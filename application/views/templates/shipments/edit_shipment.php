<?php 
$varContainer = "container";
$varNum = "num";
?>
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
<?php if($master != null && $master != '') {?> 
<div class="row first-row">
    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label for="inputEmail" class="col-md-4 control-label">出荷票No:</label>
                <div class="col-md-8">
                    <input class="hide-input" value="<?php echo $master[OS_ID];?>" disabled>
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
         <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label for="inputEmail" class="col-md-4 control-label">起票者:</label>
                <div class="col-md-8">
                    <input class="hide-input" value="<?php echo $master[OS_ORDERER];?>" disabled>
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
         <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label for="inputEmail" class="col-md-4 control-label">出荷依頼日:</label>
                <div class="col-md-8">
                    <span class="form-control form-control-input">
                        <input class="" name="shipment_date" id="shipment_date" value="">
                        <span class="icon-large icon-calendar" ></span>
                    </span> 
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
       
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label for="input7" class="col-md-4 control-label">納品予定日:</label>
                <div class="col-md-8">
                    <span class="form-control form-control-input">
                        <input class="" name="delivery_date" id="delivery_date" value="">
                        <span class="icon-large icon-calendar"></span>
                    </span> 
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
               <label for="inputPassword" class="col-md-4 control-label">配送便区分:</label>
                <div class="col-md-8"> 
                    <select class="form-control" name="shipping_category" id="shipping_category" style="width:100%;">
                        <?php if($list_classification != null && $list_classification != '') { 
                            foreach ($list_classification as $key => $value) {
                                $selected = '';
                                if($value[DC_ID] == $master[OS_DELIVERY_CLASSIFICATION]) {
                                    $selected = 'selected';
                                }
                                echo '<option value="'.$value[DC_ID].'" data-container="'.$value[DC_NUMBER_CONTAINER].'" data-truck="'.$value[DC_NUMBER_TRUCK].'" data-maxtruck="'.$value[DC_NUMBER_MAX_TRUCK].'" '.$selected.'>'.$value[DC_NAME].'</option>';
                            }
                        }?>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="clearfix visible-lg-block visible-md-block"></div>
        <div class="col-sm-12 col-md-8">
            <div class="form-group text-area">
                <label for="input9" class="col-md-2 control-label ">備考:</label>
                <div class="col-md-8" >
                  <textarea style="margin-left:2px;" name="shipment_note" id="shipment_note" ><?php echo $master[OS_NOTE];?></textarea>
                </div>
            </div>     
        </div>
        
    </div>
</div>
<?php } ?>
<div class="row margin-bottom-table">
        
