<?php

if (isset($_GET['login']) && $_GET['login'] == "invalid")
{
    echo "<script>alert('Invalid username/password entered');</script>";
}
else if (isset($_GET['verify']) && $_GET['verify'] === 0)
{
    echo ("<script>alert('You need to verify your account before loggin');</script>");
}
//You need to check if verify == 1 so that you can log in the user
?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="pen-title">
    <h1>*********</h1>
</div>

<div class="module form-module">
    <div class="toggle"><i class="fa fa-times fa-pencil"></i>
</div>
<div class="form">
    <h2>Login to your account</h2>
    <form action="includes/login.inc.php" method="POST">
        <input type="text" name="user_name" placeholder="Username / email"/>
        <input type="password" name="passwd" placeholder="Password"/>
        <button type="submit" name="submit">Login</button>
        <button formaction="index.php">Register</button>
    </form>
</div>
</div>
</body>
</html>
