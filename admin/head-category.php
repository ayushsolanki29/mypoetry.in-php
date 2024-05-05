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
  header("Location: head-category.php?message=$messageType");
  exit();
}

if (isset($_POST['poetry-category-submit'])) {
  $title = $_POST['title'];
  $filter = $_POST['filter'];

  $insert = "INSERT INTO `poetry_category`(`category`, `data_filters`) VALUES ('$title','$filter')";
  $result = mysqli_query($con, $insert);
  $messageType = $result ? 'success' : 'danger';
  $_SESSION['message'] = $result ? 'Category Added !!' : 'Not Added Something Wrong!!';
  redirect($messageType);
}

if (isset($_POST['poetry-category-update'])) {
  $title = $_POST['title'];
  $filter = $_POST['filter'];
  $id = $_GET['edit-id'];
  $update = "UPDATE `poetry_category` SET `category`='$title',`data_filters`='$filter' WHERE id = '$id'";
  $result = mysqli_query($con, $update);
  $messageType = $result ? 'success' : 'danger';
  $_SESSION['message'] = $result ? 'Category Updated !!' : 'Not Updated Something Wrong!!';
  redirect($messageType);
}

if (isset($_GET['edit-id'])) {
  $id = $_GET['edit-id'];
  $query = "SELECT `category`, `data_filters` FROM `poetry_category` WHERE id = '$id'";
  $result = mysqli_query($con, $query);

  if ($row = mysqli_fetch_assoc($result)) {
    $cat = $row['category'];
    $filt = $row['data_filters'];
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
  <title>Head Category</title>
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
      <header>Heading Category</header>
      <form method="post" class="form">
        <div class="input-box">
          <label>Title</label>
          <input type="text" placeholder="Enter Category Card Name" name="title" value="<?php if (isset($cat)) {
            echo $cat;
          } ?>" required />
        </div>

        <div class="input-box">
          <label>Data Filters</label>
          <input type="text" placeholder="Enter Data Filters" name="filter" value="<?php if (isset($filt)) {
            echo $filt;
          } ?>" required />
        </div>
        <button type="submit"
          name="<?php echo isset($_GET['edit-id']) ? 'poetry-category-update' : 'poetry-category-submit'; ?>">
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
            <h3>Heading Category</h3>
            <?php $query = "SELECT COUNT(*) as total_entries FROM poetry_category";
            $total_rows = mysqli_query($con, $query);
            $total_rows = mysqli_fetch_assoc($total_rows);
            echo '<span> Total :' . $total_rows["total_entries"] . ' </span>'; ?>
          </div>
          <table>
            <thead>
              <tr>
                <th>Title</th>
                <th>Data Filter</th>
                <th colspan="3">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                $query = "SELECT * FROM `poetry_category` ORDER BY `poetry_category`.`id` DESC";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                  if (!$result) {
                    die("Query failed: " . mysqli_error($con));
                  }
                  ?>

                  <td>
                    <p>
                      <?php echo $row['category']; ?>
                    </p>
                  </td>
                  <td>
                    <p>
                      <?php echo $row['data_filters']; ?>
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
    function displayImage(input) {
      const reader = new FileReader();

      reader.onload = function (e) {
        document.getElementById("userImg").src = e.target.result;
      };

      reader.readAsDataURL(input.files[0]);
    }
    function hideMessage() {
      window.location.href = "poetry-category.php";
    }

  </script>
</body>

</html>