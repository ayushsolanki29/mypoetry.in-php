<?php
session_start();
include "auth/config.php";
$msg = "";
if (isset($_POST['contact'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $quiery = $_POST['quiery'];
    $message = $_POST['msg'];
    $additional = $_POST['additional'] ?? '';

    $destfile = ''; // Initialize $destfile variable

    if (!empty($name) && !empty($email) && !empty($quiery) && !empty($message)) {
        if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === 0) {
            $filename = $_FILES['screenshot']['name'];
            $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
            $valid_extensions = ['png', 'jpg', 'jpeg'];

            if (in_array(strtolower($file_ext), $valid_extensions)) {
                $destfile = 'source/bugs/' . $filename;
                move_uploaded_file($_FILES['screenshot']['tmp_name'], $destfile);
            } else {
                $msg = "<div class='alert alert-danger'>Only supported extensions are JPG, PNG, JPEG.</div>";
            }
        }

        $insert_sql = "INSERT INTO contact (name, email, quiery, additional, message, screenshot) VALUES ('$name', '$email', '$quiery', '$additional', '$message', '$destfile')";
        $result = mysqli_query($con, $insert_sql);

        if ($result) {
            $msg = !empty($destfile) ? "<div class='alert alert-success'>Message sent successfully with screenshot</div>" : "<div class='alert alert-success'>Message sent successfully</div>";

            $notiInstert = "INSERT INTO `notification`(`title`, `url`, `date`) VALUES ('$name Just Submit Contact Form','contact.php',NOW())";
            $result = mysqli_query($con, $notiInstert);
            if (!$result) {
                echo "Erorr";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Message not sent. Error: " . mysqli_error($con) . "</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>Please fill in all the required fields</div>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>
    <title>Contact Us - MyPoetry.in</title>
    <meta name="title" content="Contact Us - MyPoetry.in">
    <meta name="description"
        content="Get in touch with us at MyPoetry.in. Reach out for inquiries, feedback, or collaboration. We value your input and look forward to connecting with the poetry community.">
    <meta name="keywords" content="Contact Us, MyPoetry.in, poetry community, inquiries, feedback, collaboration">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/contact-us.php">
    <meta property="og:title" content="Contact Us - MyPoetry.in">
    <meta property="og:description"
        content="Get in touch with us at MyPoetry.in. Reach out for inquiries, feedback, or collaboration. We value your input and look forward to connecting with the poetry community.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/contact-us.php">
    <meta property="twitter:title" content="Contact Us - MyPoetry.in">
    <meta property="twitter:description"
        content="Get in touch with us at MyPoetry.in. Reach out for inquiries, feedback, or collaboration. We value your input and look forward to connecting with the poetry community.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/contact-us.php">

    <?php include 'pages/links.html'; ?>
    <link rel="stylesheet" href="styles/contact.css">

</head>
<style>
    .large-textarea {
        height: 150px !important;
        /* Set the desired height */
        width: 100% !important;
        /* Set the desired width */
    }
</style>

<body class="sub_page">
    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="navabr">
        </div>
        <?php include 'pages/navbar.html' ?>
    </div>
    <section class="book_section layout_padding">
        <div class="container">
            <div class="heading_container" id="book_section">
                <h2>
                    Conatct us <span class="top3"> MyPoetry </span>
                </h2>
            </div>
            <?php echo $msg ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form_container">
                        <?php if (isset($_POST['dev-contact'])) {
                            echo "<form action='https://formspree.io/f/xvonlzrw' method='POST'>";
                        } else {
                            echo "<form method='post' enctype='multipart/form-data'>";
                        } ?>

                        <div>
                            <input type="text" class="form-control" placeholder="Name" name="name" required />
                        </div>
                        <div>
                            <input type="email" class="form-control" placeholder="Email" name="email" required />
                        </div>
                        <div>
                            <select class="form-control nice-select wide" name="quiery" required>
                                <option value="" disabled selected>Select Your Quiery</option>
                                <option value="bugreport">Report Bug</option>
                                <option value="Contact Admin">Contact Admin</option>
                                <option value="Copyright issue">Copyright Issue</option>
                                <option value="Be a Partner">Be a Partner</option>
                                <option value="developer">Developer</option>
                                <option value="refund">Refund</option>
                                <option value="purchased-details">Purchased Details</option>
                                <option value="other">Other</option>
                            </select>

                            <!-- Additional text field -->
                            <div class="form-group additional-field" style="display: none;">
                                <label for="otherProblem">Please specify:</label>
                                <input type="text" placeholder="Your Quiery" name="additional" class="form-control"
                                    id="otherProblem" name="otherProblem">
                            </div>
                            <div class="form-group bugreport-field" style="display: none;">
                                <label for="otherProblem">Upload Screenshot</label>
                                <input type="file" placeholder="Your Problem" name="screenshot" class="form-control"
                                    id="otherProblem" name="otherProblem">
                            </div>
                        </div>
                        <div>
                            <textarea class="form-control large-textarea" placeholder="Write Your Message" name="msg"
                                required></textarea>
                        </div>

                        <div class="btn_box">
                            <button name="contact" type="submit">
                                Send Message
                            </button>
                            <button name="dev-contact" style="display: none;" class="developer-field bg-primary"
                                type="submit">
                                Direct Contact
                            </button>
                        </div>

                        </form>
                    </div>
                </div>
                <!-- strt cholec crd -->
                <div class="price_container">
                    <div class="contact-details">
                        <div class="notiglow"></div>
                        <div class="notiborderglow"></div>
                        <div class="notititle">Contact us</div>
                        <div class="notibody">
                            <p><b class="title">Admin:</b> Satyam Arya</p>
                            <p><b class="title">Email:</b><a href="mailto:admin@mypoetry.in"> admin@mypoetry.in</a> </p>
                            <p><b class="title">Phone:</b> +11234567890</p>
                            <p><b class="title">Location:</b> Gandhinagar, Gujarat</p>
                            <p><b class="title">Developer :</b> Dream Creation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
    <script>
        $(document).ready(function () {
            // Initialize NiceSelect
            $('select.nice-select').niceSelect();

            // Handle change event of the dropdown
            $('select.nice-select').change(function () {
                var selectedValue = $(this).val();
                if (selectedValue === 'other') {
                    $('.additional-field').show();
                } else {
                    $('.additional-field').hide();
                }
                if (selectedValue === 'bugreport') {
                    $('.bugreport-field').show();
                } else {
                    $('.bugreport-field').hide();
                }
                if (selectedValue === 'developer') {
                    $('.developer-field').show();
                } else {
                    $('.developer-field').hide();
                }
            });
        });
    </script>
</body>

</html>