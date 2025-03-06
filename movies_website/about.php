<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Movie Streaming</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMq9K2remW5nYQVX6jQgfSGL0+GzjX5Y3Fl35o" crossorigin="anonymous">
    <style>
        .about-section {
            text-align: center;
            padding: 20px;
        }

        .admin-poster {
            width: 200px; /* Adjust size as needed */
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .social-links a {
            display: inline-block;
            background-color: #333;
            color: white;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            text-decoration: none;
        }

        .social-links a:hover {
            background-color: #555;
        }

        .social-links i {
            margin-right: 5px; /* Add space between icon and text */
        }
    </style>
</head>
<body>
    <header>
        <h1>🎬 About Us</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="about.php" class="active">About</a>
        </nav>
    </header>

    <section class="about-section">
        <img src="public/images/adminposter.jpg" alt="Admin Poster" class="admin-poster">
        <h2>Welcome to Our Chitram Movies! 🍿</h2>
        <p>
            We provide the latest movies and a seamless streaming experience. Enjoy a huge collection of movies across different genres.
        </p>
        
        <h3>👨‍💻 Admin Details</h3>
        <ul>
            <li><strong>Name:</strong> sivareddy</li>
            <li><strong>Email:</strong> tirumalaredyvenkat5@gmail.com</li>
            <li><strong>Role:</strong> Founder & Developer</li>
        </ul>

        <h3>📲 Follow Us on Social Media</h3>
        <div class="social-links">
            <a href="https://www.facebook.com/profile.php?id=100035430683881" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
            <a href="https://t.me/hdmoviestelugus" target="_blank"><i class="fab fa-telegram-plane"></i> Telegram</a>
            <a href="https://www.instagram.com/mr_siva__02/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="https://youtube.com/@venkatasivareddytirumalareddy?si=H1lJ5eHvas4_rycN" target="_blank"><i class="fab fa-youtube"></i> YouTube</a>
        </div>
    </section>
</body>
</html>