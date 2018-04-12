<htmlpageheader name="myhead" >
	<div style="background-color:#c2d1f0;width:100%;padding:15px">
		<div style="width:50%;float:right;text-align:right;font-weight:bold">
			<div><?= $this->helper->readDate(date('Y/m/d')) ?></div>
			<div>{PAGENO}/{nb} ページ</div>
		</div>
		<div style="width:50%;font-weight:bold;float:left;font-size:20pt">
			<div style="width:40%;float:left">月間生産概要</div>
			<div style="width:40%;float:left;margin-left:10px"><?= $date ?></div>
		</div>
	</div>
			
</htmlpageheader>
<sethtmlpageheader name="myhead" page="ALL" value="1" show-this-page="1"/>
<div style="width:100%;margin-top:100px">
	<table style="width:100%;margin-top:10px">
		<tbody>
		<?php
		 if($lstMaster != NULL){
		 foreach ($lstMaster as $key => $value) {
		 	$total_quantity = 0;
		 	$total_weight = 0;?>
		 	<tr style="border-bottom:solid 3px black">
				<td style="font-weight:bold"><?= mb_convert_encoding($value['name'], "SJIS","UTF-8")  ?></td>
				<td>回数</td>
				<td>重量(Kg)</td>
			</tr>
			<?php foreach ($value['detail'] as $item) { 
				$total_quantity += $item['quantity'];
				$total_weight += $item['weight'];?>
				<tr>
					<td><?= $item['item_name'] ?></td>
					<td><?= number_format($item['quantity']) ?></td>
					<td><?= number_format($item['weight'],2,'.',',') ?></td>
				</tr>
			<?php }?>
			<tr >
				<td style="border-top:solid 1px black"></td>
				<td style="border-top:solid 1px black"><?= number_format($total_quantity) ?></td>
				<td style="border-top:solid 1px black"><?= number_format($total_weight,2,'.',',') ?></td>
			</tr>

		<?php }}?>
		</tbody>
	
	</table>
	

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
	td{
		padding: 7px;
	}
</style>