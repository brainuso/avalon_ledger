<?php
if ( isset ( $_POST [ 'buttonPressed' ] )){
$mailfrom='admin@avalonpaints.com';
            $subject = 'Lousy subject';
            $to =  'brainus05@gmail.com';
            // NOT SUGGESTED TO CHANGE THESE VALUES
            $message_body = $_POST['message'] ;
            $headers = 'From: ' . $mailfrom . PHP_EOL ;
            try{
            mail ($to, $subject, $message_body, $headers );
            echo "Sent successfully";
            }
            catch (PDOException $e){
$output = $e->getMessage();
echo "Error sending mail";
     include 'error.php';
exit();
}
}
?>
<form method= "post" action= "<?php echo $_SERVER [ 'PHP_SELF' ] ;?>" />
  <table>
   
    <tr>
      <td>Your message: </td>
      <td><textarea name= "message" cols= "20" rows= "6"></textarea></td>
    </tr>
    <tr>
      <td></td>
      <td><input name= "buttonPressed" type= "submit" value= "Send E-mail!" /></td>
    </tr>
 </table>
</form>
