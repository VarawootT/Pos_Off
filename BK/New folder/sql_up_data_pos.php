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

//$serverName = '192.168.0.14';
$serverName = '110.164.127.170';
$userName = 'Aero';
$userPassword = '1stLogin';
$dbName = 'db_Aerosoft_ERP';

$connectionString = "sqlsrv:Server=$serverName;Database=$dbName;Encrypt=no;TrustServerCertificate=yes;";

try {
    $conn = new PDO($connectionString, $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connection successful!";
} catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
}

@$user_id=$_SESSION['id'];

@$result = $mysqli->query("SELECT wh FROM `user` WHERE id='$user_id'");
@$row = $result->fetch_assoc();
@$user_wh=$row['wh'];

$sta=$_GET['sta'];

if($sta == 'wh' || $sta == 'all'){
    //--------------------------------------P_WH
    //echo "WH";
    //-----------------------Del p_wh
    $d_pw="TRUNCATE TABLE p_wh ";
    $mysqli->query($d_pw);

    $s_pack = "SELECT ID, WH, NAME_WH, ID_WH, ID_WH2, NAME_BILL FROM P_WH WHERE STA = '1' ";
    //echo "$s_pack";
    $res_pack = $conn->prepare($s_pack);
    $res_pack->execute();
    while($row_pack = $res_pack->fetch( PDO::FETCH_ASSOC ))
    {
        $SE_ID = $row_pack['ID'];
        $SE_WH = $row_pack['WH'];
        $SE_NAME_WH = $row_pack['NAME_WH'];
        $SE_ID_WH = $row_pack['ID_WH'];
        $SE_ID_WH2 = $row_pack['ID_WH2'];
        $SE_NAME_BILL = $row_pack['NAME_BILL'];
        
        //-----------------------INSERT p_wh
        $i_pw="INSERT INTO p_wh (id, wh, name_wh, id_wh, id_wh2, name_bill)";
        $i_pw.="VALUES ('$SE_ID','$SE_WH','$SE_NAME_WH','$SE_ID_WH','$SE_ID_WH2','$SE_NAME_BILL') ";
        //echo "$i_pw";
        $mysqli->query($i_pw);
    }
}

//--------------------------------------

if($sta == 'inv' || $sta == 'all'){
//--------------------------------------INV

    //-----------------------Del inv
    $d_inv="TRUNCATE TABLE inv ";
    $mysqli->query($d_inv);

    $s_inv = "SELECT ID, PN, NAMEP, TYPE, PRICE FROM INV WHERE P = '1' ";
    $res_inv = $conn->prepare($s_inv);
    $res_inv->execute();
    while($row_inv = $res_inv->fetch( PDO::FETCH_ASSOC ))
    {
        $SE_ID = $row_inv['ID'];
        $SE_PN = $row_inv['PN'];
        $SE_NAMEP = $row_inv['NAMEP'];
        $SE_TYPE = $row_inv['TYPE'];
        $SE_PRICE = $row_inv['PRICE'];

    //-----------------------INSERT inv
    $i_inv="INSERT INTO inv (id, pn, namep, type, price) ";
    $i_inv.="VALUES ('$SE_ID','$SE_PN','$SE_NAMEP','$SE_TYPE','$SE_PRICE') ";
    $mysqli->query($i_inv);

    }
}

//--------------------------------------

if($sta == 'bar' || $sta == 'all'){
//--------------------------------------BAR

    //-----------------------Del bar
    $d_bar="TRUNCATE TABLE bar ";
    $mysqli->query($d_bar);

    $s_bar = "SELECT ID, PN, BARCODE FROM V_P_BAR ";
    $res_bar = $conn->prepare($s_bar);
    $res_bar->execute();
    while($row_bar = $res_bar->fetch( PDO::FETCH_ASSOC ))
    {
        $SE_ID = $row_bar['ID'];
        $SE_PN = $row_bar['PN'];
        $SE_BARCODE = $row_bar['BARCODE'];

    //-----------------------INSERT bar
    $i_bar="INSERT INTO bar (id, pn, bar) ";
    $i_bar.="VALUES ('$SE_ID','$SE_PN','$SE_BARCODE') ";
    $mysqli->query($i_bar);

    }
}

