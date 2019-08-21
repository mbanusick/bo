
<?php
// Include config file
require_once "conn.php";
// Define variables and initialize with empty values "password1""password2""type""btc_wallet""phone""country""email""lastname"firstname
$username = $password1 = $password2 = $type = $btc_wallet = $phone = $country = $email = $fullname = "";
$username_err = $fullname_err = $email_err = $password1_err = $password2_err = "";

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
    if(empty($username_err) && empty($email_err) && empty($fullname_err) && empty($password1_err) && empty($password2_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, fullname, email) VALUES (:username, :password, :fullname, :email)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
			$stmt->bindParam(":fullname", $param_fullname, PDO::PARAM_STR);
           	$stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
			$param_password = password_hash($password1, PASSWORD_DEFAULT); // Creates a password hash
			$param_fullname = $fullname;
			$param_email = $email;
            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
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
          <div class="form-group has-feedback">
          <select name="country"> 
            <option>Select your country</option>
                          <option value="1">Afghanistan</option>
                          <option value="242">Aland Islands</option>
                          <option value="2">Albania</option>
                          <option value="3">Algeria</option>
                          <option value="4">American Samoa</option>
                          <option value="5">Andorra</option>
                          <option value="6">Angola</option>
                          <option value="7">Anguilla</option>
                          <option value="8">Antarctica</option>
                          <option value="9">Antigua and Barbuda</option>
                          <option value="10">Argentina</option>
                          <option value="11">Armenia</option>
                          <option value="12">Aruba</option>
                          <option value="240">Asia / Pacific Region</option>
                          <option value="13">Australia</option>
                          <option value="14">Austria</option>
                          <option value="15">Azerbaijan</option>
                          <option value="16">Bahamas</option>
                          <option value="17">Bahrain</option>
                          <option value="18">Bangladesh</option>
                          <option value="19">Barbados</option>
                          <option value="20">Belarus</option>
                          <option value="21">Belgium</option>
                          <option value="22">Belize</option>
                          <option value="23">Benin</option>
                          <option value="24">Bermuda</option>
                          <option value="25">Bhutan</option>
                          <option value="26">Bolivia</option>
                          <option value="243">Bonaire, Sint Eustatius and Saba</option>
                          <option value="27">Bosnia and Herzegovina</option>
                          <option value="28">Botswana</option>
                          <option value="29">Bouvet Island</option>
                          <option value="30">Brazil</option>
                          <option value="31">British Indian Ocean Territory</option>
                          <option value="32">Brunei Darussalam</option>
                          <option value="33">Bulgaria</option>
                          <option value="34">Burkina Faso</option>
                          <option value="35">Burundi</option>
                          <option value="36">Cambodia</option>
                          <option value="37">Cameroon</option>
                          <option value="38">Canada</option>
                          <option value="39">Cape Verde</option>
                          <option value="40">Cayman Islands</option>
                          <option value="41">Central African Republic</option>
                          <option value="42">Chad</option>
                          <option value="43">Chile</option>
                          <option value="44">China</option>
                          <option value="45">Christmas Island</option>
                          <option value="46">Cocos (Keeling) Islands</option>
                          <option value="47">Colombia</option>
                          <option value="48">Comoros</option>
                          <option value="49">Congo</option>
                          <option value="50">Congo, the Democratic Republic of the</option>
                          <option value="51">Cook Islands</option>
                          <option value="52">Costa Rica</option>
                          <option value="53">Cote D'Ivoire</option>
                          <option value="54">Croatia</option>
                          <option value="55">Cuba</option>
                          <option value="244">Curacao</option>
                          <option value="56">Cyprus</option>
                          <option value="57">Czech Republic</option>
                          <option value="58">Denmark</option>
                          <option value="59">Djibouti</option>
                          <option value="60">Dominica</option>
                          <option value="61">Dominican Republic</option>
                          <option value="62">Ecuador</option>
                          <option value="63">Egypt</option>
                          <option value="64">El Salvador</option>
                          <option value="65">Equatorial Guinea</option>
                          <option value="66">Eritrea</option>
                          <option value="67">Estonia</option>
                          <option value="68">Ethiopia</option>
                          <option value="69">Falkland Islands (Malvinas)</option>
                          <option value="70">Faroe Islands</option>
                          <option value="71">Fiji</option>
                          <option value="72">Finland</option>
                          <option value="73">France</option>
                          <option value="74">French Guiana</option>
                          <option value="75">French Polynesia</option>
                          <option value="76">French Southern Territories</option>
                          <option value="77">Gabon</option>
                          <option value="78">Gambia</option>
                          <option value="79">Georgia</option>
                          <option value="80">Germany</option>
                          <option value="81">Ghana</option>
                          <option value="82">Gibraltar</option>
                          <option value="83">Greece</option>
                          <option value="84">Greenland</option>
                          <option value="85">Grenada</option>
                          <option value="86">Guadeloupe</option>
                          <option value="87">Guam</option>
                          <option value="88">Guatemala</option>
                          <option value="245">Guernsey</option>
                          <option value="89">Guinea</option>
                          <option value="90">Guinea-Bissau</option>
                          <option value="91">Guyana</option>
                          <option value="92">Haiti</option>
                          <option value="93">Heard Island and Mcdonald Islands</option>
                          <option value="95">Honduras</option>
                          <option value="96">Hong Kong</option>
                          <option value="97">Hungary</option>
                          <option value="98">Iceland</option>
                          <option value="99">India</option>
                          <option value="100">Indonesia</option>
                          <option value="101">Iran, Islamic Republic of</option>
                          <option value="102">Iraq</option>
                          <option value="103">Ireland</option>
                          <option value="246">Isle of Man</option>
                          <option value="104">Israel</option>
                          <option value="105">Italy</option>
                          <option value="106">Jamaica</option>
                          <option value="107">Japan</option>
                          <option value="247">Jersey</option>
                          <option value="108">Jordan</option>
                          <option value="109">Kazakhstan</option>
                          <option value="110">Kenya</option>
                          <option value="111">Kiribati</option>
                          <option value="112">Korea, Democratic People's Republic of</option>
                          <option value="113">Korea, Republic of</option>
                          <option value="248">Kosovo</option>
                          <option value="114">Kuwait</option>
                          <option value="115">Kyrgyzstan</option>
                          <option value="116">Lao People's Democratic Republic</option>
                          <option value="117">Latvia</option>
                          <option value="118">Lebanon</option>
                          <option value="119">Lesotho</option>
                          <option value="120">Liberia</option>
                          <option value="121">Libyan Arab Jamahiriya</option>
                          <option value="122">Liechtenstein</option>
                          <option value="123">Lithuania</option>
                          <option value="124">Luxembourg</option>
                          <option value="125">Macao</option>
                          <option value="126">Macedonia, the Former Yugoslav Republic of</option>
                          <option value="127">Madagascar</option>
                          <option value="128">Malawi</option>
                          <option value="129">Malaysia</option>
                          <option value="130">Maldives</option>
                          <option value="131">Mali</option>
                          <option value="132">Malta</option>
                          <option value="133">Marshall Islands</option>
                          <option value="134">Martinique</option>
                          <option value="135">Mauritania</option>
                          <option value="136">Mauritius</option>
                          <option value="137">Mayotte</option>
                          <option value="138">Mexico</option>
                          <option value="139">Micronesia, Federated States of</option>
                          <option value="140">Moldova, Republic of</option>
                          <option value="141">Monaco</option>
                          <option value="142">Mongolia</option>
                          <option value="241">Montenegro</option>
                          <option value="143">Montserrat</option>
                          <option value="144">Morocco</option>
                          <option value="145">Mozambique</option>
                          <option value="146">Myanmar</option>
                          <option value="147">Namibia</option>
                          <option value="148">Nauru</option>
                          <option value="149">Nepal</option>
                          <option value="150">Netherlands</option>
                          <option value="151">Netherlands Antilles</option>
                          <option value="152">New Caledonia</option>
                          <option value="153">New Zealand</option>
                          <option value="154">Nicaragua</option>
                          <option value="155">Niger</option>
                          <option value="156">Nigeria</option>
                          <option value="157">Niue</option>
                          <option value="158">Norfolk Island</option>
                          <option value="159">Northern Mariana Islands</option>
                          <option value="160">Norway</option>
                          <option value="161">Oman</option>
                          <option value="162">Pakistan</option>
                          <option value="163">Palau</option>
                          <option value="164">Palestinian</option>
                          <option value="165">Panama</option>
                          <option value="166">Papua New Guinea</option>
                          <option value="167">Paraguay</option>
                          <option value="168">Peru</option>
                          <option value="169">Philippines</option>
                          <option value="170">Pitcairn</option>
                          <option value="171">Poland</option>
                          <option value="172">Portugal</option>
                          <option value="173">Puerto Rico</option>
                          <option value="174">Qatar</option>
                          <option value="175">Reunion</option>
                          <option value="176">Romania</option>
                          <option value="177">Russian Federation</option>
                          <option value="178">Rwanda</option>
                          <option value="249">Saint Barthelemy</option>
                          <option value="179">Saint Helena</option>
                          <option value="180">Saint Kitts and Nevis</option>
                          <option value="181">Saint Lucia</option>
                          <option value="250">Saint Martin</option>
                          <option value="182">Saint Pierre and Miquelon</option>
                          <option value="183">Saint Vincent and the Grenadines</option>
                          <option value="184">Samoa</option>
                          <option value="185">San Marino</option>
                          <option value="186">Sao Tome and Principe</option>
                          <option value="187">Saudi Arabia</option>
                          <option value="188">Senegal</option>
                          <option value="239">Serbia</option>
                          <option value="189">Seychelles</option>
                          <option value="190">Sierra Leone</option>
                          <option value="191">Singapore</option>
                          <option value="251">Sint Maarten</option>
                          <option value="192">Slovakia</option>
                          <option value="193">Slovenia</option>
                          <option value="194">Solomon Islands</option>
                          <option value="195">Somalia</option>
                          <option value="196">South Africa</option>
                          <option value="197">South Georgia and the South Sandwich Islands</option>
                          <option value="252">South Sudan</option>
                          <option value="198">Spain</option>
                          <option value="199">Sri Lanka</option>
                          <option value="200">Sudan</option>
                          <option value="201">Suriname</option>
                          <option value="202">Svalbard and Jan Mayen</option>
                          <option value="203">Swaziland</option>
                          <option value="204">Sweden</option>
                          <option value="205">Switzerland</option>
                          <option value="206">Syrian Arab Republic</option>
                          <option value="207">Taiwan, Province of China</option>
                          <option value="208">Tajikistan</option>
                          <option value="209">Tanzania, United Republic of</option>
                          <option value="210">Thailand</option>
                          <option value="211">Timor-Leste</option>
                          <option value="212">Togo</option>
                          <option value="213">Tokelau</option>
                          <option value="214">Tonga</option>
                          <option value="215">Trinidad and Tobago</option>
                          <option value="216">Tunisia</option>
                          <option value="217">Turkey</option>
                          <option value="218">Turkmenistan</option>
                          <option value="219">Turks and Caicos Islands</option>
                          <option value="220">Tuvalu</option>
                          <option value="221">Uganda</option>
                          <option value="222">Ukraine</option>
                          <option value="223">United Arab Emirates</option>
                          <option value="224">United Kingdom</option>
                          <option value="225">United States</option>
                          <option value="226">United States Minor Outlying Islands</option>
                          <option value="227">Uruguay</option>
                          <option value="228">Uzbekistan</option>
                          <option value="229">Vanuatu</option>
                          <option value="94">Vatican City</option>
                          <option value="230">Venezuela</option>
                          <option value="231">Viet Nam</option>
                          <option value="232">Virgin Islands, British</option>
                          <option value="233">Virgin Islands, U.s.</option>
                          <option value="234">Wallis and Futuna</option>
                          <option value="235">Western Sahara</option>
                          <option value="236">Yemen</option>
                          <option value="237">Zambia</option>
                          <option value="238">Zimbabwe</option>
                      </select>
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
          <div class="row">
            <div class="col-xs-8">
              
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Send
              </button>
            </div><!-- /.col -->
          </div>
        </form>
        <a href="https://primustrades.net/Login" class="text-center">I already have a login key</a>
      </div><!-- /.form-box -->
      <div class="lockscreen-footer text-center">
        Copyright &copy; 2019 <b><a>Primustrades</a></b><br>
        All rights reserved
      </div>
    </div><!-- /.register-box -->
<div id="path" data-app-name="Primustrades" data-path="https://primustrades.net/" data-css-path="https://primustrades.net/public/css/" data-js-path="https://primustrades.net/public/js/"></div>
<footer>
	
	<script src="https://primustrades.net/public/js/lib/jquery-3.0.0.min.js"></script>
	<script src="https://primustrades.net/public/js/lib/jquery-qrcode-0.14.0.min.js"></script>
	<script src="https://primustrades.net/public/js/app.js"></script>
	<!-- <script src="https://primustrades.net/public/plugins/jQuery/jQuery-2.1.4.min.js"></script> -->
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
			<script type="text/javascript" src="https://primustrades.net/public/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://primustrades.net/public/plugins/iCheck/icheck.min.js"></script>
		
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


