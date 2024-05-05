<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$msg = "";

include 'auth/config.php';

if (isset($_GET['reset'])) {
    if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
        if (isset($_POST['changepassword'])) {
            $password = mysqli_real_escape_string($con, md5($_POST['password']));
            $confirm_password = mysqli_real_escape_string($con, md5($_POST['confirm-password']));
          
            $bcrpassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
           

            if ($password === $confirm_password) {
                $query = mysqli_query($con, "UPDATE users SET userpassword='{$bcrpassword}', code='' WHERE code='{$_GET['reset']}'");

                if ($query) {
                    $mail = new PHPMailer(true);
                    $email = $_SESSION['user_email'];
                    try {
                        //Server settings
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
                        $mail->Subject = 'Password changed Successfull';
                        $templatePath = "mail/Success.html";
                        $templateContent = file_get_contents($templatePath);

                        $templateContent = str_replace("{username}", $email, $templateContent);
                        $templateContent = str_replace("{activation_link}", "$domain", $templateContent);

                        $mail->Body = $templateContent;

                        $mail->send();
                        "mail sent";
                    } catch (Exception $e) {
                        "Mailer Error: {$mail->ErrorInfo}";
                    }
                    header("Location: login.php?msg=Password Changed successfull");
                    exit();
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>Reset Link do not match.</div>";
    }
} else {
    header("Location: password-recovery.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>
    <title>Change Password - Securely Update Your Account Password</title>
    <meta name="title" content="Change Password - Securely Update Your Account Password">
    <meta name="description"
        content="Enhance your account security with the Change Password feature. Safely update and strengthen your password to ensure the protection of your personal information on Mypoetry.in.">
    <meta name="keywords"
        content="Change Password, Update Password, Account Security, Password Update, Mypoetry.in, Secure Login, Password Strength">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/change-password.php">
    <meta property="og:title" content="Change Password - Securely Update Your Account Password">
    <meta property="og:description"
        content="Enhance your account security with the Change Password feature. Safely update and strengthen your password to ensure the protection of your personal information on Mypoetry.in.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/change-password.php">
    <meta property="twitter:title" content="Change Password - Securely Update Your Account Password">
    <meta property="twitter:description"
        content="Enhance your account security with the Change Password feature. Safely update and strengthen your password to ensure the protection of your personal information on Mypoetry.in.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/change-password.php">

    <?php include 'pages/links.html'; ?>
    <link rel="stylesheet" href="styles/login.css">
</head>

<body class="sub_page">

    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="navabr">
        </div>
        <?php include 'pages/navbar.html' ?>
    </div>
    <div class="login-wrapper">
        <div class="login-side">
            <div class="my-form__wrapper">
                <div class="login-welcome-row">
                    <h1>Change Password</h1>
                    <p>Secure your account by updating your password below.</p>
                </div>
                <form class="my-form" method="post">
                    <?php echo $msg; ?>
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
                    <input type="submit" class="my-form__button" name="changepassword" value="Change Password">
                    <div class="my-form__actions">

                        <div class="my-form__signup">
                            <a href="login.php" title="Create Account">
                                No, I Change my Mind!
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="info-side">
            <img src="source/login/changepassword.svg" alt="Mock" class="mockup">
            <div class="welcome-message">
                <h2>Change Your Password 🔐</h2>
                <p>Update your account password to ensure security and continued access to your account.</p>
            </div>
        </div>
    </div>
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
    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
</body>

</html>