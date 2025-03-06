<?php
session_start();
include '../src/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['upload'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $drive_link = mysqli_real_escape_string($conn, $_POST['drive_link']); // Google Drive link
    $rating = floatval($_POST['rating']); // Convert rating to number
    $poster = "";

    // Validate rating
    if ($rating < 0 || $rating > 10) {
        die("Error: Rating must be between 0 and 10.");
    }

    // Validate Drive link
    if (!filter_var($drive_link, FILTER_VALIDATE_URL) || !strpos($drive_link, "drive.google.com")) {
        die("Error: Invalid Google Drive link!");
    }

    // ✅ Handle Poster Image Upload
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
        $upload_dir = "../public/images/"; // Save in 'public/images/' directory
        $file_name = basename($_FILES['poster']['name']);
        $target_file = $upload_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
            $poster = "public/images/" . $file_name; // Store relative path
        } else {
            die("Error uploading the image.");
        }
    } else {
        die("Error: No poster image uploaded.");
    }

    // Insert into database
    $query = "INSERT INTO movies (title, poster, drive_link, rating) VALUES ('$title', '$poster', '$drive_link', '$rating')";
    
    if (mysqli_query($conn, $query)) {
        echo "Movie added successfully!";
    } else {
        echo "Database error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie - Admin</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        /* =============== Add Movie Page =============== */
body {
    font-family: Arial, sans-serif;
    background-color: #121212;
    color: white;
    text-align: center;
}

header {
    background-color: #ff5733;
    padding: 15px;
    text-align: center;
    font-size: 22px;
}

nav a {
    color: white;
    margin: 0 15px;
    text-decoration: none;
    font-size: 18px;
}

nav a:hover {
    text-decoration: underline;
}

/* Form Container */
.form-container {
    max-width: 500px;
    margin: 30px auto;
    padding: 20px;
    background: #1e1e1e;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(255, 87, 51, 0.8);
}

/* Form Labels */
form label {
    display: block;
    text-align: left;
    font-size: 18px;
    margin-top: 10px;
    font-weight: bold;
}

/* Form Inputs */
form input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    background: #2a2a2a;
    color: white;
}

form input:focus {
    outline: 2px solid #ff5733;
}

/* Submit Button */
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

/* Success & Error Messages */
.success-msg {
    color: green;
    font-size: 18px;
    font-weight: bold;
    margin-top: 15px;
}

.error-msg {
    color: red;
    font-size: 18px;
    font-weight: bold;
    margin-top: 15px;
}

    </style>
</head>
<body>

<h1>🎬 Add a New Movie</h1>

<form action="add_movie.php" method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Enter movie title" required><br>
    <input type="file" name="poster" accept="image/*" required><br>
    <input type="url" name="drive_link" placeholder="Enter Google Drive movie link" required><br>
    <input type="number" name="rating" placeholder="Enter rating (0-10)" step="0.1" min="0" max="10" required><br>
    <button type="submit" name="upload">Add Movie</button>
</form>

<a href="index.php">Back to Dashboard</a>

</body>
</html>
