<?php
require_once('vendor/autoload.php');
$clientID = "90983554445-5523jgn48n0088g5vmm5t0c6dch6c0l1.apps.googleusercontent.com";
$secret = "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";

$gclient = new Google_Client();

$gclient->setClientId($clientID);
$gclient->setClientSecret($secret);
$gclient->setRedirectUri('https://mypoetry.in/login.php');

$gclient->addScope('email');
$gclient->addScope('profile');?>