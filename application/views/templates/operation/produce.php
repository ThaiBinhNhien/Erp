<style>

#prod-1,#prod-2,#prod-3,#prod-4,#prod-5,#prod-6,#prod-7,#prod-8 {
    display: table-cell;
    vertical-align: middle;
    /* height: 50px; */
    border: 1px solid #989494;
    padding: 20px;
    background: #d4d4d4;
    min-width: 150px;
    text-align: center;
}
#prod-1 input,#prod-2 input,#prod-3 input,#prod-4 input,#prod-5 input,#prod-6 input,#prod-7 input,#prod-8 input{
    margin: 0 auto;
    display: block;

}
#prod-6 input{
	margin-top:25px;
}
select:disabled {
    background-color: #eee;
}
input:disabled {
    background-color: #eee;
}
</style>
<div class="container">
<div class="wrapper-contain product order">
<div class="inventory-left">
<div class="row">
<div class="col-md-4">
	<h3>生産管理</h3>
</div>
        <div class="button-right-side">
            <a href="<?php echo site_url('business-management');?>" class="print right" ><i class=""></i>営業管理</a>    
            <a href="<?php echo site_url('business/inventory');?>" class="print right top-print " ><i class=""></i>在庫管理</a>
			
        </div>
</div>

<div class="row first-row">
	<div class="col-1" id="prod-1"><input type="radio" name="report-produce" id="rd-prod-1" ><label>営業日報</label></div>	
	<div class="wrap-input-1">
	<div class="wrap-col">
    <div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3">
		<span class="right "><input  class="datepicker" type="text" id="ep1_date_from">
			<span class="icon-large icon-calendar"></span>
		</span>
    </div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	</div>
	<div class="col-5" style="clear:right;">
		<span class="right line-1"><input  class="datepicker" type="text" id="ep1_date_to">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	</div>
</div>

<div class="row">
	<div class="col-1" id="prod-2"><input type="radio" name="report-produce" id="rd-prod-2" ><label>生産実績表</label></div>	
	<div class="wrap-input-2">
	<div class="wrap-col-6">
    <div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3">
		<span class="right "><input  class="datepicker" type="text" id="ep2_date_from">
			<span class="icon-large icon-calendar"></span>
		</span>
		
    </div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="col-5">
		<span class="right line-1"><input  class="datepicker" type="text" id="ep2_date_to">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	
	</div>
	<div class="col-6">
	&nbsp;
	</div>
	<div class="col-7">
		<select id="ep2_select">
			<option value="1">得意先別生産実績表（商品別)</option>
			<option value="2">得意先別生産実績表（得意先別)</option>
		</select>
	</div>
	</div>
</div>

<div class="row first-row">
	<div class="col-1" id="prod-3"><input type="radio" name="report-produce" id="rd-prod-3" ><label>納品集計表</label></div>	
	<div class="wrap-input-3">
	<div class="col-2">
		<label class="label-form">期間</label>
		<label class="lb-line-2" style="    padding-top: 10px;">得意先</label> 
	</div>
	<div class="col-3">
		<span class="right line-1"><input  class="datepicker" type="text" id="ep3_date_from">
			<span class="icon-large icon-calendar"></span>
		</span>
		<select class="line-2" id="ep3_cus">
			<option></option>
			<?php foreach ($customer as $key => $value) {
				echo '<option value="'.$value[CUS_ID].'">'.$value[CUS_CUSTOMER_NAME]."</option>";
			} ?>
		</select>
	</div>
	<div class="col-4">
		 <label class="label-todate" style="">~</label>
	</div>
	<div class="col-5">
		<span class="right"><input  class="datepicker" type="text" id="ep3_date_to">
		<span class="icon-large icon-calendar"></span></span>
	</div>
	</div>
</div>

<div class="row">
	<div class="col-1" id="prod-4"><input type="radio" name="report-produce" id="rd-prod-4" ><label>納品量合計</label></div>	
	<div class="wrap-input-4">
	<div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3">
		<span class="right "><input  class="datepicker" id="ep4_date_from">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="col-5">
		<span class="right first-input"><input  class="datepicker" id="ep4_date_to">
		<span class="icon-large icon-calendar"></span></span>
	</div>
	</div>
</div>

<div class="row first-row">
<div class="col-1" id="prod-5"><input type="radio" name="report-produce" id="rd-prod-5" ><label>仕上状況</label></div>	
	<div class="wrap-input-5">
	<div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3">
		<span class="right"><input  class="datepicker" id="ep5_date_from">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="col-5">
		<span class="right first-input"><input  class="datepicker" id="ep5_date_to">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	</div>	
</div>

