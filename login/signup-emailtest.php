<?php // signup.php
include '../includes/function.php';
require '../includes/PHPMailer/PHPMailerAutoload.php';
$username = $email = $password = $password2 = $location = $confirm_code = $accept = ' ';
//cleaning data

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$username = sanitizeString(($_POST['username']));
	$email = sanitizeString(($_POST['email']));
	$password= sanitizeString(($_POST['password']));
	$password2= sanitizeString(($_POST['password2']));
	$location = sanitizeString(($_POST['location']));
	
	if (isset($_POST['accept']) && $_POST['accept'] =="1"){
		$accept =  sanitizeString($_POST['accept']);
		//username validation
		if ($username ==""){
			$user_error = "Please enter username";
		}
		if(strlen($username) < 5){
			$user_error = "Username must be 6 characters and above";
		}
		if (preg_match("/[^a-zA-Z0-9_-]/",$username)){
			$user_error = "Only letters, numbers, - and _ in usernames";
		}
		//duplicate username check
		if (selectMysql($pdo, "SELECT * FROM temp_user WHERE username='$username'")->rowCount() == 1||
		selectMysql($pdo, "SELECT * FROM user_biodata WHERE username='$username'")->rowCount() == 1){
				$user_error =  "Oops, username already in use, Please use another name.";
		} 
		
		//email validation
		if ($email == ""){
			$email_error = "Please enter Email";
		}
			//email string matching
		if (!((strpos($email, ".") > 0) &&(strpos($email, "@") > 0))|| preg_match("/[^a-zA-Z0-9.@_-]/", $email)){
			$email_error  = "The Email address is invalid";
		}
		//duplicate email check
		if (selectMysql($pdo, "SELECT * FROM temp_user WHERE email='$email'")->rowCount() == 1||
		selectMysql($pdo, "SELECT * FROM user_biodata WHERE email='$email'")->rowCount() == 1){
				$email_error =  "Oops, email already in use, Please use another name.";
		} 
			//duplicate email checking
		if(selectMysql($pdo, "SELECT * FROM temp_user WHERE email='$email'")->rowCount() == 1||selectMysql($pdo, "SELECT * FROM user_biodata WHERE  email='$email'")->rowCount() == 1){
			$email_error  =  "Oops, email already in use. Please enter another.";
		}
		
		//password validation
		if ($password ==""){
			$password_error = "No Password was entered";
		}
			//password count
		if (strlen($password) < 6){
				$password_error = "Passwords must be at least 6 characters";
		}
			//password string matching 
		if ( !preg_match("/[^a-zA-Z]/", $password) || !preg_match("/[0-9]/", $password)){
				$password_error = "Passwords require alphanumeric characters";
		}
		
		//password2 validation
		if ($password2 ==""){
			$password2_error = "No Password was entered";
		}
			//password2 count
		if (strlen($password2) < 6){
			$password2_error = "Passwords must be at least 6 characters";
		}
			//password2 string matching 
		if ( !preg_match("/[a-zA-Z]/", $password2) || !preg_match("/[0-9]/", $password2)){
			$password2_error = "Passwords require alphanumeric characters";
		}
		//password 1 & 2 matching
		if($password !== $password2){ 
			$password2_error =  "Passwords do not match";	
		}
								
		//location check
		if($location == "" || $location == "Select Location"){
			$loc_error = "Please Select a location";
		}
		//error checking
		if(isset($user_error) || isset($email_error) || isset($password_error) || isset($password2_error)
			|| isset($loc_error) ){
			include 'signup.html';
			exit();
		}
		else{
		//generate unique confirmation code
			$confirm_code=md5(uniqid($password2));
		//location query
		$q = selectMysql($pdo, "SELECT name FROM location WHERE id =".$location."");
		$location = $q->fetchColumn();
		//password hashing 
		$password = md5($password. 'myskilldomain' . $username);
										
										$user_id = random(32);
										//data input
										$input = queryMysql($pdo, "INSERT INTO temp_user SET userid='$user_id', username='".$username."', email='".$email."', password='".$password."', location='".$location."', confirm_code='".$confirm_code."'");
											if ($input == TRUE){
		$body_html ='
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->
  <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->
 
  <link rel="stylesheet" type="text/css" href="http://'.$site_url.'/css/bootstrap.css" media="screen"> 
		<link rel="stylesheet" type="text/css" href="http://'.$site_url.'/css/home.css">
  <title>MSD Account Verification</title>
  
  <style type="text/css">
body {
  margin: 0;
  padding: 0;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
}

table {
  border-spacing: 0;
}

table td {
  border-collapse: collapse;
}

.ExternalClass {
  width: 100%;
}

.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
  line-height: 100%;
}

.ReadMsgBody {
  width: 100%;
  background-color: #ebebeb;
}

table {
  mso-table-lspace: 0pt;
  mso-table-rspace: 0pt;
}

img {
  -ms-interpolation-mode: bicubic;
}

.yshortcuts a {
  border-bottom: none !important;
}

@media screen and (max-width: 599px) {
  .force-row,
  .container {
    width: 100% !important;
    max-width: 100% !important;
  }
}
@media screen and (max-width: 400px) {
  .container-padding {
    padding-left: 12px !important;
    padding-right: 12px !important;
  }
}
.ios-footer a {
  color: #aaaaaa !important;
  text-decoration: underline;
}
</style>
</head>

<body style="margin:0; padding:0;" bgcolor="#F0F0F0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!-- 100% background wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
  <tr>
    <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">

      <br>

      <!-- 600px container (white background) -->
      <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px">
        <tr>
          <td class="container-padding header" align="left" style="font-size:24px;font-weight:bold;padding-bottom:12px;color:#2096ba;padding-left:24px;padding-right:24px">
        MySkillDomain
		<img class="thumbnail pull-right" src="" alt="MySkillDomain"/>
          </td>
        </tr>
        <tr>
          <td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff">
            <br>

<h4 class="title" style="font-weight:600;color:#374550">MSD Account Verification</h4>
<br>

<div class="body-text" style="line-height:20px;text-align:left;color:#333333">
<p>Hello '.$username.',<br>
 Your sign up was a <strong>Success!</strong><br> There\'s just this one more thing to do. Kindly click on the button below to verify your account. 
  </p>
<p><a href="http://'.$site_url.'/users/profile/confirmation.php?passkey='.$confirm_code.'" class="btn btn-success">Verify Account</a> </p>
<p>OR Click on the link below<br><a href="http://'.$site_url.'/users/profile/confirmation.php?passkey='.$confirm_code.'">http://'.$site_url.'/users/profile/confirmation.php?passkey='.$confirm_code.'</a> </p>

  <p>If you did not sign up on <strong><a href="http://'.$site_url.'"> MySkillDomain</a></strong>, please ignore this email. We will remove your details from our server but we think you should atleast have a look at what we do.</p>
 
 <p>Signed<br> <span class="bold-italics">Adeleye Okhae</span></p>

  </div>

          </td>
        </tr>
        <tr>
          <td class="container-padding footer-text" align="left" style="line-height:16px;color:#aaaaaa;padding-left:24px;padding-right:24px">
         

            You are receiving this email because you opted in on our website. 
            <br><br>

            © 2016<strong><a href="http://'.$site_url.'"> MySkillDomain</a></strong><br>
            <!--<span class="ios-footer">
            </span>-->
           
            <br><br>

          </td>
        </tr>
      </table>
<!--/600px container -->


    </td>
  </tr>
</table>
<!--/100% background wrapper-->

</body>
</html>
';
												
												
							$body = '**MSD ACCOUNT VERIFICATION**
===================================================

Hello '.$username.'
Your sign up was a SUCCESS! There\'s just this one more thing to do. Kindly click on the link below to verify your account. 
http://'.$site_url.'/users/profile/confirmation.php?passkey='.$confirm_code.'

If you did not sign up on MYSKILLDOMAIN, please ignore this email. We will remove your details from our server but we think you should atleast have a look at what we do.
 
 Signed
 Adeleye Okhae
 
 -------------------------------------------------------
 
  © 2016 MySkillDomain';
												
											//echo $body;
											
											
												$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'secure181.sgcpanel.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'support@myskilldomain.com';                 // SMTP username
$mail->Password = 'wesupport1';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('support@myskilldomain.com', 'MSD Support');
$mail->addAddress($email, $username);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('support@myskilldomain.com', 'MSD Support');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'MSD Account Verification';
$mail->Body    = $body_html;
$mail->AltBody = $body;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}			
											}
											else echo "insertion failed";
		}
	}
	else{
		$acc_error = 'Please read the Terms and Conditions and tick the box.';
		include 'signup.html';
		exit();
	}
}
?>