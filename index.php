<?php
session_start();
include "auth/config.php";


?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html'; ?>
    <title>Mypoetry.in: Customizable Poetry for Your Emotions and Poetry Tournaments</title>
    <meta name="title" content="mypoetry.in: Customizable Poetry for Your Emotions and Poetry Tournaments">
    <meta name="description"
        content="Discover the power of personalized poetry on Mypoetry.in. Craft your emotions into exquisite verses and join poetry tournaments to showcase your creativity. Unleash your inner poet today!">
    <meta name="keywords"
        content="satyam arya, chahat k arya,poetry,mypoetry,poetry Competition, order, daily poetry,Free entry, poetry tournament,poetry Competition, , Customizable Poetry, Personalized Verses, Poetry Tournaments, Emotive Expressions, Poetry Creation, Artistic Wordsmithing, Emotional Poetry, Creative Writing, Poetry Contests, Verse Crafting, Poetic Expression, Rhyme and Rhythm, Poet's Corner, Creative Poetry, Words of Emotion, Poet's Showcase, Poetry Community, Poetry Challenges, Poetic Competitions, Poetry Inspiration.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/">
    <meta property="og:title" content="Mypoetry.in: Customizable Poetry for Your Emotions and Poetry Tournaments">
    <meta property="og:description"
        content="Discover the power of personalized poetry on Mypoetry.in. Craft your emotions into exquisite verses and join poetry tournaments to showcase your creativity. Unleash your inner poet today!">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/">
    <meta property="twitter:title" content="Mypoetry.in: Customizable Poetry for Your Emotions and Poetry Tournaments">
    <meta property="twitter:description"
        content="Discover the power of personalized poetry on Mypoetry.in. Craft your emotions into exquisite verses and join poetry tournaments to showcase your creativity. Unleash your inner poet today!">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/">

    <link rel="preload" href="styles/bootstrap.css" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        as="style">
    <?php include 'pages/links.html'; ?>
    <style>  
        .top3 {
            color: #fff;
        }

        .carousel-item {
            display: none;
        }

        .carousel-item.active {
            display: block;
        }

    
   
        ::-webkit-scrollbar {
            display: none;
        }

        .scrolltotop-style {
            position: fixed;
            right: 4%;
            bottom: 8%;
            z-index: 99999999999999999999999999999999;
            cursor: pointer;

        }

        #scrolltop {
            width: 50px;
            height: 50px;
            background: #FFBE33;
            padding-top: 30%;
            color: #fff;
            border-radius: 50%;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="home-page">
        </div>
        <?php include 'pages/navbar.html'; ?>
        <section class="slider_section">
            <div id="customCarousel1" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="container top3">
                        <h1 class="text-white">Today's Top <span class="top3">#3 Poetry</span> </h1>
                    </div>
                    <?php
                    $top3_cards = "SELECT * FROM top3_cards";
                    $result = mysqli_query($con, $top3_cards);
                    if (mysqli_num_rows($result) > 0) {
                        $firstItem = true;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $activeClass = $firstItem ? 'active' : '';
                            echo '<div class="carousel-item ' . $activeClass . '">';
                            echo '<div class="container">';
                            echo '<div class="row">';
                            echo '<div class="col-md-7 col-lg-6">';
                            echo '<div class="detail-box">';
                            echo '<p style="font-size:20px">';
                            echo '<span style="color:#ffbe33">"</span>' . $row['poetry'] . '<span style="color:#ffbe33">"</span>';
                            echo '</p>';
                            echo '<h6 style="float:right;">Written by <span class="top3 writter">' . $row['writter'] . '</span></h6>';
                            echo '<div class="btn-box">';
                            echo '<a href="poetry-details.php?category=*" class="btn1">Explore</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            $firstItem = false;
                        }
                    } else {
                        echo 'No records found in the top3_cards table.';
                    }
                    ?>
                   
                </div>
                <div class="container">
                    <ol class="carousel-indicators">
                        <?php
                        mysqli_data_seek($result, 0);
                        $indicatorIndex = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $indicatorClass = $indicatorIndex === 0 ? 'active' : '';
                            echo '<li data-target="#customCarousel1" data-slide-to="' . $indicatorIndex . '" class="' . $indicatorClass . '"></li>';
                            $indicatorIndex++;
                        }
                        ?>
                    </ol>
                </div>
            </div>
        </section>

       

    </div>


    <section class="offer_section layout_padding-bottom">
        <div class="offer_container">
            <div class="container">
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM offers_cards";
                    $result = mysqli_query($con, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="col-md-6">';
                            echo '<div class="box">';
                            echo '<div class="img-box">';
                            echo '<img src="' . $row['card_image'] . '" alt="">';
                            echo '</div>';
                            echo '<div class="detail-box">';
                            echo '<h5>' . $row['offer_day'] . '</h5>';
                            echo '<p>' . $row['offer_name'] . '</p>';
                            echo '<h6>';
                            echo '<span>' . $row['offer_price'] . '<i class="fa-solid fa-indian-rupee-sign"></i></span>';
                            echo '<del>' . $row['original_price'] . '<i class="fa-solid fa-indian-rupee-sign"></i></del>';
                            echo '</h6>';
                            echo "<a href='purchase-poetry.php?offer=active&type=" . $row["offer_name"] . "'>";
                            echo 'View Details <i class="fa-solid fa-arrow-right"></i>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo 'No offers available.';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

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
                $sql = "SELECT * FROM category_card LIMIT 9";
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
                        echo '<a href="poetry-details.php?category=' . $row['title'] . '">';
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
            <div class="btn-box">
                <a href="poetry-categories.php">View More</a>
            </div>
        </div>
    </section>

    <section class="about_section d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="admin_social_card">
                <div class="card">
                    <div class="img">
                        <img src="source/Images/admin.png">
                    </div>
                    <div class="infos">
                        <div class="name">
                            <h2>Satyam Arya</h2>
                            <h4>@ Chahat K. Arya</h4>
                        </div>
                        <p class="text">

                            I'm Chaahat K Arya from Gandhinagar, Gujarat, born on September 28, 1996. I started writing
                            in 2016, expressing my emotions through poetry. Traveling inspires my work, capturing the
                            essence of diverse places and people. For the past decade, I've been involved in "SEVA" at
                            Shrimad Rajchandra Adyatmik Sadhana Kendra, Koba, Gandhinagar. Thanks to my readers and
                            friends for their constant support in my writing journey. 😊</p>
                        <ul class="stats">
                            <li>
                                <h3>15K</h3>
                                <h4>Views</h4>
                            </li>
                            <li>
                                <h3>02K</h3>
                                <h4>Peotrys</h4>
                            </li>
                            <li>
                                <h3>13</h3>
                                <h4>Awards</h4>
                            </li>
                        </ul>
                        <div class="links">
                            <button class="follow" type="button" onclick="social_redirect()">Follow</button>
                            <button class="view" onclick="redirectAbout()">About More</button>
                            <script>
                                function redirectAbout() {
                                    window.location.href = "about.php";
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'pages/order_poetry.php'; ?>
    <section class="about_section d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="tournament-card mt-4 mb-4">
                <div class="image">
                </div>
                <div class="content">
                    <p class="text-1">
                        Participate in our Poetry Tournament
                    </p>

                    <div class="text-2">
                        <span>
                            Free Tournament
                        </span>
                        <span>Free Entry Fees and win Existing Rewards </span>
                    </div>

                    <a class="action" href="tournament.php">
                        Join the Poetry Competition
                    </a>

                    <p class="date">
                        <?php $select = "SELECT * FROM `settings` WHERE id=2";
                        $result = mysqli_query($con, $select);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $Startdate = date('d M Y', strtotime($row['data-value2']));
                                echo "Tournament stats on $Startdate*";
                            }
                        }


                        ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="client_section layout_padding-bottom">
        <div class="container">
            <div class="heading_container heading_center psudo_white_primary mb_45">
                <h2>What Says Our <span class="top3">Customers</span></h2>
            </div>
            <div class="carousel-wrap row">
                <div class="owl-carousel client_owl-carousel">
                    <?php
                    $sql = "SELECT * FROM feedback ORDER BY rating_date DESC";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="item">';
                            echo '<div class="box">';
                            echo '<div class="detail-box">';
                            $description = $row['description'];
                            $limitedDescription = (strlen($description) > 108) ? substr($description, 0, 105) . '...' : $description;
                            echo '<p>' . $limitedDescription . '</p>';
                            echo '<h6>' . $row['user_name'] . '</h6>';
                            echo '<p>';
                            $rating = intval($row['rating']);
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<span class="fa fa-star checked"></span>';
                                } else {
                                    echo '<span class="fa fa-star"></span>';
                                }
                            }
                            echo '</p>';
                            $ratingDate = strtotime($row['rating_date']);
                            $currentDate = time();
                            $differenceInSeconds = $currentDate - $ratingDate;
                            $differenceInDays = floor($differenceInSeconds / (60 * 60 * 24));
                            if ($differenceInDays == 0) {
                                echo '<p style="float:right;">Today</p>';
                            } elseif ($differenceInDays == 1) {
                                echo '<p style="float:right;">Yesterday</p>';
                            } elseif ($differenceInDays <= 60) {
                                echo '<p style="float:right;">' . $differenceInDays . ' days ago</p>';
                            } else {
                                $differenceInWeeks = ceil($differenceInDays / 7);
                                echo '<p style="float:right;">' . $differenceInWeeks . ' weeks ago</p>';
                            }
                            echo '</div>';
                            echo '<div class="img-box">';
                            echo '<img src="' . $row['user_img'] . '" alt="" class="box-img">';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo 'No feedback available.';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>


    <section class="center_popup hide" id="social_popup">
        <div class="card">
            <i class="close-icon fa fa-times" onclick="closeSocialPopup()"></i>
            <span class="small-text">Follow on</span>
            <span class="title">@Chahatkaryaa</span>
            <div class="buttons">
                <a href="https://instagram.com/mere_ahsaas2709?utm_source=qr&igshid=MzNlNGNkZWQ4Mg==" class="button"
                    target="blank">
                    <span class="icon"><i class="fa-brands fa-instagram"></i></span>
                    <div class="button-text google">
                        <span></span>
                        <span>Instagram</span>
                    </div>
                </a>
                <a href="https://www.facebook.com/shiv.arya.3517?mibextid=ZbWKwL" class="button" target="blank">
                    <span class="icon"><i class="fa-brands fa-facebook text-black"></i></span>
                    <div class="button-text apple">
                        <span></span>
                        <span>Facebook</span>
                    </div>
                </a>
            </div>
        </div>
        <script>
            function social_redirect() {
                const social_popup = document.getElementById('social_popup');
                social_popup.classList.remove("hide");
            }
            function closeSocialPopup() {
                const social_popup = document.getElementById('social_popup');
                social_popup.classList.add("hide");
            }
        </script>
    </section>
    <?php include 'pages/footer.html'; ?>
    <div class="scrolltotop-style">
        <center><i class="fa-solid fa-arrow-up" id="scrolltop"></i></center>
    </div>
    <?php include 'pages/scripts.html'; ?>
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
</body>

</html>
<?php mysqli_close($con); ?>