
<?php
  require "conn.php";
  
  //check for user admin role 
  
  $id = $_SESSION["id"];


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

	
	
$getInvoice= $pdo->prepare("SELECT invoice.*, users.fullname, plans.schedule, users.plan FROM invoice 
LEFT JOIN users ON invoice.p_user = users.id 
LEFT JOIN plans ON users.plan = plans.id
WHERE invoice.status = 0");

$getInvoice->execute();

$invoice = [];
while ($row = $getInvoice->fetch(PDO::FETCH_ASSOC)) { 
    array_push($invoice, $row); 
}

if(isset($_POST["invoiceId"]) && isset($_POST["schedule"]) && isset($_POST["plan"])) {
  $invoiceId = trim($_POST["invoiceId"]);
  $schedule = trim($_POST["schedule"]);
  $plan = $_POST["plan"];

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
  
  global $CONFIG; // Making CONFIG variable accessible in this project file.

  switch($plan) {
    case "1":
      $schedule = $schedule; break;
    case "2":
      $schedule = $CONFIG['compounding']; break;
  } 

  $mkTime = strtotime("+$schedule");
  $nxtPayment = date("Y-m-d H:i:s", $mkTime);
	
	$investAdd = $pdo->prepare("INSERT INTO investment (p_invoice, amount, next_payment) VALUES (:invoiceId, 0, '$nxtPayment')");
		
  // Bind variables to the prepared statement as parameters
  $investAdd->bindParam(":invoiceId", $param_invoiceId, PDO::PARAM_INT);

  // Set parameters
  $param_invoiceId = $invoiceId;

	$investAdd->execute();
	$pdo->commit();
	header("location: dashboard2.php?success=Investment Added");
	
	
  } catch(PDOException $e) {
	$pdo->rollBack();
    header("location: dashboard2.php?error=Error while verifying payment. Please try again or contact dev department" );
  }
 
}

//For Change of Site BTC address & Display
$sitebtc_add= $pdo->prepare("SELECT pay_address FROM settings WHERE id = 1"); 
$sitebtc_add->execute();
if($sitebtc_add->execute()) {
      if($sitebtc_add->rowCount() == 1) {

        if($row = $sitebtc_add->fetch()) {
          $sitebtc_add = $row["pay_address"];
        }
}
}
if(isset($_POST["sitebtc_add"]) && isset($_POST["pin"])){

	$sitebtc_add = trim($_POST["sitebtc_add"]);
	$pin = (int)trim($_POST["pin"]);
	
	if ($pin == '191442') {
	$pdo->prepare("UPDATE settings SET pay_address = '$sitebtc_add' WHERE id = 1")->execute();
	}
} else {
$sitebtc_add_err= "Error: No address or password input";
}



//For listing and approval of Pending withdrawals

// Fetch users Withdrawals;
$getWithdrawals= $pdo->prepare("SELECT withdrawal.*, users.fullname FROM withdrawal JOIN wallet ON withdrawal.wallet_id = wallet.wallet_id JOIN users ON wallet.id_user=users.id WHERE withdrawal.status = 0 ORDER BY withdrawal.id DESC"); 
$getWithdrawals->execute();

$withdrawals = [];
while ($row = $getWithdrawals->fetch(PDO::FETCH_ASSOC)) { 
  array_push($withdrawals, $row); 
}

//For Withdrawal cancellation  *********************************************************************

if(isset($_POST["cancel"]) && isset($_POST["cancel_amount"]) && isset($_POST["with_id"])) {  //make sure all values are available

	$cancel = (int)trim($_POST["cancel"]);
	$with_amount = (float)trim($_POST["cancel_amount"]);
	$with_id = (int)trim($_POST["with_id"]);
 
	try {
    $pdo->beginTransaction();
    //Try comparing input data with DB values
    $checkWithdrawal = $pdo ->prepare("SELECT with_amount FROM withdrawal WHERE id = $with_id");
    if($checkWithdrawal->execute()) {
      if($checkWithdrawal->rowCount() == 1) {

        if($row = $checkWithdrawal->fetch()) {
          $amount = (float)$row["with_amount"];
        }

        if ($with_amount == $amount) {
        //cancellation querry
          $pdo->prepare("UPDATE withdrawal SET status = 2 WHERE id = $with_id")->execute();
          //to return funds to wallet we need to get wallet value and add intended with back
          $getWallet = $pdo->prepare("SELECT wallet_amount FROM wallet WHERE id_user = $id");

          if($getWallet->execute()) {
            if($getWallet->rowCount() == 1) {
              $row = $getWallet->fetch(); 
              $cur_wallet = $row["wallet_amount"];
            } else {
              header("location: dashboard.php?error=Error while fetching wallet balance. Please try again later.");
              throw new Exception();
            }
          }
          //current wallet + withdrawal
          $bal_toreturn = $cur_wallet + $with_amount;
          
          $returnWallet = $pdo->prepare("UPDATE wallet SET wallet_amount = $bal_toreturn WHERE id_user = $id")->execute();
        } else {
          header("location: dashboard.php?error=Unexpected error. Please try again later.");
          throw new Exception();	
        }
      } else {
        header("location: dashboard.php?error=Unexpected error. Please try again later.");
        throw new Exception();	
      }
    }
    $pdo->commit();

    header("location: dashboard.php?success=Your withdrawal request has been canceled successfully" );
		
	} catch(PDOException $e) {
	  $pdo->rollBack();
    // die($e);
    header("location: dashboard.php?error=Please try again or contact dev department" );
    die();
  }
  
  // die("errr");
}

  //For Withdrawal Approval  *********************************************************************

