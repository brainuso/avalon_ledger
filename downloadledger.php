<?php
include "auth.php";
	$distributor_id=$_GET['id'];
	$name=$_GET['name'];
	$string_to_print ='
<!DOCTYPE html>
<html lang="en">
  <head>
  
	<title>Ledger For '.$name.'</title>
    <meta http-equiv=X-UA-Compatible content="IE=EmulateIE7; IE=EmulateIE9">
<meta http-equiv=Content-Type content="text/html; charset=utf-8"/>
<meta name=viewport content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
<link rel="shortcut icon" href=http://www.freshdesignweb.com/wp-content/themes/fv28/images/icon.ico />
<!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/font-awesome.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="jumbotron.css" rel="stylesheet">
<link rel=stylesheet type="text/css" href="printcss/style.css" media=all />
<link rel=stylesheet type="text/css" href="printcss/fdw-demo.css" media=all />
<link hre=\'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700\' rel=stylesheet type=\'text/css\'>
</head>
<body>
<div class=container>
<div class=freshdesignweb-top><h2>'.$name.' Ledger</h2></div>
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
				<tbody>';
				
				
				$trans_query=selectMysql($pdo, "SELECT * FROM transaction WHERE distributor_id='".$distributor_id."'");
				$serial_num=1;
				$this_balance=0;
				$balance=0;
				while($row=$trans_query->fetch(PDO::FETCH_ASSOC)){
					$this_balance=$row['credit']-$row['debit'];
					$balance=$balance+$this_balance;
					
					$string_to_print=$string_to_print.'<tr>
			<td>'.$serial_num.'</td>
			<td>'.dater($row['date']).'</td>
			<td>'.$row['transaction_id'].'</td>
			<td>'.$row['credit'].'</td>
			<td>'.$row['debit'].'</td>
			<td>'.$balance.'</td>
		  </tr>';
		  $serial_num++;
				}
				
		$string_to_print=$string_to_print.'	
				</tbody>
              </table> 
			  </div><!--/col-lg-4 -->

			
		</div><!-- /row -->
	</div><!-- /container -->
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<!--Script to automatically print the page when it is done loading-->
	
  </body>
</html>';
	//echo $string_to_print;
	// include autoloader
require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->load_html($string_to_print);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();
$today=time();
$date_stamp= date('g: i a, l, j M, Y', $today);
echo $date_stamp.'<br>';
// Output the generated PDF to Browser
//$dompdf->stream();
echo "The pdf file that you will be prompted to download is the ledger for ".$name.", you can send it as an attachment to their email.";
// Output the generated PDF (1 = download and 0 = preview)
$dompdf->stream($name." Ledger as of ".$date_stamp,array("Attachment"=>1));

?>