<?php

if (isset($_POST["submit"])) {
	$username = $_POST["uid"];
	$pwd1 = $_POST["pwd"];
	
	require_once "db.php";
	require_once "func.inc.php";
	
	if (emptyInputLogin($username, $pwd1) !== false) {
		header ("location:LOG.php?error=emptyinput");
		exit();
	}
	
	loginUser($conn, $username, $pwd1);
	}
	else {
		header ("location:LOG.php");
		exit();
	}
?>
	