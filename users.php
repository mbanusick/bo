
<?php
  require "conn.php";
  
  //check for user admin role 
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
  $id = $_SESSION["id"];
$sitebtc_add_err = $pin_err = $pin = "";
  
 // prepare statement for getting data from DB***************************************************************************1
$sql = "SELECT fullname, email, country, btcwallet, plan, role FROM users WHERE id = $id";   
if($stmt = $pdo->prepare($sql)){
    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Check if username exists, if yes then verify password
        if($stmt->rowCount() == 1){
          if($row = $stmt->fetch()){
            $fullname = $row["fullname"];
            $email = $row["email"];
            $country = $row["country"];
            $btcwallet = $row["btcwallet"];
            $role = $row["role"];
            $userPlan = $row["plan"];
        } 
      }
  }
}
  
if ($role == 0){
				header("location: dashboard.php"); exit;
}  

	
	
$getUsers= $pdo->prepare("SELECT * FROM users");

$getUsers->execute();

$users = [];
while ($row = $getUsers->fetch(PDO::FETCH_ASSOC)) { 
    array_push($users, $row); 
}


 

?>


<!DOCTYPE html>
<html lang="en" class="nojs">
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    
    <title>Laxiom Investment</title>

    <link rel="icon" href="https://Laxiom.net/public/images/world-diamond-logo-send.png" type="image/x-icon">
	
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Arvo:400,700%7COpen+Sans:300,300italic,400,400italic,700italic,800%7CUbuntu:500">


    
    <link rel="stylesheet" href="./Dashboard_files/bootstrap.min.css">
    <link rel="stylesheet" href="./Dashboard_files/AdminLTE.min.css">
    <link rel="stylesheet" href="./Dashboard_files/_all-skins.min.css">
    <link rel="stylesheet" href="./Dashboard_files/blue.css">
    <link rel="stylesheet" href="./Dashboard_files/morris.css">
    <link rel="stylesheet" href="./Dashboard_files/jquery-jvectormap-1.2.2..css">
    <link rel="stylesheet" href="./Dashboard_files/datepicker3.css">
    <link rel="stylesheet" href="./Dashboard_files/daterangepicker-bs3.css">
    <link rel="stylesheet" href="./Dashboard_files/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="./Dashboard_files/main.css">

<!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="httpqwertywindows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="js/html5shiv.min.js"></script>
<![endif]-->

</head><div id="stopTracker" data-check="not-approved"></div>
<div id="tracker" data-trans-tracker="0" data-ref-tracker="0" data-activity-tracker="0"></div>
<div class="invoiceBackground"></div>
<div class="invoiceContainer"></div>

<!-- Trigger the modal with a button -->
<!-- <button>Open Modal</button> -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Withdrawal request</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="https://Laxiom.net/Dashboard/withdrawalRequest"> 
          <div class="form-group">
            <input class="form-control" type="text" name="amount" placeholder="Enter the amount you want to withdraw">
          </div>
          <button class="btn btn-lg btn-primary">Request</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="https://Laxiom.net/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">Laxiom Inv</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Laxiom Inv</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs"><?php echo $fullname; ?></b></span>
                </a>
                <ul class="dropdown-menu">
                 
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
        
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left info">
            </div>
          </div>
      
          <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">MAIN NAVIGATION</li>
          <li class="treeview">
            <a href="dashboard.php">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>
          <li class="treeview">
            <a href="settings.php">
              <i class="fa fa-gears"></i>
              <span>Settings</span>
            </a>
          </li>
          <?php if ($role == 1)
				echo '<li class="treeview">
              <a href="dashboard2.php">
                <i class="fa fa-gears"></i>
                <span>Admin Panel</span>
              </a>
            </li>
			<li class="active treeview">
              <a href="users.php">
                <i class="fa fa-gears"></i>
                <span>Users List</span>
              </a>
            </li>'
				 ?>

          <li class="treeview">
            <a href="logout.php">
              <i class="fa fa-gears"></i>
              <span>Logout</span>
            </a>
          </li>
        </ul>
      </section>
      <!-- /.sidebar -->
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
     
        <!-- Content Header (Page header) -->
        <section class="content-header">
		<?php if(isset($_GET["success"])): ?>
         <div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">   
				<span aria-hidden="true">×</span><span class="sr-only">Close</span>
			</button>
			<?=$_GET["success"] ?>           
		</div>
		<?php endif; ?>
          <h1>
            Registered Users
            <small>Page</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dahsboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Settings</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->


                    <div class="box-body">
                      <table class="table table-bordered">
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Name</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Wallet</th>
                          <th>Plan</th>
                        </tr>
                        <?php for($i=0; $i < count($users);$i++): ?>
                          <tr>
                            <td><?=$i + 1?></td>
                            <td><?=$users[$i]["fullname"]?></td>
                            <td><?=$users[$i]["username"]?></td>
                            <td><?=$users[$i]["email"]?></td>
                            <td><?=$users[$i]["btcwallet"]?></td>
                            <td><?=$users[$i]["plan"]?></td>
						</tr>

                  <?php endfor; ?>

                      </table>
                    </div><!-- /.box-body --> 



            <!-- Request box end -->
				
				
                  <div id="calendar" style="width: 100%"></div>
                </div><!-- /.box-body -->
                <div class="box-footer text-black">
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- Progress bars -->
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div>
              </div><!-- /.box -->

            </section><!-- right col -->
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        
        <strong>Copyright &copy; 2019 <a href="http://almsaeedstudio.com">Laxiom</a>.</strong> All rights reserved.
      </footer>

    

<div id="path" data-app-name="Laxiom" data-path="https://Laxiom.net/" data-css-path="https://Laxiom.net/public/css/" data-js-path="https://Laxiom.net/public/js/"></div>
<footer>
	

		
	<script>
      $(function () {

				try {
					$( "#side-navigation" ).tabs({ show: { effect: "fade", duration: 400 } });
				
				} catch(e) {

				}

				try {
					$("#example1").DataTable();
					$('#example2').DataTable({
						"paging": true,
						"lengthChange": false,
						"searching": false,
						"ordering": true,
						"info": true,
						"autoWidth": false
					});
					
				} catch(e) {

				}


				try {

					$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%' // optional
					});
					
				} catch(e) {
					
				}
			
      });
    </script>
	
</footer>
</main>
</body>