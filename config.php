<?php
date_default_timezone_set('Asia/Bangkok');
//-----------------Connect MYSQL-----------------

$mysqli = new mysqli('localhost', 'root', 'root', 'pos');
mysqli_set_charset($mysqli, 'utf8');

//-----------------Connect MYSQL pos.summitfootwear.co.th-----------------

// $mysqliA = new mysqli('pos.summitfootwear.co.th', 'root', 'root', 'pos', '9090');
// mysqli_set_charset($mysqliA, 'utf8');

//---------------------------------------------

$year_en = date("Y");  // 2001
$year_th = date("Y")+543; // 2564

$date_th = date('d-m-').$year_th;  //01/01/2558
$date_en_now = date('Y-m-d');  //2022-01-31

$title = 'POS';
$Copyright = "©$year_en Developer By Aerosoft";
$namepic=date("dmyHis");

?>