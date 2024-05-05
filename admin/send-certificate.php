<?php
include 'php/config.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';

$name = $_POST['name'];
$email = $_POST['email'];
$winrank = $_POST['winrank'];
$subject = "Congratulations : You Won $winrank Prize!";
$message = "Huge congrats on bagging the $winrank prize in MyPoetry Tournaments! 🌟 Your dedication stands out, and this win is just the beginning. Here's to your continued success!";

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'mail.mypoetry.in';
    $mail->SMTPAuth = true;
    $mail->Username = 'admin@mypoetry.in';
    $mail->Password = 'Oigv4F24m6';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('admin@mypoetry.in', 'mypoetry.in');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $templatePath = "mail/tornament.html";
    $templateContent = file_get_contents($templatePath);

    $templateContent = str_replace("{username}", $name, $templateContent);
    $templateContent = str_replace("{subject}", $subject, $templateContent);
    $templateContent = str_replace("{message}", $message, $templateContent);
    $templateContent = str_replace("{rank}", $winrank, $templateContent);
    $mail->Body = $templateContent;

    // Attach file
    $pdfUri = $_POST['pdfUri'];
    $pdfBytes = base64_decode(preg_replace('#^data:application/pdf;base64,#', '', $pdfUri));
    $mail->addStringAttachment($pdfBytes, 'Certificate.pdf', 'base64', 'application/pdf');

    $mail->send();
    echo "sent";
} catch (Exception $e) {
    echo "Fail";
}
?>