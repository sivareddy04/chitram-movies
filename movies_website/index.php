<?php
include 'src/db.php';

// Pagination settings
$movies_per_page = 30;  // Number of movies per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure page is at least 1
$offset = ($page - 1) * $movies_per_page;

// Handle search input
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Count total movies for pagination
$count_query = "SELECT COUNT(*) AS total FROM movies";
if ($search) {
    $count_query .= " WHERE title LIKE '%$search%'";
}
$total_result = mysqli_query($conn, $count_query);
$total_movies = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_movies / $movies_per_page);

// Fetch movies with limit
$query = "SELECT * FROM movies";
if ($search) {
    $query .= " WHERE title LIKE '%$search%'";
}
$query .= " ORDER BY id DESC LIMIT $movies_per_page OFFSET $offset";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chitram Movies Streaming</title>
    <link rel="stylesheet" href="public/css/style.css">
    <style>
   /* General Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #121212;
    color: white;
    margin: 0;
    padding: 0;
}

/* Header */
header {
    background-color: #222;
    padding: 15px;
    text-align: center;
}
header h1 {
    margin: 0;
}
nav a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
    font-size: 18px;
}
nav a:hover {
    color: #FFD700;
}

/* Search Bar */
.search-bar {
    text-align: center;
    margin: 20px 0;
}
.search-bar input {
    padding: 10px;
    width: 250px;
    font-size: 16px;
}
.search-bar button {
    padding: 10px 15px;
    font-size: 16px;
    cursor: pointer;
}

.movie-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* 2 posters per row */
    gap: 20px;
    padding: 20px;
    justify-content: center;
}


/* Movie Card */
.movie-card {
    background-color: #1c1c1c;
    padding: 10px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
    transition: transform 0.3s;
}
.movie-card:hover {
    transform: scale(1.05);
}

/* Movie Poster - Square Style (1:1 Aspect Ratio) */
.movie-card img {
    width: 100%;
    aspect-ratio: 1 / 1;  /* Ensures square shape */
    object-fit: cover; /* Crop and fit image properly */
    border-radius: 8px;
}


/* Movie Title */
.movie-card h2 {
    font-size: 16px;
    margin: 10px 0;
}
.movie-card a {
    text-decoration: none;
    color: white;
}
.movie-card a:hover {
    color: #FFD700;
}

/* Rating */
.movie-card p {
    font-size: 14px;
    color: #FFD700;
}

/* Pagination */
.pagination {
    text-align: center;
    margin: 20px 0;
}
.pagination a {
    display: inline-block;
    padding: 10px 15px;
    margin: 5px;
    background: #FFD700;
    color: black;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
}
.pagination a.active {
    background: #ffcc00;
    font-weight: bold;
}
.pagination a:hover {
    background: #ffb300;
}

/* No Results */
.no-results {
    text-align: center;
    font-size: 18px;
    color: red;
}

@media (min-width: 1024px) {
    .movie-container {
        grid-template-columns: repeat(3, 1fr); /* 3 per row on large screens */
    }
}


    </style>
</head>
<body>
    <header>
        <h1>🎬 Chitram  Movies Streaming Platform</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
        </nav>
    </header>

    <!-- Search Bar -->
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Search movies..." value="<?= htmlspecialchars($search); ?>">
        <button type="submit">🔍 Search</button>
    </form>

    <div class="movie-container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($movie = mysqli_fetch_assoc($result)): ?>
                <div class="movie-card">
                    <a href="movie_details.php?id=<?= $movie['id']; ?>">
                        <img src="<?= $movie['poster']; ?>" alt="<?= htmlspecialchars($movie['title']); ?>" class="poster">
                    </a>
                    <h2>
                        <a href="movie_details.php?id=<?= $movie['id']; ?>">
                            <?= htmlspecialchars($movie['title']); ?>
                        </a>
                    </h2>
                    <p>⭐ <?= $movie['rating']; ?>/10</p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-results">No movies found.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?search=<?= urlencode($search); ?>&page=<?= $page - 1; ?>">« Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?search=<?= urlencode($search); ?>&page=<?= $i; ?>" class="<?= $i === $page ? 'active' : ''; ?>">
                <?= $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?search=<?= urlencode($search); ?>&page=<?= $page + 1; ?>">Next »</a>
        <?php endif; ?>
    </div>
</body>
</html>
