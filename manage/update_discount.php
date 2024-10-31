<?php
session_start();
include_once "../config.php";
$sql_unit = "";
$sql_dis  = "";
$sql_id   = "";
if (isset($_GET['DIS'])) {
    $i_DIS = $_GET['DIS'];

    $sql = "SELECT id,dis, unit FROM p_dis_h WHERE id = '$i_DIS'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $sql_dis = $row['dis'];
        $sql_unit = $row['unit'];
        $sql_id = $row['id'];
    }
    if ($sql_id == "") {
        $updatedis = "UPDATE p_so_tem SET dis_d = '$sql_dis', unit_d = '$sql_unit'  WHERE pn in (SELECT pn FROM `p_dis_d` group by pn)";
        echo $updatedis;
        $mysqli->query($updatedis);
    }else if($sql_unit == "r"){
        $updatedis = "UPDATE p_so_tem SET dis_d = '$sql_id', unit_d = '$sql_unit'  WHERE pn in (SELECT pn FROM `p_dis_d` WHERE id_dis = '$sql_id' group by pn)";
        $mysqli->query($updatedis);
    }
    else {
        $updatedis = "UPDATE p_so_tem SET dis_d = '$sql_dis', unit_d = '$sql_unit'  WHERE pn in (SELECT pn FROM `p_dis_d` WHERE id_dis = '$sql_id' group by pn)";
        //echo $updatedis;
        $mysqli->query($updatedis);
    }
}
