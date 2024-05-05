<?php
include 'php/config.php';
session_start();
if (!isset($_SESSION['access_token'])) {
  echo "<script>alert('Access Denied')</script>";
  echo "<script>alert('Redirect to Home Page')</script>";
  echo "<script>window.location.href = 'https://mypoetry.in';</script>";
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <?php include 'php/favicon.html' ?>
  <title>offers </title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="styles/top3.css" />
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>

  <?php include 'php/slidebar.php'; ?>

  <div class="content">
    <main>
      <div class="bottom-data">
        <div class="orders">
          <div class="header">
            <i class='bx bx-receipt'></i>
            <h3>Poetry Details</h3>
            We have 2 Offers
          </div>
          <table>
            <thead>
              <tr>
                <th>Image</th>
                <th>Offer Day</th>
                <th>Offer Price</th>
                <th>Original Price</th>
                <th>Offer Name</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                $query = "SELECT * FROM `offers_cards` WHERE 1";
                $result = mysqli_query($con, $query);

                // Check for errors in the query
                if (!$result) {
                  die("Query failed: " . mysqli_error($con));
                }
                while ($row = mysqli_fetch_assoc($result)) {
                  ?>

                  <td>
                    <img src="<?php echo $domain . '/' . $row['card_image']; ?>" alt="<?php echo $row['offer_name']; ?>">
                  </td>
                  <td>
                    <p>
                      <?php echo $row['offer_day']; ?>
                    </p>
                  </td>
                  <td>
                    <p>
                      <?php echo $row['offer_price'] . "&#8377;"; ?>
                    </p>
                  </td>
                  <td>
                    <p>
                      <?php echo $row['original_price'] . "&#8377;"; ?>
                    </p>
                  </td>
                  <td>
                    <p>
                      <?php echo $row['offer_name']; ?>
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
</body>

</html>