<?php
session_start();
session_destroy(); 	
include_once("config.php");
// echo "<script language='javascript'>
// 				alert(' LOGOUT FINISH','OK')
// 			</script>";
echo "<meta http-equiv=refresh content=0;url=index.php>";
exit;
?>