<?php //payment.php ajax correspondence
include 'auth.php';

$customer = sanitizeString($_GET['customer']);
$type = sanitizeString($_GET['type']);

if ($customer == "returning"){
	
	$query=selectMysql($pdo, "SELECT * FROM customer WHERE mgr_id ='".$_SESSION['mgr_id']."' AND customer_type='".$type."'");
		 echo'<select id="" name="customer_name"  class="form-control">';
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			echo'<option value="'.$row['customer_id'].'">'.$row['name'].'</option>';
		}
			 echo '</select>';
}
 else{
 echo '';
}
?>