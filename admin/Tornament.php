<?php
include 'php/config.php';
session_start();

if (isset($_GET['winner-id'])) {
    $winner_id = $_GET['winner-id'];
}
if (isset($_GET['view-id'])) {
    $view_id = $_GET['view-id'];
}
if (!isset($_SESSION['access_token'])) {
    echo "<script>alert('Access Denied')</script>";
    echo "<script>alert('Redirect to Home Page')</script>";
    echo "<script>window.location.href = 'https://mypoetry.in';</script>";
    exit();
}
function redirect($messageType)
{
  header("Location: Tornament.php?message=$messageType");
  exit();
}

function insertWinner($con, $winner_id, $rank)
{
    $select = "SELECT * FROM `tornament` WHERE id='$winner_id'";
    $result = mysqli_query($con, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $winner_name = $row["name"];
        $winner_poetry = $row["poetry"];
        $winner_poetryfile = $row["poetryfile"];
        $tornament_token = $row["tornament-token"];
        $winner_email = $row["email"];

        $insert = "INSERT INTO `tornamentwinners`(`participateID`, `participateName`, `participatePoetry`, `winrank`, `poetry-file`, `tornament-token`,`participateEmail`) 
                    VALUES ('$winner_id','$winner_name','$winner_poetry','$rank','$winner_poetryfile','$tornament_token','$winner_email')";

        $InsterResult = mysqli_query($con, $insert);
        $messageType = $InsterResult ? 'success' : 'danger';
        $_SESSION['message'] = $InsterResult ? "{$rank} winner Set" : 'Not Set Something Wrong!!';
        redirect($messageType);
    }
}

if (isset($_POST['firstwinner'])) {
    insertWinner($con, $_POST['id'], 'First');
} elseif (isset($_POST['secondwinner'])) {
    insertWinner($con, $_POST['id'], 'Second');
} elseif (isset($_POST['thirdwinner'])) {
    insertWinner($con, $_POST['id'], 'Third');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php include 'php/favicon.html' ?>
    <title>Tornament Page</title>
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
    <div class="content">
        <main>
        <div class="header">
                <div class="left">
                    <h1>Tornament Winners </h1>

                </div>
                <a href="Tornament-winner.php"class="report" >
                    <span>Show winners</span>
                </a>
            </div>
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Tornament</h3>
                        <?php $query = "SELECT COUNT(*) as total_entries FROM tornament";
                        $total_rows = mysqli_query($con, $query);
                        $total_rows = mysqli_fetch_assoc($total_rows);
                        echo '<span> Total :' . $total_rows["total_entries"] . ' </span>'; ?>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>State</th>
                                <th>Poetry</th>
                                <th>Date</th>
                                <th colspan="2">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $query = "SELECT * FROM `tornament`";
                                $result = mysqli_query($con, $query);

                                // Check for errors in the query
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
                                        <p>
                                            <?php echo $row['email']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $row['mobile']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php if ($row['state'] == 'other') {
                                                echo $row['otherstate'];
                                            } else {
                                                echo $row['state'];
                                            }
                                            ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p title="<?php echo $row['poetry'] ?>">
                                            <?php if ($row['poetry'] == '') {
                                                ?><a href=" <?php echo $domain . '/' . $row['poetryfile']; ?>">File (Click
                                                    & View)</a>
                                                <?php
                                            } else {
                                                $details = $row['poetry'];
                                                $trimmedDetails = strlen($details) > 25 ? substr($details, 0, 25) . '...' : $details;
                                                echo $trimmedDetails;
                                            }
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
                                        <form method="get">
                                            <input type="submit" value="Winner" name="status" class="status completed">
                                            <input type="hidden" name="winner-id" value="<?php echo $row['id']; ?>">
                                        </form>
                                        <form method="get">
                                            <input type="hidden" name="view-id" value="<?php echo $row['id']; ?>">
                                            <input type="submit" value="View" class="status process">
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
    <?php if (isset($winner_id)) {
        ?>
        <div id="popup" class="popup-container">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h2>Choose Winner</h2>
                <form method="post">
                    <div class="winner-btn-container">
                        <input type="hidden" name="id" value="<?php echo $winner_id?>">
                        <button type="submit" name ="firstwinner" class="winner-btn firstwinner">1st : Winner</button>
                        <button type="submit" name ="secondwinner" class="winner-btn secwinner">2nd : Winner</button>
                        <button type="submit" name ="thirdwinner" class="winner-btn thirdwinner">3rd : Winner</button>
                    </div>
                    <div class="btn-container" style="justify-content: space-evenly; margin-top:10px;">

                        <button class="btn cencel winner" type="button" onclick="togglePopup()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    } ?>
    <?php if (isset($view_id)) {
        $id = $view_id;
        $select = "SELECT  `name`, `poetry`, `poetryfile` FROM `tornament` WHERE id=$id";
        $result = mysqli_query($con, $select);

        // Check for errors in the query
        if (!$result) {
            die("Query failed: " . mysqli_error($con));
        }
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <div id="popup" class="popup-container">
                <div class="popup-content">
                    <span class="close-btn">&times;</span>
                    <h2>
                        <?php echo $row['name'] . "'s" ?> Poetry
                    </h2>
                    <p class="display-poetry" title="<?php echo $row['name'] . "'s" ?> Poetry">
                        <?php if ($row['poetry'] == '') { ?><img src="<?php echo $domain . '/' . $row['poetryfile']; ?>"
                                alt="poetry">
                            <?php
                        } else {
                            echo $row['poetry'];
                        }
                        ?>
                    </p>
                    <div class="btn-container" style="justify-content: space-evenly; margin-top:10px;">
                        <button class="btn cencel" type="button" onclick="togglePopup()">Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>

        <?php
    } ?>
    <script>
        function togglePopup() {
            var popup = document.getElementById('popup');
            popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'flex' : 'none';
            window.location.href = "Tornament.php";
        }
    </script>
    <script>
        function hideMessage() {
            window.location.href = "Tornament.php";
        }
    </script>
    <script src="scripts/index.js"></script>
</body>

</html>