<div>
<div>
	<div class="col-lg-4"><h3><?= $date ?></h3></div>
	<div style="float:left;margin-left:10%;width:30%"><h2>タ ワ ー ル ー ム リ ネ ン 納 品 書</h2></div>
	<div style="float:right;margin-left:10px;width:20%"><h3>株式会社テーオーリネンサプライ</h3></div>
</div>
<?php $total = 0;
	  $page_break = 1;
 ?>
<?php foreach ($productLst as $size => $valueMaster) {
	$ratio = count($valueMaster)*4.98;
	$width = (($size == (count($productLst)-1)) && count($valueMaster) != 20)?'style="width:'.$ratio.'%"':'style="width:100%"';
	?>

	<div class="clearfix">
		<table <?= $width?>>
			<thead >
				<tr>
					<th></th>
					<?php foreach ($valueMaster as $key => $value) {
							echo "<th >".$value[PL_PRODUCT_NAME]."</th>";
					}?>
				</tr>
			</thead>
			<tbody>
				<?php 
					$even = false;
				 	foreach ($floor as $key => $value) { ?>
					<tr <?= $even==true?'class="even"':'' ?>>
						<td><?= $key ?></td>
						<?php foreach ($valueMaster as $index => $item) {
							echo "<td>".(isset($value[$item[OD_ID]])?$value[$item[OD_ID]]["quantity"]:"")."</td>";
						}?>
					</tr>
				<?php $even = !$even; } ?>
				<tr style="background-color:#ffaa80;border-top:solid 5px black">
					<td style="border-top:solid 5px black">小計</td>
				<?php foreach ($valueMaster as $index => $item) {
					echo '<td style="border-top:solid 5px black">'.$item[OD_QUANTITY]."</td>";
				}?>
				</tr>
				<tr style="background-color: #ffdb4d">
					<td>追加</td>
				<?php foreach ($valueMaster as $index => $item) {
					echo "<td>".$item[OD_ADD]."</td>";
				}?>
				</tr>
				<tr style="background-color:#ffaa80">
					<td>合計</td>
				<?php foreach ($valueMaster as $index => $item) {
					$total += $item[OD_QUANTITY]+$item[OD_ADD];
					echo "<td>".number_format($item[OD_QUANTITY]+$item[OD_ADD],2)."</td>";
				}?>
				</tr>
			</tbody>
		</table>
					        
	</div>
	<?php if( $page_break %2 == 0) {
		echo '<pagebreak />';
	}
	$page_break += 1;
	?>
<?php }?>
<div class="clearfix" style="float:right;margin-right:20px;width:20%">
	<table width="100%">
		<tbody>
			<tr>
				<td colspan="2" style="text-align:center">担当者</td>
			</tr>
			<tr style="height:90px">
				<td style="height:90px"></td>
				<td style="height:90px"></td>
			</tr>
		
		</tbody>
	</table>
	<div style="width:100%">
		<div style="float:left;width:50%">合計点数</div>
		<div style="float:left;width:50%"><?= $total ?></div>
	</div>
</div>
</div>
<style type="text/css">
	.col-lg-4 {
    	width: 20%;
    	float: left;
	}
	table{
		border-collapse: collapse;
	}
	td,th,tr:not(.header-date){
		border: solid 2px black;

	}
	th{
		padding: 5px
	}
	td{
		padding: 10px
	}
	.clearfix{
		clear: both;
		margin-top: 20px
	}
	.even{
		background-color: #80ffff;
	}
	@page { sheet-size: A3-L; }
  
</style>