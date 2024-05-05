<?php session_start();
include "auth/config.php" ?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>

    <title>Poetry Categories - Explore a Diverse Range of Expressions</title>

    <meta name="title" content="Poetry Categories - Explore a Diverse Range of Expressions">
    <meta name="description"
        content="Immerse yourself in the world of poetry categories. Explore a diverse range of expressions, themes, and emotions. Discover curated collections that resonate with your soul on Mypoetry.in.">
    <meta name="keywords"
        content="Poetry Categories, Explore Poetry, Diverse Expressions, Themes, Emotions, Curated Collections, Mypoetry.in, Verses, Poetic Themes, Poetry Genres">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/poetry-categories.php">
    <meta property="og:title" content="Poetry Categories - Explore a Diverse Range of Expressions">
    <meta property="og:description"
        content="Immerse yourself in the world of poetry categories. Explore a diverse range of expressions, themes, and emotions. Discover curated collections that resonate with your soul on Mypoetry.in.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/poetry-categories.php">
    <meta property="twitter:title" content="Poetry Categories - Explore a Diverse Range of Expressions">
    <meta property="twitter:description"
        content="Immerse yourself in the world of poetry categories. Explore a diverse range of expressions, themes, and emotions. Discover curated collections that resonate with your soul on Mypoetry.in.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/poetry-categories.php">

    <?php include 'pages/links.html'; ?>

</head>

<body class="sub_page">

    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="navabr">
        </div>

        <?php include 'pages/navbar.html' ?>
    </div>
    <section class="food_section layout_padding-bottom">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>Poetry <span class="top3">Category</span></h2>
            </div>
            <ul class="filters_menu">
                <?php
                $sql = "SELECT * FROM poetry_category";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $firstItem = true;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $activeClass = $firstItem ? 'active' : '';
                        $dataFilter = $row['data_filters'] === '*' ? '' : 'data-filter=".' . $row['data_filters'] . '"';
                        echo '<li class="' . $activeClass . '" ' . $dataFilter . '>' . $row['category'] . '</li>';
                        $firstItem = false;
                    }
                } else {
                    echo 'No categories available.';
                }
                ?>
            </ul>
            <div class="row grid">
                <?php
                $sql = "SELECT * FROM category_card";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-sm-6 col-lg-4 all ' . $row['data-filter'] . '">';
                        echo '<div class="box">';
                        echo '<div>';
                        echo '<div class="img-box">';
                        echo '<img src="' . $row['img'] . '" alt="">';
                        echo '</div>';
                        echo '<div class="detail-box">';
                        echo '<h5>' . $row['title'] . '</h5>';
                        echo '<p>' . $row['details'] . '</p>';
                        echo '<div class="options">';
                        echo '<h6 style="user-select:none">';
                        echo '<i class="fa-solid fa-heart" id="likeButton_' . $row['id'] . '"></i> ';
                        echo '<span id="likeStatus_' . $row['id'] . '">Like</span>';
                        echo '</h6>';
                        echo '<a href="poetry-details.php?category='. $row['title'] .'">';
                        echo '<i class="fa fa-angles-right"></i>';
                        echo '</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo 'No content available.';
                }
                ?>
            </div>

        </div>
    </section>
    <?php include 'pages/footer.html' ?>
    <?php include 'pages/scripts.html'; ?>

    <script>
        $(document).ready(function () {
            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + value + expires + "; path=/";
            }

            // Function to get the value of a cookie by its name
            function getCookie(name) {
                var nameEQ = name + "=";
                var cookies = document.cookie.split(';');
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = cookies[i];
                    while (cookie.charAt(0) === ' ') {
                        cookie = cookie.substring(1, cookie.length);
                    }
                    if (cookie.indexOf(nameEQ) === 0) {
                        return cookie.substring(nameEQ.length, cookie.length);
                    }
                }
                return null;
            }

    
            $("i.fa-solid.fa-heart").click(function () {
                // Get the unique ID from the clicked like button's ID attribute
                var id = $(this).attr("id").split("_")[1];
                var likeStatusElement = $("#likeStatus_" + id);

                // Check if the cookie exists
                var cookieName = "likeStatus_" + id;
                var existingStatus = getCookie(cookieName);

                // Toggle the color between red and white
                if (existingStatus === "liked") {
                    $(this).css("color", "#fff"); // Change color to black (or any desired color)
                    likeStatusElement.text("Like"); // Update like status to "Like"
                    // Set the cookie with an expiry date one month from now
                    setCookie(cookieName, "like", 30);
                } else {
                    $(this).css("color", "#ff0000"); // Change color to red
                    likeStatusElement.text("Liked"); // Update like status to "Liked"
                    // Set the cookie with an expiry date one month from now
                    setCookie(cookieName, "liked", 30);
                }
            });

            // Restore like statuses from cookies on page load
            $("i.fa-solid.fa-heart").each(function () {
                var id = $(this).attr("id").split("_")[1];
                var likeStatusElement = $("#likeStatus_" + id);
                var cookieName = "likeStatus_" + id;
                var existingStatus = getCookie(cookieName);

                if (existingStatus === "liked") {
                    $(this).css("color", "#ff0000");
                    likeStatusElement.text("Liked");
                } else {
                    $(this).css("color", "#fff");
                    likeStatusElement.text("Like");
                }
            });
        });

    </script>
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
</body>

</html>