<?php
if(session_status()==PHP_SESSION_NONE){  //checks if session is already started
session_start();
}
//connect to database
//$dbhost = 'localhost'; // Unlikely to require changing
//$dbname = 'myskilld_myskilldomain'; // the name of the database
//$dbusername = 'brainuso'; // ...the username accessing the database
//$dbpassword = 'fiverr'; // ...password grants access to the database

try
{
$pdo = new PDO('mysql:host=localhost;dbname=avalon', 'brainuso',
'fiverr');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('SET NAMES "utf8"');

$site_url ="localhost/www.avalon.com";
$client= "Avalon Paints";
}
catch (PDOException $e)
{
$output = 'Unable to connect to the database server' . $e->getMessage();
	 include 'error.php';

exit();
}

//date function to display 04/05/2016 as 4 May 2016
		function dater($x){
		$x=date("d M Y", strtotime(str_replace('-','/',$x)));
		return $x;
		}
//random number function
function  random($rand_id_lnth){
	$rnd_id = (uniqid(rand(),1));
	
	$rnd_id = str_replace(".","",$rnd_id);
	$rnd_id = strrev(str_replace("/","",$rnd_id));
	$rnd_id = substr($rnd_id, 0, $rand_id_lnth);
	return $rnd_id;
	}
//function to handle slashes in user input
if (get_magic_quotes_gpc())
{
$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
while (list($key, $val) = each($process))
{
foreach ($val as $k => $v)
{
unset($process[$key][$k]);
if (is_array($v))
{
$process[$key][stripslashes($k)] = $v;
$process[] = &$process[$key][stripslashes($k)];
}
else
{
$process[$key][stripslashes($k)] = stripslashes($v);
}
}
}
unset($process);
}
//database query for INSERT,DELETE,UPDATE etc except for SELECT
function queryMysql($pdo, $query){
 try{
	 $query = $pdo->exec($query);
 }catch (PDOException $e){
	 $output = 'Query failed '. $e->getMessage();
	 include 'error.php';
 }
	return $query;	
}
//database query for only SELECT
function selectMysql($pdo, $query){
 try{
	 $query = $pdo->query($query);
 }catch (PDOException $e){
	 $output = 'Query failed '. $e->getMessage();
	 include 'error.php';
 }
	return $query;	
}
//function to close and logout from a session
function destroySession(){
$_SESSION=array();
if (session_id() != "" || isset($_COOKIE[session_name()]))
setcookie(session_name(), '', time()-2592000, '/');
session_destroy();
}
//function to remove php codes from user input
function sanitizeString($var){
$var = strip_tags($var);
$var = htmlentities($var);
//this has just been added
//$var = mysqli_real_escape_string($var);
$var = stripslashes($var);
return $var;
}


?>