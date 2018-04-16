<style>
.no-input-table th {
    padding: 10px 5px;
}
</style>
<?php
$sum_checklist = 0;
$count_checklist = 0;
?>
<div class="wrapper-contain purchase order detail-order-2">
    <div class="row">
	<div class="col-md-6 col-sm-6">
			<h3>発注伝票 </h3> 
            <div class="first-row">
                <table class="detail-table">
                    <tr>
                        <td>注文No:</td>
                        <td><?= $master[SL_ID] ?></td>
                    </tr>
                    <tr>
                        <td>起票者:</td>
                        <td><?= $master['user_name'] ?></td>
                    </tr>
                    <tr>
                        <td>注文日:</td>
                        <td><?= $master['orderdate_print'] ?>)</td>
                    </tr>
                    <tr>
                        <td>得意先名:</td>
                        <td> <?= $master['customer_name'] ?></td>
                        <td>部署:</td>
                        <td><?= $master['department'] ?></td>
                    </tr>
                    <tr>
                        <td>納品予定日:</td>
                        <td><?= $master['deliveryexpected_date_print'] ?></td>
                    </tr>
                    <tr>
                        <td>売上（納品）日:</td>
                        <td><?= $master['deliverydate_print'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
       <div class="button-right-side">
		<a  href="<?php echo site_url('receive-order'); ?>" class="print right">MENU画面へ</a>
        <a  href="javascript:forprint()" class="print right top-print" >印刷 </a>
        <?php if($master['delivery_date'] != '' && $master['delivery_date'] != null) { ?>
		    <a  href="<?= base_url('order/pdf-delivery?id='.$master[SL_ID]) ?>" class="print right top-print" >納品書出力</a>
        <?php } else { ?>
            <a class="print print-hide right top-print" >納品書出力</a>
        <?php } ?>
        <?php if($master['delivery_date'] != '' && $master['delivery_date'] != null && (int)$flg_copy > 0) { ?>
            <?php if($master['flg_copy'] > 0) { ?>
                <a class="print print-hide right top-print">受発注取り込み</a>
            <?php } else { ?>
            <a class="print right top-print print-copy-shipment" id="copyToShipment">受発注取り込み</a>
            <?php  } } else { ?>
                <a class="print print-hide right top-print">受発注取り込み</a>
            <?php } ?>

    </div>
    </div>
    <div class="row">
        <ul class="nav nav-tabs">
            <?php
                $getTab = $this->input->get("tab"); 
                $setTab1 = "active";
                $setTab2 = "";
                if($getTab == 2) {
                    $setTab1 = "";
                    $setTab2 = "active";
                }
                ?>
            <li class="<?php echo $setTab1; ?>"><a data-toggle="tab" href="#home">注文伝票</a></li>
            <?php if($master["status"] != "2") { ?>
            <li class="<?php echo $setTab2; ?>"><a data-toggle="tab" href="#menu1">納品・売上処理</a></li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <?php
                $getTab = $this->input->get("tab"); 
                $setTab1 = "in active";
                $setTab2 = "";
                if($getTab == 2) {
                    $setTab1 = "";
                    $setTab2 = "in active";
                }
                ?>
            <div id="home" class="tab-pane fade <?php echo $setTab1; ?>">
                <div class="row sec-row">
                    <?php if($master[SL_REVENUE_DATE] == NULL || $master[SL_REVENUE_DATE] == ""){ ?>
                        <a  href="<?php echo site_url('order/edit-order-2').'?id='.$master[SL_ID] ?>" class="print bottom-print top-print no-right-margin right">編集</a>
                    <?php }else{ ?>
                        <a href="#dialog-form" id="edit" class="print bottom-print top-print no-right-margin right">編集 </a>
                    <?php } ?>
                    <table class="no-input-table">
                        <thead>
                            <tr>
                                <th>商品ID</th>
                                <th>商品名</th>
                                <th>規格</th>
                                <th>カラー</th>
                                <th>結束単位</th>
                                <th>注文数</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sum_total = 0;
                                    foreach ($detail['order_data'] as $key => $value) {
                                    $total = 0.0;
                                    $sum_total += $value[OD_QUANTITY];
                                    echo '<tr>';
                                    //echo    '<td >'.$value[PL_PRODUCT_CODE_SALE].'</td>';
                                    if(empty($value[PL_PRODUCT_CODE_SALE]) && empty($value[PL_STANDARD]) && empty($value[PL_COLOR_TONE]) && empty($value[PL_NUMBER_PACKAGE])) {
                                        echo '<td class="field_delete">'.$this->lang->line("message_delete_product").'</td>';
                                    } else {
                                        echo    '<td>'.$value[PL_PRODUCT_CODE_SALE].'</td>';
                                    }
                                    echo    '<td >'.$value[PL_PRODUCT_NAME].'</td>';
                                    echo    '<td >'.$value[PL_STANDARD].'</td>';
                                    echo    '<td >'.$value[PL_COLOR_TONE].'</td>';
                                    echo    '<td >'.$value[PL_NUMBER_PACKAGE].'</td>';
                                    echo    '<td >'.number_format($value[OD_QUANTITY],2).'</td>';
                                    echo '</tr>';
                            } ?>
                            <tr class="sum-col">
                                <td>合計</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?= number_format($sum_total,2)?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
               <div class="row wrapper-textarea">
                    <label>備考</label>
                    <textarea class="form-control" disabled rows="5"><?= $master[SL_SUMMARY] ?></textarea><br />
				</div>
                <div class="row margin-bottom-table">
                    <?php if($master[SL_REVENUE_DATE] == NULL || $master[SL_REVENUE_DATE] == ""){ ?>
                        <a href="#dialog-form" class="print" data-id="<?= $master['id'] ?>" id="delete" >注文削除</a>  
                    <?php }else{ ?>
                        <a href="#dialog-form" id="delete2" class="print">注文削除 </a>
                    <?php } ?>
                    
                </div>
            </div>
            <div class="row">
                <div class="left">
                </div>
            </div>
            <div id="menu1" class="tab-pane fade <?php echo $setTab2; ?>">
                <div class="row sec-row">
                    <a id="btn_url_edit_delivery" class="print top-print bottom-print no-right-margin right">編集 </a>

                    <table class="no-input-table table-delivery">
                            <thead>
                                <tr>
                                    <th width="8%">商品ID </th>
                                    <th>商品名</th>
                                    <th width="8%">規格</th>
                                    <th width="8%">カラー</th>
                                    <th width="8%">結束単位</th>
                                    <th width="8%">注文数</th>
                                    <th>納品数<br/><!--【コピー】--></th>
                                    <?php if($is_gaichyu == true) { 
                                        if($is_gaichyu_login == true) {
                                            ?>
                                            <th width="8%">単価</th>
                                            <?php
                                        } else {
                                        ?>
                                        <th width="8%">売上単価</th>
                                        <th width="8%">外注専用単価</th>
                                        <?php } } else { ?>
                                        <th width="8%">単価</th>
                                        <?php } ?>
                                        <?php if($is_gaichyu_login == true) { ?>
                                        <th width="8%">金額（外注）</th>
                                        <?php } else { ?>
                                        <th width="8%">金額（納品）</th>
                                        <?php } ?>
                                        <th width="6%">チェック</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $sum_total = 0;
                                $total = 0;
                                foreach ($detail['delivery_data'] as $key => $value) {
                                    echo '<tr>';
                                    //echo    '<td>'.$value[PL_PRODUCT_CODE_SALE].'</td>';
                                    if(empty($value[PL_PRODUCT_CODE_SALE]) && empty($value[PL_STANDARD]) && empty($value[PL_COLOR_TONE]) && empty($value[PL_NUMBER_PACKAGE])) {
                                        echo '<td class=" field_delete">'.$this->lang->line("message_delete_product").'</td>';
                                    } else {
                                        echo    '<td>'.$value[PL_PRODUCT_CODE_SALE].'</td>';
                                    } 
                                    if($value['product_name_delivery'] != null && $value['product_name_delivery'] != "") {
                                        echo    '<td>'.$value['product_name_delivery'].'</td>';
                                      } else if($value['product_name_price'] != null && $value['product_name_price'] != "") {
                                        echo    '<td>'.$value['product_name_price'].'</td>';
                                      } else {
                                        echo    '<td>'.$value[PL_PRODUCT_NAME].'</td>';
                                      }
                                    echo    '<td>'.$value[PL_STANDARD].'</td>';
                                    echo    '<td>'.$value[PL_COLOR_TONE].'</td>';
                                    echo    '<td>'.$value[PL_NUMBER_PACKAGE].'</td>';
                                    if($value[PL_SPECIAL] != 1) {
                                        echo    '<td>'.number_format(($value[OD_QUANTITY]+$value[OD_ADD]),2).'</td>';
                                    }
                                    else {
                                        echo '<td></td>';
                                    }
                                    if($value[PL_SPECIAL] != 1) {
                                        echo    '<td>'.(($value['quantity_delivery'] > 0) ? number_format($value['quantity_delivery'],2) : "").'</td>';
                                    }
                                    else {
                                        echo '<td></td>';
                                    }

                                    if($value[PL_SPECIAL] != 1) {
                                        if($is_gaichyu == true) { 
                                            if($is_gaichyu_login == true) {
                                                echo '<td>'.(($value['price_delivery_gaichyu'] > 0) ? number_format($value['price_delivery_gaichyu'],2) : "").'</td>';
                                            } else {
                                                echo '<td>'.(($value['price_delivery'] > 0) ? number_format($value['price_delivery'],2) : "").'</td>';
                                                echo '<td>'.(($value['price_delivery_gaichyu'] > 0) ? number_format($value['price_delivery_gaichyu'],2) : "").'</td>';
                                            } 
                                        } else {
                                            echo '<td>'.(($value['price_delivery'] > 0) ? number_format($value['price_delivery'],2) : "").'</td>';
                                        }
                                    } else {
                                        if($is_gaichyu == true) { 
                                            if($is_gaichyu_login == true) {
                                                echo '<td></td>';
                                            } else {
                                                echo '<td></td>';
                                                echo '<td></td>';
                                            } 
                                        } else {
                                            echo '<td></td>';
                                        }
                                    }
                                    
                                    if($is_gaichyu_login == true) {
                                        $amount_gaichyu = $value['price_delivery_gaichyu'] * $value['quantity_delivery'];
                                        echo    '<td>'.(($amount_gaichyu > 0) ? number_format($amount_gaichyu,2) : "").'</td>';
                                    } else {
                                        $amount = $value[DD_DELIVERY_AMOUNT];
                                        echo    '<td>'.(($amount > 0) ? number_format($amount,2) : "").'</td>';
                                    }
                                    
                                    $count_checklist++;
                                    if(isset($value[DD_CHECK]) && $value[DD_CHECK] == 1) {
                                        $sum_checklist++;
                                        echo    '<td>レ</td>';
                                    }
                                    else{
                                        echo    '<td></td>';
                                    }
                                    echo '</tr>';

                                    // Total
                                    $sum_total += $amount;
                                    $sum_total_gaichyu += $amount_gaichyu;
                                    
                                    // number order
                                    if($value[PL_SPECIAL] != 1) {
                                        $total += ($value[OD_QUANTITY]+$value[OD_ADD]);
                                    }
                            } ?>
                                <tr class="sum-col">
                                    <td>合計</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?= number_format($total,2) ?></td>
                                    <td></td>
                                    <td></td>

                                    <?php if($is_gaichyu == true) { ?>
                                        <?php if($is_gaichyu_login == true) { ?>
                                            <td><?= ($sum_total_gaichyu > 0) ? number_format($sum_total_gaichyu,2) : "" ?></td>
                                        <?php } else { ?>
                                            <td></td>
                                            <td><?= ($sum_total > 0) ? number_format($sum_total,2) : "" ?></td>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <td><?= ($sum_total > 0) ? number_format($sum_total,2) : "" ?></td>
                                    <?php } ?>

									<td></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
                <div class="row wrapper-textarea">
                    <label>備考</label>
                    <textarea class="form-control" disabled rows="5"><?= $master[SL_DELIVERY_NOTE] ?></textarea><br />
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 var deleteUrl = "<?= base_url("order/delete-order") ?>";   
 var receivedUrl = "<?= base_url("receive-order") ?>";
 var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
 var order_id = "<?= $this->input->get('id'); ?>";
 var customer_id = "<?= $master['customer_id']; ?>";
 var copy_order_to_shipment = "<?= base_url("order/copy_order_to_shipment") ?>"; 
 var message_copy_order_to_shipment_title = "<?= $this->lang->line('message_copy_order_to_shipment_title')?>";
 var message_copy_order_to_shipment_error = "<?= $this->lang->line('message_copy_order_to_shipment_error')?>";
 var message_copy_order_to_shipment_success = "<?= $this->lang->line('message_copy_order_to_shipment_success')?>";
 var count_checklist = <?= $count_checklist;?>;
 var sum_checklist = <?= $sum_checklist;?>;
 var url_edit_delivery = "<?php echo site_url('order/edit-delivery-order?id='.$master['id'].'&type=2'); ?>";
 var message_not_redirect_to_delivery = "<?= $this->lang->line('message_not_redirect_to_delivery')?>";
</script>