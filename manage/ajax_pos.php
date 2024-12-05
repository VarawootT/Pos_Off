<?php
session_start();
include_once "../config.php";
date_default_timezone_set('Asia/Bangkok');
@$user_id=$_SESSION['id'];
@$result = $mysqli->query("SELECT wh, sta_vat, id_mac FROM `user` WHERE id='$user_id'");
@$row = $result->fetch_assoc();

@$user_wh=$row['wh'];
@$S_VAT=$row['sta_vat'];
@$id_mac=$row['id_mac'];


@$resultm = $mysqli->query("SELECT mac FROM mac WHERE id_mac = '$id_mac'");
@$rowm = $resultm->fetch_assoc();

@$se_mac=$rowm['mac'];

if (isset($_GET['MODE']))
{
    //------------------------------- Add
    if ($_GET['MODE'] == 'add')
    {
        $i_BAR    = $_GET['i_BAR'];
        $i_QTY    = $_GET['i_QTY'];
        $i_DIS    = $_GET['i_DIS'];
        $i_free   = $_GET['i_free'];
        $i_split   = $_GET['i_split'];
        if($i_DATE == ''){
            @$i_DATE = date('Y-m-d H:i:s');
        }
        $check = 0;
        $sql_b = "SELECT inv.pn, inv.price
        FROM `inv` LEFT OUTER JOIN
        bar ON inv.pn = bar.pn
        WHERE bar.bar = '$i_BAR' ";
        $query_b = mysqli_query($mysqli,$sql_b);
        while($rowb=mysqli_fetch_array($query_b,MYSQLI_ASSOC))
        {
            $SE_PN = $rowb['pn'];
            $SE_PRICE = $rowb['price'];
            $check = 1;
        }
        $sql_p = "SELECT pn, price FROM inv WHERE pn = '$i_BAR' ";
        //echo $sql_p;
        $query_p = mysqli_query($mysqli,$sql_p);
        while($row=mysqli_fetch_array($query_p,MYSQLI_ASSOC))
        {
            $SE_PN = $row['pn'];
            $SE_PRICE = $row['price'];
            $check = 1;
        }

        if($i_free == 0){
           
           


            $SE_ID_DIS = 0;
            $dis = "SELECT * FROM p_dis_d WHERE PN = '$SE_PN' AND id_dis ='$i_DIS'";
            //echo $dis;
            $result = $mysqli->query($dis);
            while($row_dis=$result->fetch_assoc())
            {
                $SE_ID_DIS = $row_dis['id_dis'];
            }
            if($SE_ID_DIS == '1'){
            $sql_sl = "SELECT
             p_so_tem.id,
             p_so_tem.pn,
             p_so_tem.qty,
             p_so_tem.price,
             p_so_tem.dis_d,
             p_so_tem.unit_d
             FROM p_so_tem 
             INNER JOIN bar ON p_so_tem.pn = bar.pn 
             WHERE p_so_tem.dis_d = '50' AND unit_d = '%' AND ( p_so_tem.pn = '$i_BAR' OR bar.bar = '$i_BAR') AND p_so_tem.free_s IS NULL AND p_so_tem.split = '0'";
             }else if($SE_ID_DIS == '2'){
                $sql_sl = "SELECT
                p_so_tem.id,
                p_so_tem.pn,
                p_so_tem.qty,
                p_so_tem.price,
                p_so_tem.dis_d,
                p_so_tem.unit_d
                FROM p_so_tem 
                INNER JOIN bar ON p_so_tem.pn = bar.pn 
                WHERE  p_so_tem.dis_d = '10' AND unit_d = '฿' AND(p_so_tem.pn = '$i_BAR' OR bar.bar = '$i_BAR') AND p_so_tem.free_s IS NULL AND p_so_tem.split = '0'";
             }else{
                $sql_sl = "SELECT
                p_so_tem.id,
                p_so_tem.pn,
                p_so_tem.qty,
                p_so_tem.price,
                p_so_tem.dis_d,
                p_so_tem.unit_d
                FROM p_so_tem 
                INNER JOIN bar ON p_so_tem.pn = bar.pn 
                WHERE p_so_tem.dis_d = '' AND p_so_tem.dis_d = '0' AND ( p_so_tem.pn = '$i_BAR' OR bar.bar = '$i_BAR') AND p_so_tem.free_s IS NULL AND p_so_tem.free_s IS NULL AND p_so_tem.split = '0'";
             }
            echo $sql_sl;
            $query_sl = mysqli_query($mysqli,$sql_sl);
            // echo $i_split;
            $rowsl=mysqli_fetch_array($query_sl,MYSQLI_ASSOC);
            if($rowsl && $i_split !== "1")
            {
                $row_qty = $rowsl['qty'];
                $row_price = $rowsl['price'];
                $is_QTY = $row_qty+$i_QTY;
                if($SE_ID_DIS == '1'){
                $i_pw = "UPDATE p_so_tem SET qty = '$is_QTY', price = '$SE_PRICE', iduser = '$user_id', wh = '$user_wh' WHERE pn = '$SE_PN' AND dis_d = '50' AND unit_d = '%' AND p_so_tem.free_s IS NULL AND p_so_tem.split = '0'";
                }
                else if($SE_ID_DIS == '2'){
                //$SE_PRICE = $SE_PRICE-10;
                $i_pw = "UPDATE p_so_tem SET qty = '$is_QTY', price = '$SE_PRICE', iduser = '$user_id', wh = '$user_wh' WHERE pn = '$SE_PN' AND dis_d = '10' AND unit_d ='฿' AND p_so_tem.free_s IS NULL AND p_so_tem.split = '0'";
                }
                else{
                $i_pw = "UPDATE p_so_tem SET qty = '$is_QTY', price = '$SE_PRICE', iduser = '$user_id', wh = '$user_wh' WHERE pn = '$SE_PN' AND dis_d = '' AND dis_d = '0' AND p_so_tem.free_s IS NULL AND p_so_tem.split = '0'";
                }
                echo "$i_pw";
                $mysqli->query($i_pw);
            }elseif($check == '1') {
                $SE_ID_DIS = 0;
                $dis = "SELECT * FROM p_dis_d WHERE PN = '$SE_PN' AND id_dis ='$i_DIS'";
                //echo $dis;
                $result = $mysqli->query($dis);
                while($row_dis=$result->fetch_assoc())
                {
                    $SE_ID_DIS = $row_dis['id_dis'];
                }

                //echo $SE_ID_DIS;
                if($SE_ID_DIS == '1'){

                    $i_pw="INSERT INTO p_so_tem (pn, qty, price,dis_d,unit_d,iduser, wh, split)";
                    $i_pw.="VALUES ('$SE_PN','$i_QTY','$SE_PRICE','50','%','$user_id','$user_wh','$i_split')";
                    //echo "$i_pw";
                    $mysqli->query($i_pw);
                }
                else if($SE_ID_DIS == '2'){
                    $i_pw="INSERT INTO p_so_tem (pn, qty, price,dis_d, iduser, wh, split)";
                    $i_pw.="VALUES ('$SE_PN','$i_QTY','$SE_PRICE','10','$user_id','$user_wh','$i_split')";
                    //echo "$i_pw";
                    $mysqli->query($i_pw);
                }else{
                //-----------------------INSERT p_so_tem
                $i_pw="INSERT INTO p_so_tem (pn, qty, price, iduser, wh, split)";
                $i_pw.="VALUES ('$SE_PN','$i_QTY','$SE_PRICE','$user_id','$user_wh','$i_split')";
                echo "$i_pw";
                $mysqli->query($i_pw);
                }
            }

            if($check == 0){
                echo "|1";
            }
    }else{
        $sql_fr = "SELECT
                p_so_tem.id,
                p_so_tem.pn,
                p_so_tem.qty,
                p_so_tem.price,
                p_so_tem.dis_d,
                p_so_tem.unit_d
                FROM p_so_tem 
                INNER JOIN bar ON p_so_tem.pn = bar.pn
                WHERE ( p_so_tem.pn = '$i_BAR' OR bar.bar = '$i_BAR') AND p_so_tem.free_s = '1' ";
                $query_fr = mysqli_query($mysqli,$sql_fr);
                if($rowfr=mysqli_fetch_array($query_fr,MYSQLI_ASSOC)){
                    $row_qty = $rowfr['qty'];
                    $is_QTY = $row_qty+$i_QTY;
                    $i_fr = "UPDATE p_so_tem SET qty = '$is_QTY', iduser = '$user_id', wh = '$user_wh' WHERE pn = '$SE_PN' AND p_so_tem.free_s = '1'";

                    $mysqli->query($i_fr);
                }else{
                    $free = "INSERT INTO p_so_tem (pn, qty, price, iduser, wh, free_s)";
                    $free.= "VALUES ('$SE_PN','$i_QTY','0','$user_id','$user_wh','$i_free')";
                    echo $free;
                    $mysqli->query($free);
                }

    }
}

    //------------------------------- Delete
    if ($_GET['MODE'] == 'delete')
    {
        $u_ID       = $_GET['id'];

        $d_sql = "DELETE FROM p_so_tem WHERE id = $u_ID ";
        $mysqli->query($d_sql);
    }

    //------------------------------- Edit
    if ($_GET['MODE'] == 'edit')
    {
        $u_ID       = $_GET['id'];
        $t_price       = $_GET['t_price'];
        $t_qty       = $_GET['t_qty'];
        $t_dis       = $_GET['t_dis'];
        $t_unit       = $_GET['t_unit'];
        $t_note       = $_GET['t_note'];
        $t_price = preg_replace('/[^0-9.]/', '', $t_price);
        $u_sql = "UPDATE `p_so_tem` SET `qty` = '$t_qty', `price` = '$t_price', `dis_d` = '$t_dis', `unit_d` = '$t_unit' ,`note` = '$t_note'  WHERE `id` = $u_ID ";
        $mysqli->query($u_sql);
    }

    //------------------------------- Dis H
    if ($_GET['MODE'] == 'dis')
    {
        $dis_h       = $_GET['dis_h'];
        $dis_h_type       = $_GET['dis_h_type'];

        $dis_sql = "UPDATE `p_so_tem` SET `dis_h` = '$dis_h', `unit_h` = '$dis_h_type' ";
        $mysqli->query($dis_sql);
    }

    //------------------------------- Cancel
    if ($_GET['MODE'] == 'cancel')
    {
        $c_sql = "DELETE FROM p_so_tem WHERE iduser = '$user_id' ";
        echo $c_sql;
        $mysqli->query($c_sql);
    }

    //------------------------------- Pause
    if ($_GET['MODE'] == 'pause')
    {
        $u_NOTE      = $_GET['i_NOTE'];

        $SE_NO = 1;
        $sql_p = "SELECT MAX(no) AS no FROM p_so_pause_h ";
        $query_p = mysqli_query($mysqli,$sql_p);
        while($row=mysqli_fetch_array($query_p,MYSQLI_ASSOC))
        {
            $SE_NO = $row['no'];
        }

        $IN_NO = $SE_NO+1;

        $sql_p = "SELECT pn, price,qty FROM p_so_tem WHERE iduser = '$user_id' ";
        $query_p = mysqli_query($mysqli,$sql_p);
        while($row=mysqli_fetch_array($query_p,MYSQLI_ASSOC))
        {
            $SE_PN = $row['pn'];
            $SE_QTY = $row['qty'];
            $SE_PRICE = $row['price'];
            $SE_DIS = $row['discount'];
            $SE_USER = $row['iduser'];
            $SE_WH = $row['wh'];
            					
            $i_pw="INSERT INTO p_so_pause_d (no, pn, qty, price, discount, iduser, wh)";
            $i_pw.="VALUES ('$IN_NO','$SE_PN','$SE_QTY','$SE_PRICE','$i_DIS','$user_id','$user_wh')";
            $mysqli->query($i_pw);
        }

        $i_h="INSERT INTO p_so_pause_h (no, name)";
        $i_h.="VALUES ('$IN_NO','$u_NOTE')";
        $mysqli->query($i_h);

        $d_sql = "DELETE FROM p_so_tem WHERE iduser = '$user_id' ";
        $mysqli->query($d_sql);
    }
    // ----------------------------comeback
    if ($_GET['MODE'] == 'comeback')
    {
        $u_NOTE = $_GET['i_NOTE'];

        $c_back = "INSERT INTO p_so_tem (iduser, pn, qty, price, wh) SELECT iduser, pn, qty, price, wh FROM p_so_pause_d WHERE no = '$u_NOTE'";
        echo $c_back;
        $mysqli->query($c_back);

        $d_sql1 = "DELETE FROM p_so_pause_h WHERE no = '$u_NOTE' ";
        $mysqli->query($d_sql1);

        $d_sql2 = "DELETE FROM p_so_pause_d WHERE no = '$u_NOTE' ";
        $mysqli->query($d_sql2);

    }
//------------------------------- Print
if ($_GET['MODE'] == 'print')
{
    @$i_DATE = $_GET['i_DATE'];
    @$i_QTY = $_GET['i_QTY'];
    @$r_QTY = $_GET['rshow'];
    @$i_PAY = $_GET['pay'];
    @$i_NOTE = $_GET['i_NOTE'];

    if($i_DATE == ''){
        $i_DATE = date("Y-m-d H:i:s");
    }

    $SE_RUN = 0;
    $SE_YEAR_S = '';
    $SE_MONTH_S = '';
    $SE_QTY_P = 0;
    $SQL_YEAR_S = '';
    $SQL_MONTH_S = '';
    $SQL_DAY_S = '';

    $SE_YEAR_N = date("Y")+543;
    $SE_MONTH_N = date("m");
    $SE_DAY_N = date("d");
    if($i_DATE != ''){
        $date = new DateTime($i_DATE);
        $SO_DATE = $date->format('Y-m-d');
        //echo $SO_DATE; // ผลลัพธ์: 2024-04-19
        
        $SO_Y = $date->format('Y');
        $SO_Y += 543;
        //echo $SO_Y; // ผลลัพธ์: 2567
        
        $SO_M = $date->format('m');
        //echo $SO_M; // ผลลัพธ์: 04
        
        $SO_D = $date->format('d');
        //echo $SO_D; // ผลลัพธ์: 19

        $sql_h = "SELECT run, year, month , day FROM p_so_h where DATE_FORMAT(date_so,'%Y-%m-%d') = '$SO_DATE' ORDER BY id DESC LIMIT 1 ";
        //echo $sql_h;
        $query_h = mysqli_query($mysqli,$sql_h);
        while($rowh=mysqli_fetch_array($query_h,MYSQLI_ASSOC))
        {
            $SE_RUN = $rowh['run'];
            $SQL_YEAR_S = $rowh['year'];
            $SQL_MONTH_S = $rowh['month'];
            $SQL_DAY_S = $rowh['day'];
        }
        if($SQL_YEAR_S == '' || $SQL_MONTH_S =='' || $SQL_DAY_S == ''){
            $RUN_INT = sprintf('%04d', $SE_RUN + 1);
            $YEAR_INT = $SO_Y;
            $DAY_INT = $SO_D;
            $MONTH_INT = $SO_M;
            $YEAR_CUT = substr($YEAR_INT,-2);
        }
        elseif($SE_RUN == 0){
            //echo "--ปี-เดือนเริ่มต้น--<br>";
            $RUN_INT = sprintf('%04d', $SE_RUN + 1);
            $YEAR_INT = $SQL_YEAR_S;
            $DAY_INT = $SQL_DAY_S;
            $MONTH_INT = $SQL_MONTH_S;
            $YEAR_CUT = substr($YEAR_INT,-2);
        }else{
            //echo "--ปี-เดือนเก่าถัดไป--<br>";
            $RUN_INT = sprintf('%04d', $SE_RUN + 1);
            $YEAR_INT = $SQL_YEAR_S;
            $DAY_INT = $SQL_DAY_S;
            $MONTH_INT = $SQL_MONTH_S;
            $YEAR_CUT = substr($YEAR_INT,-2);
        }
    }
    else{
    $sql_h = "SELECT run, year, month , day FROM p_so_h ORDER BY id DESC LIMIT 1 ";
    $query_h = mysqli_query($mysqli,$sql_h);
    while($rowh=mysqli_fetch_array($query_h,MYSQLI_ASSOC))
    {
        $SE_RUN = $rowh['run'];
        $SE_YEAR_S = $rowh['year'];
        $SE_MONTH_S = $rowh['month'];
        $SE_DAY_S = $rowh['day'];
        //$SE_Data_so = $rowh['day'];
    }
    echo "DAY_S =".  $SE_DAY_S. "DAY_N =" . $SE_DAY_N ;
    if($SE_YEAR_S == $SE_YEAR_N && $SE_MONTH_S == $SE_MONTH_N && $SE_DAY_S == $SE_DAY_N){
        //echo "--ปี-เดือนเก่า--<br>";
        $RUN_INT = sprintf('%04d', $SE_RUN + 1);
        $YEAR_INT = $SE_YEAR_S;
        $DAY_INT = sprintf('%02d', $SE_DAY_N);
        //$MONTH_INT = $SE_MONTH_S;
        $MONTH_INT = sprintf('%02d', $SE_MONTH_S);
        $YEAR_CUT = substr($YEAR_INT,-2);
    }elseif($SE_YEAR_S != $SE_YEAR_N && $SE_MONTH_S != $SE_MONTH_N && $SE_DAY_S != $SE_DAY_N || $SE_YEAR_S == $SE_YEAR_N && $SE_MONTH_S != $SE_MONTH_N && $SE_DAY_S != $SE_DAY_N ||$SE_YEAR_S == $SE_YEAR_N && $SE_MONTH_S == $SE_MONTH_N && $SE_DAY_S != $SE_DAY_N ){
        //echo "--ปี-เดือนใหม่--<br>";
        $RUN_INT = sprintf('%04d', 1);
        $YEAR_INT = $SE_YEAR_N;
        $DAY_INT = sprintf('%02d', $SE_DAY_N);
        $MONTH_INT = sprintf('%02d', $SE_MONTH_N);
        $YEAR_CUT = substr($YEAR_INT,-2);
    }
    elseif($SE_RUN == 0){
        //echo "--ปี-เดือนเริ่มต้น--<br>";
        $RUN_INT = sprintf('%04d', $SE_RUN + 1);
        $YEAR_INT = $SE_YEAR_N;
        $DAY_INT = sprintf('%02d', $SE_DAY_N);
        $MONTH_INT = sprintf('%02d', $SE_MONTH_N);
        $YEAR_CUT = substr($YEAR_INT,-2);
    }else{
        //echo "--ปี-เดือนเก่าถัดไป--<br>";
        $RUN_INT = sprintf('%04d', $SE_RUN + 1);
        $YEAR_INT = $SE_YEAR_N;
        $DAY_INT = sprintf('%02d', $SE_DAY_N);
        $MONTH_INT = sprintf('%02d', $SE_MONTH_S);
        $YEAR_CUT = substr($YEAR_INT,-2);
    }
}
    $SO_INT="$YEAR_CUT$MONTH_INT$DAY_INT$RUN_INT";

    $SE_DIS_D = 0;
    //-----------------------INSERT p_so_d
    $s_tem="SELECT pn, price, dis_d, unit_d, dis_h, unit_h, SUM(qty) AS qty, note, free_s FROM p_so_tem GROUP BY pn, price, dis_d, unit_d, dis_h, unit_h, free_s ORDER BY id DESC ";
    echo $s_tem;
    if($re_tem = $mysqli->query($s_tem)){
        while ($row_tem = $re_tem->fetch_assoc()) {
            $SE_PN = $row_tem['pn'];
            $SE_QTY = $row_tem['qty'];
            $SE_PRICE = $row_tem['price'];
            $SE_DIS_D = $row_tem['dis_d'];
            $SE_UNIT_D = $row_tem['unit_d'];
            $SE_DIS_H = $row_tem['dis_h'];
            $SE_UNIT_H = $row_tem['unit_h'];
            $SE_NOTE = $row_tem['note'];
            $SE_FREE = $row_tem['free_s'];
            //echo $SE_PRICE;
            if ($SE_UNIT_D == '%') {
                $DISCOUNT_BATH = ($SE_PRICE * $SE_DIS_D) / 100;
                $NET = ($SE_PRICE * $SE_QTY) - $DISCOUNT_BATH * $SE_QTY;
                $B_DISCOUNT = $DISCOUNT_BATH * $SE_QTY;
            }else if ($SE_UNIT_D == 'r') {
                $SQL_CH_PRICE = "SELECT price FROM `p_dis_d` WHERE pn = '$SE_PN' AND  id_dis = '$SE_DIS_D'";
                $result_ch = $mysqli->query($SQL_CH_PRICE);
                $row_ch = $result_ch->fetch_assoc();
                @$SE_PRICE = $row_ch['price'];
                $SQL_CK_ID = "SELECT name FROM `p_dis_h` WHERE id = '$SE_DIS_D'";
                $result_hch = $mysqli->query($SQL_CK_ID);
                $row_ch = $result_hch->fetch_assoc();
                @$SE_DIS_NAME = $row_ch['name'];
                $NET = ($SE_PRICE * $SE_QTY);
            } else {
                $B_DISCOUNT = $SE_DIS_D;
                $NET = ($SE_PRICE * $SE_QTY) - $SE_DIS_D;
               
            }

            
            $NET = number_format($NET,2);
            $NET = str_replace(',', '', $NET);;
            $NET = (float)$NET;
           
            @$SUM_NET += $NET;
            
            @$SUM_PRICE += $SE_PRICE;
            @$SUM_B_DISCOUNT += $B_DISCOUNT;
            if($SE_FREE == ""){
            $i_sd="INSERT INTO p_so_d (so, pn, qty, price, dis_d, unit_d, net, note)";
            $i_sd.="VALUES ('$SO_INT','$SE_PN','$SE_QTY','$SE_PRICE','$SE_DIS_D','$SE_UNIT_D','$NET','$SE_NOTE')";
            }else{
            $i_sd="INSERT INTO p_so_d (so, pn, qty, price, dis_d, unit_d, net, note, free)";
            $i_sd.="VALUES ('$SO_INT','$SE_PN','$SE_QTY','$SE_PRICE','$SE_DIS_D','$SE_UNIT_D','$NET','$SE_NOTE','$SE_FREE')";
            }
            $mysqli->query($i_sd);

        }
        $SE_QTY_P = preg_replace('/[^0-9.]/', '', $i_QTY);

        if($i_PAY == "cash"){
            
            $SE_QTY_R = preg_replace('/[^0-9.]/', '', $r_QTY);
            
            $SUMPR = $SE_QTY_P - $SE_QTY_R;
        }
            // $SUM_NET = (float)$SUM_NET;
            // echo $SUM_NET;
            $VAT = ($SUM_NET * 7) / 107;
            $BVAT = $SUM_NET - $VAT;
            //
    //-----------------------INSERT p_so_h
        $i_pw="INSERT INTO p_so_h (so, date_so, wh, year, month,day,run, iduser, receive, pay, dis_h, unit_h, note, gross_price, discount, vat, b_vat, mac, `Change`)";
        $i_pw.="VALUES ('$SO_INT','$i_DATE','$user_wh','$YEAR_INT','$MONTH_INT','$DAY_INT','$RUN_INT','$user_id','$SE_QTY_P','$i_PAY','$SE_DIS_H','$SE_UNIT_H','$i_NOTE','$SUM_PRICE','$SUM_B_DISCOUNT','$VAT','$BVAT','$se_mac','$SE_QTY_R')";
        echo $i_pw;
        $mysqli->query($i_pw);
    }
    if($i_PAY == "cash"){
        $today = date('Y-m-d');
        $MONEY_UPDATE = "UPDATE p_so_mtos SET money_end = money_end + $SUMPR WHERE wh = '$user_wh' AND DATE(date_so) = '$today' AND userid = '$user_id'";
        //echo $MONEY_UPDATE;
        $mysqli->query($MONEY_UPDATE);
    }
    //------------------------------- Delete Tem
        $d_st="TRUNCATE p_so_tem ";
        $mysqli->query($d_st);
    }
}