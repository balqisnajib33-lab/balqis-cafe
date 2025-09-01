<?php

$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$db = "spoon";

// Create connection
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword,$db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>