<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">

<style>
    @media print {
        .page-break {
            page-break-after: always;
        }
    }
    .p1 {
        /* font-family: 'Arial Unicode MS', monospace; */
        font-family: Consolas,Menlo,monospace;
    }

    .h1 {
        font-size: 27px;
    }

    .h2 {
        font-size: 23px;
    }

    .h3 {
        font-size: 18px;
    }

    .b1 {
        font-weight: bold;
    }

    .size11 {
        font-size: 15px;
    }

    .test {
        width: 320px;
    }

    body {
        margin: 6px;
    }

    .right-text {
        text-align: right;
    }

    .HS1 {
        font-size: 16px;
    }

    .text20 {
        font-size: 22px;
    }

    .text15 {
        font-size: 16px;
    }

    .text16 {
        font-size: 16px;
    }

    .text17 {
        font-size: 16px;
    }

    .text18 {
        font-size: 16px;
    }
</style>
<title>พิมพ์ใบเสร็จ</title>

<?php
session_start();
include_once "../config.php";
$SE_NAME_WH = "";
$SE_MAC     = "";
@$user_id = $_SESSION['id'];
@$result = $mysqli->query("SELECT wh, sta_vat, name FROM `user` WHERE id='$user_id'");
@$row = $result->fetch_assoc();
@$user_wh = $row['wh'];
@$S_VAT = $row['sta_vat'];
@$user_name = $row['name'];

if (isset($_GET['so'])) {
    @$i_SO = $_GET['so'];
}

if (isset($_GET['so'])) {
    $s_sh = "SELECT date_so, so, sta, note, mac FROM p_so_h WHERE so = '$i_SO' ";
} else {
    $s_sh = "SELECT date_so, so, sta, note, mac FROM p_so_h ";
}
if ($re_sh = $mysqli->query($s_sh)) {
    while ($rowsh = $re_sh->fetch_assoc()) {
        $SE_DATE = $rowsh['date_so'];
        $SE_SO = $rowsh['so'];
        $SE_STA = $rowsh['sta'];
        $SE_NOTE_H = $rowsh['note'];
        $SE_MAC = $rowsh['mac'];

        $SE_DATE_SO_BILL = date("d/m/Y", strtotime($SE_DATE));
        $SE_TIME_SO_BILL = date("H:i", strtotime($SE_DATE));
    }
}

$s_wh = "SELECT name_wh FROM p_wh WHERE wh = '$user_wh' ";
if ($re_wh = $mysqli->query($s_wh)) {
    while ($rowwh = $re_wh->fetch_assoc()) {
        $SE_NAME_WH = $rowwh['name_wh'];
    }
}




