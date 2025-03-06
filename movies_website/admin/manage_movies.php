<?php
session_start();
include '../src/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Delete movie
if (isset($_GET['delete_movie'])) {
    $id = intval($_GET['delete_movie']); // Ensure the ID is treated as an integer to prevent SQL injection
    mysqli_query($conn, "DELETE FROM movies WHERE id = $id");
    header("Location: manage_movies.php");
    exit(); // Ensure no further code is executed after the redirect
}

// Fetch all movies
$movies = mysqli_query($conn, "SELECT * FROM movies");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            text-align: center;
        }
        h1 {
            margin: 20px 0;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ff5733;
            padding: 10px;
            text-align: left;
        }
        img {
            max-width: 50px;
            max-height: 70px;
        }
        a {
            color: #ff5733;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Manage Movies</h1>
<table>
    <tr>
        <th>Poster</th>
        <th>Title</th>
        <th>Director</th> <!-- Update to show the director instead of genre -->
        <th>Actions</th>
    </tr>
    <?php while ($movie = mysqli_fetch_assoc($movies)) { ?>
        <tr>
            <td><img src="<?php echo '../' . $movie['poster']; ?>" alt="Poster"></td>
            <td><?php echo htmlspecialchars($movie['title']); ?></td>
            <td><?php echo htmlspecialchars($movie['director']); ?></td> <!-- Show director name -->
            <td>
                <a href="edit_movie.php?id=<?php echo $movie['id']; ?>">Edit</a>
                <a href="?delete_movie=<?php echo $movie['id']; ?>" onclick="return confirm('Are you sure you want to delete this movie?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

<a href="add_movie.php" style="color: #ff5733;">Add New Movie</a>

</body>
</html>