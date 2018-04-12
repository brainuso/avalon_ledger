<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title> Inventory | <?php include 'header.php';
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
				<div class="col-md-12 col-sm-12 ">
					<div class="pull-left">
						<a href="depotmgr.php" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Go to Home</a>
					</div>
					</div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
					    <div class="text-center">
                            <h2>Product Inventory</h2>
                         
                        </div>
                        <hr />
                        <table class="table table-striped table-bordered"> 
                            <thead> 
                                <tr> 
                                    <th>S/No</th> 
                                    <th>Product ID</th> 
                                    <th>Product</th> 
                                    <th>Price</th>
                                    <th>In Stock</th>
                                    <th>Stock Sold</th>
                                    <th>Stock Left</th>
                                </tr>                                 
                            </thead>                             
                            <tbody> 
							<?php $sql=selectMysql($pdo, "SELECT * FROM product INNER JOIN inventory 
							WHERE inventory.mgr_id='".$_SESSION['mgr_id']."' AND product.product_id=inventory.product_id ");
							$i =1;
							while($row=$sql->fetch(PDO::FETCH_ASSOC)){
								
								echo '<tr> 
                                    <td>'.$i.'</td> 
                                    <td>'.$row['product_id'].'</td> 
                                    <td>'.$row['name'].'</td> 
                                    <td>&#8358;'.$row['price'].'</td> 
                                    <td>'.$row['stock'].'</td> 
                                    <td>'.$row['stock_sold'].'</td> 
                                    <td>'.$row['stock_left'].'</td> 
                                </tr>';
								$i++;
							}?>                                 
                            </tbody>
                        </table>
                        <a href="newinventory.php" type="button" class="btn btn-default">Add inventory</a>
                    </div>
                </div>
            </div>
           
        </div>         
       <?php include 'footer.php';?>
    </body>
</html>
