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

#invent-2,#invent-3,#invent-4,#invent-5,#invent-6,#invent-7,#invent-8 {
    display: table-cell;
    vertical-align: middle;
    /* height: 50px; */
    border: 1px solid #989494;
    padding: 20px;
    background: #d4d4d4;
    min-width: 150px;
    text-align: center;
}
#invent-2 input,#invent-3 input,#invent-4 input,#invent-5 input,#invent-6 input,#invent-7 input,#invent-8 input{
    margin: 0 auto;
    display: block;
}
#invent-2{
	padding:40px;
}
#invent-6{
	padding-top: 62px;
	padding-bottom: 65px;
}
select:disabled {
    background-color: #eee;
}
input:disabled {
    background-color: #eee;
}
</style>
<div class="container">
<div class="wrapper-contain inventory order">
<div class="inventory-left">
<div class="row">
<div class="col-md-4">
	<h3>在庫管理</h3>
</div>
        <div class="button-right-side">
            <a href="<?php echo site_url('business-management');?>" class="print right" ><i class=""></i>営業管理</a>    
            <a href="<?php echo site_url('business/produce');?>" class="print right top-print"><i class=""></i>生産管理</a>
        </div>
</div>

<!-- --------------------------Part-2--------------------------------- -->
<div class="row margin-top-table part-2">
	<div class="col-1" id="invent-2"><input type="radio"  value="1" name="produce"><label>貯蔵品一覧</label></div>
	<div class="col-2">
		<label class="label-form" name="position" >拠点</label>
		<label class="label-form line-2" name="select-date">タイプ</label> 
		 <label  class="label-form" style="padding-top:24px;">期間</label>  
	</div>
	<div class="col-3">
		<select disabled class="right-20 invent-2" id="select_place_stock" style="margin-bottom:-5px !important;">
			<option value="">全拠点</option> 
			<?php foreach ($list_stock as $key => $value) {
                  echo '<option value="'.$value[BM_BASE_CODE].'" title="'.$value[BM_BASE_NAME].'">'.$value[BM_BASE_NAME].'</option>';
                } ?>
		</select>
		<select  disabled class="right-20 invent-2 select-opt" id="select_detergent_buy" style="    margin-top: 20px;" ><option value="1">仕入品</option><option value="2">洗剤等</option></select>
		<span class="right">
			<input disabled class="datepicker invent-2" id="value_date_expiration">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="col-4">
		<label  class="label-form" style="padding-top:56px;">条件</label>    
	</div>
	<div class="col-5">
		<select disabled class="right-20 invent-2" id="select_type_report" style="margin-top:52px;">
		<option class="opt-1" value="1">在庫一覧（決算用）  </option>
		<option class="opt-1" value="2">要発注商品のみ  </option>
		<option class="opt-2" value="3" style="display:none;">在庫一覧（仕入先別）</option>
		</select>
	</div>
</div>
<!-- --------------------------Part-3--------------------------------- -->
<div class="row margin-top-table part-3">
   		<div class="col-1" id="invent-3"><input type="radio" name="produce"  value="2" ><label>納品達成率</label></div>
        <div class="col-2">
			<label class="label-form">期間</label> 
			<label class="label-form line-2">商品ID</label>  
        </div>
        <div class="col-3" >
			 <span  class="right" style="margin-bottom: 7px;">
				 <input disabled  class="invent-3" id="delivery_achienvement_from">
                 <span class="icon-large icon-calendar"></span>
			 </span>
		<div class="right-20" id="box-product-select">
		<input class="form-control"  disabled="disabled"  name="delivery_achienvement_product" id="delivery_achienvement_product" style="    width: 150px;" >
		</div>
			
        </div>
	  	<div class="col-4">
	  		<label class="label-form">~</label> 
	  	</div>
	  	<div class="col-5">
	  		<span class="right"><input  disabled class="invent-3" id="delivery_achienvement_to">
             <span class="icon-large icon-calendar"></span></span>
	  	</div>
