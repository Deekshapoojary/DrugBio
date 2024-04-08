<?php
// Start the session
session_start();

// Include the database connection file
require_once "connect.php";

// Handle password reset form submission
if (isset($_POST['password_resets'])) {
    // Extracting email, new password, confirm password, and token from the POST data
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($con, $_POST['password_token']);

    // Checking if all necessary fields are filled
    if (!empty($token) && !empty($email) && !empty($new_password) && !empty($confirm_password)) {
        // Check if the token is valid using prepared statement
        $check_token = "SELECT verify_token FROM sign_up WHERE verify_token=?";
        $stmt = mysqli_prepare($con, $check_token);
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $check_token_run = mysqli_stmt_get_result($stmt);

        if (!$check_token_run) {
            echo "Database query error: " . mysqli_error($con);
        } elseif (mysqli_num_rows($check_token_run) > 0) {
            // Token is valid, now check if passwords match
            if ($new_password == $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the sign_up table
                $update_password = "UPDATE sign_up SET password='$hashed_password' WHERE verify_token='$token' LIMIT 1";
                $update_password_run = mysqli_query($con, $update_password);

                if (!$update_password_run) {
                    echo "Error updating password: " . mysqli_error($con);
                } else {
                    $_SESSION['status'] = "New Password Successfully Updated!";
                    // Redirect to the same page to display the message
                    header("Location: passwordchange.php?status=success");
                    exit();
                }
            } else {
                // Passwords don't match
                $_SESSION['status'] = "Password and confirm password don't match";
                header("Location: passwordchange.php?status=error");
                exit();
            }
        } else {
            // Invalid token
            $_SESSION['status'] = "Invalid Token";
            header("Location: passwordchange.php?status=error");
            exit();
        }
    } else {
        // Missing fields
        $_SESSION['status'] = "All Fields are Mandatory";
        header("Location: passwordchange.php?status=error");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "poppins", sans-serif;
        }

        body {
            background: url("backgroundimg7.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            overflow: hidden;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 110vh;
            background: rgba(39, 39, 39, 0.4);
        }

        .container {
            width: 500px;
            padding: 30px;
            margin-left: 40%;
            border-radius: 16px;
            background-color: rgba(0, 0, 0, 0.08) 0px 4px 12px;
        }

        .notification {
            position: absolute;
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 999;
            display: <?php echo isset($_SESSION['status']) ? 'block' : 'none'; ?>;
        }

        .title-section {
            margin-bottom: 30px;
        }

        .title {
            color: #fff;
            font-size: 25px;
            font-weight: 500;
            text-transform: capitalize;
            margin-bottom: 10px;
        }

        .para {
            color: #fff;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.5;
            margin-bottom: 20px;
            text-transform: capitalize;
        }

        .input-group {
            position: relative;
        }

        .input-group .label-title {
            color: #38475a;
            text-transform: capitalize;
            margin-bottom: 11px;
            font-size: 14px;
            display: block;
            font-weight: 500;
        }

        .input-group input {
            width: 100%;
            background-color: transparent;
            color: #38475a;
            height: 50px;
            font-size: 16px;
            font-weight: 300;
            border: 1px solid #eaecf0;
            padding: 2px 18px 9px 52px;
            outline: none;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .input-group input::placeholder {
            color: #38475a;
            font-size: 16px;
            font-weight: 400;
        }

        .input-group .icon {
            position: absolute;
            color: #38475a;
            left: 13px;
            top: calc(50% - 11px);
            text-align: center;
            font-size: 23px;
        }

        .submit-btn {
            width: 100%;
            background-color: #106fde;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 16px;
            color: #fff;
            padding: 13px 24px;
            font-weight: 500;
            text-align: center;
            text-transform: capitalize;
            cursor: pointer;
        }

        .submit-btn:hover {
            opacity: 0.95;
        }
    </style>
</head>
<body>
<div class="notification"><?php echo isset($_SESSION['status']) ? $_SESSION['status'] : ''; ?></div>
<div class="wrapper">
    <div class="container">
        <div class="title-section">
            <h2 class="title">Reset Password</h2>
            <p class="para">
                Enter your email, new password, and confirm it below.
            </p>
        </div>

        <form method="POST" action="passwordchange.php" class="from">

            <input type="" name="password_token"
                   value="<?php if (isset($_GET['token'])) {
                       echo $_GET['token'];
                   } ?>">

            <div class="input-group">
                <label for="" class="label-title">Email</label>
                <input type="email" name="email"
                       value="<?php if (isset($_GET['email'])) {
                           echo $_GET['email'];
                       } ?>" placeholder="Enter your email" required/>
                <span class="icon">&#x1F512;</span>
            </div>

            <div class="input-group">
                <label for="" class="label-title">New Password</label>
                <input type="password" name="new_password" placeholder="Enter your new password" required/>
                <span class="icon">&#x1F512;</span>
            </div>

            <div class="input-group">
                <label for="" class="label-title">Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm your password" required/>
                <span class="icon">&#x1F512;</span>
            </div>

            <div class="input-group">
                <button class="submit-btn" name="password_resets" type="submit">submit</button>
            </div>
        </form>
    </div>
</div>

<?php unset($_SESSION['status']); ?>
</body>
</html>
