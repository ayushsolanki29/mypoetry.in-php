<?php
session_start();
include "auth/config.php";
?>

<!DOCTYPE html>
<html>

<head>
  <?php include 'pages/meta.html' ?>
  <title>Purchase Poetry by Satyam Arya - Mypoetry.in</title>
  <meta name="title" content="Purchase Poetry by Satyam Arya - Mypoetry.in">
  <meta name="description"
    content="Explore and purchase unique and personalized poetry crafted by Satyam Arya. Elevate your emotions through exquisite verses available for purchase on Mypoetry.in.">
  <meta name="keywords"
    content="Purchase poetry, Satyam Arya, personalized verses, emotional poetry, poetic expressions, buy poetry online, unique poems, Mypoetry.in shop">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://mypoetry.in/purchase-poetry.php">
  <meta property="og:title" content="Purchase Poetry by Satyam Arya - Mypoetry.in">
  <meta property="og:description"
    content="Explore and purchase unique and personalized poetry crafted by Satyam Arya. Elevate your emotions through exquisite verses available for purchase on Mypoetry.in.">
  <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="https://mypoetry.in/purchase-poetry.php">
  <meta property="twitter:title" content="Purchase Poetry by Satyam Arya - Mypoetry.in">
  <meta property="twitter:description"
    content="Explore and purchase unique and personalized poetry crafted by Satyam Arya. Elevate your emotions through exquisite verses available for purchase on Mypoetry.in.">
  <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

  <link rel="canonical" href="https://mypoetry.in/purchase-poetry.php">


  <?php include 'pages/links.html'; ?>
  <link rel="stylesheet" href="styles/pricing.css">
</head>

<body class="sub_page">

  <div class="hero_area">
    <div class="bg-box">
      <img src="source/Images/hero-bg.jpg" alt="navabr">
    </div>
    <?php include 'pages/navbar.html' ?>

  </div>
  <?php include 'pages/order_poetry.php'; ?>

  <section class="landing-page-section">
    <h2>Basic Plans of <span class="gradient-text">MyPoetry.in</span></h2>
    <p>
      The price for each plan represents a one-time payment.
    </p>
    <div class="pricing-container">
      <article class="pricing-card">
        <img src="source/pricing/ebook.svg" alt="standerd Pack" class="plan-icon">
        <h3>Standerd Pack</h3>
        <div class="pricing-card__price">
          <img alt="Price" src="source/pricing/price.svg">
          <i class="fa-solid fa-indian-rupee-sign"></i>40
          <s><i class="fa-solid fa-indian-rupee-sign"></i>100</s>
        </div>
        <a href="#book_section" class="enroll" title="Purchase  Now" href="#book_section">
          Purchase Now
        </a>
        <div class="divider"></div>
        <ul>
          <li>
            <i class="fa-regular fa-circle-check" style="color: #2a6e11;"></i> 24h+ Delevery
          </li>
          <li>
            <i class="fa-regular fa-circle-check" style="color: #2a6e11;"></i> Get Delevery on Email
          </li>
          <li>
            <i class="fa-regular fa-circle-xmark" style="color: #c11515;"></i> Image + Music
          </li>
          <li>
            <i class="fa-regular fa-circle-xmark" style="color: #c11515;"></i> After Sell Service
          </li>
        </ul>
      </article>
      <article class="pricing-card">
        <img src="source/pricing/ebook.svg" alt="E-book Package" class="plan-icon">
        <h3>Premium Pack</h3>
        <div class="pricing-card__price">
          <img alt="Price" src="source/pricing/price.svg">
          <i class="fa-solid fa-indian-rupee-sign"></i>60
          <s><i class="fa-solid fa-indian-rupee-sign"></i>189</s>
        </div>
        <a class="enroll" title="Purchase Now" href="#book_section">
          Purchase Now
        </a>
        <div class="divider"></div>
        <ul>
          <li>
            <i class="fa-regular fa-circle-check" style="color: #2a6e11;"></i> Less Than 12h Delevery
          </li>
          <li>
            <i class="fa-regular fa-circle-check" style="color: #2a6e11;"></i> Get Delevery on Email and Whatsapp
          </li>
          <li>
            <i class="fa-regular fa-circle-check" style="color: #2a6e11;"></i> Image + Music
          </li>
          <li>
            <i class="fa-regular fa-circle-check" style="color: #2a6e11;"></i>After sell Service with changebale Content
          </li>
        </ul>
      </article>

    </div>
  </section>
  <?php include 'pages/footer.html'; ?>
  <?php include 'pages/scripts.html'; ?>
</body>

</html>