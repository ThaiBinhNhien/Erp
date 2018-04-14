<style>
	.fontJapan {
		font-family : "sun-exta";
	}
	table{
		border-collapse: collapse;
	}
</style>
<div>
	<table width="100%" class="table">
		<thead>
			<tr>
				<th width="10%" class="text-center border-bottom2 color030a84 size120">売上日</th>
				<th width="10%" class="text-center border-bottom2 color030a84 size120">ｸﾞﾙｰﾌﾟｺｰﾄﾞ</th>
				<th width="10%" class="text-center border-bottom2 color030a84 size120">グループ</th>
				<th width="10%" class="text-center border-bottom2 color030a84 size120">商品コード</th>
				<th width="10%" class="text-center border-bottom2 color030a84 size120">商品名</th>
				<th width="10%" class="text-center border-bottom2 color030a84 size120">数量</th>
				<th width="10%" class="text-center border-bottom2 color030a84 size120 fontJapan">ＣＯＬＯＲ</th>
				<th width="10%" class="text-right border-bottom2 color030a84 size120">数量の合計</th>
				<th width="10%" class="text-right border-bottom2 color030a84 size120">単価</th>
				<th width="10%" class="text-right border-bottom2 color030a84 size120">金 額</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($category)) { ?>
			<tr>
				<th class="text-center">&nbsp;</th>
				<th class="text-center"><?php echo $category['group_code']; ?></th>
				<th class="text-center"><?php echo $category['code']; ?></th>
				<th class="text-center">&nbsp;</th>
				<th class="text-center">&nbsp;</th>
				<th class="text-center">&nbsp;</th>
				<th class="text-center">&nbsp;</th>
				<th class="text-right">&nbsp;</th>
				<th class="text-right">&nbsp;</th>
				<th class="text-right">&nbsp;</th>
			</tr>
			<?php } ?>
			
			<?php if(isset($detail)) { 
				$totalQuantity = 0;
				$totalAmount = 0;
				?>
				<tr>
					<th rowspan="<?php echo count($detail)+1; ?>" colspan="3" class="text-left" style="vertical-align: text-top;"><?php echo $date_report; ?></th>
				</tr>
				<?php
				foreach ($detail as $key => $value) {
					if($value["group_code"] == $category['group_code']) {
					$totalQuantity += $value['product_quantity'];
					$totalAmount += $value['product_amount'];
				?>
				<tr>
					<th class="text-center"><?php echo $value['product_code']; ?></th>
					<th class="text-center"><?php echo $value['product_name']; ?></th>
					<th class="text-center"><?php echo $value['product_format']; ?></th>
					<th class="text-center"><?php echo $value['product_color']; ?></th>
					<th class="text-right"><?php echo number_format($value['product_quantity'],0,",",","); ?></th>
					<th class="text-right"><?php echo number_format($value['product_price'],0,",",","); ?></th>
					<th class="text-right"><?php echo number_format($value['product_amount'],0,",",","); ?></th>
				</tr>
			<?php } } } ?>

			<tr>
				<th colspan="10">&nbsp;</th>
			</tr>
			<tr>
				<th colspan="4" class="text-center sizeBig">合 計</th>
				<th class="text-right"><?php echo number_format($totalQuantity,0,",",","); ?></th>
				<th class="text-right">&nbsp;</th>
				<th class="text-right"><?php echo number_format($totalAmount,0,",",","); ?></th>
			</tr>
			
		</tbody>
	</table>
</div>