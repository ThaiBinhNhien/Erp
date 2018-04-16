<style>
	.debt .form-control{
		display:inline;
	}
	.print{
		width:105px; 
	}
</style>
<div class="wrapper-contain purchase debt">
<div class="row">
<div class="right">
    <a href="<?php echo site_url('purchase') ?>" class="print top-print">仕入管理</a>
	<a href="<?php echo site_url('purchase/export-purchase') ?>" class="print">出庫管理</a>
</div>
</div>
<div class="row">
<div class="col-md-10 col-md-offset-1 col-sm-10">
		<h3><?php echo $title; ?></h3>	
		</div></div>
<div class="row  margin-top-table">
    <div class="col-md-10 col-md-offset-1 col-sm-10">
        <label for='User'  class="col-md-2 first-label">レポート内容</label> 
        <div class="col-md-10" style="margin-top:4px;">
			<label><input type="radio" name="content" value="1" checked class="center-15">当社買掛金（未払金）明細（単月）    *月次以外の期間指定帳票は、「業務管理」を利用ください</label><br/>
			<label><input type="radio" name="content" value="2" class="center-15">外注分請求書（単月）　　*月次以外の期間指定帳票は、「業務管理」を利用ください</label><br/>
			<label><input type="radio" name="content" value="3" class="center-15">単価チェック</label>
			<select class="select-1 center-15 form-control" id="check_moneybill">
				<option value="">全て</option>
				<option value="0">当社仕入品分のみ</option>
				<option value="1">外注先分のみ</option>
			</select>
        </div>
    </div>
</div>
<div class="row margin-top-table">
    <div class="col-md-10 col-md-offset-1">
        <label for='User'  class="col-md-2 second-label">表示条件</label>
        <div class="col-md-8" style="margin-top:4px;">
		<label class="center-15">納品日 <input class="center-15 datepicker" id="getValueDeliveryFrom" style="margin-bottom: 0;"><span class=" icon-large icon-calendar"></span> &nbsp;&nbsp;&nbsp;&nbsp;〜<input class="center-15 datepicker" id="getValueDeliveryTo" style="margin-bottom: 0;"><span class=" icon-large icon-calendar"></span></label><br/>
			<label class="center-15">入庫</label><label class="center-15"> 済み</label><br/>
			<label class="center-15">入庫日 <input class="center-15" id="getValueMonth" style="margin-bottom: 0;"><span class=" icon-large icon-calendar"></span></label><br/>
			<label class="center-15">仕入先
				<select  class="center-15 select-2 form-control" id="getValuePlaceBuy">
					<option value="">全て</option>
					<?php foreach ($list_place_buy as $key => $value) {
                  echo '<option value="'.$value[SUP_ID].'" title="'.$value[SUP_ID].'">'.$value[SUP_SUPPLIER_COMPANY_NAME].'</option>';
                } ?>
				</select>
			</label><br/>
			<label class="center-15">販売先
			<select  class="center-15 select-2 form-control" id="getValuePlaceSale" disabled >
				<option value="">全て</option>
				<?php foreach ($list_place_sale as $key => $value) {
                  echo '<option value="'.$value[TSD_ID].'" title="'.$value[TSD_ID].'">'.$value[TSD_DISTRIBUTOR_NAME].'</option>';
                } ?>
			</select>   
			</label>
        </div>
    </div>
</div>
	<div class="row first-row">
		<div class="col-md-10 col-md-offset-1">
			<a style="margin-left:0;" id="btnReport" class="print create-purchase-order left">レポーティング</a>
		</div>
	</div>
</div>
<script>
	var message_error_not_select_date_import_inventory = "<?= $this->lang->line('message_error_not_select_date_import_inventory') ?>";
	var Our_Accounts_Payable_Details = "<?= site_url('/pdf_details_buy_buying')?>";
	var url_check_price = "<?= site_url('/purchase/detailDebt')?>";
</script>