?>
<!-- แผ่นแรก -->
<table class="test" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td colspan="5" align="center"><img src="../images/logo-bk.jpg" width="200"></td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 h1 b1">บริษัท ซัมมิทฟุตแวร์ จำกัด</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 h2 b1">ใบกำกับภาษีอย่างย่อ</td>
        </tr>

        <?php
        if ($SE_STA == 1) {
        ?>
            <tr>
                <td colspan="5" align="center" class="P1 h1 b1">(ยกเลิก)</td>
            </tr>
        <?php
        }
        ?>

        <tr>
            <td colspan="5" align="center" class="P1 HS1">5/4 หมู่ 1 ถ.บางนาตราด กม.16 ต.บางโฉลง</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 HS1">อ.บางพลี จ.สมุทรปราการ 10540</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 HS1">Tax ID : 0115522000260</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 HS1">RID : <?php if($SE_MAC !== ""){ echo $SE_MAC; }else{ echo "ไม่มีข้อมูล"; }  ?></td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 HS1">INV : <?php echo $SE_SO ?></td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 HS1"><?php echo $SE_DATE_SO_BILL ?> <?php echo $SE_TIME_SO_BILL ?></td>
        </tr>
        <tr>
            <td class="P1 text15 ">Q&nbsp;</td>
            <td class="P1 text15 ">Detail</td>
            <td class="P1 text15 " style="text-align: center;">Price</td>
            <td class="P1 text15  right-text">Dis</td>
            <td class="P1 text15  right-text">Total</td>
        </tr>
        <tr>
            <td colspan="5" align="center">......................................................................................</td>
        </tr>

        <?php
        $DISCOUNT_BATH = 0;
        $SUM_NET = 0;
        $SUM_QTY = 0;
        $SUM_PRICE = 0;
        $SUM_DIS = 0;
        $FSUM_NET = '';
        $FSUM_QTY = '';
        $FSUM_PRICE = '';
        $FSUM_DIS = '';
        $SE_FREE = '';
        $s_tem = "SELECT pn, price, dis_d, unit_d, SUM(qty) AS qty, note ,free FROM p_so_d WHERE so = '$SE_SO' GROUP BY pn, price, dis_d, unit_d,free ORDER BY id DESC ";
        //echo "--$s_tem--<br>";
        if ($re_tem = $mysqli->query($s_tem)) {
            while ($row = $re_tem->fetch_assoc()) {
                $SE_PN = $row['pn'];
                $SE_QTY = $row['qty'];
                $SE_PRICE = $row['price'];
                $SE_DIS_D = $row['dis_d'];
                $SE_UNIT_D = $row['unit_d'];
                $SE_NOTE = $row['note'];
                $SE_FREE = $row['free'];

                if ($SE_UNIT_D == '%') {
                    $DISCOUNT_BATH = ($SE_PRICE * $SE_DIS_D) / 100;
                    $NET = ($SE_PRICE * $SE_QTY) - $DISCOUNT_BATH * $SE_QTY;
                    $B_DISCOUNT = $DISCOUNT_BATH * $SE_QTY;
                } else if ($SE_UNIT_D == 'r') {
                    $SQL_CH_PRICE = "SELECT price FROM `p_dis_d` WHERE pn = '$SE_PN' AND  id_dis = '$SE_DIS_D'";
                    $result_ch = $mysqli->query($SQL_CH_PRICE);
                    $row_ch = $result_ch->fetch_assoc();
                    @$SE_CH_PRICE = $row_ch['price'];
                    $SQL_CK_ID = "SELECT name FROM `p_dis_h` WHERE id = '$SE_DIS_D'";
                    $result_hch = $mysqli->query($SQL_CK_ID);
                    $row_ch = $result_hch->fetch_assoc();
                    @$SE_DIS_NAME = $row_ch['name'];
                    $NET = ($SE_PRICE * $SE_QTY);
                    $B_DISCOUNT = $SE_PRICE - $SE_CH_PRICE;
                }  else {
                    $B_DISCOUNT = $SE_DIS_D;
                    $NET = ($SE_PRICE * $SE_QTY) - $SE_DIS_D;
                }

                $SE_PRICE_N = $SE_PRICE * $SE_QTY;

                $SUM_NET += $NET;
                $SUM_QTY += $SE_QTY;
                $SUM_PRICE += $SE_PRICE;
                $SUM_DIS += $B_DISCOUNT;

                $FSUM_NET = number_format($SUM_NET, 2);
                $FSUM_QTY = number_format($SUM_QTY);
                $FSUM_PRICE = number_format($SUM_PRICE, 2);
                $FSUM_DIS = number_format($SUM_DIS, 2);
                $FSE_QTY = number_format($SE_QTY);
                $FSE_PRICE = number_format($SE_PRICE, 2);
                $FNET = number_format($NET, 2);

                $check_pn = "SELECT     
                            CASE 
                            WHEN type = 'G' OR type = 'BG' THEN namep
                            ELSE pn
                            END AS result 
                            FROM `inv` WHERE pn = '$SE_PN' ";
                //echo $check_pn;
                $re_check = $mysqli->query($check_pn);
                while ($row_ck = $re_check->fetch_assoc()) {
                    $SE_PNCK = $row_ck['result'];
                }
        ?>

                <tr>
                    <td class="P1 text15 "><?php echo $FSE_QTY ?></td>
                    <td class="P1 text15 "><?php echo $SE_PNCK ?>&nbsp;<?php if ($SE_FREE == 1) {
                                                                            echo "<span style='color: red;'>*ฟรี</span>";
                                                                        } ?></td>
                    <td class="P1 text15 right-text "><?php if ($SE_UNIT_D == 'r') { echo $SE_CH_PRICE; } else { echo $FSE_PRICE; } ?></td>
                    <td class="P1 text15 right-text "><?php if($SE_UNIT_D == 'r') { echo "โปร";}else{ echo "$SE_DIS_D $SE_UNIT_D" ;} ?></td>
                    <td class="P1 text15 right-text "><?php echo $FNET ?></td>
                </tr>

                <?php if ($SE_NOTE !== '') { ?>
                    <tr>
                        <td class="P1"></td>
                        <td class="P1 size11"><?php echo $SE_NOTE ?></td>
                        <td class="P1"></td>
                        <td class="P1"></td>
                        <td class="P1"></td>
                    </tr>
                <?php } ?>
        <?php
            }
        }

        if ($S_VAT == 1) {
            $T_VAT = 0;
        } else {
            $T_VAT = 7;
        }

        $VAT = ($SUM_NET * $T_VAT) / 107;
        $FVAT = number_format($VAT, 2);

        $BVAT = $SUM_NET - $VAT;
        $FBVAT = number_format($BVAT, 2);

        $s_tem2 = "SELECT dis_h, unit_h, pay, receive FROM p_so_h WHERE so = '$SE_SO' ";
        if ($re_tem2 = $mysqli->query($s_tem2)) {
            while ($row2 = $re_tem2->fetch_assoc()) {
                $SE_DIS_H = $row2['dis_h'];
                $SE_UNIT_H = $row2['unit_h'];
                $SE_PAY = $row2['pay'];
                $SE_RECEIVE = $row2['receive'];
            }
        }

        if ($SE_UNIT_H == '%') {
            $DISCOUNT_BATH = ($SUM_NET * $SE_DIS_H) / 100;
            $SUM_NET = $SUM_NET - $DISCOUNT_BATH;
        } else {
            $SUM_NET = $SUM_NET - $SE_DIS_H;
        }

        if ($SE_PAY == 'cash') {
            $PAY = "เงินสด";
        } else if ($SE_PAY == 'card') {
            $PAY = "บัตรเครดิต";
        } else if ($SE_PAY == 'trans') {
            $PAY = "เงินโอน/QRCODE";
        }

        $Change = abs($SUM_NET - $SE_RECEIVE);

        ?>

        <tr>
            <td>&nbsp;</td>
            <td colspan="2" class="P1 text16">Discount</td>
            <td class="P1 text16 right-text"><?php if ($FSUM_DIS == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $FSUM_DIS;
                                                } ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="2" class="P1 text16">Discount Bills</td>
            <td class="P1 text16 right-text"><?php if ($FSUM_DIS == 0) {
                                                    echo "-";
                                                } else {
                                                    echo "$SE_DIS_H $SE_UNIT_H";
                                                } ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" align="center">......................................................................................</td>
        </tr>
        <tr>
            <td colspan="4" class="P1 text17">ราคาก่อนภาษี</td>
            <td class="P1 text17 right-text"><?php if ($FBVAT == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $FBVAT;
                                                } ?></td>
        </tr>
        <tr>
            <td colspan="4" class="P1 text17">ภาษี</td>
            <td class="P1 text17 right-text"><?php if (number_format($FVAT, 2) == 0) {
                                                    echo "-";
                                                } else {
                                                    echo number_format($FVAT, 2);
                                                } ?></td>
        </tr>
        <tr>
            <td colspan="4" class="P1 text17">ยอดสุทธิ : <?php echo $FSUM_QTY ?> คู่</td>
            <td class="P1 text17 right-text"><?php echo number_format($SUM_NET, 2) ?></td>
        </tr>
        <tr>
            <td colspan="4" class="P1 text17">ชำระโดย (<?php echo $PAY ?>)</td>
            <td class="P1 text17 right-text"><?php echo number_format($SE_RECEIVE, 2) ?></td>
        </tr>
        <tr>
            <td colspan="4" class="P1 text17">เงินทอน</td>
            <td class="P1 text17 right-text"><?php echo number_format($Change, 2) ?></td>
        </tr>
        <tr>
            <td colspan="5" align="center">........................................................................................</td>
        </tr>
        <tr>
            <td colspan="5" class="P1 text18"><?php echo "สาขา $SE_NAME_WH" ?></td>
        </tr>
        <tr>
            <td colspan="5" class="P1 text18"><?php echo "พนักงานขาย $user_name" ?></td>
        </tr>
        <tr>
            <td colspan="5" class="P1 text18"><?php echo "หมายเหตุ $SE_NOTE_H" ?></td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 text20">กรณีสินค้ามีปัญหามาเปลี่ยน</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 text20">ต้องนำบิลนี้มาด้วย</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 text20">ภายใน 7 วันนับตั้งแต่วันรับของ</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 text20">Aerosoft ใช้ดีบอกเพื่อน</td>
        </tr>
        <tr>
            <td colspan="5" align="center">......................................................................................</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>

    </tbody>
