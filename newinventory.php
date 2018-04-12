<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title> New Inventory | <?php include 'header.php';
   //check if depot manager is logged in
 if(empty($_SESSION['LoggedInMgr']) && empty($_SESSION['depot_mgr_name'])){
	   //what to display if a depot manager is logged in
	   //get list of distributors under the state managed by the logged in depot manager
	     echo "<script>
		location.href = 'index.php';
   </script>";
   } 
   else{
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$product = sanitizeString($_POST['product_name']);
		$price = sanitizeString($_POST['price']);
		$qty = sanitizeString($_POST['quantity']);
		$desc = sanitizeString($_POST['description']);
		
		//check if product already exists in product table
		$sql = selectMysql($pdo, "SELECT * FROM product WHERE name='".$product."'");
		if( $sql->rowCount() == 1){
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			$row['product_id'];
			//if it exists, check if product has inventory under that manager
			$prod_query = selectMysql($pdo, "SELECT * FROM inventory WHERE mgr_id= '".$_SESSION['mgr_id']."'
			AND product_id='".$row['product_id']."'");
			if($prod_query->rowCount()==1){
				//if product inventory exists update the stock and content of the product
				$list = $prod_query->fetch(PDO::FETCH_ASSOC);
				$stock = $qty + $list['stock'];
				$stock_left = $stock - $list['stock_sold'];
				$r = queryMysql($pdo, "UPDATE inventory SET price='".$price."', stock ='".$stock."', 
				stock_left='".$stock_left."' WHERE  mgr_id= '".$_SESSION['mgr_id']."'
			AND product_id='".$row['product_id']."'");
				//redirect to inventory list
				header("Location:inventory.php");
			}
			else{
				//if there is no inventory under manager, insert it
				
				$w = queryMysql($pdo, "INSERT INTO inventory SET product_id='".$row['product_id']."', 
				mgr_id = '".$_SESSION['mgr_id']."', stock ='".$qty."', price='".$price."',
					stock_left = '".$qty."'"); 
					//redirect to inventory list
				header("Location:inventory.php");
			}
		}
		else{
			//create product id, insert into product and inventory tables
			$prod_id = random(12);
		$q = queryMysql($pdo, "INSERT INTO product SET product_id='".$prod_id."', name = '".$product."', 
		description = '".$desc."'");
		$w = queryMysql($pdo, "INSERT INTO inventory SET product_id='".$prod_id."', 
		mgr_id = '".$_SESSION['mgr_id']."', stock ='".$qty."', price='".$price."',
		stock_left = '".$qty."'"); 
			//redirect to inventory list
			header("Location:inventory.php");
		}
		
   }
   }
   ?>
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <form role="form" method="POST" action="">
                        <div class="col-md-7" ta-pg-collapsed>
                            <fieldset>
                                <legend>New Inventory</legend>
                                <div class="form-group">
                                    <label class="control-label" for="">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" required id="product_name" placeholder="Product Name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="">Price</label>
                                    <div class="input-group"> 
                                        <span class="input-group-addon">&#8358;</span>
                                        <input type="text" class="form-control" name="price" required id="price" placeholder="Price">
										<span class="input-group-addon">per bucket</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="">Quantity Supplied</label>
                                    <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Quantity">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="">Product Description</label>
                                    <input type="text" class="form-control" name="description"  id="description" placeholder="Product Description">
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
