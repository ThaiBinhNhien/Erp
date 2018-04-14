<style>
.no-order-table th {
    padding: 10px 0px !important;
}
input.select_product_code {
    padding: 6px;
    border: 1px solid rgba(154, 161, 168, 0.46);
    height: 95%;
    width: 99% !important;
}
.inputpicker-arrow {
    top: 5px;
}
</style>
<div class="wrapper-contain shipment order">
<div class="row">
	<div class="col-md-8">
		<h3 >出荷伝票（発注内容を入力して下さい）</h3>
	</div> 
	<div class="right">
		<a  href="<?php echo site_url('shipment');?>" class="print top-print">MENU画面へ </a>
	</div>
</div>
<form class="form-horizontal" role="form" id="add_form_shipment"  >
<div class="row first-row">
    <div class="row">
        <div class="col-sm-12 col-md-5 col-lg-4">
            <div class="form-group">
                <label for="inputEmail" class="col-md-4 control-label">出荷票No:</label>
                <div class="col-md-7">
                    <input class="hide-input" value="<?php echo $shipment_id;?>" disabled>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 col-lg-4 col-md-offset-2">
            <div class="form-group">
                <label for="inputPassword" class="col-md-4 control-label">得意先:</label>
                <div class="col-md-7">
                    <select class="form-control" name="shipment_customer" id="shipment_customer"><option></option></select>
                </div>
            </div>
        </div>
		<div class="clearfix"></div>
		 <div class="col-sm-12 col-md-5 col-lg-4">
            <div class="form-group">
                <label for="inputEmail" class="col-md-4 control-label">起票者:</label>
                <div class="col-md-7">
                    <input class="hide-input" value="<?php echo $user_name;?>" disabled>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 col-lg-4 col-md-offset-2">
            <div class="form-group">
                <label for="inputPassword" class="col-md-4 control-label">部署:</label>
                <div class="col-md-7">
                    <select class="form-control" name="shipment_department" id="shipment_department"><option><!--ルーム--></option></select>
                </div>
            </div>
        </div>
		<div class="clearfix"></div>
		 <div class="col-sm-12 col-md-5 col-lg-4">
            <div class="form-group">
                <label for="inputEmail" class="col-md-4 control-label">出荷依頼日:</label>
                <div class="col-md-7">
                    <span class="form-control form-control-input">
                        <input name="shipment_date" id="shipment_date" value="">
                        <span class="icon-large icon-calendar" ></span>
                    </span> 
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 col-lg-4 col-md-offset-2">
            <div class="form-group">
                <label for="inputPassword" class="col-md-4 control-label">商品セット名:</label>
                <div class="col-md-7">
                    <select class="form-control" name="shipment_set_product" id="shipment_set_product"><option><!--１：メインルーム--></option></select>
                </div>
            </div>
        </div>
		<div class="clearfix"></div>
       
        <div class="col-sm-12 col-md-5 col-lg-4">
            <div class="form-group">
                <label for="input7" class="col-md-4 control-label">納品予定日:</label>
                <div class="col-md-7">
                    <span class="form-control form-control-input">
                        <input name="delivery_date" id="delivery_date" value="">
                        <span class="icon-large icon-calendar"></span>
                    </span> 
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-2 col-lg-2" >
            <div class="form-group" style="width:135%;">
               
                <div class="col-md-10"> 
                    <select class="form-control" name="shipping_category" id="shipping_category" style="width:100%;">
                        <?php if($list_classification != null && $list_classification != '') { 
                            foreach ($list_classification as $key => $value) {
                                if($value[DC_ID] == DEFAULT_SHIPMENT_SHIP) {
                                    echo '<option selected value="'.$value[DC_ID].'" data-container="'.$value[DC_NUMBER_CONTAINER].'" data-truck="'.$value[DC_NUMBER_TRUCK].'" data-maxtruck="'.$value[DC_NUMBER_MAX_TRUCK].'" >'.$value[DC_NAME].'</option>';
                                } else {
                                    echo '<option value="'.$value[DC_ID].'" data-container="'.$value[DC_NUMBER_CONTAINER].'" data-truck="'.$value[DC_NUMBER_TRUCK].'" data-maxtruck="'.$value[DC_NUMBER_MAX_TRUCK].'" >'.$value[DC_NAME].'</option>';
                                }
                                
                            }
                        }?>
                    </select>
                </div>
            </div>
        </div>
		<div class="col-sm-12 col-md-5 col-lg-4 ">
            <div class="form-group">
                <label for="input8" class="col-md-4 control-label">マイワンタッチ:</label>
                <div class="col-md-7">
                    <select class="form-control" name="my_one_touch" id="my_one_touch"><option></option></select>
                </div>
            </div>
        </div>
        <div class="clearfix visible-lg-block visible-md-block"></div>
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="form-group text-area">
                <label for="input9" class="col-md-2 control-label ">備考:</label>
                <div class="col-md-8" >
    			  <textarea style="margin-left:2px;" name="shipment_note" id="shipment_note" ></textarea>
    			</div>
            </div>     
        </div>
		
		<div class="col-sm-12 col-md-2 col-lg-2 ">
            <a class="print right" id="btn_one_touch" style="margin-right:52px;">ワンタッチ</a>
        </div>
	
    </div>
