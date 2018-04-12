<?php
include "auth.php";
$depot_mgr_name = sanitizeString($_POST['depot_mgr_name']);
$password = md5(sanitizeString($_POST['password']));
//$password2 = md5($password2. 'avalon' . $mgr_name);
		
$checklogin = selectMysql($pdo, "SELECT * FROM manager WHERE name = '".$depot_mgr_name."' AND password = '".$password."'");
if($checklogin->rowCount() == 1)
{
$row =$checklogin->fetch(PDO::FETCH_ASSOC);
$depot_mgr_name = $row['name'];
$_SESSION['depot_mgr_name'] = $row['name'];
$_SESSION['mgr_id'] = $row['mgr_id'];
$_SESSION['state_managed'] = $row['state'];
$_SESSION['LoggedInMgr'] = 1;
echo "<h1>Success</h1>";
echo "<p>redirecting...</p;>";
echo "<script>
  location.href = 'depotmgr.php';
</script>";
echo 'click <a href="depotmgr.php">here </a>if you are not automatically redirected.';
}else{
	echo'Name or password incorrect';
	echo "<p>redirecting you to the login page</p;>";
echo "<script>
  location.href = 'index.php';
</script>";
}
?>