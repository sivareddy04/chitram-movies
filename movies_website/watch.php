<?php
include 'src/db.php';
$id = $_GET['id'];
$movie = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM movies WHERE id=$id"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $movie['title']; ?> - Watch</title>
</head>
<body>
    <h1><?php echo $movie['title']; ?></h1>
    <video width="800" controls>
        <source src="<?php echo $movie['video_url']; ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <br>
    <a href="<?php echo $movie['download_url']; ?>" download>Download Movie</a>
</body>
</html>
