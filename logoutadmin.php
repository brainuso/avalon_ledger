<?php include "auth.php"; 
//unset all indices stored under $_SESSION array 

if (!empty($_SESSION['LoggedInAdm']) && !empty($_SESSION['adm_name'])){
destroySession($_SESSION['LoggedInAdm']);
}

?>
<script>
  location.href = 'index.php';
</script>