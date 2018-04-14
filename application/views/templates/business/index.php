<style>
	.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
		display: inline-block;
    	width: auto;
	}
	.dropdown-menu{
    background-color: #ffffff;
    z-index:99999;
}
.bootstrap-select button{
	height: auto !important;
    min-height: 0 !important;
    padding: 6px 12px;
    border-radius: 0;
    border: 1px solid rgb(169, 169, 169);
}
.btn-2{
    display: table-cell; 
    vertical-align: middle;
    /* height: 50px; */
    border: 1px solid #989494;
    padding: 20px;
    background: #d4d4d4;
    min-width: 150px;
    text-align: center;
}
.btn-2 input{
    margin: 0 auto;
    display: block;
}
.btn-2 input{
	margin-top:30px !important;
}
.btn-1{
	border: 1px solid #989494;
    padding: 20px;
    background: #d4d4d4;
    min-width: 150px;
    text-align: center;
    float:left;
    display: table-cell;
    vertical-align: middle;
}
select:disabled {
    background-color: #eee;
}
</style>
<div class="wrapper-contain business order"> 
<div class="row">
<div class="col-md-4">
	<h3>営業管理</h3>
</div>
<div class="button-right-side">
	<a href="<?php echo site_url('business/inventory');?>" class="print right" ><i class=""></i>在庫管理</a>    
	<a href="<?php echo site_url('business/produce');?>" class="print right top-print" ><i class=""></i>生産管理</a>
</div> 	
</div><!--End title--> 
<div class="index">
<div class="row first-row">
	<div class="col-md-9  col-sm-10 ">
		<label >期間:</label>	
		<span><input id="dateFrom" name="dateFrom" type="text">
		<span class="icon-large icon-calendar"></span></span>
		<label id="todate">~</label><input name="dateTo" id="dateTo" type="text">
		<span class="icon-large icon-calendar"></span>   
	</div>
 </div>
<div class="row" >
    <div class="col-md-9  col-sm-10 ">
		<div class="btn-1"><input type="radio" value="1" class="m-radio" name="m-radio"><label>日計表</label></div>
		<label style="margin-top:15px;"><input disabled="disabled" type="radio" value="1" name="radio-1" class="radio-1">日計表A</label>
		<label ><input disabled="disabled" type="radio" value="2" name="radio-1" class="radio-1">日計表B</label>
	</div>
</div>
<div class="row first-row">
	<div class="col-md-9  col-sm-10 ">		
	<div class="btn-2"><input type="radio" value="2" class='n-radio' name="m-radio"><label>売上一覧</label></div>
	<div class="column-2">
		<label style="line-height:2"><input disabled="disabled" value="1" class="radio-2" type="radio" name="radio-2">点数表 </label>
		<div style="margin-bottom: 5px;">      

		<div class="row">
		<div class="col-md-4" style="padding-left: 0;padding-top: 10px;">
		<label style="width: 120px;"><input disabled="disabled" value="2" class="radio-2" type="radio" name="radio-2">得意先別</label>    
			 </div>
			 	<div class="col-md-6">
				 <select disabled name="select-customer" id="select_customer" data-live-search="true" title="" data-live-search-placeholder="Search">
					<option value="">得意先名</option>
					<?php foreach ($list_customer as $key => $value) {
					echo '<option value="'.$value[CUS_ID].'" title="'.$value[CUS_CUSTOMER_NAME].'">'.$value[CUS_CUSTOMER_NAME].'</option>';
					} ?>
					
				</select>
				</div>
			 </div>
			
			
		 </div>              
		<div style="margin-bottom: 5px;">          
			<div class="row">
			 <div class="col-md-4" style="padding-left: 0;padding-top: 5px;">
			 <label style="width: 120px;"><input disabled="disabled" value="3" class="radio-2" type="radio" name="radio-2">商品別</label> </div>
			 	<div class="col-md-6" id="box-product-select">
				 <input class="form-control"  disabled="disabled"  name="select-product" id="select_product" style="    width: 150px;" ></div>
			 </div>

		</div>                            
		 <select class="" name="select-time" id="select_type_time">
		 <option value=""></option>
			 <option value="1">日報</option>
			 <option value="2">旬報</option>
			 <option value="3">月報</option>
			 <option value="4">年報</option>
		 </select>
	</div>
	</div>  
</div>
<div class="row margin-bottom-table" >
	<a id="btnPrintCsv" class="print" >CSV出力</a>
	<a id="btnPrint" class="print" >印刷 </a>
	<a id="btnPreview" class="print" >表示 </a>
</div>
</div> 
</div>
<script>
	var scheduleDailyA = "<?= base_url("pdf_daily_schedule_a") ?>";
	var scheduleDailyB = "<?= base_url("pdf_daily_schedule_b") ?>";
	var pdfSalesScore = "<?= base_url("pdf_sales_score") ?>";
	var pdfSalesProduct = "<?= base_url("pdf_sales_product") ?>";
	var pdfSalesCustomer = "<?= base_url("pdf_sales_customer") ?>";
	var productSearchUrl = "<?= site_url('/product/search-by-name')?>";
	var customerSearchUrl = "<?= site_url('/customer/search-by-name')?>";
	var message_error_not_select_report = "<?= $this->lang->line('message_error_not_select_report') ?>";
	var message_error_not_select_time_exp = "<?= $this->lang->line('message_error_not_select_time_exp') ?>";
	var get_product_selectbox = "<?= base_url("product/get_product_selectbox") ?>";
</script>