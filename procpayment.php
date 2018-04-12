<?php
include "auth.php";
$distributor_id= sanitizeString($_POST['distributor_id']);
$amount = sanitizeString($_POST['amount']);
$date = dater(sanitizeString($_POST['date']));
$bank = sanitizeString($_POST['bank']);
$teller_num = sanitizeString($_POST['teller_num']);
$trans_id = random(5);
$query=queryMysql($pdo, "INSERT INTO transaction (date, transaction_id, credit, bank, teller_num, distributor_id) VALUES ('".$date."','".$trans_id."','".$amount."','".$bank."','".$teller_num."','".$distributor_id."')") or die("Invalid query: ".mysql_error());;
echo "<h1>Transaction details entered successfully</h1>";
sleep (3);
echo "<p>Redirecting...</p;>";
echo "<script>
  location.href = 'singledist.php?id=".$distributor_id."';
</script>";
?>