<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security - SQL INJECTIONS ATTACKS
    $Firstname = $conn->real_escape_string($_POST['Firstname']);
    $Lastname = $conn->real_escape_string($_POST['Lastname']);
    $Email = $conn->real_escape_string($_POST['email']);
    $Password = $conn->real_escape_string($_POST['password']);

    // Hash the password
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Attempt insert query execution
    $sql = "INSERT INTO signup (Firstname, Lastname, email, password) 
            VALUES ('$Firstname', '$Lastname', '$Email', '$hashedPassword')";
    if ($conn->query($sql) === true) {
        echo "Records inserted successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . $conn->error;
    }

    // Close connection
    $conn->close();
}
