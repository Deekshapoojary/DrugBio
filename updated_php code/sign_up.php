<?php
session_start();

// Include the database connection file
include 'connect.php'; 

// Function to validate email domain
function isValidEmailDomain($email, $domain) {
    $email_parts = explode('@', $email);
    if (count($email_parts) == 2 && $email_parts[1] == $domain) {
        return true;
    }
    return false;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security to prevent SQL injection
    $Firstname = $con->real_escape_string($_POST['firstname']);
    $Lastname = $con->real_escape_string($_POST['lastname']);
    $Email = $con->real_escape_string($_POST['email']);
    $Password = $con->real_escape_string($_POST['password']);

    // Validate email domain
    if (!isValidEmailDomain($Email, 'gmail.com') && !isValidEmailDomain($Email, 'edu.in')) {
        // Set error message in session
        $_SESSION['status'] = 'Please enter a valid Gmail or edu.in address.';
        // Redirect back to the sign-up page
        header("Location: patient_details.php");
        exit(); // Terminate script execution after redirection
    } else {
        // Hash the password
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

        // Attempt insert query execution
        $sql = "INSERT INTO sign_up (firstname, lastname, email, password) 
                VALUES ('$Firstname', '$Lastname', '$Email', '$hashedPassword')";
        if ($con->query($sql) === true) {
            echo "Records inserted successfully.";
        } else {
            echo "ERROR: Could not able to execute $sql. " .$con->error;
        }
    }
}

// Close connection
$con->close();
?>
