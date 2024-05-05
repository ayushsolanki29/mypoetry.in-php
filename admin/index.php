<?php include 'php/config.php';
session_start();

function compareValues($expected, $actual)
{
    return hash_equals($expected, $actual);
}

$select = "SELECT `data-value`, `data-value2`, `data-value3` FROM `settings` WHERE id='5'";
$result = mysqli_query($con, $select);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$row = mysqli_fetch_assoc($result);

if (!isset($_SESSION['access_token'])) {
    if (isset($_GET['login']) && $_GET['login'] === 'true') {
        $isValidAccess = (
            compareValues($row['data-value'], $_GET['encryption1']) &&
            compareValues($row['data-value2'], $_GET['encryption2']) &&
            compareValues($row['data-value3'], $_GET['encryption3'])
        );
        if ($isValidAccess) {
            ?>
            <script>
                let actualCode = "<?php echo $admin_pass; ?>";
                let enteredCode;
                do {
                alert(actualCode);
                    enteredCode = prompt("Enter Secret Code :");
                    if (enteredCode === actualCode) {
                        alert('Access Granted');
                    } else {
                        alert('Denied');
                    }
                } while (enteredCode !== actualCode);
            </script>

            <?php
            $_SESSION['access_token'] = $row['data-value'] . $row['data-value2'] . $row['data-value3'];
        } else {
            accessDeniedRedirect();
        }

    } else {
        accessDeniedRedirect();
    }

}
function accessDeniedRedirect()
{
    echo "<script>alert('Access Denied')</script>";
    echo "<script>alert('Redirect to Home Page')</script>";
    echo "<script>window.location.href = 'https://mypoetry.in';</script>";
    exit();
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/style.css">
    <?php include 'php/favicon.html'?>
    <title>mypoetry.in - Dashbord</title>

</head>

<body>

  
    <!-- Main Content -->
    <div class="content">
        <main>
            <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>

                </div>
                <a href="#"class="report" >
                    <span onclick="checkversion()">Check Version</span>
                </a>
                <script>
                    function checkversion() {
                        alert("Admin Panel : v2.1.02");
                        alert("mypoetry : v2.0.10");
                    }
                </script>
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <?php
                    // Assuming you have a database connection established as $con
                    
                    // Fetch the count of records where payment_status is 'Paid'
                    $query = "SELECT COUNT(*) AS paidOrderCount FROM `poetry_delivery` WHERE `payment_status` = 'Paid'";
                    $result = mysqli_query($con, $query);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $paidOrderCount = $row['paidOrderCount'];
                    } else {
                        $paidOrderCount = 0; 
                    }
                    ?>

                    <span class="info">
                        <h3>
                            <?php echo $paidOrderCount; ?>
                        </h3>
                        <p>Paid Order</p>
                    </span>

                </li>
                <li><i class='bx bx-show-alt'></i>
                    <span class="info">
                        <h3>
                            <?php $select = "SELECT  `data-value` FROM `settings` WHERE id='1'";
                            $results = mysqli_query($con, $select);
                            while ($rows = mysqli_fetch_array($results)) {
                                echo $count = $rows['data-value'];
                            }
                            ?>
                        </h3>
                        <p>Site Visit</p>
                    </span>
                </li>
                <li><i class='bx bx-line-chart'></i>
                    <span class="info">
                        <h3>
                            <?php $query = "SELECT COUNT(*) as total_entries FROM poetry_cards";
                            $total_rows = mysqli_query($con, $query);
                            $total_rows = mysqli_fetch_assoc($total_rows);
                            echo '<span>' . $total_rows["total_entries"] . '</span>'; ?>
                        </h3>
                        <p>Total poetry</p>
                    </span>
                </li>
                <li><i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3>
                            <?php $select = "SELECT  `data-value` FROM `settings` WHERE id='3'";
                            $results = mysqli_query($con, $select);
                            while ($rows = mysqli_fetch_array($results)) {
                                echo $count = $rows['data-value'] . "&#8377;";
                            }
                            ?>
                        </h3>
                        <p>Total sale</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Orders</h3>
                        Todays Orders
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Get today's date in the format 'Y-m-d'
                            $todayDate = date('Y-m-d');

                            // Fetch today's entries
                            $select = "SELECT `delevery_type`, `person_name`, `person_img`, `date` FROM `poetry_delivery` WHERE DATE(`date`) = '$todayDate'";
                            $result = mysqli_query($con, $select);

                            if (mysqli_num_rows($result) > 0) {
                                // Entries found for today
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr data-toggle="popover" data-trigger="hover" title="Popover Title"
                                        data-content="Popover Content">
                                        <td>
                                            <img src="<?php echo $domain.'/'.$row['person_img']; ?>">
                                            <p>
                                                <?php echo $row['person_name']; ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                <?php echo $row['delevery_type']; ?>
                                            </p>
                                        </td>
                                        <td><span class="status  process"> <a href="payment.php" style="color:#fff;">Check</a>
                                            </span></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                // No entries for today
                                ?>
                                <tr>
                                    <td colspan="3">No Delevery Today.</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <script>
                        $(document).ready(function () {
                            // Enable popovers
                            $('[data-toggle="popover"]').popover();
                        });
                    </script>


                </div>

                <!-- Reminders -->
                <div class="reminders">
                    <div class="header">
                        <i class='bx bx-note'></i>
                        <?php
                        // Fetch all data-values
                        $dataValuesResult = mysqli_query($con, "SELECT `data-value`, `data-value2`, `data-value3` FROM `settings` WHERE id='2'");
                        $dataValues = mysqli_fetch_assoc($dataValuesResult);
                        $datavalue = $dataValues["data-value"];
                        $datavalue2 = $dataValues["data-value2"];
                        $datavalue3 = $dataValues["data-value3"];

                        $status = $datavalue;
                        ?>
                        <h3>Tournament Status</h3>
                        <p style="color: <?= $status == 'Active' ? 'green' : 'red' ?>;">
                            <?= $status == 'Active' ? 'Running' : 'Ended' ?>
                        </p>
                    </div>

                    <ul class="task-list">
                        <?php if ($status == 'Active'): ?>
                            <li class="completed">
                                <div class="task-title">
                                    <i class='bx bx-check-circle'></i>
                                    <p>
                                        <?= $status ?>
                                    </p>
                                </div>

                            </li>
                            <li class="completed">
                                <div class="task-title">
                                    <i class='bx bx-check-circle'></i>
                                    <p>
                                        <?php
                                        // Convert string to DateTime objects
                                        $dateStart = DateTime::createFromFormat('Y-m-d', $datavalue2);
                                        $dateEnd = DateTime::createFromFormat('Y-m-d', $datavalue3);

                                        // Check for errors in date conversion
                                        if ($dateStart && $dateEnd) {
                                            // Format the dates
                                            $formattedStartDate = $dateStart->format('d M');
                                            $formattedEndDate = $dateEnd->format('d M');

                                            // Output the formatted date range
                                            echo $formattedStartDate . ' to ' . $formattedEndDate;
                                        } else {
                                            echo "Error converting date.";
                                        }
                                        ?>
                                    </p>
                                </div>

                            </li>
                        <?php else: ?>
                            <?php if ($status != 'Active'): ?>
                                <li class="not-completed">
                                    <div class="task-title">
                                        <i class='bx bx-x-circle'></i>
                                        <p>Not Active</p>
                                    </div>

                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>


            </div>

        </main>

    </div>
    <script>
        function hideMessage() {
            window.location.href = "index.php";
        }

    </script>
    <script src="scripts/index.js"></script>
</body>

</html>