<?php
session_start();
include 'auth/config.php';
require 'vendor/autoload.php';
include 'auth/google-config.php';
include 'auth/fb-config.php';

if (isset($_GET['msg'])) {
    $infomsg = $_GET['msg'];
    $msg = "<div class='alert alert-success'>$infomsg</div> ";
}else{
    $msg = '';
}


if (isset($_GET['verification'])) {
    $verificationCode = $_GET['verification'];
    $query = "SELECT * FROM users WHERE code=?";
    $stmt = mysqli_prepare($con, $query);

    if (!$stmt) {
        die("Error: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, "s", $verificationCode);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $updateQuery = "UPDATE users SET status='active', code='' WHERE code=?";
        $stmt = mysqli_prepare($con, $updateQuery);

        if (!$stmt) {
            die("Error: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param($stmt, "s", $verificationCode);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['user_id'] = $row['user_id'];
            $token = bin2hex(random_bytes(32));
            $expiration = date('Y-m-d H:i:s', strtotime('+30 days'));
            $insertQuery = "INSERT INTO rememberme_tokens (user_id, token, expiration) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $insertQuery);

            if (!$stmt) {
                die("Error: " . mysqli_error($con));
            }

            mysqli_stmt_bind_param($stmt, "sss", $row['user_id'], $token, $expiration);

            if (mysqli_stmt_execute($stmt)) {
                setcookie('rememberme', $token, strtotime('+30 days'));
            } else {
                echo "<script>alert(\"There was an error while setting rememberme cookie.\")</script>";
            }
            header("Location: index.php");
            exit;
        } else {
            $msg = "<div class='alert alert-danger'>Account verification failed.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Account verification Link Expired. Try Again!!</div>";
    }
}


if (isset($_COOKIE['rememberme'])) {
    $token = $_COOKIE['rememberme'];
    $query = "SELECT * FROM rememberme_tokens WHERE token = ? AND expiration > NOW()";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        die("Error: " . mysqli_error($con));
    }
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: index.php?remebertoken=activated");
        exit;
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['rememberme']);

    $query = "SELECT user_id, userpassword, status, logintype FROM users WHERE useremail=?";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        die("Error: " . mysqli_error($con));
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['logintype'] === 'Google') {
            echo '<script>alert("Your account is logged in via Google. Please log in using the Google login button")</script>';
        }
        if (password_verify($password, $row['userpassword'])) {

            if ($row['status'] === 'active') {
                $_SESSION['user_id'] = $row['user_id'];

                if ($rememberMe) {
                    $token = bin2hex(random_bytes(32));
                    $expiration = date('Y-m-d H:i:s', strtotime('+30 days'));
                    $insertQuery = "INSERT INTO rememberme_tokens (user_id, token, expiration) VALUES (?, ?, ?)";
                    $stmt = mysqli_prepare($con, $insertQuery);
                    if (!$stmt) {
                        die("Error: " . mysqli_error($con));
                    }
                    mysqli_stmt_bind_param($stmt, "sss", $row['user_id'], $token, $expiration);
                    if (mysqli_stmt_execute($stmt)) {
                        setcookie('rememberme', $token, strtotime('+30 days'));
                        header("Location: index.php");
                        exit;
                    } else {
                        echo "<script>alert(\"There was an error while logging in.\")</script>";
                    }
                }
                $msg = "<div class='alert alert-danger'>Your Email is Not Activated. Please Activate First</div>";
               
            } else {
                $msg = "<div class='alert alert-danger'>Your Email is Not Activated. Please Activate First</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Incorrect password</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Incorrect email.</div>";
    }
}

if (isset($_GET['code'])) {
    $token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $gclient->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];
        $gservice = new Google_Service_Oauth2($gclient);
        $udata = $gservice->userinfo->get();

        $name = $udata->givenName . " " . $udata->familyName;
        $email = $udata->email;
        $profile = $udata->picture;

        $checkQuery = "SELECT user_id FROM users WHERE useremail = '$email'";
        $checkResult = mysqli_query($con, $checkQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            $_SESSION['user_id'] = $row['user_id'];
        } else {
            $sql = "INSERT INTO users (username, useremail, registerdate, logintype, userprofile, status) 
                    VALUES ('$name', '$email', NOW(), 'Google', '$profile', 'active')";

            if (mysqli_query($con, $sql)) {
                $query = "SELECT user_id FROM users WHERE useremail = '$email'";
                $result = mysqli_query($con, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['user_id'] = $row['user_id'];
                } else {
                    echo "Error fetching user_id.";
                }
            } else {
                echo "Error: " . mysqli_error($con);
            }
        }
        header("Refresh:0");
        $token = bin2hex(random_bytes(32));
        $expiration = date('Y-m-d H:i:s', strtotime('+30 days'));
        $insertQuery = "INSERT INTO rememberme_tokens (user_id, token, expiration) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $insertQuery);
        if (!$stmt) {
            die("Error: " . mysqli_error($con));
        }
        mysqli_stmt_bind_param($stmt, "sss", $_SESSION['user_id'], $token, $expiration);
        if (mysqli_stmt_execute($stmt)) {
            setcookie('rememberme', $token, strtotime('+30 days'));
        } else {
            echo "<script>alert(\"There was an error while logging in.\")</script>";
        }
        header("Location: index.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>
    <title>Sign In to MyPoetry.in - Explore Your Poetic Journey</title>
    <meta name="title" content="Sign In to MyPoetry.in - Explore Your Poetic Journey">
    <meta name="description"
        content="Sign in to your MyPoetry.in account and immerse yourself in a poetic journey. Access your personalized dashboard, share your verses, and engage with a vibrant poetry community.">
    <meta name="keywords"
        content="Sign In, MyPoetry.in, User Login, Poetry Journey, Dashboard, Share Verses, Engage, Poetic Community">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/login.php">
    <meta property="og:title" content="Sign In to MyPoetry.in - Explore Your Poetic Journey">
    <meta property="og:description"
        content="Sign in to your MyPoetry.in account and immerse yourself in a poetic journey. Access your personalized dashboard, share your verses, and engage with a vibrant poetry community.">
    <meta property="og:image" content="https://mypoetry.in/img/og-login-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/login.php">
    <meta property="twitter:title" content="Sign In to MyPoetry.in - Explore Your Poetic Journey">
    <meta property="twitter:description"
        content="Sign in to your MyPoetry.in account and immerse yourself in a poetic journey. Access your personalized dashboard, share your verses, and engage with a vibrant poetry community.">
    <meta property="twitter:image" content="https://mypoetry.in/img/og-login-image.png">

    <link rel="canonical" href="https://mypoetry.in/login.php">

    <?php include 'pages/links.html'; ?>
    <link rel="stylesheet" href="styles/login.css">
</head>

<body class="sub_page">

    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="navabr">
        </div>
        <!-- header section strats -->
        <?php include 'pages/navbar.html' ?>
        <!-- end header section -->
    </div>
    <div class="login-wrapper">
        <div class="login-side">
            <div class="my-form__wrapper">
                <div class="login-welcome-row">
                    <h1>Welcome back &#x1F44F;</h1>
                    <p>Log in to access your account and continue your journey with us.</p>
                </div>
                <form class="my-form" method="post">
                    <?php include 'pages/social_logins.php'; ?>
                    <div class="divider">
                        <div class="divider-line"></div>
                        Or
                        <div class="divider-line"></div>
                    </div>
                    <?php echo $msg; ?>
                    <div class="text-field">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Your Email" value="<?php if (isset($_COOKIE['emailcookie'])) {
                            echo $_COOKIE['emailcookie'];
                        } ?>" required>
                        <img alt="Email Icon" title="Email Icon" src="source/login/email.svg">
                    </div>
                    <div class="text-field">
                        <label for="password">Password:</label>
                        <input id="password" type="password" class="password" name="password"
                            placeholder="Your Password" value="<?php if (isset($_COOKIE['emailcookie'])) {
                                echo $_COOKIE['passwordcookie'];
                            } ?>" title="Minimum 6 characters at 
                                    least 1 Alphabet and 1 Number" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"
                            required>
                        <img alt="Password Icon" title="Password Icon" src="source/login/lock.svg" id="lockIcon"
                            style="cursor:pointer;">
                        <img alt="Password Icon" title="Password Icon" src="source/login/unlock.svg" id="unLockIcon"
                            style="display:none;cursor:pointer;">
                    </div>
                    <input type="submit" class="my-form__button" name="login" value="Login">
                    <div class="my-form__actions">
                        <div class="my-form__row">
                            <span><input type="checkbox" name="rememberme" id="checkbox" checked>Remember me</span>
                            <a href="password-recovery.php" title="Reset Password">
                                Reset Password
                            </a>
                        </div>
                        <div class="my-form__signup">
                            <a href="register.php" title="Create Account">
                                Don't Have an Account?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="info-side">
            <img src="source/login/login.svg" alt="Mock" class="mockup">
            <div class="welcome-message">
                <h2>Welcome to Our Platform! 👋</h2>
                <p>
                    Explore our amazing features and join our community to experience a world of possibilities.
                </p>

            </div>
        </div>
    </div>


    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.querySelector(".password");
            const lockIcon = document.getElementById("lockIcon");
            const unlockIcon = document.getElementById("unLockIcon");

            function togglePasswordVisibility() {
                const newPasswordType = passwordInput.type === "password" ? "text" : "password";
                passwordInput.type = newPasswordType;
                lockIcon.style.display = newPasswordType === "password" ? "block" : "none";
                unlockIcon.style.display = newPasswordType === "password" ? "none" : "block";
            }

            lockIcon.addEventListener("click", togglePasswordVisibility);
            unlockIcon.addEventListener("click", togglePasswordVisibility);
        });
    </script>

</body>

</html>