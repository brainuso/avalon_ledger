<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title> Payment | <?php include 'header.php';
   //check if depot manager is logged in
 if(empty($_SESSION['LoggedInMgr']) && empty($_SESSION['depot_mgr_name'])){
	   //what to display if a depot manager is logged in
	   //get list of distributors under the state managed by the logged in depot manager
	     echo "<script>
		location.href = 'index.php';
   </script>";
   } 
   else{
	if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['customer'])){
		//customer details 
		$customer = sanitizeString($_POST['customer']);
		$email = sanitizeString($_POST['email']);
		$phone_num = sanitizeString($_POST['phone_num']);
		$address = sanitizeString($_POST['address']);
		$state = sanitizeString($_POST['state']);
		
		$sum = sanitizeString($_POST['sum']);
		//search is customer exists
		//$cust_query= selectMysql($pdo, "SELECT * FROM 
		
		$customer_id = random(12);
		//input customer details
		$sql= queryMysql($pdo, "INSERT INTO customer SET mgr_id='".$_SESSION['mgr_id']."', customer_id='".$customer_id."', name='".$customer."',
		email='".$email."', phone_num='".$phone_num."', address='".$address."', state='".$state."'");
		
		//copy purchase details from temp_purchase table and insert into purchase 
		//generate purchase id
		$purchase_id = random(15);
		 $purchase_query = selectMysql($pdo, "SELECT * FROM temp_purchase WHERE mgr_id='".$_SESSION['mgr_id']."'");
		 while($row=$purchase_query->fetch(PDO::FETCH_ASSOC)){
			 $insert_purchase = queryMysql($pdo, "INSERT INTO purchase SET purchase_id='".$purchase_id."', product_id='".$row['product_id']."', mgr_id='".$_SESSION['mgr_id']."',
			 customer_id='".$customer_id."', quantity='".$row['qty']."', coupon_code='".$row['coupon_code']."', discount='".$row['discount']."', price='".$row['price']."', total='".$row['total']."'");
			
			//subtract quantity of goods from manager's inventory
			
		}
		 
		//PAYMENT 
		$pay_type = sanitizeString($_POST['pay_type']);
		$pay_id= random(12);
		
		//cash transaction input
		if($pay_type == "cash"){
			$amountpaid = sanitizeString($_POST['amountPaid']);
			//insert cash details into payment table
			$query = queryMysql($pdo, "INSERT INTO payment SET pay_id='".$pay_id."', pay_type='".$pay_type."', 
			amount='".$amountpaid."'");
		} 
			//bank teller transaction input
		else
		if($pay_type == "teller"){
			$amountpaid = sanitizeString($_POST['amountPaid']);
			$bank_name = sanitizeString($_POST['bank_name']);
			$teller = sanitizeString($_POST['teller']);
			$acct_num = sanitizeString($_POST['acct_no']);
			//insert bank details into payment table
			$query = queryMysql($pdo, "INSERT INTO payment SET pay_id='".$pay_id."', pay_type='".$pay_type."', 
			amount='".$amountpaid."', bank='".$bank_name."', account_num='".$acct_num."', teller_id='".$teller."'");
		}
			//POS transaction input
		else
		if($pay_type == "pos"){
			$amountpaid = sanitizeString($_POST['amountPaid']);
			$teller = sanitizeString($_POST['teller']);
			$query = queryMysql($pdo, "INSERT INTO payment SET pay_id='".$pay_id."', customer_id='".$customer_id."', pay_type='".$pay_type."', 
			amount='".$amountpaid."', teller_id='".$teller."'");
		} 
			//credit transaction input
		else
		if($pay_type == "credit"){
		$datedue = sanitizeString($_POST['credit_date']);
			$query = queryMysql($pdo, "INSERT INTO creditor SET customer_id='".$customer_id."', purchase_id='".$purchase_id."', amount_due='".$sum."', date_due='".$datedue."'");
		}
		
		
		
		
		
	}
}
   ?>
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <form role="form" method="POST" action="">
                        <div class="col-lg-7 col-md-7">
                            <fieldset>
                                <legend>Customer Details</legend>
                                 <div class="form-group radio-group">
                                            <label class="radio-inline">
                                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="individual">Individual
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="distributor">Distributor
                                            </label>
                                 </div>
								 <div class="form-group">
                                    <select id="cust-type" name="customer_type" onchange="showCustomer(this.value)" class="form-control">
                                        <option>Customer Type</option>
                                        <option value="new">New Customer</option>
                                        <option value="returning">Returning Customer</option>
                                    </select>
                                </div>
								<div class="form-group" id="returningCustomer">
								
								</div>
								<div id="namediv" class="form-group">
                                    <label class="control-label" for="paint-type">Name</label>
                                    <input type="text" class="form-control" name="customer" id="name" placeholder="Name">
                                </div>
                                <div id="emaildiv" class="form-group">
                                    <label class="control-label" for="">Email</label>
                                    <input type="email" class="form-control" name="email" id="mail" placeholder="Email">
                                </div>
                                <div id="phonediv" class="form-group">
                                    <label class="control-label" for="">Phone Number</label>
                                    <input type="text" class="form-control" name="phone_num" id="phone-number" placeholder="Phone Number">
                                </div>
                                <div id="addressdiv" class="form-group">
                                    <label class="control-label" for="">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                                </div>
                                <div id="statediv" class="form-group">
                                    <label class="control-label" for="">State</label>
                                    <input type="text" class="form-control" id="state" name="state" placeholder="State">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-5 col-md-5">
                            <fieldset>
                                <legend>Payment Options</legend>
								<p><strong> Amount payable: <?php echo sanitizeString($_POST['sum']);?></strong></p>
                                <div id="paydiv" class="form-group">
                                    <select id="pay" name="pay_type" onchange="showPay(this.value)" class="form-control">
                                        <option>Select Payment Options</option>
                                        <option value="cash">Cash</option>
                                        <option value="teller">Bank Teller</option>
                                        <option value="pos">POS</option>
                                        <option id="creditOption" value="credit">Credit</option>
                                    </select>
                                </div>
                                <div id="amountdiv" class="form-group">
                                    <label class="control-label" for="">Amount Paid</label>
									<div class="input-group"> 
                                        <span class="input-group-addon">&#8358;</span>	
										<input type="text" class="form-control" name="amountPaid" id="amountPaid" placeholder="Amount">
									</div>
                                </div>
                                <div id="creditdiv" class="form-group">
                                    <label class="control-label" for="">Date Due</label>
                                    <input type="date" class="form-control" name="credit_date" id="creditDate" placeholder="">
                                </div>
                                <div id="bankdiv" class="form-group">
                                    <label class="control-label" for="">Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" id="bankName" placeholder="Bank Name">
                                </div>
                                <div id="tellerdiv" class="form-group">
                                    <label class="control-label" for="tellerNo">Teller/Transaction Number</label>
                                    <input type="text" class="form-control" name="teller" id="teller" placeholder="Teller Number">
                                </div>
                                <div id="acctdiv" class="form-group">
                                    <label class="control-label" for="">Account Number</label>
                                    <input type="text" class="form-control" name="acct_no" id="acctNo" placeholder="Account Number">
                                </div>
								<input name="sum" value"<?php echo sanitizeString($_POST['sum']);?>" type="hidden"/>
                                
                            </fieldset>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" name="action" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>         
		 <?php include 'footer.php';?>
    </body>
	<script>
		function showCustomer(str){
			
			
			if(str=="new"){
				document.getElementById("creditOption").style.display="none";
				document.getElementById("creditdiv").style.display="none";
			}
			else if(str=="returning"){
				//show credit options
				document.getElementById("creditOption").style.display="block";
				document.getElementById("creditdiv").style.display="block";
				
				//check if radio button is selected
				if($("input[name=optionsRadios]:checked").val()!=""){
					var person = $("input[name=optionsRadios]:checked").val();
					
					//ajax call to check  customer details
			 if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("returningCustomer").innerHTML = xmlhttp.responseText;
				//hide all other customer details
				document.getElementById("namediv").style.display = "none";
				document.getElementById("emaildiv").style.display = "none";
				document.getElementById("phonediv").style.display = "none";
				document.getElementById("addressdiv").style.display = "none";
				document.getElementById("statediv").style.display = "none";
			}
        };
       		xmlhttp.open("GET","customer.php?customer="+str+"&type="+person,true);
       		xmlhttp.send();
				}
				else{
					alert("please Select either individual or distributor");
				}
			}
		}
		function showPay(val){
			var account = document.getElementById("acctdiv"); 
			var bank =	document.getElementById("bankdiv"); 
			var teller = document.getElementById("tellerdiv"); 
			var credit = document.getElementById("creditdiv"); 
			var amount = document.getElementById("amountdiv"); 
			
			if (val=="cash"){
				//visible
				amount.style.display= "block";
				//hidden
				bank.style.display= "none";
				account.style.display= "none";
				teller.style.display= "none";
				credit.style.display= "none";
			}
			else if (val=="teller"){
				
				//visible
				bank.style.display= "block";
				account.style.display= "block";
				teller.style.display= "block";
				amount.style.display= "block";
				//hidden
				credit.style.display= "none";
			}
			else if (val=="pos"){
				
				//visible
				amount.style.display= "block";
				teller.style.display= "block";
				//hidden
				bank.style.display= "none";
				account.style.display= "none";
				credit.style.display= "none";
			}
			else if (val=="credit"){
				//visible
				credit.style.display= "block";
				//hidden
				bank.style.display= "none";
				account.style.display= "none";
				teller.style.display= "none";
				amount.style.display= "none";
				
				
			}
		}
	</script>
</html>
