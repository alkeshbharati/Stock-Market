<?php
// Initialize the session


ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: first.php");
    exit;
}
 
// Include config file
require_once "connect.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "select * from user WHERE user_name='".$username."';";
        echo $sql;
        echo $username;
        echo $password;

	$stmt=mysqli_query($con,$sql);
        if($stmt){
        echo "here 1";
            // Bind variables to the prepared statement as parameters
            // Set parameters
            $param_username = $username;
            
            
                // Check if username exists, if yes then verify password
                if(mysqli_num_rows($stmt)>0){
                        echo "here 3";                    
			$row= mysqli_fetch_assoc($stmt);
			echo $row['user_id'];
			$id=$row['user_id'];
			$username=$row['user_name'];
			$hashed_password=$row['password'];
			$balance=$row['balance'];
			
                    if($row){
                            echo "here 4";
                        if($password==$hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                                    echo "here 5";
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;  
                            $_SESSION["balance"]=$balance;                          
                            
                            // Redirect user to welcome page
                            header("location: first.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        else{ echo "Error";}
        
        // Close statement
       // mysqli_stmt_close($stmt);
    
    
    // Close connection
    mysqli_close($con);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stocks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
</head>
<body>
     <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
                <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <span class="login100-form-title p-b-33">
                        Account Login
                </span>
            <div class="wrap-input100 validate-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                
                <input type="text" name="username" class="input100" value="<?php echo $username; ?>" placeholder="Username">
                <span class="help-block"><?php echo $username_err; ?></span>
                <span class="focus-input100-1"></span>
                <span class="focus-input100-2"></span>
            </div>    <br>
            <div class="wrap-input100 rs1 validate-input <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
               
                <input type="password" name="password" class="input100" placeholder="Password">
                <span class="help-block"><?php echo $password_err; ?></span>
                <span class="focus-input100-1"></span>
                <span class="focus-input100-2"></span>
            </div>
            <div class="container-login100-form-btn m-t-20">
                <input type="submit" class="login100-form-btn" value="Login">
            </div>
            <br>
            <p >Don't have an account? <a href="register.php" >Sign up now</a>.</p>
            <p > <a href="forgotmail.php" >Forgot Password?</a></p>
        </form>
    </div>    
</body>
</html>