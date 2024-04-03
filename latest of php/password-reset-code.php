<?php
session_start();

// Include the database connection file
require_once "connect.php";

// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/autoload.php';

// Function to send password reset email
function send_password_reset($get_email, $token)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'drugbiosecure@Gmail.com';
    $mail->Password = 'ngmmqtndgurjxqne';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('drugbiosecure@gmail.com', $get_name);
    $mail->addAddress($get_email);
    $mail->isHTML(true);
    $mail->Subject = 'Reset Password Notification';
    $email_template = "
         <h2>Password Reset</h2>
         <p>You are receiving this email because we received a password reset request for your account.</p>
         <p><a href='http://localhost/passwordchange.php?token=$token'>Click Here to Reset Password</a></p>
    ";
    $mail->Body = $email_template;
    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Handle password reset link request
if (isset($_POST['password_reset_link'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Check if the email exists in the sign_in table
    $check_email = "SELECT email FROM sign_in WHERE email=? LIMIT 1";
    $stmt = $con->prepare($check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(32));

        // Update user's record with the token
        $update_token = "UPDATE sign_in SET verify_token=? WHERE email=?";
        $stmt = $con->prepare($update_token);
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Send password reset email
        if (send_password_reset($email, $token)) {
            $_SESSION['status'] = "We e-mailed you a password reset link";
        } else {
            $_SESSION['status'] = "Failed to send password reset email";
        }
    } else {
        $_SESSION['status'] = "No Email Found";
    }

    header("Location: ForgetPassword.php");
    exit();
}

// Handle password reset form submission
if (isset($_POST['password_resets'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($con, $_POST['password_token']);

    if (!empty($token) && !empty($email) && !empty($new_password) && !empty($confirm_password)) {
        $check_token = "SELECT verify_token FROM sign_in WHERE verify_token=? LIMIT 1";
        $stmt = $con->prepare($check_token);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            if ($new_password == $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $update_password = "UPDATE sign_in SET password=$new_password, verify_token=NULL WHERE verify_token=?";
                $stmt = $con->prepare($update_password);
                $stmt->bind_param("ss", $hashed_password, $token);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $_SESSION['status'] = "New Password Successfully Updated!";
                    header("Location: drugEffect.html");
                    exit();
                } else {
                    $_SESSION['status'] = "Error updating password";
                    header("Location: passwordchange.php?token=$token&email=$email");
                    exit();
                }
            } else {
                $_SESSION['status'] = "Password and confirm password don't match";
                header("Location: passwordchange.php?token=$token&email=$email");
                exit();
            }
        } else {
            $_SESSION['status'] = "Invalid Token";
            header("Location: passwordchange.php?token=$token&email=$email");
            exit();
        }
    } else {
        $_SESSION['status'] = "All Fields are Mandatory";
        header("Location: passwordchange.php?token=$token&email=$email");
        exit();
    }
}

mysqli_close($con);
?>
