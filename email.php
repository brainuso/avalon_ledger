<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Email | <?php include 'header.php'; $to = $_GET['to'];
		
		//check if depot manager is logged in
 if(empty($_SESSION['LoggedInAdm']) && empty($_SESSION['adm_name']) &&
 (empty($_SESSION['LoggedInMgr']) && empty($_SESSION['depot_mgr_name']))){
	   //what to display if a depot manager is logged in
	   //get list of distributors under the state managed by the logged in depot manager
	     echo "<script>
		location.href = 'index.php';
   </script>";
   }else{
	   
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['message_body'])){
				if (!empty($_POST['message_body'])){

			// REPLACE THE LINE BELOW WITH YOUR E-MAIL ADDRESS.
			$mailfrom='admin@avalonpaints.com';

			$subject = sanitizeString($_POST['subject']);
			$to =  sanitizeString($_POST['mailto']);
			// NOT SUGGESTED TO CHANGE THESE VALUES
			$message_body = sanitizeString($_POST [ "message_body" ]) ;
			$headers = 'From: ' . $mailfrom . PHP_EOL ;
			try{
			mail ($to, $subject, $message_body, $headers );
			}
			catch (PDOException $e){
$output = $e->getMessage();
	 include 'error.php';

exit();
}

			// THE TEXT IN QUOTES BELOW IS WHAT WILL BE
			// DISPLAYED TO USERS AFTER SUBMITTING THE FORM.
			/*if(mail($to, $subject, $message_body, $headers)== TRUE){
				echo $to;
				echo $subject;
				echo $message_body;
				echo $headers;
				
				echo "Your e-mail has been sent! You should receive a reply within 24 hours!" ;}
			else{
				echo $to;
				echo $subject;
				echo $message_body;
				echo $headers;
				echo ' mail didnt fly';}*/
		}
		else{
			echo 'Warning, message cannot be empty.';}
  
   }
   }?>
		
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <form role="form" method="POST" action="">
                        <div class="col-lg-8 col-md-10" ta-pg-collapsed>
                            <fieldset>
                                <legend>Email <?php echo $to;?></legend>
                                <div class="form-group">
                                    <label class="control-label col-lg-2 col-md-2" for="">From</label>
                                    <div class=" col-lg-10 col-md-10">
                                        <input class="form-control" name="mailfrom" value="admin@avalonpaints.com" disabled="disabled" required="" type="text"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-2 col-md-2" for="name">To</label>
                                    <div class="col-lg-10 col-md-10">
                                        <select class="form-control" name="mailto" placeholder="" type="text" required="">
                                            <option>Select manager</option>
											<option value="all">All managers</option>
                                            <?php  
												$sql= selectMysql ($pdo, "SELECT name, email FROM ".$to."");
												while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
													$name = $row['name'];
													$email = $row['email'];
													echo '<option value="'.$email.'">'.$name.'</option>';
                                            	}
											?>
											
										</select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-2 col-md-2" for="">Cc</label>
                                    <div class=" col-lg-10 col-md-10">
                                        <input class="form-control" name="cc_mailto" value="" type="text"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-2 col-md-2" for="">Bcc</label>
                                    <div class=" col-lg-10 col-md-10">
                                        <input class="form-control" name="blind_cc_mailto" type="text">
                                        <cite>Type in the names, each seperated by a comma (,)</cite>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-2 col-md-2" for="">Subject</label>
                                    <div class=" col-lg-10 col-md-10">
                                        <input class="form-control" name="subject" required="" type="text"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-2 col-md-2  " for="">Compose</label>
                                    <div class="col-lg-10 col-md-10">
                                        <textarea class="form-control" rows="3" name="message_body"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-success">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>         
       <?php include 'footer.php';?>
    </body>
</html>
