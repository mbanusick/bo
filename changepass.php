<?php


// Initialize the session
// Include config file
require_once "conn.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}



?>


<?php if(isset($_GET["email"]) && isset($_GET["code"])): ?>

<?php 


$email = trim($_GET["email"]);
$code = trim($_GET["code"]);

// Veryfiy validity of email and code
$sql = "SELECT email FROM users WHERE recovery = '$code'";




// // Validate password
// if(isset($_POST["password1"])){
//    if(empty(trim($_POST["password1"]))){
//        $password1_err = "Please enter a password.";     
//    } elseif(strlen(trim($_POST["password1"])) < 6){
//        $password1_err = "Password must have atleast 6 characters.";
//    } else{
//        $password1 = trim($_POST["password1"]);
//    }
// }
// // Validate confirm password
// if(isset($_POST["password2"])){
//    if(empty(trim($_POST["password2"]))){
//        $password2_err = "Please confirm password.";     
//    } else{
//        $password2 = trim($_POST["password2"]);
//        if(empty($password1_err) && ($password1 != $password2)){
//            $password2_err = "Passwords did not match.";
//        }
//    }
// }


?>



<?php endif ?>