<?php
session_start();
include '../src/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all users
$result = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");

// Delete user logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
    header("Location: manage_users.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Manage Users</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php while ($user = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['created_at']; ?></td>
                <td><a href="manage_users.php?delete=<?php echo $user['id']; ?>">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>
