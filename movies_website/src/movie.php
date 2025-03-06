<?php
include 'db.php'; // Include database connection

// **Fetch all movies**
function getMovies() {
    global $conn;
    $query = "SELECT * FROM movies ORDER BY release_date DESC";
    return mysqli_query($conn, $query);
}

// **Fetch single movie by ID**
function getMovieById($id) {
    global $conn;
    $query = "SELECT * FROM movies WHERE id = $id";
    return mysqli_fetch_assoc(mysqli_query($conn, $query));
}

// **Add new movie**
if (isset($_POST['add_movie'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $release_date = $_POST['release_date'];
    $video_url = mysqli_real_escape_string($conn, $_POST['video_url']);
    $download_url = mysqli_real_escape_string($conn, $_POST['download_url']);

    // Handle movie poster upload
    $poster = $_FILES['poster']['name'];
    move_uploaded_file($_FILES['poster']['tmp_name'], "../public/images/$poster");

    // Insert into database
    $query = "INSERT INTO movies (title, description, genre, release_date, poster, video_url, download_url)
              VALUES ('$title', '$description', '$genre', '$release_date', '$poster', '$video_url', '$download_url')";

    if (mysqli_query($conn, $query)) {
        echo "Movie added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// **Delete movie**
if (isset($_GET['delete_movie'])) {
    $id = $_GET['delete_movie'];
    mysqli_query($conn, "DELETE FROM movies WHERE id=$id");
    header("Location: ../admin/manage_movies.php");
}
?>