</div>

<div class="row third-row">	
    <table class="no-order-table edit-table" id="add-shipment-table">
    <thead>
        <tr>
            <th style="width:10%;">得意先</th>
            <th style="width:14%;">部署</th>
            <th style="width:10%;">商品コード</th>
            <th style="width:14%;">商品名</th>
            <th style="width:8%;">規格</th>
            <th style="width:6%;">カラー</th>
			<th style="width:6%;">発注数</th>
			<th style="width:6%;">変更数</th>
			<th style="width:6%;">出荷数</th>
            <th style="width:6%;">コンテナ</th>   
            <th style="width:6%;">コンテナ</th>
            <th style="width:8%;">コメント</th>  
        </tr>
    </thead>
    <tbody> 

        <tr>
            <td><select class="span2 selectpicker select_customer" name="select_customer" data-live-search="true" title="" data-live-search-placeholder="Search">
                <option value=""></option>
                <?php /*if($list_customer_shipment != null && $list_customer_shipment != '') { 
                            foreach ($list_customer_shipment as $key => $value) {
                                echo '<option value="'.$value[CSHIPMENT_ID].'" >'.$value[CSHIPMENT_NAME].'</option>';
                            }
                        }*/?>
            </select><input type="hidden" class="shipment_product_weight" value="" /></td>
            <td><select class="span2 selectpicker select_department" name="select_department" data-live-search="true" title="" data-live-search-placeholder="Search">
                <option value=""></option>
            </select></td>
            <td>
                <input class="form-control select_product_code" value="" />
            </td>
            <td><span class="shipment_product_name"></span></td>
            <td><span class="shipment_product_style"></span></td>
			<td><span class="shipment_product_color"></span></td>
            <td>
                <input type="hidden" class="shipment_product_value_unit" value="" />
                <input type="text" class="product_quantity_order" name="product_quantity_order" value="0"/>
            </td>
            <td><span class="product_quantity_change"><input type="hidden" class="shipment_product_quantity_change" value="0" /></span></td>
            <td><span class="product_quantity_delivery"></span></td>
            <td><input class="product_container_1" name="product_container_1" value="0"/></td>
			<td><input class="product_container_2" name="product_container_2" value="0"/></td>
			<td><input class="product_comment" value=""/></td>
        </tr>
        
    </tbody>
</table>          
</div>
 <div class="row">
    <div class="right" >
		<a class="print" id="insert-shipment-row">行挿入 </a>
		<a class="print" id="remove-shipment-row">行削除 </a>
    </div>
