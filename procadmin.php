<?php
include "auth.php";
$adm_name = sanitizeString($_POST['adm_name']);
$password = md5(sanitizeString($_POST['password']));
$checklogin = selectMysql($pdo, "SELECT * FROM admin WHERE name = '".$adm_name."' AND password = '".$password."'");
if($checklogin->rowCount() == 1)
{
$row = $checklogin->fetch(PDO::FETCH_ASSOC);
$_SESSION['adm_name'] = $row['name'];
$_SESSION['LoggedInAdm'] = 1;
echo "<h1>Success</h1>";
echo "<p>Redirecting...</p;>";
echo "<script>
  location.href = 'admin.php';
</script>";
echo 'click <a href="admin.php">here </a>if you are not automatically redirected.';
}else{
	echo'Name or password incorrect';
	echo "<p>redirecting you to the login page</p;>";
echo "<script>
  location.href = 'index.php';
</script>";
}
?>