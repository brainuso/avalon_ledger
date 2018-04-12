<?php
include '../includes/function.php'; 
 
$name = $password = " ";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$name = sanitizeString($_POST['username']);
$password = sanitizeString($_POST['password']);
 //print_r($_POST);
 
 
 	if ($name  ==  "" || $password == ""){
		$master_error= "Please fill in the fields appropriately.<br/>";
		include "login.html";
		exit();
	}
	else{
		
		login($pdo, $name, $password);
	}

}

function login($pdo, $name, $password){

	try{
	
	if (((strpos($name, ".") > 0) &&(strpos($name, "@") > 0))
	|| preg_match("/[^a-zA-Z0-9.@_-]/", $name)){
		
		
		$email_query1 = selectMysql($pdo, "SELECT * FROM user_biodata WHERE email='".$name."'");
			
			if($email_query1->rowCount() == 0){
				
				$email_query2 =  selectMysql($pdo, "SELECT * FROM temp_user WHERE email= '".$name."'");
					
					if ($email_query2->rowCount() == 0){
						$user_error = '<p class="text-danger fa fa-times"><strong> User details not found</strong></p>'; //username is incorrect
						
						include('login.html');
						exit();
					}else{
						while ($row = $email_query2->fetch(PDO::FETCH_NUM)){
							$id =  $row[1];
							$name= $row[2];
							$email = $row[3];
							$pass = $row[4];
							$location = $row[5];
							
						}
						$password = md5($password. 'myskilldomain'.$name);
						temppass($id, $name, $pass, $password, $email,$location);
					}
			}
			else{
				while ($row = $email_query1->fetch(PDO::FETCH_NUM)){
					$id =  $row[1];
					$name= $row[2];
					$email = $row[3];
					$pass = $row[4];
					$location = $row[5];
					$storyline = $row[7];
					$level = $row[8];
					
				}
				$password = md5($password. 'myskilldomain'.$name);
				biodatapass($id, $name, $pass, $password,$email,$location, $storyline, $level);
			}
	}else{
	//checking name in database
	$name_query1 = "SELECT * FROM user_biodata WHERE username='".$name."'";
	$name_query1 = selectMysql($pdo, $name_query1);

		if ($name_query1->rowCount() == 0){
			$name_query2 =  selectMysql($pdo, "SELECT * FROM temp_user WHERE username= '$name'");
			
			if ($name_query2->rowCount() == 0){
				$user_error = '<p class="text-danger"><strong> User details not found</strong></p>'; //username is incorrect
				include('login.html');
			}else{
				while ($row = $name_query2->fetch(PDO::FETCH_NUM)){
							$id =  $row[1];
							$name= $row[2];
							$email = $row[3];
							$pass = $row[4];
							$location = $row[5];
						}
						$password = md5($password. 'myskilldomain'.$name);
						temppass($id, $name, $pass, $password,$email,$location);
			}
		}else {
				while ($row = $name_query1->fetch(PDO::FETCH_NUM)){
					$id =  $row[1];
					$name= $row[2];
					$email = $row[3];
					$pass = $row[4];
					$location = $row[5];
					$storyline = $row[7];
							$level = $row[8];
				}
				$password = md5($password. 'myskilldomain'.$name);
				biodatapass($id, $name, $pass, $password,$email,$location, $storyline, $level);
		}
	}
	}catch (PDOException $e){
		 $output = 'Login error encountered '. $e->getMessage();
	 include '../includes/error.html.php';
	}

}

	
	
function temppass($id, $name,$pass,$password,$email,$location){
				//validating password
				
				if($pass !== $password){
				$error='<p class="fa fa-times text-danger"><strong> Incorrect password</strong></p>'; 
				include('login.html');
				}else{
					
						$loggedin = TRUE;
						$_SESSION['ID'] = md5(microtime().$_SERVER['REMOTE_ADDR']);
					$_SESSION['userID'] = $id;	
					$_SESSION['username']=$name;
					$_SESSION['password']=$password;
					$_SESSION['email']=$email;
					$_SESSION['location']=$location;
					$_SESSION['linker']="login";
			
					header("Location:../users/profile/user_dashboard.html");
				}
}

function biodatapass($id, $name,$pass,$password,$email,$location, $storyline, $level ){
				//validating password
				
				if($pass !== $password){
				$error='<p class=" fa fa-times text-danger"><strong> Incorrect password</strong><br/></p>';
				include('login.html');				
				}else{
				
					$loggedin = TRUE;
					$_SESSION['ID'] = md5(microtime().$_SERVER['REMOTE_ADDR']);
					$_SESSION['userID'] = $id;	
					$_SESSION['username']=$name;
					$_SESSION['password']=$password;
					$_SESSION['email']=$email;
					$_SESSION['location']=$location;
					$_SESSION['storyline']=	$storyline;
					$_SESSION['seller_lvl']= $level;
					$_SESSION['linker']="login";
			
					header("Location:../users/profile/user_dashboard.html");
					
				
}
}
?>