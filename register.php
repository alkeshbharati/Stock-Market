<?php
// Include config file
require_once "connect.php";
 
// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $username = trim($_POST["username"]);
        $sql = "select user_id from user WHERE user_name='".$username."';";

        $stmt=mysqli_query($con,$sql);
        
         if($stmt){
            
              $param_username = $username;
            
                if(mysqli_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
             
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    

$balance = $_POST["money"];

   // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $email = trim($_POST["email"]);
        
        $sql = "select * from user WHERE email='".$email."'";

        $stmt=mysqli_query($con,$sql);
        
         if($stmt){
            
                if(mysqli_num_rows($stmt) > 0){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
             
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
   
        $query="insert into user(user_name,password,email,balance) values('".$username."','".$password."','".$email."','".$balance."')";
        $stmt=mysqli_query($con,$query);

            // Attempt to execute the prepared statement
            if($stmt){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
                        Sign up
                    </span>
                         <div class="wrap-input100 validate-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            
                            <input type="text" name="username" class="input100" value="<?php echo $username; ?>" placeholder="Username">
                           <span class="help-block"><?php echo $username_err; ?></span> 
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                         </div>    <br>
                         <div class="wrap-input100 validate-input <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                  
                            <input type="password" name="password" class="input100" value="<?php echo $password; ?>" placeholder="Passowrd">
                           <span class="help-block"><?php echo $password_err; ?></span>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                         </div>
                         <div class="wrap-input100 validate-input <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                           
                            <input type="password" name="confirm_password" class="input100" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password">
                          <span class="help-block"><?php echo $confirm_password_err; ?></span>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                         </div>
                         <br>
                         <div class="wrap-input100 validate-input <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                           
                            <input type="text" name="email" class="input100"  placeholder="Email Id">
                            <span class="help-block"><?php echo $email_err; ?></span>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                         </div>
                          <div class="wrap-input100 validate-input ">
                           
                            <input type="text" name="money" class="input100"  placeholder="Money">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                         </div>

                         <div class="container-login100-form-btn m-t-20">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <input type="reset" class="btn btn-default" value="Reset">
                          </div>
                     <p>Already have an account? <a href="login.php">Login here</a>.</p>
                </form>
            </div>
        </div>
    </div>
    

    

</body>
</html>