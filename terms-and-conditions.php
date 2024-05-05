<?php
session_start();
include "auth/config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>
    <title>Terms and Conditions - MyPoetry.in</title>
    <meta name="title" content="Terms and Conditions - MyPoetry.in">
<meta name="description" content="Read and understand the terms and conditions of using MyPoetry.in. Explore the guidelines that govern your use of the platform, ensuring a positive and respectful community experience.">
<meta name="keywords" content="Terms and Conditions, MyPoetry.in, platform guidelines, user agreement, community experience">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://mypoetry.in/terms-and-conditions.php">
<meta property="og:title" content="Terms and Conditions - MyPoetry.in">
<meta property="og:description" content="Read and understand the terms and conditions of using MyPoetry.in. Explore the guidelines that govern your use of the platform, ensuring a positive and respectful community experience.">
<meta property="og:image" content="https://mypoetry.in/source/og-image.png">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://mypoetry.in/terms-and-conditions.php">
<meta property="twitter:title" content="Terms and Conditions - MyPoetry.in">
<meta property="twitter:description" content="Read and understand the terms and conditions of using MyPoetry.in. Explore the guidelines that govern your use of the platform, ensuring a positive and respectful community experience.">
<meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

<link rel="canonical" href="https://mypoetry.in/terms-and-conditions.php">

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
    <div class="container">
        <header class="header">
            <h1>Terms and Conditions</h1>
        </header>

        <div class="content">
            <p>Issued Date: October 10, 2023</p>

            <h2>1. Acceptance of Terms</h2>
            <p>By accessing or using MyPoetry.in in any manner, you agree to be bound by these Terms and Conditions. If
                you do not accept all of these terms, then you may not use our services.</p>

            <h2>2. User Account</h2>
            <p>When you create an account with us, you must provide accurate and complete information. You are solely
                responsible for the activity that occurs on your account, and you must keep your account password
                secure.</p>

            <h2>3. User Content</h2>
            <p>You retain ownership of the poetry and content you submit to MyPoetry.in. By posting content, you grant
                us a worldwide, non-exclusive, royalty-free license to use, reproduce, modify, and publish your content.
            </p>

            <h2>4. Prohibited Conduct</h2>
            <p>You agree not to engage in any activity that may interfere with or disrupt our services, including but
                not limited to hacking, scraping, or transmitting viruses. You also agree not to access or attempt to
                access non-public areas of the services.</p>

            <h2>5. Privacy Policy</h2>
            <p>Your use of MyPoetry.in is also governed by our <a href="privacy.php">Privacy Policy</a>, which
                outlines how we collect, use, and share your information.</p>

            <h2>6. Termination</h2>
            <p>We reserve the right to suspend or terminate your account and access to our services at our sole
                discretion, without prior notice, for any conduct that we believe violates these Terms and Conditions or
                is harmful to other users of MyPoetry.in or third parties, or for any other reason.</p>
        </div>
        <div class="content">
            <h2>Delivery Policy</h2>
            <p>When you place an order with MyPoetry.in:</p>
            <ul>
                <li>Standard Delivery: Your delivery will be made within 3 to 4 business days. If you do not receive
                    your delivery within 4 days, your money will be refunded within a specified time frame.</li>
                <li>Extreme Option: By choosing the extreme option, your delivery will be made within 24 hours. The same
                    refund policy applies.</li>
            </ul>
            <h2>Image Retention</h2>
            <p>We retain the images you upload for personalized poetry for a period of 15 days. After this period, the
                images will be deleted from our servers.</p>

            <h2>Data Storage</h2>
            <p>We store your personal details securely on our servers for future reference and analysis. We adhere to
                strict privacy practices to protect your information.</p>
            <h2>Contact Us</h2>
            <p>If you have any questions about our Terms and Conditions, please contact us at <a
                    href="mailto:admin@mypoetry.in">admin@mypoetry.in </a> or <a href="contact-us.php">contact us</a>.</p>
        </div>
    </div>
    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
</body>

</html>