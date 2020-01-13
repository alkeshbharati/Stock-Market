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

  <title>Stocks - Charts</title>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  
    <!-- Bootstrap core JavaScript-->
  
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

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

           <span class="mr-2 d-none d-lg-inline" style="color:black">Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>

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
      
          <br>
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
             <h1 class="h3 mb-2 text-gray-800" id='ticker'></h1>
             <button  class="btn btn-primary" onclick="buy()">Buy Stocks</button>
             <button class="btn btn-dark" onclick="sell()">Sell Stocks</button>
             <span>QTY<select id='qty'>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">4</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="7">9</option>
  <option value="8">10</option>
</select></span>
          </div>
          <!-- Content Row -->
          <div class="row">

            <div class="col-xl-8 col-lg-7" >

              <!-- Area Chart -->
              <div class="card shadow mb-4" style="width:1050px">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Today</h6>
                </div>
                <div class="card-body" style="width:500px" >
                   
                   <table class="table table-bordered" id="table1" style="width:500px" cellspacing="0">
                  <thead>
                   <tr>
                      <th>Stock Name</th>
                      <th>Open</th>
                      <th>High</th>
                      <th>low</th>
                      <th>close</th>
                      <th>Volume</th>
                    </tr>
                  </thead>
              
                  <tbody>
                    <tr>
                      
                    </tr>
                    
                  </tbody>
                </table>
                </div>
              </div>

              <!-- Bar Chart -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Past Month </h6>
                 

                </div>
                <div class="card-body">
                  <table class="table table-bordered" id="table2" width="100%" cellspacing="0">
                  <thead>
                   <tr>
                      <th>Open</th>
                      <th>High</th>
                      <th>low</th>
                      <th>close</th>
                      <th>Volume</th>
                      <th>Date</th>
                    </tr>
                  </thead>
              
                  <tbody >
                    <tr>
                      
                      
                    </tr>
                  </tbody>
                </table>
                </div>
              </div>

        <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Last 5 Years</h6>
                   <select class="inputxlg" id="rangeval">
   
    <option value="Custom Date Range">Custom Date Range</option>
</select>

<input id="selectDate" name="selectDate" type="text">
<input id="selectDate2" name="selectDate" type="text">
                </div>
                <div class="card-body">
                  <table class="table table-bordered" id="table3" width="100%" cellspacing="0">
                  <thead>
                   <tr>
                    
                      <th>Open</th>
                      <th>High</th>
                      <th>low</th>
                      <th>close</th>
                      <th>Volume</th>
                      <th>Date</th>
                    </tr>
                  </thead>
              
                  <tbody id="t">
                    <tr>
                      
                    </tr>
              
                  </tbody>
                </table>
                </div>
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

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>




