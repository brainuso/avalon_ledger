<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Invoice | <?php include 'header.php';
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
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <form role="form" id="purchase"> 
                            <fieldset>
                                <legend>Purchase Invoice</legend>
								<?php 
									/*if(!empty($_GET['product'])){
										$prod_id = sanitizeString($_GET['product']);
										$q = selectMysql($pdo, "SELECT product.product_id, product.name, inventory.price FROM product 
										INNER JOIN inventory WHERE product.product_id='".$prod_id."' AND product.product_id=inventory.product_id 
										AND inventory.mgr_id='".$_SESSION['mgr_id']."'");
												$row=$q->fetch(PDO::FETCH_ASSOC);
												echo'<div class="form-group">
                                    <label class="control-label" for="paint-type">Paint</label>                                     
                                    <select class="form-control" name="paint" id="paint">
                                        <option value="'.$row['product_id'].'">'.$row['name'].'</option>
                                    </select>                                     
                                </div>
                                <div class="form-group"> 
                                    <label class="control-label" for="">Price</label>
									 <div class="input-group"> 
                                        <span class="input-group-addon">&#8358;</span>	
                                    <input type="text" class="form-control" disabled name="price" id="price" placeholder="Price" value="'.$row['price'].'"/> 
									</div>                                 
                                </div>                                 
                                ';
									}
									else{*/
												echo'<div class="form-group">
                                    <label class="control-label" for="paint-type">Paint</label>                                     
                                    <select class="form-control" name="paint" id="paint" onchange="myPrice(this.value)">
									<option>Select Paint</option>';
									
									$q = selectMysql($pdo, "SELECT product.product_id, product.name, inventory.price FROM product 
										INNER JOIN inventory WHERE product.product_id=inventory.product_id 
										AND inventory.mgr_id='".$_SESSION['mgr_id']."'");
												while($row=$q->fetch(PDO::FETCH_ASSOC)){
                                       echo' <option value="'.$row['product_id'].'">'.$row['name'].'</option>';
												}
												echo'
                                    </select>                                     
                                </div>
                                <div class="form-group" id="priceLabel"> 
                                    <label class="control-label" for="" >Price</label>
									 <div class="input-group"> 
                                        <span class="input-group-addon">&#8358;</span>	
                                    <input type="text" class="form-control" disabled name="price" id="price" placeholder="Price" value="'.$row['price'].'"/> 
									</div>                                 
                                </div>                                 
                               ';
								//}
									?>
                                  <div class="form-group">
                                    <label class="control-label" for=""> Quantity</label>  
										<div class="input-group"> 
                                    <input type="text" class="form-control" id="qty" name="qty" onkeyup="myQty()" placeholder="Quantity"> 
										     <span class="input-group-addon">buckets</span>	
										</div>
								  </div>
                                <div class="form-group"> 
                                    <label class="control-label" for="">Coupon Code</label>                                     
                                    <input type="text" class="form-control" name="coupon" onblur="checkCoupon(this.value)" id="coupon" placeholder="Coupon"> 
									<?php if(isset($coupon_error))echo $coupon_error;?>
								</div>
								<div class="form-group"> 
                                    <label class="control-label" for="">Discount</label>                                     
                                    <input type="text" class="form-control" name="discount"  id="discount" placeholder=""> 
								
								</div>
                                <div class="form-group"> 
                                    <label class="control-label" for="">Total</label>
									 <div class="input-group"> 
                                        <span class="input-group-addon">&#8358;</span>	
                                    <input type="text" class="form-control" name="total" id="total" placeholder="Total"> 
									</div>                                 
                                </div>                                 
                               <!-- <div class="checkbox"> 
                                    <label class="control-label"> 
                                        <input type="checkbox"> Check me out                        
                                    </label>                                     
                                </div>-->
                                                             
                                                       
                            </fieldset>
                        </form> 
						<div id="myButtons2" class="bs-example">
							<button type="submit" onclick="showInvoice()" class="btn btn-success" data-loading-text="Loading...">Order </button> 
						</div>	
					</div>
					<div class="col-lg-8 col-md-8 col-xs-12 pull-right">
					<h2 class="text-center">Invoice</h2>
						
						<table class="table table-striped table-bordered">
							 <thead> 
                                <tr> 
                                    <th>S/No</th> 
                                    <th>Product</th> 
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                    
                                </tr>                                 
                            </thead>   
							<tbody id="invoice-table">
								<?php
										$query = selectMysql($pdo, "SELECT * FROM temp_purchase WHERE mgr_id='".$_SESSION['mgr_id']."'");
		$i = 1;
		$sum=0;
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			$r= selectMysql($pdo, "SELECT name FROM product WHERE product_id='".$row['product_id']."'");
				$list=$r->fetch(PDO::FETCH_ASSOC);
						echo '<tr>
									<td>'.$i.'</td> 
                                    <td>'.$list['name'].'</td> 
                                    <td>'.$row['price'].'</td>
                                    <td>'.$row['qty'].'</td>
                                    <td>'.$row['discount'].'</td>
                                    <td>&#8358;'.$row['total'].'</td>
                                    <td><button onClick="deletePurchase(this.value)" id="delete" class="fa fa-times-circle" 
									name="action" value="'.$row['product_id'].'"></button></td>
                                    
								</tr>
							';
			$i++;
			$sum +=$row['total'];
		}
		echo '<tr><td></td><td></td><td></td><td></td><td>TOTAL:</td><td><strong> &#8358;'.$sum.'</strong></td></tr>';
								
								?>
							</tbody>
						</table>
						<form method="POST" action="payment.php">
							<input name="sum" type="hidden" value="<?php echo $sum;?>"/>
							<button type="submit" class="btn btn-success pull-right">Proceed to Checkout</button>
						</form>
                    </div>
                </div>
            </div>
        </div>         
      <?php include 'footer.php';?>
    </body>
	<script>
			$(function() { $("#myButtons2 .btn").click(function(){ $(this).button('loading').delay(50).queue(function() { }); }); });
			
			function myQty(){
					var price = document.getElementById("price").value;
					var qty = document.getElementById("qty").value;
					var coupon = document.getElementById("discount").value;
					total = (price * qty)- coupon;
					document.getElementById("total").value= total;
			}
			
		
		//ajax price call to get price of selected paint
			function myPrice(str){
			
			 //document.getElementById("priceLabel").innerHTML = '<span><i>class="fa fa-spinner fa-spin"></i>Loading...</span>';
				if (str == "") {
        document.getElementById("priceLabel").innerHTML = "";
		
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("priceLabel").innerHTML = xmlhttp.responseText;
					myQty();
            }
        };
        xmlhttp.open("GET","price.php?q="+str,true);
        xmlhttp.send();
    }					
			}
	
	//check coupon value
			function checkCoupon(val){
				
				if (val == "") {
        
       					 return;
   				 } else { 
				
				 if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        //assign response to coupon id
			document.getElementById("discount").value = xmlhttp.responseText;
			myQty();
			}
        };
        xmlhttp.open("GET","price.php?coupon_code="+val,true);
        xmlhttp.send();
			}
			
		}
	
	
			//ajax function to input order into table
			function showInvoice(){
				var paint, price, qty, coupon, total;
				paint=document.getElementById("paint").value;
				price=document.getElementById("price").value;
				qty=document.getElementById("qty").value;
				discount=document.getElementById("discount").value;
				total=document.getElementById("total").value;
				
	
  if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("invoice-table").innerHTML = xmlhttp.responseText;
            }
        };
				if(coupon =="0"){
				xmlhttp.open("GET","price.php?paint="+paint +"&price="+ price + "&qty=" + qty + "&total=" + total,true);
        xmlhttp.send(null);
				}else{
					code= document.getElementById("coupon").value;
        xmlhttp.open("GET","price.php?paint="+paint +"&price="+ price + "&qty=" + qty + "&coupon="+ code + "&discount="+ discount + "&total=" + total,true);
        xmlhttp.send(null);
				}			
			}			
		
		//ajax call to delete individual cells from invoice table
		function deletePurchase(del){
			
			alert(del);
			 if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
               document.getElementById("invoice-table").innerHTML = xmlhttp.responseText;
            }
        };
			xmlhttp.open("GET","price.php?delete="+del,true);
      		xmlhttp.send(null);
		}
	</script>
</html>
