<?php
$se_name_wh = '';
$qry = "SELECT name_wh FROM p_wh WHERE wh='$user_wh'";
if ($result = $mysqli->query($qry)) {
	while ($row = $result->fetch_assoc()) {
		$se_name_wh = $row['name_wh'];
	}
}

?>
<style>
	.hi {
		height: 10px;
	}

	#stafree,
	#split {
		margin-right: 10px;
		vertical-align: middle;
		/* เว้นระยะห่างระหว่าง checkbox และ label */
	}

	.labelck {
		margin-right: 10px;
		/* เว้นระยะห่างระหว่าง checkbox และ label ตัวถัดไป */
	}
</style>
<script>
	function add(mode) {

		if (mode == 1) { //--Add

			let i_BAR = $("#exampleDataList").val()
			let i_QTY = $("#i_QTY").val()
			let i_DIS = $("#i_DIS").val()
			let i_DATE = $("#i_DATE").val();
			let i_free = $("#stafree").is(":checked") ? 1 : 0;
			let i_split = $("#split").is(":checked") ? 1 : 0;
			// alert(i_BAR)

			if (i_BAR == "") {
				alert("กรุณาใส่ รุ่น ด้วยครับ")
				form.i_BAR.focus();
				return false;
			} else if (i_QTY == "") {
				alert("กรุณาใส่ จำนวน ด้วยครับ")
				form.i_QTY.focus();
				return false;
			} else {

				$.ajax({
					type: "PUT",
					url: "ajax_pos.php?MODE=add&i_BAR=" + i_BAR + "&i_QTY=" + i_QTY + "&i_DIS=" + i_DIS + "&i_free=" + i_free + "&i_split=" + i_split,
					success: function(data) {
						console.log(data);

						var text = data.split("|")
						if (text[1] == 1) {
							alert("ไม่พบรหัสสินค้า !!!");
						} else {
							window.location.href = "index.php?link=frm_in_pos&DIS=" + i_DIS + "&i_DATE=" + i_DATE;
						}
					},
					error: function(xhr, status, exception) {
						alert(status);
					}
				});
			}
		}
	}

	// -----------------------Del

	function del(id) {
		let i_DATE = $("#i_DATE").val();
		if (confirm("ต้องการ ลบ ข้อมูลใช่หรือไม่"))
			$.ajax({
				type: "DELETE",
				url: "ajax_pos.php?MODE=delete&id=" + id,
				success: function(data) {
					window.location.href = "index.php?link=frm_in_pos&i_DATE=" + i_DATE;
				},
				error: function(xhr, status, exception) {
					alert(status);
				}
			});
	}

	// -----------------------Edit

	function edit(id) {
		let t_price = $("#t_price" + id).val()
		let t_qty = $("#t_qty" + id).val()
		let t_dis = $("#t_dis" + id).val()
		let t_unit = $("#t_unit" + id).val()
		let t_note = $("#t_note" + id).val()
		let i_DATE = $("#i_DATE").val();

		if (t_dis != "0" && t_unit == "") {
			alert("กรุณาใส่ หน่วย ด้วยครับ")
			form.i_BAR.focus();
			return false;
		}

		$.ajax({
			type: "EDIT",
			url: "ajax_pos.php?MODE=edit&id=" + id + "&t_price=" + t_price + "&t_qty=" + t_qty + "&t_dis=" + t_dis + "&t_unit=" + t_unit + "&t_note=" + t_note,
			success: function(data) {

				window.location.href = "index.php?link=frm_in_pos&i_DATE=" + i_DATE;
			},
			error: function(xhr, status, exception) {
				alert(status);
			}
		});
	}

	// -----------------------Dis H

	function fn_dis() {
		let dis_h = $("#i_DIS_H").val()
		let dis_h_type = $("#i_UNIT").val()

		$.ajax({
			type: "EDIT",
			url: "ajax_pos.php?MODE=dis&dis_h=" + dis_h + "&dis_h_type=" + dis_h_type,
			success: function(data) {
				window.location.href = "index.php?link=frm_in_pos";
			},
			error: function(xhr, status, exception) {
				alert(status);
			}
		});
	}

	// -----------------------Cancel

	function cancel(id) {
		if (confirm("ต้องการ ยกเลิก ใช่หรือไม่"))
			$.ajax({
				type: "CANCEL",
				url: "ajax_pos.php?MODE=cancel&id=" + id,
				success: function(data) {
					//console.log(data)
					window.location.href = "index.php?link=frm_in_pos";
				},
				error: function(xhr, status, exception) {
					alert(status);
				}
			});
	}

	// -----------------------Pause

	function pause() {
		let i_NOTE = $("#i_NOTE").val()
		$.ajax({
			type: "PAUSE",
			url: "ajax_pos.php?MODE=pause&i_NOTE=" + i_NOTE,
			success: function(data) {
				window.location.href = "index.php?link=frm_in_pos";
			},
			error: function(xhr, status, exception) {
				alert(status);
			}
		});
	}

	// -----------------------print

	function print() {
		let i_DATE = $("#i_DATE").val()
		let i_QTY = $("#show").val()
		let loss_QTY = $("#ishow").val()
		let i_NOTE = $("#note").val()
		let rshow = $("#rshow").val()
		let pay = $('input[name="pay"]:checked').val();
		//   alert(loss_QTY)
		if (pay == undefined) {
			alert("กรุณาเลือก ช่องทางชำระเงิน ด้วยครับ")
			form.pay.focus();
			return false;
		} else if (i_QTY == "") {
			alert("กรุณาเลือก จำนวนเงิน ด้วยครับ")
			form.i_QTY.focus();
			return false;
		} else if (loss_QTY != 0) {
			alert("จำนวนเงินไม่พอจ่าย")
			form.loss_QTY.focus();
			return false;
		} else {
			$.ajax({
				type: "PRINT",
				url: "ajax_pos.php?MODE=print&i_DATE=" + i_DATE + "&i_QTY=" + i_QTY + "&pay=" + pay + "&i_NOTE=" + i_NOTE + "&rshow=" + rshow,
				success: function(data) {
					//console.log(data);
					window.location.href = "print_pos.php";
				},
				error: function(xhr, status, exception) {
					alert(status);
				}
			});
		}
	}
	//-------------------------------
