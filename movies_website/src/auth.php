<?php
include 'db.php';

// ✅ Register User
function registerUser($email, $password) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')";
    return mysqli_query($conn, $query);
}

// ✅ Login User
function loginUser($email, $password) {
    global $conn;
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

// ✅ Logout
function logoutUser() {
    session_start();
    session_destroy();
    header("Location: ../index.php");
}
?>
