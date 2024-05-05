<?php
include 'php/config.php';
session_start();
function redirect($messageType)
{
  header("Location: card-category.php?message=$messageType");
  exit();
}


if (isset($_POST['category-submit'])) {
  $title = $_POST['title'];
  $filter = $_POST['data-filters'];
  $details = $_POST['details'];
  $filename = $_POST['img'];

  $destfile = 'source/menu/' . $filename;

  $insert = "INSERT INTO `category_card`(`title`,`details`,`data-filter`,`img`) VALUES ('$title','$details','$filter','$destfile')";
  $result = mysqli_query($con, $insert);

  $messageType = $result ? 'success' : 'danger';
  $_SESSION['message'] = $result ? 'Category Added !!' : 'Not Added Something Wrong!!';

  redirect($messageType);

}

if (isset($_POST['category-update'])) {
  $title = $_POST['title'];
  $filter = $_POST['data-filters'];
  $details = $_POST['details'];
  $filename = $_POST['img'];

  $id = $_GET['edit-id'];

  $update = "UPDATE `category_card` SET `title`='$title',`details`='$details',`data-filter`='$filter',`img`='$filename' WHERE id = '$id'";
  $result = mysqli_query($con, $update);
  $messageType = $result ? 'success' : 'danger';
  $_SESSION['message'] = $result ? 'Category Updated !!' : 'Not Updated Something Wrong!!';
  redirect($messageType);
}
if (isset($_GET['delete-id'])) {
  $id = $_GET['delete-id'];
  $del = "DELETE FROM `category_card` WHERE id ='$id' ";
  $result = mysqli_query($con, $del);
  $messageType = $result ? 'success' : 'danger';
  $_SESSION['message'] = $result ? 'Deleted Successfully !!' : 'Not Deleted Something Wrong!!';
  redirect($messageType);
}


if (isset($_GET['edit-id'])) {
  $id = $_GET['edit-id'];
  $query = "SELECT `title`,`details`,`data-filter`,`img` FROM `category_card` WHERE id = '$id'";
  $result = mysqli_query($con, $query);

  if ($row = mysqli_fetch_assoc($result)) {
    $title = $row['title'];
    $details = $row['details'];
    $filt = $row['data-filter'];
    $img = $row['img'];
  }
}

if (isset($_GET['delete-id'])) {
  $id = $_GET['delete-id'];
  $del = "DELETE FROM `poetry_category` WHERE id ='$id' ";
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
  <?php include 'php/favicon.html'?>
  <title>Category Card</title>
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
    <section class="container">
      <header>Category Card</header>
      <form method="post" class="form">
        <div class="input-box">
          <label>Title</label>
          <input type="text" placeholder="Enter Category Card Name" name="title"
            value="<?php echo isset($title) ? $title : ''; ?>" required />
        </div>

        <div class="input-box">
          <label>Data Filter</label>
          <div class="select-box">
            <select name="data-filters">
              <option hidden>Select Filter</option>
              <?php if (isset($filt)): ?>
                <option value="<?= $filt ?>" selected>
                  <?= $filt ?>
                </option>
              <?php endif; ?>

              <?php
              $query = "SELECT * FROM `poetry_category` ORDER BY `poetry_category`.`id` DESC";
              $result = mysqli_query($con, $query);

              if (!$result) {
                die("Query failed: " . mysqli_error($con));
              }

              while ($row = mysqli_fetch_assoc($result)):
                ?>
                <option value="<?= $row['data_filters'] ?>">
                  <?= $row['data_filters'] ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>

        <div class="input-box">
          <label>Enter img Name</label>
          <input type="text" placeholder="Enter File Name " value="<?php if (isset($img)) {
            echo $img;
          } ?>" name="img">
        </div>


        <div class="input-box">
          <label>Details</label>
          <textarea placeholder="Enter Description of Category" cols="10" rows="10"
            name="details"><?php echo isset($details) ? $details : ''; ?></textarea>
        </div>

        <button type="submit" name="<?php echo isset($_GET['edit-id']) ? 'category-update' : 'category-submit'; ?>">
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
            <h3>Category</h3>
            <?php $query = "SELECT COUNT(*) as total_entries FROM category_card";
            $total_rows = mysqli_query($con, $query);
            $total_rows = mysqli_fetch_assoc($total_rows);
            echo '<span> Total :' . $total_rows["total_entries"] . ' </span>'; ?>
          </div>
          <table>
            <thead>
              <tr>
                <th>Title</th>
                <th>Details</th>
                <th>Image</th>
                <th>Data Filter</th>

                <th colspan="3">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                $query = "SELECT * FROM `category_card` ORDER BY `category_card`.`id` DESC";
                $result = mysqli_query($con, $query);

                if (!$result) {
                  die("Query failed: " . mysqli_error($con));
                }
                while ($row = mysqli_fetch_assoc($result)) {
                  ?>

                  <td>
                    <p>
                      <?php echo $row['title']; ?>
                    </p>
                  </td>
                  <td>
                    <p title="<?php echo $row['details']?>">
                      <?php
                      $details = $row['details'];
                      $trimmedDetails = strlen($details) > 35 ? substr($details, 0, 35) . '...' : $details;
                      echo $trimmedDetails;
                      ?>
                    </p>

                  </td>
                  <td>
                    <img src="<?php echo $domain . '/' . $row['img']; ?>" alt="<?php echo $row['title']; ?>">
                  </td>

                  <td>
                    <p>
                      <?php echo $row['data-filter']; ?>
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

  <script src="scripts\index.js"></script>
  <script>
    function hideMessage() {
      window.location.href = "card-category.php";
    }

  </script>
</body>

</html>