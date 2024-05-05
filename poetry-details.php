<?php
session_start();
include "auth/config.php";
mysqli_set_charset($con, "utf8");

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <?php include 'pages/meta.html' ?>
  <title>Poetry Details - MyPoetry.in</title>
<meta name="title" content="Poetry Details - MyPoetry.in">
<meta name="description" content="Explore the intricate details of this captivating poetry piece on MyPoetry.in. Delve into the emotions, themes, and artistic expression that make this verse truly special.">
<meta name="keywords" content="Poetry Details, MyPoetry.in, Explore Poetry, Emotional Expression, Artistic Themes, Captivating Verse, Poetic Details">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://mypoetry.in/poetry-details.php">
<meta property="og:title" content="Poetry Details - MyPoetry.in">
<meta property="og:description" content="Explore the intricate details of this captivating poetry piece on MyPoetry.in. Delve into the emotions, themes, and artistic expression that make this verse truly special.">
<meta property="og:image" content="https://mypoetry.in/source/og-image.png">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://mypoetry.in/poetry-details.php">
<meta property="twitter:title" content="Poetry Details - MyPoetry.in">
<meta property="twitter:description" content="Explore the intricate details of this captivating poetry piece on MyPoetry.in. Delve into the emotions, themes, and artistic expression that make this verse truly special.">
<meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

<link rel="canonical" href="https://mypoetry.in/poetry-details.php">

  <?php include 'pages/links.html'; ?>
  <link rel="stylesheet" href="styles/pricing.css">
</head>
<style>.food_section .filters_menu a li {
  color: #222831;
}</style>
<body class="sub_page">
  <div class="hero_area">
    <div class="bg-box">
      <img src="source/Images/hero-bg.jpg" alt="navabr">
    </div>

    <?php include 'pages/navbar.html' ?>
  </div>
  <section class="landing-page-section">
    <h2>
      <?php
      $category = isset($_GET['category']) ? $_GET['category'] : '';

      if ($category == '*') {
        echo 'All Type of';
      } else {
        echo $category;
      }
      ?>
      <span class="gradient-text"> Poetrys</span>

    </h2>
  </section>
  <section class="food_section layout_padding-bottom">
    <div class="container">
      <ul class="filters_menu">
        <?php
        $sql = "SELECT * FROM category_card";
        $result = mysqli_query($con, $sql);
        $firstItem = true;
        if (mysqli_num_rows($result) > 0) {
          $allActiveClass = isset($_GET['category']) && $_GET['category'] == '*' ? 'active' : '';
          echo '<a href="?category=*"><li class="' . $allActiveClass . '" data-filter="*">All</li></a>';
          while ($row = mysqli_fetch_assoc($result)) {
            $activeClass = '';
            if (isset($_GET['category']) && $_GET['category'] == $row['title']) {
              $activeClass = 'active';
            }
            $dataFilter = $row['data-filter'] === '*' ? '' : 'data-filter=".' . $row['data-filter'] . '"';
            echo '<a href="?category='. $row['title'] . '"><li class="' . $activeClass . '"'.$dataFilter.'>' . $row['title'] . '</li></a>';
          }
        } else {
          echo 'No categories available.';
        }

        ?>
      </ul>

      <div class="row grid" style="margin-left: 0px;">
        <?php
        $category = isset($_GET['category']) ? $_GET['category'] : '*';
        $sql = "SELECT * FROM poetry_cards";
        if ($category !== '*') {
          $sql .= " WHERE data_filters = '$category'";
        }
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            // Display poetry card HTML
            echo '<div class="poetry-card all ' . $row['data_filters'] . '">
                    <div class="infos">';

            // PHP code for date calculation
            $poetryDate = strtotime($row["date"]);
            $currentDate = strtotime(date("Y-m-d"));
            $differenceInDays = floor(($currentDate - $poetryDate) / (60 * 60 * 24));

            if ($differenceInDays == 0) {
              $dateText = "Today";
            } elseif ($differenceInDays == 1) {
              $dateText = "Tomorrow";
            } elseif ($differenceInDays <= 30) {
              $dateText = $differenceInDays . " days ago";
            } else {
              $monthsAgo = floor($differenceInDays / 30);
              $dateText = ($monthsAgo == 1) ? "1 month ago" : $monthsAgo . " months ago";
            }

            // Output date and description
            echo '<p class="date-time">' . $dateText . '</p>
                  <p class="description">' . $row['poetry'] . '</p>
                </div>
                <div class="author">
                  — ' . $row['author'] . '
                </div>
              </div>';
          }


        } else {
          echo 'No poetry available.';
        }
        ?>
      </div>
    </div>
  </section>
  <?php include 'pages/footer.html' ?>
  <?php include 'pages/scripts.html'; ?>
</body>

</html>