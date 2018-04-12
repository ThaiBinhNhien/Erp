<?php 
		$varContainer = "container";
		$varNum = "num";
		$varSpace = "&nbsp;";
		$varDetail = "detail";
		?>

		<!-- CSS -->
		<link href="<?php echo site_url();?>asset/css/bootstrap-report.css" rel="stylesheet">
		<style>
			h1 {
				font-weight: 900;
			}
			table{
		border-collapse: collapse;
	}
			table tbody tr td, table tbody tr th {
				padding: 2px 5px;
			}
			.text-center {
				text-align: center;
			}
			.text-left {
				text-align: left;
			}
			.text-right {
				text-align: right;
			}
			.border {
				border: 1px solid #000;
			}
			.border-left {
				border-left: 1px solid #000;
			}
			.border-right {
				border-right: 1px solid #000;
			}
			.border-top {
				border-top: 1px solid #000;
			}
			.border-bottom {
				border-bottom: 1px solid #000;
			}
			.table-border {
				border-bottom: 1px solid #000;
			}
			.table-border tbody tr td, .table-border tbody tr th{
				border-top: 1px solid #000;
				border-left: 1px solid #000;
			}
			.table-border thead tr th {
				border-top: 1px solid #000;
				border-left: 1px solid #000;
			}
			.table-border thead tr th {
				border-right: 1px solid #000;
			}
			table tbody tr td.padding-left {
				padding-left: 0 !important;
			}
			table tbody tr td.padding-right {
				padding-right: 0 !important;
			}
			.fontJapan {
				font-family : "sun-exta";
			}
		</style>
	
		<?php if($master != '') { ?>
		<h1 class="text-center"><b><?php echo $title;?></b></h1><br>
		<div class="row"> 
			<table width="100%">
				<tbody>
					<tr>
						<td width="75%">
							<table width="100%">
								<tbody>
									<tr>
										<td width="50%">
											<table>
												<tbody>
													<tr>
														<th class="text-right" width="30%">伝票番号：</th>
														<td class="border text-center"><?php echo $master[OS_ID];?></td>
													</tr>
													<tr>
														<th class="text-right">配送便：</th>
														<td class="border-left border-right border-bottom fontJapan"><?php echo $master['delivery_classifition'];?></td>
													</tr>
													<tr>
														<th class="text-right">発注日：</th>
														<td class="border-left border-right"><?php echo $OS_ORDER_DATE;?></td>
													</tr>
													<tr>
														<th class="text-right">納品日：</th>
														<td class="border"><?php echo $OS_DELIVERY_DATE;?></td>
													</tr>
												</tbody>
											</table>
										</td>
										<td width="50%" style="vertical-align:top;">
											<table width="100%">
												<tbody>
													<tr>
														<th class="text-right" width="30%">形態：</th>
														<td class="border">
															<?php 
													            if($master[OS_STATUS] != '') {
													                if((int)$master[OS_STATUS] == 1) {
													                    echo '<span>一時保存</span>';
													                }
													                else if((int)$master[OS_STATUS] == 2) {
													                    echo '<span>出荷未確定</span>';
													                }
													                else if((int)$master[OS_STATUS] == 3) {
													                    echo '<span>再依頼</span>';
													                }
													                else if((int)$master[OS_STATUS] == 4) {
													                    echo '<span>出荷確定(不足)</span>';
													                }
													                else if((int)$master[OS_STATUS] == 5) {
													                    echo '<span>出荷確定</span>';
													                }
													            }
													           ?>
														</td>
													</tr>
													<tr>
														<th class="text-right" width="30%">備考：</th>
														<td class="border-left border-right border-bottom" rowspan="3"><?php echo $master[OS_NOTE];?></td>
													</tr>
													<tr>
														<th>&nbsp;</th>
													</tr>
													<tr>
														<th>&nbsp;</th>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td width="25%" style="vertical-align:top;">
							<table>
								<tbody>
									<tr>
										<th class="text-right" width="50%">&nbsp;発注者 </th>
										<td><?php echo $master['user_order'];?></td>
									</tr>
									<tr>
										<th class="text-right" width="50%">&nbsp;出荷者 </th>
										<td><?php echo $master['user_shipper'];?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<br>
		<div>
			<table width="100%">
				<tbody>
					<tr>
						<td class="padding-left" width="75%">
							<table width="100%" class="table table-bordered">
								<tbody>
									<tr>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[0])) ? $listCountContainer[0][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[0])) ? $listCountContainer[0][$varNum] : $varSpace; ?></td>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[1])) ? $listCountContainer[1][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[1])) ? $listCountContainer[1][$varNum] : $varSpace; ?></td>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[2])) ? $listCountContainer[2][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[2])) ? $listCountContainer[2][$varNum] : $varSpace; ?></td>
									</tr>
									<tr>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[3])) ? $listCountContainer[3][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[3])) ? $listCountContainer[3][$varNum] : $varSpace; ?></td>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[4])) ? $listCountContainer[4][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[4])) ? $listCountContainer[4][$varNum] : $varSpace; ?></td>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[5])) ? $listCountContainer[5][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[5])) ? $listCountContainer[5][$varNum] : $varSpace; ?></td>
									</tr>
									<tr>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[6])) ? $listCountContainer[6][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[6])) ? $listCountContainer[6][$varNum] : $varSpace; ?></td>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[7])) ? $listCountContainer[7][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[7])) ? $listCountContainer[7][$varNum] : $varSpace; ?></td>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[8])) ? $listCountContainer[8][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[8])) ? $listCountContainer[8][$varNum] : $varSpace; ?></td>
									</tr>
									<tr>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[9])) ? $listCountContainer[9][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[9])) ? $listCountContainer[9][$varNum] : $varSpace; ?></td>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[10])) ? $listCountContainer[10][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[10])) ? $listCountContainer[10][$varNum] : $varSpace; ?></td>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[11])) ? $listCountContainer[11][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[11])) ? $listCountContainer[11][$varNum] : $varSpace; ?></td>
									</tr>
									<tr>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[12])) ? $listCountContainer[12][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[12])) ? $listCountContainer[12][$varNum] : $varSpace; ?></td>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[13])) ? $listCountContainer[13][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[13])) ? $listCountContainer[13][$varNum] : $varSpace; ?></td>
										<td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[14])) ? $listCountContainer[14][$varContainer] : $varSpace; ?></td>
										<td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[14])) ? $listCountContainer[14][$varNum] : $varSpace; ?></td>
									</tr>

									<?php 

								        if($listCountContainer != null && count($listCountContainer) > 15) {
								            $iBegin = 15;
								            $countList = ceil(( count($listCountContainer) - $iBegin ) / 3);
								            for ($i=0; $i < $countList; $i++) { 
								                $jBegin = $iBegin + 3 * i;
								                $jEnd = $jBegin + 3; 
								        ?>
								            <tr>
								                <?php 
								                for ($j=$jBegin; $j < $jEnd; $j++) { 
								                ?>
								                <td class="text-center"><?php echo ($listCountContainer != null && isset($listCountContainer[$j])) ? $listCountContainer[$j][$varContainer] : ''; ?></td>
								                <td class="text-right"><?php echo ($listCountContainer != null && isset($listCountContainer[$j])) ? $listCountContainer[$j][$varNum] : ''; ?></td>
								                <?php } ?>
								            </tr>
								        <?php 
								        } }
								        ?>
								</tbody>
							</table>
						</td>
						<td class="padding-right" width="25%">
							<table width="100%" class="table table-bordered">
								<tbody>
									<tr>
										<td class="text-center" colspan="2">コンテナ台数内訳</td>
									</tr>
									<tr>
										<th class="text-center">合計</th>
										<td class="text-right"><?php echo $master[OS_TOTAL_NUMBER_CONTAINERS];?>台</td>
									</tr>
									<tr>
										<th class="text-center">重量</th>
										<td class="text-right"><?php 
										if($master[OS_GROSS_WEIGHT_SHIPPING] != null && $master[OS_GROSS_WEIGHT_SHIPPING] != "" && $master[OS_GROSS_WEIGHT_SHIPPING] > 0) {
											echo $master[OS_GROSS_WEIGHT_SHIPPING];
										}
										else {
											echo $master[OS_GROSS_WEIGHT];
										}
										?>kg</td>
									</tr>
									<tr>
										<th class="text-center">トラック</th>
										<td class="text-right"><?php echo $master[OS_NUMBER_TRUCKS];?>台</td>
									</tr>
									<tr>
										<th class="text-center">臨車</th>
										<td class="text-right"><?php echo $master[OS_NUMBER_TRAIN];?>台</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div>
			<table width="100%" class="table">
				<?php if($listDetail != '') { 
					foreach ($listDetail as $key => $value) {
						?>
					<tr>
						<td colspan="6" style="text-decoration: underline;"><b><?php echo $value['customer'];?></b></td>
					</tr>
					<tr>
						<td width="25%">商品名</td>
						<td width="25%">規格</td> 
						<td width="15%" class="fontJapan">ＣＯＬＯＲ</td>
						<td width="10%" class="text-right">出荷数</td>
						<td width="15%" class="text-right">重量</td>
						<td width="10%" class="text-right">合計</td>
					</tr>
					<?php if($value[$varDetail] != '') { 
						foreach ($value[$varDetail] as $keyDepartment => $valueDepartment) {
					?>
					<?php if($valueDepartment[$varDetail] != '') { 
						foreach ($valueDepartment[$varDetail] as $keyProduct => $valueProduct) {
					?>
					<tr>
						<td><?php echo $valueProduct['product_name'];?></td>
						<td><?php echo $valueProduct['product_format'];?></td>
						<td><?php echo $valueProduct['product_color'];?></td>
						<td class="text-right"><?php echo $valueProduct['quantity_delivery'];?></td>
						<td class="text-right"><?php echo $valueProduct['product_weight'];?></td>
						<td class="text-right"><?php echo $valueProduct['total'];?></td>
					</tr>
					<?php } } ?>
					<?php } } ?>
					<tr>
						<td class="border-top">&nbsp;</td>
						<td class="border-top">&nbsp;</td>
						<td class="text-right border-top">合計（枚）</td>
						<td class="text-right border-top"><?php echo $value['number_delivery'];?></td>
						<td class="text-right border-top fontJapan">合計（ｋｇ）</td>
						<td class="text-right border-top"><?php echo $value['total'];?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				<?php } } ?>	

			</table>
		</div>

		
		<?php } ?>
