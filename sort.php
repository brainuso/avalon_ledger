<?php //subcat.php ajax correspondence
include 'auth.php';

$q = sanitizeString($_GET['q']);

if ($q == "all states"){
	$query=selectMysql($pdo, "SELECT * FROM manager ORDER BY state");
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			
				 echo'
                <a href="mgrledger.php?manager='.$row['name'].'" class="list-group-item">
                  '.$row['name'].'<span class="badge">'.$row['state'].'</span>  
                </a>';
			 }
} else{


$ql = selectMysql($pdo, "SELECT * FROM manager WHERE state='".$q."'");
 
 
	   
		while($row=$ql->fetch(PDO::FETCH_ASSOC)){
				 echo'
                <a href="mgrledger.php?manager='.$row['name'].'" class="list-group-item">
                  '.$row['name'].'<span class="badge">'.$row['state'].'</span>  
                </a>';
			 }
}
?>