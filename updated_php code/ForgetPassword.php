<?php
// Include the password reset logic
require_once "password-reset-code.php";
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
            /* background-color: #fff; */
            padding: 30px;
            margin-left:30%;            border-radius: 16px;
            background-color: rgba(0, 0, 0, 0.08) 0px 4px 12px;
        }

        .title-section {
            margin-bottom: 30px;
            color: #fff;
        }

        .title {
            color: #fff;
            font-size: 25px;
            font-weight: 500;
            text-transform: capitalize;
            margin-bottom: 10px;
        }

        .para {
            color: rgba(255, 255, 255, 0.95);
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
    background-color: transparent; /* Set background color to transparent */
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
        
        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <?php if(isset($_SESSION['status'])): ?>
          <div class="message <?php echo ($_SESSION['status'] == 'We e-mailed you a password reset link') ? 'success' : 'error'; ?>">
            <?php echo $_SESSION['status']; ?>
          </div>
          <?php unset($_SESSION['status']); ?>
        <?php endif; ?>
        <div class="title-section">
            <h2 class="title">Reset Password</h2>
            <p class="para">
                Enter your email address below. We'll send you a link to reset your password.
            </p>
        </div>

        <form method="POST" action="" class="from">
            <div class="input-group">
                <label for="email" class="label-title">Enter your Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" />
                <span class="icon">&#9993;</span>
            </div>

            <div class="input-group">
                <button class="submit-btn" name="password_reset_link" type="submit">Send Reset Link</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>