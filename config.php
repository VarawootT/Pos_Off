<?php
date_default_timezone_set('Asia/Bangkok');
//-----------------Connect MYSQL-----------------

$mysqli = new mysqli('localhost', 'root', 'root', 'pos');
mysqli_set_charset($mysqli, 'utf8');

//-----------------Connect MYSQL Mario-----------------

// $mysqliM = new mysqli('mysql-5.5.chaiyohosting.com', 'pos01', '69K*@bChl6RaN3', 'pos', '3306');
// mysqli_set_charset($mysqliM, 'utf8');

//---------------------------------------------

$year_en = date("Y");  // 2001
$year_th = date("Y")+543; // 2564

$date_th = date('d-m-').$year_th;  //01/01/2558
$date_en_now = date('Y-m-d');  //2022-01-31

$title = 'POS';
$Copyright = "©$year_en Developer By Aerosoft";
$namepic=date("dmyHis");

?>
    <!-- 
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    favicon.ico 
    <link rel="icon" type="image/png" href="../images/favicon.png">
    -->