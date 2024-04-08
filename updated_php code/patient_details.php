
<?php
            // Start the session
            session_start();

            
            
            ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title> Login & Registration</title>
</head>
<style>
	/* POPPINS FONT */
	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

*{  
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
body{
    background: url("mainimg.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    overflow: hidden;
}

.wrapper{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 110vh;
    background: rgba(39, 39, 39, 0.4);
}
.nav{
    position: fixed;
    top: 0;
    display: flex;
    justify-content: space-around;
    width: 100%;
    height: 100px;
    line-height: 100px;
    background: linear-gradient(rgba(39,39,39, 0.6), transparent);
    z-index: 100;
}
.nav-logo img{	
  width: 300px;
  height: 230px;
  margin-top: -3%;
  position: absolute;
  top: 3%;
  left: 0%;
}

.nav-menu ul{
    display: flex;
}
.nav-menu ul li{
    list-style-type: none;
}
.nav-menu ul li .link{
    text-decoration: none;
    font-weight: 500;
    color: #fff;
    padding-bottom: 15px;
    margin: 0 25px;
}
.link:hover::after {
  border-bottom: 2px solid red;
  display: inline-block;
  margin: auto;
  transition: 0.5s;
}

.link {
    position: relative;
    text-decoration: none;
    font-weight: 500;
    color: #fff;
    padding-bottom: 15px;
    margin: 0 25px;
}

.link::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 0;
    height: 2px;
    background-color: red;
    transition: width 0.5s ease;
}

.link:hover::after {
    width: 100%;
}


.nav-button .btn{
    width: 130px;
    height: 40px;
    font-weight: 500;
    background: rgba(255, 255, 255, 0.4);
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: .3s ease;
}
.btn:hover{
    background: rgba(255, 255, 255, 0.3);
}
#registerBtn{
    margin-left: 15px;
}
.btn.white-btn{
    background: rgba(255, 255, 255, 0.7);
}
.btn.btn.white-btn:hover{
    background: rgba(255, 255, 255, 0.5);
}
.nav-menu-btn{
    display: none;
}
.form-box{
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 512px;
    height: 420px;
    margin-left:40%;
    overflow: hidden;
    z-index: 2;
}



.login-container{
    position: absolute;
    left: 4px;
    width: 500px;
    display: flex;
    flex-direction: column;
    transition: .5s ease-in-out;
}
.register-container{
    position: absolute;
    right: -520px;
    width: 500px;
    display: flex;
    flex-direction: column;
    transition: .5s ease-in-out;
}


.top span{
    color: #fff;
    font-size: small;
    padding: 10px 0;
    display: flex;
    justify-content: center;
}
.top span a{
    font-weight: 500;
    color: #fff;
    margin-left: 5px;
}
header{
    color: #fff;
    font-size: 30px;
    text-align: center;
    padding: 10px 0 30px 0;
}
.two-forms{
    display: flex;
    gap: 10px;
}
.input-field{
    font-size: 15px;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    height: 50px;
    width: 100%;
    padding: 0 10px 0 45px;
    border: none;
    border-radius: 30px;
    outline: none;
    transition: .2s ease;
}
.input-field:hover, .input-field:focus{
    background: rgba(255, 255, 255, 0.25);
}
::-webkit-input-placeholder{
    color: #fff;
}
.input-box i{
    position: relative;
    top: -35px;
    left: 17px;
    color: #fff;
}
.submit{
    font-size: 15px;
    font-weight: 500;
    color: black;
    height: 45px;
    width: 100%;
    border: none;
    border-radius: 30px;
    outline: none;
    background: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    transition: .3s ease-in-out;
}
.submit:hover{
    background: rgba(255, 255, 255, 0.5);
    box-shadow: 1px 5px 7px 1px rgba(0, 0, 0, 0.2);
}
.two-col{
    display: flex;
    justify-content: space-between;
    color: #fff;
    font-size: small;
    margin-top: 10px;
}
.two-col .one{
    display: flex;
    gap: 5px;
}
.two label a{
    text-decoration: none;
    color: #fff;
}
.two label a:hover{
    text-decoration: underline;
}



@media only screen and (max-width: 786px){
    .nav-button{
        display: none;
    }
    .nav-menu.responsive{
        top: 100px;
    }
    .nav-menu{
        position: absolute;
        top: -800px;
        display: flex;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        width: 100%;
        height: 90vh;
        backdrop-filter: blur(20px);
        transition: .3s;
    }
    .nav-menu ul{
        flex-direction: column;
        text-align: center;
    }
    .nav-menu-btn{
        display: block;
    }
    .nav-menu-btn i{
        font-size: 25px;
        color: #fff;
        padding: 10px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        cursor: pointer;
        transition: .3s;
    }
    .nav-menu-btn i:hover{
        background: rgba(255, 255, 255, 0.15);
    }
}
@media only screen and (max-width: 540px) {
    .wrapper{
        min-height: 100vh;
    }
    .form-box{
        width: 100%;
        height: 500px;
    }
    .register-container, .login-container{
        width: 100%;
        padding: 0 20px;
    }
    .register-container .two-forms{
        flex-direction: column;
        gap: 0;
    }

    
}
.message {
    margin-bottom: 10px;
    padding: 15px 20px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
}

