<?php
// Initialize the session
require_once "conn.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file

 
// Define variables and initialize with empty values
//$username = $fullname = $oldpassword = $password1 = $password2 = $btcwallet = "";
$name_err = $fullname_err = $oldpassword_err = $password1_err = $password2_err = $btcwallet1 = $btcwallet_err = $submit_button = "";
$ref_earning = $tot_earning = $cur_balance = $tot_deposit = "";

$id = $_SESSION["id"];



// Get user plan type




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

$plan = "SELECT * FROM plans WHERE id = $userPlan";
if($plan = $pdo->prepare($plan)){
  // Attempt to execute the prepared statement
  if($plan->execute()){
      // Check if username exists, if yes then verify password
      if($plan->rowCount() == 1){
        if($row = $plan->fetch()){
          $planType = $row["plantype"];
          $percentage = $row["percentage"];
      } 
    }
  }
}


  
if (empty($fullname)) {
  session_unset();
  session_destroy();
  header("location: login.php"); die(); /* Always check for all possibilities */
}
	
// for Bitcoin Withdrawal  
//if ($_POST['btc']){		
//if($_SERVER["REQUEST_METHOD"] == "POST") {		
//if($_POST['btcwallet1']=="1"){  

if(isset($_POST["with_amount"])) {

if(empty(trim($_POST["with_amount"]))){
        $with_amount_err = "Please enter withdrawal amount.";     
    } else{
        $with_amount = trim($_POST["with_amount"]);
    }
	if(empty($with_amount_err)){
        // Prepare an update statement
		$sql = "UPDATE users SET btcwallet = :btc WHERE id = :id";   /***********************************/
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":with_amount", $param_with_amount, PDO::PARAM_INT);
            
			
            // Set parameters
            //$param_password = ($new_name, PASSWORD_DEFAULT);trim($_POST["username"]);
			$param_with_amount = $with_amount;
            
			
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Withdrawal updated successful. 
                //$btc_suc = "Withdrawal Requested Successfully";
				header("location: settings.php?success=Withdrawal Requested Successfully");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
    }
    
    
}


// for Bitcoin Deposit  
//if ($_POST['btc']){		
//if($_SERVER["REQUEST_METHOD"] == "POST") {		
//if($_POST['btcwallet1']=="1"){  

if(isset($_POST["dep_amount"])) {

if(empty(trim($_POST["dep_amount"]))){
        $dep_amount_err = "Please enter withdrawal amount.";     
    } elseif(strlen(trim($_POST["dep_amount"])) < 3){                /***********************************/
        $dep_amount_err = "Deposit amount should not be less than 500.";
    } else{
        $dep_amount = trim($_POST["dep_amount"]);
    }
	if(empty($dep_amount_err)){
        // Prepare an update statement
		$sql = "UPDATE users SET btcwallet = :btc WHERE id = :id";   /***********************************/
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":btc", $param_dep_amount, PDO::PARAM_INT);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            
            // Set parameters
            //$param_password = ($new_name, PASSWORD_DEFAULT);trim($_POST["username"]);
			$param_dep_amount = $dep_amount;
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Name updated successfully. 
                //$btc_suc = "Address changed succeffuly";
				header("location: settings.php?success=Address changed succeffuly");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
    }
    
    
}


// Fetch users approved investments;
	
$getInvestments= $pdo->prepare("SELECT investment.*, invoice.amount, plans.plantype FROM investment LEFT JOIN invoice ON investment.p_invoice = invoice.id LEFT JOIN plans ON invoice.id_plan = plans.id WHERE invoice.p_user = $id ORDER BY investment.id DESC"); 
$getInvestments->execute();

$investments = [];
while ($row = $getInvestments->fetch(PDO::FETCH_ASSOC)) { 
  array_push($investments, $row); 
}
// Sum all the user investments.
$investementAmounts = [];
for($i=0; $i < count($investments); $i ++) {
  array_push($investementAmounts, $investments[$i]["amount"]);
}
$investementAmount = array_sum($investementAmounts);






?>

