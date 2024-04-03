<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Drug Side Effects Analysis Result</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url("sipht.jpg");
      background-size: cover;
      background-repeat: no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .card {
      width: 300px;
      padding: 20px;
      border-radius: 10px;
      background-color: #4B0082;
      /* Purple background color */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      text-align: center;
    }

    .card h2 {
      color: #fff;
      /* White text color */
      margin-bottom: 20px;
    }

    .card p {
      color: #eee;
      /* Light gray text color */
      margin-bottom: 10px;
    }

    .card img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin-bottom: 20px;
    }
  </style>
</head>



<body>
  <div class="card">
    <h2>Drug Side Effects Analysis Result</h2>
    <div id="result">

      <?php
      $side_effects = $_POST['side_effects'];

      // Output the received data
      echo "<p>Side Effects: " . $side_effects . "</p>";

      // Database configuration
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "test"; // Replace with your actual database name

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Fetch data from the database
      $sql = "SELECT * FROM patient_details ORDER BY email DESC LIMIT 1"; // Assuming the email field is the primary key
      $result = $conn->query($sql);

      // Check if the query was successful
      if ($result === false) {
        echo "Error executing the SQL query: " . $conn->error;
      } else {
        // Check if any rows were returned
        if ($result->num_rows > 0) {
          // Output data of the latest row
          $row = $result->fetch_assoc();
          echo "<p>Name: " . $row["name"] . "</p>";
          echo "<p>Email: " . $row["email"] . "</p>";
          echo "<p>Age: " . $row["age"] . "</p>";
          echo "<p>Gender: " . $row["gender"] . "</p>";
          echo "<p>Drug Name: " . $row["Drug_name"] . "</p>";
          echo "<p>Quantity: " . $row["Drug_quantity"] . "</p>";
          echo "<p>Side Effects: " . $row["side_effects"] . "</p>";
          echo "<p>Severity: " . $row["severity_effect"] . "</p>";
          echo "<p>Duration: " . $row["duration_effect"] . " days</p>";
          echo "<p>Other Medications: " . ($row["Other_medication"] ?: 'None') . "</p>";
          echo "<p>Medical History: " . ($row["Medical_history"] ?: 'None') . "</p>";
        } else {
          echo "No data available";
        }
      }

      // Close database connection
      $conn->close();
      ?>
    </div>
  </div>

</body>

</html>