//--------------------------------------

if($sta == 'dis' || $sta == 'all'){
//--------------------------------------DIS

//-----------------------Del p_dis_h
    $d_dis_h="TRUNCATE TABLE p_dis_h ";
    $mysqli->query($d_dis_h);

    $s_dish = "SELECT NAME, DIS, UNIT FROM P_DIS_H ";
    $res_dish = $conn->prepare($s_dish);
    $res_dish->execute();
    while($row_dish = $res_dish->fetch( PDO::FETCH_ASSOC ))
    {
        $SE_NAME = $row_dish['NAME'];
        $SE_DIS = $row_dish['DIS'];
        $SE_UNIT = $row_dish['UNIT'];

    //-----------------------INSERT p_dis_h
    $i_dis_h="INSERT INTO p_dis_h (name, dis, unit) ";
    $i_dis_h.="VALUES ('$SE_NAME','$SE_DIS','$SE_UNIT') ";
    $mysqli->query($i_dis_h);

    }

//-----------------------Del p_dis_d
    $d_dis_d="TRUNCATE TABLE p_dis_d ";
    $mysqli->query($d_dis_d);

    $s_disd = "SELECT ID_DIS, PN FROM P_DIS_D ";
    $res_disd = $conn->prepare($s_disd);
    $res_disd->execute();
    while($row_disd = $res_disd->fetch( PDO::FETCH_ASSOC ))
    {
        $SE_ID_DIS = $row_disd['ID_DIS'];
        $SE_PN = $row_disd['PN'];

    //-----------------------INSERT p_dis_d
    $i_dis_d="INSERT INTO p_dis_d (id_dis, pn) ";
    $i_dis_d.="VALUES ('$SE_ID_DIS','$SE_PN') ";
    $mysqli->query($i_dis_d);

    }

}

//--------------------------------------

if($sta == 'user' || $sta == 'all'){
    //--------------------------------------User

    //-----------------------Del user
    $d_user="TRUNCATE TABLE user ";
    $mysqli->query($d_user);

    $s_user = "SELECT * FROM P_USER ";
    $res_user = $conn->prepare($s_user);
    $res_user->execute();
    while($row_user = $res_user->fetch( PDO::FETCH_ASSOC ))
    {
        $SE_U_ID = $row_user['U_ID'];
        $SE_U_USER = $row_user['U_USER'];
        $SE_U_PWD = $row_user['U_PWD'];
        $SE_U_NAME = $row_user['U_NAME'];
        $SE_U_LNAME = $row_user['U_LNAME'];
        $SE_U_WH = $row_user['U_WH'];
        $SE_U_GROUP = $row_user['U_GROUP'];
        $SE_U_TEAM = $row_user['U_TEAM'];
        $SE_U_NICKNAME = $row_user['U_NICKNAME'];
        $SE_STA_VAT = $row_user['STA_VAT'];
        $SE_ID_MAC = $row_user['ID_MAC'];

    //-----------------------INSERT user
    $i_user="INSERT INTO `user` (`id`, `user`, `password`, `name`, `lname`, `wh`, `group_menu`, `team`, `nickname`, `sta_vat`, `id_mac`) ";
    $i_user.="VALUES ('$SE_U_ID', '$SE_U_USER', '$SE_U_PWD', '$SE_U_NAME', '$SE_U_LNAME', '$SE_U_WH', '$SE_U_GROUP', '$SE_U_TEAM', '$SE_U_NICKNAME', '$SE_STA_VAT', '$SE_ID_MAC') ";
    $mysqli->query($i_user);

    }

}

//--------------------------------------

