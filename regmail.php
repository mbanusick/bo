<?php
$to = "$email";
$subject = "Registration Successful";

$message = "
<html>
<head>
<title>Laxiom Investment Registration</title>
</head>
<body>
<p>Hello <b>$username,</b></p>
<p>Thank you for registering on our platform!</p>
<p>Below are some of your details:</p>

<b>Fullname:</b> $fullname
</br>
<b>Username:</b> $username

<p>You can <a href=\"https://www.laxiominvestment.com/login.php\">Login</a> right away and start investing</p>
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