</div>
<?php if($master != null && $master != '') {?> 
<div class="row third-row"> 
    <table class="no-order-table edit-table" id="add-shipment-table">
    <thead>
        <tr>
        <th style="width:5%;">得意先</th>
        <th style="width:5%;">部署</th>
        <th style="width:12%;">商品コード</th>
        <th style="width:14%;">商品名</th>
        <th style="width:8%;">規格</th>
        <th style="width:8%;">カラー</th>
        <th style="width:8%;">発注数</th>
        <th style="width:8%;">変更数</th>
        <th style="width:8%;">出荷数</th>
        <th style="width:8%;">コンテナ</th>   
        <th style="width:8%;">コンテナ</th>
        <th style="width:8%;">コメント</th> 
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <select class="span2 selectpicker select_customer" name="select_customer" data-live-search="true" title="" data-live-search-placeholder="Search">
                    <option value=""></option>
                </select>
                <input type="hidden" class="shipment_product_weight" value="" />
            </td>
            <td>
                <select class="span2 selectpicker select_department" name="select_department" data-live-search="true" title="" data-live-search-placeholder="Search">
                    <option value=""></option>
                </select>
            </td>
             <td>
              <!-- <div class="box-pulldown-table">
                <span class="input-triangle"><b></b></span>
                <input class="value_pulldown_id select_product_code" name="value_pulldown_id"/>
                <table class="detail-pulldown-table">
                    <thead>
                    </thead>
                </table>
              </div> -->
              <input class="form-control select_product_code" value="<?php if($product_default != null && count($product_default) > 0) { echo $product_default[0][PL_PRODUCT_CODE_SALE];} ?>" />
            </td>
            <td><span class="shipment_product_name"></span></td>
            <td><span class="shipment_product_style"></span></td>
            <td><span class="shipment_product_color"></span></td>
            <td><input type="hidden" class="shipment_product_value_unit" value="" /><input type="text" class="product_quantity_order" name="product_quantity_order" value="0"/></td>
            <td><span class="product_quantity_change"><input type="hidden" class="shipment_product_quantity_change" name="shipment_product_quantity_change" value="0" /></span></td>
            <td><input class="product_quantity_delivery" name="product_quantity_delivery" type="hidden" value=""/><span class="product_quantity_delivery"></span></td>
            <td><input class="product_container_1" name="product_container_1" value="0"/></td>
            <td><input class="product_container_2" name="product_container_2" value="0"/></td>
            <td><input class="product_comment" value=""/></td>
        </tr>

        <?php if($detail != '' && $detail != null) { ?>
        <?php foreach ($detail as $key => $value) { ?>
        <tr>
            <td>
                <select data-previous="<?= $value[OSHD_CUSTOMER_ID] ?>" class="span2 selectpicker select_customer" name="select_customer" data-live-search="true" title="" data-live-search-placeholder="Search">
                    <?php foreach ($list_customer as $keycustomer => $valuecustomer) { 
                        $selectCustomer = '';
                        if($value[OSHD_CUSTOMER_ID] == $valuecustomer['customer_id']) {
                            $selectCustomer = 'selected';
                        }
                        echo '<option value="'.$valuecustomer['customer_id'].'" '.$selectCustomer.'>'.$valuecustomer['customer_shipment_name'].'</option>';
                    } ?>
                </select>
                <input type="hidden" class="shipment_product_weight" value="<?php echo $value['product_weight']; ?>" />
            </td>
            <td>
                <select class="span2 selectpicker select_department" name="select_department" data-live-search="true" title="" data-live-search-placeholder="Search">
                    <option value=""></option>
                </select>
                <input type="hidden" class="product_derpartment" value="<?php echo $value[OSHD_DEPARTMENT_ID];?>" />
            </td>
            <td>
              <!-- <div class="box-pulldown-table">
                <span class="input-triangle"><b></b></span>
                <input class="value_pulldown_id select_product_code" name="value_pulldown_id" value="<?php //echo $value[OSHD_PRODUCT_CODE];?>"/>
                <table class="detail-pulldown-table">
                    <thead>
                    </thead>
                </table> 
              </div> -->
              <input class="form-control select_product_code" value="<?php echo (empty($value['product_code']) && empty($value['product_name']) && empty($value['product_format']) && empty($value['product_color']))?"":$value[OSHD_PRODUCT_CODE];?>" />
            </td>

            <td class="shipment_product_name" title="<?php echo $value['product_container'];?>"><?php echo $value['product_name'];?></td>
            <td class="shipment_product_style"><?php echo $value['product_format'];?></td>
            <td class="shipment_product_color"><?php echo $value['product_color'];?></td>
            <td>
                <input type="hidden" class="shipment_product_value_unit" value="<?php echo $value['product_value_unit'];?>" />
                <input type="number" class="product_quantity_order" name="product_quantity_order" value="<?php echo $value[OSHD_QUANTITY];?>" />
            </td>
            <td><input type="number" class="shipment_product_quantity_change" name="shipment_product_quantity_change" value="<?php echo $value[OSHD_QUANTITY_CHANGE];?>" /></td>
            <td><input class="product_quantity_delivery" name="product_quantity_delivery" type="hidden" value="<?php echo $value[OSHD_DELIVERY];?>"/><?php echo $value[OSHD_DELIVERY];?></td>
            <td><input type="number" class="product_container_1" name="product_container_1" value="<?php echo $value[OSHD_CONTAINER1];?>"/></td>
            <td><input type="number" class="product_container_2" name="product_container_2" value="<?php echo $value[OSHD_CONTAINER2];?>"/></td>
            <td><input class="product_comment" name="product_comment" value="<?php echo $value[OSHD_COMMENT];?>"/></td>
        </tr>
        <?php } ?>
        <?php } ?>
        
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
<table  class="empty-table table-center">
    <tbody> 
        <tr>
            <td colspan="2">コンテナ台数内訳</td>
            <td class="first-col" id="keyContainer1"><?php echo ($listCountContainer != null && isset($listCountContainer[0])) ? $listCountContainer[0][$varContainer] : ''; ?></td>
            <td id="valueContainer1"><?php echo ($listCountContainer != null && isset($listCountContainer[0])) ? $listCountContainer[0][$varNum] : ''; ?></td>
            <td id="keyContainer2"><?php echo ($listCountContainer != null && isset($listCountContainer[1])) ? $listCountContainer[1][$varContainer] : ''; ?></td>
            <td id="valueContainer2"><?php echo ($listCountContainer != null && isset($listCountContainer[1])) ? $listCountContainer[1][$varNum] : ''; ?></td>
            <td id="keyContainer3"><?php echo ($listCountContainer != null && isset($listCountContainer[2])) ? $listCountContainer[2][$varContainer] : ''; ?></td>
            <td id="valueContainer3"><?php echo ($listCountContainer != null && isset($listCountContainer[2])) ? $listCountContainer[2][$varNum] : ''; ?></td>
        </tr>
        <tr>
            <td>合計</td>
            <td><input class="span1" id="shipmentTotal" value="<?php echo $master[OS_TOTAL_NUMBER_CONTAINERS];?>" disabled /></td>
            <td id="keyContainer4"><?php echo ($listCountContainer != null && isset($listCountContainer[3])) ? $listCountContainer[3][$varContainer] : ''; ?></td>
            <td id="valueContainer4"><?php echo ($listCountContainer != null && isset($listCountContainer[3])) ? $listCountContainer[3][$varNum] : ''; ?></td>
            <td id="keyContainer5"><?php echo ($listCountContainer != null && isset($listCountContainer[4])) ? $listCountContainer[4][$varContainer] : ''; ?></td>
            <td id="valueContainer5"><?php echo ($listCountContainer != null && isset($listCountContainer[4])) ? $listCountContainer[4][$varNum] : ''; ?></td>
            <td id="keyContainer6"><?php echo ($listCountContainer != null && isset($listCountContainer[5])) ? $listCountContainer[5][$varContainer] : ''; ?></td>
            <td id="valueContainer6"><?php echo ($listCountContainer != null && isset($listCountContainer[5])) ? $listCountContainer[5][$varNum] : ''; ?></td>
        </tr>
        <tr>
            <td>重量</td>
            <td><input class="span1" id="shipmentWeight" value="<?php echo $master[OS_GROSS_WEIGHT];?> kg" disabled /></td>
            <td id="keyContainer7"><?php echo ($listCountContainer != null && isset($listCountContainer[6])) ? $listCountContainer[6][$varContainer] : ''; ?></td>
            <td id="valueContainer7"><?php echo ($listCountContainer != null && isset($listCountContainer[6])) ? $listCountContainer[6][$varNum] : ''; ?></td>
            <td id="keyContainer8"><?php echo ($listCountContainer != null && isset($listCountContainer[7])) ? $listCountContainer[7][$varContainer] : ''; ?></td>
            <td id="valueContainer8"><?php echo ($listCountContainer != null && isset($listCountContainer[7])) ? $listCountContainer[7][$varNum] : ''; ?></td>
            <td id="keyContainer9"><?php echo ($listCountContainer != null && isset($listCountContainer[8])) ? $listCountContainer[8][$varContainer] : ''; ?></td>
            <td id="valueContainer9"><?php echo ($listCountContainer != null && isset($listCountContainer[8])) ? $listCountContainer[8][$varNum] : ''; ?></td>
        </tr>
        <tr>
            <td>トラック</td>
            <td><input class="span1" id="shipmentTruck_Main" value="<?php echo $master[OS_NUMBER_TRUCKS];?>" disabled /></td>
            <td id="keyContainer10"><?php echo ($listCountContainer != null && isset($listCountContainer[9])) ? $listCountContainer[9][$varContainer] : ''; ?></td>
            <td id="valueContainer10"><?php echo ($listCountContainer != null && isset($listCountContainer[9])) ? $listCountContainer[9][$varNum] : ''; ?></td>
            <td id="keyContainer11"><?php echo ($listCountContainer != null && isset($listCountContainer[10])) ? $listCountContainer[10][$varContainer] : ''; ?></td>
            <td id="valueContainer11"><?php echo ($listCountContainer != null && isset($listCountContainer[10])) ? $listCountContainer[10][$varNum] : ''; ?></td>
            <td id="keyContainer12"><?php echo ($listCountContainer != null && isset($listCountContainer[11])) ? $listCountContainer[11][$varContainer] : ''; ?></td>
            <td id="valueContainer12"><?php echo ($listCountContainer != null && isset($listCountContainer[11])) ? $listCountContainer[11][$varNum] : ''; ?></td>
        </tr>
        <tr>
            <td>臨車</td>
            <td><input class="span1" id="shipmentTruck_Aid" value="<?php echo $master[OS_NUMBER_TRAIN];?>" disabled/></td>
            <td id="keyContainer13"><?php echo ($listCountContainer != null && isset($listCountContainer[12])) ? $listCountContainer[12][$varContainer] : ''; ?></td>
            <td id="valueContainer13"><?php echo ($listCountContainer != null && isset($listCountContainer[12])) ? $listCountContainer[12][$varNum] : ''; ?></td>
            <td id="keyContainer14"><?php echo ($listCountContainer != null && isset($listCountContainer[13])) ? $listCountContainer[13][$varContainer] : ''; ?></td>
            <td id="valueContainer14"><?php echo ($listCountContainer != null && isset($listCountContainer[13])) ? $listCountContainer[13][$varNum] : ''; ?></td>
            <td id="keyContainer15"><?php echo ($listCountContainer != null && isset($listCountContainer[14])) ? $listCountContainer[14][$varContainer] : ''; ?></td>
            <td id="valueContainer15"><?php echo ($listCountContainer != null && isset($listCountContainer[14])) ? $listCountContainer[14][$varNum] : ''; ?></td>
        </tr>

        <?php 
        if($listCountContainer != null && count($listCountContainer) > 15) {
            $iBegin = 15;
            $countList = ceil(( count($listCountContainer) - $iBegin ) / 3);
            for ($i=0; $i < $countList; $i++) { 
                $jBegin = $iBegin + 3 * $i;
                $jEnd = $jBegin + 3; 
        ?>
            <tr>
                <td></td>
                <td></td>
                <?php 
                for ($j=$jBegin; $j < $jEnd; $j++) { 
                ?>
                <td id="valueContainer<?php echo $j;?>"><?php echo ($listCountContainer != null && isset($listCountContainer[$j])) ? $listCountContainer[$j][$varContainer] : ''; ?></td>
                <td id="valueContainer<?php echo $j;?>"><?php echo ($listCountContainer != null && isset($listCountContainer[$j])) ? $listCountContainer[$j][$varNum] : ''; ?></td>
                <?php } ?>
            </tr>
        <?php 
        } }
        ?>
    </tbody>
</table>    
</div>      
<?php } ?>
<div class="row first-row">
    <div class="right">
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
    width: 120px !important;
}
.select_department {
    width: 120px !important;
}
.select_product_code {
    width: 120px !important;
}
button.btn {
    margin: 0;
}
tr.del-row, tr.del-row button, tr.del-row input {
    /*background-color: #0099ba;*/
}
.form-control {
    margin-bottom: 9px;
}
.shipment .table-center tr td {
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
var getDetailProduct = "<?= base_url("shipment/get-detail-product") ?>";
var getContainerShipment = "<?= base_url("shipment/get-container-shipment") ?>";
var editShipmentPost = "<?= base_url("shipment/edit-shipment-post") ?>";
var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
var message_title_add_shipment = "<?= $this->lang->line('message_title_add_shipment')?>";
var message_not_select_row = "<?= $this->lang->line('message_not_select_row')?>";
var order_id = "<?php echo $order_id;?>";
var date_update = "<?php echo $master['date_update'];?>";
var message_error_multiples_product = "<?= $this->lang->line('message_error_multiples_product')?>";
var message_add_detail_change_shipping = "<?= $this->lang->line('message_add_detail_change_shipping')?>";
var value_shipment_date = '<?php echo ($master[OS_SHIPMENT_DECISION_DATETIME] != null && $master[OS_SHIPMENT_DECISION_DATETIME] != "") ? date_format(date_create($master[OS_SHIPMENT_DECISION_DATETIME]),"Y/m/d") : "";?>';
var value_delivery_date = '<?php echo ($master[OS_DELIVERY_DATE] != null && $master[OS_DELIVERY_DATE] != "") ? date_format(date_create($master[OS_DELIVERY_DATE]),"Y/m/d") : "";?>';
var status_shipment = "<?= $master[OS_STATUS];?>";
</script>
