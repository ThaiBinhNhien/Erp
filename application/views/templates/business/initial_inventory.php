<style>
	.inventory input[type="radio"]{
		width:auto !important;
	}
	.inventory button input{text-align: center;
		display:block;
		margin:0 auto;
	}
	.inventory button{
		min-height:73px;
	}
	.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
		display: inline-block;
		width: auto;
		margin-left: 10px;
		margin-right: 0;
		width: 170px;
	}
	.dropdown-menu{
    background-color: #ffffff;
    z-index:99999;
}
.bootstrap-select button{
	height: 28px !important;
    min-height: 0 !important;
    padding: 6px 12px;
    border-radius: 0;
    border: 1px solid rgb(169, 169, 169);
}
.inventory .part-4 .col-4 label:nth-child(2) {
    padding-top: 23px;
    font-size: 15px;
}
</style>
<div class="container">
<div class="wrapper-contain inventory order">
<div class="inventory-left">
<div class="row">
<div class="col-md-4">
	<h3>商品回転率</h3> 
</div>
</div>

<div>&nbsp;</div>
<div>&nbsp;&nbsp;日付 : <?php echo $exp_from; ?> ～ <?php echo $exp_to; ?></div>
</div>

<div class="row" style="padding: 0 30px;">
<div class="col-md-12">
<div class="table-responsive">
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
                <th class="text-center" width="8%">商品コード</th>
				<th class="text-center" width="12%">商品名</th>
				<th class="text-center" width="8%">規格</th> 
				<th class="text-center" width="8%">色調</th> 
				<th class="text-center" width="10%">棚卸日(直近)</th> 
                <th class="text-center">棚卸数(直近)</th>
                <th class="text-center">累計出庫数</th>
                <th class="text-center">累計廃棄数</th>
				<th class="text-center">使用中リネン</th>
				<th class="text-center">累計納品数</th>
				<th class="text-center">回転率</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($data_result) && $data_result != null) { 
                foreach ($data_result as $key => $value) {
			?>
				<tr>
					<td><?php echo $value['product_code_sell']; ?></td>
					<td><?php echo $value['product_name_sell']; ?></td>
					<td><?php echo $value['product_format']; ?></td>
					<td><?php echo $value['product_color']; ?></td>
					<td class="text-center"><?php echo $value['date_initial']; ?></td>
					<td class="text-right"><?php echo $value['number_initial']; ?></td>
					<td class="text-right"><?php echo $value['number_export']; ?></td>
					<td class="text-right"><?php echo $value['number_disposal']; ?></td>
					<td class="text-right"><?php echo $value['number_product']; ?></td>
					<td class="text-right"><?php echo $value['number_delivery']; ?></td>
					<td class="text-right border-right">
						<?php 
						if($value['number_delivery'] > 0 && $value['number_product'] > 0) {
						echo round(($value['number_delivery']/$value['number_product']),2);
						} else {
							echo '0';
						}
						 ?></td>
				</tr>
			<?php } } ?>
		</tbody>
	</table>
</div>
</div>
</div>


</div>
</div> 
<script>
	var url_inventory_type1 = "<?= base_url("pdf_inventory_list") ?>";
	var url_warehouse_status = "<?= base_url("pdf_warehouse_status") ?>";
	var url_detergent_condition = "<?= base_url("pdf_detergent_condition") ?>";
	var url_pdf_details_buy = "<?= base_url("pdf_details_buy") ?>";
	var url_pdf_purchase_ledger = "<?= base_url("pdf_purchase_ledger_collective") ?>";
	var url_delivery_achievement_rate = "<?= base_url("pdf_delivery_achievement_rate") ?>";
	var url_pdf_initial_inventory = "<?= base_url("pdf_initial_inventory") ?>";
	var productSearchUrl = "<?= site_url('/product/search-by-name')?>";
	var message_error_not_select_report = "<?= $this->lang->line('message_error_not_select_report') ?>";
	var message_error_not_select_date_report = "<?= $this->lang->line('message_error_not_select_date_report') ?>";
</script>
