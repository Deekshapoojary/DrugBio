<?php
session_start();

// Include the database connection file
include 'connect.php'; // Make sure this file contains database connection details

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'drugbiosecure@Gmail.com';
    $mail->Password = 'ngmmqtndgurjxqne';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('drugbiosecure@gmail.com', $get_name); // Change sender name if needed
    $mail->addAddress($get_email, $get_name);
    $mail->isHTML(true);
    $mail->Subject = 'Reset Password Notification';
    $email_template = "
         <h2>Hello $get_name</h2>
         <p>You are receiving this email because we received a password reset request for your account.</p>
         <p><a href='http://localhost/drug_effect_prediction/passwordchange.php?token=$token&email=$get_email'>Click Here to Reset Password</a></p>
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
    $email = mysqli_real_escape_string($con, $_POST['email']); // Sanitize email input

    // Check if the email exists in the database
    $check_email = "SELECT firstname, email FROM sign_up WHERE email=? LIMIT 1";
    $stmt = mysqli_prepare($con, $check_email);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        $_SESSION['status'] = "Database query error: " . mysqli_error($con);
        header("Location: ForgetPassword.php");
        exit(0);
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $get_name = $row['firstname'];
        $get_email = $row['email'];

        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Update the user's record with the token
        $update_token = "UPDATE sign_up SET verify_token=? WHERE email=?";
        $stmt = mysqli_prepare($con, $update_token);
        mysqli_stmt_bind_param($stmt, "ss", $token, $email);
        $update_token_run = mysqli_stmt_execute($stmt);

        if (!$update_token_run) {
            $_SESSION['status'] = "Error updating token: " . mysqli_error($con);
            header("Location: ForgetPassword.php");
            exit(0);
        }

        // Send the password reset email
        if (send_password_reset($get_name, $get_email, $token)) {
            $_SESSION['status'] = "We e-mailed you a password reset link";
        } else {
            $_SESSION['status'] = "Failed to send password reset email";
        }
    } else {
        $_SESSION['status'] = "No Email Found";
    }

    // Redirect to appropriate page
    header("Location: ForgetPassword.php");
    exit(0);
}

// Handle password reset form submission
if (isset($_POST['password_resets'])) {
    // Extracting email, new password, confirm password, and token from the POST data
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($con, $_POST['password_token']);

    // Checking if all necessary fields are filled
    if (!empty($token) && !empty($email) && !empty($new_password) && !empty($confirm_password)) {
        // Check if the token is valid
        $check_token = "SELECT verify_token FROM sign_up WHERE verify_token=? LIMIT 1";
        $stmt = mysqli_prepare($con, $check_token);
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            $_SESSION['status'] = "Database query error: " .mysqli_error($con);
            header("Location: passwordchange.php?token=$token&email=$email");
            exit(0);
        }

        if (mysqli_num_rows($result) > 0) {
            // Token is valid, now check if passwords match
            if ($new_password == $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password
                $update_password = "UPDATE sign_in SET password=? WHERE verify_token=? LIMIT 1";
                $stmt = mysqli_prepare($con, $update_password);
                mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $token);
                $update_password_run = mysqli_stmt_execute($stmt);

                if (!$update_password_run) {
                    $_SESSION['status'] = "Error updating password: " .mysqli_error($con);
                    header("Location:passwordchange.php?token=$token&email=$email");
                    exit(0);
                } else {
                    // Password updated successfully
                    // Generate a new token
                    $new_token = md5(rand()) ."funda";
                    $update_to_new_token = "UPDATE sign_in SET verify_token=? WHERE verify_token=? LIMIT 1";
                    $stmt = mysqli_prepare($con, $update_to_new_token);
                    mysqli_stmt_bind_param($stmt, "ss", $new_token, $token);
                    mysqli_stmt_execute($stmt);

                    $_SESSION['status'] = "New Password Successfully Updated!";
                    header("Location: patient_details.php?token=$token&email=$email"); // Changed file extension to .php
                    exit(0);
                }
            } else {
                // Passwords don't match
                $_SESSION['status'] = "Password and confirm password don't match";
                header("Location: passwordchange.php?token=$token&email=$email");
                exit(0);
            }
        } else {
            // Invalid token
            $_SESSION['status'] = "Invalid Token";
            header("Location: passwordchange.php?token=$token&email=$email");
            exit(0);
        }
    } else {
        // Missing fields
        $_SESSION['status'] = "All Fields are Mandatory";
        header("Location: passwordchange.php?token=$token&email=$email");
        exit(0);
    }
}

// Close the database connection
mysqli_close($con);
?>


