<?php
session_start();
include "auth/config.php";

$select = "SELECT `data-value`,`data-value2`,`data-value3` FROM `settings` WHERE id='2'";
$result = mysqli_query($con, $select);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $status = $row["data-value"];
        $datavalue2 = $row["data-value2"];
        $datavalue3 = $row["data-value3"];
        $dateStart = DateTime::createFromFormat('Y-m-d', $datavalue2);
        $dateEnd = DateTime::createFromFormat('Y-m-d', $datavalue3);

        if (!$dateStart || !$dateEnd) {
            echo "Error converting date.";
        } else {
            // Format the dates
            $formattedStartDate = $dateStart->format('d M');
            $formattedEndDate = $dateEnd->format('d M');
        }
        if ($status == "Active") {
            $selectToken = "SELECT `data-value` FROM `settings` WHERE id='4'";
            $resultToken = mysqli_query($con, $selectToken);

            if ($resultToken) {
                while ($rowToken = mysqli_fetch_assoc($resultToken)) {
                    $token = $rowToken["data-value"];
                    $_SESSION['tornament_token'] = $token;
                    $tornament_url = "tournament-form.php?tonrnament-token=$token";
                }
            }
        } elseif ($status = "Deactivate") {
            $tornament_url = "tournament-form.php";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>
    <title>Poetry Tournaments - MyPoetry.in</title>
    <meta name="title" content="Poetry Tournaments - MyPoetry.in">
    <meta name="description"
        content="Explore details about upcoming poetry tournaments on MyPoetry.in. Find information on tournament dates, prize pools, join links, and status. Participate in the excitement and showcase your poetic talent.">
    <meta name="keywords"
        content="Poetry Tournaments, MyPoetry.in, Tournament Details, Tournament Dates, Prize Pool, Join Link, Tournament Status, Poetic Talent Showcase">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/poetry-tournaments.php">
    <meta property="og:title" content="Poetry Tournaments - MyPoetry.in">
    <meta property="og:description"
        content="Explore details about upcoming poetry tournaments on MyPoetry.in. Find information on tournament dates, prize pools, join links, and status. Participate in the excitement and showcase your poetic talent.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/poetry-tournaments.php">
    <meta property="twitter:title" content="Poetry Tournaments - MyPoetry.in">
    <meta property="twitter:description"
        content="Explore details about upcoming poetry tournaments on MyPoetry.in. Find information on tournament dates, prize pools, join links, and status. Participate in the excitement and showcase your poetic talent.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/poetry-tournaments.php">

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
    <div class="container mt-3 Tornament-page mb-3">
        <div class="text-center">
            <h2 class="display-4 tonrnament-head">Poetry <span class="text-primary">Competition</span></h2>
            <p class="lead">
                Participate for <span class="text-success">free</span> and stand a chance to win exciting rewards!
            </p>
        </div>
        <script>
            const startDate = new Date("<?php echo $datavalue2; ?>");
            const endDate = new Date("<?php echo $datavalue3; ?>");

            const competitionStartDate = startDate.getTime();
            const competitionEndDate = endDate.getTime();

            const countdown = setInterval(function () {
                const now = new Date().getTime();
                let timeRemaining;

                if (now < competitionStartDate) {
                    timeRemaining = competitionStartDate - now;
                    document.getElementById("countdownStart").innerHTML = ` ${formatTime(timeRemaining)}`;
                } else if (now < competitionEndDate) {
                    timeRemaining = competitionEndDate - now;
                    document.getElementById("countdownStart").innerHTML = `${formatTime(timeRemaining)}`;
                } else {
                    clearInterval(countdown);
                    document.getElementById("countdownStart").innerHTML = "Competition has ended!";
                }
            }, 1000);

            // Function to format time
            function formatTime(time) {
                const days = Math.floor(time / (1000 * 60 * 60 * 24));
                const hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));

                return `${days}d ${hours}h ${minutes}m`;
            }
        </script>
        <div class="row mt-3">
            <div class="col-lg-6 mt-2">
                <div class="countdown-card text-center">
                    <div class="card-body">
                        <?php if ($status == "Active") {
                            echo "Hurry up! Only";
                        } ?>
                        <h5 class="card-title">
                        </h5>
                        <h2 id="countdownStart" class=" text-primary"></h2>
                        <p class="card-text">
                            <?php if ($status == "Active") {
                                echo "Days left to submit your poem";
                            } else {

                            } ?>
                        </p>
                    </div>
                    <div class="card-footer text-muted">
                        <?php if ($status == "Active") {
                            echo "Poetry Competition ends on " . $datavalue3;
                        } else {
                            echo "Competition ended!!";
                        } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-2 ">
                <div class="tornament-announce-card mt-2 mb-2">
                    <div class="date-time-container">
                        <?php
                        $dateStart = DateTime::createFromFormat('Y-m-d', $datavalue2);
                        $dateEnd = DateTime::createFromFormat('Y-m-d', $datavalue3);

                        // Check for errors in date conversion
                        if (!$dateStart || !$dateEnd) {
                            echo "Error converting date.";
                        } else {
                            // Format the dates
                            $formattedStartDate = $dateStart->format('d M');
                            $formattedStartYear = $dateStart->format('Y');
                        }
                        ?>
                        <time class="date-time" datetime="<?php echo $datavalue2 ?>" title="Start Date">
                            <span>
                                <?php if ($status == "Active") {
                                    echo $formattedStartYear;
                                } else {
                                    echo "--";
                                } ?>
                            </span>

                            <span class="separator"></span>
                            <span>
                                <?php if ($status == "Active") {
                                    echo $formattedStartDate;
                                } else {
                                    echo "Endned";
                                } ?>

                            </span>
                        </time>
                    </div>
                    <div class="content">
                        <div class="infos">
                            <?php if (new DateTime() < $dateEnd): ?>
                                <a href="<?php echo $tornament_url; ?>">
                                    <span class="title">
                                        Join Our Poetry Competition!
                                    </span>
                                </a>
                                <p class="description">
                                    Calling all poets and poetry enthusiasts! Showcase your talent and creativity by
                                    participating in our Poetry Competition. Express your emotions, thoughts, and stories
                                    through the power of words. This competition is open to everyone, and it's completely
                                    free to join! Don't miss this opportunity to be a part of a community passionate about
                                    poetry.
                                </p>
                            <?php else: ?>
                                <span class="title">
                                    Tournament Ended
                                </span>
                                <p class="description">
                                    The Poetry Competition has come to a close, and we extend our heartfelt gratitude to all
                                    the talented participants! Your poetic expressions have enriched our community. Stay
                                    tuned for exciting announcements about upcoming tournaments, as we eagerly anticipate
                                    bringing more opportunities for you to showcase your creativity. New tournament dates
                                    will be announced shortly, so be prepared to embark on another inspiring poetic journey
                                    with us!
                                </p>

                            <?php endif; ?>
                        </div>
                        <?php if (new DateTime() < $dateEnd): ?>
                            <a class="action" target="_blank" href="<?php echo $tornament_url; ?>">
                                0 <i class="fa-solid fa-indian-rupee-sign"></i> Entry Fees
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="pricing-container">
            <article class="pricing-card" style="max-width: 950px;">
                <img src="source/pricing/ebook.svg" alt="standerd Pack" class="plan-icon">
                <h3>Poetry Competition
                    <?php if ($status == "Active") {
                        echo "<span class='text-success'> Running </span>";
                    } else {
                        echo "<span class='text-danger'> Ended </span>";
                    } ?>
                </h3>
                <div class="pricing-card__price">
                    <img alt="Price" src="source/pricing/price.svg">
                    <span class="price-value"><i class="fa-solid fa-indian-rupee-sign"></i> 0 </span>
                </div>
                <a class="enroll" title="Join Now" target="_blank" href="<?php echo $tornament_url ?>">
                    <?php if ($status == "Active") {
                        echo "Free Joinning";
                    } else {
                        echo "No Compatition Available";
                    } ?>
                </a>
                <div class="divider"></div>
                <ul>
                    <li>
                        <i class="fa-regular fa-circle-check" style="color: #2a6e11;"></i> Free entry and exclusive
                        rewards
                    </li>
                    <li>
                        <i class="fa-regular fa-circle-check" style="color: #2a6e11;"></i> Earn a <span
                            class="text-success">Certificate</span>
                    </li>
                    <li>
                        <i class="fa-regular fa-circle-check" style="color: #2a6e11;"></i> Participate in live poetry
                        slams for cash prizes
                    </li>
                    <li>
                        <i class="fa-regular fa-circle-check" style="color: #2a6e11;"></i> Network with fellow poets and
                        experts
                    </li>
                </ul>

            </article>
        </div>

    </div>
    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>

</body>

</html>