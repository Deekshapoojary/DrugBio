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
    $Username = $conn->real_escape_string($_POST['Username']);
    $Password = $conn->real_escape_string($_POST['Password']);
    $IPAddress = $conn->real_escape_string($_SERVER['REMOTE_ADDR']); // Get user's IP address

    // Attempt select query execution to check if user exists
    $sql = "SELECT * FROM signup WHERE email='$Username'"; // Assuming email is used for login
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists
        $row = $result->fetch_assoc();
        $hashedPasswordFromDB = $row["Password"];

        // Compare hashed password from DB with the entered password
        if (password_verify($Password, $hashedPasswordFromDB)) {
            // Password is correct, record login attempt in a separate table
            $sql = "INSERT INTO lognin (Username) 
                    VALUES ('$Username')";
            if ($conn->query($sql) !== true) {
                echo "Error recording login attempt: " . $conn->error;
            }

            echo "Login successful.";
        } else {
            // Password is incorrect
            echo "Incorrect password.";
        }
    } else {
        // User does not exist
        echo "User not found.";
    }

    // Close connection
    $conn->close();
}
