<?php
if (isset($_POST['markasread'])) {
    $id = $_POST['id'];
    $sql = "UPDATE notification SET status='Read' WHERE id=$id";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "error";
    };
}

if (isset($_POST['clear-all'])) {
    $sql = "UPDATE notification SET status='Read' WHERE status='unread'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "error";
    };
}

?>
<div class="sidebar close">
    <a href="index.php" class="logo">
        <i class='bx bx-code-alt'></i>
        <div class="logo-name"><span>mypoetry</span>.in</div>
    </a>
    <ul class="side-menu">
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'index.php')
                        echo 'active'; ?>'><a href="index.php"><i class='bx bxs-dashboard '></i>Dashboard</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'top3.php')
                        echo 'active'; ?>'><a href="top3.php"><i class='bx bx-hash'></i>Top3 Poetry</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'payment.php')
                        echo 'active'; ?>'><a href="payment.php"><i class='bx bxs-credit-card'></i>Payment Status</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'delevery.php')
                        echo 'active'; ?>'><a href="delevery.php"><i class='bx bxs-cart-alt'></i>Orders</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'Tornament.php')
                        echo 'active'; ?>'><a href="Tornament.php"><i class='bx bx-medal'></i>Tornament</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'card-category.php')
                        echo 'active'; ?>'><a href="card-category.php"><i class='bx bx-list-plus'></i>Category Cards</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'head-category.php')
                        echo 'active'; ?>'><a href="head-category.php"><i class='bx bxs-customize'></i>Head category</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'poetry.php')
                        echo 'active'; ?>'><a href="poetry.php"><i class='bx bxs-pen'></i>Poetry</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'feedback.php')
                        echo 'active'; ?>'><a href="feedback.php"><i class='bx bx-message-rounded'></i>Feedbacks</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'contact.php')
                        echo 'active'; ?>'><a href="contact.php"><i class='bx bxs-contact'></i>Contact</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'users.php')
                        echo 'active'; ?>'><a href="users.php"><i class='bx bx-group'></i>Users</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'offer.php')
                        echo 'active'; ?>'><a href="offer.php"><i class='bx bxs-offer'></i>offers</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'send-poetry.php')
                        echo 'active'; ?>'><a href="send-poetry.php"><i class='bx bxs-send'></i>Send Poetry</a></li>
        <li class='<?php if (basename($_SERVER['PHP_SELF']) == 'settings.php')
                        echo 'active'; ?>'><a href="settings.php"><i class='bx bx-cog'></i>Settings</a></li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="logout.php?logout=true&access=denied" class="logout">
                <i class='bx bx-log-out-circle'></i>
                Logout
            </a>
        </li>
    </ul>
</div>
<!-- End of Sidebar -->
<div class="content">
    <!-- Navbar -->
    <nav>
        <i class='bx bx-menu' onclick="toggleSidebar()"></i>
        <form action="payment.php" class="form" id="searchForm">
            <div class="form-input">
                <input type="text" name="search" id="txt_id" placeholder="Search..." oninput="getSuggestions()" autocomplete="off">
                <button style="margin-top:0px" class="search-btn" type="submit" onclick="searchData()"><i class='bx bx-search'></i></button>
            </div>
            <!-- Container to display autocomplete suggestions -->
            <div id="autocompleteSuggestions"></div>
        </form>
        <script>
            const searchInput = document.getElementById("txt_id");
            const autocompleteSuggestions = document.getElementById("autocompleteSuggestions");

            // Event listener for input changes
            searchInput.addEventListener("input", function() {
                // Show/hide autocomplete suggestions based on input value
                if (searchInput.value.trim() === "") {
                    autocompleteSuggestions.style.display = "none";
                } else {
                    autocompleteSuggestions.style.display = "block";
                }
            });

            // Event listener for when user clicks outside the input and suggestions container
            document.addEventListener("click", function(event) {
                if (!searchInput.contains(event.target) && !autocompleteSuggestions.contains(event.target)) {
                    autocompleteSuggestions.style.display = "none";
                }
            });
        </script>
        <input type="checkbox" id="theme-toggle" hidden>
        <label for="theme-toggle" class="theme-toggle"></label>
        <a href="#" class="notif" id="notificationIcon">
            <i class='bx bx-bell'></i>

            <?php
            $query = "SELECT COUNT(*) AS unreadedNotification FROM `notification` WHERE `status` = 'unread'";
            $result = mysqli_query($con, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result); // Move this line here
                if ($row['unreadedNotification'] != 0) {
                    echo " <span class='count'>";
                    echo $unreadedNotification = $row['unreadedNotification'];
                    echo "</span>";
                }
            }
            ?>

        </a>

        <div class="notification-card" id="notificationCard">
            <?php if (isset($unreadedNotification)) {  ?>
                <form method="post">
                    <button class="clear-all-btn" type="submit" name="clear-all"> <i class='bx bx-check-square'></i>Clear
                        All</button>
                </form>
            <?php } ?>

            <div class="notification-content">
                <ul class="notification-list">
                    <?php
                    $select = "SELECT * FROM `notification` WHERE `status` = 'unread' ORDER BY `notification`.`id` DESC";
                    $result = mysqli_query($con, $select);

                    if (mysqli_num_rows($result) > 0) {
                        while ($notification = mysqli_fetch_array($result)) {

                            $notificationtitle = $notification["title"];
                            $notificationurl = $notification["url"];
                            $notificationdate = $notification["date"];
                            $notificationid = $notification["id"];

                            $ratingDate = strtotime($notificationdate);
                            $currentDate = time();
                            $differenceInDays = floor(($currentDate - $ratingDate) / (60 * 60 * 24));

                            $timeAgo = ($differenceInDays == 0) ? 'Today' : (($differenceInDays == 1) ? 'Yesterday' : (($differenceInDays <= 60) ? $differenceInDays . ' days ago' : ceil($differenceInDays / 7) . ' weeks ago'));

                            echo "<li>
    <form method='post'>
    <button type='submit' name='markasread'>
    <input type='hidden' name='id' value=$notificationid>
    <i class='bx bx-check-square'></i></button>
    </form>
            <a href='http://admin.mypoetry.in/$notificationurl'>
                <p>$notificationtitle</p>
            </a>
            <span class='date'>$timeAgo</span>
          </li>";
                        }
                    } else {
                    ?>
                        <li>
                            <p>No Notification </p>
                        </li>
                    <?php
                    }
                    ?>


                </ul>
            </div>

            <button class="close-btn" onclick="closeNotificationCard()">Close</button>
        </div>
        <script>
            document.getElementById('notificationIcon').addEventListener('click', function() {
                // Show the notification card
                document.getElementById('notificationCard').style.display = 'block';
            });

            function closeNotificationCard() {
                // Close the notification card
                document.getElementById('notificationCard').style.display = 'none';
            }
        </script>
        <a href="https://mypoetry.in/" class="profile">
            <img src="assets/logo.ico">
        </a>
    </nav>
</div>