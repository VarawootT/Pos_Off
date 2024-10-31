<?php 
session_start();
include_once("../config.php");

@$user_id=$_SESSION['id'];

@$result = $mysqli->query("SELECT name, lname, group_menu, wh,user FROM `user` WHERE id='$user_id'");
@$row = $result->fetch_assoc();
@$user_id_name = $row['user'];
@$user_name=$row['name'];
@$user_lname=$row['lname'];
@$user_group=$row['group_menu'];
@$user_wh=$row['wh'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- favicon.ico -->
    <link rel="icon" type="image/png" href="../images/favicon.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../node_modules_s/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../node_modules_s/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../node_modules_s/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../node_modules_s/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../node_modules_s/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../node_modules_s/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../node_modules_s/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../node_modules_s/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="../asset/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/dashboard.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="../node_modules_s/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../node_modules_s/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- jQuery -->
    <script src="../node_modules_s/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap 4 -->
    <script src="../node_modules_s/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules_s/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- jquery-3.6.0 -->
    <script src="js/function_3.6.0.js"></script>

    <!-- jquery-sweetalert2 -->
    <script src="js/function_sweetalert2.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="../node_modules_s/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../node_modules_s/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../node_modules_s/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../asset/datatable/fixedHeader.bootstrap4.min.css">

    <!-- <link rel="stylesheet" href="../asset/css/login.css"> -->
</head>
<title><?php echo "$title";?></title>
<style type="text/css">
    .marlogo {
        text-align: center;
        margin-top: 3%;
    }

    body {
        margin: 0px;
        font-family: Arial, Helvetica, sans-serif;
        font-family: 'Kanit', sans-serif;
        background-image: url("../images/test007.jpeg"); 
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

    .martitle {
        text-align: center;
    }

    .marlogin {
        justify-content: center;
    }

    .form-control2 {
        font-family: "Roboto", sans-serif;
        outline: 0;
        background: #f2f2f2;
        width: 100%;
        border: 0;
        margin: 0 0 15px;
        padding: 15px;
        box-sizing: border-box;
        font-size: 14px;
    }

    .button {
        background-color: #28A745;
        border: none;
        color: white;
        width: 100%;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        padding: 15px 0px;
    }

    .button1 {
        background-color: #FF0000;
        border: none;
        color: white;
        width: 100%;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        padding: 15px 0px;
    }

    .bottn {
        text-align: center;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        width: 100%;
        padding: 15px 0px;

    }

    .row {
        display: flex;
        /* Use flexbox for alignment */
        justify-content: center;
        /* Center contents */
        width: 100%;
        margin: 2px 0;
        /* Add margin for spacing */
    }

    .button:hover {
        background-color: #1a8a34;
    }

    section {
        width: 360px;
        height: 320px;
        background-color: rgb(3 48 53 / 73%);
        margin: 13% auto;
        padding: 20px;
    }

    .row-col-12 {
        justify-content: center;
    }

    @media only screen and (max-width: 600px) {
        section {
            width: 360px;
            height: 450px;
            background-color: rgb(0, 0, 0, 0.5);
            margin: 10% auto;
            padding: 40px;
        }
    }


    /* mobile */

    @media only screen and (max-width: 360px) {
        section {
            width: 300px;
            height: 350px;
            background-color: rgb(0, 0, 0, 0.5);
            margin: 10% auto;
            padding: 20px;
        }
    }
</style>
<!-- <body>
    <div class="card-body">
        <input type="text">
        <button type="submit" class="btn btn-primary" name="sub_int" id="sub_int" value="int">ค้นหา</button>
    </div>
</body> -->

<section class="marlogin">

    <!-- <br> -->
    <div class="container text-center">

        <form action="chk_store.php" method="post" onsubmit="return chkSub(this)" />

        <div class="row col-sm-12" style="padding-bottom : 35px;color: white;">USER : <?php echo "$user_id_name - $user_name - $user_lname";  ?></div>

        <div class="row col-sm-12">
            <input name="money" type="text" class="form-control2" placeholder="$ จำนวนเงินเปิดร้าน" aria-label="Username" aria-describedby="addon-wrapping" min="0" oninput="formatNumber(this)">
        </div>

        <div class="row col-sm-12">
            <button class="btn btn-success bottn" type="submit" name="status" value="SHOPSTART">กำหนดเงินเปิดร้าน</button>
        </div>

        <div class="row col-sm-12">
            <button class="btn btn-danger bottn" type="submit" name="status" value="SHOPSTART_NO">ไม่กำหนดเงินเปิดร้าน</button>
        </div>

        </form>

    </div>
</section>

<script>
function formatNumber(input) {
    // ลบค่าที่ไม่ใช่ตัวเลข
    let value = input.value.replace(/,/g, '').replace(/[^0-9.]/g, '');

    // แยกส่วนทศนิยม
    let parts = value.split(".");
    
    // เพิ่มคอมม่าในส่วนจำนวนเต็ม
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    // รวมส่วนทศนิยมกลับเข้ามา
    input.value = parts.join(".");
}
</script>

<!-- ChartJS -->
<script src="../node_modules_s/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../node_modules_s/plugins/sparklines/sparkline.js"></script>
<!-- jQuery Knob Chart -->
<script src="../node_modules_s/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../node_modules_s/plugins/moment/moment.min.js"></script>
<script src="../node_modules_s/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../node_modules_s/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../node_modules_s/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../node_modules_s/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../node_modules_s/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../node_modules_s/dist/js/demo.js"></script>

<!-- DataTables  & Plugins -->
<script src="../node_modules_s/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../node_modules_s/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../node_modules_s/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../node_modules_s/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../node_modules_s/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../node_modules_s/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../node_modules_s/plugins/jszip/jszip.min.js"></script>
<script src="../node_modules_s/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../node_modules_s/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../node_modules_s/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../node_modules_s/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../node_modules_s/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="../asset/datatable/dataTables.fixedHeader.min.js"></script>

<!-- Select2 -->
<script src="../node_modules_s/plugins/select2/js/select2.full.min.js"></script>