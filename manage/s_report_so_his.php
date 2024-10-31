<style>
    .small-box {
        height: 165px;
        /* ปรับความสูงของกล่องตามที่ต้องการ */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .small-box .inner {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        /* text-align: center; */
    }



    .icon.large-icon i {
        font-size: 92px !important;
        top: 10px !important;
        color: white;
        /* White color for icons */
        z-index: 0;
    }

    .icon.white-larg i {
        font-size: 76px !important;
        color: black;
        /* White color for icons */
        z-index: 0;
    }

    .icon.white-icon i {
        color: white;
        /* White color for icons */
        z-index: 0;
    }

    .icon.black-icon i {
        color: black;
        /* Black color for icons */
        z-index: 0;
    }

    .bgblue {
        background-color: #b3e5fc;

    }
    .bgsblue {
        background-color: #4682B4;

    }

</style>
<?php
$i_USER   = "";
$SE_USER  = "";
$SE_USERH = "";
$SE_USERS = "";
@$i_DATE1 = $_POST['i_DATE1'];
@$i_DATE2 = $_POST['i_DATE2'];
@$i_USER   = $_POST['user_s'];
@$wh      = $_POST['user_sale'];
//echo $i_USER;
if (isset($_GET['r_DATE1'])) {
    @$i_DATE1 = $_GET['r_DATE1'];
    @$i_DATE2 = $_GET['r_DATE2'];
}
if($wh != "")
{
    $SE_WH = "AND wh = '$wh'";
}
if($i_USER != "")
{
    $SE_USER =  "AND h.IDUSER = '$i_USER'";
    $SE_USERS = "AND userid = '$i_USER'";
    $SE_USERH = "AND IDUSER = '$i_USER'";
}

$CReceived       = 0;
$CIssued         = 0;
$CTransfer       = 0;
$CReStock        = 0;
$SUM_R           = 0;
$SUM_T           = 0;
$SUM_I           = 0;
$sumpayall       = 0;
$sumqtyall       = 0;
$stacount        = 0;
$stasum          = 0;
$sta0count       = 0;
$sta0sum         = 0;
$money_s         = 0;
$money_e         = 0;
$SUM_Change      = 0;
// $countUseByDate  = "SELECT count(ID) as countType, TYPE  FROM PO_HIS WHERE CONVERT(date, DATE_MODI) = '" . date('Y-m-d') . "' group by TYPE";
// //echo $countUseByDate;
// $resultUseByDate = $conn->prepare($countUseByDate);
// $resultUseByDate->execute();
// while ($rcud = $resultUseByDate->fetch(PDO::FETCH_ASSOC)) {
//     if ($rcud['TYPE'] == "IN") {
//         $CReceived = $rcud['countType'];
//     }
//     if ($rcud['TYPE'] == "OU") {
//         $CIssued = $rcud['countType'];
//     }
//     if ($rcud['TYPE'] == "DT") {
//         $CTransfer = $rcud['countType'];
//         $CTransfer = $CTransfer/2;
//     }
// }
// 
//echo "SELECT SUM(money_start) AS money_start,SUM(money_end) as money_end,wh,userid FROM `p_so_mtos` WHERE date(date_so) BETWEEN '$i_DATE1' AND '$i_DATE2' $SE_USERS $SE_WH GROUP BY wh,userid ";
@$resultstart = $mysqli->query("SELECT SUM(money_start) AS money_start,SUM(money_end) as money_end,wh,userid FROM `p_so_mtos` WHERE date(date_so) BETWEEN '$i_DATE1' AND '$i_DATE2' $SE_USERS $SE_WH GROUP BY wh,userid ");
while($row_start = $resultstart->fetch_assoc()){
    $money_s = $row_start['money_start'];
    $money_e = $row_start['money_end'];
}

@$result = $mysqli->query("SELECT count(id) as countType,sum(receive) as qty, pay ,sum(`Change`) as aChange FROM `p_so_h` WHERE sta = '0' AND date(date_so) BETWEEN '$i_DATE1' AND '$i_DATE2'  $SE_USERH $SE_WH GROUP BY pay");
while ($row_dis = $result->fetch_assoc()) {
    if ($row_dis['pay'] == "cash") {
        $CReceived = $row_dis['countType'];
        $SUM_R = $row_dis['qty'];
        $SUM_Change = $row_dis['aChange'];
    }
    if ($row_dis['pay'] == "trans") {
        $CTransfer = $row_dis['countType'];
        $SUM_T = $row_dis['qty'];
    }
    if ($row_dis['pay'] == "card") {
        $CIssued = $row_dis['countType'];
        $SUM_I = $row_dis['qty'];
    }
}
@$result = $mysqli->query("SELECT count(id) as countType,sum(receive - `Change`) as qty, pay FROM `p_so_h` WHERE date(date_so) BETWEEN '$i_DATE1' AND '$i_DATE2' $SE_USERH $SE_WH");
while ($row_dis = $result->fetch_assoc()) {
    $sumpayall = $row_dis['countType'];
    $sumqtyall = $row_dis['qty'];
}
@$resultsta = $mysqli->query("SELECT count(id) as countsta,sum(receive) as qty FROM `p_so_h` WHERE sta = '1' AND date(date_so) BETWEEN '$i_DATE1' AND '$i_DATE2' $SE_USERH $SE_WH");
while ($row_sta = $resultsta->fetch_assoc()) {
    $stacount = $row_sta['countsta'];
    $stasum = $row_sta['qty'];
}
@$resultsta = $mysqli->query("SELECT count(id) as countsta,sum(receive - `Change`) as qty FROM `p_so_h` WHERE sta = '0' AND date(date_so) BETWEEN '$i_DATE1' AND '$i_DATE2' $SE_USERH $SE_WH");
while ($row_sta = $resultsta->fetch_assoc()) {
    $sta0count = $row_sta['countsta'];
    $sta0sum = $row_sta['qty'];
}
$SUM_R = $SUM_R - $SUM_Change;
?>

<body>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <label class="pt-3 text-secondary">รายงานสรุป</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>เงินสด</h3>
                            <h5>จำนวนบิล : <?php echo $CReceived; ?></h5>
                            <h5>จำนวนเงิน :<?php echo number_format($SUM_R, 2); ?></h5>

                        </div>
                        <div class="icon white-icon">
                            <i class="fa fa-money-bill-alt" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 accent-dangercol-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>บัตรเครดิต</h3>
                            <h5>จำนวนบิล : <?php echo $CIssued; ?></h5>
                            <h5>จำนวนเงิน : <?php echo number_format($SUM_I, 2); ?></h5>

                        </div>
                        <div class="icon black-icon">
                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>โอนเงิน/QRCODE</h3>
                            <h5>จำนวนบิล :<?php echo $CTransfer; ?></h5>
                            <h5>จำนวนเงิน :<?php echo number_format($SUM_T, 2); ?></h5>

                        </div>
                        <div class="icon white-icon">
                            <i class="fa fa-exchange-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-4 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>ยกเลิก</h3>
                            <h5>จำนวนบิล : <?php echo $stacount; ?></h5>
                            <h5>จำนวนเงิน :<?php echo number_format($stasum, 2); ?></h5>

                        </div>
                        <div class="icon large-icon">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="small-box bgblue">
                        <div class="inner">
                            <h3>รวมการขาย</h3>
                            <h5>จำนวนบิล : <?php echo $sta0count; ?></h5>
                            <h5>จำนวนเงิน :<?php echo number_format($sta0sum, 2); ?></h5>

                        </div>
                        <div class="icon white-larg">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 accent-dangercol-sm-12">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>รวมทั้งหมด</h3>
                            <h5>จำนวนบิล : <?php echo $sumpayall; ?></h5>
                            <h5>จำนวนเงิน : <?php echo number_format($sumqtyall, 2); ?></h5>

                        </div>
                        <div class="icon white-icon">
                            <i class="fa fa-archive" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12 col-sm-12">
                    <div class="small-box bgsblue">
                        <div class="inner">
                            <h3>เงินในร้าน</h3>
                            <h5>เงินสดเริ่มต้น : <?php echo number_format($money_s, 2); ?></h5>
                            <h5>เงินสดทั้งหมดในลิ้นชัก : <?php echo number_format($money_e, 2); ?></h5>

                        </div>
                        <div class="icon black-icon">
                            <i class="fa fa-archive" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>