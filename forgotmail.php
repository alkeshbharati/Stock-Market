<?php
// Include config file
require_once "connect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
   
        $email = $_POST["email"];
  
        $sql = "select * from user WHERE email='".$email."'";

        $stmt=mysqli_query($con,$sql);

        
         if($stmt){
              session_start();
              $_SESSION["email"]=$email;  
        
                if(mysqli_num_rows($stmt) > 0){
                   // Redirect to login page
               header("location: password.php");
                } else{
                    echo "Invalid email id";
                }
             
        }          
       }     
?>
 


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stocks</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css"> 
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <script src="js/main.js"></script>
</head>
<body>
    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
                <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <span class="login100-form-title p-b-33">
                        Enter Registered Email Id
                    </span>
                         <div class="wrap-input100 validate-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            
                            <input type="email" name="email" class="input100"  >
                          
                         </div>    <br>
                        
                         <div class="container-login100-form-btn m-t-20">
                            <input type="submit" class="btn btn-primary" value="Proceed">
                          </div>
                   
                </form>
            </div>
        </div>
    </div>
</body>
</html>