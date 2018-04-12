<style>
.dataTables_wrapper .dataTables_processing {
background-color:red;
}
</style>
<div class="wrapper-contain shipment order" id="shipment">
<div class="first-row">
<form class="form-horizontal" role="form">
    <div class="row">
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">出荷票No:</label>
          <div class="col-md-8">
            <input class="form-control" id="ticket_no" >
          </div>
        </div>
      </div> 
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputPassword" class="col-md-4 control-label">起票者:</label>
          <div class="col-md-8">
          <input class="form-control" id="shipment_voter" >
          </div>
        </div>
      </div>
	<div class="clearfix"></div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input7" class="col-md-4 control-label">配送便区分:</label>
          <div class="col-md-8">
            <select class="form-control" id="shipping_category">
            	<option></option>
            	<?php if($list_classification != null && $list_classification != '') { 
            		foreach ($list_classification as $key => $value) {
                        echo '<option value="'.$value[DC_ID].'" data-container="'.$value[DC_NUMBER_CONTAINER].'" data-truck="'.$value[DC_NUMBER_TRUCK].'">'.$value[DC_NAME].'</option>';
                    }
            	}?>
            </select>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input8" class="col-md-4 control-label">形態:</label>
          <div class="col-md-8">
			  <select class="form-control" id="shipment_status">
				<option value="2">出荷未確定</option>
				<option value="1">一時保存</option>
				<option value="3">再依頼</option>
				<option value="4">出荷確定（不足）</option>
				<option value="5">出荷確定</option>
			  </select>
          </div>
        </div>
      </div>
	<div class="clearfix visible-lg-block visible-md-block"></div>
	<div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputPassword" class="col-md-4 control-label">納品予定日:</label>
          <div class="col-md-8">
            <span class="form-control form-control-input">
            <input  class="" id="delivery_from">
           <span class=" icon-large icon-calendar "></span>
            </span>    
            
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group ">
          <label  class="col-md-4 control-label center" style="line-height:2.5;padding-top:0;"> <span id="character">~</span></label>
          <div class="col-md-8">
           <span class="form-control form-control-input">
            <input  class="" id="delivery_to">
           <span class=" icon-large icon-calendar "></span>
            </span>    
          </div>
        </div>
      </div>
	 <div class="clearfix visible-lg-block visible-md-block"></div>
     <div class="col-sm-12 col-md-4 col-lg-4" style="margin-top:5px;">
        <div class="form-group">
          <label for="input9" class="col-md-4 control-label ">お得意先:</label>
          <div class="col-md-8">
              <select class="form-control" id="customer" ><option></option></select>
          </div>
        </div>
      </div>
   <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input9" class="col-md-4 control-label" style="line-height:2;">部署名:</label>
          <div class="col-md-8">
              <select class="form-control" style="margin-bottom:0;margin-top:5px;" id="department_name" ><option></option></select>
          </div>
        </div>
      </div>
	 <div class="clearfix visible-lg-block visible-md-block"></div>
	<div class="col-sm-12 col-md-8 col-lg-8">
        <div class="form-group">
          <label for="input9" class="col-md-2 control-label ">テキスト:</label>
          <div class="col-md-10">
              <input style="width:150%;margin-left:2px;" id="text_note" />
          </div>
        </div>
      </div> 
    </div>
  </form>
</div>
<div class="row left"> 
            <a class="print" id="search_shipment">検索 </a>
</div>
<div class="clearfix"></div>
<div class="row first-row">
  <a id="btnExportList" class="print left">CSV出力</a>
  <?php if($role_order == true || $role_manager == true) { ?>
        <a href="<?php echo site_url('shipment/add') ?>" class="print right" style="margin-right:26px;">新規作成画面へ</a>       
  <?php } ?>
</div>	
<div class="row third-row">	     

<div>
<table class="display datatable dataTable responsive cell-border" id="shipment_table" cellspacing="0" width="100%">
    <thead style="border:none !important;">
        <tr style="border:none !important;">
            <th>出荷票No</th>
            <th>作成日</th>
            <th>お得意先</th>
            <th style="max-width:150px;width:150px;min-width:150px;">部署名</th>
            <th>配送便区分</th>
            <th>形態</th>
            <th>納品予定日</th>           
         </tr>
    </thead>
    <tbody class="over_loading">
    <!-- <tr class="odd row-empty">
    <td valign="top" colspan="7" class="dataTables_empty">
    <button class="btn btn-lg btn-warning"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...</button>
    </td></tr> -->
    </tbody>
</table>
</div>	
</div>
</div>
<input type="hidden" value="<?= base_url("shipment/detail_shipment") ?>" id="shipmentViewUrl" />

<script> 
var detailShipmentViewUrl = document.getElementById('shipmentViewUrl').value;
var shipmentViewUrl = "<?= base_url("shipment/get-shipment-view") ?>";
var getCustomerByClassification = "<?= base_url("shipment/get-customer-by-classification") ?>";
var getDepartmentByCustomer = "<?= base_url("shipment/get-department") ?>";
var getCustomerByDepartment = "<?= base_url("shipment/get-customer") ?>";
var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
var url_export = "<?= base_url("shipment/export") ?>";
</script>
