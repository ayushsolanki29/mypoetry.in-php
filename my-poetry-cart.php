<?php
session_start();
include "auth/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<?php if (isset($_GET['delevery-type'])) {
    if ($_SESSION['delevery-type'] === $_GET['delevery-type']) {
        $deliveryType = $_GET['delevery-type'];
    } else {
        header("Location: index.php");
        exit;
    }
    $user_id = $_SESSION['user_id'];
    $select = "SELECT `useremail` FROM `users` WHERE user_id=$user_id";
    $result = mysqli_query($con, $select);
    while ($row = mysqli_fetch_assoc($result)) {
        $userEmail = $row["useremail"];
    }
} else {
    ?>
    <div class="Card-center">
        <div class="not-loged">
            <span class="title">Your Cart is Empty</span>
            <div class="description">
                <p>Explore our collection and add your favorite poetry to your cart.</p>
            </div>
            <div class="actions">
                <a href="privacy.php"><button class="pref">View Privacy Policy</button></a>
                <a href="index.php#book_section"><button class="accept">Shop Now</button></a>
            </div>
        </div>
    </div>
    <?php
}
?>

<head>
    <?php include 'pages/meta.html' ?>
    <title>My Poetry Cart - Explore, Review, and Purchase Your Favorite Verses</title>

    <meta name="title" content="My Poetry Cart - Explore, Review, and Purchase Your Favorite Verses">
    <meta name="description"
        content="Review and manage your selected poetry in My Poetry Cart. Explore a curated collection, review your chosen verses, and easily purchase your favorite poetry on Mypoetry.in.">
    <meta name="keywords"
        content="Poetry Cart, My Poetry Cart, explore poetry, review verses, purchase poetry, Mypoetry.in, curated collection, favorite verses, manage poetry">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/my-poetry-cart.php">
    <meta property="og:title" content="My Poetry Cart - Explore, Review, and Purchase Your Favorite Verses">
    <meta property="og:description"
        content="Review and manage your selected poetry in My Poetry Cart. Explore a curated collection, review your chosen verses, and easily purchase your favorite poetry on Mypoetry.in.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/my-poetry-cart.php">
    <meta property="twitter:title" content="My Poetry Cart - Explore, Review, and Purchase Your Favorite Verses">
    <meta property="twitter:description"
        content="Review and manage your selected poetry in My Poetry Cart. Explore a curated collection, review your chosen verses, and easily purchase your favorite poetry on Mypoetry.in.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/my-poetry-cart.php">

    <?php
    include 'pages/links.html'; ?>
    <link rel="stylesheet" href="styles/cart.css" />
</head>

