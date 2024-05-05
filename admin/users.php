<?php
include 'php/config.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';

if (!isset($_SESSION['access_token'])) {
    echo "<script>alert('Access Denied')</script>";
    echo "<script>alert('Redirect to Home Page')</script>";
    echo "<script>window.location.href = 'https://mypoetry.in';</script>";
    exit();
}
function redirect($messageType)
{
    header("Location: users.php?message=$messageType");
    exit();
}

if (isset($_POST['active-btn'])) {
    $id = $_POST['id'];
    $update = "UPDATE `users` SET `status`='active' WHERE user_id=$id";
    $result = mysqli_query($con, $update);
    $messageType = $result ? 'success' : 'danger';
    $_SESSION['message'] = $result ? 'User Activeted!!' : 'Activition Fail Something Wrong!!';
    redirect($messageType);
}
if (isset($_POST['delete-btn'])) {
    $id = $_POST['id'];
    $update = "DELETE FROM `users` WHERE user_id=$id";
    $result = mysqli_query($con, $update);
    $messageType = $result ? 'success' : 'danger';
    $_SESSION['message'] = $result ? 'User Deleted!!' : 'Delete Fail Something Wrong!!';
    redirect($messageType);
}

if (isset($_POST['send-mail'])) {
    $mail_active = true;
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['useremail'] = $_POST['useremail'];
}
if (isset($_POST['send-message'])) {
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    try {

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'mail.mypoetry.in';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@mypoetry.in';
        $mail->Password = 'Oigv4F24m6';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('admin@mypoetry.in', 'mypoetry.in');
        $mail->addAddress($_SESSION['useremail']);

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $templatePath = "mail/send-msg.html";
        $templateContent = file_get_contents($templatePath);

        $templateContent = str_replace("{username}", $_SESSION['username'], $templateContent);
        $templateContent = str_replace("{subject}", $subject, $templateContent);
        $templateContent = str_replace("{message}", $message, $templateContent);
        $mail->Body = $templateContent;

        $mail->send();
        $_SESSION['message'] = 'Mail Sended';
        $messageType = "success";

    } catch (Exception $e) {
        $_SESSION['message'] = 'Fail To send';
        $messageType = "danger";
    }
    redirect($messageType);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php include 'php/favicon.html' ?>
    <title>Users</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/top3.css" />
    <link rel="stylesheet" href="styles/style.css" />
</head>

<body>

    <?php include 'php/slidebar.php'; ?>
    <?php
    if (isset($_SESSION['message'], $_GET['message'])):
        $messageClass = $_GET['message'];
        $messageText = $_SESSION['message'];
        ?>
        <div class="message" style="z-index:111px;">
            <div class="info <?= $messageClass ?>">
                <div class="info__icon">
                    <i class='bx bxs-info-circle'></i>
                </div>
                <div class="info__title">
                    <?= $messageText ?>
                </div>
                <div class="info__close" onclick="hideMessage()"><i class='bx bx-x-circle'></i></div>
            </div>
        </div>
    <?php endif; ?>
    <div class="content">
        <main>

            <div class="bottom-data">

                <div class="orders">
                    <div class="header">

                        <i class='bx bx-receipt'></i>

                        <h3>Users</h3>

                        <?php $query = "SELECT COUNT(*) as total_entries FROM users";
                        $total_rows = mysqli_query($con, $query);
                        $total_rows = mysqli_fetch_assoc($total_rows);
                        echo '<span> Total :' . $total_rows["total_entries"] . ' </span>'; ?>
                    </div>
                    <table>

                        <thead>
                            <tr>
                                <th>UserName</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Profile</th>
                                <th>Login Date</th>
                                <th>User Status</th>
                                <th colspan="4">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <?php
                                $query = "SELECT * FROM `users` ORDER BY `users`.`user_id` DESC";
                                $result = mysqli_query($con, $query);


                                if (!$result) {
                                    die("Query failed: " . mysqli_error($con));
                                }
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>


                                    <td>
                                        <p>
                                            <?php echo $row['username']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $row['useremail']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $row['logintype']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <?php if ($row['logintype'] == "Google") {
                                            ?>
                                            <a href="<?php echo $row['userprofile']; ?>">

                                                <img src="<?php echo $row['userprofile']; ?>"
                                                    alt="<?php echo $row['username']; ?>">
                                            </a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="<?php echo $domain . '/' . $row['userprofile']; ?>">
                                                <img src="<?php echo $domain . '/' . $row['userprofile']; ?>"
                                                    alt="<?php echo $row['username']; ?>">
                                            </a>
                                            <?php
                                        } ?>

                                    </td>
                                    <td>
                                        <p title="<?php echo $row['registerdate'] ?>">

                                            <?php $ratingDate = strtotime($row['registerdate']);
                                            $currentDate = time();
                                            $differenceInSeconds = $currentDate - $ratingDate;
                                            $differenceInDays = floor($differenceInSeconds / (60 * 60 * 24));
                                            if ($differenceInDays == 0) {
                                                echo 'Today';
                                            } elseif ($differenceInDays == 1) {
                                                echo 'Yesterday';
                                            } elseif ($differenceInDays <= 60) {
                                                echo $differenceInDays . ' days ago';
                                            } else {
                                                $differenceInWeeks = ceil($differenceInDays / 7);
                                                echo $differenceInWeeks . ' weeks ago';
                                            } ?>
                                        </p>
                                      
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $row['status']; ?>
                                        </p>
                                    </td>

                                    <td class="d-flex">
                                        <form method="Post">
                                            <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                                            <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                                            <input type="hidden" name="useremail" value="<?php echo $row['useremail']; ?>">
                                            <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                                            <button type="submit" name="send-mail" class="status process"> Send
                                                Mail</button>

                                        </form>
                                        <?php if ($row['status'] != "active") { ?>
                                            <form method="Post">
                                                <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                                                <button type="submit" onclick="togglePopup()" class="status light-success"
                                                    name="active-btn">Active</button>
                                            </form>
                                        <?php } ?>

                                        <form action="" method="post">
                                            <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                                            <button type="submit" name="delete-btn" class="status delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <?php if (isset($mail_active)) {
        ?>
        <div id="popup" class="popup-container">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h2>Send Message</h2>

                <!-- Input and Textarea -->
                <form method="post">
                    <label for="name">Subject</label>
                    <input type="text" id="name" name="subject" placeholder="Enter Subject" required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" placeholder="Enter Message" rows="4" required></textarea>

                    
                    <div class="btn-container">
                        <button class="btn" name="send-message" type="submit">Send</button>
                        <button class="btn cencel" type="button" onclick="togglePopup()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    } ?>

    <script>
        function togglePopup() {
            var popup = document.getElementById('popup');
            popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'flex' : 'none';
            window.location.href = "users.php";
        }
    </script>
    <script>
        function hideMessage() {
            window.location.href = "users.php";
        }

    </script>
    <script src="scripts/index.js"></script>
</body>

</html>