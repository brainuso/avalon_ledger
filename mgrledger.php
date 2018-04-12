<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title> <?php echo $_GET['manager']. ' | Manager Ledger |';  include 'header.php';
   //check if depot manager is logged in
 if(empty($_SESSION['LoggedInAdm']) && empty($_SESSION['adm_name'])){
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
						<div id="ledger">
					   <div class="text-center">
						<?php $sql = selectMysql($pdo, "SELECT * FROM manager WHERE name='".$_GET['manager']."'");
								$row=$sql->fetch(PDO::FETCH_ASSOC);
								$mgr_id = $row['mgr_id'];
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
                        <table  class="table"> 
                            <thead> 
                                <tr> 
                                    <th>#</th> 
                                    <th>Date</th> 
                                    <th>Customer</th> 
                                    <th>Purchase</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Balance</th>
                                </tr>                                 
                            </thead>                             
                            <tbody> 
                                <tr> 
                                    <td>1</td> 
                                    <td>Mark</td> 
                                    <td>Otto</td> 
                                    <td>@mdo</td> 
                                    <td>Jacob</td> 
                                    <td>Thornton</td> 
                                    <td>@fat</td> 
                                </tr>                                 
                                <tr> 
                                    <td>2</td> 
                                    <td>Jacob</td> 
                                    <td>Thornton</td> 
                                    <td>@fat</td> 
                                    <td>Jacob</td> 
                                    <td>Thornton</td> 
                                    <td>@fat</td> 
                                </tr>                                 
                                <tr> 
                                    <td>3</td> 
                                    <td>Larry</td> 
                                    <td>the Bird</td> 
                                    <td>@twitter</td> 
                                    <td>Jacob</td> 
                                    <td>Thornton</td> 
                                    <td>@fat</td> 
                                </tr>                                 
                            </tbody>
                        </table>
						</div>
                  			<?php echo '
			<a href="downloadledger.php?id='.$mgr_id.'&name='.$name.'" type="button" class="btn btn-success">Download Ledger</a>
			<a href="printledger.php?id='.$mgr_id.'&name='.$name.'" type="button" class="btn btn-default">Print Ledger</a> 
			<a href="email.php?to='.$mgr_id.'&name='.$name.'" type="button" class="btn btn-info">Email Manager</a> ';
			?>	
			<input type="button" class="btn btn-default" onClick="window.print()" value="Print Ledger"/>
			
          </div>
                </div>
            </div>
           
        </div>         
      <?php include 'footer.php';?>
	  <script type="text/javascript">

	</script>
    </body>
</html>
