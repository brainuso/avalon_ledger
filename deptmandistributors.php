<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>	Manage Customers | <?php include 'header.php';
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
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <h2>Customers/Distributors</h2>
                        <hr />
                       
                        <form role="form" class="">
    <fieldset>
        <div class="form-group col-lg-8"> 
            <input type="text" class="form-control inout-group" id="myInput" onkeyup="showState()" placeholder="Search...">
        </div>
        <div class="checkbox col-lg-8" data-toggle="radio">
<p>Sort By:</p>		
            <label class="control-label"> 
                <input type="radio" name="optionsRadios" id="optionsRadios1" value="customer"/> Customer                        
            </label>
            <label class="control-label"> 
                <input type="radio" name="optionsRadios" id="optionsRadios2" value="distributor"/>  Distributor                    
            </label>             
        </div> 
		
		<div class="checkbox col-lg-6"> 
		<p></p>
        <label class="control-label"> 
            <input name="optionsCheck" id="checkbox" value="debt" type="checkbox"/> Debtors                
        </label>
		</div>
    </fieldset>     
</form>
								<table id="myTable" class="table table-striped "> 
                            <thead> 
                                <tr> 
                                    <th>Name</th> 
                                    <th>State</th> 
                                </tr>                                 
                            </thead>                             
                            <tbody> 
							<?php
	   $query=selectMysql($pdo, "SELECT * FROM distributor WHERE state='".$_SESSION['state_managed']."' 
	   AND mgr_id='".$_SESSION['mgr_id']."'");
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			 echo'<tr> 
                <td><a href="distledger.php?name='.$row['name'].'">'.$row['name'].'</a></td> 
                                    <td>'.$row['state'].'</td> 
                 </tr>';
		}?>
                            </tbody>
                        </table>
						<a href="email.php?to=customer" type="button" class="btn btn-default">Send Email</a>
                    </div>
                </div>
            </div>
           
        </div>         
       <?php include 'footer.php';?>
	   	<script>
		  //ajax location call
function showState() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
	if( tr == "all"){
		document.write = "alll";
	}else{
  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

}
</script>
    </body>
</html>
