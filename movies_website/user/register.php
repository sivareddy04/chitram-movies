<?php
include '../src/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (registerUser($email, $password)) {
        echo "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        echo "Error registering user.";
    }
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="password" name="password" placeholder="Enter Password" required>
    <button type="submit">Register</button>
</form>
<a href="login.php">Already have an account? Login here</a>
