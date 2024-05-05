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
    header("Location: settings.php?message=$messageType");
    exit();
}
function generateRandomToken($length = 10)
{
    $token = '';
    $characters = '0123456789ABCXYZ';

    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[random_int(0, $max)];
    }
    return $token;
}
if (isset($_GET['date-btn'])) {
    $date_active = true;
}
if (isset($_POST['send-date'])) {
    $start = $_POST['start-date'];
    $end = $_POST['end-date'];

    // Convert input dates to 'Y-m-d' format
    $startFormatted = date('Y-m-d', strtotime($start));
    $endFormatted = date('Y-m-d', strtotime($end));

    // Update the database with formatted dates
    $updateActive = "UPDATE `settings` SET `data-value2`='$startFormatted', `data-value3`='$endFormatted' WHERE id='2'";
    $messageTypeActive = mysqli_query($con, $updateActive) ? 'success' : 'danger';
    $_SESSION['message'] = $messageTypeActive === 'success' ? 'Date Set successfully!!!' : 'Setting Failed - Something Went Wrong!!';

    redirect($messageTypeActive);

}
if (isset($_POST['active-btn'])) {
    $randomToken = 'TRMT' . generateRandomToken(10) . 'MYPI';


    $updateActive = "UPDATE `settings` SET `data-value`='Active' WHERE id='2'";
    $messageTypeActive = mysqli_query($con, $updateActive) ? 'success' : 'danger';
    $_SESSION['message'] = $messageTypeActive === 'success' ? 'Tournament Activated!!' : 'Activation Failed - Something Went Wrong!!';

    // Second Update Query
    if ($messageTypeActive === 'success') {
        $updateToken = "UPDATE `settings` SET `data-value`='$randomToken' WHERE id='4'";
        $messageTypeToken = mysqli_query($con, $updateToken) ? 'success' : 'danger';
        $_SESSION['message'] = $messageTypeToken === 'success' ? 'Tournament Activated Token Created!!' : 'Tournament Activated & Token Creation Failed - Something Went Wrong!!';
    }

    // Redirect based on the result
    redirect($messageTypeToken ?? $messageTypeActive);
}
if (isset($_POST['deactivate-btn'])) {

    // First Update Query
    $updateActive = "UPDATE `settings` SET `data-value`='Deactivate' WHERE id='2'";
    $messageTypeActive = mysqli_query($con, $updateActive) ? 'success' : 'danger';
    $_SESSION['message'] = $messageTypeActive === 'success' ? 'Tournament Deactivated!!' : 'Deactivate Failed - Something Went Wrong!!';

    if ($messageTypeActive === 'success') {
        $updateToken = "UPDATE `settings` SET `data-value`='' WHERE id='4'";
        $messageTypeToken = mysqli_query($con, $updateToken) ? 'success' : 'danger';
        $_SESSION['message'] = $messageTypeToken === 'success' ? 'Tournament Deactivated & Token Removed!!' : 'Token Creation Failed - Something Went Wrong!!';
    }

    // Redirect based on the result
    redirect($messageTypeToken ?? $messageTypeActive);
}



if (isset($_POST['reset-btn'])) {
    $updateActive = "UPDATE `settings` SET `data-value`='0' WHERE id='3'";
    $updateActiveResult = mysqli_query($con, $updateActive);

    $messageTypeActive = $updateActiveResult ? 'success' : 'danger';
    $_SESSION['message'] = $messageTypeActive === 'success' ? 'Revenue Reset successfully!!!' : 'Revenue Reset Failed - Something Went Wrong!!';
    redirect($messageTypeActive);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php include 'php/favicon.html' ?>
    <title>Settings</title>
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
                        <h3>Settings</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch all data-values
                            $dataValuesResult = mysqli_query($con, "SELECT `data-value`, `data-value2`, `data-value3` FROM `settings` WHERE id='2'");
                            $dataValues = mysqli_fetch_assoc($dataValuesResult);
                            $datavalue = $dataValues["data-value"];
                            $datavalue2 = $dataValues["data-value2"];
                            $datavalue3 = $dataValues["data-value3"];

                            // Check the status
                            $status = $datavalue; ?>
                            <tr>
                                <td>
                                    <p>Tournament Status</p>
                                </td>
                                <td>
                                    <?php echo $datavalue; ?>
                                </td>
                                <td>
                                    <?php
                                    // Assuming $datavalue2 and $datavalue3 are in the format '2023-11-21'
                                    
                                    // Convert string to DateTime objects
                                    $dateStart = DateTime::createFromFormat('Y-m-d', $datavalue2);
                                    $dateEnd = DateTime::createFromFormat('Y-m-d', $datavalue3);

                                    // Check for errors in date conversion
                                    if (!$dateStart || !$dateEnd) {
                                        echo "Error converting date.";
                                    } else {
                                        // Format the dates
                                        $formattedStartDate = $dateStart->format('d M');
                                        $formattedEndDate = $dateEnd->format('d M');

                                        // Output the formatted date range
                                        echo $formattedStartDate . ' to ' . $formattedEndDate;
                                    }
                                    ?>



                                </td>
                                <td class="d-flex">

                                    <?php
                                    if ($status != "Active") {
                                        ?>
                                        <form method="get">
                                            <button type="submit" name="date-btn" value="true" class="status process">Choose
                                                Date</button>
                                        </form>
                                        <form method="post">
                                            <button type="submit" name="active-btn"
                                                class="status completed">Activate</button>
                                        </form>
                                        <?php
                                    } else {
                                        ?>
                                        <form method="post">
                                            <button type="submit" name="deactivate-btn"
                                                class="status delete">Deactivate</button>
                                        </form>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Revanue</td>
                                <td>Active</td>
                                <td>
                                    <?php $select = "SELECT  `data-value` FROM `settings` WHERE id='3'";
                                    $results = mysqli_query($con, $select);
                                    while ($rows = mysqli_fetch_array($results)) {
                                        echo $count = $rows['data-value'] . "&#8377;";
                                    }
                                    ?>
                                </td>
                                <td class="d-flex">
                                    <form method="post" id="reset-revanue">
                                        <button type="submit" name="reset-btn" class="status delete">Reset</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>Login</td>
                                <td>Secured</td>
                                <td>3 Layer Activated</td>
                                <td>
                                    <?php
                                    $select = "SELECT `data-value4` FROM `settings` WHERE id='5'";
                                    $result = mysqli_query($con, $select);

                                    if (!$result) {
                                        die("Query failed: " . mysqli_error($con));
                                    }

                                    $row = mysqli_fetch_assoc($result);
                                    $datavalue4 = $row['data-value4'];
                                    echo "<a id='loginUrlCopy' href='https://admin.mypoetry.in./.$datavalue4'>Get URL</a>";
                                    ?>
                                </td>



                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <?php if (isset($date_active)) {
        ?>
        <div id="popup" class="popup-container">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h2>Choose Date</h2>

                <!-- Input and Textarea -->
                <form method="post">
                    <label for="name">Start Date</label>
                    <input type="date" name="start-date" required>

                    <label for="name">End Date</label>
                    <input type="date" name="end-date" required>

                    <!-- Buttons -->
                    <div class="btn-container">
                        <button class="btn" name="send-date" type="submit">Save</button>
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
            window.location.href = "settings.php";
        }
    </script>
    <script>
        function hideMessage() {
            window.location.href = "settings.php";
        }

    </script>
    <script src="scripts/index.js"></script>
</body>

</html>