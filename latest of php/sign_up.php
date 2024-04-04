<?php
session_start();

// Include the database connection file
include 'connect.php'; 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security to prevent SQL injection
    $Firstname = $con->real_escape_string($_POST['firstname']);
    $Lastname = $con->real_escape_string($_POST['lastname']);
    $Email = $con->real_escape_string($_POST['email']);
    $Password = $con->real_escape_string($_POST['password']);

    
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

// Close connection
$con->close();
?>
