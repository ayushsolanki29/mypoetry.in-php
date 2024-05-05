<?php
session_start();
include "auth/config.php";
mysqli_set_charset($con, "utf8");
$msg = "";
$user_id = isset($_SESSION['user-id']) ? $_SESSION['user-id'] : null;

if (isset($_POST['submit'])) {
    if (!isset($_SESSION['user_id'])) {
        $msg = "<div class='alert alert-danger'>Please Login First</div>";
        header("Location: login.php");
        exit;
    }



    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $state = $_POST['state'];
    $poetry = $_POST['poetry'];
    $format = $_POST['poetryFormate'];
    $otherstate = $_POST['otherstate'] ?? '';
    $destfile = '';
    $token = $_GET['tonrnament-token'];

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($state && !empty($format))) {
        if (isset($_FILES['poetryfile']) && $_FILES['poetryfile']['error'] === 0) {
            $filename = $_FILES['poetryfile']['name'];
            $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
            $valid_extensions = ['png', 'jpg', 'jpeg'];

            if (in_array(strtolower($file_ext), $valid_extensions)) {
                $destfile = 'source/poetryfile/' . $filename;
                move_uploaded_file($_FILES['poetryfile']['tmp_name'], $destfile);
            } else {
                $msg = "<div class='alert alert-danger'>Only supported extensions are JPG, PNG, JPEG.</div>";
            }
        }
        $insert_sql = "INSERT INTO `tornament` (  `name`, `email`, `mobile`, `state`, `otherstate`, `poetry`, `poetryfile`, `date`, `tornament-token`) VALUES ('$name', '$email', '$phone', '$state', '$otherstate', '$poetry',' $destfile',NOW(),'$token')";
        $result = mysqli_query($con, $insert_sql);

        if ($result) {
            $msg = !empty($destfile) ? "<div class='alert alert-success'>Poetry submited successfully with Photo</div>" : "<div class='alert alert-success'>Poetry submited successfully</div>";
            $notiInstert = "INSERT INTO `notification`(`title`, `url`, `date`) VALUES ('$name Just Submited Tornament','Tornament.php',NOW())";
            $result = mysqli_query($con, $notiInstert);
            if (!$result) {
                echo "Erorr";
            }
        } else {
            $msg = "<div class='alert alert-danger'>PoetryNot sent. Error: " . mysqli_error($con) . "</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>Please Fill in all the required fields</div>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <?php include 'pages/meta.html' ?>
    <title>Tournament Form - MyPoetry.in</title>
    <meta name="title" content="Tournament Form - MyPoetry.in">
    <meta name="description"
        content="Participate in poetry tournaments on MyPoetry.in. Fill out the Tournament Form to showcase your poetic skills and compete with fellow wordsmiths. Join the excitement and let your verses shine.">
    <meta name="keywords"
        content="Tournament Form, Poetry Tournaments, MyPoetry.in, Participate, Poetry Competitions, Showcase Verses, Wordsmiths, Poetic Skills, Join the Excitement">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/tournament-form.php">
    <meta property="og:title" content="Tournament Form - MyPoetry.in">
    <meta property="og:description"
        content="Participate in poetry tournaments on MyPoetry.in. Fill out the Tournament Form to showcase your poetic skills and compete with fellow wordsmiths. Join the excitement and let your verses shine.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/tournament-form.php">
    <meta property="twitter:title" content="Tournament Form - MyPoetry.in">
    <meta property="twitter:description"
        content="Participate in poetry tournaments on MyPoetry.in. Fill out the Tournament Form to showcase your poetic skills and compete with fellow wordsmiths. Join the excitement and let your verses shine.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/tournament-form.php">

    <?php include 'pages/links.html'; ?>
    <link rel="stylesheet" href="styles/pricing.css">
    <style>
        .large-textarea {
            height: 150px !important;

            width: 100% !important;

        }
    </style>
</head>

<body class="sub_page">
    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="navabr">
        </div>
        <?php include 'pages/navbar.html' ?>
    </div>
    <?php if (isset($_GET['tonrnament-token']) && isset($_SESSION['tornament_token'])) {
        $get_token = $_GET['tonrnament-token'];
        $save_token = $_SESSION['tornament_token'];
        if ($get_token == $save_token) {
            ?>
            <div class="container mt-3 Tornament-page mb-3">
                <div class="text-center">
                    <h2 class="display-5 tonrnament-head">🏆 Fill Up This <span class="text-primary">Form</span> 🏆</h2>
                    <p class="lead">
                        Enter your details below and stay tuned! <span class="text-success"> The results will be announced via
                            email and on <a href="#"> Click Here</a></span>
                    </p>
                </div>

                <section class="book_section layout_padding">
                    <div class="container">
                        <?php echo $msg ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_container">
                                    <form method="post" enctype="multipart/form-data">
                                        <div>
                                            <input type="text" class="form-control tornament-inputs" placeholder="Full Name"
                                                name="name" required />
                                        </div>
                                        <div>
                                            <input type="email" class="form-control tornament-inputs"
                                                placeholder="Enter Your Email" name="email" required />
                                        </div>
                                        <div>
                                            <input type="text" class="form-control tornament-inputs"
                                                placeholder="Enter Your Phone" name="phone" required />
                                        </div>
                                        <div>
                                            <select class="form-control nice-select wide tornament-inputs" name="state"
                                                required>
                                                <option value="" disabled selected>Select Your State</option>
                                                <option value="gujarat">Gujarat</option>
                                                <option value="other">other</option>
                                            </select>
                                            <div class="form-group additional-field" style="display: none;">
                                                <label for="otherProblem">Please specify:</label>
                                                <input type="text" name="otherstate" placeholder="Your state name"
                                                    class="form-control tornament-inputs" id="otherProblem" name="otherstate">
                                            </div>
                                        </div>
                                        <div>
                                            <select class="form-control nice-select wide tornament-inputs" name="poetryFormate"
                                                required>
                                                <option value="" disabled selected>Select Formate of Poetry</option>
                                                <option value="text">Text (in words)</option>
                                                <option value="photo">File (Photo)</option>
                                            </select>
                                            <div class="form-group text-field" style="display: none;">
                                                <label for="otherProblem">Please specify:</label>
                                                <textarea class="form-control large-textarea" placeholder="Write Your Poetry"
                                                    name="poetry"></textarea>
                                            </div>

                                            <div class="form-group photo-field" style="display: none;">
                                                <label for="otherFile">Upload File</label>
                                                <input type="file" class="form-control tornament-inputs" id="otherProblem"
                                                    name="poetryfile">
                                            </div>
                                            <input type="hidden" name="token" value="<?php if (isset($_GET['tonrnament-token'])) {
                                                echo $_GET['tonrnament-token'];
                                            } ?>">
                                        </div>
                                        <div>

                                        </div>

                                        <div class="btn_box">
                                            <button name="submit" type="submit">
                                                Submit
                                            </button>

                                        </div>

                                    </form>
                                </div>

                            </div>
                            <div class="price_container">

                                <h2 class="display-6">🏆 Prize Pool: <span class="text-success">₹999</span></h2>
                                <p class="lead">Get a chance to win exciting cash <br> prizes for your poetic masterpiece <br>
                                    with certificates!</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <?php if (!isset($_SESSION['user_id'])) { ?>
                <div class="Card-center" id="loginpopup" style="backdrop-filter: blur(1px); user-select:none;">
                    <div class="not-loged">
                        <span class="title">Oops! It seems you're not logged in</span>
                        <div class="description">
                            <p>To unlock this feature, please log in to your account.</p>
                        </div>
                        <div class="actions">
                            <a href="privacy.php"><button class="pref">View Our Privacy Policy</button></a>
                            <a href="login.php"><button class="accept">Log In Now</button></a>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
        }
    } else {
        ?>
        <div class="container mt-3  mb-3">
            <div class="text-center">
                <h2 class="display-5 tonrnament-head">Tournament <span class="text-danger">Ended</span></h2>
                <p class="lead">
                    Thank you for your participation! <br> Stay tuned for our next exciting competition.<br>
                    <span class="text-info">New competition details will be announced soon.</span>
                </p>
            </div>
            <div class="countdown-card text-center">
                <div class="card-body">
                    <h2 class="card-title">New Tournament</h2>
                    <div id="countdown" class="display-3 font-weight-bold">Launching Shortly</div>
                    <p class="lead mt-3">Prepare to showcase your poetic talent in our upcoming event.</p>
                </div>
                <div class="card-footer text-muted">
                    <p>Stay tuned for updates and get ready to shine with your words!</p>
                </div>
            </div>
        </div>
        <?php
    } ?>
    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>


    <script>
        $(document).ready(function () {

            $('select.nice-select').niceSelect();

            // Handle change event of the dropdown
            $('select.nice-select').change(function () {
                var selectedValue = $(this).val();
                if (selectedValue === 'other') {
                    $('.additional-field').show();
                } else {
                    $('.additional-field').hide();
                }

                if (selectedValue === 'text') {
                    $('.text-field').show();
                } else {
                    $('.text-field').hide();
                }
                if (selectedValue === 'photo') {
                    $('.photo-field').show();
                } else {
                    $('.photo-field').hide();
                }
            });
        });
    </script>
</body>

</html>