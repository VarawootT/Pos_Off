<?php
session_start();
include_once("config.php");

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
			echo "<meta http-equiv=refresh content=0;url=manage/index.php?like=home>";
		}
		
}else{
	echo "เชื่อมต่อฐานข้อมูลไม่ได้ !!";
}
?>