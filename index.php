<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Ifsnop\Mysqldump as IMysqldump;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $timestamp = date('Y-m-d_H-i-s'); // Current timestamp
    $filename = "awc_mart_$timestamp.sql"; // Filename with current timestamp
    $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=awc_mart', 'root', '');
    $dump->start("storage/$filename");
    // Server settings
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'acrh.mostak@gmail.com'; // SMTP username
    $mail->Password = 'ddacrxcwocjurqyo'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    // Sender
    $mail->setFrom('acrh.mostak@gmail.com', 'Database');

    // Recipients
    $mail->addAddress('acrh.mostak@gmail.com', 'Mostak'); // Add a recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = "Database Backup $timestamp";
    $mail->Body    = 'This is the  <b>Database Backup</b>';
    $mail->AltBody = 'This is the plain text version of the email message';
    $mail->addAttachment("storage/$filename");
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
