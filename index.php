<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content=" Avalon Paints Login">
        <meta name="author" content="">
        <title>Login |
        
    <?php 
include "header.php";

   //check if user is logged in
   if(!empty($_SESSION['LoggedInMgr']) && !empty($_SESSION['depot_mgr_name'])){
	   //redirect depot manager to distributor page
	   echo "<script>
  location.href = 'depotmgr.php';
</script>";
	   
   }else if(!empty($_SESSION['LoggedInAdmin']) && !empty($_SESSION['admin_name'])){
	  //redirect admin to distributor page
	   echo "<script>
  location.href = 'admin.php';
</script>";
   }else {
	   //display login forms
	   ?>
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="well">
                            <form role="form" method="POST" action="procdepotmgr.php">
                                <fieldset>
                                    <legend>Depot Manager</legend>
                                    <div class="form-group"> 
                                        <label class="control-label" for="depot_mgr_name">Username</label>                                         
                                        <input type="text" class="form-control" name="depot_mgr_name" id="depot_mgr_name" placeholder="Enter username"> 
                                    </div>                                     
                                    <div class="form-group"> 
                                        <label class="control-label" for="">Password</label>                                         
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password"> 
                                    </div>
                                    <p>
                                Forgot Your password? Click <a href="resetpassword.php?depotmgr"> here</a></p>
                                </fieldset>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="well">
                            <form role="form" method="POST" action="procadmin.php">
                                <fieldset>
                                    <legend>Admininstrator</legend>
                                    <div class="form-group"> 
                                        <label class="control-label" for="adm_name">Username</label>                                         
                                        <input type="text" class="form-control" name="adm_name" id="adm_name" placeholder="Enter username"> 
                                    </div>                                     
                                    <div class="form-group"> 
                                        <label class="control-label" for="">Password</label>                                         
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password"> 
                                    </div>
                                    <p>
                                Forgot Your password? Click <a href="resetpassword.php?admin"> here</a></p>
                                </fieldset>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>                         
                    </div>
                </div>
					   <?php
   }
?>	

<!--What is displayed when the user is logged in-->
        
  
            </div>
            
        </div> 
		<?php 
include "footer.php";
?>
    </body>
</html>