</table>
<!-- จบแผ่นแรก -->
<div style="page-break-after: always"></div>
<!-- แผ่นสอง -->
<table class="test" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td colspan="5" align="center"><img src="../images/logo-bk.jpg" width="300"></td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 h1 b1">บริษัท ซัมมิทฟุตแวร์ จำกัด</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 h2 b1">ใบกำกับภาษีอย่างย่อ</td>
        </tr>

        <?php
        if ($SE_STA == 1) {
        ?>
            <tr>
                <td colspan="5" align="center" class="P1 h1 b1">(ยกเลิก)</td>
            </tr>
        <?php
        }
        ?>

        <tr>
            <td colspan="5" align="center" class="P1 HS1">5/4 หมู่ 1 ถ.บางนาตราด กม.16 ต.บางโฉลง</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 HS1">อ.บางพลี จ.สมุทรปราการ 10540</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 HS1">Tax ID : 0115522000260</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 HS1">RID : E051120002A3581</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 HS1">INV : <?php echo $SE_SO ?></td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 HS1"><?php echo $SE_DATE_SO_BILL ?> <?php echo $SE_TIME_SO_BILL ?></td>
        </tr>
        <tr>
            <td class="P1 text15 ">Q&nbsp;</td>
            <td class="P1 text15 ">Detail</td>
            <td class="P1 text15 " style="text-align: center;">Price</td>
            <td class="P1 text15  right-text">Dis</td>
            <td class="P1 text15  right-text">Total</td>
        </tr>
        <tr>
            <td colspan="5" align="center">......................................................................................</td>
        </tr>

        <?php
        $DISCOUNT_BATH = 0;
        $SUM_NET = 0;
        $SUM_QTY = 0;
        $SUM_PRICE = 0;
        $SUM_DIS = 0;
        $FSUM_NET = '';
        $FSUM_QTY = '';
        $FSUM_PRICE = '';
        $FSUM_DIS = '';

        $s_tem = "SELECT pn, price, dis_d, unit_d, SUM(qty) AS qty, note FROM p_so_d WHERE so = '$SE_SO' GROUP BY pn, price, dis_d, unit_d ORDER BY id DESC ";
        //echo "--$s_tem--<br>";
        if ($re_tem = $mysqli->query($s_tem)) {
            while ($row = $re_tem->fetch_assoc()) {
                $SE_PN = $row['pn'];
                $SE_QTY = $row['qty'];
                $SE_PRICE = $row['price'];
                $SE_DIS_D = $row['dis_d'];
                $SE_UNIT_D = $row['unit_d'];
                $SE_NOTE = $row['note'];

                if ($SE_UNIT_D == '%') {
                    $DISCOUNT_BATH = ($SE_PRICE * $SE_DIS_D) / 100;
                    $NET = ($SE_PRICE * $SE_QTY) - $DISCOUNT_BATH * $SE_QTY;
                    $B_DISCOUNT = $DISCOUNT_BATH * $SE_QTY;
                } else if ($SE_UNIT_D == 'r') {
                    $SQL_CH_PRICE = "SELECT price FROM `p_dis_d` WHERE pn = '$SE_PN' AND  id_dis = '$SE_DIS_D'";
                    $result_ch = $mysqli->query($SQL_CH_PRICE);
                    $row_ch = $result_ch->fetch_assoc();
                    @$SE_PRICE = $row_ch['price'];
                    $SQL_CK_ID = "SELECT name FROM `p_dis_h` WHERE id = '$SE_DIS_D'";
                    $result_hch = $mysqli->query($SQL_CK_ID);
                    $row_ch = $result_hch->fetch_assoc();
                    @$SE_DIS_NAME = $row_ch['name'];
                    $NET = ($SE_PRICE * $SE_QTY);
                    $B_DISCOUNT = $SE_PRICE - $SE_CH_PRICE;
                } else {
                    $B_DISCOUNT = $SE_DIS_D;
                    $NET = ($SE_PRICE * $SE_QTY) - $SE_DIS_D;
                }

                $SE_PRICE_N = $SE_PRICE * $SE_QTY;

                $SUM_NET += $NET;
                $SUM_QTY += $SE_QTY;
                $SUM_PRICE += $SE_PRICE;
                $SUM_DIS += $B_DISCOUNT;

                $FSUM_NET = number_format($SUM_NET, 2);
                $FSUM_QTY = number_format($SUM_QTY);
                $FSUM_PRICE = number_format($SUM_PRICE, 2);
                $FSUM_DIS = number_format($SUM_DIS, 2);

                $FSE_QTY = number_format($SE_QTY);
                $FSE_PRICE = number_format($SE_PRICE, 2);
                $FNET = number_format($NET, 2);
        ?>

                <tr>
                    <td class="P1 text15 "><?php echo $FSE_QTY ?></td>
                    <td class="P1 text15 "><?php echo $SE_PN ?></td>
                    <td class="P1 text15 right-text "><?php if ($SE_UNIT_D == 'r') { echo $SE_CH_PRICE; } else { echo $FSE_PRICE; } ?></td>
                    <td class="P1 text15 right-text "><?php if($SE_UNIT_D == 'r') { echo "โปร";}else{ echo "$SE_DIS_D $SE_UNIT_D" ;} ?></td>
                    <td class="P1 text15 right-text "><?php echo $FNET ?></td>
                </tr>

                <?php if ($SE_NOTE !== '') { ?>
                    <tr>
                        <td class="P1"></td>
                        <td class="P1 size11"><?php echo $SE_NOTE ?></td>
                        <td class="P1"></td>
                        <td class="P1"></td>
                        <td class="P1"></td>
                    </tr>
                <?php } ?>
        <?php
            }
        }

        if ($S_VAT == 1) {
            $T_VAT = 0;
        } else {
            $T_VAT = 7;
        }

        $VAT = ($SUM_NET * $T_VAT) / 107;
        $FVAT = number_format($VAT, 2);

        $BVAT = $SUM_NET - $VAT;
        $FBVAT = number_format($BVAT, 2);

        $s_tem2 = "SELECT dis_h, unit_h, pay, receive FROM p_so_h WHERE so = '$SE_SO' ";
        if ($re_tem2 = $mysqli->query($s_tem2)) {
            while ($row2 = $re_tem2->fetch_assoc()) {
                $SE_DIS_H = $row2['dis_h'];
                $SE_UNIT_H = $row2['unit_h'];
                $SE_PAY = $row2['pay'];
                $SE_RECEIVE = $row2['receive'];
            }
        }

        if ($SE_UNIT_H == '%') {
            $DISCOUNT_BATH = ($SUM_NET * $SE_DIS_H) / 107;
            $SUM_NET = $SUM_NET - $DISCOUNT_BATH;
        } else {
            $SUM_NET = $SUM_NET - $SE_DIS_H;
        }

        if ($SE_PAY == 'cash') {
            $PAY = "เงินสด";
        } else if ($SE_PAY == 'card') {
            $PAY = "บัตรเครดิต";
        } else if ($SE_PAY == 'trans') {
            $PAY = "เงินโอน/QRCODE";
        }

        $Change = abs($SUM_NET - $SE_RECEIVE);

        ?>

        <tr>
            <td>&nbsp;</td>
            <td colspan="2" class="P1 text16">Discount</td>
            <td class="P1 text16 right-text"><?php if ($FSUM_DIS == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $FSUM_DIS;
                                                } ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="2" class="P1 text16">Discount Bills</td>
            <td class="P1 text16 right-text"><?php if ($FSUM_DIS == 0) {
                                                    echo "-";
                                                } else {
                                                    echo "$SE_DIS_H $SE_UNIT_H";
                                                } ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" align="center">......................................................................................</td>
        </tr>
        <tr>
            <td colspan="4" class="P1 text17">ราคาก่อนภาษี</td>
            <td class="P1 text17 right-text"><?php if ($FBVAT == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $FBVAT;
                                                } ?></td>
        </tr>
        <tr>
            <td colspan="4" class="P1 text17">ภาษี</td>
            <td class="P1 text17 right-text"><?php if (number_format($FVAT, 2) == 0) {
                                                    echo "-";
                                                } else {
                                                    echo number_format($FVAT, 2);
                                                } ?></td>
        </tr>
        <tr>
            <td colspan="4" class="P1 text17">ยอดสุทธิ : <?php echo $FSUM_QTY ?> คู่</td>
            <td class="P1 text17 right-text"><?php echo number_format($SUM_NET, 2) ?></td>
        </tr>
        <tr>
            <td colspan="4" class="P1 text17">ชำระโดย (<?php echo $PAY ?>)</td>
            <td class="P1 text17 right-text"><?php echo number_format($SE_RECEIVE, 2) ?></td>
        </tr>
        <tr>
            <td colspan="4" class="P1 text17">เงินทอน</td>
            <td class="P1 text17 right-text"><?php echo number_format($Change, 2) ?></td>
        </tr>
        <tr>
            <td colspan="5" align="center">........................................................................................</td>
        </tr>
        <tr>
            <td colspan="5" class="P1 text18"><?php echo "สาขา $SE_NAME_WH" ?></td>
        </tr>
        <tr>
            <td colspan="5" class="P1 text18"><?php echo "พนักงานขาย $user_name" ?></td>
        </tr>
        <tr>
            <td colspan="5" class="P1 text18"><?php echo "หมายเหตุ $SE_NOTE_H" ?></td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 text20">กรณีสินค้ามีปัญหามาเปลี่ยน</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 text20">ต้องนำบิลนี้มาด้วย</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 text20">ภายใน 7 วันนับตั้งแต่วันรับของ</td>
        </tr>
        <tr>
            <td colspan="5" align="center" class="P1 text20">Aerosoft ใช้ดีบอกเพื่อน</td>
        </tr>
        <tr>
            <td colspan="5" align="center">......................................................................................</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>

    </tbody>
</table>
<!-- จบแผ่นสอง -->
<?php
if (isset($_GET['so'])) {
} else {
?>

    <script type="text/javascript">
        function PrintPage() {
            window.print();
            document.getElementById('input').value = 2;
        }
        document.loaded = function() {

        }
        window.addEventListener('DOMContentLoaded', (event) => {
            PrintPage()
            setTimeout(function() {
                window.close()
            }, 750)
        });
    </script>

<?php
    echo "<meta http-equiv=refresh content=0;url=index.php?link=frm_in_pos>";
}
?>