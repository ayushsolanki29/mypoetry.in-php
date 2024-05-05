<?php
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

$fb = new Facebook([
  'app_id' => '1438662513411600',
  'app_secret' => 'dea0354921c2a31744420fea0560eaa9',
  'default_graph_version' => 'v12.0',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email'];

if (isset($_GET['login'])) {
    try {
        $accessToken = $helper->getAccessToken();
    } catch (FacebookResponseException $e) {
        // Handle Graph API errors
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (FacebookSDKException $e) {
        // Handle SDK errors
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    if (isset($accessToken)) {
        try {
            // Get user data from Facebook
            $response = $fb->get('/me?fields=id,name,email', $accessToken);
            $userData = $response->getGraphNode()->asArray();

            // Get user details
            $fbid = $userData['id'];
            $fbfullname = $userData['name'];
            $femail = $userData['email'];

            // Store user data in session variables
            $_SESSION['FBID'] = $fbid;
            $_SESSION['FULLNAME'] = $fbfullname;
            $_SESSION['EMAIL'] = $femail;

            // Redirect to your desired location after successful login
            header("Location: index.php");
            exit;
        } catch (FacebookResponseException $e) {
            // Handle Graph API errors
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            // Handle SDK errors
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    } else {
        echo 'Login failed. Please try again.';
        exit;
    }
}
?>