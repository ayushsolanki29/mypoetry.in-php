<?php
include 'php/config.php';
session_start();
function redirect($messageType)
{
    header("Location:Tornament-winner.php?message=$messageType");
    exit();
}
if (!isset($_SESSION['access_token'])) {
    echo "<script>alert('Access Denied')</script>";
    echo "<script>alert('Redirect to Home Page')</script>";
    echo "<script>window.location.href = 'https://mypoetry.in';</script>";
    exit();
}
if (isset($_POST['save-name'])) {
    $new_name = $_POST['newname'];
    $edit_name_id = $_POST['edit_name_id'];
    $update = "UPDATE `tornamentwinners` SET `participateName`='$new_name' WHERE id='$edit_name_id'";
    if ($con->query($update) === TRUE) {
        $messageType = 'success';
        $_SESSION['message'] = 'Name Changed!!';
    } else {
        $messageType = 'danger';
        $_SESSION['message'] = 'Faild to change!!';
    }
    redirect($messageType);
}
if (isset($_POST['edit-name'])) {
    $edit_name_id = $_POST['id'];
    $name = $_POST['name'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php include 'php/favicon.html' ?>
    <title>Tornament Winners</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/top3.css" />
    <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
    <?php include 'php/slidebar.php'; ?>
    <?php
    if (isset($_SESSION['message'], $_GET['message'])) :
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
                        <h3>Tornament Winners</h3>
                        <?php $query = "SELECT COUNT(*) as total_entries FROM tornamentwinners";
                        $total_rows = mysqli_query($con, $query);
                        $total_rows = mysqli_fetch_assoc($total_rows);
                        echo '<span> Total :' . $total_rows["total_entries"] . ' </span>'; ?>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Poetry</th>
                                <th>Rank</th>
                                <th>Tornament ID</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $query = "SELECT * FROM `tornamentwinners`";
                                $result = mysqli_query($con, $query);

                                // Check for errors in the query
                                if (!$result) {
                                    die("Query failed: " . mysqli_error($con));
                                }
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <td>
                                        <p>
                                            <?php echo $row['participateName']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p title="<?php echo $row['participatePoetry'] ?>">
                                            <?php if (!empty($row['participatePoetry'])) {
                                                $details = $row['participatePoetry'];
                                                $trimmedDetails = strlen($details) > 25 ? substr($details, 0, 25) . '...' : $details;
                                                echo $trimmedDetails;
                                            } else {
                                                $FileName = $row['poetry-file'];
                                                echo "<a href='$domain/$FileName'>Show File</a>";
                                            } ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $row['winrank']; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <?php echo $row['tornament-token']; ?>
                                        </p>
                                    </td>

                                    <td class="d-flex">
                                        <form method="post" onsubmit="generateCertificate('<?php echo $row['participateName']; ?>','<?php echo $row['winrank']; ?>', '<?php echo $row['participateEmail']; ?>'); return false;">
                                            <input type="hidden" name="name" value="<?php echo $row['participateName']; ?>">
                                            <input type="hidden" name="name" value="<?php echo $row['winrank']; ?>">
                                            <input type="hidden" name="email" value="<?php echo $row['participateEmail']; ?>">
                                            <input type="submit" value="Certificate" name="status" class="status completed">
                                        </form>
                                        <form method="post">
                                            <input type="hidden" name="name" value="<?php echo $row['participateName']; ?>">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <input type="submit" value="edit" name="edit-name" class="status process">
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
    <?php if (isset($edit_name_id)) {
    ?>
        <div id="popup" class="popup-container">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h2>Edit Name</h2>
                <form method="post">
                    <label for="name">Name : </label>
                    <input type="text" id="name" name="newname" placeholder="Enter Subject" value="<?php echo $name ?>" required>
                    <input type="hidden" name="edit_name_id" value="<?php echo $edit_name_id ?>">
                    <div class="btn-container">
                        <button class="btn" name="save-name" type="submit">Update</button>
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
            window.location.href = "Tornament-winner.php";
        }
    </script>
    <script>
        function hideMessage() {
            window.location.href = "Tornament-winner.php";
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/pdf-lib/dist/pdf-lib.min.js"></script>
    <script src="https://unpkg.com/@pdf-lib/fontkit/dist/fontkit.umd.min.js"></script>
    <script src="scripts/index.js"></script>
    <script src="scripts/certificate.js"></script>

</body>

</html>