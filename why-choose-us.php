<?php
session_start();
include "auth/config.php";
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'pages/meta.html' ?>
    <title>Why Choose Us | MyPoetry.in</title>
    <meta name="title" content="Why Choose Us | MyPoetry.in">
<meta name="description" content="Discover the reasons to choose MyPoetry.in for your poetic journey. Explore unique features, a supportive community, and exciting opportunities to showcase your verses.">
<meta name="keywords" content="Why Choose Us, MyPoetry.in, Poetry Platform, Unique Features, Supportive Community, Poetry Opportunities, Showcase Verses">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://mypoetry.in/why-choose-us.php">
<meta property="og:title" content="Why Choose Us | MyPoetry.in">
<meta property="og:description" content="Discover the reasons to choose MyPoetry.in for your poetic journey. Explore unique features, a supportive community, and exciting opportunities to showcase your verses.">
<meta property="og:image" content="https://mypoetry.in/source/og-image.png">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://mypoetry.in/why-choose-us.php">
<meta property="twitter:title" content="Why Choose Us | MyPoetry.in">
<meta property="twitter:description" content="Discover the reasons to choose MyPoetry.in for your poetic journey. Explore unique features, a supportive community, and exciting opportunities to showcase your verses.">
<meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

<link rel="canonical" href="https://mypoetry.in/why-choose-us.php">

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
        <h1 class="mb-4">Why Choose Us</h1>

        <div class="row">
            <div class="col-md-4">
                <h3>1. Creative Poetry Services</h3>
                <p>At MyPoetry.in, we offer creative and personalized poetry services tailored to your unique needs. Our talented poets craft beautiful and meaningful poems just for you.</p>
            </div>
            <div class="col-md-4">
                <h3>2. Participate in Tournaments</h3>
                <p>Engage with our vibrant poetry community by participating in our exciting poetry tournaments. Showcase your talent, connect with fellow poets, and win amazing prizes.</p>
            </div>
            <div class="col-md-4">
                <h3>3. Easy and Secure Payments</h3>
                <p>We provide a hassle-free payment experience. Our secure payment gateway ensures the safety of your transactions, allowing you to enjoy our services with peace of mind.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <h3>4. Timely Delivery</h3>
                <p>We value your time. Expect prompt and timely delivery of your poetry requests. Our team works diligently to ensure you receive your personalized poetry within the specified timeframe.</p>
            </div>
            <div class="col-md-4">
                <h3>5. Expert Poets</h3>
                <p>Our team comprises skilled and experienced poets who are passionate about their craft. Rest assured, your poetry requests are in the hands of experts who understand the art of poetic expression.</p>
            </div>
            <div class="col-md-4">
                <h3>6. Customer Satisfaction</h3>
                <p>Customer satisfaction is our priority. We strive to exceed your expectations with our poetry services. Your feedback is valuable, and we continuously work to enhance your experience.</p>
            </div>
        </div>
    </div>

    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
</body>

</html>