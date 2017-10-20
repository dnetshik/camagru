<?php
session_start();

if (isset($_POST['submit']))
{
    include_once('config.php');

    $login = mysqli_real_escape_string($conn, $_POST['user_name']);
    $passwd = mysqli_real_escape_string($conn, $_POST['passwd']);
    if (empty($login) || empty($passwd))
    {
        header("Location: ../login.php?login=empty");
        exit();
    }
    else
    {
        $sql = "SELECT * FROM users WHERE user_name = '$login' OR email = '$login'"; //Checking if the email or username exists in the database
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1)
        {
            //if the details entered do not match any user from the database 
            header("Location: ../login.php?login=invalid");
            exit();
        }
        else
        {
            if ($row = mysqli_fetch_assoc($result))
            {
                if (isset($row['user_name']) || isset($row['email']))
                {
                    if ($row['user_name'] === $login || $row['email'] === $login)
                    {
                        if ($row['status'] == 0)
                        {
                            header("Location: ../login.php?verify=0");
                            exit();
                        }
                        else if ($row['status'] == 1 && password_verify($passwd, $row['passwd']))
                        {
                            $_SESSION['username'] = $row['user_name'];
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['passwd'] = $row['passwd'];
                            header("Location: ../login.php?verify=1");
                        }
                    }
                }
            }
        }
    }
}
?>
