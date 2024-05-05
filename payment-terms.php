<?php
session_start();
include "auth/config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>
    <title>Payment Terms | MyPoetry.in</title>
    <meta name="title" content="Payment Terms | MyPoetry.in">
    <meta name="description"
        content="Understand the payment terms on MyPoetry.in. Learn about payment methods, subscription details, and any relevant policies.">
    <meta name="keywords" content="Payment Terms, MyPoetry.in, Payment Methods, Subscription, Policies">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/payment-terms.php">
    <meta property="og:title" content="Payment Terms | MyPoetry.in">
    <meta property="og:description"
        content="Understand the payment terms on MyPoetry.in. Learn about payment methods, subscription details, and any relevant policies.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/payment-terms.php">
    <meta property="twitter:title" content="Payment Terms | MyPoetry.in">
    <meta property="twitter:description"
        content="Understand the payment terms on MyPoetry.in. Learn about payment methods, subscription details, and any relevant policies.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/payment-terms.php">

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
            <h1>Payment Terms and conditions </h1>
        </header>

        <div class="container mt-5">
            <p>Thank you for choosing MyPoetry.in for your poetic needs. Below are our payment policies and terms:</p>

            <h3>Payment Process:</h3>
            <p>When you make a payment on our website, our system will initiate a payment check. This process typically
                takes 2 to 3 hours. During this time, your payment status will be marked as "Pending".</p>

            <h3>Order Cancellation:</h3>
            <p>If your delivery is canceled due to any unforeseen circumstances, your payment will be refunded in full.
            </p>

            <h3>Refund Policy:</h3>
            <p>If your order is not delivered within 3 days, your payment will be automatically refunded.</p>

            <h2>Contact Us</h2>
            <p>If you have any questions about our Payment Terms and conditions or the practices of this site, please
                contact us at <a href="mailto:admin@mypoetry.in">admin@mypoetry.in </a> or <a href="contact-us.php">contact
                    us</a>.</p>
        </div>
    </div>

    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
</body>

</html>