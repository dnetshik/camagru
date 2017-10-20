<?php
require_once ('db.php');
//Creating mysqli table...
function db_pamahil()
{
	$sql = "CREATE TABLE users
		(
			id int(11) not null AUTO_INCREMENT PRIMARY KEY,
			user_name varchar(255) not null,
			email varchar(255) not null,
			status int(1) not null DEFAULT 0,
			com_code varchar(255) not null
		)";
	if (mysqli_query($conn, $sql))
	{
		header("Location: ../index.php?con=success");
	}
	else
	{
		header("Location: ../index.php?network=error");
	}
}
mysqli_close($conn);
?>
