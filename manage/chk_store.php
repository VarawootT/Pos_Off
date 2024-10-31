<?php
session_start();
include_once("../config.php");
@$user_id=$_SESSION['id'];
@$result = $mysqli->query("SELECT wh, sta_vat, id_mac FROM `user` WHERE id='$user_id'");
@$row = $result->fetch_assoc();
@$user_wh=$row['wh'];
@$STATUS_SHOP = $_POST['status'];
@$MONEY_START = $_POST['money']; 

@$MONEY_START = str_replace(',', '', $MONEY_START);

if($STATUS_SHOP == 'SHOPSTART'){
    // $selectsumpay = $mysqli->query("SELECT `receive`,`change` FROM p_so_h WHERE wh = '$user_wh'");
    // $rowsum = $selectsumpay->fetch_assoc();
    $mysqli->query("INSERT INTO p_so_mtos (wh,money_start,money_end,userid) VALUES ('$user_wh','$MONEY_START','$MONEY_START','$user_id')");

    echo "<meta http-equiv=refresh content=0;url=index.php?like=home>";
}
else{
    echo "<meta http-equiv=refresh content=0;url=index.php?like=home>";
}
?>