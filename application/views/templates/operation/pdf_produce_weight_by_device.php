
<div style="width:100%;margin-top:100px">
	<?php 
		foreach ($lstMaster as $key => $value) {
		$total_quantity = 0;
		$total_weight = 0;?>
		<htmlpageheader name="myhead<?= $key ?>" >
			<div style="border-bottom:solid 3px black;width:100%;padding:15px">
					<div style="width:100%;float:right;text-align:right;font-weight:bold">
						<div><?= $this->helper->readDate(date('Y/m/d')) ?></div>
						<div>{PAGENO}/{nb} ページ</div>
					</div>
					<div style="width:100%;clear:both;margin-top:20px;font-weight:bold">
						<div style="width:50%;float:left;font-size:20pt">機器別洗濯量 &nbsp;&nbsp;<?= $value['name'] ?></div>
						<div style="width:40%;float:right;text-align:right;margin-right:30px"><?= $date_from." ~ ".$date_to ?></div>
					</div>
			</div>
					
		</htmlpageheader>
		<sethtmlpageheader name="myhead<?= $key ?>" page="ALL" value="1" show-this-page="1"/>
		<table style="width:100%;margin-top:10px">
			<thead >
				<tr>
					<th style="width:15%">洗濯コード</th>
					<th style="width:50%">洗濯品名</th>
					<th style="width:10%">洗濯回数</th>
					<th style="width:10%">重量</th>
					<th style="width:15%">洗濯量(Kg)</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($value['detail'] as  $item) { 
					$total_quantity += $item['quantity'];
					$total_weight += $item['weight'];
					?>
					<tr>
						<td><?= $item[LM_CODE]?></td>
						<td><?= $item[LM_ITEM_NAME_1]?></td>
						<td><?= number_format($item['quantity'])?></td>
						<td><?= number_format($item['weight'],2,'.',',')?></td>
						<td><?= number_format($item['weight'],2,'.',',')?></td>
					</tr>
				<?php }?>
					<tr>
						<td style="border-top:solid 3px black"></td>
						<td style="border-top:solid 3px black"></td>
						<td style="border-top:solid 3px black"><?= number_format($total_quantity) ?></td>
						<td style="border-top:solid 3px black"></td>
						<td style="border-top:solid 3px black"><?= number_format($total_weight,2,'.',',') ?></td>
					</tr>
			</tbody>
		</table>
		<pagebreak />
	<?php }?>

</div>
<style>
	th{
		font-size:14pt;
		text-align: left;
		border-bottom:solid 3px black
	}
	table{
		border-collapse: collapse;
	}
</style>