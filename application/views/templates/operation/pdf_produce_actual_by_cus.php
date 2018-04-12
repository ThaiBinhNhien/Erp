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
				<th width="40%">得意先</th>
				<th>区分 </th>
				<th>数量</th>
				<th>重量(g)</th>
				<th>前年比(数量)</th>
				<th>前年比(重量)</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($lstMaster as $key => $value) {?>
				<tr>
					<td><?= '['.$value[CUS_ID].']'.$value[CUS_CUSTOMER_NAME] ?></td>
					<td>ドライ</td>
					<td class="text-center"><?= number_format($value['dry_quantity']) ?></td>
					<td class="text-center"><?= number_format($value['dry_weight'],2,'.',',') ?></td>
					<td class="text-center"><?= number_format($value['dry_quantity_last_year'],2) ?>%</td>
					<td class="text-center"><?= number_format($value['dry_weight_last_year'],2) ?>%</td>
				</tr>
				<tr>
					<td></td>
					<td style="border-bottom:solid 1px black">ランドリー </td>
					<td style="border-bottom:solid 1px black" class="text-center"><?= number_format($value['laundry_quantity']) ?></td>
					<td style="border-bottom:solid 1px black" class="text-center"><?= number_format($value['laundry_weight'],2,'.','.') ?></td>
					<td style="border-bottom:solid 1px black" class="text-center"><?= number_format($value['laundry_quantity_last_year'],2) ?>%</td>
					<td style="border-bottom:solid 1px black" class="text-center"><?= number_format($value['laundry_weight_last_year'],2) ?>%</td>
				</tr>
				<tr>
					<td></td>
					<td><b>得意先合計</b></td>
					<td class="text-center"><?= number_format($value['dry_quantity']+$value['laundry_quantity']) ?></td>
					<td class="text-center"><?= number_format($value['dry_weight']+$value['laundry_weight'],2,'.',',') ?></td>
					<td class="text-center"><?= number_format($value["total_quantity_last_year"],2) ?>%</td>
					<td class="text-center"><?= number_format($value["total_weight_last_year"],2) ?>%</td>
				</tr>
				<tr><td></td></tr>
			<?php }?>
			
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
	.text-right{
		text-align: right
	}
	.text-center{
		text-align: center
	}
</style>