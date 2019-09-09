
<?php
// Include config file
require_once "conn.php";
// Define variables and initialize with empty values "password1""password2""type""btc_wallet""phone""country""email""lastname"firstname
$username = $password1 = $password2 = $type = $btc_wallet = $phone = $country = $email = $fullname = $plan = "";
$username_err = $fullname_err = $email_err = $password1_err = $password2_err = $country_err = $plan_err = "";

// Start Fetch Plans
// $plans = $pdo->prepare("SELECT id, plantype FROM plans"); 
// $plans->execute();

// $planData = [];
// while ($row = $plans->fetch(PDO::FETCH_ASSOC)) { 
//     array_push($planData, $row); /* while there are still data in the db, send them to an array container */
// }
// End fetch Plans


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
	
	// Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = :email";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email_err = "This email already exists.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
	
	 // Validate fullname
    if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter your Fullname.";     
    } else{
        $fullname = trim($_POST["fullname"]);
    }
	
		 // Validate country
    if(empty(trim($_POST["country"]))){
        $country_err = "Please select your country.";     
    } else{
        $country = trim($_POST["country"]);
        // echo $country;
    }
	
    	// Validate plan
    if(empty(trim($_POST["plan"]))){
        $plan_err = "Please select your preferred.";     
    } else{
        $plan = trim($_POST["plan"]);
    }
	
    // Validate password
    if(empty(trim($_POST["password1"]))){
        $password1_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password1"])) < 6){
        $password1_err = "Password must have atleast 6 characters.";
    } else{
        $password1 = trim($_POST["password1"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["password2"]))){
        $password2_err = "Please confirm password.";     
    } else{
        $password2 = trim($_POST["password2"]);
        if(empty($password1_err) && ($password1 != $password2)){
            $password2_err = "Passwords did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($fullname_err) && empty($password1_err) && empty($password2_err) && empty($plan_err) && empty($country_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, fullname, email, country, plan) VALUES (:username, :password, :fullname, :email, :country, :plan)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
			$stmt->bindParam(":fullname", $param_fullname, PDO::PARAM_STR);
           	$stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
			$stmt->bindParam(":country", $param_country, PDO::PARAM_STR);
			$stmt->bindParam(":plan", $param_plan, PDO::PARAM_INT);
            
            // Set parameters
            $param_username = $username;
			$param_password = password_hash($password1, PASSWORD_DEFAULT); // Creates a password hash
			$param_fullname = $fullname;
			$param_email = $email;
            $param_country = $country;
			$param_plan = $plan;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php?success=Registration was Successful; Login" );
            } else{
                echo "Something went wrong. Please try again later.";
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
    
    
    <title>Laxiom</title>

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
<body class="hold-transition register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="index.php">
        <img style="width: 100%" src="" >
        </a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg">Open an Account</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">        
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="fullname" placeholder="Full name" value="<?php echo $fullname; ?>">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
			<span class="help-block"><?php echo $fullname_err; ?></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email; ?>">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			<span class="help-block"><?php echo $email_err; ?></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username; ?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
			<span class="help-block"><?php echo $username_err; ?></span>
          </div>
          <div class="form-group has-feedback">Select your country:
          <select class="form-control" name="country" label="teeeeee"> 
            <option value="<?php echo $country; ?>" selected><?php echo $country; ?></option>
                          <option>Afghanistan</option>
                          <option >Aland Islands</option>
                          <option >Albania</option>
                          <option >Algeria</option>
                          <option >American Samoa</option>
                          <option >Andorra</option>
                          <option >Angola</option>
                          <option >Anguilla</option>
                          <option >Antarctica</option>
                          <option >Antigua and Barbuda</option>
                          <option>Argentina</option>
                          <option>Armenia</option>
                          <option>Aruba</option>
                          <option >Asia / Pacific Region</option>
                          <option>Australia</option>
                          <option>Austria</option>
                          <option>Azerbaijan</option>
                          <option>Bahamas</option>
                          <option>Bahrain</option>
                          <option>Bangladesh</option>
                          <option>Barbados</option>
                          <option>Belarus</option>
                          <option>Belgium</option>
                          <option>Belize</option>
                          <option>Benin</option>
                          <option>Bermuda</option>
                          <option>Bhutan</option>
                          <option>Bolivia</option>
                          <option >Bonaire, Sint Eustatius and Saba</option>
                          <option>Bosnia and Herzegovina</option>
                          <option>Botswana</option>
                          <option>Bouvet Island</option>
                          <option>Brazil</option>
                          <option>British Indian Ocean Territory</option>
                          <option>Brunei Darussalam</option>
                          <option>Bulgaria</option>
                          <option>Burkina Faso</option>
                          <option>Burundi</option>
                          <option>Cambodia</option>
                          <option>Cameroon</option>
                          <option>Canada</option>
                          <option>Cape Verde</option>
                          <option>Cayman Islands</option>
                          <option>Central African Republic</option>
                          <option>Chad</option>
                          <option>Chile</option>
                          <option>China</option>
                          <option>Christmas Island</option>
                          <option>Cocos (Keeling) Islands</option>
                          <option>Colombia</option>
                          <option>Comoros</option>
                          <option>Congo</option>
                          <option>Congo, the Democratic Republic of the</option>
                          <option>Cook Islands</option>
                          <option>Costa Rica</option>
                          <option>Cote D'Ivoire</option>
                          <option>Croatia</option>
                          <option>Cuba</option>
                          <option >Curacao</option>
                          <option>Cyprus</option>
                          <option>Czech Republic</option>
                          <option>Denmark</option>
                          <option>Djibouti</option>
                          <option>Dominica</option>
                          <option>Dominican Republic</option>
                          <option>Ecuador</option>
                          <option>Egypt</option>
                          <option>El Salvador</option>
                          <option>Equatorial Guinea</option>
                          <option>Eritrea</option>
                          <option>Estonia</option>
                          <option>Ethiopia</option>
                          <option>Falkland Islands (Malvinas)</option>
                          <option>Faroe Islands</option>
                          <option>Fiji</option>
                          <option>Finland</option>
                          <option>France</option>
                          <option>French Guiana</option>
                          <option>French Polynesia</option>
                          <option>French Southern Territories</option>
                          <option>Gabon</option>
                          <option>Gambia</option>
                          <option>Georgia</option>
                          <option>Germany</option>
                          <option>Ghana</option>
                          <option>Gibraltar</option>
                          <option>Greece</option>
                          <option>Greenland</option>
                          <option>Grenada</option>
                          <option>Guadeloupe</option>
                          <option>Guam</option>
                          <option>Guatemala</option>
                          <option >Guernsey</option>
                          <option>Guinea</option>
                          <option>Guinea-Bissau</option>
                          <option>Guyana</option>
                          <option>Haiti</option>
                          <option>Heard Island and Mcdonald Islands</option>
                          <option>Honduras</option>
                          <option>Hong Kong</option>
                          <option>Hungary</option>
                          <option>Iceland</option>
                          <option>India</option>
                          <option >Indonesia</option>
                          <option >Iran, Islamic Republic of</option>
                          <option >Iraq</option>
                          <option >Ireland</option>
                          <option >Isle of Man</option>
                          <option >Israel</option>
                          <option >Italy</option>
                          <option >Jamaica</option>
                          <option >Japan</option>
                          <option >Jersey</option>
                          <option >Jordan</option>
                          <option >Kazakhstan</option>
                          <option >Kenya</option>
                          <option >Kiribati</option>
                          <option >Korea, Democratic People's Republic of</option>
                          <option >Korea, Republic of</option>
                          <option >Kosovo</option>
                          <option >Kuwait</option>
                          <option >Kyrgyzstan</option>
                          <option >Lao People's Democratic Republic</option>
                          <option >Latvia</option>
                          <option >Lebanon</option>
                          <option >Lesotho</option>
                          <option >Liberia</option>
                          <option >Libyan Arab Jamahiriya</option>
                          <option >Liechtenstein</option>
                          <option >Lithuania</option>
                          <option >Luxembourg</option>
                          <option >Macao</option>
                          <option >Macedonia, the Former Yugoslav Republic of</option>
                          <option >Madagascar</option>
                          <option >Malawi</option>
                          <option >Malaysia</option>
                          <option >Maldives</option>
                          <option >Mali</option>
                          <option >Malta</option>
                          <option >Marshall Islands</option>
                          <option >Martinique</option>
                          <option >Mauritania</option>
                          <option >Mauritius</option>
                          <option >Mayotte</option>
                          <option >Mexico</option>
                          <option >Micronesia, Federated States of</option>
                          <option >Moldova, Republic of</option>
                          <option >Monaco</option>
                          <option >Mongolia</option>
                          <option >Montenegro</option>
                          <option >Montserrat</option>
                          <option >Morocco</option>
                          <option >Mozambique</option>
                          <option >Myanmar</option>
                          <option >Namibia</option>
                          <option >Nauru</option>
                          <option >Nepal</option>
                          <option >Netherlands</option>
                          <option >Netherlands Antilles</option>
                          <option >New Caledonia</option>
                          <option >New Zealand</option>
                          <option >Nicaragua</option>
                          <option >Niger</option>
                          <option >Nigeria</option>
                          <option >Niue</option>
                          <option >Norfolk Island</option>
                          <option >Northern Mariana Islands</option>
                          <option >Norway</option>
                          <option >Oman</option>
                          <option >Pakistan</option>
                          <option >Palau</option>
                          <option >Palestinian</option>
                          <option >Panama</option>
                          <option >Papua New Guinea</option>
                          <option >Paraguay</option>
                          <option >Peru</option>
                          <option >Philippines</option>
                          <option >Pitcairn</option>
                          <option >Poland</option>
                          <option >Portugal</option>
                          <option >Puerto Rico</option>
                          <option >Qatar</option>
                          <option >Reunion</option>
                          <option >Romania</option>
                          <option >Russian Federation</option>
                          <option >Rwanda</option>
                          <option >Saint Barthelemy</option>
                          <option >Saint Helena</option>
                          <option >Saint Kitts and Nevis</option>
                          <option >Saint Lucia</option>
                          <option >Saint Martin</option>
                          <option >Saint Pierre and Miquelon</option>
                          <option >Saint Vincent and the Grenadines</option>
                          <option >Samoa</option>
                          <option >San Marino</option>
                          <option >Sao Tome and Principe</option>
                          <option >Saudi Arabia</option>
                          <option >Senegal</option>
                          <option >Serbia</option>
                          <option >Seychelles</option>
                          <option >Sierra Leone</option>
                          <option >Singapore</option>
                          <option >Sint Maarten</option>
                          <option >Slovakia</option>
                          <option >Slovenia</option>
                          <option >Solomon Islands</option>
                          <option >Somalia</option>
                          <option >South Africa</option>
                          <option >South Georgia and the South Sandwich Islands</option>
                          <option >South Sudan</option>
                          <option >Spain</option>
                          <option >Sri Lanka</option>
                          <option >Sudan</option>
                          <option >Suriname</option>
                          <option >Svalbard and Jan Mayen</option>
                          <option >Swaziland</option>
                          <option >Sweden</option>
                          <option >Switzerland</option>
                          <option >Syrian Arab Republic</option>
                          <option >Taiwan, Province of China</option>
                          <option >Tajikistan</option>
                          <option >Tanzania, United Republic of</option>
                          <option >Thailand</option>
                          <option >Timor-Leste</option>
                          <option >Togo</option>
                          <option >Tokelau</option>
                          <option >Tonga</option>
                          <option >Trinidad and Tobago</option>
                          <option >Tunisia</option>
                          <option >Turkey</option>
                          <option >Turkmenistan</option>
                          <option >Turks and Caicos Islands</option>
                          <option >Tuvalu</option>
                          <option >Uganda</option>
                          <option >Ukraine</option>
                          <option >United Arab Emirates</option>
                          <option >United Kingdom</option>
                          <option >United States</option>
                          <option >United States Minor Outlying Islands</option>
                          <option >Uruguay</option>
                          <option >Uzbekistan</option>
                          <option >Vanuatu</option>
                          <option>Vatican City</option>
                          <option >Venezuela</option>
                          <option >Viet Nam</option>
                          <option >Virgin Islands, British</option>
                          <option >Virgin Islands, U.s.</option>
                          <option >Wallis and Futuna</option>
                          <option >Western Sahara</option>
                          <option >Yemen</option>
                          <option >Zambia</option>
                          <option >Zimbabwe</option>
                      </select>
					  <span class="help-block"><?php echo $country_err; ?></span>
          </div>
		  <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password1" placeholder="Password" value="<?php echo $password1; ?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
			<span class="help-block"><?php echo $password1_err; ?></span>
          </div>
		  <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password2" placeholder="Password" value="<?php echo $password2; ?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
			<span class="help-block"><?php echo $password2_err; ?></span>
          </div>
          <div class="form-group has-feedback">
            <select name="plan" class="form-control">
                <option value="">Select prefered plan</option>
                <option value="1">Default</option>
                <option value="2">Compounding</option>
            </select>
			<span class="help-block"><?php echo $plan_err; ?></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Send
              </button>
            </div><!-- /.col -->
          </div>
        </form>
        <a href="login.php" class="text-center">I already have a login key</a>
      </div><!-- /.form-box -->
      <div class="lockscreen-footer text-center">
        Copyright &copy; 2019 <b><a>Laxiom Investments</a></b><br>
        All rights reserved
      </div>
    </div><!-- /.register-box -->
<div id="path" data-app-name="Laxiom" data-path="index.php" data-css-path="index.phppublic/css/" data-js-path="index.phppublic/js/"></div>
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
		<script type="text/javascript" src="index.phppublic/plugins/iCheck/icheck.min.js"></script>
		
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


