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

$delevery_type = 'normal';
function redirect($messageType, $whatapp_send)
{
  header("Location: send-poetry.php?message=$messageType&whatsapp-send=$whatapp_send");
  exit();
}

if (isset($_GET['txt_id'])) {
  $_SESSION['txt-id'] = $_GET['txt_id'];
}

if (isset($_SESSION['txt-id'])) {
  $txt_id = $_SESSION['txt-id'];

  $paymentQuery = "SELECT `email`, `phone`,`fullname` FROM `payment-details` WHERE txt_id='$txt_id'";
  $paymentResult = mysqli_query($con, $paymentQuery);
  $paymentRow = mysqli_fetch_assoc($paymentResult);

  if ($paymentRow) {
    $email = $paymentRow['email'];
    $phone = $paymentRow['phone'];
    $fullname = $paymentRow['fullname'];
  }

  $poetryQuery = "SELECT `delevery_type`, `person_name`, `language`, `relation_status`, `payment_status`, `person_img`, `date` FROM `poetry_delivery` WHERE txt_id='$txt_id'";
  $poetryResult = mysqli_query($con, $poetryQuery);

  if ($poetryResult && mysqli_num_rows($poetryResult) > 0) {
    $poetryRow = mysqli_fetch_assoc($poetryResult);

    $delevery_type = $poetryRow['delevery_type'];
    $person_name = $poetryRow['person_name'];
    $language = $poetryRow['language'];
    $relation_status = $poetryRow['relation_status'];
    $payment_status = $poetryRow['payment_status'];
    $person_img = $poetryRow['person_img'];
    $date = $poetryRow['date'];
  } else {

  }
}