</script>
<!-- <script>
function inputnum(value, sum_net) {
    // Remove commas from the input values
    const received = parseNumber(value.replace(/,/g, '')) || 0;
    const total = parseNumber(sum_net.replace(/,/g, '')) || 0;

    const shortage = total - received;
    const change = received > total ? received - total : 0;

    document.getElementById('ishow').value = shortage > 0 ? shortage : 0;
    document.getElementById('rshow').value = change;
}
</script> -->
<?php
@$SE_DATE = $_GET['i_DATE'];
?>
<div class="card-header bg-secondary">
	<h3 class="card-title"><i class="fas fa-cart-plus mr-2"></i>ขายหน้าร้าน</h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $se_name_wh; ?>
</div>

<!-- -------------------------------Start H1-->

<table width="100%" border="1" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td width="75%">
				<br>
				<div class="container">

					<div class="form-group row">
						<!--col12-->
						<div class="col-2 col-md-1 text-right"><label for="i_DATE" class="col-form-label">วันที่ :</label></div>
						<div class="col-2 col-md-2"><input class="form-control form-control-sm" type="datetime-local" id="i_DATE" name="i_DATE" value="<?php echo $SE_DATE ?>"></div>

						<div class="col-1 col-md-1 text-right"><label for="i_QTY" class="col-form-label">จำนวน :</label></div>
						<div class="col-2 col-md-1"><input class="form-control form-control-sm" type="number" id="i_QTY" name="i_QTY" value="1" min="1"></div>

						<div class="col-1 col-md-1 text-right"><label for="i_DIS" class="col-form-label">ส่วนลด :</label></div>
						<div class="col-2 col-md-2">
							<select class="form-control form-control-sm" style="width: 80%;" name="i_DIS" id="i_DIS">
								
								<?php
								$i_DIS = $_GET['DIS'];
								if (empty($i_DIS)) { ?>
									<option value="" selected disabled>เลือกส่วนลดที่ต้องการ</option>
									<option value="">ไม่มีส่วนลด</option>

									<?php
									$sql = "SELECT id,name FROM p_dis_h";
									$result = $mysqli->query($sql);
									while ($row = $result->fetch_assoc()) {
										$SE_ID = $row['id'];
										$SE_NAME = $row['name'];
										echo "<option value=\"$SE_ID\">$SE_NAME</option>";
									}
									?>
								<?php } else {
									$sql3 = "SELECT id,name FROM p_dis_h WHERE id = '$i_DIS'";
									echo $sql3;
									$result3 = $mysqli->query($sql3);
									while ($row3 = $result3->fetch_assoc()) {
										$SE_NAME_GET = $row3['name'];
									}
									echo "<option value=\"$i_DIS\">$SE_NAME_GET</option>";
									$sql = "SELECT id,name FROM p_dis_h WHERE NOT id = '$i_DIS'";
									$result = $mysqli->query($sql);
									while ($row = $result->fetch_assoc()) {
										$SE_ID = $row['id'];
										$SE_NAME = $row['name'];

										echo "<option value=\"$SE_ID\">$SE_NAME</option>";
									}
									echo "<option value=''>ไม่มีส่วนลด</option>";
								} ?>

							</select>
						</div>
						<div class="col-2 col-md-2 pt-1">
							<input type="checkbox" id="stafree" name="stafree" value="1"> <label class="labelck" for="stafree">แถม</label>
							<input type="checkbox" id="split" name="split" value="1"><label class="labelck" for="split">แยก</label>
						</div>
					</div>

					<div class="form-group row">
						<!--col12-->
						<div class="col-1 col-md-1 text-right"><label for="i_BAR" class="col-form-label">สินค้า :</label></div>
						<div class="col-2 col-md-5">

							<!-- <input class="form-control form-control-sm" type="text" placeholder="Scan Barcode หรือ พิมพ์ เพื่อค้นหาสินค้า" id="i_BAR" name="i_BAR" onchange="add(1)"> -->

							<input class="form-control form-control-sm" list="i_BAR" id="exampleDataList" placeholder="Scan Barcode หรือ พิมพ์ เพื่อค้นหาสินค้า" name="i_BAR" oninput="checkInputLength()">
							<datalist id="i_BAR">

							</datalist>

						</div>
						<div class="col-2 col-md-5">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal4" style="font-size:12px;">รายการพักการขาย</button>
						</div>
						<div class="col-2 col-md-1"></div>
					</div>

				</div>

				<!------------------------------------------>

				<!-- -------------------------------End H2 -->
				<table class="table table-sm">
					<thead class="thead-light">
						<tr>
							<th><small><b>No</b></small></th>
							<th><small><b>สินค้า</b></small></th>
							<th><small><b>หมายเหตุ</b></small></th>
							<th><small><b>ราคาขาย</b></small></th>
							<th><small><b>จำนวน</b></small></th>
							<th><small><b>ส่วนลด</b></small></th>
							<th><small><b>สุทธิ(ต่อหน่วย)</b></small></th>
							<th><small><b>สุทธิ</b></small></th>
							<th style="width: 110px;"><small><b>เลือกรายการ</b></small></th>
						</tr>
					</thead>
					<tbody>
						<?php

						$i = 1;
						$DISCOUNT_BATH = 0;
						$DISCOUNT_BATHONEQTY = 0;
						$SE_DIS = 0;

						$SUM_NET = 0;
						$SUM_QTY = 0;
						$SUM_PRICE_N = 0;
						$SUM_DIS = 0;

						$SE_DIS_H = 0;
						$SE_UNIT_H = '';

						$FSUM_NET = '';
						$FSUM_QTY = '';
						$FSUM_DIS = '';
						$NETNOTQTY = 0;
						$SUM_FNET = 0;
						$s_tem = "SELECT id, pn, price, dis_d, unit_d, SUM(qty) AS qty, dis_h, unit_h, NOTE, free_s FROM p_so_tem GROUP BY id, pn, price, dis_d, unit_d, free_s ORDER BY id ASC ";
						if ($re_tem = $mysqli->query($s_tem)) {
							while ($row_tem = $re_tem->fetch_assoc()) {
								$SE_ID = $row_tem['id'];
								$SE_PN = $row_tem['pn'];
								$SE_QTY = $row_tem['qty'];
								$SE_PRICE = $row_tem['price'];
								$SE_DIS_D = $row_tem['dis_d'];
								$SE_UNIT_D = $row_tem['unit_d'];
								$SE_DIS_H = $row_tem['dis_h'];
								$SE_UNIT_H = $row_tem['unit_h'];
								$SE_NOTE = $row_tem['NOTE'];
								$SE_FREE = $row_tem['free_s'];

								if ($SE_UNIT_D == '%') {

									$DISCOUNT_BATH = ($SE_PRICE * $SE_DIS_D) / 100 * $SE_QTY;
									$DISCOUNT_BATHONEQTY = ($SE_PRICE * $SE_DIS_D) / 100;
									$NET = ($SE_PRICE * $SE_QTY) - $DISCOUNT_BATH;
									$NETNOTQTY = $SE_PRICE - $DISCOUNT_BATHONEQTY;
									$B_DISCOUNT = $DISCOUNT_BATH;
								} else if ($SE_UNIT_D == 'r') {
									$SQL_CH_PRICE = "SELECT price FROM `p_dis_d` WHERE pn = '$SE_PN' AND  id_dis = '$SE_DIS_D'";
									$result_ch = $mysqli->query($SQL_CH_PRICE);
									$row_ch = $result_ch->fetch_assoc();
									@$SE_CH_PRICE = $row_ch['price'];
									$SQL_CK_ID = "SELECT name FROM `p_dis_h` WHERE id = '$SE_DIS_D'";
									$result_hch = $mysqli->query($SQL_CK_ID);
									$row_ch = $result_hch->fetch_assoc();
									@$SE_DIS_NAME = $row_ch['name'];
									$B_DISCOUNT = $SE_QTY * ($SE_PRICE - $SE_CH_PRICE) ;
									$NET = ($SE_CH_PRICE * $SE_QTY);
								} else {
									$B_DISCOUNT = $SE_DIS_D;
									$NET = ($SE_PRICE * $SE_QTY) - ($SE_DIS_D * $SE_QTY);
								}

								$SE_PRICE_N = $SE_PRICE * $SE_QTY;

								$SUM_NET += $NET;
								$SUM_QTY += $SE_QTY;
								$SUM_PRICE_N += $SE_PRICE_N;
								$SUM_DIS += $B_DISCOUNT;

								$FSUM_QTY = number_format($SUM_QTY);
								$FSUM_DIS = number_format($SUM_DIS, 2);

								$FSE_QTY = number_format($SE_QTY);
								$FSE_PRICE = number_format($SE_PRICE, 2);
								$FNET = number_format($NET, 2);

								$SUM_FNET += $NET;

						?>
								<tr>
									<td class="pl-3"><small><?php echo $i ?></small></td>
									<td><small><?php echo $SE_PN; ?><?php if ($SE_FREE == "1") {
																		echo ' <span style="color: red;">*ฟรี</span>';
																	} ?></small></td>
									<td><small><?php echo $SE_NOTE ?></small></td>
									<td><small><?php if ($SE_UNIT_D == 'r') { echo $SE_CH_PRICE; } else { echo $FSE_PRICE; }  ?></small></td>
									<td><small><?php echo $FSE_QTY ?></small></td> 
									<?php if ($SE_PN) ?>
									<td><small id="discount-info"><?php if($SE_UNIT_D == 'r') { echo "$SE_DIS_NAME";}else{ echo "$SE_DIS_D $SE_UNIT_D" ;} ?></small></td>

									<td><small><?php
												if ($SE_UNIT_D == 'r') {
													echo $SE_CH_PRICE;
												} else {

													if ($DISCOUNT_BATHONEQTY == 0) {
														echo $SE_PRICE;
													} else {
														echo number_format($NETNOTQTY, 2);
													}
												}
												?>

										</small></td>
									<td><small><?php echo $FNET; ?></small></td>
									<td>
										<button type="button" class="btn btn-warning p-2" data-toggle="modal" data-target="#exampleModal<?php echo $SE_ID ?>" style="font-size:10px;" title="Edit">
											<i class="fas fa fa-pen" aria-hidden="true"></i>
										</button>
										<button type="button" class="btn btn-danger p-2" onClick="del(<?php echo $SE_ID ?>)" style="font-size:10px;" title="Delete">
											<i class="fas fa-trash-alt" aria-hidden="true"></i>
										</button>
									</td>
								</tr>

								<!-- Modal1 -->
								<div class="modal fade" id="exampleModal<?php echo $SE_ID ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel<?php echo $SE_ID ?>" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="form-group row">
											</div>
											<div class="form-group row ">
												<label for="t_qty" class="col-sm-4 col-form-label text-right">ราคา :</label>
												<div class="col-sm-3"><input type="text" class="form-control form-control-sm" placeholder="ราคา" id="t_price<?php echo $SE_ID ?>" value="<?php echo number_format($SE_PRICE, 2) ?>"></div>
												<div class="col-sm-5"></div>
											</div>

											<div class="form-group row ">
												<label for="t_qty" class="col-sm-4 col-form-label text-right">จำนวน :</label>
												<div class="col-sm-3"><input type="number" class="form-control form-control-sm" placeholder="จำนวน" id="t_qty<?php echo $SE_ID ?>" value="<?php echo $SE_QTY ?>" min="1"></div>
												<div class="col-sm-5"></div>
											</div>

											<div class="form-group row ">
												<label for="add-PN" class="col-sm-4 col-form-label text-right">ส่วนลด : </label>
												<div class="col-sm-3">
													<input type="number" class="form-control form-control-sm" placeholder="ส่วนลด" id="t_dis<?php echo $SE_ID ?>" value="<?php echo $SE_DIS_D ?>" min="0">
												</div>
												<div class="col-sm-3">
													<select class="form-control form-control-sm" list="i_DISTYPE" id="t_unit<?php echo $SE_ID ?>" placeholder="หน่วย">
														<option value="<?php echo $SE_UNIT_D ?>"><?php echo $SE_UNIT_D ?>
														<option value="">เลือกหน่วย
														<option value="%">%
														<option value="฿">฿
													</select>
												</div>
												<div class="col-sm-2"></div>
											</div>

											<div class="form-group row">
												<label for="t_note" class="col-sm-4 col-form-label text-right">Note :</label>
												<div class="col-sm-6"><input type="text" class="form-control form-control-sm" placeholder="หมายเหตุ" id="t_note<?php echo $SE_ID ?>" value="<?php echo $SE_NOTE; ?>"></div>
												<div class="col-sm-2"></div>
											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
												<button type="button" class="btn btn-primary" id="sub_edit" value="sub_edit" onClick="edit(<?php echo $SE_ID ?>)">Edit</button>
											</div>
										</div>
									</div>
								</div>
								<!-- Button trigger modal1 -->

						<?php
								$DISCOUNT_BATHONEQTY = 0;
								$i++;
							}
						}

						if ($SE_UNIT_H == '%') {
							$DISCOUNT_BATH = ($SUM_NET * $SE_DIS_H) / 100;
							$SUM_NET = $SUM_NET - $DISCOUNT_BATH;
						} else {
							$B_DISCOUNT = $SE_DIS_H;
							$SUM_NET = $SUM_NET - $SE_DIS_H;
						}

						$FVAT = ($SUM_NET * 7) / 107;
						?>
						<tr>
							<td>&nbsp;</td>

							<td class="font-weight-bold"><small><b><?php if ($FSUM_QTY != '') { ?>รวม<?php } ?></b></small></td>
							<td class="font-weight-bold"><small><b><?php //echo $FSUM_PRICE 
																	?></b></small></td>
							<td>&nbsp;</td>
							<td class="font-weight-bold"><small><b><?php echo $FSUM_QTY ?></b></small></td>

							<td class="font-weight-bold"><small><b><?php echo $FSUM_DIS ?></b></small></td>
							<td>&nbsp;</td>
							<td class="font-weight-bold"><small><b><?php if ($FSUM_QTY != '') {
																		echo number_format($SUM_FNET, 2);
																	} ?></b></small></td>

							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					<tbody>
				</table>
				<!-- -------------------------------End H2 -->
			</td>

			<td width="25%" valign="top">
				<table width="100%" border="1" cellspacing="0" cellpadding="5">
					<tbody>
						<tr>
							<td width="50%"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal3" style="font-size:12px;">พักการขาย</button></td>
							<td align="right"><small><b><?php echo number_format($SUM_PRICE_N, 2) ?></b></small></td>
						</tr>
						<tr>
							<td width="50%"><small><b>ราคารวม :</b></small></td>
							<td align="right"><small><b><?php echo number_format($SUM_PRICE_N, 2) ?></b></small></td>
						</tr>
						<tr>
							<td><small><b>ส่วนลด :</b></small></td>
							<td align="right"><small><b><?php echo number_format($SUM_DIS, 2); ?></b></small></td>
						</tr>
						<tr>
							<td><a href="" data-toggle="modal" data-target="#exampleModal5"><small><b>ส่วนลดท้ายบิล :</b></small></a></td>
							<td align="right"><small><b><?php if ($SUM_QTY != '') {
															echo number_format($SE_DIS_H, 2);
															echo " $SE_UNIT_H";
														} ?></b></small></td>
						</tr>
						<tr>
							<td><small><b>ภาษี :</b></small></td>
							<td align="right"><small><b><?php if ($SUM_QTY != '') {
															echo number_format($FVAT, 2);
														} ?></b></small></td>
						</tr>
						<tr>
							<td><b>ราคารวมสุทธิ :</b></td>
							<td align="right"><b><?php if ($SUM_QTY != '') {
														echo number_format($SUM_NET, 2);
													} ?></b></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<!-- Button trigger modal -->
								<?php if ($SUM_QTY != '') { ?>
									<button type="button" class="btn btn-secondary btn-lg btn-block" onClick="cancel(1)">ยกเลิกการขาย</button>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">

								<!-- Button trigger modal -->
								<?php if ($FSUM_QTY != '') { ?>
									<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal">การชำระเงิน</button>
								<?php } ?>

								<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel"><b>Total : <?php echo number_format($SUM_NET, 2) ?> THB</b></h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<br>

											<script type="text/javascript">
												function formatNumber(num) {
													// Format the number with commas and two decimal places
													return Number(num).toLocaleString('en-US', {
														minimumFractionDigits: 2,
														maximumFractionDigits: 2
													});
												}

												function parseNumber(formattedNumber) {
													if (typeof formattedNumber === 'number') {
														// If the input is already a number, return it directly
														return formattedNumber;
													}
													// Ensure formattedNumber is a string before replacing commas
													return parseFloat(String(formattedNumber).replace(/,/g, '')) || 0;
												}

												function inputnums(value, sum_net) {
													received = parseNumber(value);
													total = parseNumber(sum_net);

													const shortage = total - received;
													const change = received > total ? received - total : 0;



													document.getElementById('ishow').value = formatNumber(shortage > 0 ? shortage : 0);
													document.getElementById('rshow').value = formatNumber(change);
												}

												function inputnum(a, b) {
													var showElement = document.getElementById("show");
													var rshowElement = document.getElementById("rshow");
													var ishowElement = document.getElementById("ishow");


													var currentValue = parseNumber(showElement.value);
													a = parseNumber(a);
													b = parseNumber(b);
													// console.log(formatNumber(currentValue));

													var clickedButton = event.target.tagName.toLowerCase() === 'button';
													// console.log()
													if (clickedButton) {
														if (document.getElementById("show").value == '') {
															document.getElementById("show").value = formatNumber(a);
														} else if (a != '0') {
															document.getElementById("show").value = formatNumber(currentValue + a);
														}
													}
													if (document.getElementById("show").value != '') {
														var newValue = parseNumber(document.getElementById("show").value);
														if (newValue >= b) {
															document.getElementById("rshow").value = formatNumber(newValue - b);
															document.getElementById("ishow").value = 0;
														} else {
															document.getElementById("rshow").value = 0;
															document.getElementById("ishow").value = formatNumber(b - newValue);
														}
													}

													if (a == 0) {
														document.getElementById("show").value = '';
														document.getElementById("rshow").value = '';
														document.getElementById("ishow").value = '';
													}

												}

												function setPaymentValue(paymentType, amount) {
													if (document.getElementById(paymentType).checked) {
														document.getElementById("show").value = amount;
													}
													if (paymentType === 'cash') {
														document.getElementById("ishow").value = null;
														document.getElementById("rshow").value = null;
													}
													if (paymentType === 'card') {
														document.getElementById("ishow").value = null;
														document.getElementById("rshow").value = null;
													}
													if (paymentType === 'trans') {
														document.getElementById("ishow").value = null;
														document.getElementById("rshow").value = null;
													}
												}
											</script>

											<div class="modal-pay">
												<input type="radio" name="pay" id="cash" value="cash" onclick="setPaymentValue('cash', '');  toggleModalBody(true)">&nbsp;เงินสด&nbsp;&nbsp;&nbsp;
												<input type="radio" name="pay" id="card" value="card" onclick="setPaymentValue('card', '<?php echo number_format($SUM_NET, 2); ?>'); toggleModalBody(false)">&nbsp;บัตรเครดิต&nbsp;&nbsp;&nbsp;
												<input type="radio" name="pay" id="trans" value="trans" onclick="setPaymentValue('trans', '<?php echo number_format($SUM_NET, 2); ?>'); toggleModalBody(false)">&nbsp;โอนเงิน/QRCODE
											</div>

											<div class="modal-body" id="modal-body" style="display: none;">
												<button type="button" class="btn btn-light" id="txt" value="<?php echo number_format($SUM_NET, 2) ?>" onclick="inputnum(this.value,'<?php echo number_format($SUM_NET, 2); ?>')"><?php echo number_format($SUM_NET, 2) ?></button>
												<button type="button" class="btn btn-light" id="txt" value="20.00" onclick="inputnum(this.value,'<?php echo number_format($SUM_NET, 2); ?>')">20</button>
												<button type="button" class="btn btn-light" id="txt" value="50.00" onclick="inputnum(this.value,'<?php echo number_format($SUM_NET, 2); ?>')">50</button>
												<button type="button" class="btn btn-light" id="txt" value="100.00" onclick="inputnum(this.value,'<?php echo number_format($SUM_NET, 2); ?>')">100</button>
												<button type="button" class="btn btn-light" id="txt" value="500.00" onclick="inputnum(this.value,'<?php echo number_format($SUM_NET, 2); ?>')">500</button>
												<button type="button" class="btn btn-light" id="txt" value="1000.00" onclick="inputnum(this.value,'<?php echo number_format($SUM_NET, 2); ?>')">1,000</button>
												<button type="button" class="btn btn-light" id="txt" value="0.00" onclick="inputnum(this.value,'')">Clear</button>
											</div>

											<div class="hi">&nbsp;</div>

											<div class="form-group row justify-content-center">
												<!--col12-->
												<div class="col-4 col-md-4 text-right"><label for="S_QTY" class="col-form-label">รับเงิน :</label></div>
												<div class="col-4 col-md-4">
													<input class="form-control form-control-sm" type="text" placeholder="รับเงิน" id="show" name="S_QTY" oninput="inputnums(this.value,'<?php echo number_format($SUM_NET, 2); ?>')">
												</div>
												<div class="col-4 col-md-4"></div>
											</div>

											<div class="form-group row justify-content-center">
												<!--col12-->
												<div class="col-4 col-md-4 text-right"><label for="I_QTY" class="col-form-label">ขาด :</label></div>
												<div class="col-4 col-md-4">
													<input class="form-control form-control-sm" type="text" placeholder="ขาด" id="ishow" name="I_QTY" readonly>
												</div>
												<div class="col-4 col-md-4"></div>
											</div>

											<div class="form-group row justify-content-center">
												<!--col12-->
												<div class="col-4 col-md-4 text-right"><label for="R_QTY" class="col-form-label">ทอน :</label></div>
												<div class="col-4 col-md-4">
													<input class="form-control form-control-sm" type="text" placeholder="ทอน" id="rshow" name="R_QTY" readonly>
												</div>
												<div class="col-4 col-md-4"></div>
											</div>

											<div class="form-group row">
												<!--col12-->
												<div class="col-4 col-md-4 text-right"><label for="R_QTY" class="col-form-label">หมายเหตุ :</label></div>
												<div class="col-4 col-md-4">
													<input class="form-control form-control-sm" type="text" placeholder="หมายเหตุ" id="note" name="note">
												</div>
												<div class="col-4 col-md-4"></div>
											</div>
											<br>

											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
												<button type="button" class="btn btn-primary" id="sub_int" onClick="print()">ออกบิล</button>
											</div>
										</div>
									</div>
								</div>

								<!-- Modal3 -->
								<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
									<div class="modal-dialog modal-sm" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>

											<div class="form-group row">
												<label for="i_NOTE" class="col-sm-4 col-form-label text-right mt-1">ชื่อรายการ :</label>
												<div class="col-sm-7"><input type="text" class="form-control form-control-sm mt-2" placeholder="ชื่อรายการ" id="i_NOTE"></div>
												<div class="col-sm-1"></div>
											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
												<button type="button" class="btn btn-primary" id="sub_pause" onClick="pause()">OK</button>
											</div>
										</div>
									</div>
								</div>

								<!-- Modal4 -->
								<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>

											<div class="form-group row">
												<label for="i_NOTE" class="col-sm-4 col-form-label text-right mt-1">ชื่อรายการ :</label>
												<div class="col-sm-7"><input type="text" class="form-control form-control-sm mt-2" placeholder="ชื่อรายการ" id="i_NOTE"></div>
												<div class="col-sm-1"></div>
											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
												<button type="button" class="btn btn-primary" id="sub_pause" onClick="pause()">OK</button>
											</div>
										</div>
									</div>
								</div>

								<!-- Modal5 -->
								<div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
									<div class="modal-dialog modal-l" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="form-group row">
												<label for="i_DIS_H" class="col-sm-4 col-form-label text-right">ส่วนลดท้ายบิล :</label>
												<div class="col-sm-3">
													<input type="number" class="form-control form-control-sm" placeholder="ส่วนลด" id="i_DIS_H" min="0">
												</div>
												<div class="col-sm-2">
													<select class="form-control form-control-sm" list="i_DIS_H_TYPE" id="i_UNIT" placeholder="หน่วย">
														<option value="฿">฿
														<option value="%">%
													</select>
												</div>
												<div class="col-sm-3"></div>
											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
												<button type="button" class="btn btn-primary" id="sub_pause" onClick="fn_dis()">OK</button>
											</div>
										</div>
									</div>
								</div>

							</td>
						</tr>
					</tbody>
				</table>

			</td>

		</tr>
	</tbody>
</table>

<script>
	function handleChange() {
		const input = document.getElementById('exampleDataList');
		const options = document.querySelectorAll('#i_BAR option');

		for (let option of options) {
			if (option.value === input.value) {
				// เรียกฟังก์ชัน add ถ้าผู้ใช้เลือกตัวเลือกจาก datalist
				add(1);
				break;
			}
		}
	}

	function checkInputLength() {
		var input = document.getElementById('exampleDataList');
		var datalist = document.getElementById('i_BAR');

		if (input.value.length > 0) {
			// เรียกโค้ด PHP เพื่อดึงข้อมูลและสร้างตัวเลือกใน datalist
			<?php
			$sql_pn = "SELECT inv.pn, inv.namep, bar.bar
			FROM `inv` LEFT OUTER JOIN
			bar ON inv.pn = bar.pn";
			$query_pn = mysqli_query($mysqli, $sql_pn);

			$options = ''; // สตริงที่ใช้เพื่อเก็บตัวเลือกทั้งหมด
			while ($rowdpn = mysqli_fetch_array($query_pn, MYSQLI_ASSOC)) {
				$SE_PN = $rowdpn['pn'];
				$SE_Nane = $rowdpn['namep'];
				$SE_Bar = $rowdpn['bar'];
				$options .= "<option value=\"$SE_PN\" data-bar=\"$SE_Bar\">$SE_PN | $SE_Nane | $SE_Bar</option>";
			}

			// ส่งตัวแปร options ไปยัง PHP เพื่อ echo ครั้งเดียว
			echo "var options = '" . addslashes($options) . "';";
			?>
			datalist.innerHTML = options;
			datalist.style.display = 'none';

		} else {
			datalist.style.display = 'none';
			datalist.innerHTML = '';
		}
	}

	function checkInputOnEnter() {
		let inputValue = document.getElementById('exampleDataList').value.toLowerCase(); // แปลงค่าที่กรอกเป็นตัวพิมพ์เล็ก
		let datalistOptions = document.querySelectorAll('#i_BAR option');

		// ตัวแปรเพื่อตรวจสอบว่าค่าที่กรอกตรงกับตัวเลือกใน datalist หรือไม่
		let matchFound = false;

		// ตรวจสอบว่าค่าที่กรอกตรงกับตัวเลือกใน datalist หรือไม่
		for (let option of datalistOptions) {
			let optionValue = option.value.toLowerCase();
			let optionBar = option.getAttribute('data-bar').toLowerCase();

			if (optionValue.includes(inputValue) || optionBar.includes(inputValue)) {
				matchFound = true; // ตั้งค่าว่าพบการจับคู่
				break;
			}
		}

		// หากมีการพิมพ์และตรงกับตัวเลือกใน datalist
		if (matchFound) {
			// add(1); // เรียกฟังก์ชัน add เมื่อมีการจับคู่
		} else {
			alert("ไม่พบรหัสสินค้า !!!");
		}
	}

	// ฟังก์ชันสำหรับตรวจสอบเมื่อเลือกจาก datalist เท่านั้น
	function checkDatalistOnSelect() {
		let selectedValue = document.getElementById('exampleDataList').value.toLowerCase(); // ค่าที่เลือกใน datalist
		let datalistOptions = document.querySelectorAll('#i_BAR option');

		// ตรวจสอบว่าค่าที่เลือกตรงกับตัวเลือกใน datalist หรือไม่
		for (let option of datalistOptions) {
			let optionValue = option.value.toLowerCase();
			if (optionValue === selectedValue) { // ตรวจสอบว่าค่าเลือกตรงกับตัวเลือก
				add(1); // เรียกฟังก์ชัน add เมื่อมีการจับคู่
				break;
			}
		}
	}

	// ตรวจสอบเมื่อผู้ใช้กดปุ่ม Enter
	document.getElementById("exampleDataList").addEventListener("keypress", function(event) {
		if (event.key === 'Enter') { // ตรวจสอบว่ากด Enter หรือไม่
			checkInputOnEnter(); // เรียกใช้ฟังก์ชันเมื่อกด Enter
		}
	});

	// ตรวจสอบเมื่อผู้ใช้เลือกตัวเลือกใน datalist
	document.getElementById("exampleDataList").addEventListener("change", function() {
		checkDatalistOnSelect(); // เรียกใช้ฟังก์ชันเมื่อเลือกตัวเลือก
	});
</script>

<script>
	// JavaScript code to set default value after the page is loaded
	window.onload = function() {
		document.getElementById("exampleDataList").focus();
	};
</script>
<script>
	$(document).ready(function() {
		// เมื่อเปลี่ยนค่าใน <select> ให้เก็บค่าใน localStorage และรีโหลดหน้าเว็บ
		$('#i_DIS').change(function() {
			var discountId = $(this).val();
			localStorage.setItem('selectedDiscount', discountId);
			$.ajax({
				url: 'update_discount.php',
				type: 'GET',
				data: {
					DIS: discountId
				},
				success: function(response) {
					//console.log(response);
					window.location.reload();
				}
			});
		});

		// เมื่อหน้าเว็บโหลด ให้ตั้งค่า <select> ให้เป็นค่าเดิมที่เก็บไว้ใน localStorage
		var savedDiscountId = localStorage.getItem('selectedDiscount');
		if (savedDiscountId) {
			if (savedDiscountId === "") {
				// ถ้าค่าที่เก็บไว้เป็นค่าว่าง ให้ไม่เลือกค่าใดๆ
				$('#i_DIS').val('');
			} else {
				$('#i_DIS').val(savedDiscountId);
			}
		} else {
			// ถ้าไม่มีค่าใน localStorage, ตั้งค่า <select> เป็นค่าเริ่มต้น
			$('#i_DIS').val('');
		}
	});
</script>
<script>
	function toggleModalBody(show) {
		var modalBody = document.getElementById('modal-body');
		if (show) {
			modalBody.style.display = 'block';
		} else {
			modalBody.style.display = 'none';
		}
	}

	// By default, the modal body is hidden (handled by inline style above)
</script>
<script>
	document.getElementById('i_QTY').addEventListener('input', function() {
		if (this.value < 1) {
			this.value = 1; // Set the value back to 1 if it's less than 1
		}
	});
</script>