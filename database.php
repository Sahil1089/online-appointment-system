<?php
$host = "localhost";
$dbname = "hospital_db";
$username = "root";
$password = "";
$conn =mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    header("Location: error.php");
    die();
}



?>