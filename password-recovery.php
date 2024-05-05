<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'auth/config.php';
$msg = "";

if (isset($_POST['recover_email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $code = mysqli_real_escape_string($con, md5(rand()));

    if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE useremail='{$email}'")) > 0) {
        $query = mysqli_query($con, "UPDATE users SET code='{$code}' WHERE useremail='{$email}'");
        $_SESSION['user_email'] = $email;
        if ($query) {
            $mail = new PHPMailer(true);
            try {
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
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
                $mail->Subject = 'Forgot Your Password';
                $templatePath = "mail/forgetpass.html";
                $templateContent = file_get_contents($templatePath);

                $templateContent = str_replace("{username}", $email, $templateContent);
                $templateContent = str_replace("{resetpass_link}", "$domain/change-password.php?reset=$code", $templateContent);

                $mail->Body = $templateContent;

                $mail->send();
                "mail sent";
            } catch (Exception $e) {
                "Mailer Error: {$mail->ErrorInfo}";
            }

            $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>$email - This email address do not found.</div>";
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>

    <title>Password Recovery - MyPoetry.in</title>
    <meta name="title" content="Password Recovery - MyPoetry.in">
    <meta name="description"
        content="Initiate the password recovery process on MyPoetry.in. Follow the simple steps to reset your password and regain access to your account. Securely recover your account and resume your poetic journey effortlessly.">
    <meta name="keywords"
        content="Password Recovery, Forgot Password, MyPoetry.in, account access, reset password, account recovery, poetic journey">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/password-recovery.php">
    <meta property="og:title" content="Password Recovery - MyPoetry.in">
    <meta property="og:description"
        content="Initiate the password recovery process on MyPoetry.in. Follow the simple steps to reset your password and regain access to your account. Securely recover your account and resume your poetic journey effortlessly.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/password-recovery.php">
    <meta property="twitter:title" content="Password Recovery - MyPoetry.in">
    <meta property="twitter:description"
        content="Initiate the password recovery process on MyPoetry.in. Follow the simple steps to reset your password and regain access to your account. Securely recover your account and resume your poetic journey effortlessly.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/password-recovery.php">



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
                    <h1>Email Recovery 📧</h1>
                    <p>Enter your registered email for recovery instructions</p>

                </div>
                <form class="my-form" method="post">
                    <?php echo $msg; ?>
                    <div class="text-field">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Your Email" required>
                        <img alt="Email Icon" title="Email Icon" src="source/login/email.svg">
                    </div>
                    <button type="submit" class="my-form__button" name="recover_email"> Send Mail</button>

                    <div class="my-form__actions">

                        <div class="my-form__signup">
                            <a href="login.php" title="Create Account">
                                Ahh, I Remember my Password.
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="info-side">
            <img src="source/login/recoveremail.svg" alt="Mock" class="mockup">
            <div class="welcome-message">
                <h1>Recover Email &#x1F44F;</h1>
                <p>Enter your registered email address below, and we'll send you instructions on how to recover your
                    email.</p>

            </div>
        </div>
    </div>
    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
</body>

</html>