<?php

function validateEmptyFields($fields) {
    foreach ($fields as $field) {
        if (empty(trim($field))) {
            return false;
        }
    }
    return true;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function validateUsername($username) {
    $username = trim($username);
    return !empty($username); 
}
function validatePassword($password, $confirmPassword) {
    return !empty($password) && $password === $confirmPassword && strlen($password) >= 6; 
}
function validateImageExtension($filename, $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($extension, $allowedExtensions);
}

?>