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
    header("Location: feedback.php?message=$messageType");
    exit();
}
if (isset($_GET['edit-feedback'])) {
    $mail_active = true;
}
if (isset($_GET['delete-feedback'])) {
    $id = $_GET['delete-feedback'];
    $update = "DELETE FROM `feedback` WHERE id=$id";
    $result = mysqli_query($con, $update);
    $messageType = $result ? 'success' : 'danger';
    $_SESSION['message'] = $result ? 'Feedback Deleted!!' : 'Delete Fail Something Wrong!!';
    redirect($messageType);

}
if (isset($_POST['send-feedback'])) {
    $rating = $_POST['rating'];
    $msg = $_POST['message'];
    $id = $_POST['id'];
    $update = "UPDATE `feedback` SET `rating`='$rating',`description`='$msg',`rating_date`=NOW() WHERE id='$id'";
    $result = mysqli_query($con, $update);
    $messageType = $result ? 'success' : 'danger';
    $_SESSION['message'] = $result ? 'Feedback Edited!!' : 'Delete Fail Something Wrong!!';
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
    <title>Feedback</title>
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
                        <h3>User Feedback</h3>
                        <?php $query = "SELECT COUNT(*) as total_entries FROM feedback";
                        $total_rows = mysqli_query($con, $query);
                        $total_rows = mysqli_fetch_assoc($total_rows);
                        echo '<span> Total :' . $total_rows["total_entries"] . ' </span>'; ?>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Description</th>
                                <th>Rating</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th colspan="3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $query = "SELECT * FROM `feedback` ORDER BY `feedback`.`id` DESC";
                                $result = mysqli_query($con, $query);

                                // Check for errors in the query
                                if (!$result) {
                                    die("Query failed: " . mysqli_error($con));
                                }
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>

                                    <td>
                                        <p>
                                            <?php echo $row['user_name']; ?>
                                        </p>
                                    </td>


                                    <td>

                                        <p title="<?php echo $row['description'] ?>">
                                            <?php
                                            $details = $row['description'];
                                            $trimmedDetails = strlen($details) > 65 ? substr($details, 0, 65) . '...' : $details;
                                            echo $trimmedDetails;
                                            ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $row['rating']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php
                                            if (strpos($row['user_img'], 'http') === 0) {
                                                ?>
                                                <a href="<?php echo $row['user_img']; ?>">
                                                    <img src="<?php echo $row['user_img']; ?>"
                                                        alt="<?php echo $row['user_name']; ?>">
                                                </a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="<?php echo $domain . '/' . $row['user_img']; ?>">
                                                    <img src="<?php echo $domain . '/' . $row['user_img']; ?>"
                                                        alt="<?php echo $row['user_name']; ?>">
                                                </a>
                                                <?php
                                            }
                                            ?>

                                        </p>
                                    </td>
                                    <td>
                                        <p title="<?php echo $row['rating_date'] ?>">

                                            <?php $ratingDate = strtotime($row['rating_date']);
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
                                            <input type="hidden" value="<?php echo $row['id'] ?>" name="edit-feedback">
                                            <input type="submit" value="edit" class="status completed">
                                        </form>
                                        <form method="get">
                                            <input type="hidden" value="<?php echo $row['id'] ?>" name="delete-feedback">
                                            <input type="submit" value="delete" name="delete-feedback-btn"
                                                class="status delete">
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
                <h2>Edit Feedback</h2>

                <?php
                $feedback_id = isset($_GET['edit-feedback']) ? $_GET['edit-feedback'] : null;

                $query = "SELECT  `rating`, `description` FROM `feedback` WHERE id=$feedback_id";
                $result = mysqli_query($con, $query);

                // Check for errors in the query
                if (!$result) {
                    die("Query failed: " . mysqli_error($con));
                }
                $row = mysqli_fetch_assoc($result)
                    ?>
                <form method="post">
                    <label for="name">Rating</label>
                    <input type="number" min="1" max="5" value="<?php echo $row['rating'] ?>" name="rating" required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" placeholder="Enter Message" rows="4"
                        required><?php echo $row['description'] ?></textarea>
                    <input type="hidden" name="id" value=<?php echo $feedback_id; ?>>
                    <!-- Buttons -->
                    <div class="btn-container">
                        <button class="btn" name="send-feedback" type="submit">Send</button>
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
        }
    </script>
    <script>
        function hideMessage() {
            window.location.href = "feedback.php";
        }
    </script>
    <script src="scripts/index.js"></script>
</body>

</html>