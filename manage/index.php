<?php
session_start();
include_once("../config.php");

if (isset($_GET["link"])) {
    $link = $_GET['link'];
}

@$user_id = $_SESSION['id'];

@$result = $mysqli->query("SELECT name, lname, group_menu, wh FROM `user` WHERE id='$user_id'");
@$row = $result->fetch_assoc();

@$user_name = $row['name'];
@$user_lname = $row['lname'];
@$user_group = $row['group_menu'];
@$user_wh = $row['wh'];

if ($user_id != "") {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
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

        <title><?php echo "$title"; ?></title>

        <style>
            .custom-search-ajax {
                position: absolute;
                z-index: 9999;
                background-color: white;
                width: 95%;
                border: 1px solid;
                border-color: #f9f9f9;
            }

            .custom-search-ajax>div>div {
                padding: 5px;
                width: 100%;
            }

            .custom-search-ajax>div>div:hover {
                background-color: #0069d9;
                color: azure;
            }

            .custom-search-ajax-scroll {
                position: absolute;
                z-index: 9999;
                background-color: white;
                width: 95%;
                border: 1px solid;
                border-color: #f9f9f9;
            }

            .custom-search-ajax-scroll>div {
                height: 300px;
                overflow: auto;
            }

            .custom-search-ajax-scroll>div>div {
                padding: 5px;
                width: 100%;
            }

            .custom-search-ajax-scroll>div>div:hover {
                background-color: #0069d9;
                color: azure;
            }

            .card-table-scroll {
                height: 635px;
                overflow: auto;
            }

            .card-table-scroll-500 {
                height: 500px;
                overflow: auto;
            }

            .card-table-scroll-custom {
                height: 750px;
                overflow: auto;
            }

            @page {
                size: auto;
            }
        </style>
        <script>
            function closeStore() {
                window.location.href = "CloseStore.php";
            }
        </script>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <section class="warpper">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
                <?php
                date_default_timezone_set('Asia/Bangkok');
                $today = date('Y-m-d');
                $money_day = 0;
                $check_id = "SELECT * FROM p_so_mtos WHERE wh = '$user_wh' AND userid = '$user_id'  AND DATE(date_so) = '$today'"; // AND userid = '$user_id' 
                $result_ck = $mysqli->query($check_id);
                if ($result_ck && $result_ck->num_rows > 0) {
                    $row = $result_ck->fetch_assoc();
                    $money_day = $row['money_end']; // เข้าถึงข้อมูลเมื่อมีแถวที่คืนมา
                    $money_days = $row['money_start'];
                } else {
                    $money_day = 0;
                    $money_days = 0;
                }

                ?>
                <div class="ml-auto d-flex align-items-center" style="gap: 15px;">
                    
                    <div class="d-flex align-items-center">
                        <label class="mb-0 mr-2" for="">เงินสดเริ่มต้น :</label>
                        <input class="form-control form-control-sm" type="text"
                            style="text-align: right; width: 180px;"
                            value="<?php echo number_format($money_days, 2); ?> THB" readonly />
                    </div>
                    <div class="d-flex align-items-center">
                        <label class="mb-0 mr-2" for="">เงินสดทั้งหมดในลิ้นชัก :</label>
                        <input class="form-control form-control-sm" type="text"
                            style="text-align: right; width: 180px;"
                            value="<?php echo number_format($money_day, 2); ?> THB" readonly />
                    </div>
                    <button class="btn btn-danger btn-sm ml-2" onclick="closeStore()">ปิดร้าน</button>
                </div>
            </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index.php" class="brand-link">
                    <img src="../images/dashboard/logo_small.jpg" alt="<?php echo "$title"; ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light"><?php echo "$title"; ?></span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="../images/dashboard/user.png" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block"><?php echo "$user_name" . ' ' . "$user_lname"; ?></a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                            <?php

                            //--------------------------permission menu
                            if ($user_group != '') {
                                $sql_p = "SELECT ref_menu FROM permission WHERE group_menu = '$user_group' GROUP BY ref_menu ORDER BY no ";
                            } else {
                                $sql_p = "SELECT ref_menu FROM permission WHERE ref_user = '$user_id' GROUP BY ref_menu ORDER BY no ";
                            }
                            //echo "--$sql_p---<br>";
                            $query_p = mysqli_query($mysqli, $sql_p);
                            while ($result_p = mysqli_fetch_array($query_p, MYSQLI_ASSOC)) {
                                $se_ref_menu = $result_p['ref_menu'];

                                //--------------------------menu
                                $se_link_m = '';
                                $sql_m = "SELECT name_th, name_en, class, link, id FROM menu WHERE id = '$se_ref_menu' AND (sta = 'A' OR sta = 'P') ";
                                $query_m = mysqli_query($mysqli, $sql_m);
                                while ($result_m = mysqli_fetch_array($query_m, MYSQLI_ASSOC)) {
                                    $se_id_m = $result_m['id'];
                                    $se_name_th_m = $result_m['name_th'];
                                    $se_class_m = $result_m['class'];
                                    $se_link_m = $result_m['link'];

                                    echo "<li class=\"nav-item\">
                                        <a href=\"$se_link_m\" class=\"nav-link\">
                                        <i class=\"$se_class_m\"></i>
                                        <p class=\"text\">$se_name_th_m</p>
                                        </a>";
                                }

                                //--------------------------permission menu detail

                                if ($user_group != '') {
                                    $sql_d = "SELECT ref_menu_detail FROM permission WHERE group_menu = '$user_group' ORDER BY no ";
                                } else {
                                    $sql_d = "SELECT ref_menu_detail FROM permission WHERE ref_user = '$user_id' ORDER BY no ";
                                }
                                //echo "--$sql_d---<br>";
                                $query_d = mysqli_query($mysqli, $sql_d);
                                while ($result_d = mysqli_fetch_array($query_d, MYSQLI_ASSOC)) {
                                    $se_ref_menu_d = $result_d['ref_menu_detail'];

                                    //--------------------------menu detail
                                    $se_link_md = '';
                                    $sql_md = "SELECT name, link FROM menu_detail WHERE ref_id_menu = '$se_id_m' AND id = '$se_ref_menu_d' AND (sta = 'A' OR sta = 'P') ";
                                    $query_md = mysqli_query($mysqli, $sql_md);
                                    while ($result_md = mysqli_fetch_array($query_md, MYSQLI_ASSOC)) {
                                        $se_name_md = $result_md['name'];
                                        $se_link_md = $result_md['link'];

                                        echo "<ul class=\"nav nav-treeview\">

                                                    <li class=\"nav-item pl-4\">
                                                        <a href=\"$se_link_md\" class=\"nav-link\">
                                                            <i class=\"far fas fa-angle-double-right\"></i>
                                                            <p>$se_name_md</p>
                                                        </a>
                                                    </li>

                                                </ul>";
                                    }
                                    //--------------------------                                       
                                }
                                echo "</li>";
                            }
                            //--------------------------
                            ?>

                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper bg-white">
                <!-- check include show file -->
                <?php

                if (isset($link)) {
                    $LinkFile = $link . ".php";
                    include_once("$LinkFile");
                } else {
                    include_once("menu.php");
                }

                ?>
            </div>

            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong><?php echo "$Copyright"; ?></strong>
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.0.0
                </div>
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
        </section>

        <!-- jQuery UI 1.11.4 -->
        <script src="../node_modules_s/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!--นำเข้าไฟล์  Css -->

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

        <!-- Page specific script -->
        <script>
            $(function() {
                $('.select2').select2()
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            });
        </script>

    </body>

    </html>

<?php
} else {
    echo "<script language='javascript'>
        alert('กรุณา Login ใหม่เนื่องจากไม่มีการใช้งานเป็นเวลานาน','ok')
                </script>";
    echo "<meta http-equiv=refresh content=0;url=../logout.php>";
}
?>