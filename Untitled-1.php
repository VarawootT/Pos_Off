<?php	
	$se_name_wh = '';							
	$qry="SELECT name_wh FROM p_wh WHERE wh='$user_wh'";
	if($result = $mysqli->query($qry)){
		while ($row = $result->fetch_assoc()) {
			$se_name_wh = $row['name_wh'];
		}
	}
?>

<div class="card-header bg-secondary">
	<h3 class="card-title"><i class="fas fa-cart-plus mr-2"></i>ขายหน้าร้าน</h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $se_name_wh; ?>
</div>

<!-- -------------------------------Start H1-->

<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      	<td width="75%">		
				<table width="100%" border="1" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
						<td width="21%">&nbsp;&nbsp;<label for="i_BAR">Barcode</label></td>
						<td width="20%"><label for="i_DATE">Date</label></td>
						<td width="17%"><label for="i_INV">Product</label></td>
						<td width="14%" align="center"><label for="i_QTY">Amount</label></td>
						<td width="6%">&nbsp;</td>
						</tr>
						<tr>
						<td>&nbsp;&nbsp;<input type="text" size="17" placeholder="Barcode" name="i_BAR" autofocus></td>
						<td>
						&nbsp;<input type="datetime-local" name="i_DATE" size="1" >
						</td>
						<td>				
							<input list="Options1" id="exampleDataList" placeholder="เลือกสินค้า" size="14" name="i_INV">
							<datalist id="Options1">
								<?php
								$s_inv="SELECT pn, namep FROM inv ";
								if($re_inv = $mysqli->query($s_inv)){
									while ($row_inv = $re_inv->fetch_assoc()) {
										$se_pn = $row_inv['pn'];
										$se_namep = $row_inv['namep'];
										echo "<option value=\"$se_pn\">$se_namep</option>";
									}
								}
								?>
							</datalist>
						</td>
						<td align="center"><input type="text" size="5" placeholder="จำนวน" name="i_QTY" value="1"></td>						
						<td><button type="submit" class="btn btn-primary" name="sub_tem" id="sub_tem" value="sub_tem">Add</button></td>
						</tr>
					</tbody>
				</table>
			</form>
			<!-- -------------------------------End H1 -->

			<!-- -------------------------------End H2 -->
				<table class="table table-sm">
					<thead class="thead-light">
						<tr>
							<th><small><b>No</b></small></th>
							<th><small><b>Product</b></small></th>
							<th><small><b>Amonut</b></small></th>
							<th><small><b>Price</b></small></th>
							<th><small><b>Discount</b></small></th>
							<th><small><b>Total</b></small></th>
							<th><small><b>Clear</b></small></th>
						</tr>
					</thead>
					<tbody>
						<?php

						$i = 1;
						$DISCOUNT_BATH = 0;
						$SUM_NET = 0;
						$SUM_QTY = 0;
						$SUM_PRICE = 0;
						$SUM_DIS = 0;
						$FSUM_NET = '';
						$FSUM_QTY = '';
						$FSUM_PRICE = '';
						$FSUM_DIS = '';

							$s_tem="SELECT id, pn, price, discount, SUM(qty) AS qty FROM p_so_tem GROUP BY id, pn, price, discount ORDER BY id DESC ";
							if($re_tem = $mysqli->query($s_tem)){
								while ($row_tem = $re_tem->fetch_assoc()) {
									$SE_ID = $row_tem['id'];
									$SE_PN = $row_tem['pn'];
									$SE_QTY = $row_tem['qty'];
									$SE_PRICE = $row_tem['price'];
									$SE_DISCOUNT = $row_tem['discount'];

								$PERCENT = substr($SE_DISCOUNT, -1);
								$DIS_PERCENT = substr($SE_DISCOUNT, 0, -1);
								if ($PERCENT == '%') {
									$DISCOUNT_BATH = ($SE_PRICE * $DIS_PERCENT) / 100;
									$NET = ($SE_PRICE * $SE_QTY) - $DISCOUNT_BATH;
									$B_DISCOUNT = $DISCOUNT_BATH * $SE_QTY;							
								}else {
									$B_DISCOUNT = $SE_DISCOUNT;
									$NET = ($SE_PRICE * $SE_QTY) - $SE_DISCOUNT;
								}

								$SE_PRICE_N = $SE_PRICE * $SE_QTY;

								$SUM_NET += $NET;
								$SUM_QTY += $SE_QTY;
								$SUM_PRICE += $SE_PRICE;
								$SUM_DIS += $B_DISCOUNT;

								$FSUM_NET = number_format($SUM_NET);
								$FSUM_QTY = number_format($SUM_QTY);
								$FSUM_PRICE = number_format($SUM_PRICE);
								$FSUM_DIS = number_format($SUM_DIS);

								$FSE_QTY = number_format($SE_QTY);
								$FSE_PRICE = number_format($SE_PRICE);
								$FNET = number_format($NET);

							?>
								<tr>
									<td class="pl-3"><small><?php echo $i ?></small></td>
									<td><small><?php echo $SE_PN ?></small></td>
									<td><small><?php echo $FSE_QTY ?></small></td>
									<td><small><?php echo $FSE_PRICE ?></small></td>
									<td><small><?php echo $SE_DISCOUNT ?></small></td>
									<td><small><?php echo $FNET ?></small></td>
									<td>
										<a href="sql_pos.php?&id_del=<?php echo $SE_ID ?>&NS=<?php echo $RD_NS ?>&WH=<?php echo $RD_WH ?>&DATE=<?php echo $RD_DATE_SO ?>&TIME=<?php echo $RD_TIME_SO ?>" class="btn btn-danger confirmation">
										<i class="fas fa-trash-alt" onclick="myFunction()"></i></a>
									</td>
								</tr>
							<?php
								$i++;
							}
						}					
							?>
						<tr>
							<td>&nbsp;</td>
							<td class="font-weight-bold"><small><b><?php if ($FSUM_QTY != '') { ?>รวม<?php } ?></b></small></td>
							<td class="font-weight-bold"><small><b><?php echo $FSUM_QTY ?></b></small></td>
							<td class="font-weight-bold"><small><b><?php echo $FSUM_PRICE ?></b></small></td>
							<td class="font-weight-bold"><small><b><?php echo $FSUM_DIS ?></b></small></td>
							<td class="font-weight-bold"><small><b><?php echo $FSUM_NET ?></b></small></td>
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
						</tr>
					<tbody>
				</table>
			 <!-- -------------------------------End H2 -->
		</td>

