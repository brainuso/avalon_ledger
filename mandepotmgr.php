<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title> Manage Depot Managers |
		
		<?php include 'header.php';
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
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <h2>Depot Managers</h2>
                        <hr />
						<div class="form-group">
										<label for="gigTitle" class="col-lg-1 control-label">Filter: </label>
										<div class="col-lg-5">
										<input class="form-control input-group" id="myInput" onkeyup="showState()" placeholder="Search states"/> 
							
										</div>
									</div>
						<table id="myTable" class="table table-striped "> 
                            <thead> 
                                <tr> 
                                    <th>Name</th> 
                                    <th>State</th> 
                                </tr>                                 
                            </thead>                             
                            <tbody> 
							<?php
	   $query=selectMysql($pdo, "SELECT * FROM manager ORDER BY state");
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			 echo'<tr> 
                <td><a href="mgrledger.php?manager='.$row['name'].'">'.$row['name'].'</a></td> 
                                    <td>'.$row['state'].'</td> 
                 </tr>';
		}?>
                            </tbody>
                        </table>
						
                        <a href="addnewmgr.php" type="button" class="btn btn-default">Add Depot Manager</a>
                        <a href="email.php?to=manager" type="button" class="btn btn-default">Email Manager</a>
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
		document.write = "all";
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
