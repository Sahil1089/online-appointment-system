<?php
session_start();
require_once '../database.php';

if (isset($_POST[''])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];


    $checkEmail = $conn->query("SELECT email FROM user WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['error'] = "Email already exists.";
        header("Location: register.php");
        exit();
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password , gender) VALUES ( $first_name, $last_name, $email, $password, $gender)");
}
exit();}




?>