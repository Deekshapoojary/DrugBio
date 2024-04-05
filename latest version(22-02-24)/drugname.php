<?php
include 'connect.php';
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css"
    />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url("helllllllooo.avif");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            overflow: auto;
        }

        /* --------------header------------- */

        .header img {
            width: 300px;
            height: 230px;
            margin-top: 0%;
            position: absolute;
            top: -9%;
            left: 0%;
        }

        .header {
            min-height: 100vh;
            width: 100%;
            background-position: center;
            background-size: cover;
            position: relative;
        }

        nav {
            display: flex;
            padding: 2% 6%;
            justify-content: space between;
            align-items: centers;
        }

        nav img {
            width: 100px;
        }

        .nav-links {
            flex: 1;
            text-align: right;
        }

        .nav-links ul li {
            list-style: none;
            display: inline-block;
            padding: 8px 12px;
            position: relative;
        }

        .nav-links ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font: bold;
            font-size: 15px;
        }

        .nav-links ul li::after {
            content: "";
            width: 0%;
            height: 2px;
            background: #f44336;
            display: inline-block;
            margin: auto;
            transition: 0.5s;
        }

        .nav-links ul li:hover::after {
            width: 100%;
        }


        /* ---------------input box----------- */

        input{
            position: absolute;
            top: 180px; /* Adjust the top position as needed */
            left: 30%;
            width:40vw;
            height:5vh;
      
        }

        button{
            position: absolute;
            top: 180px; /* Adjust the top position as needed */
            left: 71%;
            width:5vw;
       
        }
 
        .container2 {
            position: relative;
            top: -500px; /* Adjust this value as needed */
            justify-content: center;
            margin-left:10vh;
        }

        .text-danger{
            text-align:center;
            justify-content:center;
            margin-top:30vh;
            font-size:50px;
            
        }
        
        /* ---------------------table------------- */

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            border-bottom: 2px solid #ddd;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #ddd;
        }
      
       
       
        

        /* -----------------footer------------ */
        footer {
  background-color: lightblue;
  color: white;
  padding: 20px 0;
  text-align: center; /* Center align all content within the footer */
}

.footerContainer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
}

.socialIcons {
  display: inline-block;
  width: 40vw;
  height: 10vh;
  margin-left: 350px;
}

.socialIcons a {
  text-decoration: none;
  padding: 10px;
  margin: 0 20px;
  border-radius: 50%;
  background-color: white;
  color: black;
  position: relative;
  top: 10px;
}

.socialIcons a i {
  font-size: 2em;
  color: black;
  opacity: 0.9;
  position: relative;
  top: 10px;
}

.socialIcons a:hover {
  background-color: #111;
  transition: background-color 0.5s;
}

.socialIcons a:hover i {
  color: white;
  transition: color 0.5s;
}

.footerNav {
  width:70vw;
  margin-top: 120px; 
  margin-left: -1000px;
  /* Add margin to create space between socialIcons and footerNav */
}

.footerNav ul {
  list-style-type: none;
  display: flex;
  justify-content: center;
}

.footerNav ul li {
  margin: 0 20px; /* Adjust margin for spacing between navigation links */
}

.footerNav ul li a {
  color: white;
  text-decoration: none;
  font-size: 1.3em;
  opacity: 0.7;
  transition: color 0.5s;
}

.footerNav ul li a:hover {
  opacity: 1;
  color: #000;
}

.footerBottom {
  background-color: lightblue;
  padding: 20px;
  text-align: center; /* Center align text in the footer bottom */
}

.footerBottom p {
  color: white;
  margin-left: 100px;
}

.designer {
  opacity: 0.7;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 400;
}


    </style>
</head>

