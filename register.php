<?php session_start(); ?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'auth/config.php';
include 'auth/google-config.php';
include 'auth/fb-config.php';
$msg = "";
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
        header("Location: index.php?login=true");
        exit;
    }
}
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, ($_POST['password']));

    $confirm_password = mysqli_real_escape_string($con, ($_POST['confirm-password']));
    $code = mysqli_real_escape_string($con, md5(rand()));

    if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE useremail='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
    } else if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE username='{$name}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$name} - This username is Taken.</div>";
    } else {
        if ($password === $confirm_password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (username, useremail,userpassword	,registerdate,logintype, code,status) VALUES ('{$name}', '{$email}', '{$hashedPassword}',NOW(),'email', '{$code}','inactive')";
            $result = mysqli_query($con, $sql);

            if ($result) {

                $mail = new PHPMailer(true);

                try {
                    $mail = new PHPMailer(true);

                    $mail->isSMTP();
                    $mail->Host = 'mail.mypoetry.in';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'welcome@mypoetry.in';
                    $mail->Password = ';s);4Zk7T!B,';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

                    $mail->setFrom('welcome@mypoetry.in', 'mypoetry.in');
                    $mail->addAddress($email);

                    //Content
                    $mail->isHTML(true); //Set email format to HTML
                    $mail->Subject = 'Account Activation';
                    $templatePath = "mail/activation.html";
                    $templateContent = file_get_contents($templatePath);

                    $templateContent = str_replace("{username}", $name, $templateContent);
                    $templateContent = str_replace("{activation_link}", "$domain/login.php?verification=$code", $templateContent);

                    $mail->Body = $templateContent;

                    $mail->send();
                    "mail sent";
                    
                } catch (Exception $e) {
                    "Mailer Error: {$mail->ErrorInfo}";
                }
                $notiInstert = "INSERT INTO `notification`(`title`, `url`, `date`) VALUES ('$name Just Created His Account','users.php',NOW())"; 
                $result = mysqli_query($con, $notiInstert);
                if (!$result) {
                    echo "Erorr";
                }
                $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>

    <title>Join MyPoetry.in - Create Your Account</title>
    <meta name="title" content="Join MyPoetry.in - Create Your Account">
    <meta name="description"
        content="Unlock the world of poetry by joining MyPoetry.in. Create your account to share your verses, connect with fellow poets, and participate in engaging poetry events.">
    <meta name="keywords"
        content="Register, Join MyPoetry.in, Create Account, Poetry Community, Share Verses, Poetry Events">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/register.php">
    <meta property="og:title" content="Join MyPoetry.in - Create Your Account">
    <meta property="og:description"
        content="Unlock the world of poetry by joining MyPoetry.in. Create your account to share your verses, connect with fellow poets, and participate in engaging poetry events.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/register.php">
    <meta property="twitter:title" content="Join MyPoetry.in - Create Your Account">
    <meta property="twitter:description"
        content="Unlock the world of poetry by joining MyPoetry.in. Create your account to share your verses, connect with fellow poets, and participate in engaging poetry events.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/register.php">
   
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
    <!-- end header section -->
    <div class="login-wrapper">
        <div class="login-side">
            <div class="my-form__wrapper">
                <div class="login-welcome-row">
                    <h1>Create Account&#x1F44F;</h1>
                    <p>Create Your Account with mypoerty.in</p>

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
                        <label for="email">Username:</label>
                        <input type="text" id="username" name="username" title="Please Enter username"
                            placeholder="Your Username" required>

                    </div>
                    <div class="text-field">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Your Email" required>

                    </div>
                    <div class="text-field">
                        <label for="password">Password:</label>
                        <input id="password" type="password" class="password" name="password"
                            placeholder="Your Password" title="Minimum 6 characters at 
                                    least 1 Alphabet and 1 Number" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"
                            required>
                        <img alt="Password Icon" title="Password Icon" src="source/login/lock.svg" id="lockIcon"
                            style="cursor:pointer;">
                        <img alt="Password Icon" title="Password Icon" src="source/login/unlock.svg" id="unLockIcon"
                            style="display:none;cursor:pointer;">
                    </div>
                    <div class="text-field">
                        <label for="confirmpassword">Confirm Password:</label>
                        <input id="confirmpassword" class="confirm-password" type="password" name="confirm-password"
                            placeholder="Your Confirm Password" title="Minimum 6 characters at 
                                    least 1 Alphabet and 1 Number" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"
                            required>

                    </div>
                    <div class="my-form__row">
                        <span>By Creating an Account, You Are Accepting Our <a href="privacy-policy.php">Privacy Policy</a>
                            and <a href="terms-and-conditions.php">Terms of service.</a></span>
                    </div>
                    <input type="submit" class="my-form__button" name="register" value="Register">
                    <div class="my-form__actions">

                        <div class="my-form__signup">
                            <a href="login.php" title="Create Account">
                                Already Have an Account?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="info-side">
            <img src="source/login/register.svg" alt="Mock" class="mockup">
            <div class="welcome-message">
                <h2>Welcome to Our Registration Page 👋</h2>
                <p>
                    Join our community to access exclusive content, receive updates, and connect with like-minded
                    individuals.
                </p>

            </div>
        </div>
    </div>

    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.querySelector(".password");
            const confirmPasswordInput = document.querySelector(".confirm-password");
            const lockIcon = document.getElementById("lockIcon");
            const unlockIcon = document.getElementById("unLockIcon");

            function togglePasswordVisibility(input, icon) {
                if (input.type === "password") {
                    input.type = "text";
                    icon.style.display = "none";
                } else {
                    input.type = "password";
                    icon.style.display = "block";
                }
            }

            lockIcon.addEventListener("click", function () {
                togglePasswordVisibility(passwordInput, lockIcon);
                togglePasswordVisibility(confirmPasswordInput, lockIcon);
                unlockIcon.style.display = "block";
                lockIcon.style.display = "none";
            });

            unlockIcon.addEventListener("click", function () {
                togglePasswordVisibility(passwordInput, unlockIcon);
                togglePasswordVisibility(confirmPasswordInput, unlockIcon);
                unlockIcon.style.display = "none";
                lockIcon.style.display = "block";
            });
        });
    </script>


</body>

</html>