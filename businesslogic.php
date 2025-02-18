<?php
require_once 'config.php';

function insertCustomer($name, $email, $password, $profilePicture = null, $roomId = null) {
    global $pdo;
    $sql = "INSERT INTO customer (name, email, password, profile_picture, room_id) VALUES (:name, :email, :password, :profile_picture, :room_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT), 
        ':profile_picture' => $profilePicture,
        ':room_id' => $roomId
    ]);
    return $pdo->lastInsertId(); 
}

function getAllRooms() {
    global $pdo;
    $sql = "SELECT * FROM room";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

function getAllCustomers() {
    global $pdo;
    $sql = "SELECT * FROM customer";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

function updateCustomer($id, $name, $email, $password = null, $profilePicture = null, $roomId = null) {
    global $pdo;
    $sql = "UPDATE customer SET name = :name, email = :email, profile_picture = :profile_picture, room_id = :room_id";
    if ($password) {
        $sql .= ", password = :password";
    }
    $sql .= " WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $params = [
        ':id' => $id,
        ':name' => $name,
        ':email' => $email,
        ':profile_picture' => $profilePicture,
        ':room_id' => $roomId
    ];
    if ($password) {
        $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
    }
    $stmt->execute($params);
    return $stmt->rowCount(); 
}
function deleteCustomer($id) {
    global $pdo;
    $sql = "DELETE FROM customer WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->rowCount(); 
}


?>