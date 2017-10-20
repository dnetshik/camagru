<?php
include('config.php');
if (isset($_POST['submit']))
{

	$username = mysqli_real_escape_string($conn, $_POST['user_name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$passwd = mysqli_real_escape_string($conn, $_POST['passwd']);

	//Error handling
	//Empty fields
	if (empty($username) || empty($email) || empty('passwd'))
	{
		header("Location: ../index.php?signup=empty");
		exit();
	}
	else if (!preg_match("/^[a-zA-Z]*$/", $username)) //Checking if the username is characters only
	{
		header("Location: ../index.php?signup=invalid");
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		header("Location: ../index.php?signup=email");
		exit();
	}
	else
	{
		//checking if the username exists
		$sql = "SELECT * FROM users WHERE user_name = '$username' OR email = '$email'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		$row = mysqli_fetch_assoc($result);
		if ($resultCheck > 0)
		{
			if ($row['user_name'] === $username)
			{
				header("Location: ../index.php?signup=u_name");
				exit();
			}
			else if ($row['email'] === $email)
			{
				header("Location: ../index.php?signup=email");
				exit();
			}
		}
		else
		{
			//randomising the com_code for user verification
			$com_code = hash('whirlpool', rand(0, 10000));
			$url_salt = hash('whirlpool', rand(0, 100000));
			//hashing the password
			$hashedPw = password_hash($passwd, PASSWORD_DEFAULT);
			//Insert the user into the database
			$sql = "INSERT INTO users (user_name, email, passwd, com_code) VALUES ('$username', '$email', '$hashedPw', '$com_code');";
			mysqli_query($conn, $sql);

			//sending the mail
			$to = $email;
			$subject = "Email Verification.";
			$msg = "Thank you for your registration.";
			$to = $email;
			$headers .="MIME-Version: 1.0"."\r\n";
			$headers .='Content-type: text/html; charset=iso-8859-1'."\r\n";
			$headers .='From: noreply@example.com'."\r\n";

			$ms.="<html></body><div><div>Dear $username,</div></br></br>";
			$ms.="<div style='padding-top:8px;'>Your account information is successfully updated in our server, Please click the following link to activate your account.</div>
			<div style='padding-top:10px;'><a href='http://localhost:8080/aff/email_verification.php?verify=1&code=$com_code&name=$username&com=$url_salt'>Click Here</a></div>
			</body></html>";
			mail($to, $subject, $ms, $headers);
			header("Location: ../index.php?verify=0");
			exit();
		}
	}
}
else
{
	header("Location: ../index.php");
}
?>
