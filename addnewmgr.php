<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Add Depot Manager |
		<?php include 'header.php'; 
		//check if admin is logged in
   if(empty($_SESSION['LoggedInAdm']) && empty($_SESSION['adm_name'])){
	   //what to display if a depot manager is logged in
	   //get list of distributors under the state managed by the logged in depot manager
	     echo "<script>
		location.href = 'index.php';
   </script>";
   }
   else{
	     //------------------------------------------------------// 
	  
	  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	 $mgr_name=sanitizeString($_POST['mgr_name']);
	 $address=sanitizeString($_POST['address']);
	  $email=sanitizeString($_POST['email']);
	  $password=sanitizeString($_POST['password']);
	  $password2=sanitizeString($_POST['password2']);
	  $state=sanitizeString($_POST['state']);
	  $phone_num=sanitizeString($_POST['phone_num']);
		
		/*	echo $mgr_name;
		echo $address;
		echo $email;
		echo $password;
		echo $password2;
		echo $state;
		echo $mgr_id;*/
		//mgr_name validation
		if ($mgr_name ==""){
			$user_error = "Please enter Manager name";
		}
		if(strlen($mgr_name) < 6){
			$user_error = "mgr_name must be 6 characters and above";
		}
		if (preg_match("/[^A-Za-z0-9_ -]/",$mgr_name)){
			$user_error = "Only letters, numbers, - and _ in names";
		}
		//duplicate mgr_name check
		//if (selectMysql($pdo, "SELECT * FROM temp_user WHERE username='$username'")->rowCount() == 1||
		//selectMysql($pdo, "SELECT * FROM user_biodata WHERE username='$username'")->rowCount() == 1){
		//		$user_error =  "Oops, username already in use, Please use another name.";
		//} 
		
		//email validation
		if ($email == ""){
			$email_error = "Please enter Email";
		}
			//email string matching
		if (!((strpos($email, ".") > 0) &&(strpos($email, "@") > 0))|| preg_match("/[^a-zA-Z0-9.@_-]/", $email)){
			$email_error  = "The Email address is invalid";
		}
		//duplicate email check
		if (selectMysql($pdo, "SELECT * FROM manager WHERE email='$email'")->rowCount() == 1){
				$email_error =  "Oops, email already in use, Please use another email.";
		}
		//password validation
		if ($password =="" || $password ==" "){
			$password_error = "No Password was entered";
		}
		//password count
		if (strlen($password) < 6){
				$password_error = "Passwords must be at least 6 characters";
		}
		//password string matching 
		if ( !preg_match("/[^a-zA-Z]/", $password) || !preg_match("/[0-9]/", $password)){
				$password_error = "Passwords require alphanumeric characters";
		}
		//password2 validation
		if ($password2 =="" || $password ==" "){
			$password2_error = "No Password was entered";
		}
			//password2 count
		if (strlen($password2) < 6){
			$password2_error = "Passwords must be at least 6 characters";
		}
			//password2 string matching 
		if ( !preg_match("/[a-zA-Z]/", $password2) || !preg_match("/[0-9]/", $password2)){
			$password2_error = "Passwords require alphanumeric characters";
		}
		//password 1 & 2 matching
		if($password !== $password2){ 
			$password2_error =  "Passwords do not match";	
		}
								
		//location check
		if($address == "" || $address == " "){
			$addr_error = "Please add an address";
		}
		//state check
		if($state == "" || $state == "Select State"){
			$state_error = "Please Select a location";
		}
		//error checking
		if(isset($user_error) || isset($email_error) || isset($password_error) || isset($password2_error)
			|| isset($addr_error) || isset($state_error) ){
				echo $user_error;
		echo $addr_error;
		echo $email_error;
		echo $password_error;
		echo $password2_error;
		echo $state_error;
			echo 'error found';
			exit();
		}
		else{
		//password hashing 
		$password2 = md5($password2. 'avalon' . $mgr_name);
			$mgr_id = random(12);
			//data input
			$query = queryMysql($pdo, "INSERT INTO manager SET name='".$mgr_name."', mgr_id='".$mgr_id."',email='".$email."',address='".$address."',password='".$password2."', phone_num='".$phone_num."', state='".$state."'");
			if($query){
				//echo 'inout successful';
				header("Location:mandepotmgr.php");
			}
		}
	
		
	}
  }
	   ?>
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <form role="form" method="POST" action="">
                        <div class="col-md-7">
                            <fieldset>
                                <legend>New Depot Manager</legend>
                                <div class="form-group">
                                    <label class="control-label" for="">Name</label>
                                    <input required type="text" class="form-control" name="mgr_name" id="mgr_name" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="">Email</label>
                                    <div class="input-group"> 
                                        <span class="input-group-addon">@</span>
                                        <input required type="email" class="form-control" name="email" id="email" placeholder="Email"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="">Password</label>
                                    <input required type="password" class="form-control" id="password" name="password" placeholder="Password"/>
									<span class="help-block">Password should be at least 6 characters with 0-9, a-z </span>
									<?php if(!empty($password_error)) echo $password_error;?>
								</div>
                                <div class="form-group">
                                    <label class="control-label" for="">Re-enter Password</label>
                                    <input required type="password" class="form-control" name="password2" id="password2" placeholder="Re-enter Password"/>
									<?php if(!empty($password2_error)) echo $password2_error;?>
								</div>
                                <div class="form-group">
                                    <label class="control-label" for="">Address</label>
                                    <input required type="text" class="form-control" name="address" id="address" placeholder="Address"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="">Phone Number</label>
                                    <input required type="text" class="form-control" name="phone_num" id="phone_num" placeholder="Phone Number"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="">State</label>
                                    <select class="form-control input-group" name="state">
										<option value="">Select State</option>
										<?php $sql = selectMysql($pdo, "SELECT name FROM location ORDER BY name");
										while ($row=$sql->fetch(PDO::FETCH_ASSOC)){
										$state = $row['name'];
										echo '<option value="'.$state.'">'.$state.'</option>';
										}?> 
									</select>
									<?php if(!empty($state_error)) echo $state_error;?>
							</div>
                            </fieldset>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>         
        <?php include 'footer.php';?>
    </body>
</html>
