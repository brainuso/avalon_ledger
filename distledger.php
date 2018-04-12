<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title> <?php echo $_GET['name']. ' | Customer Ledger |';  include 'header.php';
   //check if depot manager is logged in
 if((empty($_SESSION['LoggedInAdm']) && empty($_SESSION['adm_name'])) &&
 (empty($_SESSION['LoggedInMgr']) && empty($_SESSION['depot_mgr_name']))){
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
                    <div class="col-md-12 col-sm-12 ">
					 <div class="text-center">
						<?php $sql = selectMysql($pdo, "SELECT * FROM distributor WHERE name='".$_GET['name']."'");
								$row=$sql->fetch(PDO::FETCH_ASSOC);
								$dist_id = $row['dist_id'];
									$name=$row['name'];
	   $address=$row['address'];
	   $phone_num=$row['phone_num'];
	   $state=$row['state'];
								$email=$row['email'];
								
                             echo '<h2>'.$name.'</h2>
                            
           
            <h4>Phone Number:<small> '.$phone_num.'</small><br>
            Email:<small> '.$email.'</small><br>
			State:<small> '.$state.'</small><br>
            </h4>';?>
                        </div>
                        <hr />
						
						  <table class="table table-striped table-bordered ">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Date</th>
					<th>Transaction ID</th>
                    <th>Credit</th>
					<th>Debit</th>
                    <th>Balance</th>
                  </tr>
                </thead>
                <tbody>
		<?php
		//display transaction table for this distributor
		$trans_query=selectMysql($pdo, "SELECT * FROM transaction WHERE distributor_id='".$dist_id."'");
		$serial_num=1;
		$this_balance=0;
		$balance=0;
		while($row=$trans_query->fetch(PDO::FETCH_ASSOC)){
			$this_balance=$row['credit']-$row['debit'];
			$balance=$balance+$this_balance;
			
			echo '
		  <tr>
			<td>'.$serial_num.'</td>
			<td>'.dater($row['date']).'</td>
			<td>'.$row['transaction_id'].'</td>
			<td>'.$row['credit'].'</td>
			<td>'.$row['debit'].'</td>
			<td>'.$balance.'</td>
		  </tr>' ;
		  $serial_num++;
		  
		}
		?>
			</tbody>
              </table> 
					<?php echo '
			<a href="downloadledger.php?id='.$dist_id.'&name='.$name.'" type="button" class="btn btn-default">Download Ledger</a>
			<a href="printledger.php?id='.$dist_id.'&name='.$name.'" type="button" class="btn btn-default">Print Ledger</a> ';
			?>	
                       </div>
                </div>
            </div>
           
        </div>         
      <?php include 'footer.php';?>
    </body>
</html>
