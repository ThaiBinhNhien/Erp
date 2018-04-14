<div>
<?php for($i=0;$i<count($shipment);$i++){ 
	$total_quantity = 0;
	$total_weight = 0;
	?>
	
		<div style="float:left;font-size:18pt;width:50%;clear:both">納品数・重量　合計</div>
		<div style="float:right;width:30%;text-align:right;padding-top:10px"><?= $this->helper->readDate($shipment[$i][OS_ORDER_DATE]) ?></div>
		<div style="width:100%;clear:both;margin-top:10px">
			<table style="width:100%">
				<thead>
					<tr>
						<th style="width:15%">項目コード</th>
						<th style="width:35%">項目コード名</th>
						<th style="width:25%">出荷数の合計　(枚)</th>
						<th style="width:25%">納品重量の合計　(Kg)</th>
					</tr>
				</thead>
				<tbody>
				<?php for(;$i<count($shipment);$i++){ 
					$total_quantity += $shipment[$i]['quantity'];
					$total_weight += $shipment[$i]['weight'];
					?>
					<tr>
						<td><?=$shipment[$i][OSHD_PRODUCT_CODE]?></td>
						<td><?=$shipment[$i][PL_PRODUCT_NAME]?></td>
						<td><?=number_format($shipment[$i]['quantity'])?></td>
						<td><?=number_format($shipment[$i]['weight'],2,'.',',')?></td>
					</tr>
					<?php if($shipment[$i+1][OS_ORDER_DATE] != $shipment[$i][OS_ORDER_DATE]) 
							break;
					?>
				<?php } ?>
				<tr><td></td></tr>
				<tr>
					<td></td>
					<td></td>
					<td><?= number_format($total_quantity)?></td>
					<td><?= number_format($total_weight,2,'.',',')?></td>
				</tr>
				</tbody>
			</table>
		</div>
	<?php if($i != count($shipment) -1){
		echo '<pagebreak />';
	}?>
	
<?php } ?>


</div>
<style>
	td{
		text-align: center;
		padding: 5px;
		

	}
	table{
		border-collapse: collapse;
	}
</style>