if(isset($_POST["approve"]) && isset($_POST["with_id"])) {  //make sure all values are available

	$approve = (int)trim($_POST["approve"]);
	
	$with_id = (int)trim($_POST["with_id"]);
	
	
	$pdo->prepare("UPDATE withdrawal SET status = 1 WHERE id = $with_id")->execute();
	header("location: dashboard2.php?success=Approval Successful" );
    //$pdo->commit();

  }
  
  // die("errr");

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
            
            <li>
			<li class="active treeview">
              <a href="dashboard2.php">
                <i class="fa fa-dashboard"></i> <span>Admin Panel</span>
              </a>
            </li>
            <li>
              <a href="logout.php">
                <i class="fa fa-area-chart"></i> <span>Logout</span>
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
                                <a href="https://Laxiom.net/Dashboard/affiliate" class="small-box-footer">Become an affiliate <i class="fa fa-arrow-circle-right"></i></a>
                                
                
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
                            <td>$<?=$invoice[$i]["usd_amount"]?></td>
                            <td><?=$invoice[$i]["btc_amount"]?></td>
                            <td><?=$invoice[$i]["tx_id"]?></td>
                            <td>
                             
							  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                          <input type="hidden" name="schedule" value="<?=$invoice[$i]["schedule"]?>" />
                          <input type="hidden" name="invoiceId" value="<?=$invoice[$i]["id"]?>" />
                          <input type="hidden" name="plan" value="<?=$invoice[$i]["plan"]?>" />
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
<!-- *********************************************************************Withdrawal -->
 <div class="nav-tabs-custom">
              <!-- Tabs within a box -->
              <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#revenue-chart" data-toggle="tab">Withdrawals</a></li>
                <li class="pull-left header"><i class="fa fa-inbox"></i> Withdrawals</li>
              </ul>
              <div class="tab-content no-padding">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" style="position: relative;">
                  <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table class="table table-bordered">
                        <tr>
                          <th style="width: 10px">#</th>
						  <th>Name</th>
                          <th>Withdrawal Amount</th>
                          <th>Address</th>
                          <th>Status</th>
                          <th>Withdrawal Date</th>
                          
                        </tr>
                        <?php for($i=0; $i < count($withdrawals);$i++): ?>
                          <tr>
                            <td><?=$i + 1?></td>
							<td><?=$withdrawals[$i]["fullname"]?></td>
                            <td>$<?=$withdrawals[$i]["with_amount"]?></td>
                            <td><?=$withdrawals[$i]["toAddress"]?></td>
                            <td>
                              <?php if($withdrawals[$i]["status"] === "1"): ?>
                              <div class="text-center text-success"><span class="fa fa-checked"></span></div>
                              <?php elseif($withdrawals[$i]["status"] === "2"): ?>
                                <div class="text-center text-danger"><span class="fa fa-times"></span></div>
                              <?php else: ?>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                  <input type="hidden" name="cancel" value="2" >
								  
                                  <input type="hidden" name="cancel_amount" value="<?=$withdrawals[$i]["with_amount"]?>">
                                  <input type="hidden" name="with_id" value="<?=$withdrawals[$i]["id"]?>">
                                  <button class="btn btn-secondary">Cancel</button>
								  
                                </form>
								<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                  
								  <input type="hidden" name="approve" value="1" >
                                 
                                  <input type="hidden" name="with_id" value="<?=$withdrawals[$i]["id"]?>">
                                 
								  <button class="btn btn-secondary">Approve</button>
                                </form>
                              <?php endif; ?>
                            </td>
                            <td><?=$withdrawals[$i]["createdAt"]?></td>
                            
                    </tr>

                  <?php endfor; ?>

                      </table>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->
                </div>
                <div class="chart tab-pane" style="position: relative; height: 300px;">

                </div>
              </div>
            </div>
			
<!-- **************************************************************** -->			
              <!-- Chat box -->
              
                  <!-- /.box-header -->
                    <!-- /.box-body -->
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
  
				<!-- Request box  -->
            <div class="modal-content">
              <div class="modal-header">
                
                <h4 class="modal-title">Site BTC Deposit Address</h4>
              </div>
              <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="form-group">
                    <label class="text-gray-base form-label form-label-outside">Current Address: <?php echo $sitebtc_add; ?></label>
                    <input class="form-control" type="text" name="sitebtc_add"
                      placeholder="Enter new btc address">
					<input class="form-control" type="text" name="pin"
                      placeholder="Enter PIN">
                  </div>
                  <button class="btn btn-lg btn-primary">Change Address</button>
                </form>
              </div>
              
            </div>



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