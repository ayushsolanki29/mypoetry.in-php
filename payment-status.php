<?php
session_start();
include "auth/config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "sended") {
        $msg = "<div class='alert alert-success mt-3' role='alert'>All details have been sent to your email. Please check your inbox.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Mail Not Sended. Something went wrong</div>";
    }
} else {
    $msg = "";
}

if (isset($_POST['sharepaymentss'])) {
    $txt_id = $_POST['txt_id'];
    if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === 0) {
        $filename = $_FILES['screenshot']['name'];
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        $valid_extensions = ['png', 'jpg', 'jpeg'];

        if (in_array(strtolower($file_ext), $valid_extensions)) {
            $destfile = 'source/payment_screenshot/' . $txt_id . '.' . $file_ext;
            move_uploaded_file($_FILES['screenshot']['tmp_name'], $destfile);
            $update = "UPDATE `payment-details` SET `screenshot`='$destfile' WHERE txt_id='$txt_id'";
            $result = mysqli_query($con, $update);
            if ($result) {
                $msg = "<div class='alert alert-success'>Screenshot Uploaded</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Screenshot Not Uploaded</div>";
            }
        } else {
            $msg = "<div class='alert alert-warning'>Only supported extensions are JPG, PNG, JPEG.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>File Uploading Erorr</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status - MyPoetry.in</title>
    <meta name="title" content="Payment Status - MyPoetry.in">
    <meta name="description"
        content="Check the status of your payment on MyPoetry.in. Stay updated on your subscription, purchase, or transaction details.">
    <meta name="keywords" content="Payment Status, MyPoetry.in, Subscription, Purchase, Transaction Details">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/payment-status.php">
    <meta property="og:title" content="Payment Status - MyPoetry.in">
    <meta property="og:description"
        content="Check the status of your payment on MyPoetry.in. Stay updated on your subscription, purchase, or transaction details.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/payment-status.php">
    <meta property="twitter:title" content="Payment Status - MyPoetry.in">
    <meta property="twitter:description"
        content="Check the status of your payment on MyPoetry.in. Stay updated on your subscription, purchase, or transaction details.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/payment-status.php">
    <link rel="stylesheet" href="styles/pricing.css">
    <?php include 'pages/meta.html' ?>
    <?php include 'pages/links.html'; ?>
</head>


<body class="sub_page">
    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="navabr">
        </div>
        <?php include 'pages/navbar.html' ?>
    </div>
    <div class="container">
        <section class="landing-page-section">
            <h2>Check Your Payment <span class="gradient-text">Status</span></h2>
        </section>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <form method="post" class="mt-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="orderID" placeholder="Enter your order ID"
                                required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" name="checkOrderID" type="submit">Check Status</button>
                            </div>
                        </div>
                        <?php if (isset($_POST['checkOrderID'])) {
                            $_SESSION['txt-id'] = $_POST['orderID'];
                            echo "<script>window.location.href = 'payment-status.php'</script>";
                        } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">


        <?php
        if (isset($_SESSION['txt-id'])) {
            if (isset($_SESSION['txt-id'])) {
                $txs_id = ($_SESSION['txt-id']);
            } else {
                $txs_id = "0";
            }

            $sql = "SELECT * FROM  `payment-details` WHERE txt_id='$txs_id'";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc(); ?>
                <div class="row">
                    <?php if ($row['txt_status'] === "Pending") {
                        ?>
                        <div class="col-md-6">
                            <div class="card text-white bg-warning ">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Status : Pending</h5>
                                    <p class="card-text">
                                    <ol>
                                        <li>Your payment is pending. Please wait for further updates. Must check Your
                                            Email</li>
                                        <li>We work on your payment processing.</li>
                                    </ol>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    } elseif ($row['txt_status'] === "Paid") {
                        ?>
                        <div class="col-md-6">
                            <div class="card text-white bg-success ">
                                <div class="card-body">
                                    <h5 class="card-title">Payment Successful</h5>
                                    <p class="card-text">
                                    <p> Thank you for your purchase!</p>
                                    <hr>
                                    <p class="mb-0">If you have any questions or concerns, please <a
                                            href="contact-us.php">contactus</a> </p>
                                    </p>
                                </div>
                            </div>

                        </div>
                        <?php
                    }


                    if ($row['txt_status'] === "Paid" || $row['txt_status'] === "Pending") { ?>

                        <div class="col-md-6 mt-2">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Check Email for Updates </h5>
                                    <p class="card-text">
                                    <ol>
                                        <li>Check your email regularly for updates.</li>
                                        <li>Please take a screenshot of the payment details for future reference in case of
                                            problems.</li>
                                    </ol>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            }
        }
        echo $msg; ?>

        <div class="row mt-4">
            <?php
            if (isset($_SESSION['txt-id'])) {
                $txs_id = ($_SESSION['txt-id']);
            } else {
                $txs_id = "0";
            }

            $sql = "SELECT * FROM  `payment-details` WHERE txt_id='$txs_id'";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>

                <div class="col-md-6">
                    <h2>Payment Details</h2>
                    <table class="table" id="pdfContent">
                        <tr>
                            <th>TXN ID</th>
                            <td>
                                <?php echo $row['txt_id']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>TXN Status</th>
                            <td>
                                <?php echo $row['txt_status']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Full Name</th>
                            <td>
                                <?php echo $row['fullname']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <?php echo $row['email']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>UPI ID</th>
                            <td>
                                <?php echo $row['upi_id']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>
                                <?php echo $row['phone']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Payment Type</th>
                            <td>
                                <?php echo $row['txt_type']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Paid Ammount</th>
                            <td>
                                <?php echo $row['paid_amount'] . ' <i class="fa-solid fa-indian-rupee-sign"></i>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Choosed Plan</th>
                            <td>
                                <?php echo $row['delivery_pan']; ?>
                            </td>
                        </tr>
                        <?php if (!empty($row['screenshot'])) { ?>
                            <tr>
                                <th>Screenshot </th>
                                <td><a href="<?php echo $row['screenshot']; ?>" download>Get Sreenshot</a>

                                </td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <th>Purchase Date</th>
                            <td>
                                <?php echo $row['date']; ?>
                            </td>
                        </tr>
                    </table>
                    <div class="d-flex">
                        <div class="m-3">
                            <button type="button" onclick="generatePDF()" class="btn btn-success">
                                <i class="fa-regular fa-file-pdf"></i> Generate PDF
                            </button>
                            <script>
                                function generatePDF() {
                                    alert("Sorry Can't Download PDF");
                                }
                            </script>
                        </div>
                        <div class="m-3">
                            <form method="post">
                                <button type="submit" name="sendMail" class="btn btn-primary"
                                    title="<?php echo "Send All Details to This Mail " . $row['email'] ?>">
                                    <i class="fa-regular fa-envelope"></i> Send to Mail
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mb-3 ml-5">
                <?php if (empty($row['screenshot'])) { ?>
                    <form enctype="multipart/form-data" method="post">
                        <h3>Upload Payment Screenshot</h3>
                        <p>Why share a screenshot of the payment?</p>
                        <ul style="list-style:none;">
                            <li><span class="text-success">Verify:</span> Payment Details Verification</li>
                            <li>
                                <spa class="text-success">Fast Approval:</spa> Speeds up the approval process
                            </li>
                        </ul>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileInput"
                                accept="image/png, image/jpeg, image/jpg" name="screenshot">
                            <label class="custom-file-label" for="fileInput">Select Payment Screenshot</label>
                        </div>
                        <input type="hidden" name="txt_id" value="<?php echo $row['txt_id']; ?>">
                        <button type="submit" name="sharepaymentss" class="btn btn-primary mt-3">Send</button>
                    </form>
                    <?php } ?>
                </div>
                <?php
                if (isset($_POST['sendMail']) || isset($_SESSION['send-mail'])) {
                    $emailContent = $name = $row['fullname'];
                    $paymentStatus = $row['txt_status'];

                    echo "<div>";
                    $emailContent = "<h2>Hi <b>$name</b>,</h2>";
                    $emailContent .= "<p>Thank you for your payment!</p><br>";
                    $emailContent .= "Your payment status is:<b> $paymentStatus.</b><br>";
                    $emailContent .= "Below are your order details:<br>";
                    $emailContent .= "-------------------------------------<br>";
                    $emailContent .= "<b>Order ID</b>: {$row['txt_id']}<br>";
                    $emailContent .= "<b>Product</b>: {$row['delivery_pan']} Package<br>";
                    $emailContent .= "<b>UPI ID</b>: {$row['upi_id']}<br>";
                    $emailContent .= "<b>Payment Amount</b>: {$row['paid_amount']} INR<br>";
                    $emailContent .= "<b>Transaction Type</b>: {$row['txt_type']}<br>";
                    if (!empty($row['screenshot'])) {
                        $emailContent .= "<b>Screenshot </b>: <a href=\"{$domain}/{$row['screenshot']}\" download>Get Screenshot</a><br>";
                    }                    
                    $emailContent .= "<b>Purchase Date</b>: {$row['date']}<br>";
                    $emailContent .= "-------------------------------------<br><br>";
                    $emailContent .= "If you have any questions or concerns, please feel free to <a href='$domain/contact-us.php'> contact us.</a><br>";
                    $emailContent .= "Thank you for choosing our services!<br><br>";
                    $emailContent .= "Best regards,<br> <b>The MyPoetry Team</b>";
                    echo "</div>";

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
                        $email = $row['email'];
                        $mail->addAddress($email);
                        $txt_id = $row['txt_id'];

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = "Payment Details for Transaction ID '$txt_id'";
                        $mail->Body = $emailContent;
                        $mail->send();
                        echo "<script>window.location.href = 'payment-status.php?msg=sended'</script>";
                        unset($_SESSION['send-mail']);
                    } catch (Exception $e) {
                        echo "<script>window.location.href = 'payment-status.php?msg=sended'</script>";
                        unset($_SESSION['send-mail']);
                    }
                }
            } else {
                ?>
                <div class="container">
                    <div class="alert alert-danger">
                        <p>
                            <?php echo "No payment details found on this Transaction ID"; ?>
                        </p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    </div>
    </div>

    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>

</body>

</html>