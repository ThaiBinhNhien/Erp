<style>
	#detail-debt .no-input-table input{
		width:auto !important;
	}
</style>
<div class="wrapper-contain purchase order" id="detail-debt">
<div class="row">
	<div class="col-md-4">
	<div class="row">
		<h3><?php echo $title; ?></h3>	
	</div>
	

<div class="row"> 
 <table id="detail" class="detail-table">
        <tr>
           <td>入庫日:</td>
           <td><?= $date_month ?> – <?= $date_month ?></td>
           </tr>
            <tr>
           <td>入庫:</td>
           <td>済</td>
           </tr>
            <tr>
           <td>仕入先:</td>
           <td><?= $place_buy_name ?></td>
           </tr>
            <tr>
           <td>販売先:</td>
           <td><?= $place_sale_name ?></td>
           </tr> 
        </table>
    </div>
    
</div>
<div class="right top-print">
		<a href="<?php echo site_url('purchase') ?>" class="print">仕入管理</a>
		<a href="<?php echo site_url('purchase/export-purchase') ?>" class="print">出庫管理</a>
        <div style="padding-top: 10px;text-align: right;">
            <a id="btnPrintPdf" class="print">印刷</a>
        </div>
        
	</div>
</div>

<div class="row sec-row">
<table class="no-input-table" id="checklist_table" >
    <thead>
        <tr>
            <th>入庫日</th>
            <th>入庫番号</th>
            <th>商品ID</th>
            <th>商品名</th>
            <th>色調</th>
            <th>規格</th>
            <th>備考</th>
            <th>数量</th>
            <th>単価（円））</th>  
            <th>小計（円）</th> 
            <th><input type="checkbox" id="checkAll"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalAmount = 0;
        if(isset($data_check)) {
            foreach ($data_check as $key => $value) {
                $totalAmount += $value["number_import"] * $value["price"];
        ?>
            <tr>
                <td><?= $value["detail_date"]; ?></td>
                <td><?= $value["id_import"]; ?></td>
                <td><?= $value["product_buy_code"]; ?></td>
                <td><?= $value["product_buy_name"]; ?></td>
                <td><?= $value["product_color"]; ?></td>
                <td><?= $value["product_format"]; ?></td>
                <td><?= $value["note"]; ?></td>
                <td><?= $value["number_import"]; ?></td>
                <td><?= number_format($value["price"],0,",",","); ?></td>
                <td><?= number_format($value["number_import"] * $value["price"],0,",",","); ?></td>
                <td><input data-id="<?= $value["id"]; ?>" type="checkbox" class="btn_checkprice"></td>
            </tr>
        <?php
            }
        }
        ?>
        <tr class="sum-col">
            <td></td> 
            <td> 総合計</td>
             <td></td> 
             <td></td>
             <td></td> 
             <td></td> 
             <td></td> 
             <td></td> 
             <td></td> 
            <td><?= number_format($totalAmount,0,",",","); ?></td>
            <td></td>
        </tr>
    </tbody>
</table>
</div>                                  
	<div class="row first-row">
		<a id="btnSave" class="print right save-debt">保存  </a>
		<a href="<?php echo site_url('purchase/debt');?>" class="print right">戻る  </a>
	</div>
</div>
<script>
    var checkListUrl = "<?= base_url("purchase/check_price") ?>";
    var url_pdf_check_price = "<?= base_url("purchase/pdf_check_price") ?>";
    var notCheckData = "<?= $this->lang->line('message_error_not_checked')?>";
    var message_success_select_check_price = "<?= $this->lang->line('message_success_select_check_price')?>";
    var message_not_select_check_price = "<?= $this->lang->line('message_not_select_check_price')?>";
    var dateDeliveryFrom = "<?= $this->input->get('date_delivery_from') ?>";
    var dateDeliveryTo = "<?= $this->input->get('date_delivery_to') ?>";
    var valueDateImport = "<?=  $this->input->get('date_month') ?>";
    var getPlaceBuy = "<?= $this->input->get('place_buy') ?>";
    var getPlaceBuyName = "<?= $this->input->get('place_buy_name') ?>";
    var getPlaceSale = "<?= $this->input->get('place_sale') ?>";
    var getPlaceSaleName = "<?= $this->input->get('place_sale_name') ?>";
    var getTypeReport = "<?= $this->input->get('type_report') ?>";
</script>