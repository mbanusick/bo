<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "conn.php";
 
// Define variables and initialize with empty values
//$username = $fullname = $oldpassword = $password1 = $password2 = $btcwallet = "";
$name = $name_err = $suc = $fullname_err = $password_err = $oldpassword_err = $password_err1 = $password_err2 = $btcwallet = $btc = $btcwallet_err = $submit_button = $oldpassword = $password1 = $password2 = $currentplan = "";

$id = $_SESSION["id"];

 // prepare statement for getting data from DB
$sql = "SELECT fullname, email, country, btcwallet FROM users WHERE id = $id";
        
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
						
				} 
			}
		}
	}

      
	   // prepare statement for getting CurrentPlan data from DB
$sql = "SELECT fullname, email, country, btcwallet FROM users WHERE id = $id";   /**********************************/
        
        if($stmt = $pdo->prepare($sql)){
           			
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
						$fullname = $row["fullname"]; /**********************************/
                        
						
				} 
			}
		}
	}
	  
	  
	  

		
// for Bitcoin Address update
//if ($_POST['btc']){		
//if($_SERVER["REQUEST_METHOD"] == "POST") {		
//if($_POST['btcwallet1']=="1"){
if(isset($_POST["btc"])) {

if(empty(trim($_POST["btc"]))){
        $btcwallet_err = "Please enter your BTC Wallet address.";     
    } elseif(strlen(trim($_POST["btc"])) < 26){
        $btcwallet_err = "Wallet address should be atleast 26 characters.";
    } else{
        $btc = trim($_POST["btc"]);
    }
	if(empty($btcwallet_err)){
        // Prepare an update statement
		$sql = "UPDATE users SET btcwallet = :btc WHERE id = :id";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":btc", $param_btc, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            
            // Set parameters
            //$param_password = ($new_name, PASSWORD_DEFAULT);trim($_POST["username"]);
			$param_btc = $btc;
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
	

// for Investment Plan update
//if ($_POST['btc']){		
//if($_SERVER["REQUEST_METHOD"] == "POST") {		
//if($_POST['btcwallet1']=="1"){
if(isset($_POST["plan"])) {

if(empty(trim($_POST["plan"]))){
        $plan_err = "Please select your plan.";     
    } else{
        $plan = trim($_POST["plan"]);
    }
	if(empty($plan_err)){
        // Prepare an update statement
		$sql = "UPDATE users SET btcwallet = :btc WHERE id = :id";  /**************************************************/
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":plan", $param_id, PDO::PARAM_INT);
            
            // Set parameters
            //$param_password = ($new_name, PASSWORD_DEFAULT);trim($_POST["username"]);
			$param_plan = $plan;
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
	

	
	


// for Password update
//if($_SERVER["REQUEST_METHOD"] == "POST"){
   if(isset($_POST["oldpassword"]) && isset($_POST["password1"]) && isset($_POST["password2"])) {
    // Check if password is empty
    if(empty(trim($_POST["oldpassword"]))){
        $password_err = "Please enter your old password.";
    } else{
        $password = trim($_POST["oldpassword"]);
    }
	
	if(empty(trim($_POST["password1"]))) {
		$password_err1 = "Please enter your new password.";
	} else {
		// Check of both passwords match
		
		if(trim($_POST["password1"]) !== trim($_POST["password2"])) {
			$password_err2 = "Both passwords doesn't match";
		} else {
			$password1 = trim($_POST["password1"]);
		}
	}
	
    
    // Validate credentials
    if(empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT password FROM users WHERE id = :id";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
           // $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
			
            // Set parameters
           // $param_username = trim($_POST["username"]);
			$param_id = $_SESSION["id"];
			
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
						
						if(empty($password_err1) && empty($password_err2)){
						
							// Prepare a select statement
							$sql = "UPDATE users SET password = :password1 WHERE id = :id";
        
							if($stmt = $pdo->prepare($sql)){
								// Bind variables to the prepared statement as parameters
								$stmt->bindParam(":password1", $param_password1, PDO::PARAM_STR);
								$stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
								
								// Set parameters
								$param_password1 = password_hash($password1, PASSWORD_DEFAULT); // Creates a password hash
								$param_id = $_SESSION["id"];
								
								// Attempt to execute the prepared statement
								if($stmt->execute()){
											
											
									//$suc = "New password created.";
									header("location: settings.php?success=New password created");
									
									
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
                $oldpassword_err = "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    
}
}
}
}






// for Profile, Name update


//if($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_POST["name"])) {
if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your Fullname.";     
        } else{
        $name = trim($_POST["name"]);
		} 
		if(empty($name_err)){
        // Prepare an update statement
$sql = "UPDATE users SET fullname = :name WHERE id = :id";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            
            // Set parameters
            //$param_password = ($new_name, PASSWORD_DEFAULT);trim($_POST["username"]);
			$param_name = $name;
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Name updated successfully. 
                //$suc = "Name changed succeffuly";
				header("location: settings.php?success=Name changed succeffuly");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
	

	

?>

<!DOCTYPE html>
<html lang="en" class="nojs">
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    
    <title>Primustrades</title>


    <link rel="icon" href="index.phppublic/images/world-diamond-logo-send.png" type="image/x-icon">
	
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

</head>
<div id="stopTracker" data-check="not-approved"></div>
<div id="tracker" data-trans-tracker="0" data-ref-tracker="0" data-activity-tracker="0"></div>
<div class="invoiceBackground"></div>
<div class="invoiceContainer"></div>

<!-- Trigger the modal with a button -->




<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
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
            <li class="treeview">
              <a href="dashboard.php">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <li class="active treeview">
              <a href="settings.php">
                <i class="fa fa-gears"></i>
                <span>Settings</span>
              </a>
            </li>
            <li class="active treeview">
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
            Settings
            <small>Page</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dahsboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Settings</li>
          </ol>
        </section>


        <!-- Main content -->
        <section class="content">

                  <div class="row">
            <!-- left column -->
            <div class="col-md-6">

              <!-- Input addon -->

              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Bitcoin Address</h3>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="box-body">
                    <div class="input-group">
                        <span class="input-group-addon"> <i class="fa fa-btc"></i> </span>
                        <input type="text" class="form-control" name="btc" placeholder="<?php echo $btcwallet; ?>">
                        <span class="input-group-addon">Btc Address</span>
						
                    </div>
					<span class="help-block"><?php echo $btcwallet_err; ?></span>
                </div>
                <div class="box-footer">
                    <span>Get a bitcoin address here <a target="_blank" href="https://blockchain.info/">click</a></span>
                    <br>
                  <button type="submit" class="btn btn-info pull-right">Update</button>
                </div><!-- /.box-footer -->
                </form>
              </div><!-- /.box -->
			   <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Change Password</h3>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="box-body">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" class="form-control" name="oldpassword" placeholder="Old Password" value="">
					<span class="input-group-addon">Old Password</span>
				</div>
					<div><span class="help-block"><?php echo $password_err; ?></span></div>
					<div><span class="help-block"><?php echo $oldpassword_err; ?></span></div>
                <div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" class="form-control" name="password1" placeholder="New Password" value="">
					<span class="input-group-addon">New Password</span>
					
				</div>
				<span class="help-block"><?php echo $password_err1; ?></span>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" class="form-control" name="password2" placeholder="Repeat Password" value="">
					<span class="input-group-addon">New Password</span>
					
				</div>
				<span class="help-block"><?php echo $password_err2; ?></span>
                <div class="box-footer">
                    
                    <br>
                  <button type="submit" class="btn btn-info pull-right">Change</button>
                </div><!-- /.box-footer -->
				</div>
                </form>
              </div>
              

            </div><!--/.col (left) -->

            
            <!-- right column -->
            <div class="col-md-6">
              <!-- Horizontal Form -->


                 <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Profile Settings</h3>
                </div>
                <div class="box-body">
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="input-group">
                    <span class="input-group-addon"> <i class="fa fa-user"></i> </span>
                    <input type="text" class="form-control" name="name" placeholder="<?php echo $fullname; ?>">
                    <span class="input-group-addon">Full Name</span>
                  </div>
				  	<span class="help-block"><?php echo $name_err; ?></span>
                  <br>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" readonly value="<?php echo $email; ?>">
                    <span class="input-group-addon">Email</span>
                  </div>
                  <br>
                
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                    <input type="text" class="form-control" readonly value="<?php echo $country; ?>">
                    <span class="input-group-addon">Country</span>
                  </div>
                  <br>
                  <button type="submit" class="btn btn-info pull-right">Update</button>
                  </form>
				  
                </div><!-- /.box-body -->
				
              </div>
			  
			   <!-- Horizontal Form -->


                 <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Plan Settings</h3>
                </div>
                <div class="box-body">
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="form-group has-feedback">
				  <span class="help-block">Current Plan: <?php echo $currentplan; ?> </span>
					<select name="plan"> 
						<option>Select your plan</option>
                          <option value="1">Invest</option>
                          <option value="2">Compounding</option>
                    </select>
				</div>
                 
                  <button type="submit" class="btn btn-info pull-right">Update</button>
                  </form>
				  
			  
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
		<footer class="main-footer">
        
        <strong>Copyright &copy; 2019 <a href="http://almsaeedstudio.com">Primustrades</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-user bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
<div id="path" data-app-name="Primustrades" data-path="index.php" data-css-path="index.phppublic/css/" data-js-path="index.phppublic/js/"></div>
<footer>
	
	<script src="index.phppublic/js/lib/jquery-3.0.0.min.js"></script>
	<script src="index.phppublic/js/lib/jquery-qrcode-0.14.0.min.js"></script>
	<script src="index.phppublic/js/app.js"></script>
	<!-- <script src="index.phppublic/plugins/jQuery/jQuery-2.1.4.min.js"></script> -->
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
			<script type="text/javascript" src="index.phppublic/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="index.phppublic/plugins/morris/morris.min.js"></script>
		<script type="text/javascript" src="index.phppublic/plugins/sparkline/jquery.sparkline.min.js"></script>
		<script type="text/javascript" src="index.phppublic/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script type="text/javascript" src="index.phppublic/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
		<script type="text/javascript" src="index.phppublic/plugins/knob/jquery.knob.js"></script>
		<script type="text/javascript" src="index.phppublic/plugins/daterangepicker/daterangepicker.js"></script>
		<script type="text/javascript" src="index.phppublic/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="index.phppublic/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
		<script type="text/javascript" src="index.phppublic/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<script type="text/javascript" src="index.phppublic/plugins/fastclick/fastclick.min.js"></script>
		<script type="text/javascript" src="index.phppublic/dist/js/app.min.js"></script>
		<script type="text/javascript" src="index.phppublic/dist/js/pages/dashboard.js"></script>
		<script type="text/javascript" src="index.phppublic/dist/js/demo.js"></script>
		<script type="text/javascript" src="index.phppublic/js/payment.js"></script>
		
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


