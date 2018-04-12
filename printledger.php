<!DOCTYPE html>
<html lang="en">
  <head>
  <?php include "auth.php";
	$distributor_id=$_GET['id'];
	$name=$_GET['name'];
	?>
	<title>Ledger For <?php echo $name; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
<link rel="shortcut icon" href="http://www.freshdesignweb.com/wp-content/themes/fv28/images/icon.ico"/>
<!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/font-awesome.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="jumbotron.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="printcss/style.css" media="all" />
<link rel="stylesheet" type="text/css" href="printcss/fdw-demo.css" media="all" />
<link hre='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel=stylesheet type='text/css'>
</head>
<body>
<div class="container">
<div class="freshdesignweb-top"><h2><?php echo $name; ?></h2></div>
<header>
<h3>Customer Ledger</h3><p>
</header>



  <body>

    <!-- Fixed navbar -->
   	
	<div class="container">
		
		<div class="row">
			<div class="col-lg-13">	 <table class="bordered">
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
				$trans_query=selectMysql($pdo, "SELECT * FROM transaction WHERE distributor_id='".$distributor_id."'");
				$serial_num=1;
				$this_balance=0;
				$balance=0;
				while($row=$trans_query->fetch(PDO::FETCH_ASSOC)){
					$this_balance=$row['credit']-$row['debit'];
					$balance=$balance+$this_balance;
					
					echo '<tr>
			<td>'.$serial_num.'</td>
			<td>'.dater($row['date']).'</td>
			<td>'.$row['ID'].'</td>
			<td>'.$row['credit'].'</td>
			<td>'.$row['debit'].'</td>
			<td>'.$balance.'</td>
		  </tr>';
		  $serial_num++;
				}
				
                ?>
				
				</tbody>
              </table> 
			  <?php
			  
				?>
			  <div class="form-group">
                    <div class="col-lg-6">
                      <button type="button" class="btn btn-default" onClick="window.print()">Print</button>
           
                    </div>
                  </div>
			  </form>
			</div><!--/col-lg-4 -->

			
		</div><!-- /row -->
	</div><!-- /container -->
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
     <script src="assets/js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
       <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
   <!--Script to automatically print the page when it is done loading-->
	        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
(function(){try{var s,a,i,j,r,c,l=document.getElementsByTagName("a"),t=document.createElement("textarea");for(i=0;l.length-i;i++){try{a=l[i].getAttribute("href");if(a&&a.indexOf("/cdn-cgi/l/email-protection") > -1  && (a.length > 28)){s='';j=27+ 1 + a.indexOf("/cdn-cgi/l/email-protection");if (a.length > j) {r=parseInt(a.substr(j,2),16);for(j+=2;a.length>j&&a.substr(j,1)!='X';j+=2){c=parseInt(a.substr(j,2),16)^r;s+=String.fromCharCode(c);}j+=1;s+=a.substr(j,a.length-j);}t.innerHTML=s.replace(/</g,"&lt;").replace(/>/g,"&gt;");l[i].setAttribute("href","mailto:"+t.value);}}catch(e){}}}catch(e){}})();
/* ]]> */
</script>

  </body>
</html>
<script type="text/javascript">
	window.onload= function()
	{ window.print(); }
	</script>