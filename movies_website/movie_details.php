<?php
include 'src/db.php';

// Get movie ID from URL
$movie_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = "SELECT * FROM movies WHERE id = $movie_id";
$result = mysqli_query($conn, $query);
$movie = mysqli_fetch_assoc($result);

if (!$movie) {
    die("Movie not found.");
}

// Extract Google Drive ID
$driveId = "";
if (preg_match('/\/d\/(.*?)\//', $movie['drive_link'], $matches)) {
    $driveId = $matches[1];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($movie['title'] ?? 'Movie Details'); ?> - Movie Details</title>
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        /* Movie Details Page */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        /* Main Container */
        .movie-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 900px;
            width: 100%;
            gap: 20px;
            align-items: flex-start;
            justify-content: center;
        }

        /* Left Side - Poster */
        .movie-poster {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 87, 51, 0.8);
        }

        /* Right Side - Movie Details */
        .movie-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Title */
        .movie-details h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        /* Rating */
        .movie-details p {
            font-size: 18px;
            color: #ffca28;
        }

        /* Director, Cast, and Categories */
        .movie-details-section {
            font-size: 16px;
            margin: 5px 0;
        }

        /* Video Player Wrapper */
        .video-wrapper {
            width: 100%;
            max-width: 900px;
            margin-top: 20px;
            text-align: center;
            position: relative;
        }

        /* Responsive Video */
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            max-width: 100%;
            background: black;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Buttons Wrapper */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
        }

        /* Fullscreen & Download Buttons */
        .fullscreen-btn, .download-btn {
            padding: 10px 15px;
            font-size: 16px;
            background: #ff5733;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .fullscreen-btn:hover, .download-btn:hover {
            background: #e64a19;
        }
    </style>
</head>
<body>
    <header>
        <h1><?= htmlspecialchars($movie['title'] ?? 'Movie Details'); ?></h1>
        <nav>
            <a href="index.php">Home</a>
        </nav>
    </header>

    <div class="movie-container">
        <!-- Left Side - Poster -->
        <img src="<?= htmlspecialchars($movie['poster'] ?? 'placeholder.jpg'); ?>" alt="Movie Poster of <?= htmlspecialchars($movie['title'] ?? ''); ?>" class="movie-poster">
        
        <!-- Right Side - Movie Details -->
        <div class="movie-details">
            <h2><?= htmlspecialchars($movie['title']); ?></h2>
            <p>⭐ Rating: <?= htmlspecialchars($movie['rating']); ?>/10</p>
            <div class="movie-details-section"><strong>Director:</strong> <?= htmlspecialchars($movie['director']); ?></div>
            <div class="movie-details-section"><strong>Cast:</strong> <?= htmlspecialchars($movie['cast']); ?></div>
            <div class="movie-details-section"><strong>Categories:</strong> <?= htmlspecialchars($movie['categories']); ?></div>
        </div>
    </div>

    <!-- Movie Video Player -->
    <div class="video-wrapper">
        <?php if (!empty($driveId)): ?>
            <div class="video-container">
                <iframe id="moviePlayer" src="https://drive.google.com/file/d/<?= htmlspecialchars($driveId); ?>/preview" allowfullscreen></iframe>
            </div>
            <div class="button-container">
                <button class="fullscreen-btn" onclick="toggleFullScreen()">🔲 Fullscreen</button>
                <a href="https://drive.google.com/uc?export=download&id=<?= htmlspecialchars($driveId); ?>" target="_blank" class="download-btn">⬇ Download</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function toggleFullScreen() {
            let iframe = document.getElementById('moviePlayer');
            if (iframe.requestFullscreen) {
                iframe.requestFullscreen();
            } else if (iframe.mozRequestFullScreen) { // Firefox
                iframe.mozRequestFullScreen();
            } else if (iframe.webkitRequestFullscreen) { // Chrome, Safari, Opera
                iframe.webkitRequestFullscreen();
            } else if (iframe.msRequestFullscreen) { // IE/Edge
                iframe.msRequestFullscreen();
            }
        }
    </script>
</body>
</html>
