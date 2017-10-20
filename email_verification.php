<?php
include_once ('includes/config.php');
if (isset($_GET['verify']) && $_GET['verify'] == 1 && isset($_GET['name']) && isset($_GET['code']) && isset($_GET['com']))
{
	$name = $_GET['name'];
	$code = $_GET['code'];
	$sql = "SELECT * FROM users WHERE user_name = '$name'";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	$row = mysqli_fetch_assoc($result);
	$id = $row['id'];

	if ($resultCheck > 0)
	{
		if ($row['com_code'] === $code)
		{
			$sql = "UPDATE users SET status = 1 WHERE user_name = '$name'";

			if (mysqli_query($conn, $sql))
			{
				$new_code = hash('whirlpool', rand(0, 100000));
				$sql ="UPDATE users SET com_code = '$new_code' WHERE user_name = '$name'";
				if (mysqli_query($conn, $sql))
				{
					echo ("<script>alert('Your account has been verified')</script>");
				}
			}
			else
			{
				echo ("<script>alert('Unable to verify account: Check the network or retry again')</script>");
			}
		}
		else
		{
			if ($row['status'] == 1)
			{
				echo ("<script>alert('Error: code is nolonger valid')</script>");
			}
			else
			{
				$sql = "DELETE FROM users WHERE user_name = '$name'";
				mysqli_query($conn, $sql);
				echo ("<script>alert('The confirmation code is incorrect. Server_error:556')</script>");
			}
		}
	}
	else
	{
		echo ("<script>alert('User not found. PLease register first')</script>");
	}
}
else
{
	echo ("<script>alert('Confirmation code is not recognized.')</script>");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Email verification</title>
		<link href="css/styles.css" rel="stylesheet">
	</head>
	<body>

<div class="container-fluid">

  <!--center-->
  <div class="col-sm-6">
	<div class="row">
	  <div class="col-xs-12">
		<h3 style="color:green">SUCCESS!!</h3>
		<hr >
	<p><?php echo htmlentities($msg); ?></p>
   <p> Now you can login</p>
   <p>For login <a href="login.php">Click Here</a></p>
	  </div>
	</div>
	<hr>


  </div>

  <hr>
</div>
	</body>
</html>
