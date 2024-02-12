<?php
// Database configuration
$servername = "localhost"; // Change this to your database server if it's different
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password if you have one
$dbname = "test"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security - SQL INJECTIONS ATTACKS
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $branch = $conn->real_escape_string($_POST['branch']);
    $year = $conn->real_escape_string($_POST['year']);

    // Attempt insert query execution
    $sql = "INSERT INTO users (firstname, lastname, email, username, password, branch, year) 
            VALUES ('$firstname', '$lastname', '$email', '$username', '$password', '$branch', '$year')";
    if($conn->query($sql) === true){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . $conn->error;
    }
    
    // Close connection
    $conn->close();
}
?>