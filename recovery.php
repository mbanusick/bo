<?php
// Initialize the session
// Include config file
require_once "conn.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}
 

 
// Define variables and initialize with empty values
$username = $fullname = $password = $email = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
 
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, email FROM users WHERE email = :username OR username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
			
            // Set parameters
            $param_username = trim($_POST["username"]);
        
			
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $email = $row["email"];
						
							
							
                            
							
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username or email.";
                }
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
    
    
    <title>Laxiom Investment | Password Recovery</title>

	
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
<body class="hold-transition lockscreen">
<?php include 'lang.php';?>
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
		<div class="register-logo">
		  <a href="index.php">
		  <img style="width: 100%" src="" >
		  </a>
		</div>
		  <!-- User name -->
		    <?php if(isset($_GET["success"])): ?>
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">   
						<span aria-hidden="true">×</span><span class="sr-only">Close</span>
					</button>
					<?=$_GET["success"] ?>           
				</div>
			<?php endif; ?>
			
		<div class="lockscreen-name">Forgot Your Password</div>

                                   <!-- lockscreen credentials (contains the form) -->
		 <div>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
						 <div class="form-group has-feedback">
							<input type="text" class="form-control" name="username" placeholder="Email or Username" value="<?php echo $username; ?>">
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							<span class="help-block"><?php echo $username_err; ?></span>
						 </div>
						 
						 <div class="col-xs-4">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Recover</button>
						 </div>
					  
					</form><!-- /.lockscreen credentials -->
		 </div>
			    <div>
				 <a href="login.php">Have an Account? Login</a>
				</div>
				<div>
				 <a href="register.php">Don't have an Account? Create One</a>
				</div>
			
       </div><!-- /.lockscreen-item -->
     
	 
		
   
		
	<div class="lockscreen-wrapper">
		
      <div>
        Copyright &copy; 2017 <b><a href="index.php">>Laxiom Investment</a></b> All rights reserved
      </div>
	</div>
    <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
</div>
<?php include 'tawk.php';?>
</body>
</html>
