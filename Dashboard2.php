
<?php
  require "conn.php";
  
  

	
	
$getInvoice= $pdo->prepare("SELECT invoice.*, users.fullname, plans.schedule FROM invoice LEFT JOIN users ON invoice.p_user = users.id LEFT JOIN plans ON users.plan = plans.id WHERE invoice.status = 0"); 
$getInvoice->execute();

$invoice = [];
while ($row = $getInvoice->fetch(PDO::FETCH_ASSOC)) { 
    array_push($invoice, $row); 
}


if(isset($_POST["invoiceId"]) && isset($_POST["schedule"])) {
  $invoiceId = trim($_POST["invoiceId"]);
  $schedule = trim($_POST["schedule"]);
  
  try {
  
	$pdo->beginTransaction();
	 // Set Invoice status to 1;
  // Move data to Investment Table
	$invoiceApprove = $pdo->prepare("UPDATE invoice SET status = 1 WHERE id = :invoiceId");
	// Bind variables to the prepared statement as parameters
	$invoiceApprove->bindParam(":invoiceId", $param_invoiceId, PDO::PARAM_INT);
	// Set parameters
	$param_invoiceId = $invoiceId;
	$invoiceApprove->execute();

		
	$mkTime = strtotime("+{$schedule} days");
	$nxtPayment = date("Y-m-d H:i:s", $mkTime);
	
	$investAdd = $pdo->prepare("INSERT INTO investment (p_invoice, amount, next_payment) VALUES (:invoiceId, 0, '$nxtPayment')");
		
		
	  // Bind variables to the prepared statement as parameters
		$investAdd->bindParam(":invoiceId", $param_invoiceId, PDO::PARAM_INT);

		// Set parameters
		$param_invoiceId = $invoiceId;
		
		
	$investAdd->execute();
	$pdo->commit();
	header("location: dashboard2.php?success=Investment Added" );
	
	
  } catch(PDOException $e) {
	$pdo->rollBack();
    header("location: dashboard2.php?error=Error while verifying payment.Please try again or contact dev department" );
  }
 
}



?>


<!DOCTYPE html>
<html lang="en" class="nojs">
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    
    <title>Primustrades</title>

    <link rel="icon" href="https://primustrades.net/public/images/world-diamond-logo-send.png" type="image/x-icon">
	
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
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5b7bf39df31d0f771d840021/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
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
        <form method="post" action="https://primustrades.net/Dashboard/withdrawalRequest"> 
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
        <a href="https://primustrades.net/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">Primustrades</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Primustrades</b></span>
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
                  <span class="hidden-xs">Chukwuebuka Mbanusi</span>
                </a>
                <ul class="dropdown-menu">
                 
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="https://primustrades.net/Dashboard/logout" class="btn btn-default btn-flat">Sign out</a>
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
            <li class="active treeview">
              <a href="https://primustrades.net/Dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <li class="treeview">
              <a href="https://primustrades.net/Dashboard/settings">
                <i class="fa fa-gears"></i>
                <span>Settings</span>
              </a>
            </li>
            <li>
              <a href="https://primustrades.net/Plan">
                <i class="fa fa-th"></i> <span>Pricing</span>
              </a>
            </li>
                        <li>
              <a href="https://primustrades.net/Thinklala">
                <i class="fa fa-dashboard"></i> <span>Admin</span>
              </a>
            </li>
            <li>
              <a href="https://primustrades.net/Dashboard/trade">
                <i class="fa fa-area-chart"></i> <span>Trade</span>
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
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->


                    <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>$1000.00</h3>
                  <p>Total Investment</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Total investment made</a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>1<sup style="font-size: 20px"></sup></h3>
                  <p>Investments</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Number of investemnts</a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>0</h3>
                  <p>Total Referrals</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                                <a href="https://primustrades.net/Dashboard/affiliate" class="small-box-footer">Become an affiliate <i class="fa fa-arrow-circle-right"></i></a>
                                
                
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>$64.00</h3>
                  <p>Wallet Amount</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#"  type="button" data-toggle="modal" data-target="#myModal" class="small-box-footer">Make withdrawal request <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">
                  <li class="active"><a href="#revenue-chart" data-toggle="tab">Investment</a></li>
                  <li class="pull-left header"><i class="fa fa-inbox"></i> Investment</li>
                </ul>
                <div class="tab-content no-padding">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" style="position: relative;">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Investments</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <table class="table table-bordered">
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Name</th>
                          <th>Amount</th>
                          <th>Btc Amount</th>
                          <th>Tx_ID</th>
                          <th>action</th>
                        </tr>
                        <?php for($i=0; $i < count($invoice);$i++): ?>
                          <tr>
                            <td><?=$i + 1?></td>
                            <td><?=$invoice[$i]["fullname"]?></td>
                            <td>$<?=$invoice[$i]["amount"]?></td>
                            <td><?=$invoice[$i]["btc_amount"]?></td>
                            <td><?=$invoice[$i]["tx_id"]?></td>
                            <td>
                             
							  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                          <input type="hidden" name="schedule" value="<?=$invoice[$i]["schedule"]?>" />
                          <input type="hidden" name="invoiceId" value="<?=$invoice[$i]["id"]?>" />
                          <button class="btn btn-success">Approve</button>
                        </form>
                      </td>
                    </tr>

                  <?php endfor; ?>

                      </table>
                    </div><!-- /.box-body -->  
                  </div><!-- /.box -->
                  </div>
                  <div class="chart tab-pane" style="position: relative; height: 300px;">

                  </div>
                </div>
              </div><!-- /.nav-tabs-custom -->

              <!-- Chat box -->
              <div class="box box-success">
                <div class="box-header">
                  <i class="fa fa-modey"></i>
                  <h3 class="box-title">Request</h3>
                </div>
                <div class="box-body chat" id="chat-box">
                  <div class="box-header with-border">
                    <h3 class="box-title">Withdrawal Request</h3>
                  </div><!-- /.box-header -->
                  <div class="box-body">
                     
                      Heads Up!. No data to display
                                      </div><!-- /.box -->
                </div>
              </div><!-- /.box (chat box) -->
            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

              <!-- Map box -->
              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header with-border">
                  <h3 class="box-title">Invest Now</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
        
              </div>
            </div>
              <!-- /.box -->
  
				<!-- Calendar -->
              <div class="box box-solid bg-green-gradient">
                <div class="box-header">
                  <i class="fa fa-calendar"></i>
                  <h3 class="box-title">Calendar</h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                      <button class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
                      <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">Add new event</a></li>
                        <li><a href="#">Clear events</a></li>
                        <li class="divider"></li>
                        <li><a href="#">View calendar</a></li>
                      </ul>
                    </div>
                    <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div><!-- /. tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <!--The calendar -->

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
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        
        <strong>Copyright &copy; 2019 <a href="http://almsaeedstudio.com">Primustrades</a>.</strong> All rights reserved.
      </footer>

    

<div id="path" data-app-name="Primustrades" data-path="https://primustrades.net/" data-css-path="https://primustrades.net/public/css/" data-js-path="https://primustrades.net/public/js/"></div>
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