</div> 
<div class="row third-row no-top-margin">						
<table  class="empty-table shipment-container">
    <tbody>
		<tr>
			<td colspan="2">コンテナ台数内訳</td>
			<td class="first-col" id="keyContainer1"></td>
			<td id="valueContainer1"></td>
			<td id="keyContainer2"></td>
			<td id="valueContainer2"></td> 
			<td id="keyContainer3"></td>
			<td id="valueContainer3"></td>
		</tr>
    	<tr>
			<td>合計</td>
			<td><input class="span1" id="shipmentTotal" disabled /></td>
			<td id="keyContainer4"></td>
            <td id="valueContainer4"></td>
            <td id="keyContainer5"></td>
            <td id="valueContainer5"></td>
            <td id="keyContainer6"></td>
            <td id="valueContainer6"></td>
		</tr>
        <tr>
			<td>重量</td>
			<td><input class="span1" id="shipmentWeight" disabled /></td>
			<td id="keyContainer7"></td>
            <td id="valueContainer7"></td>
            <td id="keyContainer8"></td>
            <td id="valueContainer8"></td>
            <td id="keyContainer9"></td>
            <td id="valueContainer9"></td>
		</tr>
		<tr>
    		<td>トラック</td> 
			<td><input class="span1" id="shipmentTruck_Main" disabled /></td>
			<td id="keyContainer10"></td>
            <td id="valueContainer10"></td>
            <td id="keyContainer11"></td>
            <td id="valueContainer11"></td>
            <td id="keyContainer12"></td>
            <td id="valueContainer12"></td>
		</tr>
		<tr>
    		<td>臨車</td>
    		<td><input class="span1" id="shipmentTruck_Aid" disabled/></td>
    		<td id="keyContainer13"></td>
            <td id="valueContainer13"></td>
            <td id="keyContainer14"></td>
            <td id="valueContainer14"></td>
            <td id="keyContainer15"></td>
            <td id="valueContainer15"></td>
		</tr>
    </tbody>
</table>	
</div>		
<div class="row first-row">
    <div class="right">
		<a class="print print-auto" id="autoUpdateContainerShipment">コンテナ台数反映 </a>
    </div>	   
</div>
<div class="row first-row">
    <div class="right">
		<a class="print" id="save_temp_shipment">一時保存 </a>
		<a class="print request-export" id="save_order_shipment">発注確定</a>
    </div>	   
</div>
</form>
</div>
<input type="hidden" id="PL_PRODUCT_ID" value="<?php echo PL_PRODUCT_ID;?>">
<input type="hidden" id="PL_PRODUCT_NAME" value="<?php echo PL_PRODUCT_NAME;?>">
<input type="hidden" id="CUS_ID" value="<?php echo CUS_ID;?>">
<input type="hidden" id="CUS_CUSTOMER_NAME" value="<?php echo CUS_CUSTOMER_NAME;?>">
<input type="hidden" id="DL_DEPARTMENT_CODE" value="<?php echo DL_DEPARTMENT_CODE;?>">
<input type="hidden" id="DL_DEPARTMENT_NAME" value="<?php echo DL_DEPARTMENT_NAME;?>">
<style type="text/css" media="screen">
.dropdown-menu{
    background-color: #ffffff;
    z-index:99999;
}
.form-group button {
    background: #fff;
    border-radius: 2px;
    margin: 0;
}
.bootstrap-select button{
    height: 30px;
}
.order .edit-table input {
    text-align: left;
}
.select_customer {
    width: 100% !important;
}
.select_department {
    width: 100% !important;
}
.select_product_code {
    width: 100% !important;
}
button.btn {
    margin: 0;
}
.shipment table.shipment-container tr td {
    text-align: center;
}
.detail-pulldown-table { 
    min-width: 250px;
}
</style> 
<script> 
var get_product_selectbox = "<?= base_url("product/get_product_selectbox") ?>";
var urlShipmentIndex = "<?= base_url("shipment") ?>";
var getCustomerByClassification = "<?= base_url("shipment/get-customer-by-classification") ?>";
var getDepartmentByCustomer = "<?= base_url("shipment/get-department") ?>";
var getSetProduct = "<?= base_url("shipment/get-set-product") ?>";
var getMyOneTouch = "<?= base_url("shipment/get-my-one-touch") ?>"; 
var getDetailSetAndOntouch = "<?= base_url("shipment/get-detail-set-one-touch") ?>";
var getDetailProduct = "<?= base_url("shipment/get-detail-product") ?>";
var getContainerShipment = "<?= base_url("shipment/get-container-shipment") ?>";
var addShipmentPost = "<?= base_url("shipment/add-shipment-post") ?>";
var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
var message_not_select_set_error = "<?= $this->lang->line('message_not_select_set_error')?>";
var message_not_select_row = "<?= $this->lang->line('message_not_select_row')?>";
var message_shipment_error_product_setproduct = "<?= $this->lang->line('message_shipment_error_product_setproduct')?>";
var message_error_multiples_product = "<?= $this->lang->line('message_error_multiples_product')?>";
var message_add_detail_change_shipping = "<?= $this->lang->line('message_add_detail_change_shipping')?>";
var DEFAULT_SHIPMENT_SHIP = "<?= DEFAULT_SHIPMENT_SHIP;?>";
</script>
