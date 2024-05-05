<?php
session_start();
include "auth/config.php";
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'pages/meta.html' ?>
    <title>Privacy Policy - MyPoetry.in</title>
    <meta name="title" content="Privacy Policy - MyPoetry.in">
<meta name="description" content="Read and understand the privacy policy of MyPoetry.in. Learn how we collect, use, and protect your personal information. Your privacy is important to us, and this policy outlines our commitment to safeguarding your data.">
<meta name="keywords" content="Privacy Policy, MyPoetry.in, data protection, user privacy, online privacy, personal information, privacy commitment">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://mypoetry.in/privacy-policy.php">
<meta property="og:title" content="Privacy Policy - MyPoetry.in">
<meta property="og:description" content="Read and understand the privacy policy of MyPoetry.in. Learn how we collect, use, and protect your personal information. Your privacy is important to us, and this policy outlines our commitment to safeguarding your data.">
<meta property="og:image" content="https://mypoetry.in/source/og-image.png">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://mypoetry.in/privacy-policy.php">
<meta property="twitter:title" content="Privacy Policy - MyPoetry.in">
<meta property="twitter:description" content="Read and understand the privacy policy of MyPoetry.in. Learn how we collect, use, and protect your personal information. Your privacy is important to us, and this policy outlines our commitment to safeguarding your data.">
<meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

<link rel="canonical" href="https://mypoetry.in/privacy-policy.php">

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
            <h1>Privacy Policy</h1>
        </header>
        
        <div class="content">
        <p>Issued Date: October 10, 2023</p>
            <p>At MyPoetry.in, we respect your privacy and are committed to protecting your personal information. This Privacy Policy outlines the types of personal information we collect, how it is used, and the steps we take to safeguard your data.</p>

            <h2>Information We Collect</h2>
            <p>We collect the following types of information to provide personalized poetry services and enhance your user experience:</p>
            <ul>
                <li><strong>Email Addresses:</strong> We collect email addresses to send you product updates, delivery notifications, and occasional promotional offers. You can opt-out of promotional emails at any time.</li>
                <li><strong>Images:</strong> We may collect images provided by users to create personalized poetry. These images are used solely for this purpose and are not shared with third parties.</li>
                <li><strong>Device Information:</strong> We may collect information about the device you are using to access our website, including IP address, browser type, and operating system, for analytical purposes.</li>
            </ul>

            <h2>How We Use Your Information</h2>
            <p>We use the collected information to:</p>
            <ul>
                <li>Provide personalized poetry services based on the images you provide.</li>
                <li>Send important product updates and delivery notifications.</li>
                <li>Improve our website and services by analyzing user behavior and preferences.</li>
            </ul>

            <h2>Security Measures</h2>
            <p>We take the security of your personal information seriously. We employ industry-standard security measures to protect your data from unauthorized access, alteration, disclosure, or destruction.</p>

            <h2>Third-Party Disclosure</h2>
            <p>We do not sell, trade, or otherwise transfer your personal information to outside parties. This does not include trusted third parties who assist us in operating our website or servicing you, as long as those parties agree to keep this information confidential.</p>

            <h2>Changes to This Privacy Policy</h2>
            <p>We may update our Privacy Policy from time to time. Any changes will be reflected on this page, and the updated policy will be effective immediately upon posting.</p>

            <h2>Contact Us</h2>
            <p>If you have any questions about our Privacy Policy or the practices of this site, please contact us at <a href="mailto:admin@mypoetry.in">admin@mypoetry.in </a> or  <a href="contact-us.php">contact us</a>.</p>
        </div>
    </div>

    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
</body>

</html>