<?php 
$varContainer = "container";
$varNum = "num";
?>
<div class="wrapper-contain shipment order">
<div class="row"> 
       <div class="col-md-10 col-sm-10">
       <h3>出荷伝票（内容を確認して「出荷確定」ボタンにて出荷確定して下さい）</h3>     
		<div class="row">
		<div class="col-md-8 no-left-pad"> 	
            <?php if($master != null && $master != '') {?>
        <table class="table_1 detail-table">
        <tr>
           <td>出荷票No:</td>
           <td><?php echo $master[OS_ID];?></td>
        </tr>
        <tr>
            <td>起票者:</td>
            <td><?php echo $master[OS_ORDERER];?></td>
        </tr>
        <tr>
           <td>出荷依頼日:</td>
           <td><?php echo $master[OS_ORDER_DATE];?></td>
        </tr>
        <tr>
           <td>納品予定日:</td>
           <td><?php echo $master[OS_DELIVERY_DATE];?>　<?php echo $master['delivery_classifition'];?>
            <input type="hidden" id="shipmentContInTruck" value="<?php echo $master['number_container']; ?>" />
            <input type="hidden" id="shipmentWeightInTruck" value="<?php echo $master['number_max_truck']; ?>" />
            <input type="hidden" id="shipmentTruck" value="<?php echo $master['number_truck']; ?>" />
        </td>
        </tr>
        <tr>
            <td>備考:</td>
            <td><?php echo $master[OS_NOTE];?></td>
        </tr>
        <tr>
           <td>形態:</td>
           <td>
            <?php 
            if($master[OS_STATUS] != '') {
                if((int)$master[OS_STATUS] == 1) {
                    echo '<span>一時保存</span>';
                }
                else if((int)$master[OS_STATUS] == 2) {
                    echo '<span>出荷未確定</span>';
                }
                else if((int)$master[OS_STATUS] == 3) {
                    echo '<span>再依頼</span>';
                }
                else if((int)$master[OS_STATUS] == 4) {
                    echo '<span>出荷確定(不足)</span>';
                }
                else if((int)$master[OS_STATUS] == 5) {
                    echo '<span>出荷確定</span>';
                }
            }
           ?></td>
        </tr>
        </table>
        <?php } ?>
		</div>
    	</div>
    </div>
	<div class="right">
		<a  href="<?php echo site_url('shipment');?>" class="print top-print">MENU画面へ </a>
	</div>
</div>
<div class="row sec-row">
<form class="form-horizontal" role="form" id="edit_form_shipment" >    
<table  class="no-input-table edit-table" id="edit_shipment_confirm">
    <thead>
        <tr>
            <th style="width:11%;">得意先</th>
            <th style="width:8%;">部署</th>
            <th style="width:12%;">商品コード</th>
            <th style="width:14%;">商品名</th>
            <th style="width:8%;">規格</th>
            <th style="width:8%;">カラー</th> 
            <th style="width:6%;">発注数</th>
            <th style="width:6%;">変更数</th>
            <th style="width:6%">出荷数<br/><!--<button id="ship-copy">コピー</button>--><a href="#" id="ship-copy">コピー</a></th>
            <th style="width:7%">コンテナ</th>
            <th style="width:7%">コンテナ</th>
            <th style="width:7%">コメント</th>    
        </tr>
    </thead>
    <tbody>
        <?php if($detail != null && $detail != '') { ?>
        <?php foreach ($detail as $key => $value) { ?>
        <tr>  
            <td><input type="hidden" class="shipment_product_weight" value="<?php echo $value['product_weight']; ?>" /><input type="hidden" class="product_customer" value="<?php echo $value[OSHD_CUSTOMER_ID];?>" /><input type="hidden" class="product_customer_name" value="<?php echo $value['customer_name'];?>" /><?php echo $value['customer_name'];?></td>
            <td><input type="hidden" class="product_derpartment" value="<?php echo $value[OSHD_DEPARTMENT_ID];?>" /><input type="hidden" class="product_derpartment_name" value="<?php echo $value['department_name'];?>" /><?php echo $value['department_name'];?></td>
            <td><input type="hidden" class="product_code" value="<?php echo $value[OSHD_PRODUCT_CODE];?>" /><?php echo $value[OSHD_PRODUCT_CODE];?></td>
            <td title="<?php echo $value['product_container'];?>"><?php echo $value['product_name'];?></td>
            <td><?php echo $value['product_format'];?></td>
            <td><?php echo $value['product_color'];?></td>
            <td class="copy"><?php echo $value[OSHD_QUANTITY];?></td>
            <td><input type="hidden" class="product_quantity_order" value="<?php echo $value[OSHD_QUANTITY];?>" /><input type="hidden" class="product_quantity_change" value="<?php echo $value[OSHD_QUANTITY_CHANGE];?>" /><?php echo $value[OSHD_QUANTITY_CHANGE];?></td>
            <td><input class="product_quantity_delivery" value="<?php echo $value[OSHD_DELIVERY];?>"/></td>
            <td><input class="product_quantity_container1" value="<?php echo $value[OSHD_CONTAINER1];?>"/></td>
            <td><input class="product_quantity_container2" value="<?php echo $value[OSHD_CONTAINER2];?>"/></td>
            <td><input class="product_shipment_comment" type="text" value="<?php echo $value[OSHD_COMMENT];?>" /></td>
        </tr>
        <?php } ?>
        <?php } ?>
    </tbody>
</table> 
</form>
</div>                              
<div class="row top-15">
	<a class="print right print-auto" id="shipment_update_container" >コンテナ台数更新</a>
</div>
<div class="row sec-row">						
<?php if($master != null && $master != '') { ?>             
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
            <td><input class="span1" id="shipmentWeight" data-weight="<?php echo $master[OS_GROSS_WEIGHT_SHIPPING];?>" value="<?php echo $master[OS_GROSS_WEIGHT_SHIPPING];?> kg" disabled /></td>
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
<?php } ?>
</div>	                                   
<div class="row margin-top-table">
	<a class="print export right" id="shipmentConfirmRequest">出荷確定</a>
</div>
<div class="row first-row">
	<a href="<?php echo site_url('shipment/detail_shipment?id='.$order_id.'');?>" class="print right">戻る </a>
	</div>
</div>     
<style>             
.shipment .table-center tr td {
    text-align: center;
}
</style>             
<script>
var order_id = "<?= $order_id;?>";
var urlShipmentIndex = "<?= base_url("shipment") ?>";
var getContainerShipment = "<?= base_url("shipment/get-container-shipment") ?>";
var urlShipmentConfirm = "<?= base_url("shipment/detail_order_confirm_post") ?>";
var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
var titleAjax = "<?= $this->lang->line('message_fix_number_shipment')?>";
var date_update = "<?php echo $master['date_update'];?>";
</script>      
