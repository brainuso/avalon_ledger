<?php //subcat.php ajax correspondence
include 'auth.php';

if(!empty($_GET['q'])){
	$q = sanitizeString($_GET['q']);

	if($q == ""){
	echo'';
	}
	else{

$ql = selectMysql($pdo, "SELECT price FROM inventory WHERE product_id='".$q."'
 AND mgr_id='".$_SESSION['mgr_id']."'");
 $row=$ql->fetch(PDO::FETCH_ASSOC);
		 echo' <label class="control-label" for="" >Price</label>
		  <div class="input-group"> 
              <span class="input-group-addon">&#8358;</span>	
                <input type="text" disabled class="form-control" name="price" id="price" placeholder="Price" value="'.$row['price'].'"/> 
		   </div>';
	}
} 
elseif(!empty($_GET['paint'])){
	$product_id = sanitizeString($_GET['paint']);
	$price = sanitizeString($_GET['price']);
	$qty = sanitizeString($_GET['qty']);
	$total = sanitizeString($_GET['total']);
	if(!empty($_GET['coupon'])){
		$coupon = sanitizeString($_GET['coupon']);
		$discount = sanitizeString($_GET['discount']);
	}else{
		$coupon =0;
		$discount =0;
	}
		$sql= queryMysql($pdo, "INSERT INTO temp_purchase SET mgr_id='".$_SESSION['mgr_id']."', 
		product_id='".$product_id."', qty='".$qty."', coupon_code='".$coupon."', discount='".$discount."', price='".$price."', total='".$total."'");
	
	
	if($sql){
		$query = selectMysql($pdo, "SELECT * FROM temp_purchase WHERE mgr_id='".$_SESSION['mgr_id']."'");
		$i = 1;
		$sum=0;
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			$r= selectMysql($pdo, "SELECT name FROM product WHERE product_id='".$row['product_id']."'");
				$list=$r->fetch(PDO::FETCH_ASSOC);
						echo '<tr>
									<td>'.$i.'</td> 
                                    <td>'.$list['name'].'</td> 
                                    <td>'.$row['price'].'</td>
                                    <td>'.$row['qty'].'</td>
                                    <td>'.$row['discount'].'</td>
                                    <td>&#8358;'.$row['total'].'</td>
                                    <td><button onClick="deletePurchase(this.value)" id="delete" class="fa fa-times-circle" 
									name="action" value="'.$row['product_id'].'"></button></td> 
								</tr>
							';
			$i++;
			$sum +=$row['total'];
		}
		echo '<tr><td></td><td></td><td></td><td></td><td>TOTAL:</td><td><strong> &#8358;'.$sum.'</strong></td></tr>';
		
	}
	else echo "Failed entry please retry";
	
}
else if(!empty($_GET['coupon_code'])){
	$coupon = sanitizeString($_GET['coupon_code']);
	
	$q= selectMysql($pdo, "SELECT * FROM coupon WHERE coupon_code='".$coupon."'");
	$row= $q->fetch(PDO::FETCH_ASSOC);
	if($row['status']=='ACTIVE'){
	echo $row['value'];
	}
	else{ 
	//$coupon_error='coupon is expired'; 
	echo "0";
	return;
	}
	
}
		  
else if(!empty($_GET['delete'])){
	$del = sanitizeString($_GET['delete']);
	$sql = queryMysql($pdo, "DELETE FROM temp_purchase WHERE product_id='".$del."' AND mgr_id='".$_SESSION['mgr_id']."'");
	
	if($sql){
		$query = selectMysql($pdo, "SELECT * FROM temp_purchase WHERE mgr_id='".$_SESSION['mgr_id']."'");
		$i = 1;
		$sum=0;
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			$r= selectMysql($pdo, "SELECT name FROM product WHERE product_id='".$row['product_id']."'");
				$list=$r->fetch(PDO::FETCH_ASSOC);
						echo '<tr>
									<td>'.$i.'</td> 
                                    <td>'.$list['name'].'</td> 
                                    <td>'.$row['price'].'</td>
                                    <td>'.$row['qty'].'</td>
                                    <td>'.$row['discount'].'</td>
                                    <td>&#8358;'.$row['total'].'</td>
                                    <td><button onClick="deletePurchase(this.value)" id="delete" class="fa fa-times-circle" 
									name="action" value="'.$row['product_id'].'"></button></td>
                                    
								</tr>
							';
			$i++;
			$sum +=$row['total'];
		}
		echo '<tr><td></td><td></td><td></td><td></td><td>TOTAL:</td><td><strong> &#8358;'.$sum.'</strong></td></tr>';
		
	}
}
	?>