<!-- --------------------------Part-4--------------------------------- --> 
</div>
<div class="row margin-top-table part-4">
	<div class="col-1" id="invent-4"><input id="invent-4"  type="radio" name="produce"  value="3" style="margin-left: -20px;" ><label>使用中リネン品<br/>回転率</label></div>
	<div class="col-2">
		<label class="label-form">拠点</label> 
		<label class="label-form line-2">期間</label> 
	</div>
	<div class="col-3" style="margin-top:8px !important;">
		<select disabled class="right-20 invent-4" id="initial_inventory_base">
		<option value="">全拠点</option> 
			<?php foreach ($list_stock as $key => $value) {
                  echo '<option value="'.$value[BM_BASE_CODE].'" title="'.$value[BM_BASE_NAME].'">'.$value[BM_BASE_NAME].'</option>';
                } ?>
		</select>
		<span class="right"><input  class=" invent-4" id="initial_inventory_date_from" disabled>
		<span class="icon-large icon-calendar"></span></span>
	</div>  
	<div class="col-4">
		<label  class="label-form">タイプ</label>
		<label class="label-form line-2">~</label>
	</div> 
	<div class="col-5" style=" margin-top: 8px;" >
		<select class="right-20 invent-4" id="initial_inventory_type_product" disabled>
			<option value="">全商品</option>
			<option value="1">要発注商品のみ</option>
		</select>
		<span class="right" ><input disabled class=" invent-4" id="initial_inventory_date_to">
             <span class="icon-large icon-calendar"></span></span>
	</div>
	<div class="col-5">
			 &nbsp;&nbsp;<span class="label-form line-2"><a id="btnPreviewinitial_inventory" class="print" >数量棚卸</a></span>
	</div>	
</div>
<!-- --------------------------Part-5--------------------------------- -->
<div class="row margin-top-table part-5" >
	<div class="col-1" id="invent-5"><input  name="produce"  value="4" type="radio"><label>入出庫状況</label></div>
	<div class="col-2">
		 <label class="label-form">期間</label> 
		 <label class="label-form line-2">商品ID</label>  
	</div>
        <div class="col-3">
			 <span class="right" style="margin-bottom: 10px;"><input disabled class=" invent-5" id="exp_from_warehouse_status">
                 <span class="icon-large icon-calendar"></span>
                </span>
				<!-- <select disabled class="right-20 invent-5 selectpicker" id="product_warehouse_status" style="margin-bottom:8px !important;" data-live-search="true" title="" data-live-search-placeholder="Search">
			<option value=""></option>
			<?php foreach ($list_product_i_o as $key => $value) {
                  echo '<option value="'.$value[PL_PRODUCT_ID].'" title="'.$value[PL_PRODUCT_NAME_BUY].'">'.$value[PL_PRODUCT_NAME_BUY].'</option>';
                } ?>
		</select> -->
		<div class="right-20" id="box-product-select2">
		<input class="form-control"  disabled="disabled"  name="product_warehouse_status" id="product_warehouse_status" style="    width: 150px;" >
		</div>
        </div>
	  	<div class="col-4">
	  		<label class="label-form">~</label>
			<label  class="label-form line-2">タイプ</label>
	  	</div>
	  	<div class="col-5">
	  		<span class="right"  style="margin-bottom: 10px;"><input disabled class=" invent-5" id="exp_to_warehouse_status">
             <span class="icon-large icon-calendar"></span></span>
			<select disabled class="right-20 invent-5" id="product_type_warehouse_status"><option value="1">仕入品</option><option value="2">洗剤等</option></select>
	  	</div>    