<body class="sub_page">
    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="navabr">
        </div>
        <?php include 'pages/navbar.html' ?>
    </div>
    <?php if (isset($_GET['transaction'])): ?>
        <div class="modal show d-block paymentPage" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Payment to Satyam Arya</h5>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?= ($_GET['delevery-type'] == 'normal') ? 'source/Payment/40rs.jpg' : 'source/Payment/60rs.jpg' ?>"
                            class="rounded" width="200" alt="<?= ($_GET['delevery-type'] == 'normal') ? '40Rs' : '60Rs' ?>">
                        <hr class="my-3">
                       
                        <?php if ($_GET['price']): ?>
                            <?php
                            $paymentLink = ($_GET['delevery-type'] == 'normal') ? 'upi://pay?pa=satyoannpurna01-1@okicici&pn=Satyam%20arya&am=40.00&cu=INR&aid=uGICAgIDV_6-4HA' : 'upi://pay?pa=satyoannpurna01-1@okicici&pn=Satyam%20arya&am=60.00&cu=INR&aid=uGICAgIDV_6-4HA';
                            ?>
                            <a href="<?= $paymentLink ?>" class="btn btn-primary">
                                Pay Now
                                <?= $_GET['price'] ?> <i class="fa-solid fa-indian-rupee-sign"></i>
                            </a>
                        <?php endif; ?>
                        <div class="alert alert-warning mt-3 mb-3 rounded" role="alert">
                        <strong>Complete your transaction in <span id="countdown-payment"></span>.</strong>

                        </div>
                        <script>
                            var seconds = 60;

                            function updateCountdown() {
                                document.getElementById('countdown-payment').innerHTML = seconds + ' seconds';
                                seconds--;

                                if (seconds < 0) {
                                    window.location.href = "payment-status.php";
                                    <?php $_SESSION['send-mail'] = ""; ?>
                                } else {
                                    setTimeout(updateCountdown, 1000);
                                }
                            }

                            updateCountdown();
                        </script>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <main class="cart-container">
        <div class="item-flex">
            <section class="checkout">
                <h2 class="section-heading">Payment Details</h2>
                <div class="payment-form">
                    <form method="post">
                        <div class="cardholder-name">
                            <label for="cardholder-name" class="label-default">
                                Enter Name 
                            </label>

                            <input type="text" name="fullname" placeholder="Write Your Original Name on Your Payment App" id="cardholder-name" class="input-default"
                                 required />
                        </div>


                        <input type="hidden" name="email" id="cardholder-name" value="<?php echo $userEmail ?>"
                            class="input-default" />

                        <div class="cardholder-name">
                            <label for="cardholder-name" class="label-default">
                                UPI ID
                            </label>
                            <input type="email" name="upiid" id="cardholder-name"
                                placeholder="Enter Your UPI ID for Payment" class="input-default" required />
                        </div>
                        <div class="card-number">
                            <label for="card-number" class="label-default">
                                Mobile Number
                            </label>
                            <input type="number" name="phone" id="card-number"
                                placeholder="Enter Your Whatsapp Number for Delivery" class="input-default" required />
                        </div>
                        <button class="btn btn-prinary" type="submit" name="payment">
                            <b>Pay</b> <i class="fa-solid fa-indian-rupee-sign"></i> <span id="payAmount">
                                <?php
                                $deliveryCosts = [
                                    "normal" => 40,
                                    "extreme" => 60
                                ];
                                if (isset($deliveryType) && array_key_exists($deliveryType, $deliveryCosts)) {
                                    echo $deliveryCosts[$deliveryType];
                                } else {
                                    echo "Invalid delivery type";
                                }
                                ?>
                            </span>
                        </button>
                    </form>
                </div>
            </section>
            <section class="cart">
                <div class="cart-item-box">
                    <h2 class="section-heading">Order Summery</h2>
                    <?php if (isset($deliveryType) && ($deliveryType === "extreme" || $deliveryType === "normal")): ?>
                        <div class="product-card">
                            <div class="cart-card">
                                <div class="img-box">
                                    <img src="source/offers/<?php echo ($deliveryType === "extreme") ? 'bestoffer.jpg' : 'specialoffer.jpg'; ?>"
                                        alt="img not found" class="product-img" width="80px" />
                                </div>
                                <div class="detail">
                                    <h4 class="product-name">
                                        <?php echo ucfirst($deliveryType); ?> Delivery
                                    </h4>
                                    <div class="wrapper">
                                        <div class="price">
                                            <i class="fa-solid fa-indian-rupee-sign"></i> <span id="price">
                                                <?php echo ($deliveryType === "extreme") ? '190' : '100'; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
                $extremePrice = 170;
                $normalPrice = 100;
                $extremeDiscount = 110;
                $normalDiscount = 60;
                $price = 0;
                $discount = 0;
                if (isset($deliveryType)) {
                    if ($deliveryType === "extreme") {
                        $price = $extremePrice;
                        $discount = $extremeDiscount;
                    } elseif ($deliveryType === "normal") {
                        $price = $normalPrice;
                        $discount = $normalDiscount;
                    }
                }
                $total = $price - $discount;
                ?>
                <hr>
                <div class="wrapper">
                    <div class="amount">
                        <div class="subtotal">
                            <span>Subtotal</span><span><i class="fa-solid fa-indian-rupee-sign"></i> <span
                                    id="subtotal">
                                    <?php echo $price; ?>
                                </span></span>
                        </div>
                        <div class="discount">
                            <span>Discount</span><span><i class="fa-solid fa-indian-rupee-sign"></i> <span
                                    id="discount">
                                    <?php echo "-" . $discount; ?>
                                </span></span>
                        </div>
                        <div class="total">
                            <span>Total</span><span class="alert alert-success"><i
                                    class="fa-solid fa-indian-rupee-sign"></i> <span id="total">
                                    <?php echo $total; ?>
                                </span></span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
<?php
if (isset($_POST['payment'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $upiid = $_POST['upiid'];
    $user_id = $_SESSION['user_id'];
    $randomToken = $_SESSION['txt-id'];

    $insertQuery = "INSERT INTO `payment-details` (fullname, email,upi_id,date,txt_id,txt_type, phone,txt_status,user_id,paid_amount,delivery_pan) VALUES ('{$name}', '{$email}','{$upiid}',NOW(),'$randomToken', 'UPI','$phone','Pending',' $user_id','$total','$deliveryType')";
    $result = mysqli_query($con, $insertQuery);
    if ($result) {
        echo "<script> window.location.href = 'my-poetry-cart.php?delevery-type=$deliveryType&transaction=status&price=$total'</script> ";
    } else {
        echo "error" ;
    }

    $notiInstert = "INSERT INTO `notification`(`title`, `url`, `date`) VALUES ('$name Just complete Their Payment','payment.php',NOW())"; 
    $result = mysqli_query($con, $notiInstert);
    if (!$result) {
        echo "Erorr";
    }
} ?>