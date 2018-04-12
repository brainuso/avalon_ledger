<?php include '../includes/function.php';


	$locsql = selectMysql($pdo, "SELECT id, name FROM location ORDER BY name");
	echo '<option>Select Location</option>';
	
	while($row = $locsql->fetch(PDO::FETCH_NUM)){
	 $locationID = $row[0];
	 $locationName = $row[1];
echo "<option value=". $locationID.">". $locationName."</option>";
}


?>
