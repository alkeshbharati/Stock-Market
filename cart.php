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

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
          <button  class="btn btn-primary" id="deleterow">Remove</button>
                <span class="m-0 font-weight-bold text-primary" style="float:right;" id='balance'></span>
               <span class="m-0 font-weight-bold text-primary" style="float:right;"> Balance- </span>
         
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
         
            <div class="card-body">
              <div class="table-responsive">
               
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                   <tr>
                      <th>Stock Name</th>
                      <th>Open</th>
                      <th>Quantity</th>
                      <th>Option</th>
                      <th>Select</th>
                    </tr>
                  </thead>
              
                  <tbody id='mytable'>
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


  

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script type = "text/javascript" language = "javascript">
       $(document).ready(function() {
 var tr
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
    
 var data = localStorage.getItem("cart");
 localStorage.removeItem("cart");
 var json = JSON.parse(data);
//localStorage.clear(); //clean the localstorage
          for(i=0;i<json.length;i++)
            {
                  tr = $('<tr />');
                    tr.append("<td>" + json[i]["ticker"] + "</td>");
                    tr.append("<td>" + json[i]["open"] + "</td>");
                    tr.append("<td><input type='text' id='qty' /></td>");
                    tr.append("<td><button type='button' value='buy' id='buy'>Buy</button><button type='button' value='buy' id='sell'>Sell</button></td>");
                    tr.append("<td><input type='checkbox' id='chk_"+i+"' /></td>");
                    $('#mytable').append(tr);
                }
         

    
       
        $("#deleterow").click(function(){
           $('input[type="checkbox"]:checked').closest("tr").remove();
        });

        $("#dataTable").on("click", "#buy", function () {
           var name = $(this).parent().siblings(":first").text();
           var cost = parseInt($(this).parent().siblings(":first").next().text());
           var qty = parseInt($(this).parents('tr').find("#qty").val()) ;
           var cal= cost*qty;
           
           
           if( cal > rep)
            {
              alert("You have exceeded your limit");
                }else{
  
              rep= rep- cal;
              
              
                   var tr;
                   var temp;
                   

                    $.ajax({
                             type: "GET",
                             url: "service.php",
                             data:{number:3,user_name:rr,new_balance:rep,quantity:qty,pur_price:cal,stock_name:name},
                             dataType:'text', 
                              success: function(response){
                              
                              alert("bought Successfully");
                          }
                  });

                }

          });
          
             $("#dataTable").on("click", "#sell", function () {
           var name = $(this).parent().siblings(":first").text();
           var cost = parseInt($(this).parent().siblings(":first").next().text());
           var qty = parseInt($(this).parents('tr').find("#qty").val()) ;
           var cal= cost*qty;
           
              rep= parseInt(rep) + cal;

              
                   var tr;
                   var temp;
                   var rr='<?php echo $_SESSION["username"];?>';
   
                    $.ajax({
                             type: "GET",
                             url: "service.php",
                             data:{number:4,user_name:rr,new_balance:rep,quantity:qty,stock_name:name},
                             dataType:'text', 
                              success: function(response){
                      
                              alert("sold succussfully");
                          }
                  });

                

          });
    });
      </script>


  <script src="js/demo/datatables-demo.js"></script>


</body>

</html>