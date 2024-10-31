<title>ปิดร้าน</title>
<link rel="icon" type="image/png" href="../images/favicon.png">
<script src="js/function_3.6.0.js"></script>
<?php
session_start();
include_once("../config.php");
date_default_timezone_set('Asia/Bangkok');
$timenow = date('d-m-Y\ H:i:s');
$daynow  = date('Y-m-d');
$SE_MS   = 0;
$SE_END  = 0;
if (isset($_SESSION['id']) && $_SESSION['id'] !== "") {
    @$user_id = $_SESSION['id'];

    @$result = $mysqli->query("SELECT  id,wh, sta_vat, name, lname FROM `user` WHERE id='$user_id'");
    @$row = $result->fetch_assoc();
    @$user_wh = $row['wh'];
    @$user_id = $row['id'];
    @$S_VAT = $row['sta_vat'];
    @$user_name = $row['name'];
    @$user_lname = $row['lname'];
    //-----------------------------------------------------------------------------------------------
    $UPDATETIMENOW = "UPDATE p_so_mtos SET data_so_end = '$timenow' WHERE wh = '$user_wh' AND userid = '$user_id'";
    $mysqli->query($UPDATETIMENOW);
    //-----------------------------------------------------------------------------------------------
    $p_so_q_all = $mysqli->query("SELECT count(DISTINCT  so) AS SUMALLQTYSO FROM `p_so_h`  WHERE STA = '0' AND iduser = '$user_id' AND date(date_so) = '$daynow'"); /* รวมจำนวนทั้งหมด */
    $row_so_q_all = $p_so_q_all->fetch_assoc();
    $SUMALLQTYSO = $row_so_q_all['SUMALLQTYSO'];
    //-----------------------------------------------------------------------------------------------
    $most = "SELECT * FROM `p_so_mtos` WHERE wh = '$user_wh' AND userid = '$user_id' AND date(date_so) = '$daynow'";
    $result_mo = $mysqli->query($most);
    $row_mo = $result_mo->fetch_assoc();
    @$DATE_ST = $row_mo['date_so'];
    @$DATE_EN = $row_mo['date_so_end'];
    @$SE_MS  = $row_mo['money_start'];
    @$SE_END = $row_mo['money_end'];


    session_destroy();
?>


    <style>
        .test {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid black;
            /* กรอบรอบตาราง */
        }

        .test td,
        .test th {
            border-bottom: 1px solid black;
            /* เส้นแบ่งระหว่างแถว */
            padding: 8px;
        }

        .container-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 95vh;
            /* กำหนดให้มีความสูงเท่ากับความสูงของหน้าจอ */
        }

        body {
            overflow: hidden;
        }

        table.test {
            width: 500px;
            height: 340px;
            /* ให้ขนาดของ table เป็นตามเนื้อหา */
        }

        .button {
            background-color: #E32636;
            border: none;
            color: white;
            width: 50%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            padding: 15px 0px;
        }

        .button:hover {
            background-color: #BA0021;
        }

        .fontheader {
            font-size: 38px;
        }

        .fontcolum {
            font-size: 18px;
        }
    </style>
    <!-- <script>
        function Endstore() {
            window.location.href = "print_report_summary.php";
        }
        // window.history.pushState(null, '', window.location.href);
        // window.addEventListener('popstate', function(event) {
        //     window.history.pushState(null, '', window.location.href);
        // });
    </script> -->
    <!-- <script>
        function Endstore() {
            let user_s = $("#user_s").val();
            let user_sale = $("#user_sale").val();
            let i_DATE1 = $("#i_DATE1").val();
            let i_DATE2 = $("#i_DATE2").val();

            $.ajax({
                type: 'POST',
                url: 'testpost.php',
                data: {
                    user_s: user_s,
                    user_sale: user_sale,
                    i_DATE1: i_DATE1,
                    i_DATE2: i_DATE2
                },
                success: function(data) {
                    console.log(data);
                    // Optionally redirect after successful submission
                    //window.location.href = "testpost.php";
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script> -->



    <body>
        <div class="container-center">
            <table class="test" border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <th colspan="5" align="center" class="fontheader">ปิดร้าน</th>

                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" align="left" class="fontcolum">USER</td>
                        <td colspan="2" align="right" class="fontcolum"><?php echo $user_name; ?>&nbsp;<?php echo $user_lname; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" class="fontcolum">วันที่ปิดร้าน</td>
                        <td colspan="2" align="right" class="fontcolum"><?php echo $timenow; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" class="fontcolum">จำนวนบิลขาย</td>
                        <td colspan="2" align="right" class="fontcolum"><?php echo $SUMALLQTYSO; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" class="fontcolum">จำนวนเงินเปิดร้าน</td>
                        <td colspan="2" align="right" class="fontcolum"><?php echo number_format($SE_MS, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" class="fontcolum">เงินสดทั้งหมดในลิ้นชัก</td>
                        <td colspan="2" align="right" class="fontcolum"><?php echo number_format($SE_END, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center">
                            <form action="print_report_summary.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="user_s" name="user_s" value="<?php echo $user_id ?>">
                                <input type="hidden" id="user_sale" name="user_sale" value="<?php echo $user_wh ?>">
                                <input type="hidden" id="i_DATE1" name="i_DATE1" value="<?php echo date('Y-m-d\TH:i:s', strtotime($DATE_ST)); ?>">
                                <input type="hidden" id="i_DATE2" name="i_DATE2" value="<?php echo date('Y-m-d\TH:i:s', strtotime($timenow)); ?>">
                                <button class="button" onclick="Endstore()">ปิดร้าน</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
<?php
    exit;
} else {
    echo "<meta http-equiv=refresh content=0;url=../index.php>";
    exit;
}
?>