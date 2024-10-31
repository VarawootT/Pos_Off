<?php
$i_USER   = "";
$SE_USER  = "";
$WH       = "";
@$i_DATE1 = $_POST['i_DATE1'];
@$i_DATE2 = $_POST['i_DATE2'];
@$i_USER  = $_POST['user_s'];
@$WH      = $_POST['user_sale'];
if (isset($_GET['r_DATE1'])) {
    @$i_DATE1 = $_GET['r_DATE1'];
    @$i_DATE2 = $_GET['r_DATE2'];
}

if($i_USER != "")
{
    $SE_USER = "AND h.IDUSER = '$i_USER'";
}
if($WH != "")
{
    $SE_WH   = "AND h.wh = '$WH '";
}

@$result = $mysqli->query("SELECT wh, team FROM `user` WHERE id='$user_id'");
@$row = $result->fetch_assoc();

@$S_WH = $row['wh'];
@$S_TEAM = $row['team'];

$s_wh = "SELECT name_wh FROM p_wh WHERE wh = '$S_WH' ";
if ($re_wh = $mysqli->query($s_wh)) {
    while ($wh = $re_wh->fetch_assoc()) {
        $SE_NAME_WH = $wh['name_wh'];
    }
}

?>

<style>
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }
    .paginatetabel {
        margin-top: 7px;
    }

</style>

<div class="card-header bg-secondary">
    <h3 class="card-title"><i class="fas far fas fa-archive mr-2"></i>ประวัติขาย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สาขา : <?php if ($S_WH != 'ALL') {
                                                                                                                                echo $SE_NAME_WH;
                                                                                                                            } else {
                                                                                                                                echo "ALL";
                                                                                                                            } ?></h3>
