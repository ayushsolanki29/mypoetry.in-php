<?php
session_start();
include "auth/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include 'pages/meta.html'; ?>
    <?php include 'pages/links.html'; ?>
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="https://kit.fontawesome.com/b8b432d7d3.js" crossorigin="anonymous">

    <title>MyPoetry.in - User Profile</title>
    <meta name="title" content="MyPoetry.in - User Profile">
    <meta name="description"
        content="Explore and manage your user profile on MyPoetry.in. Showcase your poetry, connect with the poetry community, and personalize your experience.">
    <meta name="keywords"
        content="MyPoetry.in, User Profile, Poetry Showcase, Poetry Community, Personalized Experience, Poetry Platform">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/user-profile.php">
    <meta property="og:title" content="MyPoetry.in - User Profile">
    <meta property="og:description"
        content="Explore and manage your user profile on MyPoetry.in. Showcase your poetry, connect with the poetry community, and personalize your experience.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/user-profile.php">
    <meta property="twitter:title" content="MyPoetry.in - User Profile">
    <meta property="twitter:description"
        content="Explore and manage your user profile on MyPoetry.in. Showcase your poetry, connect with the poetry community, and personalize your experience.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/user-profile.php">

</head>

<body class="sub_page">
    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="navabr">
        </div>
        <?php include 'pages/navbar.html' ?>
    </div>
    <?php
    if (isset($_SESSION['user_id'])) {
        $userID = $_SESSION['user_id'];
        $query = "SELECT user_id, username, logintype, registerdate, useremail, userprofile,feedback FROM users WHERE user_id=?";
        $stmt = mysqli_prepare($con, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $userID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $userIdResult, $usernameResult, $logintypeResult, $registerdateResult, $useremailResult, $userprofileResult, $feedbackResult);

            if (mysqli_stmt_fetch($stmt)) {
                ?>
                <?php if (isset($_GET['profile-msg'])) {
                    $status = $_GET['profile-msg'];
                    ?>
                    <div class="alert alert-<?php echo $status; ?> alert-dismissible fade show notify mt-2" role="alert">
                        <strong>
                            <?php echo $status; ?> !
                        </strong>
                        <?php if (isset($_SESSION['profile-msg'])) {
                            echo $_SESSION['profile-msg'];
                        }
                        ; ?>
                        <button type="button" class="close" data-dismiss="alert" onclick="redirectToOrigin()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                } ?>
                <script>
                    function redirectToOrigin() {
                        window.location.href = "user-profile.php";
                    }
                </script>
                <div class="profile-container">

                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="main-profile">
                                <style>
                                    .notification {
                                        z-index: 100;
                                    }

                                    .profile-image {
                                        width: 150px;
                                        height: 150px;
                                        background: url("<?php echo $userprofileResult ?>") center;
                                        background-size: cover;
                                        border-radius: 50%;
                                        border: 10px solid var(--primary-bg);
                                    }
                                </style>
                                <div class="profile-image">
                                </div>
                                <div class="profile-names">
                                    <h1 class="username" style="font-size: 1.5rem;">
                                        <?php echo str_replace(' ', '', $usernameResult); ?>
                                    </h1>
                                    <small class="page-title">
                                        <?php echo $useremailResult; ?>
                                    </small>
                                </div>
                                <div class="more-icon-bg">
                                    <i class="fa-solid fa-ellipsis more-icon"></i>
                                    <div class="dropdown-content">
                                        <!-- Edit Profile Link -->
                                        <a href="#" data-toggle="modal" data-target="#editProfileModal">Edit</a>
                                        <a href="#" data-toggle="modal" data-target="#settingsModal">Settings</a>
                                        <a href="#" id="poppurchasedPoetry" data-toggle="modal"
                                            data-target="#purchasedPoetry">Purchased Poetry</a>
                                        <a href="logout.php">Logout</a>
                                    </div>
                                </div>
                            </div>
                            <div class="back-icon-bg">
                                <a href="index.php"><i class="fa-solid fa-arrow-left back-icon"></i></a>
                            </div>
                        </div>

                        <div class="profile-body">
                            <div class="profile-actions">
                                <button class="follow" data-toggle="modal" data-target="#feedbackModal">Feedback</button>
                                <button class="message">Share</button>
                                <section class="bio">
                                    <div class="bio-header">
                                        <i class="fa fa-info-circle"></i>
                                        Date Info
                                    </div>
                                    <p class="bio-text">
                                        Join :
                                        <?php echo $registerdateResult ?>

                                    </p>
                                </section>
                            </div>

                            <div class="account-info">
                                <div class="data">
                                    <div class="important-data">
                                        <section class="data-item">
                                            <h5 class="value">Active</h5>
                                            <small class="title"> Status</small>
                                        </section>
                                        <section class="data-item">
                                            <h3 class="value">
                                                <?php echo $userIdResult ?>
                                            </h3>
                                            <small class="title">User ID</small>
                                        </section>
                                        <section class="data-item">
                                            <h5 class="value">
                                                <?php echo $logintypeResult ?>
                                            </h5>
                                            <small class="title">Login Type</small>
                                        </section>
                                        </section>

                                    </div>
                                    <div class="other-data">
                                        <section class="data-item">
                                            <h3 class="value">0</h3>
                                            <small class="title">Orders</small>
                                        </section>
                                        <section class="data-item">
                                            <h3 class="value">0</h3>
                                            <small class="title">Share-Poetry</small>
                                        </section>
                                        <section class="data-item">
                                            <h3 class="value">0</h3>
                                            <small class="title">Liked</small>
                                        </section>
                                    </div>
                                </div>

                                <div class="social-media" data-toggle="modal" data-target="#feedbackModal">
                                    <span>Ratings </span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <button class="rating-btn" data-toggle="modal" data-target="#feedbackModal">Feedback</button>
                                </div>

                                <div class="last-post" id="poppurchasedPoetry" data-toggle="modal" data-target="#purchasedPoetry">
                                    <div class="post-cover">
                                        <span class="last-badge">Purchased</span>
                                    </div>
                                    <h3 class="post-title">Poetry Details</h3>
                                    <button class="post-CTA">View </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    } else {
        ?>
        <div class="Card-center">
            <div class="not-loged">
                <span class="title">We Notice You Are Not Logged In</span>
                <div class="description">
                    <p>Explore our website features by logging in or create a new account to get started.</p>
                </div>
                <div class="actions">
                    <a href="register.php"><button class="pref">Don't have an account?</button></a>
                    <a href="login.php"><button class="accept">Login</button></a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">

                    <div class="text-center mb-2">
                        <span class="bg-info p-1 px-4 rounded text-white">User ID:
                            <?php echo $userIdResult; ?>
                        </span>
                    </div>

                    <?php if (isset($uploadError)): ?>
                        <div class="alert alert-danger mt-2">
                            <?php echo $uploadError; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="profile-update.php" enctype="multipart/form-data">
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">

                                <img src="<?php echo $userprofileResult; ?>" width="100" class="rounded-circle"
                                    alt="<?php echo $usernameResult; ?>">
                                <label for="profilePhoto">Profile Photo</label>
                                <input type="file" name="profile" accept="image/png, image/jpeg, image/jpg"  class="form-control-file" id="profilePhoto">
                            </div>
                            <?php if ($userprofileResult != "source/profile/defult.jpg") {
                                ?>
                                <button type="submit" name="resetPic" class="btn btn-warning mt-2 mr-2">Reset</button>
                            <?php } ?>

                            <input type="hidden" name="userid" value="<?php echo $userIdResult; ?>">
                            <input type="hidden" name="username" value="<?php echo $usernameResult; ?>">
                            <button type="submit" name="uploadPic" class="btn btn-secondary mt-2">Upload</button>

                        </div>
                    </form>
                    <hr>
                    <form method="POST" action="profile-update.php">
                        <!-- Username -->
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="hidden" name="userid" value="<?php echo $userIdResult; ?>">
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?php echo $usernameResult; ?>">
                        </div>
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo $useremailResult ?>">
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="password form-control" name="password"
                                placeholder="Your Password" value="<?php if (isset($_COOKIE['emailcookie'])) {
                                    echo $_COOKIE['passwordcookie'];
                                } ?>" title="Minimum 6 characters at 
                                    least 1 Alphabet and 1 Number" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"
                                required>
                            <br>
                            <label for="password"> <a href="forgot-password.php">Reset Password</a></label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="saveChanges">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- purchased Poetry -->
    <div class="modal fade" id="purchasedPoetry" tabindex="-1" role="dialog" aria-labelledby="purchasedPoetryLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="purchasedPoetryLabel">Purchased Poetry</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <div class='alert alert-danger'>This feature is currently in progress. We appreciate your
                            understanding and patience. If you have any questions or need assistance, don't hesitate to
                            <a href="contact-us.php" class="text-primary">reach out to us</a>. We're here to help!
                        </div>
                        <button type="submit" class="btn btn-primary">Okay I Understand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Settings Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingsModalLabel">Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input notify" id="switchToggle">
                        <label class="form-check-label" for="switchToggle">Notification</label>
                    </div>

                    <!-- <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
                    <p><a href="#" data-toggle="modal" data-target="#contactCare">Details</a> Contact our Customer care
                    </p>
                    <button type="button" class="btn btn-primary"> Save changes</button>

                </div>
            </div>
        </div>
    </div>
    <!-- contactCare -->
    <div class="modal fade" id="contactCare" tabindex="-1" role="dialog" aria-labelledby="contactCareLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactCareLabel">Contact </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mt-3">Satyam Arya</p>
                    <button type="button" class="btn btn-primary">Call</button>
                    <button type="button" class="btn btn-success">Message</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .star-rating .fa-star.checked {
            color: gold;
        }
    </style>
    <!-- Feedback Modal -->

    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if ($feedbackResult === "False") {
                        ?>
                        <form action="profile-update.php" method="post">
                            <div class="star-rating" style="user-select:none;">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <input type="hidden" id="rating" name="rating" value="0">
                            <div class="form-group mt-3">
                                <label for="feedback">Your Feedback:</label>
                                <textarea placeholder="Write your experience (between 100 and 108 characters)"
                                    name="feedbacktext" class="form-control" id="feedbackText" rows="3" required></textarea>
                                <span id="charCount"></span>
                                <span id="errorMessage" style="color: red;"></span>
                                <input type="hidden" name="userId" value="<?php echo $userIdResult; ?>">
                                <input type="hidden" name="userName" value="<?php echo $usernameResult; ?>">
                                <input type="hidden" name="userPic" value="<?php echo $userprofileResult; ?>">
                            </div>
                            <button type="submit" name="feedback" class="btn btn-primary mt-3" id="submitFeedbackBtn">Submit
                                Feedback</button>
                            <button type="button" class="btn btn-secondary mt-3" id="defaultText"
                                onclick="generateReviews()">Generate Review</button>
                            <div id="reviewsContainer"></div>

                        </form>
                    <?php } else {
                        echo "You already Submited Your Feedback";
                    } ?>
                </div>
            </div>
        </div>
    </div>

    <script>document.addEventListener("DOMContentLoaded", function () {
            var moreIconBg = document.querySelector(".more-icon-bg");
            var dropdownContent = document.querySelector(".dropdown-content");

            moreIconBg.addEventListener("click", function () {
                dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" : "block";
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const stars = document.querySelectorAll('.star-rating .fa-star');
            const ratingInput = document.getElementById('rating');
            const feedbackText = document.getElementById('feedbackText');
            const submitBtn = document.getElementById('submitFeedbackBtn');

        // Handle star hover effect
            stars.forEach(star => {
                star.addEventListener('mouseover', function () {
                    stars.forEach(s => s.classList.remove('checked'));
                    star.classList.add('checked');
                });

                star.addEventListener('mouseout', function () {
                    stars.forEach(s => s.classList.remove('checked'));
                    // Restore the selected stars
                    for (let i = 0; i < ratingInput.value; i++) {
                        stars[i].classList.add('checked');
                    }
                });

                // Handle star click event
                star.addEventListener('click', function () {
                    ratingInput.value = Array.from(stars).indexOf(star) + 1;
                });
            });


        });
        const feedbackTextarea = document.getElementById("feedbackText");
        const charCountElement = document.getElementById("charCount");
        const errorMessageElement = document.getElementById("errorMessage");

        // Set minimum and maximum character limits
        const minLength = 100;
        const maxLength = 108;

        // Add event listener for input in the textarea
        feedbackTextarea.addEventListener("input", function () {
            const textLength = feedbackTextarea.value.length;
            charCountElement.textContent = textLength + " characters";

            if (textLength < minLength) {
                errorMessageElement.textContent = "Minimum " + minLength + " characters required.";
            } else if (textLength > maxLength) {
                errorMessageElement.textContent = "Maximum " + maxLength + " characters allowed.";
            } else {
                errorMessageElement.textContent = "";
            }
        });
        // Function to generate random reviews for text areas
        function generateReviews() {
            const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>]/g;
            const reviews = [
                "Excellent service! I'm extremely satisfied with my experience.And now im suggets to please must use poetry purchase.",
                "The website is full friendly and helpful. Will definitely come back! and its featurs are most usesble.",
                "Amazing Poetrys and great prices. Highly recommended!, im very happy to using this website and there features",
                "Fast Delevery and superb customer support. 5 stars! Must Try this Plateform and there services. thanks",
                "This website exceeded my expectations. A fantastic shopping experience! and website has feature of email support is awsome and time saver",
                "Quality services and exceptional Featurs. I'm a happy customer!. thanks for made my day. must recounded website"
            ];

            const textAreas = document.querySelectorAll('textarea');

            textAreas.forEach(textArea => {
                // Clear previous content
                textArea.value = '';

                // Generate random review
                const randomReviewIndex = Math.floor(Math.random() * reviews.length);
                let review = reviews[randomReviewIndex];

                // Remove special characters
                review = review.replace(specialCharsRegex, '');

                // Truncate to 100-108 characters
                const maxLength = Math.floor(Math.random() * (9)) + 100; // Generates random number between 100 and 108
                review = review.substring(0, maxLength);

                // Fill the text area
                textArea.value = review;
            });
        }

    </script>
    <script>
        const NotificationBtn = document.querySelector(".notify");

        const requestPermission = async function () {
            try {
                // Request notification permission
                const permission = await Notification.requestPermission();

                if (permission === "granted") {
                    // Create a notification if permission is granted
                    const notification = new Notification("Mypoetrt.in", {
                        body: "welcome to Mypoetry.in ",
                        icon: "https://testing.mypoetry.in/source/Favicon/android-chrome-192x192.png"
                    });

                    // Handle notification click event
                    notification.onclick = function (event) {
                        window.location.href = "index.php";
                        notification.close();
                    };
                } else if (permission === "denied") {
                    alert("Notification permission denied");
                } else {
                    alert("Notification permission dismissed");
                }
            } catch (error) {
                console.error("Error occurred while requesting notification permission:", error);
            }
        };

        // Add click event listener to the button
        NotificationBtn.addEventListener("click", requestPermission);
    </script>
    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
</body>

</html>