<!DOCTYPE html>
<html lang="en" class="nojs">

<head>
  <meta charset="utf-8">
  <meta name="viewport"
    content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">


  <title>Laxiom</title>

  <link rel="icon" href="index.phppublic/images/world-diamond-logo-send.png" type="image/x-icon">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" type="text/css"
    href="//fonts.googleapis.com/css?family=Arvo:400,700%7COpen+Sans:300,300italic,400,400italic,700italic,800%7CUbuntu:500">



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

<style>
  #pay-btn, #paymentCallback, #successMsg {
    display: none;
  }
</style>

</head>


<body class="hold-transition skin-blue sidebar-mini">


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Withdraw Funds</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group">
            <label class="text-gray-base form-label form-label-outside">Amount:</label>
            <input class="form-control" type="text" name="with_amount"
              placeholder="Enter the amount you want to withdraw">
          </div>
          <button class="btn btn-lg btn-primary">Request Funds</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Deposit Funds</h4>
      </div>
      <div class="modal-body">
          <div id="paymentCallback" class="alert alert-danger"></div>
          <div class="text-center">
            <div><span class="fa fa-spinner fa-spin"></span></div><br>
            <span style="color: red">Pay exact amount</span>
            <div style="color: blue">
              <span id="btc-value">0</span> BTC
            </div>
            to
          </div>
          <input type="hidden" id="userPlan" value=<?=$userPlan?> />
          <p id="btcAddress" class="text-center">39b2nCCnJKQCYJW8fT97dfVUckvbLDM9g2</p>

          <hr><hr>
    
          <div class="form-group">
            <input class="form-control" type="text" id="txId" name="with_amount" placeholder="Enter your Transaction ID">
            <i class="fa fa-btc text-center"></i> Powered by blockchain</span>
          </div>
          
          <button class="btn btn-block btn-primary" id="txtSubmit">Verify Deposit</button> 
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">Laxiom</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Laxiom</b></span>
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
                <span class="hidden-xs"><b><?php echo $fullname; ?></b></span>
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
          <li class="active treeview">
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

        <div id="successMsg" class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">   
            <span aria-hidden="true">×</span><span class="sr-only">Close</span>
          </button>
          <span id="successMessage"></span>          
        </div>
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3>$<?php echo $investementAmount; ?></h3>
                <p>Total Deposits</p>
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
                <h3>$<?php echo $cur_balance; ?><sup style="font-size: 20px"></sup></h3>
                <p>Current Balance</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Number of Investemnts</a>
            </div>
          </div><!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3>$<?php echo $tot_earning; ?></h3>
                <p>Total Earnings</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="index.phpDashboard/affiliate" class="small-box-footer">Become an affiliate <i
                  class="fa fa-arrow-circle-right"></i></a>


            </div>
          </div><!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3>$<?php echo $ref_earning; ?></h3>
                <p>Referral Earnings</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" type="button" data-toggle="modal" data-target="#myModal" class="small-box-footer">Make
                withdrawal request <i class="fa fa-arrow-circle-right"></i></a>
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
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table class="table table-bordered">
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Plan</th>
                          <th>Investment Amount</th>
                          <th>Profit Received</th>
                          <th>Investment Date</th>
                          
                        </tr>
                        <?php for($i=0; $i < count($investments);$i++): ?>
                          <tr>
                            <td><?=$i + 1?></td>
                            <td><?=$investments[$i]["plantype"]?></td>
                            <td>$<?=$investments[$i]["amount"]?></td>
                            <td>0</td>
                            <td><?=$investments[$i]["date_updated"]?></td>
                            
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
            <!-- /.nav-tabs-custom -->
            <!-- Custom tabs (Charts with tabs)-->
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
                          <th>Plan</th>
                          <th>Amount</th>
                          <th>Today rate(%)</th>
                          <th>Received</th>
                          <th>Investment date</th>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>Silver</td>
                          <td>$1000.00</td>
                          <td>


                            <span class="badge bg-primary">1.6%</span>
                          </td>
                          <td> $64.00</td>
                          <td> 2019-07-29 19:00:01</td>
                        </tr>
                      </table>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->
                </div>
                <div class="chart tab-pane" style="position: relative; height: 300px;">

                </div>
              </div>
            </div>
            <!-- /.nav-tabs-custom -->


          </section><!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">


            <!-- Map box start-->
            <form action="" method="post">
              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header with-border">
                  <h3 class="box-title">Invest Now</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div id="btcPayment" style="display: block;">
                    <!-- <div id="amountCallback" class="callback alert alert-info"></div> -->
                    <div>
                    <div class="form-group">
                        <label for="fist-name" class="text-gray-base form-label form-label-outside">Enter investment amount:</label>
                        <select id="plan" name="plan" class="form-control">
                          <option>Select plan</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="fist-name" class="text-gray-base form-label form-label-outside">Enter investment amount:</label>
                        <input id="payAmount" type="text" name="usd-amount" class="form-control"
                          placeholder="Minimum deposit $500">
                      </div>
                      <p>Selected Plan: <?=$planType?> (<?=$percentage?>% rate)</p>
                      <!-- <div class="form-group form-group-outside">
                        <label for="fist-name" class="text-gray-base form-label form-label-outside">BTC Value:</label>
                        <input id="btc-value" name="btc-value" type="text" readonly
                          class="form-control bg-whisper-lighten">
                      </div>
                      <div class="form-group">
                        <label class="text-gray-base form-label form-label-outside">Send to Address:</label>
                        <input class="form-control" type="text" name="with_amount"
                          value="39b2nCCnJKQCYJW8fT97dfVUckvbLDM9g2" readonly class="form-control bg-whisper-lighten">
                      </div>
                      <div class="form-group">
                        <label class="text-gray-base form-label form-label-outside">Txn ID:</label>
                        <input class="form-control" type="text" name="with_amount"
                          placeholder="Enter your Transaction ID">
                      </div> -->
                      <div class="form-group" id="pay-btn">
                        <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary"
                          id="amountSubmit">Deposit Funds</button>
                      </div>
                    </div>

