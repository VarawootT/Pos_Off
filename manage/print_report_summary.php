<style>
    .h1 {
        /* กำหนดให้ font-size 27 px */
        font-size: 18px;
    }

    .b1 {
        /* กำหนดให้ font-weight ให้ตัวหน่า */
        font-weight: bold;
    }

    .font16 {
        /* กำหนดให้ font-size 18 px */
        font-size: 12px;
    }

    .p1 {
        /* กำหนดให้ font เป๋น arial */
        font-family: 'Arial Unicode MS', monospace;
    }

    .font20 {
        /* กำหนดให้ font-size 18 */
        font-size: 16px;
    }
</style>
<title>พิมพ์ใบสรุป</title> <!-- หัว web -->
<link rel="icon" type="image/png" href="../images/favicon.png"> <!-- link รูปจาก ไฟล์ที่กำหนดมาแสดง icon -->
<?php //เปิดหัว php 
session_start(); /* เริ่ม session */
include_once "../config.php"; //include config.php ที่อยู่ไฟล์ ข้างหน้าของ manage


//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- รับข้อมูลเข้ามาจากหน้า frm_report_summary
$SEN_USER_SALE  = "";                                                                         //สร้างตัวแปล SEN_USER_SALE เพื่อใช้สำหรับเช็คได้ว่าเป็นค่าว่างไหม
$SEN_DATE_OPEN  = "";                                                                         //สร้างตัวแปล SEN_DATE_OPEN เพื่อใช้สำหรับเช็คได้ว่าเป็นค่าว่างไหม
$SEN_DATE_END   = "";                                                                         //สร้างตัวแปล SEN_DATE_END  เพื่อใช้สำหรับเช็คได้ว่าเป็นค่าว่างไหม
@$SEN_USER_SALE = $_POST['user_sale'];                                                        //รับข้อมูลมาจาก frm_report_summary ในรูปแบบ POST แล้วมาเปลี่ยน SEN_USER_SALE เพิ่มเติม เนื่องจาก @ ไว้ทำให้ถ้าไม่ส่งมาจะไม่ต้อง Error
@$SEN_DATE_OPEN = $_POST['i_DATE1'];                                                          //รับข้อมูลมาจาก frm_report_summary ในรูปแบบ POST แล้วมาเปลี่ยน SEN_DATE_OPEN เพิ่มเติม เนื่องจาก @ ไว้ทำให้ถ้าไม่ส่งมาจะไม่ต้อง Error
@$SEN_DATE_END  = $_POST['i_DATE2'];                                                          //รับข้อมูลมาจาก frm_report_summary ในรูปแบบ POST แล้วมาเปลี่ยน SEN_DATE_END เพิ่มเติม เนื่องจาก @ ไว้ทำให้ถ้าไม่ส่งมาจะไม่ต้อง Error
@$SEN_USER_S    = $_POST['user_s'];

//  echo $SEN_USER_SALE;
//  echo $SEN_DATE_OPEN;
//  echo $SEN_USER_S;

