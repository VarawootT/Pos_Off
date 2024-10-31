<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
include_once("config.php");
$today = date('Y-m-d');
if($_POST){

	$user=($_POST['login_admin']); 
	$pwd=($_POST['pswd_admin']);

	$id = 0;
	$qry="SELECT id FROM `user` WHERE user='$user' AND password='$pwd'";
	if($result = $mysqli->query($qry)){
		while ($row = $result->fetch_assoc()) {
			$id=$row['id'];
		}
	}
		if($id==NULL){ 
			echo "<script language='javascript'>
			alert(' Username & Password ไม่ถูกต้อง','OK')
			</script>";
			echo "<meta http-equiv=refresh content=0;url=index.php>";
		}else{ //
			$user_id=$_SESSION["id"]=$id;
			@$result = $mysqli->query("SELECT wh, sta_vat, id_mac FROM `user` WHERE id='$id'");
			@$row = $result->fetch_assoc();
			@$user_wh=$row['wh'];
			@$check_row = "";
			$check_id = "SELECT * FROM p_so_mtos WHERE wh = '$user_wh' AND userid = '$id' AND DATE(date_so) = '$today'";
			$result_ck = $mysqli->query($check_id);
			$row = $result_ck->fetch_assoc();
			@$check_row = $row['wh'];
			
			if($check_row == ""){
			echo "<meta http-equiv=refresh content=0;url=manage/set_up.php>";
			}else{
			echo "<meta http-equiv=refresh content=0;url=manage/index.php?like=home>";
			}
		}
		
}else{
	echo "เชื่อมต่อฐานข้อมูลไม่ได้ !!";
}
?>