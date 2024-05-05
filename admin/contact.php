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
    header("Location: contact.php?message=$messageType");
    exit();
}
if (isset($_POST['send-mail'])) {
    $mail_active = true;
    $_SESSION['contactname'] = $_POST['name'];
    $_SESSION['contactemail'] = $_POST['email'];
    $_SESSION['contactquery'] = $_POST['query'];
}
if (isset($_POST['get-details'])) {
    $viewbtn_Active = true;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $problem = $_POST['query'];
    $message = $_POST['message'];
    $date = $_POST['date'];
    $img = $_POST['img'];
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
        $mail->addAddress($_SESSION['contactemail']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $templatePath = "mail/send-msg.html";
        $templateContent = file_get_contents($templatePath);

        $templateContent = str_replace("{username}", $_SESSION['contactname'], $templateContent);
        $templateContent = str_replace("{subject}", $subject, $templateContent);
        $templateContent = str_replace("{message}", $message, $templateContent);
        $mail->Body = $templateContent;

        $mail->send();
        $_SESSION['message'] = 'Reply Sended';
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
    <title>Contact Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/top3.css" />
    <link rel="stylesheet" href="styles/style.css" />
</head>

<body>

    <?php include 'php/slidebar.php';
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
                        <h3>Contact</h3>
                        <?php $query = "SELECT COUNT(*) as total_entries FROM contact";
                        $total_rows = mysqli_query($con, $query);
                        $total_rows = mysqli_fetch_assoc($total_rows);
                        echo '<span> Total :' . $total_rows["total_entries"] . ' </span>'; ?>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Quiery</th>
                                <th>Additional</th>
                                <th>Screenshot</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th colspan="2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $query = "SELECT * FROM `contact` ORDER BY `contact`.`id` DESC";
                                $result = mysqli_query($con, $query);


                                if (!$result) {
                                    die("Query failed: " . mysqli_error($con));
                                }
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>

                                    <td>
                                        <p>
                                            <?php echo $row['name']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p title="<?php echo $row['email']; ?>">
                                            <?php
                                            $details = $row['email'];
                                            $trimmedDetails = strlen($details) > 7 ? substr($details, 0, 7) . '...' : $details;
                                            echo $trimmedDetails;
                                            ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $row['quiery']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $row['additional']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <?php
                                        echo $row['quiery'] == "bugreport" ? "<img src=\"$domain/{$row['screenshot']}\" alt=\"{$row['name']}\">" : "No Img";
                                        ?>
                                    </td>
                                    <td>
                                        <p title="<?php echo $row['message']; ?>">
                                            <?php
                                            $details = $row['message'];
                                            $trimmedDetails = strlen($details) > 30 ? substr($details, 0, 30) . '...' : $details;
                                            echo $trimmedDetails;
                                            ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p title="<?php echo $row['date'] ?>">

                                            <?php $ratingDate = strtotime($row['date']);
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

                                    <td class="d-flex">
                                        <form method="post">
                                            <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                            <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                            <input type="hidden" name="query"
                                                value="<?= $row['quiery'] == 'other' ? $row['additional'] : $row['quiery']; ?>">
                                            <button type="submit" name="send-mail" class="status process"> Send
                                                Reply</button>
                                        </form>
                                        <form method="post">
                                            <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                            <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                            <input type="hidden" name="message" value="<?php echo $row['message']; ?>">
                                            <input type="hidden" name="date" value="<?php echo $row['date']; ?>">
                                            <input type="hidden" name="query"
                                                value="<?= $row['quiery'] == 'other' ? $row['additional'] : $row['quiery']; ?>">
                                            <input type="hidden" name="img"
                                                value="<?php echo $row['quiery'] == "bugreport" ? "$domain/{$row['screenshot']}" : "No Img"; ?>">
                                            <input type="hidden" name="query"
                                                value="<?= $row['quiery'] == 'other' ? $row['additional'] : $row['quiery']; ?>">
                                            <button type="submit" name="get-details" class="status completed">View
                                                Details</button>

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

                <form method="post">
                    <label for="name">Subject</label>
                    <input type="text" id="name" name="subject"
                        value="<?php echo 'Reply to ' . $_SESSION['contactquery'] . ' Query' ?>" placeholder="Enter Subject"
                        required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" placeholder="Enter Message" rows="4" required></textarea>

                    <!-- Buttons -->
                    <div class="btn-container">
                        <button class="btn" name="send-message" type="submit">Send</button>
                        <button class="btn cencel" type="button" onclick="togglePopup()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    } ?>
    <?php if (isset($viewbtn_Active)) {
        ?>
        <div id="popup" class="popup-container">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h2>
                    <?php echo $name . "'s Query" ?>
                </h2><br>
                <p> <b>Email :</b>
                    <?php echo $email ?>
                </p>
                <p> <b>Query :</b>
                    <?php echo $problem ?>
                </p>
                <p><b>Image :</b>
                    <?php if ($img == "No Img") {
                        echo "Not Availbale Screenshot";
                    } else {
                        ?> <a href="<?php echo $img ?>"> <img src="<?php echo $img ?>" height="20px" width="100px"
                                alt="<?php echo $name ?>">
                            <?php
                    }
                    $img ?>
                    </a>
                </p><br>
                <p><b>Message : </b>
                    <?php echo $message ?>
                </p><br>
                <p><b>Date :</b>
                    <?php echo $date ?>
                </p>
                <form method="post">
                    <input type="hidden" name="name" value="<?php echo $name ?>">
                    <input type="hidden" name="email" value="<?php echo $email ?>">
                    <input type="hidden" name="query" value="<?php echo $problem ?>">

                    <div class="btn-container" style="justify-content: space-evenly; margin-top:10px;">
                        <button class="btn" name="send-mail" type="submit">Send Reply</button>
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
            window.location.href = "contact.php";
        }
    </script>
    <script>
        function hideMessage() {
            window.location.href = "contact.php";
        }

    </script>
    <script src="scripts/index.js"></script>
</body>

</html>