$SQL_USER_SALE  = "";                                                                         //สร้างตัวแปล SQL_USER_SALE เพื่อให้เป็นค่าว่างไว้กำหนดเมื่อไม่มีข้อมูล SQL_USER_SALE
$SQL_DATE_SO    = "";
$SQL_USER_SALE_V = "";
$SQL_USER_S      = "";
$SQL_DATETIME_SO_V = "";
$SQL_USER_E         = "";
$SQL_USER_B     = "";
$date_start_open = "";
$date_end_close  = "";
//สร้างตัวแปล SQL_DATE_SO เพื่อให้เป็นค่าว่างไว้กำหนดเมื่อไม่มีข้อมูล SQL_DATE_SO
$SEN_DATETIME_OPEN  = str_replace('T', ' ', $SEN_DATE_OPEN);                                  //รับข้อมูลมาในรูปแบบ Datetime แล้วลบ T ใน $SEN_DATE_OPEN เพื่อนำเข้า SQL ได้
$SEN_DATETIME_END   = str_replace('T', ' ', $SEN_DATE_END);                                   //รับข้อมูลมาในรูปแบบ Datetime แล้วลบ T ใน $SEN_DATE_END เพื่อนำเข้า SQL ได้
$SEN_DATETIME_OPEN  = new DateTime($SEN_DATE_OPEN);                                           //เปลี่ยนแบบ Fomate เวลาสำหรับ ใช้งานแต่ละ Function  
$SEN_DATETIME_END   = new DateTime($SEN_DATE_END);                                            //เปลี่ยนแบบ Fomate เวลาสำหรับ ใช้งานแต่ละ Function
$SHOW_DATE_TIME_OPEN = $SEN_DATETIME_OPEN->format('d-m-Y H:i:s');
$SHOW_DATE_TIME_END  = $SEN_DATETIME_END->format('d-m-Y H:i:s');
$SEN_END_TIME       = $SEN_DATETIME_END->format('Y-m-d H:i');                                 //เปลี่ยนแบบ Fomate เวลาสำหรับ ใช้งานแต่ละ Function              
$SEN_DATETIME_OPEN  = $SEN_DATETIME_OPEN->format('Y-m-d H:i:s');                              //เปลี่ยนแบบ Fomate เวลาสำหรับ ใช้งานแต่ละ Function                  
$SEN_DATETIME_END   = $SEN_DATETIME_END->format('Y-m-d H:i:s');                               //เปลี่ยนแบบ Fomate เวลาสำหรับ ใช้งานแต่ละ Function              
if ($SEN_USER_SALE != "") {                                                                     //เริ่มต้นทำเงื่อนไขเช็คว่า $SEN_USER_SALE ต้องไม่ == ค่าว่าง ถ้าไม่ == ค่าว่างให้ดำเนินการใน if
    $SQL_USER_SALE = "AND b.wh = '$SEN_USER_SALE'";                                           //กำหนดให้ $SQL_USER_SALE = "" ที่กำนหดให้เพื่อใช่สำหรับ WHERE SQL จาก **iduser เป้น wh edit 2024-09-9 time**
} // สิ้นสุด if
if ($SEN_USER_SALE != "") {
    $SQL_USER_SALE_V = "AND wh = '$SEN_USER_SALE'";
} // สิ้นสุด if
if ($SEN_DATE_OPEN != "") {                                                                     //เริ่มต้นทำเงื่อนไขเช็คว่า $SEN_DATE_OPEN ต้องไม่ == ค่าว่าง ถ้าไม่ == ค่าว่างให้ดำเนินการใน if
    $SQL_DATE_SO   = "AND DATE(b.date_so) BETWEEN '$SEN_DATE_OPEN' AND '$SEN_DATE_END'";      //กำหนดให้ $SQL_USER_SALE = "" ที่กำนหดให้เพื่อใช่สำหรับ WHERE SQL 
} // สิ้นสุด if
if ($SEN_DATE_OPEN != "") { //อีกเวอร์ชั้น                                         
    $SQL_DATETIME_SO  = "AND b.date_so BETWEEN '$SEN_DATETIME_OPEN' AND '$SEN_DATETIME_END'";
}
if ($SEN_DATE_OPEN != "") {
    $SQL_DATE_SO_V   = "AND DATE(date_so) BETWEEN '$SEN_DATE_OPEN' AND '$SEN_DATE_END'";
} // สิ้นสุด if
if ($SEN_DATE_OPEN != "") { //อีกเวอร์ชั้น                                         
    $SQL_DATETIME_SO_V  = "AND date_so BETWEEN '$SEN_DATETIME_OPEN' AND '$SEN_DATETIME_END'";
}
if ($SEN_USER_S != "") {
    $SQL_USER_S = "AND iduser = '$SEN_USER_S'";
    $SQL_USER_E = "AND userid = '$SEN_USER_S'";
    $SQL_USER_B = "AND b.iduser = '$SEN_USER_S'";
}
//echo "SELECT  MIN(date_so) AS date_so_min,MAX(data_so_end) AS data_so_end_max FROM `p_so_mtos` WHERE money_start IS NOT NULL  $SQL_DATETIME_SO_V $SQL_USER_E $SQL_USER_SALE_V";
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------  เวลาเปิดปิด
@$startandstop = $mysqli->query("SELECT  MIN(date_so) AS date_so_min,MAX(data_so_end) AS data_so_end_max FROM `p_so_mtos` WHERE money_start IS NOT NULL  $SQL_DATETIME_SO_V $SQL_USER_E $SQL_USER_SALE_V");
@$rowsns = $startandstop->fetch_assoc();
@$date_start_open = $rowsns['date_so_min'];
@$date_end_close = $rowsns['data_so_end_max'];
$date_start_open  = new DateTime($date_start_open);                                           //เปลี่ยนแบบ Fomate เวลาสำหรับ ใช้งานแต่ละ Function  
$date_end_close   = new DateTime($date_end_close);
$date_start_open = $date_start_open->format('d-m-Y H:i:s');
$date_end_close  = $date_end_close->format('d-m-Y H:i:s');


