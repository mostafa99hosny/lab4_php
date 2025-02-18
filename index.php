<?php
session_start();
require_once 'config.php';

$username = "mostafa";
$password = "123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_username = $_POST['username'];
    $form_password = $_POST['password'];
    if ($form_username === $username && $form_password === $password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: addcustomer.php");
        exit();
    } else {
        echo "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2 style="text-align: center;margin: 15px;">Cafeteria</h2>
    <form action="index.php" method="post" style="text-align: center;margin: 15px;">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>