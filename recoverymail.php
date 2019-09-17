<?php
$to = "$email";
$subject = "Reset Your Password";

$message = "
<html>
<head>
<title>Laxiom Investment Password Reset</title>
</head>
<body>
<p>Hello <b>$username,</b></p>
<p>You are receiving this mail because you requested for password reset for your</p>
<p>Laxiom Investment Account, please click on the link below to change your password.</p>


<p><a href=\"https://www.laxiominvestment.com/changepass.php?email=$email?code=$code\">https://www.laxiominvestment.com/changepass.php?email=$email?code=$code</a></p>
</br>
<p><i>Laxiom Investment</i></br>
<i>Team</i></p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: Laxiom Investment <support@laxiominvestment.com>' . "\r\n";


mail($to,$subject,$message,$headers);
?>