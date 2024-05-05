<?php $msg = "";
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $delivery_type = $_POST["delivery_type"];
        $person_name = $_POST["person_name"];
        $language = $_POST["language"];
        $relation_status = $_POST["relation_status"];
        $payment_status = "Pending";
        $image_path = null;
        $_SESSION['person_name'] =  $person_name ;

        if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
            $target_dir = "source/odered_persons/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
            if (in_array($imageFileType, $allowed_extensions)) {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $image_path = $target_file;
                } else {
                    $msg = "<div class='alert alert-danger'>Error uploading file.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.</div>";
            }
        }
        function generateRandomToken($length = 10)
        {
            $token = '';
            $characters = '0123456789';
    
            $max = strlen($characters) - 1;
            for ($i = 0; $i < $length; $i++) {
                $token .= $characters[random_int(0, $max)];
            }
            return $token;
        }
        $randomToken = 'TXS' . generateRandomToken(10) . 'MYPI';
    
        $_SESSION['txt-id'] = $randomToken;
        // Insert into the database
        $sql = "INSERT INTO poetry_delivery (user_id, delevery_type, person_name, language, relation_status, payment_status, person_img,txt_id)
                VALUES ('$user_id', '$delivery_type', '$person_name', '$language', '$relation_status', '$payment_status', '$image_path','$randomToken')";

        if ($con->query($sql) === TRUE) {
            $msg = "<div class='alert alert-success'>Order placed successfully! but Your Payment is Still Pending <a href='cart.php'>click here</a></div>";
            echo "<script>window.location.href = 'my-poetry-cart.php?delevery-type=$delivery_type';</script>";
            $_SESSION['delevery-type'] = $delivery_type;
        } else {
            $msg = "<div class='alert alert-danger'>Error: " . $con->error . "</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Please Login to access this Feature. <a href='login.php'>Click Here For Login</a> </div>";
    }
}
?>
<section class="book_section layout_padding">
    <div class="container">
        <div class="heading_container" id="book_section">
            <h2>
                Personalized <span class="top3"> Poetry </span>
            </h2>
        </div>
        <?php echo $msg ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form_container">
                    <form method="post"  enctype="multipart/form-data">
                        <div class="cust_file_upload">
                            <input type="file" name="file" id="file"  accept="image/*" style="opacity:0">
                            <div class="img-area" data-img="" for="file" title="Please upload image">
                                <i class='bx bxs-cloud-upload icon'></i>
                                <h3>Upload Image</h3>
                                <p>Why share an image?</p>
                                <ul>
                                    <li><span>Emotion : </span> Adds depth to your verses.</li>
                                    <li><span>Creativity : </span> Fuels beautiful poetry.</li>
                                    <li><span>Personal : </span> Reflects your individuality.</li>
                                </ul>
                                <p>Your image makes poetry uniquely yours.</p>

                            </div>
                            <button type="button" class="select-image">Select Image</button>
                        </div>
                        <div class="mt-3" id="personalized">
                            <select class="form-control nice-select wide" id="deliverySelect" name="delivery_type" required>
                                <option value="normal" onclick="handleOptionClick('normal')">Normal Delivery</option>
                                <option value="extreme" onclick="handleOptionClick('extreme')">Extreme Delivery</option>
                            </select>
                        </div>


                        <div>
                            <input type="text" class="form-control" placeholder="Person Name" name="person_name" required/>
                        </div>
                        <div>
                            <select class="form-control nice-select wide" name="language" required>
                                <option value="" disabled selected>
                                    Select Your Language For Poetry
                                </option>
                                <option value="Hindi">
                                    Hindi
                                </option>
                                <option value="English">
                                    English
                                </option>
                                <option value="Gujarati">
                                    Gujarati
                                </option>
                                <option value="Bhojpuri">
                                    Bhojpuri
                                </option>
                            </select>
                        </div>
                        <div>
                            <select class="form-control nice-select wide" name="relation_status" required>
                                <option value="" disabled selected>
                                    Relation Status
                                </option>
                                <option value="Love">
                                    Love
                                </option>
                                <option value="Friend Male / Female">
                                    Friend Male / Female
                                </option>
                                <option value="Normal Person">
                                    Normal Person
                                </option>
                                <option value="Father / Mother">
                                    Father / Mother
                                </option>
                            </select>
                        </div>


                        <div class="btn_box" >
                            <button id="btn_price" name="oder_now" type="submit">
                                Order Now
                            </button>
                           
                        </div>
                    </form>
                </div>
            </div>
            <!-- strt cholec crd -->
            <div class="price_container ">


                <div class="plan">
                    <div class="inner">
                        <span class="pricing"> Only &nbsp;<span><i class="fa-solid fa-indian-rupee-sign"></i> 60</span>
                        </span>
                        <p class="title">Extreme Delivery</p>
                        <p class="info">Get your poetry delivered in record time with our Extreme Delivery service. Our
                            team is dedicated to providing you with the best experience</p>
                        <ul class="features">
                            <li>
                                <span class="icon">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>
                                <span><strong>Under 12h</strong> Delivery</span>
                            </li>
                            <li>
                                <span class="icon">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>
                                <span>Get Delivery in<strong> Whatsapp</strong></span>
                            </li>
                            <li>
                                <span class="icon">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>
                                <span>Extra <strong>Custumization</strong></span>
                            </li>
                            <li>
                                <span class="icon">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>
                                <span><strong>Photo + Music </strong> Delivery</span>
                            </li>
                            <li>
                                <span class="icon">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>
                                <span>And Much <strong>More... </strong></span>
                            </li>
                        </ul>
                        <div class="action">
                            <a href="#personalized" class="button" style="cursor: pointer;" id="checkButton">
                                Choose plan
                            </a>
                        </div>
                        <!-- end cholec crd -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end book section -->