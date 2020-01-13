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

  <title>Stocks - Tables</title>

  <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>

<style type="text/css">
 #dataTable tr:hover {
          background-color: #bdbdbd;
        }

</style>
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
        
          <span>My Stocks</span></a>
      </li>

    

      <!-- Divider -->
      <hr class="sidebar-divider">


      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="cart.php">
       
          <span>Cart</span></a>
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

         <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
               <a href="logout.php" class="btn btn-danger">Logout</a>
            </li>

         </ul>
     
     </nav>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Stocks</h1>
         <button href="tables.php" class="btn btn-primary" id="cart">Add to Cart</button>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
         
            <div class="card-body">
              <div class="table-responsive" id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
              <input type="text" id="myInput"  placeholder="Search">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                   <tr>
                      <th>Stock Name</th>
                      <th>Open</th>
                      <th>High</th>
                      <th>low</th>
                      <th>close</th>
                      <th>Volume</th>
                      <th>Select</th>
                    </tr>
                  </thead>
              
                  <tbody id='myTable'>
                    <tr>
                      
                    </tr>
        
                  </tbody>
                </table>
              </div>
            </div>
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


  <!-- Page level custom scripts -->
  <script type = "text/javascript" language = "javascript">
       $(document).ready(function() {
       
    // var table = $('#dataTable').DataTable();
       
       
var tr;
var rr='<?php echo $_SESSION["username"];?>';
           $.ajax({
                  type: "GET",
                  url: "http://3.135.147.14/all",
                  data:{},
                  
                  dataType:'JSON', 
                 
                success: function(response){
  //redirect user to proper logged in page
                var json     = response //String.fromCharCode.apply(null, new Uint16Array(response));
               
           for (var i = 0; i < json.length; i++) {
                    tr = $('<tr/>');
                    tr.append("<td>" + json[i].stock_name + "</td>");
                    tr.append("<td>" + json[i].open + "</td>");
                    tr.append("<td>" + json[i].high + "</td>");
                    tr.append("<td>" + json[i].low + "</td>");
                    tr.append("<td>" + json[i].close + "</td>");
                    tr.append("<td>" + json[i].volume + "</td>");
                    tr.append("<td><input type='checkbox' id='chk_"+i+"' /></td>");
            $('#dataTable').append(tr);
         }
       } 
   });


$('#cart').on('click', function() {
  var updates = [];
  var selector = '#myTable tr input:checked'; 
  $.each($(selector), function(idx, val) {
    
    var ticker = $(this).parent().siblings(":first").text();
    var open = $(this).parent().siblings(":first").next().text();
    updates.push({'ticker': ticker, 'open': open});
  });
 
  localStorage.setItem("cart",JSON.stringify(updates));
 // post to DB - fill in your details
 alert('Moved to cart successfully');
});


$("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
         
});         
       
      </script>
 // <script src="js/demo/datatables-demo.js"></script>

<script type="text/javascript">

  $(document).ready(function() {

      $('#dataTable').DataTable();
    $('#dataTable tbody').on('click', 'tr td:first-child', function () {
      document.location.href='charts.php';
       var data =  $(this).text();
    localStorage.setItem("ticker",data);
 
//alert(data);
    } );
} );
</script>
</body>

</html>