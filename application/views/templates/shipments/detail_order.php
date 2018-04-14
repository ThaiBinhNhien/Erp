<?php 
$varContainer = "container";
$varNum = "num";
?>
<div class="wrapper-contain shipment order">
<div class="row">
       <div class="col-md-6 col-sm-6">
         <h3>発注伝票/出荷伝票</h3>  
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
           <td><?php echo $master[OS_DELIVERY_DATE];?>　<?php echo $master['delivery_classifition'];?></td>
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
	<div class="button-right-side">
		<a href="<?php echo site_url('shipment');?>" class="print right">MENU画面へ </a>
		<a href="<?php echo site_url('shipment/bill-shipment?id='.$order_id.''); ?>" class="print right top-print" target="_blank">印刷 </a>
    	<a id="btnExportCsv" class="print right top-print">CSV出力</a>
	</div>
</div>
<div class="row margin-bottom-table">
	  <a href="<?php echo site_url('shipment/detail_order_confirm?id='.$order_id.''); ?>" class="print right">確定画面へ</a>
</div>
<div class="row sec-row">
<table  class="no-input-table">
    <thead>
        <tr>
            <th>得意先</th>
            <th>部署</th>
            <th>商品コード</th>
            <th>商品名</th>
            <th>規格</th>
            <th>カラー</th>
            <th>発注数</th>
            <th>変更数</th>
            <th>出荷数</th>
            <th>コンテナ</th>
            <th>コンテナ</th>
            <th>コメント</th>    
        </tr>
    </thead>
    <tbody>
        <?php if($detail != null && $detail != '') { ?>
        <?php foreach ($detail as $key => $value) { ?>
        <tr>
            <td><?php echo $value['customer_name'];?></td>
            <td><?php echo $value['department_name'];?></td>
            <td><?php echo $value['product_code'];?></td>
            <td title="<?php echo $value['product_container'];?>"><?php echo $value['product_name'];?></td>
            <td><?php echo $value['product_format'];?></td>
            <td><?php echo $value['product_color'];?></td>
            <td><?php echo $value[OSHD_QUANTITY];?></td> 
            <td><?php echo $value[OSHD_QUANTITY_CHANGE];?></td>
            <td><?php echo $value[OSHD_DELIVERY];?></td>
            <td class="box_container"><?php echo $value[OSHD_CONTAINER1];?></td>
            <td class="box_container"><?php echo $value[OSHD_CONTAINER2];?></td>
            <td><?php echo $value[OSHD_COMMENT];?></td>
        </tr>
        <?php } ?>
        <?php } ?>
    </tbody>
</table> 
</div>                              

<div class="row display sec-row">		
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
<?php } ?>
</div>	                                   
<div class="row first-row">
 <div class="right">
	<a href="<?php echo site_url('shipment/report-shipment?id='.$order_id.''); ?>" target="_blank" class="print print-auto">発注状況レポート</a>
	<a href="<?php echo site_url('shipment/report-shipment-customer?id='.$order_id.''); ?>" target="_blank" class="print print-auto">発注状況レポート（得意先別)</a>
</div>	   
</div>
<div class="row">
    <div class="right margin-bottom-table">
        <form action="<?php echo site_url('shipment/report-set-container'); ?>" target="_blank" method="GET" role="form" id="form-set-container">
            <span class="button-container">コンテナNo<input type="text" name="set" id="input-set-container" class="no-bottom-margin">
            <input type="hidden" name="id" value="<?php echo $order_id;?>">
            <button type="button" class="print print-auto" id="print-set-container">コンテナ用紙セット</button>
        </form>
    </div>
</div>
</div>    
<style>             
.shipment .table-center tr td {
    text-align: center;
}
</style>                 
<script>                               
    var message_not_no_container = "<?= $this->lang->line('message_not_no_container')?>";
    var message_not_exits_container = "<?= $this->lang->line('message_not_exits_container')?>";
    var id_export_detail = "<?= $this->input->get('id'); ?>";
    var urlExportCsvDetail = "<?= base_url("shipment/detail_order") ?>";
</script>                    
 
 

