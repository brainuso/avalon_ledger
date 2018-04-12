<?php
//reset-password.php
include  '../includes/function.php';
require_once  '../includes/PHPMailer/PHPMailerAutoload.php';

$email="";
$pass_code = random(32);
if ($_SERVER['REQUEST_METHOD']== "POST"){
	$_SESSION['pass_code'] = $pass_code;
$email = sanitizeString($_POST['email']);


$q = selectMysql($pdo, "SELECT username FROM user_biodata WHERE email ='".$email."'");

if($q->rowCount() == 0){
	$w =  selectMysql($pdo, "SELECT username FROM temp_user WHERE email ='".$email."'");
		if($w->rowCount() == 0){
			$user_error = '<p class="text-danger fa fa-times">Incorrect email, please verify.</p>';
			include 'reset-password.html';
			exit();
		}
		else{
			$_SESSION['username'] = $w->fetchColumn();
			$tbl_name = "temp_user";
		}
}
else{
	$_SESSION['username'] = $q->fetchColumn();
	$tbl_name = "user_biodata";
}

$_SESSION['tbl_name'] = $tbl_name;
$username = $_SESSION['username'];
$body ='
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

<h4 class="title" style="font-weight:600;color:#374550">Reset your MSD password</h4>
<br>

<div class="body-text" style="line-height:20px;text-align:left;color:#333333">
<p>Hello '.$username.',<br>
Click on the button below to reset your password<br>
 <a class="btn btn-success" href="http://'.$site_url.'/login/reset2.php?token='.$pass_code.'">Reset Password</a> </p>
<p> OR Click on the link below<br><a href="http://'.$site_url.'/login/reset2.php?token='.$pass_code.'">http://'.$site_url.'/login/reset2.php?token='.$pass_code.'</a> </p>

  <p>If you did not request a password reset on <strong><a href="http://'.$site_url.'"> MySkillDomain</a></strong>, please ignore this email.</p>
 
 <p>Signed<br> <span id="bold-italics">Adeleye Okhae</span></p>

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

echo $body;


}

?>