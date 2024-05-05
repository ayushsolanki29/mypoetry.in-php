<?php
include 'auth/config.php';
session_start();
if (isset($_POST['rating']) && isset($_POST['feedbacktext'])) {
    $rating = $_POST['rating'];
    $feedbackText = $_POST['feedbacktext'];

    if (empty($rating) || empty($feedbackText)) {
        echo "Please fill out both rating and feedback fields.";
    } else {
        $start = $_POST['rating'];
        $feedbacktext = $_POST['feedbacktext'];
        $userId = $_POST['userId'];
        $userName = $_POST['userName'];
        $userImg = $_POST['userPic'];
        $query = "INSERT INTO feedback (user_id, user_name, rating, description, user_img) VALUES ('$userId', '$userName', '$start', '$feedbacktext', '$userImg')";
        if (mysqli_query($con, $query)) {
            $updateQuery = "UPDATE users SET feedback='True' WHERE user_id='$userId'";
            if (mysqli_query($con, $updateQuery)) {
                $_SESSION['profile-msg'] = "Feedback Submited";
                header("Location:user-profile.php?profile-msg=success");
                exit;
            } else {
                $_SESSION['profile-msg'] = "Feedback Not Submited";
                header("Location:user-profile.php?profile-msg=info");
            }
        } else {
            $_SESSION['profile-msg'] = "Feedback Not Submited";
            header("Location:user-profile.php?profile-msg=info");
        }
    }
} else {
    $_SESSION['profile-msg'] = "Invalid form submission.";
            header("Location:user-profile.php?profile-msg=danger");
}

if (isset($_POST['resetPic'])) {
    $user_id = $_POST['userid'];
    $update = "UPDATE `users` SET userprofile='source/profile/defult.jpg' WHERE user_id='$user_id'";
    $result = mysqli_query($con, $update);
    if ($result) {
        $_SESSION['profile-msg'] = "Profile Change To Default";
        header("Location:user-profile.php?profile-msg=success");
        exit;
    } else {
        $_SESSION['profile-msg'] = "Profile Not Changed";
        header("Location:user-profile.php?profile-msg=info");
    }
}
if (isset($_POST['uploadPic'])) {
    $user_id = $_POST['userid'];
    $userName = $_POST['username'];
    $file = $_FILES['profile'];
    $filename = $file['name'];
    $filetmp = $file['tmp_name'];
    $fileerror = $file['error'];

    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    $valid_file_ext = array('png', 'jpg', 'jpeg');

    if ($fileerror == 0) {
        if (in_array(strtolower($file_ext), $valid_file_ext)) {
            $new_filename = $userName . '.' . $file_ext;
            $destfile = 'source/Profile/' . $new_filename;
            if (move_uploaded_file($filetmp, $destfile)) {
                $update = "UPDATE `users` SET userprofile='$destfile' WHERE user_id='$user_id'";
                $result = mysqli_query($con, $update);
                if ($result) {
                    $_SESSION['profile-msg'] = "Profile picture uploaded successfully";
                    header("Location:user-profile.php?profile-msg=success");
                } else {
                    $_SESSION['profile-msg'] = "Failed to update profile picture";
                    header("Location:user-profile.php?profile-msg=info");
                }
            } else {
                $_SESSION['profile-msg'] = "File upload failed";
                header("Location:user-profile.php?profile-msg=danger");
            }
        } else {
            $_SESSION['profile-msg'] = "Invalid file format. Only JPG, PNG, and JPEG files are allowed.";
            header("Location:user-profile.php?profile-msg=info");
        }
    } else {
        $_SESSION['profile-msg'] = "File upload failed";
        header("Location:user-profile.php?profile-msg=danger");
    }
}

function isUsernameExists($con, $newUsername, $userIdResult)
{
    $checkQuery = "SELECT * FROM users WHERE username='$newUsername' AND user_id != '$userIdResult'";
    $checkResult = mysqli_query($con, $checkQuery);
    return mysqli_num_rows($checkResult) > 0;
}

// Function to check if a new email already exists
function isEmailExists($con, $newEmail, $userIdResult)
{
    $checkQuery = "SELECT * FROM users WHERE useremail='$newEmail' AND user_id != '$userIdResult'";
    $checkResult = mysqli_query($con, $checkQuery);
    return mysqli_num_rows($checkResult) > 0;
}

if (isset($_POST['saveChanges'])) {
    $userIdResult = mysqli_real_escape_string($con, $_POST['userid']);
    $newUsername = mysqli_real_escape_string($con, $_POST['username']);
    $newEmail = mysqli_real_escape_string($con, $_POST['email']);
    $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Check if the new username or email already exists
    $isUsernameTaken = isUsernameExists($con, $newUsername, $userIdResult);
    $isEmailTaken = isEmailExists($con, $newEmail, $userIdResult);

    if ($isUsernameTaken) {
        $_SESSION['profile-msg'] = "Username already exists. Please choose another one.";
        header("Location:user-profile.php?profile-msg=info");

    } elseif ($isEmailTaken) {
        $_SESSION['profile-msg'] = "Email already exists. Please choose another one.";
        header("Location:user-profile.php?profile-msg=info");
    } else {
        $updateQuery = "UPDATE users SET username='$newUsername', useremail='$newEmail', userpassword='$newPassword' WHERE user_id='$userIdResult'";
        if (mysqli_query($con, $updateQuery)) {
            $_SESSION['profile-msg'] = "Profile Updated !!";
            header("Location:user-profile.php?profile-msg=success");
        } else {
            $_SESSION['profile-msg'] = "Profile Update failed";
            header("Location:user-profile.php?profile-msg=danger");
        }
    }
}
?>