<?php
session_start();
include "auth/config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>
    <title>Gallary - MyPoetry.in</title>
    <meta name="title" content="Gallary - MyPoetry.in">
    <meta name="description"
        content="Read and understand the privacy policy of MyPoetry.in. Learn how we collect, use, and protect your personal information. Your privacy is important to us, and this policy outlines our commitment to safeguarding your data.">
    <meta name="keywords"
        content="Privacy Policy, MyPoetry.in, data protection, user privacy, online privacy, personal information, privacy commitment">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/gallary.php">
    <meta property="og:title" content="Gallary - MyPoetry.in">
    <meta property="og:description"
        content="Read and understand the privacy policy of MyPoetry.in. Learn how we collect, use, and protect your personal information. Your privacy is important to us, and this policy outlines our commitment to safeguarding your data.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/gallary.php">
    <meta property="twitter:title" content="Gallary - MyPoetry.in">
    <meta property="twitter:description"
        content="Read and understand the privacy policy of MyPoetry.in. Learn how we collect, use, and protect your personal information. Your privacy is important to us, and this policy outlines our commitment to safeguarding your data.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/gallary.php">


    <?php include 'pages/links.html'; ?>
    <link rel="stylesheet" href="styles/pricing.css">
    <style>
        .photo-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 10px;
            padding: 20px;
        }

        .photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
            overflow: hidden;
            cursor: pointer;
        }

        .vertical-photo {
            aspect-ratio: 3/4;
            /* Adjust the aspect ratio as needed */
        }

        .horizontal-photo {
            aspect-ratio: 3/4;
            /* Adjust the aspect ratio as needed */
        }  
         .lightbox-container {
            z-index:1000 ;
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(8px);
        }

        .lightbox-image {
            max-width: 90%;
            max-height: 90%;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: #fff;
            font-size: 20px;
        }
    </style>
</head>

<body class="sub_page">
    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="navabr">
        </div>
        <?php include 'pages/navbar.html' ?>
    </div>
    <div class="container">
        <section class="landing-page-section">
            <h2>Photo Gallery <span class="gradient-text">My Community Moments</span></h2>
            <p>Explore a collection of captivating moments, featuring both my poetry and the faces of our wonderful
                community members.</p>
        </section>

        <div class="photo-gallery" id="gallery">
            <img src="source/gallary/1.jpeg" alt="Photo" class="photo vertical-photo"
                onclick="openPopup('source/gallary/1.jpeg', 'Photo 1')">
            <img src="source/gallary/9.jpg" alt="Photo" class="photo horizontal-photo"
                onclick="openPopup('source/gallary/9.jpg', 'Photo 9')">
            <img src="source/gallary/2.jpg" alt="Photo" class="photo vertical-photo"
                onclick="openPopup('source/gallary/2.jpg', 'Photo 2')">
            <img src="source/gallary/3.jpg" alt="Photo" class="photo vertical-photo"
                onclick="openPopup('source/gallary/3.jpg', 'Photo 3')">
            <img src="source/gallary/4.jpg" alt="Photo" class="photo vertical-photo"
                onclick="openPopup('source/gallary/4.jpg', 'Photo 4')">
            <img src="source/gallary/5.jpeg" alt="Photo" class="photo vertical-photo"
                onclick="openPopup('source/gallary/5.jpeg', 'Photo 5')">
            <img src="source/gallary/6.jpeg" alt="Photo" class="photo vertical-photo"
                onclick="openPopup('source/gallary/6.jpeg', 'Photo 6')">
            <img src="source/gallary/7.jpeg" alt="Photo" class="photo vertical-photo"
                onclick="openPopup('source/gallary/7.jpeg', 'Photo 7')">
            <img src="source/gallary/8.jpeg" alt="Photo" class="photo vertical-photo"
                onclick="openPopup('source/gallary/8.jpeg', 'Photo 8')">
            <img src="source/gallary/10.jpeg" alt="Photo" class="photo vertical-photo"
                onclick="openPopup('source/gallary/10.jpeg', 'Photo 10')">
        </div>
    </div>
    <div class="lightbox-container" id="lightboxContainer" onclick="closePopup()">
    <span class="close-button" onclick="closePopup()">&times;</span>
    <img src="" alt="Large Photo" class="lightbox-image" id="lightboxImage">
</div>


    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>

    <script>
    function openPopup(imageSrc, caption) {
        document.getElementById('lightboxImage').src = imageSrc;
        document.getElementById('lightboxContainer').style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent scrolling when the lightbox is open
    }

    function closePopup() {
        document.getElementById('lightboxContainer').style.display = 'none';
        document.body.style.overflow = 'auto'; // Allow scrolling when the lightbox is closed
    }
</script>
</body>

</html>