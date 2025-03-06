<?php
session_start();
include '../src/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch movie details if an ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM movies WHERE id = $id");

    if (mysqli_num_rows($result) == 0) {
        die("Movie not found.");
    }

    $movie = mysqli_fetch_assoc($result);
} else {
    die("No movie ID provided.");
}

// Handle form submission for updating movie details
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $drive_link = mysqli_real_escape_string($conn, $_POST['drive_link']);
    $rating = isset($_POST['rating']) ? floatval($_POST['rating']) : 0;
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $cast = mysqli_real_escape_string($conn, $_POST['cast']);
    $categories = isset($_POST['categories']) ? implode(", ", $_POST['categories']) : '';

    // Optional: Handle poster image upload
    $poster = $movie['poster']; // Default to existing poster
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
        $upload_dir = "../public/images/";
        $file_name = basename($_FILES['poster']['name']);
        $target_file = $upload_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            // Move uploaded file
            if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
                $poster = "public/images/" . $file_name; // Use new poster
            }
        } else {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }
    }

    // Update movie in database
    $query = "UPDATE movies SET title='$title', poster='$poster', drive_link='$drive_link', 
              rating='$rating', director='$director', cast='$cast', categories='$categories' 
              WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        header("Location: manage_movies.php");
        exit();
    } else {
        echo "Error updating movie: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie - Admin</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: blue;
            text-align: center;
        }
        header {
            background-color:rgb(238, 241, 241);
            padding: 15px;
            text-align: center;
            font-size: 22px;
        }
        .form-container {
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            background:rgb(43, 37, 37);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(238, 226, 224, 0.8);
        }
        form label {
            display: block;
            text-align: left;
            font-size: 18px;
            margin-top: 10px;
            font-weight: bold;
        }
        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background: #2a2a2a;
            color: white;
        }
        button {
            width: 100%;
            background-color: #ff5733;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 15px;
            transition: 0.3s;
        }
        button:hover {
            background-color: #e64a19;
        }
    </style>
</head>
<body>

<header>
    <h1>✏️ Edit Movie</h1>
</header>

<div class="form-container">
<form action="edit.php?id=<?php echo $movie['id']; ?>" method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Enter movie title" value="<?php echo htmlspecialchars($movie['title']); ?>" required><br>
    <input type="file" name="poster" accept="image/*"><br> <!-- Optional to upload new poster -->
    <input type="url" name="drive_link" placeholder="Enter Google Drive movie link" value="<?php echo htmlspecialchars($movie['drive_link']); ?>" required><br>
    <input type="number" name="rating" placeholder="Enter rating (0-10)" value="<?php echo htmlspecialchars($movie['rating']); ?>" step="0.1" min="0" max="10" required><br>
    <input type="text" name="director" placeholder="Enter director's name" value="<?php echo htmlspecialchars($movie['director']); ?>" required><br>
    <input type="text" name="cast" placeholder="Enter cast (comma-separated)" value="<?php echo htmlspecialchars($movie['cast']); ?>" required><br>
    
    <strong>Select Categories:</strong><br>
    <?php
    $categoriesArray = explode(", ", $movie['categories']);
    $availableCategories = ['Comedy', 'Action', 'Thriller', 'Horror', 'Romance'];
    foreach ($availableCategories as $availableCategory) {
        echo '<label><input type="checkbox" name="categories[]" value="' . $availableCategory . '" ' . (in_array($availableCategory, $categoriesArray) ? 'checked' : '') . '> ' . $availableCategory . '</label><br>';
    }
    ?>

    <button type="submit" name="update">Update Movie</button>
</form>
</div>

<a href="manage_movies.php" style="text-decoration: none; color: white;">Back to Movie List</a>

</body>
</html>