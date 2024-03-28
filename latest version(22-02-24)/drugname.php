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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url("patient_details_img.jpg");
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
        
      
       
       
        

        /* -----------------footer------------ */

        footer{
            display: flex;
            flex-wrap: wrap;
            margin-top: auto;
            background-color:rgb(112, 167, 201);
            padding: 60px 10%;
        }

        ul{
            list-style: none;
        }

        .footer-col{
            width: 25%;
        }

        .footer-col h4{
            position: relative;
            margin-bottom: 30px;
            font-weight: 400;
            font-size: 22px;
            color: #f1bc0d;
            text-transform: capitalize;
        }

        .footer-col h4::before{
            content: '';
            position: absolute;
            left: 0;
            bottom: -6px;
            background-color: #27c0ac;
            height: 2px;
            width: 40px;
        }

        ul li:not(:last-child){
            margin-bottom: 8px;
        }

        ul li a{
            display: block;
            font-size: 19px;
            text-transform: capitalize;
            color: #bdb6b6;
            text-decoration: none;
            transition: 0.4s;
        }

        ul li a:hover{
            color: white;
            padding-left: 2px;
        }

        .links a{
            display: inline-block;
            height: 44px;
            width: 44px;
            color: white;
            background-color: rgba(40, 130, 214, 0.8);
            margin: 0 8px 8px 0;
            text-align: center;
            line-height: 44px;
            border-radius: 50%;
            transition: 0.4s;
        }

        .links a:hover{
            color: #4d4f55;
            background-color: white;
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
    <div class="footer-col">
        <h4>products</h4>
        <ul>
            <li><a href="#">teams</a></li>
            <li><a href="#">advertising</a></li>
            <li><a href="#">talent</a></li>
        </ul>
    </div>
    <div class="footer-col">
        <h4>network</h4>
        <ul>
            <li><a href="#">technology</a></li>
            <li><a href="#">science</a></li>
            <li><a href="#">business</a></li>
            <li><a href="#">professional</a></li>
            <li><a href="#">API</a></li>
        </ul>
    </div>
    <div class="footer-col">
        <h4>company</h4>
        <ul>
            <li><a href="#">about</a></li>
            <li><a href="#">legal</a></li>
            <li><a href="#">contact us</a></li>
        </ul>
    </div>
    <div class="footer-col">
        <h4>follow us</h4>
        <div class="links">
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
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
