<?php
// Initialize the session
require_once "connect.php";

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  
        $account = trim($_POST["account"]);
        
        $a = $_POST["amount"];
        
              $sql="select amount from bank where account ='$account'";
              $result=mysqli_query($con,$sql);
             $row= mysqli_fetch_assoc($result);
              $prev= $row["amount"];
              
             
           $final=$a+$prev; 
             

        $query="update bank set amount = '$final' where account ='$account'";
          $stmt=mysqli_query($con,$query);

            // Attempt to execute the prepared statement
            if($stmt){
                // Redirect to login page
              echo "Records added successfully.";
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }    

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Stocks - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        
        <div class="sidebar-brand-text mx-3">Stocks Insights</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="first.php">
         <!-- <i class="fas fa-fw fa-tachometer-alt"></i>-->
          <span>My Stocks</span></a>
      </li>

      <hr class="sidebar-divider my-0">
  
  


    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <span class="mr-2 d-none d-lg-inline" style="color:black">Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
               <a href="logout.php" class="btn btn-danger">Logout</a>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bank Details</h1>
            
          </div>

          <!-- Content Row -->


             <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3" >
             <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <span class="login100-form-title p-b-33">
                        Account Login
                </span>
            <div class="wrap-input100 validate-input">
                
               <select name="account">
                  <?php 
                      $sql = mysqli_query($con, "SELECT account FROM bank");
                      while ($row = $sql->fetch_assoc()){
                      echo "<option value='" . $row['account'] . "'>" . $row['account'] . "</option>";
                    }
                    ?>
                </select>
            </div><br>
            
            <div class="wrap-input100 rs1 validate-input">
               
                <input type="text" name="amount" class="input100" placeholder="Amount">
           
            </div>
            <div class="container-login100-form-btn m-t-20">
                <input type="submit" class="login100-form-btn" value="Add">
            </div>
        
        </form>
            </div>

          </div>
          
       
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>



  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>


</script>
</body>

</html>