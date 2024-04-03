<?php
// Start the session
session_start();

// Include the database connection file
require_once "connect.php";

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
            background: url("patient_details_img.jpg");
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
            background-color: #fff;
            padding: 30px;
            border-radius: 16px;
            background-color: rgba(0, 0, 0, 0.08) 0px 4px 12px;
        }

        .title-section {
            margin-bottom: 30px;
        }

        .title {
            color: #38475a;
            font-size: 25px;
            font-weight: 500;
            text-transform: capitalize;
            margin-bottom: 10px;
        }

        .para {
            color: #38476a;
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
            background-color: none;
            color: #38475a;
            height: 50px;
            font-size: 16px;
            font-weight: 300;
            border: 1px solid #eaecf0;
            padding: 9px 18px 9px 52px;
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
            top: calc(50%-11px);
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
<div class="wrapper">
    <div class="container">
        <div class="title-section">
            <h2 class="title">Reset Password</h2>
            <p class="para">
                Enter your email, new password, and confirm it below.
            </p>
        </div>

        <form method="POST" action="passwordchange.php" class="from">

            <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];} ?>">

            <div class="input-group">
                <label for="" class="label-title">Email</label>
                <input type="email" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];}?>" placeholder="Enter your email" required />
                <span class="icon">&#x1F512;</span>
            </div>

            <div class="input-group">
                <label for="" class="label-title">New Password</label>
                <input type="password" name="new_password" placeholder="Enter your new password" required />
                <span class="icon">&#x1F512;</span>
            </div>

            <div class="input-group">
                <label for="" class="label-title">Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm your password" required />
                <span class="icon">&#x1F512;</span>
            </div>

            <div class="input-group">
                <button class="submit-btn" name="password_resets" type="submit">submit</button>
            </div>
        </form>
    </div>
</div>



</body>
</html>