//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวเปิด mysql  
@$userid = $_SESSION['id'];                                                                   // เอาข้อมูลที่อยู่ใน session ของ user_id ที่เก็บไว้นำมาใช้งาน เป็นข้อมูลที่ถูกเก็บรับรู้ว่าเข้า id นี้อยู่ @ เมื่อไม่มีข้อมูลนี้จะไม่ Error
if ($userid == "") {
    @$result = $mysqli->query("SELECT wh,sta_vat, name,lname FROM `user` WHERE id='$SEN_USER_S'");
} else {
    @$result = $mysqli->query("SELECT wh,sta_vat, name,lname FROM `user` WHERE id='$userid'");
}
@$row = $result->fetch_assoc();                                                               // กำหนดให้ $row ให้ $result ดึงแถวผลลัพธ์เป็นอาเรย์ที่เชื่อมโยง
@$user_wh = $row['wh'];                                                                       // กำหนด user_wh = $row ของแถว wh
@$S_VAT = $row['sta_vat'];                                                                    // กำหนด S_VAT = $row ของแถว sta_vat
@$user_name = $row['name'];                                                                   // กำหนด user_name = $row ของแถว naem
@$lname_name = $row['lname'];                                                                 // กำหนด lanem_name = $row ของแถว lname
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวเปิด mysql 
$user_name_select  = "";                                                                      //กำหนดให้ user_name_select เป็นค่าว่างเพื่อไว้เช็คเมื่อ select ไม่เจอและเป็นค่าว่างให้แสดงอีกคำที่ไม่ใช้ ืname 
$user_lname_select = "";                                                                 //กำหนดให้ user_name_select เป็นค่าว่างเพื่อไว้เช็คเมื่อ select ไม่เจอและเป็นค่าว่างให้แสดงอีกคำที่ไม่ใช้ lname
if ($userid == "") {
    @$user_sql = $mysqli->query("SELECT  wh,name,lname  FROM `user` WHERE id='$SEN_USER_SALE'");
} else {
    @$user_sql = $mysqli->query("SELECT  wh,name,lname  FROM `user` WHERE id='$userid'");
    $user_sql;
}
@$row_user = $user_sql->fetch_assoc();
$user_name_select  = $row_user['name'] ?? '';
$user_lname_select = $row_user['lname'] ?? '';
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวเปิด mysql 
@$resultwh = $mysqli->query("SELECT name_bill FROM `p_wh` WHERE wh = '$SEN_USER_SALE'");            //กำหนด query สำหรับ select name_bill หรือ สถานที่ของเครื่อง                                                  
@$rowwh = $resultwh->fetch_assoc();                                                           //กำหนดให้ $rowwh รับค่าของ $resultwh มาในรูแบบลูปที่เป็นแถว   
@$name_wh = $rowwh['name_bill'];                                                              //กำหนด name_wh = $rowwh ของแถว name_bill
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวปิด mysql
$COUNTQTY        = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ
$COUTALLQTYFROM  = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ
$COUTQTY_STA_1   = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ
$SUMVAT          = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ
$VATSTA0         = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ
$SUMRECEIVESTA   = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ
$SUMRECEIVE      = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ             
$SUMDISCOUNT     = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ 
$SUMCOUNTCASH    = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ 
$SUMCOUNTCARD    = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ 
$SUMCOUNTTRANS   = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ
$SUMRECEIVESTAC1 = 0;                                                            // กำหนดค่าให้แสดงเป็น 0 เพื่อกัน Error เมื่อ sql ไม่เจอ
$SUMCOUNTCHANGE  = 0;
$SUMCHANGE       = 0;
$start_money     = 0;
$SETMONEY_END    = 0;
$SET_MONEY       = 0;
$p_so_d = $mysqli->query("SELECT
SUM(CASE WHEN b.sta = 0 THEN QTY ELSE 0 END) AS COUNTQTY_STA_0,                  /* ต้นหาจำนวน b.sta=0 */
COUNT(QTY) AS COUTQTY,                                                           /* ค้นหาจำนวนทั้งหมด */
SUM(CASE WHEN b.sta = 1 THEN QTY ELSE 0 END) AS COUTQTY_STA_1                    /* คนหาจำนวนที่เป็น b.sta = 1 (ยกเลิก) */
FROM `p_so_d` a INNER JOIN `p_so_h` b ON a.so = b.so WHERE b.so IS NOT NULL $SQL_DATETIME_SO $SQL_USER_SALE $SQL_USER_B  ");
$row_so_d        = $p_so_d->fetch_assoc();
//-------------------------------------------------------------------------------------// กำหนดแต่ละ row_so_d
$COUNTQTY        = $row_so_d['COUTQTY'];
$COUTQTY_STA_1   = $row_so_d['COUTQTY_STA_1'];
$COUNTQTY_STA_0  = $row_so_d['COUNTQTY_STA_0'];
// $SUMRECEIVESTA   = $row_so_d['receive_sta_1'];               //ปิดไว้ไม่ได้ใช่ตอนนี้           
// $SUMRECEIVESTA0  = $row_so_d['receive_sta_0'];               //ปิดไว้ไม่ได้ใช่ตอนนี้           
// $SUMBVAT         = $row_so_d['BVAT'];                        //ปิดไว้ไม่ได้ใช่ตอนนี้  
// $SUMVAT          = $row_so_d['VAT'];                         //ปิดไว้ไม่ได้ใช่ตอนนี้ 
// $SUMBVATSTA0     = $row_so_d['BVATSTA0'];                    //ปิดไว้ไม่ได้ใช่ตอนนี้      
// $SUMVATSTA0      = $row_so_d['VATSTA0'];                     //ปิดไว้ไม่ได้ใช่ตอนนี้     
// $SUMDISCOUNTALL  = $row_so_d['discountall'];                 //ปิดไว้ไม่ได้ใช่ตอนนี้         
// $SUMPRICE        = $row_so_d['Price'];                       //ปิดไว้ไม่ได้ใช่ตอนนี้   
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวปิด mysql
$p_so_d_all = $mysqli->query("SELECT SUM(QTY) AS COUTALLQTYFROM FROM `p_so_d` a INNER JOIN `p_so_h` b ON a.so = b.so WHERE b.sta = 0 $SQL_DATETIME_SO $SQL_USER_SALE $SQL_USER_S "); /* รวมจำนวนทั้งหมด */
$row_so_d_all = $p_so_d_all->fetch_assoc();
$COUTALLQTYFROM = $row_so_d_all['COUTALLQTYFROM'];
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวปิด mysql
//echo "SELECT count(DISTINCT  so) AS SUMALLQTYSO FROM `p_so_h`  WHERE STA = '0' $SQL_DATETIME_SO_V $SQL_USER_SALE_V $SQL_USER_S ";
$p_so_q_all = $mysqli->query("SELECT count(DISTINCT  so) AS SUMALLQTYSO FROM `p_so_h`  WHERE STA = '0' $SQL_DATETIME_SO_V $SQL_USER_SALE_V $SQL_USER_S "); /* รวมจำนวนทั้งหมด */
$row_so_q_all = $p_so_q_all->fetch_assoc();
$SUMALLQTYSO = $row_so_q_all['SUMALLQTYSO'];
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวปิด mysql
$p_so_c_all = $mysqli->query("SELECT count(DISTINCT  so) AS SUMALLCQTYSO FROM `p_so_h`  WHERE STA = '1' $SQL_DATETIME_SO_V $SQL_USER_SALE_V $SQL_USER_S "); /* รวมจำนวนทั้งหมด */
$row_so_c_all = $p_so_c_all->fetch_assoc();
$SUMALLCQTYSO = $row_so_c_all['SUMALLCQTYSO'];
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวเปิด mysql ค่ารวมสุทธิ เหตุผลที่ต้องแยกเนื่องการ 1 รายการมีสินค้าที่เหมือนกันทำให้มี 2 ID และ case when sum กัน ไม่ได้เนื่องจากทำให้ค่าผิดเพี่ยน
$SQLSUMDISCOUNT = "SELECT 
b.so,                                                                           
(b.receive + b.discount) AS receiveall,                                         
(b.discount) AS discount                                                        
FROM `p_so_d` a INNER JOIN `p_so_h` b ON a.so = b.so 
WHERE b.so IS NOT NULL $SQL_DATETIME_SO $SQL_USER_SALE $SQL_USER_B  GROUP BY a.so";
//echo $SQLSUMDISCOUNT;
$recive_so = $mysqli->query($SQLSUMDISCOUNT);
while ($row2 = $recive_so->fetch_assoc()) {
    $SUMRECEIVE  += $row2['receiveall'];       // รวมค่า รายรับทั้งหมด
    $SUMDISCOUNT += $row2['discount'];         // รวมค่า ส่วนลดทั้งหมด
} // หมายเหตุทำไมไม่ใช้ SUM เนื่องจาก GROUP BY ทำให้ เกิดค่าที่ผิด เพี้ยน เนื่องจากจะรูปมาทั้งหมดใช้ถ้ารวมรายรับจริงๆ
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
$SUMRECEIVESTA0 = 0;
$SUMCHANGESTA0  = 0;
$SQLSUMDISCOUNTSTA0 = "SELECT 
b.so,   
(b.receive + b.discount) AS receiveall, 
(b.`change`) AS test
FROM `p_so_d` a INNER JOIN `p_so_h` b ON a.so = b.so 
WHERE b.sta = '0' $SQL_DATETIME_SO $SQL_USER_SALE $SQL_USER_B  GROUP BY a.so";
$recive_sosta0 = $mysqli->query($SQLSUMDISCOUNTSTA0);
while ($row2sta0 = $recive_sosta0->fetch_assoc()) {
    @$SUMRECEIVESTA0  += $row2sta0['receiveall'];       // รวมค่า รายรับทั้งหมด
    @$SUMCHANGESTA0   += $row2sta0['test'];
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวเปิด mysql ค่ารวมสุทธิ เหตุผลที่ต้องแยกเนื่องการ 1 รายการมีสินค้าที่เหมือนกันทำให้มี 2 ID และ case when sum กัน ไม่ได้เนื่องจากทำให้ค่าผิดเพี่ยน
$SQLSUMDISCOUNTS1 = "SELECT b.so,                                       
(b.receive) AS recsta1                      
FROM `p_so_d` a INNER JOIN `p_so_h` b ON a.so = b.so 
WHERE b.sta = '1' $SQL_DATETIME_SO $SQL_USER_SALE GROUP BY a.so";
$recives1_so = $mysqli->query($SQLSUMDISCOUNTS1);
while ($row6 = $recives1_so->fetch_assoc()) {
    $SUMRECEIVESTAC1  += $row6['recsta1'];
} // หมายเหตุทำไมไม่ใช้ SUM เนื่องจาก GROUP BY ทำให้ เกิดค่าที่ผิด เพี้ยน เนื่องจากจะรูปมาทั้งหมดใช้ถ้ารวมรายรับจริงๆ
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวเปิด mysql cash  เหตุผลที่ต้องแยก select เนื่องจากมีบ้างตัว มี 2 ID จึงต้อง Group by
$cash_so = $mysqli->query("SELECT b.receive,b.change FROM `p_so_d` a INNER JOIN `p_so_h` b ON a.so = b.so WHERE b.sta = 0 AND b.pay ='cash' $SQL_DATETIME_SO $SQL_USER_SALE $SQL_USER_B GROUP BY a.so");    //กำหนด query สำหรับ select ข้อมูล b.sta = 0 หรือไม่ยกเลิก และ b.pay = cash เงินสด
while ($row3 = $cash_so->fetch_assoc()) {   //เก็บ while loop (โดยค่า loop คือ  $row3 และรับค่า มาเป็น array อีกรอบเพื่อทำ loop ได้  )
    $SUMCOUNTCASH += $row3['receive'];      //รวมราคา ที่จ่ายด้วยเงินสด
    $SUMCOUNTCHANGE += $row3['change'];
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวเปิด mysql card   เหตุผลที่ต้องแยก select เนื่องจากมีบ้างตัว มี 2 ID จึงต้อง Group by
$card_so = $mysqli->query("SELECT b.receive FROM `p_so_d` a INNER JOIN `p_so_h` b ON a.so = b.so WHERE b.sta = 0 AND b.pay ='card' $SQL_DATETIME_SO $SQL_USER_SALE $SQL_USER_B GROUP BY a.so");    //กำหนด query สำหรับ select ข้อมูล b.sta = 0 หรือไม่ยกเลิก และ b.pay = card การ์ด
while ($row4 = $card_so->fetch_assoc()) {   //เก็บ while loop (โดยค่า loop คือ  $row4 และรับค่า มาเป็น array อีกรอบเพื่อทำ loop ได้  )
    $SUMCOUNTCARD += $row4['receive'];      //รวมราคา ที่จ่ายด้วยการ์ด
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวเปิด mysql trans  เหตุผลที่ต้องแยก select เนื่องจากมีบ้างตัว มี 2 ID จึงต้อง Group by
$trans_so = $mysqli->query("SELECT b.receive FROM `p_so_d` a INNER JOIN `p_so_h` b ON a.so = b.so WHERE b.sta = 0 AND b.pay ='trans' $SQL_DATETIME_SO $SQL_USER_SALE $SQL_USER_B GROUP BY a.so");  //กำหนด query สำหรับ select ข้อมูล b.sta = 0 หรือไม่ยกเลิก และ b.pay = trans โอน
while ($row5 = $trans_so->fetch_assoc()) {  //เก็บ while loop (โดยค่า loop คือ  $row5 และรับค่า มาเป็น array อีกรอบเพื่อทำ loop ได้  ) 
    $SUMCOUNTTRANS += $row5['receive'];     //รวมราคา ที่จ่ายด้วยโอนเงิน
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวเปิด mysql trans
$start_money = $mysqli->query("SELECT sum(money_start) as money_start FROM `p_so_mtos` WHERE date_so BETWEEN '$SEN_DATETIME_OPEN' AND '$SEN_DATETIME_END' $SQL_USER_SALE_V $SQL_USER_E ");
$row_start = $start_money->fetch_assoc();
$start_money = $row_start['money_start'];
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวเปิด mysql trans
$start_money_all = $mysqli->query("SELECT sum(money_start) as money_start FROM `p_so_mtos` WHERE date_so BETWEEN '$SEN_DATETIME_OPEN' AND '$SEN_DATETIME_END' $SQL_USER_SALE_V $SQL_USER_E");
$row_start_all = $start_money_all->fetch_assoc();
$start_money_all = $row_start_all['money_start'];
//-------------------------------------------------------------------------------------// ตัวคำนวน
$SUMRECEIVESTA01 = $SUMRECEIVESTA0 - $SUMCHANGESTA0;
$NETSALES  = $SUMRECEIVE - ($SUMDISCOUNT + $SUMRECEIVESTAC1) - $SUMCHANGESTA0; /* คำนวนค่ารวมสุทธิ ขึ้นมา โดยนำข้อมูลจาก SUMRECEIVE มาคำนวน - ( SUMDISCOUNT + SUMRECIVESTA) */
$VATNET    = $NETSALES * 7 / 107;                                               /* คำนวนภาษีของค่ารวมสุทธิ ขึ้นมา */
$SUMVATNET = $NETSALES - $VATNET;                                               /* คำนวนภาษีของค่ารวมสุทธิ ขึ้นมา */

$SUMALLVAT = $NETSALES + $SUMVAT;                                               /* ตำนวนค่ารวมสุทธิ + ภาษี */
$SUMCOUNTCASH = $SUMCOUNTCASH - $SUMCOUNTCHANGE;
$SUMRECEIVESTA01 = $SUMRECEIVESTA01 - $VATNET;
$SUMRECEIVE = $SUMRECEIVE - $SUMCHANGESTA0;
if ($start_money == "") {
    $SETMONEY_END = $SUMCOUNTCASH + $start_money_all;
    $SET_MONEY = $start_money_all;
} else {
    $SETMONEY_END = $SUMCOUNTCASH + $start_money;
    $SET_MONEY = $start_money;
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------- ตัวปิด mysql
?> <!-- จบ php -->

<table class="test" border="0" cellspacing="0" cellpadding="0"> <!-- ตัวเปิดตาราง -->

    <thead> <!-- เปิดหัวตาราง -->

        <!-- ------------------------------------------------------------------------ -->
        <tr>
            <td colspan="5" align="center" class="P1 h1 b1">บริษัท ซัมมิทฟุตแวร์ จำกัด</td> <!-- ตารางหัวบริษัท รวม 5 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------ -->

    </thead><!-- ปิดหัวตาราง -->

    <tbody> <!-- เปิดเนื่อหาหัวตาราง -->

        <!-- ------------------------------------------------------------------------รายงานสรุปการขาย -->
        <tr>
            <td colspan="5" align="center" class="P1 font20 b1">รายงานสรุปการขาย</td> <!-- ตาราง body เนื้อหา รวม 5 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------สาขา / เครื่อง -->
        <tr>
            <td colspan="5" align="left" class="p1 font16">สาขา / เครื่อง : <?php echo $name_wh ?></td> <!-- ชิดซ้าย รวม 5 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------วันที่เปิด  -->
        <tr>
            <td colspan="5" align="left" class="p1 font16">วันที่เวลา/เปิดการขาย : <?php if ($date_start_open != "") {
                                                                                        echo $date_start_open;
                                                                                    } else {
                                                                                        echo "ยังไม่มีเวลาเปิดร้าน";
                                                                                    } ?> </td> <!-- ชิดซ้าย รวม 5 แถว -->
        </tr>

        <!-- ------------------------------------------------------------------------วันที่ปิด -->
        <tr>
            <td colspan="5" align="left" class="p1 font16">วันที่เวลา/ปิดการขาย : <?php if ($date_end_close != "") {
                                                                                        echo $date_end_close;
                                                                                    } else {
                                                                                        echo "ยังไม่มีเวลาปิดร้าน";
                                                                                    }   ?></td> <!-- ชิดซ้าย รวม 5 แถว -->
        </tr>


        <!-- ------------------------------------------------------------------------ -->
        <tr>
            <td colspan="5" align="left" class="p1 font16">พิมพ์โดย : <?php echo $user_name ?> <?php echo $lname_name ?> </td> <!-- ชิดซ้าย รวม 5 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------ -->
        <tr>
            <td colspan="5" align="left" class="p1 font16">P-ID : <?php echo $user_wh; ?></td> <!-- ชิดซ้าย รวม 5 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------ -->

        <td colspan="5" align="center">------------------------------------------</td> <!-- ตัวปิดกำหนดเส้น มีผลกับ ตารางทั้งหมดถ้าลบหรือเพิ่มจะขยาย -->

        <!-- ------------------------------------------------------------------------จำนวนบิลขาย -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">จำนวนบิลขาย</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($SUMALLQTYSO, 2) ?></td> <!-- ชิดขวา รวม 2 แถว กำหนดให้เลขมีจุดทศนิยม 2 ตำแหน่างและมีลูกตามรูป number_format -->
        </tr>
        <!-- ------------------------------------------------------------------------จำนวนยกเลิก -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">จำนวนบิลยกเลิก</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($SUMALLCQTYSO, 2) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------จำนวนบิลคืนสินค้า -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">จำนวนบิลคืนสินค้า</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16">0.00</td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------จำนวนสินค้า -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">จำนวนสินค้า</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($COUTALLQTYFROM) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------ -->

        <td colspan="5" align="center">------------------------------------------</td> <!-- ตัวปิดกำหนดเส้น มีผลกับ ตารางทั้งหมดถ้าลบหรือเพิ่มจะขยาย -->

        <!-- ------------------------------------------------------------------------ยอดขาย -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">ยอดขาย</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($SUMRECEIVE, 2) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------การคืนสินค้า -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">การคืนสินค้า</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16">0.00</td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------การยกเลิกบิลขาย -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">ยกเลิกบิลขาย</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php if ($SUMRECEIVESTAC1 != 0) {
                                                                echo number_format(-$SUMRECEIVESTAC1, 2);
                                                            } else {
                                                                echo "0.00";
                                                            }  ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------ส่วนลดทั้งหมด -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">ส่วนลดทั้งหมด</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format(-$SUMDISCOUNT, 2) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------ -->


        <td colspan="5" align="center">------------------------------------------</td> <!-- ตัวปิดกำหนดเส้น มีผลกับ ตารางทั้งหมดถ้าลบหรือเพิ่มจะขยาย -->

        <!-- ------------------------------------------------------------------------ยอดขายสุทธิ -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">ยอดขายสุทธิ</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($SUMVATNET, 2) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------ภาษี -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">ภาษี</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($VATNET, 2) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------รวมทั้งหมด -->
        <tr>
            <td colspan="3" align="left" class="p1 b1 font16">รวมทั้งหมด</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 b1 font16"><?php echo number_format($NETSALES, 2) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------ -->

        <td colspan="5" align="center">------------------------------------------</td> <!-- ตัวปิดกำหนดเส้น มีผลกับ ตารางทั้งหมดถ้าลบหรือเพิ่มจะขยาย -->

        <!-- ------------------------------------------------------------------------เงินสด -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">เงินสด</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($SUMCOUNTCASH, 2) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------บัตรเครดิต -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">บัตรเครดิต</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($SUMCOUNTCARD, 2) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------เงินโอน / QR -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">เงินโอน / QR</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($SUMCOUNTTRANS, 2) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>
        <!-- ------------------------------------------------------------------------ -->

        <td colspan="5" align="center">------------------------------------------</td> <!-- ตัวปิดกำหนดเส้น มีผลกับ ตารางทั้งหมดถ้าลบหรือเพิ่มจะขยาย -->

        <!-- ------------------------------------------------------------------------เงินสดทั้งหมดในลิ้นชัก -->
        <tr>
            <td colspan="3" align="left" class="p1 font16">เงินสดเริ่มต้น</td>
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($SET_MONEY, 2) ?></td>
        </tr>
        <tr>
            <td colspan="3" align="left" class="p1 font16">เงินสดทั้งหมดในลิ้นชัก</td> <!-- ชิดซ้าย รวม 3 แถว -->
            <td colspan="2" align="right" class="p1 font16"><?php echo number_format($SETMONEY_END, 2) ?></td> <!-- ชิดขวา รวม 2 แถว -->
        </tr>



    </tbody> <!-- ปิดเนื่อหาหัวตาราง -->

</table> <!-- ตัวปิดตาราง -->
<script type="text/javascript">
    function PrintPage() {
        window.print();
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
if ($userid != "") {
    echo "<meta http-equiv=refresh content=0;url=index.php?link=frm_report_summary>";
} else {
    echo "<meta http-equiv=refresh content=0;url=CloseStore.php>";
}
?>
</script>