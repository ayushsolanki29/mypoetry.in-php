<?php
session_start();
include "auth/config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>
    <title>Explore Frequently Asked Questions - MyPoetry.in</title>
    <meta name="title" content="Explore Frequently Asked Questions - MyPoetry.in">
    <meta name="description"
        content="Find answers to common queries about poetry creation, contests, and community engagement on MyPoetry.in. Explore our comprehensive Frequently Asked Questions section to enhance your poetic journey.">
    <meta name="keywords"
        content="FAQ, Frequently Asked Questions, MyPoetry.in, poetry creation, contests, community engagement, poetry platform, poetic journey">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/faq.php">
    <meta property="og:title" content="Explore Frequently Asked Questions - MyPoetry.in">
    <meta property="og:description"
        content="Find answers to common queries about poetry creation, contests, and community engagement on MyPoetry.in. Explore our comprehensive Frequently Asked Questions section to enhance your poetic journey.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/faq.php">
    <meta property="twitter:title" content="Explore Frequently Asked Questions - MyPoetry.in">
    <meta property="twitter:description"
        content="Find answers to common queries about poetry creation, contests, and community engagement on MyPoetry.in. Explore our comprehensive Frequently Asked Questions section to enhance your poetic journey.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/faq.php">

    <?php include 'pages/links.html'; ?>
    <style>
        .header {
            text-align: center;
            padding: 1em 0;
        }

        .content {
            margin-top: 20px;
        }

        ul {
            list-style: disc;
            margin-left: 20px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid #dee2e6;
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
    <div class="container mt-5">
        <h1 class="mb-4">Frequently Asked Questions</h1>

        <h3>What is MyPoetry.in?</h3>
        <p>MyPoetry.in is a poetry buying website where you can create poetry for your needs. Additionally, you can
            participate in our tournament program.</p>

        <h3>How can I join the tournament?</h3>
        <p>To join the tournament, you can click on the cards available on our home page or find a link in the footer.
            Alternatively, you can <a href="tournament.php">click here</a> to join.</p>

        <h3>How do I sign up?</h3>
        <p>Signing up is easy! Just click on the "Login" button on the top right corner of our website and follow the
            simple registration process.</p>

        <h3>Are there any hidden fees?</h3>
        <p>No, there are no hidden fees. We believe in transparent pricing, and all costs associated with our services
            are clearly communicated to our users.</p>
    </div>
    </div>

    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
</body>

</html>