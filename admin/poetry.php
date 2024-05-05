<?php
include 'php/config.php';
session_start();
mysqli_set_charset($con, "utf8");

if (!isset($_SESSION['access_token'])) {
  echo "<script>alert('Access Denied')</script>";
  echo "<script>alert('Redirect to Home Page')</script>";
  echo "<script>window.location.href = 'https://mypoetry.in';</script>";
  exit();
}

function redirect($messageType)
{
  header("Location: poetry.php?message=$messageType");
  exit();
}

if (isset($_POST['poetry-submit'])) {
  $author = $_POST['author'];
  $poetry = $_POST['poetry'];
  $category = $_POST['category'];

  $insert = "INSERT INTO `poetry_cards`(`poetry`, `data_filters`, `date`, `author`) VALUES ('$poetry','$category',NOW(),'$author')";
  $result = mysqli_query($con, $insert);
  $messageType = $result ? 'success' : 'danger';
  $_SESSION['message'] = $result ? 'Poetry Added !!' : 'Not Added Something Wrong!!';
  redirect($messageType);
}

if (isset($_POST['poetry-update'])) {
  $author = $_POST['author'];
  $poetry = $_POST['poetry'];
  $category = $_POST['category'];

  $id = $_GET['edit-id'];
  $update = "UPDATE `poetry_cards` SET `poetry`='$poetry',`data_filters`=' $category',`date`=NOW(),`author`='$author ' WHERE id = '$id'";
  $result = mysqli_query($con, $update);
  $messageType = $result ? 'success' : 'danger';
  $_SESSION['message'] = $result ? 'Poetry Updated !!' : 'Not Updated Something Wrong!!';
  redirect($messageType);
}

if (isset($_GET['edit-id'])) {
  $id = $_GET['edit-id'];
  $query = "SELECT `poetry`, `data_filters`, `author` FROM `poetry_cards` WHERE id = '$id'";
  $result = mysqli_query($con, $query);

  if ($row = mysqli_fetch_assoc($result)) {
    $poetry = $row['poetry'];
    $author = $row['author'];
    $category = $row['data_filters'];

  }
}

if (isset($_GET['delete-id'])) {
  $id = $_GET['delete-id'];
  $del = "DELETE FROM `poetry_cards` WHERE id ='$id'";
  $result = mysqli_query($con, $del);
  $messageType = $result ? 'success' : 'danger';
  $_SESSION['message'] = $result ? 'Deleted Successfully !!' : 'Not Deleted Something Wrong!!';
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
  <title>Poetry Page</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="styles/top3.css" />
  <link rel="stylesheet" href="styles/style.css" />
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
    <?php endif; ?>
    <section class="container">
      <header>Poetry Card</header>
      <form method="post" class="form">
        <div class="input-box">
          <label>Author</label>
          <input type="text" placeholder="Enter Author Name" name="author"
            value="<?php echo isset($author) ? $author : 'Chahat K Arya'; ?>" required />
        </div>
        <div class="select-box">

          <select name="category">
            <?php
            $query = "SELECT * FROM `poetry_cards`";
            $result = mysqli_query($con, $query);

            if (!$result) {
              die("Query failed: " . mysqli_error($con));
            }
            while ($row = mysqli_fetch_assoc($result)) {
              ?>

              <option hidden>Select Category</option>
              <?php if (isset($category)): ?>
                <option value="<?= $category ?>" selected>
                  <?= $category ?>
                </option>
              <?php endif; ?>
              <option value="<?php echo $row['data_filters'] ?>">
                <?php echo $row['data_filters'] ?>
              </option>

              <?php
            }
            ?>
          </select>
        </div>
        <div class="input-box">
          <label>Poetry</label>
          <textarea cols="10" rows="10" name="poetry"><?php echo isset($poetry) ? $poetry : ''; ?></textarea>
        </div>

        <button type="submit" name="<?php echo isset($_GET['edit-id']) ? 'poetry-update' : 'poetry-submit'; ?>">
          <?php echo isset($_GET['edit-id']) ? 'Update' : 'Submit'; ?>
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
            <h3>Poetries</h3>
            <?php $query = "SELECT COUNT(*) as total_entries FROM poetry_cards";
            $total_rows = mysqli_query($con, $query);
            $total_rows = mysqli_fetch_assoc($total_rows);
            echo '<span> Total :' . $total_rows["total_entries"] . ' </span>'; ?>
          </div>
          <table>
            <thead>
              <tr>
                <th>Poetry</th>
                <th>Data Filters</th>
                <th>Author</th>
                <th>Date</th>
                <th colspan="2">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                $query = "SELECT * FROM `poetry_cards` ORDER BY `poetry_cards`.`id` DESC";
                $result = mysqli_query($con, $query);

                if (!$result) {
                  die("Query failed: " . mysqli_error($con));
                }
                while ($row = mysqli_fetch_assoc($result)) {
                  ?>

                  <td>
                    <p title="<?php echo $row['poetry'] ?>">
                      <?php
                      $details = $row['poetry'];
                      $trimmedDetails = strlen($details) > 185 ? substr($details, 0, 185) . '...' : $details;
                      echo $trimmedDetails;
                      ?>
                    </p>
                  </td>
                  <td>
                    <p>
                      <?php echo $row['data_filters']; ?>
                    </p>
                  </td>
                  <td>
                    <p>
                      <?php echo $row['author']; ?>
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
                    <form method="get">
                      <input type="hidden" value="<?php echo $row['id'] ?>" name="edit-id">
                      <input type="submit" value="edit" class="status completed">
                    </form>
                    <form method="get">
                      <input type="hidden" value="<?php echo $row['id'] ?>" name="delete-id">
                      <input type="submit" value="delete" class="status delete">
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
  <script>
    function hideMessage() {
      window.location.href = "poetry.php";
    }

  </script>
  <script src="scripts\index.js"></script>
</body>

</html>