<div class="row margin-bottom-table">
	<div class="col-1 btn-part-6" id="prod-6"><input type="radio" name="report-produce" id="rd-prod-6" ><label>生産状況</label></div>	
	<div class="wrap-input-6">
	<div class="wrap-col-6">
	<div class="col-2">
		<label class="label-form" style="line-height:0.5;padding-top: 12px;">期間</label>
	</div>
	<div class="col-3">
		<span class="right "><input  class="datepicker" id="ep6_date_from">
			<span class="icon-large icon-calendar"></span>
		</span>		
	</div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="col-5">
		<span class="right first-input"><input  class="datepicker" id="ep6_date_to">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="prod-row-2">
	<div>
	<div class="lb-row-1">
		<label><input type="radio" name="number-type-1" id="ep6_1" value="1" id="ep6.1">機種別洗濯量</label>
		<label><input type="radio" name="number-type-1" id="ep6_2" value="2" id="ep6.2">生産概要別洗濯量</label>
	</div>
	<div class="lb-row-2">
		<label><input type="radio" name="number-type-1" id="ep6_3" value="3" id="ep6.3">機種別洗濯コース別洗剤使用量</label>
		<label><input type="radio" name="number-type-1" id="ep6_4" value="4" id="ep6.4">洗剤別機種別使用量</label>
	</div>
	</div>
	<div class="lb-row-3">
		<label>（＊現機器別洗剤使用量）</label>
		<label>（＊現洗剤別使用量）</label>
	</div>
	</div>
	</div>
	<div class="col-6">
		<label class="label-form">機器</label>
		<label class="lb-line-2" style="    padding-top: 5px;">洗濯</label>
	</div>
	<div class="col-7">
		<select class="line-2" id="machine">
			<option value="">（すべて）</option>
			<?php foreach ($machine as $key => $value) { ?>
				<option value="<?= $value[EQ_CODE]?>"><?= $value[EQ_NAME] ?></option>
			<?php }?>
		</select>
		<select class="line-2" id="laundry">
			<option value="">（すべて）</option>
			<?php foreach ($laundry as $key => $value) { ?>
				<option value="<?= $value[LM_CODE]?>"><?= $value[LM_ITEM_NAME_2] ?></option>
			<?php }?>
		</select>
	</div>
	</div>
</div>

<div class="row top-10">
	<div class="col-1" id="prod-7"><input type="radio" name="report-produce" id="rd-prod-7" ><label>月間生産概要</label></div>	
	<div class="wrap-input-7">
	<div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3">
		<span class="right"><input  class="datepicker" id="ep7_date_from">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="col-5">
		<span class="right"><input  class="datepicker" id="ep7_date_to">
		<span class="icon-large icon-calendar"></span></span>
		</div>
	</div>
</div>

<div class="row margin-top-table">
<div class="col-1" id="prod-8"><input type="radio" name="report-produce" id="rd-prod-8" ><label>ボイラー運転状況</label></div>	
	<div class="wrap-input-8">
	<div class="wrap-col-2">
	<div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3"><span class="right "><input  class="datepicker" id="ep8_date_from">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="col-4">
		 <label class="label-todate" style="">~</label>
	</div>
	<div class="col-5">
		<span class="right first-input"><input  class="datepicker" id="ep8_date_to">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="prod-row-2">
		<label ><input type="radio" id="boler"  name="field">新帳票（数値）</label>
		<label ><input type="radio" id="boler_old" name="field">旧帳票（数値）</label>
		<label ><input type="radio" id="boler_graph" name="field">旧帳票（グラフ）</label>
	</div>
	</div>
	</div>
</div>
<div class="row first-row">
	<a href="" id="print_csv" class="print no-left-margin">CSV出力</a>
	<a href="#" id="print_pdf" class="print">印刷 </a>
	<a href="" id="preview" class="print">表示</a>
</div>
</div>
</div><!-- End container-->
</div><!-- End wrapper-contain-->
<script>
var ep1_url = "<?= base_url("operation/produce/pdf-produce-business") ?>";
var ep1_csv_url = "<?= base_url("operation/produce/csv-produce-business") ?>";
var ep2_1_url = "<?= base_url("operation/produce/pdf-produce-actual-by-product") ?>";
var ep2_2_url = "<?= base_url("operation/produce/pdf-produce-actual-by-cus") ?>";
var ep2_csv_1_url = "<?= base_url("operation/produce/csv-produce-actual-by-product") ?>";
var ep2_csv_2_url = "<?= base_url("operation/produce/csv-produce-actual-by-cus") ?>";
var ep3_url = "<?= base_url("operation/produce/pdf-produce-shipment-cus") ?>";
var ep3_csv_url = "<?= base_url("operation/produce/csv-produce-shipment-cus") ?>";
var ep4_url = "<?= base_url("operation/produce/pdf-produce-shipment") ?>";
var ep4_csv_url = "<?= base_url("operation/produce/csv-produce-shipment") ?>";
var ep5_url = "<?= base_url("operation/produce/pdf-produce-finishing-situation") ?>";
var ep5_csv_url = "<?= base_url("operation/produce/csv-produce-finishing-situation") ?>";
var ep6_1_url = "<?= base_url("operation/produce/pdf-produce-weight-by-device") ?>";
var ep6_2_url = "<?= base_url("operation/produce/pdf-produce-amount-powder-used-by-device") ?>";
var ep6_3_url = "<?= base_url("operation/produce/pdf-produce-quantity-used-by-device") ?>";
var ep6_4_url = "<?= base_url("operation/produce/pdf-produce-washing-amount") ?>";
var ep6_csv_1_url = "<?= base_url("operation/produce/csv-produce-weight-by-device") ?>";
var ep6_csv_2_url = "<?= base_url("operation/produce/csv-produce-amount-powder-used-by-device") ?>";
var ep6_csv_3_url = "<?= base_url("operation/produce/csv-produce-quantity-used-by-device") ?>";
var ep6_csv_4_url = "<?= base_url("operation/produce/csv-produce-washing-amount") ?>";
var ep7_csv_url = "<?= base_url("operation/produce/pdf-produce-quantity-used-by-device") ?>";
var ep7_csv_url = "<?= base_url("operation/produce/csv-produce-quantity-used-by-device") ?>";
var ep8_1_url = "<?= base_url("operation/produce/pdf-produce-enegy-used") ?>";
var ep8_2_url = "<?= base_url("operation/produce/pdf-produce-enegy-graph") ?>";
var ep8_csv_1_url = "<?= base_url("operation/produce/csv-produce-enegy-used") ?>";
var ep8_csv_2_url = "<?= base_url("operation/produce/csv-produce-enegy-graph") ?>";
</script>