.message.success {

    color: #155724;
    
}

.message.error {

    color: #721c24;

}

/* Center the message horizontally */
.message {
    margin: 0 auto;
    max-width: 400px;
}

</style>
<body>



 <div class="wrapper">

    <nav class="nav">
        <div class="nav-logo">
             <a href="next_page.html"> <img src="logotra.png" /></a>
        </div>
        <div class="nav-menu" id="navMenu">
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="login()">Sign In</button>
            <button class="btn" id="registerBtn" onclick="register()">Sign Up</button>
        </div>
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>
   
<!----------------------------- Form box ----------------------------------->    
    <div class="form-box">
        
        <!------------------- login form -------------------------->

        <div class="login-container" id="login">
            <div class="top">
                <span>Don't have an account? <a href="#" onclick="register()">Sign Up</a></span>
                <header>Login</header>
            </div>
            <form action="sign_in.php"  method="POST">
            <div class="input-box">
            <?php
            // Start the session

            // Check if there is a notification message
            if (isset($_SESSION['status'])) {
                // Display the notification message
                echo "<div class='message-container'>";
                echo "<div class='message " . ($_SESSION['status'] == 'Login successful!' ? 'success' : 'error') . "'>";
                echo $_SESSION['status'];
                echo "</div>";
                echo "</div>";

                // Unset the session variable to clear the message
                unset($_SESSION['status']);
            }
            ?>
                <input placeholder="Username or Email" type="email" class="input-field" name="email" required>
                <i class="bx bx-user"></i>
            </div>
            <div class="input-box">
                <input placeholder="Password" type="password" class="input-field" name="password" required>
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="submit" class="submit" value="Sign In" name="submit">
            </div>
            <div class="two-col">
                <div class="one">
                    <input type="checkbox" id="login-check">
                    <label for="login-check"> Remember Me</label>
                </div>
                <div class="two">
                    <label><a href="ForgetPassword.php">Forgot password?</a></label>
                </div>
            </div>
        </div>
    </form>

        <!------------------- registration form -------------------------->
        <div class="register-container" id="register">
            <div class="top">
                <span>Have an account? <a href="#" onclick="login()">Login</a></span>
                <header>Sign Up</header>
                <?php
// Display error message if set in session
if (isset($_SESSION['status'])) {
    echo "<p>{$_SESSION['status']}</p>";
    unset($_SESSION['status']); // Remove error message from session
}
?>

            </div>
            <form action="sign_up.php" method="post">
            <div class="two-forms">
                <div class="input-box">
                    
                <?php
                // Check if there is a notification message
                if (isset($_SESSION['status'])) {
                    // Display the notification message
                    echo "<div class='message-container'>";
                    echo "<div class='message " . ($_SESSION['status'] == 'Records inserted successfully.' ? 'success' : 'error') . "'>";
                    echo $_SESSION['status'];
                    echo "</div>";
                    echo "</div>";

                    // Unset the session variable to clear the message
                    unset($_SESSION['status']);
                }
                ?>


                    <input placeholder="Firstname" type="text" class="input-field" name="firstname" required>
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-box">
                    <input placeholder="Lastname" type="text" class="input-field" name="lastname" required>
                    <i class="bx bx-user"></i>
                </div>
            </div>
            <div class="input-box">
                <input placeholder="Email" type="email" class="input-field" name="email" required>
                <i class="bx bx-envelope"></i>
            </div>
            <div class="input-box">
                <input placeholder="Password" type="password" class="input-field" name="password" required>
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="submit" class="submit" value="Register" name="register">
            </div>
            <div class="two-col">
                <div class="one">
                    <input type="checkbox" id="register-check">
                    <label for="register-check"> Remember Me</label>
                </div>
                <div class="two">
                    <label><a href="#">Terms & conditions</a></label>
                </div>
            </div>
 


<script>
   
   function myMenuFunction() {
    var i = document.getElementById("navMenu");

    if(i.className === "nav-menu") {
        i.className += " responsive";
    } else {
        i.className = "nav-menu";
    }
   }
 
</script>

<script>

    var a = document.getElementById("loginBtn");
    var b = document.getElementById("registerBtn");
    var x = document.getElementById("login");
    var y = document.getElementById("register");

    function login() {
        x.style.left = "4px";
        y.style.right = "-520px";
        a.className += " white-btn";
        b.className = "btn";
        x.style.opacity = 1;
        y.style.opacity = 0;
    }

    function register() {
        x.style.left = "-510px";
        y.style.right = "5px";
        a.className = "btn";
        b.className += " white-btn";
        x.style.opacity = 0;
        y.style.opacity = 1;
    }

   
</script>



</body>
</html>
