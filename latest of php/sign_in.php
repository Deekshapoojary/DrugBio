<?php
session_start();

// Include the database connection file
include 'connect.php'; 


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security using prepared statements
    $username = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM sign_up WHERE email=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPasswordFromDB = $row["password"];

        // Verify password using password_verify
        if (password_verify($password, $hashedPasswordFromDB)) {
            // Check if user has already logged in
            $check_sql = "SELECT * FROM sign_up WHERE email=?";
            $check_stmt = $con->prepare($check_sql);
            $check_stmt->bind_param("s", $username);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows == 0) {
                // User has not logged in before, record login attempt in a separate table
                $insert_sql = "INSERT INTO sign_in (email) VALUES (?)";
                $insert_stmt = $con->prepare($insert_sql);
                $insert_stmt->bind_param("s", $username);
                $insert_stmt->execute();

                if ($insert_stmt->affected_rows > 0) {
                    // Set session variable for successful login
                    $_SESSION['status'] = 'Login successful!';
                    // Redirect user to drugEffect.html
                    header("Location: drugEffect.html");
                    exit();
                } else {
                    // Error recording login attempt
                    $_SESSION['status'] = 'Error recording login attempt';
                    header("Location: patient_details.php");
                    exit();
                }
            } else {
                // User has already logged in
                $_SESSION['status'] = 'User already logged in.';
                header("Location: drugEffect.html");
                exit();
            }
        } else {
            // Password is incorrect
            $_SESSION['status'] = 'Incorrect password.';
            header("Location: patient_details.php");
            exit();
        }
    } else {
        // User does not exist
        $_SESSION['status'] = 'User not found.';
        header("Location: patient_details.php");
        exit();
    }
}

// Close connection
$con->close();
?>