<?php
$dbServer = "localhost";
$dbUserName = "root";
$dbPasswd = "uAiTFkBe";
$dbName = "db_pamashil";

$conn = mysqli_connect($dbServer, $dbUserName, $dbPasswd, $dbName);

if (!$conn)
{
	echo("Failed to connect to the database");
	header("Location: ../index.php?server=error");
	exit();
}
?>
