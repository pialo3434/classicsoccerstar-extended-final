<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './libs/PHPMailer-master/src/Exception.php';
require './libs/PHPMailer-master/src/PHPMailer.php';
require './libs/PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Include the database connection file
    require 'db.php';

    // Check if an account with this email exists
    $stmt = $conn->prepare("SELECT * FROM player WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // An account with this email exists

        // Generate a unique token for password reset
        $token = bin2hex(random_bytes(50));

        // Store the token in your database associated with the user's email
        $stmt = $conn->prepare("UPDATE player SET password_reset_token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Prepare the email
        $to = $email;
        $subject = "Password Recovery";

        $message = "
        <html>
        <body>
            <img src='https://i.ibb.co/pdjRMZJ/soccerback.jpg' alt='Header Image' style='width: 510px; height: 250px;'>
            <h2 style='color: black;'>Password Reset Request</h2>
            <p style='font-size: 1.2em; color: black;'>Hello,</p>
            <p style='font-size: 1.2em; color: black;'>You have requested to reset your password. Please click on the link below:</p>
            <a href='http://classicsoccerstar-extended.ct8.pl/index.php?page=reset_password&token=$token' style='background-color: #008CBA; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;'>Reset Password</a>
            <p style='font-size: 1.2em; color: black;'>If you run into any issues, feel free to contact us on our Discord!</p>
            <p style='font-size: 1.2em; color: black;'>Best regards,</p>
            <p style='font-size: 1.2em; color: black;'><strong>Classicsoccerstar Team</strong></p>
        </body>
        </html>
    ";
        $mail = new PHPMailer(true);

        try {
            //Server settings (GMAIL)
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gmail's SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email_to_send_messages@gmail.com'; // Your Gmail email address
            $mail->Password = 'create_a_app_password_dont_use_default_password'; // Your Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use 'ssl' for Gmail
            $mail->Port = 465; // Use port 465 for 'ssl'

            //Recipients
            $mail->setFrom('your_email_to_send_messages@gmail.com', 'ClassicSoccerstar Team'); // Your Gmail email address and the name to display as the sender
            $mail->addAddress($to, 'Classicsoccerstar Team'); // The recipient's email address and name

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    } else {
        // No account with this email exists
        echo "No account found with this email.";
    }

    $stmt->close();
    $conn->close();
}
