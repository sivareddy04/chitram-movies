<?php
session_start();
include '../src/db.php';

// ✅ Check if 'users' table exists before querying
$result = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
if (mysqli_num_rows($result) == 0) {
    die("Error: The 'users' table does not exist. Please check your database.");
}

// ✅ Login Logic
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Plain text password from form

    // Fetch user details from 'users' table
    $query = "SELECT * FROM users WHERE email='$email' AND role='admin'"; // Ensure only admins can log in
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    // ✅ Verify password
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['email'];
        header("Location: index.php"); // Redirect to admin dashboard
        exit();
    } else {
        echo "<p style='color:red;'>Invalid email, password, or you are not an admin!</p>";
    }
}
?>

<!-- ✅ Admin Login Form -->
<form method="POST">
    <input type="email" name="email" placeholder="Admin Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>
