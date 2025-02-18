<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $roomId = $_POST['room_id'];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $file_name = uniqid() . "_" . basename($_FILES['profile_picture']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $result = update('customer', ['name', 'email', 'profile_picture', 'room_id'], [$name, $email, $target_file, $roomId], 'id = ?', [$id]);
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    } else {
        $result = update('customer', ['name', 'email', 'room_id'], [$name, $email, $roomId], 'id = ?', [$id]);
    }

    if ($result) {
        header("Location: listcustomer.php");
        exit();
    } else {
        die("Failed to update customer.");
    }
}
?>