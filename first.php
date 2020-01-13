<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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
 <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>


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
  
      <li class="nav-item active">
        <a class="nav-link" href="bank.php">
          <span>Add Bank Account</span></a>
      </li>  

      <li class="nav-item active">
        <a class="nav-link" href="money.php">
          <span>Add Money</span></a>
      </li>  

 <li class="nav-item active">
        <a class="nav-link" href="transfer.php">
          <span>Transfer Money</span></a>
      </li>  
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
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
             <a href="tables.php" class="btn btn-primary">Buy/Sell Stocks</a>
          </div>

          <!-- Content Row -->


             <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3" >
              <h6 class="m-0 font-weight-bold text-primary" style="">Your stocks</h6>
               <span class="m-0 font-weight-bold text-primary" style="float:right;" id='balance'></span>
               <span class="m-0 font-weight-bold text-primary" style="float:right;"> Balance- </span>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Stock Name</th>
                      <th>Purchased Price</th>
                      <th>No of Stocks</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
       
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->
</div>
</div>
  <!-- End of Page Wrapper -->

 

<script type = "text/javascript">
 $(document).ready(function() {
 
 

      var tr;
var temp;
var rr='<?php echo $_SESSION["username"];?>';
var rep;
   $.ajax({
                type: "GET",
                url: "get_balance.php",
                data:{user_name:rr},
                dataType:'text', 
                async: false,
           
                success: function(response){
              rep=response;
             document.getElementById('balance').innerHTML=rep;
              }
    });
    
 
    
     $.ajax({
                type: "GET",
                url: "service.php",
                data:{number:1,user_name:rr},
                dataType:'JSON', 
           
                success: function(response){

  for (var i = 0; i < response.length; i++) {
                        tr = $('<tr/>');
                        tr.append("<td>" + response[i].stock_name + "</td>");
                        tr.append("<td>" + response[i].purchased_price + "</td>");
                        tr.append("<td>" + response[i].quantity + "</td>");          
             $('#dataTable').append(tr);
                
          }
        }
    });
    
});
         
     
    
 </script>

 <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>



</body>

</html>