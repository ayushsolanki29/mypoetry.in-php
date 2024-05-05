<?php
include 'php/config.php';
session_start();
if (!isset($_SESSION['access_token'])) {
    echo "<script>alert('Access Denied')</script>";
    echo "<script>alert('Redirect to Home Page')</script>";
    echo "<script>window.location.href = 'https://mypoetry.in';</script>";
    exit();
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';
function redirect($messageType)
{
    header("Location: payment.php?message=$messageType");
    exit();
}

if (isset($_POST['paid-btn'])) {
    $txt_id = $_POST['txt_id'];
    $amount = $_POST['amount'];

    $txt_id = mysqli_real_escape_string($con, $txt_id);

    $update1 = "UPDATE `poetry_delivery` SET `payment_status`='Paid' WHERE txt_id='$txt_id'";
    $result_update1 = mysqli_query($con, $update1);

    $update2 = "UPDATE `payment-details` SET `txt_status`='Paid' WHERE txt_id='$txt_id'";
    $result_update2 = mysqli_query($con, $update2);

    $messageType = ($result_update1 && $result_update2) ? 'success' : 'danger';
    $_SESSION['message'] = ($result_update1 && $result_update2) ? 'Payment Complete!!' : 'Fail Something Wrong!!';

    $user_id = $_POST['user_id'];
    $user_email = $_POST['email'];
    $full_name = $_POST['fullname'];

    $select = "SELECT `username`, `useremail` FROM `users` WHERE user_id=$user_id";
    $result_select = mysqli_query($con, $select);

    $select_amount = "SELECT `data-value` FROM `settings` WHERE id='3'";
    $amount_result_select = mysqli_query($con, $select_amount);

    if ($amount_result_select && $row = mysqli_fetch_assoc($amount_result_select)) {
        $data_value = $row['data-value'];
        $data_value_new = $data_value + $amount;

        $update_amount = "UPDATE `settings` SET `data-value`='$data_value_new' WHERE id='3'";
        $result_update = mysqli_query($con, $update_amount);

        if (!$result_update) {
            die("Update failed: " . mysqli_error($con));
        }
    }



    if ($result_select && $row = mysqli_fetch_assoc($result_select)) {
        $name = $row['username'];
        $email = $row['useremail'];


        $subject = "Your Payment is Done";
        $message = "Thanks For Purchasing";
        $status_color = "Green";
        $status_text = "Paid";

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
            $mail->addAddress($email);

            // Send email
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $templatePath = "mail/payment.html";
            $templateContent = file_get_contents($templatePath);
            $templateContent = str_replace(["{username}", "{status-color}", "{status-text}", "{message}"], [$name, $status_color, $status_text, $message], $templateContent);
            $mail->Body = $templateContent;
            $mail->send();

            $_SESSION['message'] = 'Payment Complete!! & Mail Sent';
            $messageType = "success";
        } catch (Exception $e) {
            $_SESSION['message'] = 'Payment Complete!! & Failed to send mail';
            $messageType = "danger";
        }

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
    <title>Payment Page</title>
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
                        <h3>Payment Details</h3>
                        <?php $query = "SELECT COUNT(*) as total_entries FROM  `payment-details`";
                        $total_rows = mysqli_query($con, $query);
                        $total_rows = mysqli_fetch_assoc($total_rows);
                        echo '<span> Total :' . $total_rows["total_entries"] . ' </span>'; ?>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>UPI ID</th>
                                <th>Screenshot</th>
                                <th>Amount</th>
                                <th>Plan</th>
                                <th>Date</th>
                                <th>Payment ID</th>
                                <th colspan="3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                if (isset($_GET['search'])) {
                                    $txt_id = $_GET['search'];
                                    $query = "SELECT * FROM `payment-details` WHERE txt_id='$txt_id'";

                                } else {
                                    $query = "SELECT * FROM `payment-details` ORDER BY 
                                    CASE 
                                      WHEN txt_status = 'pending' THEN 0
                                      ELSE 1
                                    END,
                                    `id` DESC;
                                ";
                                }

                                $result = mysqli_query($con, $query);

                                if (!$result) {
                                    die("Query failed: " . mysqli_error($con));
                                }

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>


                                        <td>
                                            <p>
                                                <?php echo $row['fullname']; ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                <?php echo $row['txt_status']; ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                <?php echo $row['upi_id']; ?>
                                            </p>
                                        </td>
                                        <?php if (!empty($row['screenshot'])) { ?>
                                            <td><a href="<?php echo $domain . '/' . $row['screenshot']; ?>">Show Sreenshot</a>
                                            </td>

                                        <?php } else {
                                            echo "<td>No IMG</td>";
                                        } ?>
                                        <td>
                                            <p>
                                                <?php echo $row['paid_amount'] . "&#8377;"; ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                <?php echo $row['delivery_pan']; ?>
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
                                        <td>
                                            <p>
                                                <?php echo $row['txt_id']; ?>
                                            </p>
                                        </td>
                                        <td class="d-flex">
                                            <?php if ($row['txt_status'] == "Pending") { ?>
                                                <form action="" method="post">
                                                    <input type="hidden" value="<?php echo $row['txt_id']; ?>" name="txt_id">
                                                    <input type="hidden" value="<?php echo $row['user_id']; ?>" name="user_id">
                                                    <input type="hidden" value="<?php echo $row['email']; ?>" name="email">
                                                    <input type="hidden" value="<?php echo $row['fullname']; ?>" name="fullname">
                                                    <input type="hidden" value="<?php echo $row['paid_amount']; ?>" name="amount">
                                                    <button type="submit" name="paid-btn" class="status process">Paid</button>
                                                </form>
                                            <?php } ?>
                                            <?php if ($row['txt_status'] != "Pending") { ?>
                                                <form action="send-poetry.php" method="get">
                                                    <input type="hidden" value="<?php echo $row['txt_id']; ?>" name="txt_id">
                                                    <button type="submit" name="" class="status completed">Create</button>
                                                </form>
                                            <?php } ?>



                                    </tr>
                                    <?php
                                    }
                                } else {
                                    echo "<td>
                                    <p>
                                        <?php echo 'No Transition Found' ?>
                                    </p>
                                </td>";
                                } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script>
        function hideMessage() {
            window.location.href = "payment.php";
        }

    </script>
    <script src="scripts/index.js"></script>
</body>

</html>