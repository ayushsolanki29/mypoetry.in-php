<?php
include 'php/config.php';
session_start();

if (!isset($_SESSION['access_token'])) {
  echo "<script>alert('Access Denied')</script>";
  echo "<script>alert('Redirect to Home Page')</script>";
  echo "<script>window.location.href = 'https://mypoetry.in';</script>";
  exit();
}
function redirect($messageType)
{
  header("Location: top3.php?message=$messageType");
  exit();
}
if (isset($_POST['top-poetry-update'])) {
  $poetry = $_POST['poetry'];
  $writter = $_POST['writter'];
  $id = $_GET['card-number'];

  $update = "UPDATE `top3_cards` SET `poetry`='$poetry',`writter`='$writter',`date`=NOW() WHERE id = '$id'";
  $result = mysqli_query($con, $update);
  $messageType = $result ? 'success' : 'danger';
  $_SESSION['message'] = $result ? 'Poetry Updated !!' : 'Not Updated Something Wrong!!';
  redirect($messageType);
}

if (isset($_GET['card-number'])) {
  $id = $_GET['card-number'];
  $query = "SELECT `poetry`, `writter`, `date` FROM `top3_cards` WHERE id = '$id'";
  $result = mysqli_query($con, $query);

  if ($row = mysqli_fetch_assoc($result)) {
    $poetry = $row['poetry'];
    $writter = $row['writter'];
    $date = $row['date'];
  }
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <?php include 'php/favicon.html' ?>
  <title>Top3 Section</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="styles/top3.css" />
  <link rel="stylesheet" href="styles/style.css" />

</head>

<body>

  <?php include 'php/slidebar.php'; ?>

  <div class="top3container">
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
    <?php endif; ?>
    <section class="container card">
      <header>Todays Top Card
        <?php if (isset($_GET['card-number'])) {
          echo $_GET['card-number'];
        } ?>
      </header>
      <form method="get" class="form" id="cardSelect">
        <div class="input-box">
          <label>Todays Card</label>
          <div class="select-box">

            <select name="card-number" id="cardNumberSelect">
              <?php if (isset($_GET['card-number']))
                echo '<option selected hidden value="' . $_GET['card-number'] . '">Top ' . $_GET['card-number'] . '</option>'; ?>

              <option value="" hidden>Choose a card number...</option>

              <option value="1">Top 1</option>
              <option value="2">Top 2</option>
              <option value="3">Top 3</option>
            </select>
          </div>
        </div>
      </form>

      <script>
        // Get the form and select element by their IDs
        var form = document.getElementById("cardSelect");
        var select = document.getElementById("cardNumberSelect");

        // Add an event listener to the select element
        select.addEventListener("change", function () {
          // Submit the form when an option is selected
          form.submit();
        });
      </script>
      <form method="post" class="form">
        <div class="input-box address">
          <label>Write a Poetry</label>
          <textarea id="poetryInput" name="poetry" placeholder="Enter Poetry" rows="10" cols="6"
            required><?php echo isset($poetry) ? $poetry : ''; ?></textarea>


        </div>
        <div class="input-box">
          <label>Enter Author Name</label>
          <input id="authorInput" name="writter" type="text" placeholder="Enter Author Name"
            value="<?php echo isset($writter) ? $writter : ''; ?>" required />
        </div>
        <div class="input-box">
          <label>Edited Date:
            <?php echo isset($date) ? $date : ''; ?>
          </label>
        </div>
        <button type="submit"
          name="<?php echo isset($_GET['card-number']) ? 'top-poetry-update' : 'top-poetry-submit'; ?>">
          <?php echo isset($_GET['card-number']) ? 'Update' : 'Submit'; ?>
        </button>
      </form>

    </section>

  </div>

  <div class="content">
    <main>
      <div class="bottom-data">
        <div class="orders">
          <div class="header">
            <i class='bx bx-receipt'></i>
            <h3>Top 3 Poetry</h3>
            We have 3 cards
          </div>
          <table>
            <thead>
              <tr>
                <th>Top</th>
                <th>Poetry</th>
                <th>date</th>

              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                $query = "SELECT * FROM `top3_cards`";
                $result = mysqli_query($con, $query);

                // Check for errors in the query
                if (!$result) {
                  die("Query failed: " . mysqli_error($con));
                }
                while ($row = mysqli_fetch_assoc($result)) {
                  ?>

                  <td>
                    <p>
                      <?php echo $row['id']; ?>
                    </p>
                  </td>
                  <td>
                    <p>
                      <?php echo $row['poetry']; ?>
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
  <script src="scripts\index.js"></script>
  <script>
    function hideMessage() {
      window.location.href = "top3.php";
    }
  </script>
</body>

</html>