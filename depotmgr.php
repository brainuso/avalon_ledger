<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Manage Customers | <?php include 'header.php';
   //check if depot manager is logged in
 if(empty($_SESSION['LoggedInMgr']) && empty($_SESSION['depot_mgr_name'])){
	   //what to display if a depot manager is logged in
	   //get list of distributors under the state managed by the logged in depot manager
	     echo "<script>
		location.href = 'index.php';
   </script>";
   }?>
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Depot Manager Page</h2>
                        <hr />
                        <a href="shop.php" type="button" class="btn btn-default">Shop</a>
                        <br>
                        <a href="payment.php" type="button" class="btn btn-default">Cashier System</a>
                        <br>
                        <a href="inventory.php" type="button" class="btn btn-default">Manage Inventory</a>
                        <br>
                        <a href="deptmandistributors.php" type="button" class="btn btn-default">Manage Customers</a> 
                    </div>
                </div>
            </div>
            
        </div>         
        <?php include 'footer.php';?>
    </body>
</html>
