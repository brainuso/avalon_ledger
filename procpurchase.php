<?php
include "auth.php";
$distributor_id= sanitizeString($_POST['distributor_id']);
$amount = sanitizeString($_POST['amount']);
$date = dater(sanitizeString($_POST['date']));
$trans_id = random(5);
//If the inputted purchase amount makes the ledger balance  to exceed  --#50,000,  prompt error message: “credit limit exceeded”
$trans_query=selectMysql($pdo, "SELECT * FROM transaction WHERE distributor_id='".$distributor_id."'");
		$this_balance=0;
		$credit=0;
		$balance=0;
		while($row=$trans_query->fetch(PDO::FETCH_ASSOC)){
			$this_balance=$row['credit']-$row['debit'];
			$balance=$balance+$this_balance;
		}
		$credit_lim=$balance-$amount;
		if($credit_lim<-50000){
		echo "<h2>Credit Limit Exceeded</h2>";
	}else{
		$query=queryMysql($pdo, "INSERT INTO transaction (date, transaction_id, debit, distributor_id) VALUES ('".$date."','".$trans_id."','".$amount."','".$distributor_id."')");
		echo "<h1>Transaction details entered successfully</h1>";
	}

sleep (10);
echo "<p>Redirecting...</p;>";
echo "<script>
  location.href = 'singledist.php?id=".$distributor_id."';
</script>";
?>