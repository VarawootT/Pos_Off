<?php
session_start();
include_once "../config.php";

if (isset($_GET['MODE']))
{
    //------------------------------- Cancel
    if ($_GET['MODE'] == 'cancel')
    {
        @$SE_ID = $_GET['id'];
        @$SE_NOTE = $_GET['Note'];

        $c_sql = "UPDATE p_so_h SET sta = 1, note = '$SE_NOTE'  WHERE so = '$SE_ID' ";
        $mysqli->query($c_sql);

        $sel_sql = "SELECT receive,date(date_so) as date_so,wh FROM p_so_h WHERE so = '$SE_ID'";
        $result = $mysqli->query($sel_sql);
        $rowsql = $result->fetch_assoc();
        $SET_DATE = $rowsql['date_so'];
        $SET_RECEIVE = $rowsql['receive'];
        $SET_WH = $rowsql['wh'];

        $s_sql = "UPDATE p_so_mtos SET money_end = money_end - $SET_RECEIVE WHERE date(date_so) = '$SET_DATE' AND wh = '$SET_WH'";
        $mysqli->query($s_sql);
    }
}