<!-- 
                    <div class="cell-md-6 offset-top-22 offset-md-top-0">
                      <div class="form-group form-group-outside">
                        <label for="duration" class="text-gray-base form-label form-label-outside">Rate(%)</label>
                        <input id="duration" type="text" readonly class="form-control bg-whisper-lighten">
                      </div>
                    </div> -->


                  </div>
                </div>
              </div>
            </form>
            <!-- Map box end -->

            <!-- Request box  -->
            <div class="modal-content">
              <div class="modal-header">
                
                <h4 class="modal-title">Withdraw Funds</h4>
              </div>
              <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="form-group">
                    <label class="text-gray-base form-label form-label-outside">Txn ID:</label>
                    <input class="form-control" type="text" name="with_amount"
                      placeholder="Enter the amount you want to withdraw">
                  </div>
                  <button class="btn btn-lg btn-primary">Request Funds</button>
                </form>
              </div>
              
            </div>



            <!-- Request box end -->

          </section><!-- right col -->
        </div><!-- /.row (main row) -->

      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <footer class="main-footer">

      <strong>Copyright &copy; 2017 <a href="">Laxiom</a>.</strong> All rights reserved.
    </footer>



    <div id="path" data-app-name="Laxiom" data-path="index.php" data-css-path="index.phppublic/css/"
      data-js-path="index.phppublic/js/"></div>
    <footer>

      <script src="./Dashboard_files/jquery-3.0.0.min.js"></script>
      <script src="./Dashboard_files/jquery-qrcode-0.14.0.min.js"></script>
      <script src="./Dashboard_files/app.js"></script>
      <!-- <script src="./Dashboard_files/juery-3..4.min.js"></script> -->
      <script src="./Dashboard_files/jquery-ui.min.js"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
        $.widget.bridge('uibutton', $.ui.button);
      </script>
      <script src="./Dashboard_files/raphael-min.js"></script>
      <script src="./Dashboard_files/moment.min.js"></script>
      <script src="./Dashboard_files/sweetalert.min.js"></script>
      <script type="text/javascript" src="./Dashboard_files/bootstrap.min.js"></script>
      <script type="text/javascript" src="./Dashboard_files/morris.min.js"></script>
      <script type="text/javascript" src="./Dashboard_files/jquery.sparkline.min.js"></script>
      <script type="text/javascript" src="./Dashboard_files/jquery-jvectormap-1.2.2.min.js"></script>
      <script type="text/javascript" src="./Dashboard_files/jquery-jvectormap-world-mill-en.js"></script>
      <script type="text/javascript" src="./Dashboard_files/jquery.knob.js"></script>
      <script type="text/javascript" src="./Dashboard_files/daterangepicker.js"></script>
      <script type="text/javascript" src="./Dashboard_files/bootstrap-datepicker.js"></script>
      <script type="text/javascript" src="./Dashboard_files/bootstrap3-wysihtml5.all.min.js"></script>
      <script type="text/javascript" src="./Dashboard_files/jquery.slimscroll.min.js"></script>
      <script type="text/javascript" src="./Dashboard_files/fastclick.min.js"></script>
      <script type="text/javascript" src="./Dashboard_files/app.min.js"></script>

      <script type="text/javascript" src="./Dashboard_files/demo.js"></script>


      <script>

        /* Investment */
        const btcValueInput = $("#btc-value");
        const amountCallback = $("#amountCallback");
        const payBtn = $("#pay-btn");

        $("#payAmount").keyup(() => {
          const self = $("#payAmount");
          $.get("https://api.coindesk.com/v1/bpi/currentprice/USD.json", (res) => {
            let btcPrice = JSON.parse(res).bpi.USD.rate_float;

            // convert user input to btc
            let userAmount = Number(self.val());

            if(userAmount < 500 || !Number(userAmount)) {
             
              amountCallback.css("display", "block");
              payBtn.css("display", "none");
              amountCallback.text("Minimum deposit $500");
            } else {
              amountCallback.css("display", "none");
              payBtn.css("display", "block");
               /* 
                $1 -> btcPrice 
                $x -> userAmount
        
                Input Btc value = userAmount divided by btcprice
              */
              let btcValue = userAmount / btcPrice;
              btcValueInput.text(btcValue.toFixed(6));
            } 
           

          });



        });


        // Submit investment deposit
        const txtSubmit = $("#txtSubmit");
        const paymentCallback = $("#paymentCallback");
        const successMsg = $("#successMsg");
        const successMessage = $("#successMessage");

        txtSubmit.click(function() {
          successMsg.css("display", "none");
          const txId = $("#txId").val();
          const payAmount = $("#payAmount").val();
          const btcValue = $("#btc-value").text();
          const btcAddress = $("#btcAddress").text();
          const userPlan = $("#userPlan").val();
          if(txId !== "") {
            paymentCallback.css("display", "none");
            $.post("./investment.php", { txId, payAmount, btcValue, btcAddress, userPlan }, function(res) {
              

                if(res == 1) {
               
                  $("#myModal2").modal('hide');
                  paymentCallback.css("display", "none");
                  paymentCallback.text("");
                  
                  $("#btc-value").text("");
                  $("#payAmount").val("");
                  $("#txId").val("");
                  payBtn.css("display", "none");

                  successMsg.css("display", "block");
                  successMsg.text("Your deposit has been sent for verification. Thank you.");
                  
                } else {
                  
                  
                  paymentCallback.css("display", "block");
                  paymentCallback.text("Please enter your transaction txid");
                }



            }); 
          } else {
            paymentCallback.css("display", "block");
            paymentCallback.text("Please enter your transaction txid", "ccvd");
          }
          
        });
      









        $(function () {

          try {
            $("#side-navigation").tabs({ show: { effect: "fade", duration: 400 } });

          } catch (e) {

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

          } catch (e) {

          }


          try {

            $('input').iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
              increaseArea: '20%' // optional
            });

          } catch (e) {

          }

        });
      </script>

    </footer>
    </main>
</body>