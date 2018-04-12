<div>
<?php 
	$index = 0;
	for($i=0;$i<count($shipment);$i++){ 
	$total_quantity = 0;
	$total_weight = 0;
	$pageno += 1;
	?>
	
		<div style="float:left;font-size:16pt;width:20%;clear:both">納品集計表</div>
		<div style="float:left;font-size:16pt;width:30%;margin-left:20px"><?= $date_from."  ~  ".$date_to ?></div>
		<div style="float:right;font-size:16pt;width:10%;margin-right:20px">No.<?= $pageno ?></div>
		<div style="float:left;font-size:16pt;width:30%;clear:both;text-align:right"><?= $shipment[$i][CUS_CUSTOMER_NAME] ?></div>
		<div style="width:100%;clear:both;margin-top:10px">
			<table style="width:100%">
				<thead>
					<tr>
						<th style="width:10%">商品コード</th>
						<th style="width:30%">商品名</th>
						<th style="width:10%">規格</th>
						<th style="width:10%">COLOR</th>
						<th style="width:10%">出荷数</th>
						<th style="width:15%">重量</th>
						<th style="width:15%">合計</th>
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
						<td><?=$shipment[$i][PL_STANDARD]?></td>
						<td><?=$shipment[$i][PL_COLOR_TONE]?></td>
						<td><?=number_format($shipment[$i]['quantity'])?></td>
						<td><?=number_format($shipment[$i][PL_ORGANIZATION_WEIGHT],2,'.',',')?></td>
						<td><?=number_format($shipment[$i]['quantity']*$shipment[$i][PL_ORGANIZATION_WEIGHT],2,'.',',')?></td>
					</tr>
					<?php if($shipment[$i+1][OSHD_CUSTOMER_ID] != $shipment[$i][OSHD_CUSTOMER_ID]) 
							break;
					?>
				<?php } ?>
				<tr><td></td></tr>
				<tr style="border-top:solid 1px black">
					<td></td>
					<td></td>
					<td></td>
					<td>合計(枚)</td>
					<td><?= number_format($total_quantity) ?></td>
					<td>合計(kg)</td>
					<td><?= number_format($total_weight,2,'.',',') ?></td>
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