<!-- ------------------------------- -->

      	<td width="25%" valign="top">
			<table width="100%" border="1" cellspacing="0" cellpadding="5">
				<tbody>
					<tr>
					<td colspan="2" height="100">
					<?php	
						// $SUM_DIS_BATH = 0;
						// $s_vd = "SELECT DISCOUNT, NAME FROM V_P_DIS WHERE DISCOUNT = '1' ";
						// $Res_vd = $conn->prepare($s_vd);
						// $Res_vd->execute();
						// while ($vd = $Res_vd->fetch(PDO::FETCH_ASSOC)) {
						// 	$VD_DISCOUNT = $vd['DISCOUNT'];
						// 	$VD_NAME = $vd['NAME'];
	
						// 	echo "$VD_NAME<br>";

						// 	$PERCENT_L = substr($VD_DISCOUNT, -1);
						// 	$DIS_PER_L = substr($VD_DISCOUNT, 0, -1);
						// 	if ($PERCENT_L == '%') {
						// 		$DIS_BATH = ($SUM_NET * $DIS_PER_L) / 100;
						// 	} else {								
						// 		$DIS_BATH = $VD_DISCOUNT;
						// 	}

						// 	$SUM_DIS_BATH += $DIS_BATH;						
						// }

						// if($S_VAT == 1){
						// 	$T_VAT = 0;
						// }else{
						// 	$T_VAT = 7;
						// }

						// $SUM_DIS_END = $SUM_DIS_BATH + $SUM_DIS;
						// $TOTAL_NOVAT = $SUM_NET - $SUM_DIS_END;						
						// $VAT = ($TOTAL_NOVAT * $T_VAT) / 100;
						// $TOTAL_VAT = ($SUM_NET - $SUM_DIS_END);

						// $FSUM_DIS_END = number_format($SUM_DIS_END);
						// $FVAT = number_format($VAT);
						// $FTOTAL_VAT = number_format($TOTAL_VAT);
					?>

					</td>
					</tr>
					<tr>
					<td><small><b>Subtotal :</b></small></td>
					<td><small><b><?php //echo $FSUM_NET ?></b></small></td>
					</tr>
					<tr>
					<td><small><b>Discount :</b></small></td>
					<td><small><b><?php //echo $FSUM_DIS_END ?></b></small></td>
					</tr>
					<tr>
					<td><small><b>Vat :</b></small></td>
					<td><small><b><?php //echo $FVAT ?></b></small></td>
					</tr>
					<tr>
					<td><small><b>Total :</b></small></td>
					<td><small><b><?php //echo $FTOTAL_VAT ?></b></small></td>
					</tr>
					<tr>
					<td colspan="2" align="center">

						<!-- Button trigger modal -->
						<?php if ($FSUM_QTY != '') { ?>
						<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal">
						PAY NOW
						</button>
						<?php } ?>
	
						<!-- Modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel"><b>Total : <?php echo $FTOTAL_VAT ?> THB</b></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>

								<div class="modal-pay">
								<button type="button" class="btn btn-light" name="pay_cash">สด</button>
								<button type="button" class="btn btn-light" name="pay_card">บัตร</button>
								<button type="button" class="btn btn-light" name="pay_transfer">โอน</button>
								</div>

								<div class="modal-body">
								<button type="button" class="btn btn-light" name="amount_fully"><?php echo $FTOTAL_VAT ?></button>
								<button type="button" class="btn btn-light" name="amount_20">20</button>
								<button type="button" class="btn btn-light" name="amount_50">50</button>
								<button type="button" class="btn btn-light" name="amount_100">100</button>
								<button type="button" class="btn btn-light" name="amount_500">500</button>
								<button type="button" class="btn btn-light" name="amount_1000">1,000</button>
								</div>
								
								<div>
								<input type="text" name="S_QTY" size="20" value="<?php echo $FTOTAL_VAT ?>">
								</div>
								<br>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">ออกบิล</button>
								</div>
							</div>
						</div>
						</div>
						<!-- Button trigger modal -->

					<form action="sql_pos.php" method="post" enctype="multipart/form-data" onSubmit="return chkSub(this)">					
						<!-- Modal2 -->
						<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<?php
								@$S_QTY = $_GET['S_QTY'];
								?>
								<h5 class="modal-title" id="exampleModalLabel2"><b>Receive Money : <?php echo $S_QTY ?> THB</b></h5>
								<h5 class="modal-title" id="exampleModalLabel2"><b>Total Price : <?php echo $FTOTAL_VAT ?> THB</b></h5>
								<h5 class="modal-title" id="exampleModalLabel2"><b>Change : <?php echo $FTOTAL_VAT ?> THB</b></h5>						
								<br>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
									<button type="submit" class="btn btn-primary" name="sub_int" id="sub_int" value="sub_int">Print Receive</button>
								</div>
							</div>
						</div>
						</div>
						<!-- Button trigger modal2 -->
					</form>
					
					</td>
					</tr>
				</tbody>
			</table>

		</td>
	
    </tr>
  </tbody>
</table>

<!-- ------------------------------- -->

<script type="text/javascript">
	var elems = document.getElementsByClassName('confirmation');
	var confirmIt = function(e) {
		if (!confirm('ต้องการ ลบ ข้อมูลใช่หรือไม่')) e.preventDefault();
	};
	for (var i = 0, l = elems.length; i < l; i++) {
		elems[i].addEventListener('click', confirmIt, false);
	}
</script>