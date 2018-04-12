<?php include "auth.php"; 
//destroy and unset all indices stored under $_SESSION array 
if (!empty($_SESSION['LoggedInMgr']) && !empty($_SESSION['depot_mgr_name'])){
destroySession($_SESSION['LoggedInMgr']);
}
?>
<script>
  location.href = 'index.php';
</script>