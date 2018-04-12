<!DOCTYPE html>
  
  
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Adminstrator Page | 
       <?php 
include "header.php";

   //check if admin is logged in
   if(empty($_SESSION['LoggedInAdm']) && empty($_SESSION['adm_name'])){
	   //what to display if a depot manager is logged in
	   //get list of distributors under the state managed by the logged in depot manager
	     echo "<script>
		location.href = 'index.php';
   </script>";
   }
	   ?>
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Administrator Page</h2>
                        <hr />
						<p>Administrator Name: <strong>
	   <?php echo strtoupper($_SESSION['adm_name']); ?> </strong>
	   </p>
		
                        <a href="mandepotmgr.php" type="button" class="btn btn-default">Manage Depot Managers</a>
                        <br>
                        <a href="mandistributors.php" type="button" class="btn btn-default">Manage Customers</a> 
                    </div>
                </div>
            </div>

        </div> 
<?php       
include "footer.php";
?>  
    </body>
</html>
