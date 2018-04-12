<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
	
        <title>Paint Shop | <?php include 'header.php';
   //check if depot manager is logged in
 if((empty($_SESSION['LoggedInMgr']) && empty($_SESSION['depot_mgr_name']))&&
 ( empty($_SESSION['LoggedInAdm']) && empty($_SESSION['adm_name']))){
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
                    <div class="col-lg-12">
                        <h2 class="text-center">Avalon Depot </h2> 
                        <div class="row">
						<?php $sql = selectMysql($pdo, "SELECT * FROM product INNER JOIN inventory
						WHERE product.product_id=inventory.product_id AND inventory.mgr_id='".$_SESSION['mgr_id']."'");
						while($row=$sql->fetch(PDO::FETCH_ASSOC)){
							if($row['stock_left'] == 0){
									echo '<div class="col-sm-6 col-md-4 disabled"> 
                                <div class="thumbnail"> 
                                    <img src="file:///C:/Program%20Files%20(x86)/Pinegrow%20Web%20Designer/placeholders/img6.jpg" alt="'.$row['name'].'"> 
                                    <div class="caption"> 
                                        <h3>'.$row['name'].'</h3> 
                                        <p>Description: '.$row['description'].'.<br>
										Price: &#8358;'.$row['price'].' <br>
										Stock Left: '.$row['stock_left'].'</p> 
                                        <p><a href="invoice.php" class="btn btn-primary disabled" value="" role="button">Purchase</a> </p> 
                                    </div>                                     
                                </div>                                 
                            </div>';
							}elseif($row['stock_left'] <= 50){
								echo '<div class="col-sm-6 col-md-4"> 
                                <div class="thumbnail"> 
                                    <img src="file:///C:/Program%20Files%20(x86)/Pinegrow%20Web%20Designer/placeholders/img6.jpg" alt="'.$row['name'].'"> 
                                    <div class="caption"> 
                                        <h3>'.$row['name'].'</h3> 
                                        <p>Description: '.$row['description'].'.<br>
										Price: &#8358;'.$row['price'].' <br>
										<span class="bold text-danger">Stock Left: '.$row['stock_left'].'</span></p> 
                                        <p><a href="invoice.php" class="btn btn-primary" value="" role="button">Purchase</a> </p> 
                                    </div>                                     
                                </div>                                 
                            </div>';
							}else{
									echo '<div class="col-sm-6 col-md-4"> 
                                <div class="thumbnail"> 
                                    <img src="file:///C:/Program%20Files%20(x86)/Pinegrow%20Web%20Designer/placeholders/img6.jpg" alt="'.$row['name'].'"> 
                                    <div class="caption"> 
                                        <h3>'.$row['name'].'</h3> 
                                        <p>Description: '.$row['description'].'.<br>
										Price: &#8358;'.$row['price'].' <br>
										Stock Left: '.$row['stock_left'].'</p> 
                                        <p><a href="invoice.php" class="btn btn-primary" value="" role="button">Purchase</a> </p> 
                                    </div>                                     
                                </div>                                 
                            </div>';
							}
							
						}
						?>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>         
       <?php include 'footer.php';?>
    </body>
</html>