</div>
<?php
$SUMNET = 0;
?>
<div class="card p-2 card-table-scroll" id="hidtable">
    <div class="card-body">
        <table class="table table-sm table-bordered" id="datatable" style="width:100%">
            <thead class="thead-light">
                <tr>
                    <th>ลำดับ</th>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>สาขา</th>
                    <th>จำนวน</th>
                    <th>ราคาก่อนหักส่วนลด</th>
                    <th>ส่วนลด</th>
                    <th>ยอดก่อนภาษี</th>
                    <th>ภาษี</th>
                    <th>จำนวนเงิน</th>
                    <th>วิธีชำระเงิน</th>
                    <th>พนักงานขาย</th>
                    <th>หมายเหตุ</th>
                    <th>เลขเครื่อง</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if ($S_WH != 'ALL') {
                    $Sel_WH = "AND h.wh = '$S_WH'";
                } elseif ($S_WH == 'ALL' && $S_TEAM != 'ALL') {
                    $Sel_WH = "AND dbo.P_WH.ID_GROUP = '$S_TEAM'";
                } else {
                    $Sel_WH = "";
                }

                $i = 1;
                $DISCOUNT_BATH = 0;
                $SUM_NET = 0;
                $SUM_QTY = 0;
                $SUM_PRICE = 0;
                $SUM_B_DIS_PCS = 0;
                $FSUM_NET = '';
                $FSUM_QTY = '';
                $FSUM_PRICE = '';
                $FSUM_B_DIS_PCS = '';
                $SUMQTY = 0;
                $SUMDIS = 0;
                $SUMBVAT = 0;
                $SUMVAT = 0;
                $SUMNET = 0;
                $SUMGPRICE = 0;
                $s_sql = "SELECT     h.so, h.date_so, wh.NAME_WH, h.NOTE, h.IDUSER, h.sta, h.pay, SUM(d.qty) AS qty, SUM(d.net) AS net, h.gross_price, h.discount,
                h.vat, h.b_vat, h.mac
                FROM        p_so_d AS d INNER JOIN
                            p_so_h AS h ON h.so = d.so INNER JOIN
                            p_wh AS wh ON h.wh = wh.wh 
                WHERE (date(h.date_so) BETWEEN '$i_DATE1' AND '$i_DATE2') $SE_WH $SE_USER
                GROUP BY h.so, h.date_so, wh.NAME_WH, h.NOTE, h.IDUSER, h.sta, h.pay
                ORDER BY h.date_so";
                //echo "--$s_sql--<br>";
                if ($re_sql = $mysqli->query($s_sql)) {
                    while ($sql = $re_sql->fetch_assoc()) {
                        $SE_DATE_SO = $sql['date_so'];
                        $SE_SO = $sql['so'];
                        $SE_NAME_WH = $sql['NAME_WH'];
                        $SE_IDUSER = $sql['IDUSER'];
                        $SE_NOTE = $sql['NOTE'];
                        $SE_STA = $sql['sta'];
                        $SE_PAY = $sql['pay'];
                        $SE_QTY = $sql['qty'];
                        $SE_NET = $sql['net'];
                        $SE_G_PRICE = $sql['gross_price'];
                        $SE_DIS = $sql['discount'];
                        $SE_VAT = $sql['vat'];
                        $SE_B_VAT = $sql['b_vat'];
                        $SE_MAC = $sql['mac'];

                        $SUMQTY += $SE_QTY;
                        $SUMGPRICE += $SE_G_PRICE;
                        $SUMDIS += $SE_DIS;
                        $SUMBVAT += $SE_B_VAT;
                        $SUMVAT += $SE_VAT;
                        $SUMNET += $SE_NET;
                        // echo $SUMNET;
                        @$result_u = $mysqli->query("SELECT name FROM `user` WHERE `id` = '$SE_IDUSER'");
                        @$row_u = $result_u->fetch_assoc();
                        @$S_NAME = $row_u['name'];

                        if ($SE_PAY == 'cash') {
                            $S_PAY = "เงินสด";
                        } elseif ($SE_PAY == 'card') {
                            $S_PAY = "บัตรเครดิต";
                        } else {
                            $S_PAY = "โอน";
                        }

                        $SE_DATE_SO = date("d/m/Y", strtotime($SE_DATE_SO));

                        //----------------------------
                ?>
                        <tr>
                            <td class="pl-3"><?php echo $i ?></td>
                            <td><?php echo $SE_DATE_SO ?></td>
                            <td><?php echo "INV$SE_SO";
                                if ($SE_STA == 1) {
                                    echo " <font color=\"red\">(ยกเลิก)</font>";
                                } ?></td>
                            <td><?php echo $SE_NAME_WH ?></td>
                            <td><?php echo number_format($SE_QTY) ?></td>
                            <td><?php echo number_format($SE_G_PRICE,2) ?></td>
                            <td><?php echo number_format($SE_DIS,2) ?></td>
                            <td><?php echo number_format($SE_B_VAT,2) ?></td>
                            <td><?php echo number_format($SE_VAT,2) ?></td>
                            <td><?php echo number_format($SE_NET,2) ?></td>
                            <td><?php echo $S_PAY ?></td>
                            <td><?php echo $S_NAME ?></td>
                            <td><?php echo $SE_NOTE ?></td>
                            <td><?php echo $SE_MAC ?></td>
                            <td>
                                <!-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#<?PHP echo $SE_SO ?>Modal"><i class="fas fa-search"></i></button> -->
                                <a href="javascript:void(0);" onclick="openPrintWindow('<?php echo $SE_SO; ?>')">
                                    <div class="btn btn-secondary confirmation1 btn-sm">
                                        <i class="fas fa-print"></i>
                                    </div>
                                </a>
                                <?php
                                if ($SE_STA == 0) {
                                ?>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#ChkDel<?PHP echo $SE_SO ?>"><i class="fas fa-times"></i></button>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <!-- Modal Del -->
                        <div class="modal fade" id="ChkDel<?PHP echo $SE_SO ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ChkDel<?PHP echo $SE_SO ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="checkDeleteLabel<?PHP echo $SE_SO ?>">หมายเหตุ</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea name="FromNote" id="FromNote<?PHP echo $SE_SO ?>" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                        <button type="button" class="btn btn-primary" onclick="cancel(<?PHP echo $SE_SO ?>,'<?php echo $i_DATE1 ?>','<?php echo $i_DATE2 ?>','<?php echo $SE_SO ?>')">ยกเลิก</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php
                        $i++;
                    }
                }
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td style="text-align: right;"><b>รวม&nbsp;</b></td>
                    <td><b><?php echo number_format($SUMQTY, 2) ?></b></td>
                    <td><b><?php echo number_format($SUMGPRICE, 2) ?></b></td>
                    <td><b><?php echo number_format($SUMDIS, 2) ?></b></td>
                    <td><b><?php echo number_format($SUMBVAT, 2) ?></b></td>
                    <td><b><?php echo number_format($SUMVAT, 2) ?></b></td>
                    <td><b><?php echo number_format($SUMNET, 2) ?></b></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            <tbody>
        </table>
    </div>
</div>

<script>
    $(function() {
        $('#datatable').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            buttons: [{
                    extend: 'pageLength',
                    className: 'btn-primary'
                },
                {
                    extend: 'csv',
                    className: 'btn-info'
                },
                {
                    extend: 'excel',
                    className: 'btn-success'
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    className: 'btn-danger'
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    },
                    className: 'btn-warning',
                    autoPrint: false
                }
            ],
            initComplete: function() {
                $('#datatable_info, #datatable_paginate').wrapAll('<div class="row">');
                $('#datatable_info').wrapAll('<div class="col-sm-12 col-md-5 infotabel">');
                $('#datatable_paginate').wrapAll('<div class="col-sm-12 col-md-7 paginatetabel">');
                $('.dataTables_filter').css({
                    'float': 'right',
                    'margin-top': '7px' // Add margin-top for adjusting the position
                });
                $('.dataTables_filter input').css('width', 'auto');
            },
            order: [],
            scrollY: true,
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedHeader: true,

        });
        $(document).on("click", ".button-page-length span", function() {
            $("#hidtable").removeClass("card-table-scroll");
        });
    });

    // -----------------------Cancel

    function cancel(id, i_DATE1, i_DATE2, SO) {
        let Note = $("#FromNote" + SO).val()
        if (confirm("ต้องการ ยกเลิก ใช่หรือไม่"))
            $.ajax({
                type: "CANCEL",
                url: "ajax_so_his.php?MODE=cancel&id=" + id + "&i_DATE1=" + i_DATE1 + "&i_DATE2=" + i_DATE2 + "&Note=" + Note,
                success: function(data) {
                    window.location.href = "index.php?link=s_so_his&r_DATE1=" + i_DATE1 + "&r_DATE2=" + i_DATE2;
                },
                error: function(xhr, status, exception) {
                    alert(status);
                }
            });
    }
</script>
<script type="text/javascript">
    function openPrintWindow(so) {
        
        // สร้าง URL พร้อมพารามิเตอร์
        const url = `print_pos.php?so=` + so;
        
        // เปิดหน้าต่างพิมพ์
        const printWindow = window.open(url);
        
        if (printWindow) {
            printWindow.onload = function() {
                printWindow.print(); // เรียกพิมพ์
                setTimeout(function() {
                    printWindow.close(); // ปิดหน้าต่างหลังจากพิมพ์
                }, 750);
            };
        }
    }
</script>