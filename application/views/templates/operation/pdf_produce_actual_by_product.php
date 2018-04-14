<div>
	<htmlpageheader name="myhead" >
		<div style="width:100%;text-align:center;font-size:20pt">
			<b>得意先別生産実績表</b>
		</div>
		<div style="width:100%;clear:both;float:right;text-align:right">
			<div style="width:100%">{PAGENO}/{nb} ページ</div>
			<div style="width:100%"><?= $date_from." ~ ".$date_to ?></div>
		</div>
	</htmlpageheader>
	<sethtmlpageheader name="myhead" page="ALL" value="1" show-this-page="1"/>
</div>
<div style="margin-top:60px">
	<table style="width:100%">
		<thead>
			<tr>
				<th>得意先 </th>
				<th>商品名 </th>
				<th>規格</th>
				<th>COLOR</th>
				<th>数量</th>
				<th>重量(g)</th>
				<th>前年比(数量)</th>
				<th>前年比(重量)</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($lstMaster as $key => $value) {
				$first = true;?>
					<?php foreach ($value['detail'] as $item) {?>
						<tr>
							<td><?= $first == true? $value['cus_name']:'' ?></td>
							<td><?= $item['name'] ?></td>
							<td><?= $item['standard'] ?></td>
							<td><?= $item['color'] ?></td>
							<td><?= number_format($item['quantity'],2) ?></td>
							<td><?= number_format($item['weight'],2,'.',',') ?></td>
							<td><?= number_format($item['quantity_last_year'],2) ?>%</td>
							<td><?= number_format($item['weight_last_year'],2) ?>%</td>
						</tr>
					<?php } ?>
				<tr>
					<td style="border-bottom:solid 1px black"></td>
					<td style="border-bottom:solid 1px black"></td>
					<td style="border-bottom:solid 1px black"></td>
					<td style="border-bottom:solid 1px black">制服･作業着 合計</td>
					<td style="border-bottom:solid 1px black"><?= number_format($value['total_quantity'],2) ?></td>
					<td style="border-bottom:solid 1px black"><?= number_format($value['total_weight'],2,'.',',')?></td>
					<td style="border-bottom:solid 1px black"><?= $value['total_quantity_last_year'] == 0?0:number_format($value['total_quantity']*100/$value['total_quantity_last_year'],2)?>%</td>
					<td style="border-bottom:solid 1px black"><?= $value['total_weight_last_year'] == 0?0:number_format($value['total_weight']*100/$value['total_weight_last_year'],2)?>%</td>
				</tr>
				
				
			<?php } ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td><b>得意先合計</b></td>
				<td><?= number_format($sum_quantity,2) ?></td>
				<td><?= number_format($sum_weight,2,'.',',') ?></td>
				<td><?= $sum_quantity_last_year == 0?0:number_format($sum_quantity*100/$sum_quantity_last_year,2)?>%</td>
				<td><?= $sum_weight_last_year == 0?0:number_format($sum_weight*100/$sum_weight_last_year,2)?>%</td>
			</tr>
		</tbody>
	</table>
</div>
<style>
	table{
		border-collapse: collapse;
	}
	th{
		text-align: center;
		border-top:solid 1px black;
		border-bottom:solid 1px black;
	}
	td{
		text-align: center;
	}
</style>