<body>

    <section class="header">
        <nav>
            <a href="next_page.html"> <img src="logotra.png" /></a>
            <div class="nav-links" id="navLinks">
                <ul>
                    <li><a style="color:#000" href="drugname.php">Drug Name</a></li>
                    <li><a style="color:#000" href="Drug_Effect.html">Drug Effect</a></li>
                    <li><a style="color:#000" href="patient_details.html">Patient Details</a></li>
                </ul>
            </div>
        </nav>
    </section>

    <div class="container1 my-5 ">
        <form method="post">
            <input type="text" placeholder="Drug name" name="search">
            <button class="btn btn-dark btn-sm" id="searchBtn" name="submit">Search</button>
            <button type="button" class="btn btn-danger btn-sm" id="stopBtn" style="display: none;">Stop</button>
        </form>
        <div class="container2 my-5">
            <table class="table">
                <?php
                if (isset($_POST['submit'])) {
                    $search = $_POST['search'];

                    // Prepare the SQL statement with a parameterized query
                    $sql = "SELECT * FROM `medicine_dataset` WHERE LOWER(name) LIKE ?";
                    $stmt = mysqli_prepare($con, $sql);

                    // $num=mysqli_num_rows($stmt);
                    // $numberpages = 3;
                    // $totalpages = $num/$numberpages;
                    // echo $totalpages;

                    if (!$stmt) {
                        die('Error in preparing SQL statement: ' . mysqli_error($con));
                    }

                    // Adjust the search term to match the desired behavior (lowercase)
                    $searchParam = strtolower($search) . '%';
                    mysqli_stmt_bind_param($stmt, "s", $searchParam);

                    // Execute the query
                    mysqli_stmt_execute($stmt);

                    // Get the result
                    $result = mysqli_stmt_get_result($stmt);


                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Substitute 0</th>
                                    <th>Substitute 1</th>
                                    <th>Substitute 2</th>
                                    <th>Substitute 3</th>
                                    <th>Substitute 4</th>
                                    <th>Side Effects</th>
                                </tr>
                                </thead>
                                <tbody>';

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                    <td>' . $row['id'] . '</td>
                                    <td>' . $row['name'] . '</td>
                                    <td>' . $row['substitute0'] . '</td>
                                    <td>' . $row['substitute1'] . '</td>
                                    <td>' . $row['substitute2'] . '</td>
                                    <td>' . $row['substitute3'] . '</td>
                                    <td>' . $row['substitute4'] . '</td>
                                    <td>' . $row['sideEffect0'] . '<br>' . $row['sideEffect1'] . '<br>' . $row['sideEffect2'] . '<br>' . $row['sideEffect3'] . '<br>' . $row['sideEffect4'] . '</td>
                                </tr>';
                            }

                            echo '</tbody>';
                        } else {
                            echo '<h2 class="text-danger">Data not found you dumb!!!!!!</h2>';
                        }
                    } else {
                        echo '<h2 class="text-danger">Error in executing query</h2>';
                    }
                }
                ?>


            </table>
        </div>
    </div>

    <footer>
        <div class="footerContainer">
          <div class="socialIcons">
            <a href=""><i class="fa-brands fa-facebook"></i></a>
            <a href=""><i class="fa-brands fa-instagram"></i></a>
            <a href=""><i class="fa-brands fa-twitter"></i></a>
          </div>
          <div class="footerNav">
            <ul>
              <li><a href="">Home</a></li>
              <li><a href="">About</a></li>
              <li><a href="">Contact Us</a></li>
              <li><a href="">our Team</a></li>
            </ul>
          </div>
        </div>
        <div class="footerBottom">
          <p>
            Copyright &copy;2024; Designed by
            <span class="designer">AakDeeAyi</span>
          </p>
        </div>
      </footer>
<script>
    document.getElementById("searchBtn").addEventListener("click", function() {
        // Hide the search button and show the stop button
        document.getElementById("searchBtn").style.display = "none";
        document.getElementById("stopBtn").style.display = "inline-block";

        // Submit the form
        document.querySelector("form").submit();
    });

    document.getElementById("stopBtn").addEventListener("click", function() {
        // Show the search button and hide the stop button
        document.getElementById("searchBtn").style.display = "inline-block";
        document.getElementById("stopBtn").style.display = "none";

        // Optionally, clear the input field
        document.querySelector("input[name='search']").value = "";
    });

</script>


</body>

</html>