if($sta == 'sale' || $sta == 'all'){  // UPDATE SALE

    //--------------------------------------SELECT Sale
    $s_sal = "SELECT * FROM p_so_d WHERE trans = 0 ";
    if ($re_sal = $mysqli->query($s_sal)) {
        while ($sal = $re_sal->fetch_assoc()) {
            $SE_ID = $sal['id'];
            $SE_SO = $sal['so'];
            $SE_PN = $sal['pn'];
            $SE_QTY = $sal['qty'];
            $SE_PRICE = $sal['price'];
            $SE_DIS_D = $sal['dis_d'];
            $SE_UNIT_D = $sal['unit_d'];
            $SE_NET = $sal['net'];
            $SE_FREE = $sal['free'];
            $SE_NOTE = $sal['NOTE'];

    //-----------------------INSERT P_SO_D
    $sqld="INSERT INTO P_SO_D (REF_ID, SO, PN, QTY, PRICE, DIS_D, UNIT_D, NET, FREE, NOTE) ";
    $sqld.="VALUES ('$SE_ID','$SE_SO','$SE_PN','$SE_QTY','$SE_PRICE','$SE_DIS_D','$SE_UNIT_D','$SE_NET','$SE_FREE','$SE_NOTE') ";
    $conn->exec($sqld);
   

    //-----------------------UPDATE p_so_d
    $i_sal="UPDATE p_so_d SET trans = 1 WHERE id = '$SE_ID' ";
    $mysqli->query($i_sal);

    }
        }

    //-----------------------------------

    $s_salh = "SELECT * FROM p_so_h WHERE trans_h = 0 ";
    if ($re_salh = $mysqli->query($s_salh)) {
        while ($salh = $re_salh->fetch_assoc()) {
            $SE_ID = $salh['id'];
            $SE_SO = $salh['so'];
            $SE_DATE_SO = $salh['date_so'];
            $SE_WH = $salh['wh'];
            $SE_GROSS_PRICE = $salh['gross_price'];
            $SE_DISCOUNT = $salh['discount'];
            $SE_VAT = $salh['vat'];
            $SE_B_VAT = $salh['b_vat'];
            $SE_RECEIVE = $salh['receive'];
            $SE_PAY = $salh['pay'];
            $SE_DIS_H = $salh['dis_h'];
            $SE_UNIT_H = $salh['unit_h'];
            $SE_YEAR = $salh['year'];
            $SE_MONTH = $salh['month'];
            $SE_DAY = $salh['day'];
            $SE_RUN = $salh['run'];
            $SE_IDUSER = $salh['iduser'];
            $SE_NOTE = $salh['note'];
            $SE_STA = $salh['sta'];
            $SE_MAC = $salh['mac'];
            $SE_DATE_MIDI = $salh['date_modi'];

    //-----------------------INSERT P_SO_H
    $sql="INSERT INTO P_SO_H (REF_ID, SO, DATE_SO, BRANCH, GROSS_PRICE, DISCOUNT, VAT, B_VAT, RECEIVE, PAY, DIS_H, UNIT_H, YEAR_S, MONTH_S, DAY, RUN, IDUSER, NOTE,	STA, MAC) ";
    $sql.="VALUES ('$SE_ID','$SE_SO','$SE_DATE_SO','$SE_WH','$SE_GROSS_PRICE','$SE_DISCOUNT','$SE_VAT','$SE_B_VAT','$SE_RECEIVE','$SE_PAY','$SE_DIS_H','$SE_UNIT_H','$SE_YEAR','$SE_MONTH','$SE_DAY','$SE_RUN','$SE_IDUSER','$SE_NOTE','$SE_STA','$SE_MAC') ";
    //echo "---$sql---<br>";
    $conn->exec($sql);

    //-----------------------UPDATE p_so_d
    $i_sal="UPDATE p_so_h SET trans_h = 1 WHERE id = '$SE_ID' ";
    $mysqli->query($i_sal);

        }
    }

}

if($sta == 'mac' || $sta == 'all'){ // อัพเดจ MAC time 20241022
    $mac_user="TRUNCATE TABLE mac ";
    //$mysqli->query($mac_user);

    $mac_select = "SELECT * FROM P_MAC";
    $res_mac = $conn->prepare($mac_select);
    $res_mac->execute();
    while($row_mac = $res_mac->fetch(PDO::FETCH_ASSOC))
    {
        $SE_MAC_ID   = $row_mac['ID'];
        $SE_MAC_NAME = $row_mac['MAC'];

        $sql_mac = "INSERT INTO mac (id_mac,mac)";
        $sql_mac.= "VALUES('$SE_MAC_ID','$SE_MAC_NAME')";
        // echo $sql_mac;
        $mysqli->query($sql_mac);
    }

}

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
          document.location.href = 'index.php?link=frm_up_data_pos';
      });
    })
    </script>";
?>