</div><!--End part-5-->
<!-- --------------------------Part-6--------------------------------- -->
<div class="row margin-top-table part-6">
	<div class="col-1" id="invent-6"><input  type="radio"  value="5" name="produce"><label>仕入台帳</label></div>        
	<div class="col-2">
		<label class="label-form">タイプ</label>           
		<label class="label-form line-2">期間</label>  
		<label class="label-form line-2">仕入先</label>  
		<label class="label-form line-2">ベース</label>  
	</div>
	<div class="col-3">
		<select class="right-20 invent-6" id="purchase_ledger_report_type" disabled>
			<option value="1">仕入品</option>
			<option value="2">洗剤等</option>
		</select>
		<span class="right">
		<input disabled class=" invent-6" id="purchase_ledger_date_from" >
		<span class="icon-large icon-calendar"></span>
		</span>
		<select class="right-20 invent-6" id="purchase_ledger_place_buy" style="margin-top: 12px;" disabled>
		<option></option> 
		<?php foreach ($list_place_buy as $key => $value) {
                  echo '<option value="'.$value[SUP_ID].'" title="'.$value[SUP_ID].'">'.$value[SUP_SUPPLIER_COMPANY_NAME].'</option>';
                } ?>
		</select>  
		<select class="right-20 invent-6 no-bottom-margin" id="purchase_ledger_import_export" disabled>
			<option value="1">入庫ベース</option>
			<option value="2">出庫ベース</option>
		</select>
	</div>
	<div class="col-4">
		<label class="label-form">~</label> 
		<label class="label-form line-2">販売先 </label> 
		
	</div>
	<div class="col-5">
		<span class="right"><input disabled  class=" invent-6" id="purchase_ledger_date_to">
		<span class="icon-large icon-calendar"></span></span>
		<select class="right-20 invent-6" style="margin-top: 12px;" id="purchase_ledger_place_sales" disabled>
		<option></option>
		<?php foreach ($list_place_sale as $key => $value) {
                  echo '<option value="'.$value[TSD_ID].'" title="'.$value[TSD_ID].'">'.$value[TSD_DISTRIBUTOR_NAME].'</option>';
                } ?>
		</select>
		
	</div>
	<div class="col-6">
		<label class="label-form">形式</label>			   
	</div>			        
	<div class="col-7">
		<select  class="invent-6" id="purchase_ledger_form_report" disabled>
		<option value="1">通常</option>
		<option value="2">差額形式</option>
		</select>
	</div>               
</div><!--End col-6-->
<!-- --------------------------Part-7--------------------------------- -->
<div class="row margin-top-table part-7">
	<div class="col-1" id="invent-7"><input type="radio"  value="6" name="produce" ><label>洗剤等使用状況</label></div>
	<div class="col-2">
			<label class="label-form line-2">期間</label> 
	</div>
	<div class="col-3">
			<span class="right" id="wrap"><input disabled name="startDate" id="startDate" class="date-picker invent-7" />
			<span class="icon-large icon-calendar"></span></span>
	</div>  
	
</div><!--End part-7-->		
<div class="row margin-top-table part-8" >
	<div class="col-1" id="invent-8"><input type="radio" name="produce"  value="7"  ><label>仕入品金額明細</label></div>
	<div class="col-2">
	
		<label class="label-form line-2">タイプ</label> 	
		<label class="label-form line-2">期間</label> 
		      
	</div>
	<div class="col-3">
			<select disabled class="right-20 invent-8" id="purchase_amount_date_type">
				<option value="1">仕入品</option>
				<option value="2">洗剤等</option>
			</select>
			<span class="right"><input disabled  class=" invent-8" id="purchase_amount_date_from">
			<span class="icon-large icon-calendar"></span></span>
	</div>  
	<div class="col-4">
		<label class="label-form line-2" >帳票</label> 	
		<label class="label-form line-2" >~</label> 
	</div>
	<div class="col-5">
		<select disabled class="right-20 invent-8" id="purchase_amount_report">
			<option value="2">外注分売上明細</option>
			<option value="1">当社買掛金（未払金)明細</option>
		</select>
		<span class="right"><input disabled class=" invent-8" id="purchase_amount_date_to">
			<span class="icon-large icon-calendar"></span></span>
	</div>
</div><!--End part-8-->	
<div class="row first-row">
	<div class="col-md-8">
		<a id="btnPrintCsv" class="print">CSV出力</a>
		<a id="btnPrint" class="print" >印刷 </a>
		<a id="btnPreview" class="print" >表示 </a>
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
	var get_product_selectbox = "<?= base_url("product/get_product_selectbox") ?>";
</script>
