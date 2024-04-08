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
            // Update login attempt count in the sign_up table
            $update_sql = "UPDATE sign_up SET login_attempts = login_attempts + 1 WHERE email=?";
            $update_stmt = $con->prepare($update_sql);
            $update_stmt->bind_param("s", $username);
            $update_stmt->execute();

            if ($update_stmt->affected_rows > 0) {
                // Set session variable for successful login
                $_SESSION['status'] = 'Login successful!';
                // Redirect user to drugEffect.html
                header("Location: drugEffect.html");
                exit();
            } else {
                // Error updating login attempt count
                $_SESSION['status'] = 'Error recording login attempt';
                header("Location: patient_details.php");
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
