<?php //reset.php2
include '../includes/function.php';

if ($_SERVER['REQUEST_METHOD']== "GET"){
$token = "";
$token = sanitizeString($_GET['token']);
$_SESSION['token'] = $token;

include 'new-password.html';
}
	if ($_SESSION['token'] == $_SESSION['pass_code']){
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST'){
			$pass = sanitizeString($_POST['password']);
			$pass2 = sanitizeString($_POST['password2']);
			$tbl_name = $_SESSION['tbl_name'];
			$username = $_SESSION['username'];
				if (strlen($pass) < 6 || strlen($pass2) < 6 ){
					$pasword_error = 'Passwords must be at least 6 characters';
				}
				//password string matching 
				if ( !preg_match("/[^a-zA-Z]/", $pass) || !preg_match("/[0-9]/", $pass)){
					$password_error = 'Passwords require alphanumeric characters';
				}
				if (!$pass == $pass2){
					$password2_error ='Passwords do not match';
				}
				if(isset($password_error) || isset($password2_error)){
					include('new-password.html');
					exit();
				}
				else{
					$pass2 = md5($pass2. 'myskilldomain' . $username);
					
					
					$passql = queryMysql($pdo, "UPDATE $tbl_name  SET password  = '".$pass2."' WHERE username ='".$username."'");
	
$qry = selectMysql($pdo, "SELECT * FROM $tbl_name WHERE username ='".$username."'");	

		if ($tbl_name == "temp_user"){
	while ($row = $qry->fetch(PDO::FETCH_NUM)){
							$id =  $row[1];
							$name= $row[2];
							$email = $row[3];
							$pass = $row[4];
							$location = $row[5];
							$loggedin = TRUE;
						$_SESSION['ID'] = md5(microtime().$_SERVER['REMOTE_ADDR']);
					$_SESSION['userID'] = $id;	
					$_SESSION['username']=$username;
					$_SESSION['password']=$pass2;
					$_SESSION['email']=$email;
					$_SESSION['location']=$location;
					$_SESSION['linker']="login";
					
					destroy($_SESSION['token']);
					destroy($_SESSION['pass_code']);
					destroy($_SESSION['tbl_name']);
					destroy($_SESSION['user']);
					
					header("Location:../users/profile/user_dashboard.html");
		
						}
					}
		else if($tbl_name == "user_biodata"){
			while ($row = $qry->fetch(PDO::FETCH_NUM)){
					$id =  $row[1];
					$name= $row[2];
					$email = $row[3];
					$pass = $row[4];
					$location = $row[5];
					$storyline = $row[7];
					$level = $row[8];
							
							$loggedin = TRUE;
					$_SESSION['ID'] = md5(microtime().$_SERVER['REMOTE_ADDR']);
					$_SESSION['userID'] = $id;	
					$_SESSION['username']=$name;
					$_SESSION['password']=$password;
					$_SESSION['email']=$email;
					$_SESSION['location']=$location;
					$_SESSION['storyline']=	$storyline;
					$_SESSION['seller_lvl']=	$level;
					$_SESSION['linker']="login";
			
			destroy($_SESSION['token']);
					destroy($_SESSION['pass_code']);
					destroy($_SESSION['tbl_name']);
					destroy($_SESSION['user']);
					
					header("Location:../users/profile/user_dashboard.html");
				
			}

					
				}
			}
	}
	//else echo "Server request failed.";
	
}
else{
		$error = '<span class="text-danger fa fa-warning">Token does not match . Please retry or contact Support.</span>';
		include 'reset-password.html';
		exit();
	}

 function destroy($a){
		unset($a);
	}

?>