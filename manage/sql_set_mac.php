<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

include_once("../config.php");
?>

<!-- jquery-3.6.0 -->
<script src="js/function_3.6.0.js"></script>
<!-- jquery-sweetalert2 -->
<script src="js/function_sweetalert2.js"></script>

<?php
//-----------------Connect MSSQL 14 db_Aerosoft_ERP-----------------

$serverName = '192.168.0.14';
//$serverName = '110.164.127.170';
$userName = 'aero';
$userPassword = '1stLogin';
$dbName = 'db_Aerosoft_ERP';
 
try{
	$conn = new PDO("sqlsrv:server=$serverName ; Database = $dbName", $userName, $userPassword);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
	die(print_r($e->getMessage()));
}

@$user_id=$_SESSION['id'];

@$result = $mysqli->query("SELECT wh FROM `user` WHERE id='$user_id'");
@$row = $result->fetch_assoc();
@$user_wh=$row['wh'];

$i_MAC=$_POST['i_MAC'];

    //-----------------------UPDATE mac
    $up_mac="UPDATE user SET id_mac = $i_MAC WHERE id = $user_id ";
    $mysqli->query($up_mac);

//--------------------------------------
          
    echo "<script>
    $(document).ready(function() {
       Swal.fire({
           title: 'สำเร็จ',
           text: 'อัพเดตสำเร็จ!',
           icon: 'success',
           timer: 2000,
           showConfirmButton: false
       }).then(() => {
          document.location.href = 'index.php?link=set_mac';
      });
    })
    </script>";

?>