if (isset($_POST['poetry-email']) || isset($_POST['poetry-whatsapp'])) {
  $poetry_text = $_POST['poetry-text'];
  $name = $_POST['name'];
  $plan = $_POST['delevery_type'];
  $TXS_ID = $_POST['txt_id'];
  $email = $_POST['email'];
  $destfile = '';

  // Handle file upload
  if (isset($_FILES['poetry-file']) && $_FILES['poetry-file']['error'] === 0) {
    $valid_extensions = ['png', 'jpg', 'jpeg','mp4','mp3','mkv'];
    $file_ext = strtolower(pathinfo($_FILES['poetry-file']['name'], PATHINFO_EXTENSION));

    if (in_array($file_ext, $valid_extensions)) {
      $destfile = 'source/sended-poetry/' . $TXS_ID . '.' . $file_ext;
      move_uploaded_file($_FILES['poetry-file']['tmp_name'], $destfile);
    }
  }

  $date = date("Y-m-d H:i:s");

  $stmt = $con->prepare("INSERT INTO `sended-poetry` (`name`, `poetry`, `ordered_plan`, `txt_id`, `date`, `poetry-file`) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $name, $poetry_text, $plan, $TXS_ID, $date, $destfile);
  $result = $stmt->execute();
  $stmt->close();

  if ($result) {
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
      $subject = "Your Order is Ready";
      // Content
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $templatePath = "mail/send-poetry.html";
      $templateContent = file_get_contents($templatePath);
      $templateContent = str_replace(["{username}", "{message}"], [$name, $poetry_text], $templateContent);
      $mail->Body = $templateContent;
      $mail->send();

      $_SESSION['message'] = 'Poetry saved and Mail Sent';
      $messageType = "success";
    } catch (Exception $e) {
      $_SESSION['message'] = 'Poetry saved but Failed to send mail';
      $messageType = "danger";
    }
    $whatapp_send = "false";
    if (isset($_POST['poetry-whatsapp'])) {
      $_SESSION['whatsapp'] = "https://wa.me/{$phone}?text=Hello%2C+Ayush%21%0AWe+are+From+mypoetry.in.+You+Placed+Order+For+Poetry.%0A-----YOUR+ORDER+IS+READY-----%0A{$poetry_text}%0A----- *Your+file+is+here* -----%0Ahttps://admin.mypoetry.in/{$destfile}";
      $_SESSION['message'] = 'Poetry saved & Sended message';
      $messageType = "success";
      $whatapp_send = "true";
    }
  }

  redirect($messageType, $whatapp_send);
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <?php include 'php/favicon.html' ?>
  <title>Send Poetry</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="styles/top3.css" />
  <link rel="stylesheet" href="styles/style.css" />
  <style>
    .card {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      width: 500px;
      max-width: 100%;
    }

    .card img {
      width: 100%;
      height: auto;
    }

    .card-content {
      padding: 16px;
    }

    .name {
      font-size: 1.2em;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .details {
      color: #555;
    }

    .text-center {
      text-align: center;
    }

    .whatsappsend {
      color: blue;
    }
  </style>
</head>

<body>

  <?php include 'php/slidebar.php'; ?>
  <div class="top3container d-flex">

    <?php
    if (isset($_SESSION['message'], $_GET['message'])):
      $messageClass = $_GET['message'];
      $messageText = $_SESSION['message'];
      ?>
      <div class="message">
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
    <?php endif; ?><br>
    <?php
    if (isset($_GET['txt_id']) || isset($_SESSION['txt-id'])) {
      ?>
      <div class="card">
        <?php
        $person_img = 'https://mypoetry.in/' . $person_img;

        $display_img = !empty($person_img) ? $person_img : 'https://mypoetry.in/source/og-image.png';
        ?>

        <a href="<?php echo $display_img; ?>"><img src="<?php echo $display_img; ?>" alt="Person Image"> </a>

        <div class="card-content">
          <div class="name">
            <?php echo $person_name ?>
          </div>
          <div class="details">
            <p>Plan : <b>
                <?php echo $delevery_type ?>
              </b></p>
            <p>Email :<b>
                <?php echo $email ?>
              </b></p>
            <p>Phone :<b>
                <?php echo $phone ?>
              </b></p>
            <p>Language : <b>
                <?php echo $language ?>
              </b></p>
            <p>Relation :<b>
                <?php echo $relation_status ?>
              </b></p>
            <p>TXS ID :<b>
                <?php echo $txt_id ?>
              </b></p>
            <p title="<?php echo $date ?>">Date : <b>


                <?php $ratingDate = strtotime($date);
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

              </b></p>
          </div>
        </div>
      </div>
      <?php
    }
    ?>

    <section class="container">
      <header>Send Poetry</header>
      <form method="post" class="form" enctype="multipart/form-data">
        <div class="input-box">
          <label>Poetry Text</label>
          <textarea required cols="10" rows="10" placeholder="Type Poetry Here" name="poetry-text"></textarea>
        </div>
        <div class="text-center">

          <label>or</label>
        </div>
        <?php if ($delevery_type == "extreme") { ?>
          <div class="input-box">
            <label>Poetry File</label>
            <input type="file" name="poetry-file">
          </div>
        <?php } ?>
        <input type="hidden" name="name" value="<?php echo $person_name ?>">
        <input type="hidden" name="txt_id" value="<?php echo $txt_id ?>">
        <input type="hidden" name="email" value="<?php echo $email ?>">
        <input type="hidden" name="delevery_type" value="<?php echo $delevery_type ?>">
        <?php if ($delevery_type == "extreme") {
          ?> <button type="submit" name="poetry-whatsapp" style="background-color: #075e54">
            Send on Whatsapp
          </button>
          <?php
        } else { ?>
          <button type="submit" name="poetry-email">
            Send on Email
          </button>
        <?php } ?>


      </form>
    </section>
  </div>
  <div class="content">
    <main>
      <div class="bottom-data">
        <div class="orders">
          <div class="header">
            <i class='bx bx-receipt'></i>
            <h3>Poetries</h3>
            <?php $query = "SELECT COUNT(*) as total_entries FROM `sended-poetry`";
            $total_rows = mysqli_query($con, $query);
            $total_rows = mysqli_fetch_assoc($total_rows);
            echo '<span> Total :' . $total_rows["total_entries"] . ' </span>'; ?>
          </div>
          <table>
            <thead>
              <tr>
                <th>Poetry</th>
                <th>Name</th>
                <th>Order Plan</th>
                <th>File</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $select = "SELECT `name`, `poetry`, `ordered_plan`, `date`, `poetry-file` FROM `sended-poetry`";
              $result = mysqli_query($con, $select);

              while ($row = mysqli_fetch_assoc($result)) {

                echo "<tr>";
                $details = $row['poetry'];
                $trimmedDetails = strlen($details) > 35 ? substr($details, 0, 35) . '...' : $details;
                echo "<td title='" . $row['poetry'] . "'>" . $trimmedDetails . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['ordered_plan'] . "</td>";
                echo "<td><a href='https://admin.mypoetry.in/" . $row['poetry-file'] . "' target='_blank'>Show File</a></td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "</tr>";
              }

              // Close the result set
              mysqli_free_result($result);
              ?>
            </tbody>
          </table>

          </table>
        </div>
      </div>
    </main>
  </div>
  <?php if (isset($_GET['whatsapp-send'])) {
    if (($_GET['whatsapp-send']) == "true") {
      ?>
      <div id="popup" class="popup-container">
        <div class="popup-content">
          <span class="send-btn-con">
            <a title="click to send" href="<?php echo $_SESSION['whatsapp'] ?>" class="whatsappsend">
              <h2>Send Message</h2>
            </a><br>
          </span>
          <div class="btn-container" style="justify-content: space-evenly;">
            <button class="btn cencel" type="button" onclick="togglePopup()">Cancel</button>
          </div>
        </div>
      </div>
      <?php
    }
  } ?>
  <script>
    function hideMessage() {
      window.location.href = "send-poetry.php";
    }

    function togglePopup() {
      var popup = document.getElementById('popup');
      popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'flex' : 'none';
      window.location.href = "send-poetry.php";
    }

  </script>
  <script src="scripts\index.js"></script>
</body>

</html>