<script type="text/javascript">
  $(document).ready(function(){


 
   var text = localStorage.getItem("ticker");
    document.getElementById('ticker').innerHTML= text;


   
          $.ajax({
                  type: "GET",
                  url: "http://3.135.147.14/realtime",
                  data:{symbol:text},
                  dataType:'JSON', 
                  success: function(response){
  //redirect user to proper logged in page
                  var json     = response;//String.fromCharCode.apply(null, new Uint16Array(response));
                
                   for (var i = 0; i < json.length; i++) {
                    tr = $('<tr/>');
                    tr.append("<td>" + json[i].stock_name + "</td>");
                    tr.append("<td>" + json[i].open + "</td>");
                    tr.append("<td>" + json[i].high + "</td>");
                    tr.append("<td>" + json[i].low + "</td>");
                    tr.append("<td>" + json[i].close + "</td>");
                    tr.append("<td>" + json[i].volume + "</td>");
                   
            $('#table1').append(tr);
        }
    }
});

   $.ajax({
                  type: "GET",
                  url: "http://3.135.147.14/pastMonth",
                  data:{symbol:text},
                  dataType:'JSON', 
                  success: function(response){
  //redirect user to proper logged in page
                  var json     = response;//String.fromCharCode.apply(null, new Uint16Array(response));
                  
                 console.log(json);
                   for (var i = 0; i < json.length; i++) {
                    tr = $('<tr/>');
                  
                    tr.append("<td>" + json[i].open + "</td>");
                    tr.append("<td>" + json[i].high + "</td>");
                    tr.append("<td>" + json[i].low + "</td>");
                    tr.append("<td>" + json[i].close + "</td>");
                    tr.append("<td>" + json[i].volume + "</td>");
                    tr.append("<td>" + json[i].date + "</td>");
            $('#table2').append(tr);
        }
    }
});
      $.ajax({
                  type: "GET",
                  url: "http://3.135.147.14/pastFiveYears",
                  data:{symbol:text},
                  dataType:'JSON', 
                  success: function(response){
  //redirect user to proper logged in page
                  var json     = response;//String.fromCharCode.apply(null, new Uint16Array(response));
                  console.log("years" + json );
                   for (var i = 0; i < json.length; i++) {
                    tr = $('<tr/>');
                   
                    tr.append("<td>" + json[i].open + "</td>");
                    tr.append("<td>" + json[i].high + "</td>");
                    tr.append("<td>" + json[i].low + "</td>");
                    tr.append("<td>" + json[i].close + "</td>");
                    tr.append("<td>" + json[i].volume + "</td>");
                    tr.append("<td>" + json[i].date + "</td>");
            $('#table3').append(tr);
          }
        }
     });
     
      // Initialise the inputs on page load:
    var today = new Date().toJSON().replace(/..(..)-(..)-(..).*/, '$2/$3/$1');
    $("#selectDate").datepicker({ dateFormat: 'mm/dd/yy' }).val(today).change(applyFilter);
    $("#selectDate2").datepicker({ dateFormat: 'mm/dd/yy' }).val(today).change(applyFilter);
    

  //  $.fn.date = function () {
   //     return new Date((this.is(':input') ? this.val() : this.text()).replace(/\/(..)$/, '/20$1'));
    //}
    
    function applyFilter() {
        var filterType = $("#rangeval").val(),
            start, end;
        // Set the visibility of the two date fields:
       
        // Depending on the type of filter, set the range of dates (start, end):
        
            // Use data entry:
            start = $("#selectDate").val();
            var s = new Date(start);
          // alert(s);
           
            end =  $("#selectDate2").val(); 
           var e = new Date(end);
      //  alert(e);
        // For each row: set the visibility depending on the date range
       $("#t tr").each(function () {
        
        var date = $(this).find("td:eq(5)").html();
           var d = new Date(date);
        //  alert(d);
          $(this).toggle(d >= s && d <= e);
      });
    }
    applyFilter(); // Execute also on page load

});
</script>
<script type="text/javascript">
  function buy() {
  var text = localStorage.getItem("ticker");
    document.getElementById('ticker').innerHTML= text;
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
             
              }
    });
var cost =  parseInt($('#table1').find("td:eq(1)").html());
var qty  =  parseInt($('#qty').val());


var cal= cost*qty;

           
           
           if( cal > rep)
            {
              alert("You have exceeded your limit");
                }else{
  
             rep= rep- cal;
              
                   var tr;
                   var temp;
                   var rr='<?php echo $_SESSION["username"];?>';

                    $.ajax({
                             type: "GET",
                             url: "service.php",
                             data:{number:3,user_name:rr,new_balance:rep,quantity:qty,pur_price:cal,stock_name:text},
                             dataType:'text', 
                              success: function(response){
                          }
                  });

                }

}

function sell() {
var text = localStorage.getItem("ticker");
    document.getElementById('ticker').innerHTML= text;
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
             
              }
    });
           
           var cost =  parseInt($('#table1').find("td:eq(1)").html());
           var qty  =  parseInt($('#qty').val())
           var cal= cost*qty;
           
               rep= parseInt(rep) + cal;
             
                   var tr;
                   var temp;
                   var rr='<?php echo $_SESSION["username"];?>';

                    $.ajax({
                             type: "GET",
                             url: "service.php",
                             data:{number:4,user_name:rr,new_balance:rep,quantity:qty,stock_name:text},
                             dataType:'JSON', 
                              success: function(response){
                          }
                  });

    }
</script>

</body>

</html>