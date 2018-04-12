<?php include "auth.php"; 
//log all stored under $_SESSION array 
if (isset($_SESSION['LoggedInAdm'])){

destroySession($_SESSION['LoggedInAdm']);
} else{	
destroySession($_SESSION['LoggedInMgr']);
}
?>
<script>
  location.href = 'index.php';
</script>