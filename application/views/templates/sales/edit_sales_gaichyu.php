<style>
table input{
  width:calc(100% - 2px) !important;
  border: 1px solid #878898 !important;
  margin:1px !important;
  height:32px;
  }
</style>
<div class="wrapper-contain revenues order detail-revenues">
<input type="hidden" id="invoice_no" value="<?php echo ($id) ?>">
<div class="row">
    <div class="col-md-8">

        <table class="detail-table">
            <tr>
               <td width="30%">請書No: </td>
               <td><?php echo ($id) ?></td>
               <input type="hidden" id="invoice_id" value="<?php echo ($id) ?>">
               <input type="hidden" id="update_date" value="<?php echo $update_date ?>">
            </tr>
            <tr>
               <td>請求書種別:</td>
               <td><?php echo ($invoice) ?></td>
            </tr>
            <tr>
               <td>お得意先:</td>
               <td><?php echo ($customer_name) ?></td>
            </tr>
              <tr>
               <td>部署指定:</td>
               <td><?php echo ($department_list) ?></td>
            </tr>
            <tr>
               <td>納品日:</td>
               <td><?php echo ($date_ship['start'] . ' - ' . $date_ship['end']) ?></td>
           </tr>
           <tr>
               <td>得意先住所:</td>
               <td height="40px;">
                <textarea rows="2" cols="50" id="address"><?php echo ($address) ?></textarea>
                </td>

           </tr>
        </table>

    </div>
    <div class="button-right-side">
    <a  href="<?php echo site_url('sale'); ?>" class="print right ">MENU画面へ </a>
     <a href="<?php echo (base_url('sale/print-invoice?inv_id=' . $id)) ?>" class="print right top-print">印刷 </a>
     <a  href="" class="print right top-print">営業管理画面へ</a>
        </div>
</div>

<div class="clearfix"></div>
<div class="row" style="margin:9px;">
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;padding-top:0;"></caption>
            <th style="width: 14%;">
            <?php if ($sum_price_cate1 > 0) {
	echo 'ﾘﾈﾝｻﾌﾟﾗｲ売上';
}
?>
            </th>
            <th style="width: 13%;">
                <?php
if ($environment_tax > 0) {
	echo "ﾘﾈﾝ補充費";
} elseif ($discount > 0) {
	echo "値引分" . $discount . "%";
}

?>
            </th>
            <th style="width: 14%">
            <?php if ($sum_price_cate2 > 0) {
	echo 'ｸﾘｰﾆﾝｸﾞ他売上';
}
?>
            </th>
            <th style="width: 14%">管理業務料</th>
            <th style="width: 15%">小　　　　計</th>
            <th style="width: 15%">
                <?php if ($tax > 0) {
	echo "消費税" . $tax . "%";
}
?>
            </th>
            <th style="width: 15%">請求金額（税込）</th>
            <tr>
                <td class="right-text sum_price_cate1">
                    <?php
if ($sum_price_cate1 > 0) {
	echo $sum_price_cate1;
}

$discount_cate1 = $sum_price_cate1 * $discount_gaichyu->linen_discount / 100;
?>
                </td>
                <td class="right-text col_2_value">
                    <?php
if ($environment_tax > 0 & $sum_price_cate1 > 0) {
	echo $environment_tax * $sum_price_cate1 / 100;
} elseif ($discount > 0 & $sum_price_cate1 > 0) {
	echo $discount * $sum_price_cate1 / 100;
}

$discount_environment = $environment_tax * $sum_price_cate1 * $discount_gaichyu->environment_discount / 10000;
?>
                </td>
                <input type="hidden" class="col_2_hide_value" value="<?php echo $environment_tax - $discount; ?>">
                <td class="right-text sum_price_cate2">
                    <?php
if ($sum_price_cate2 > 0) {
	echo $sum_price_cate2;
}

$discount_cate2 = $sum_price_cate2 * $discount_gaichyu->other_discount / 100;
?>
                </td>
                <td class="right-text discount_gaichyu">
                    <?php
$fee_gaichyu = $discount_cate1 + $discount_environment + $discount_cate2;
echo $fee_gaichyu;
?>
                </td>
                <td class="right-text" id="sum_price">
                    <?php
$sum_price = $sum_price_cate1 - $discount * $sum_price_cate1 / 100 + $environment_tax * $sum_price_cate1 / 100 + $sum_price_cate2 - $fee_gaichyu;
echo $sum_price;
?>
                </td>
                <td class="right-text tax_value">
                    <?php if ($tax > 0) {
	echo $sum_price * $tax / 100;
}
?>
                </td>
                <input type="hidden" class="tax_hide_value" value="<?php echo $tax; ?>">
                <td class="right-text" id="total_price">
                    <?php echo $sum_price + $sum_price * $tax / 100; ?>
                </td>
            </tr>
    </tbody>
</table>
</div>
<div class="row third-row margin-top-table"  >
      <label class="" for="comment">備考</label>
      <textarea class="form-control" rows="5" id="remark"><?php echo ($remark) ?></textarea>
</div>

<div class="row third-row">
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;padding-top:0;">請求書明細書</caption>
            <th width="50%">項　　　　　目（部署）</th>
            <th width="25%">リネンサプライ売上</th>
            <th width="25%">クリーニング他売上</th>
        <?php foreach ($list_order as $order) {?>
        <input type="hidden" class="order_id_list" value="<?php echo $order->{ID_ORDER_ID} ?>">
        <tr>
            <td><?php echo $order->{DL_DEPARTMENT_NAME} ?></td>

            <input type="hidden" class="department_id" value="<?php echo $order->{SL_DEPARTMENT_CODE} ?>">
            <td style="text-align: right;" class="price_cate1 cate1_of_order<?php echo $order->{ID_ORDER_ID} ?>"><?php echo $order->sum_price_cate1 ?></td>
            <td style="text-align: right;" class="price_cate2 cate2_of_order<?php echo $order->{ID_ORDER_ID} ?>"><?php echo $order->sum_price_cate2 ?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
</div>
<?php foreach ($list_order as $order) {?>
<div style="padding-left: 10px; font-size: 20px;"><b>請求明細: </b> <?php echo $order->{DL_DEPARTMENT_NAME} ?> </div>
<div class="row third-row">
<?php if (!empty($order->product_list_cate1)) {?>
<table  class="full-table">
    <tbody>
        <input type="hidden" class="order_id" value="<?php echo $order->{ID_ORDER_ID} ?>">
        <caption style="text-align:left;padding-top:0;">種目：ﾘﾈﾝｻﾌﾟﾗｲ売上 &ensp;<span class="sum_price"><?php echo $order->sum_price_cate1 ?></span>円</caption>
            <th width="10%">商品コード</th>
            <th width="30%">商品名</th>
            <th width="20%">数量</th>
            <th width="20%">単価</th>
            <th width="20%">金額（円） </th>
        <?php foreach ($order->product_list_cate1 as $product) {?>
        <tr>
            <td><?php echo $product->{DD_PRODUCT_CODE} ?></td>
            <td><?php echo $product->{DD_PRODUCT_NAME} ?></td>
            <td style="text-align: right;"><?php echo $product->{DD_QUANTITY}+0 ?></td>
            <td style="text-align: right;"><?php echo $product->{DD_GAICHYU_PRICE}+0 ?></td>
            <td style="text-align: right;" class="right-text price"><?php echo $product->{DD_QUANTITY} * $product->{DD_GAICHYU_PRICE} ?></td>
        </tr>
        <?php }?>
        <tr>
            <td>値引き(%)</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text"><input style="text-align: right" class="discount_cate1" value="<?php echo $order->{ID_DISCOUNT_SUPPLIER} ?>"></td>
        </tr>
    </tbody>
</table>
<?php } else {?>
<input type="hidden" class="discount_cate1" value="0">
<?php }?>
<?php if (!empty($order->product_list_cate2)) {?>
<table  class="full-table" style="margin-top: 10px">
    <tbody>
        <input type="hidden" class="order_id" value="<?php echo $order->{ID_ORDER_ID} ?>">
        <caption style="text-align:left;padding-top:0;">種目：ｸﾘｰﾆﾝｸﾞ他売上 &ensp;<span class="sum_price"><?php echo $order->sum_price_cate2 ?></span>円</caption>
            <th width="10%">商品コード</th>
            <th width="30%">商品名</th>
            <th width="20%">数量</th>
            <th width="20%">単価</th>
            <th width="20%">金額（円） </th>
        <?php foreach ($order->product_list_cate2 as $product) {?>
        <tr>
            <td><?php echo $product->{DD_PRODUCT_CODE} ?></td>
            <td><?php echo $product->{DD_PRODUCT_NAME} ?></td>
            <td style="text-align: right;"><?php echo $product->{DD_QUANTITY}+0 ?></td>
            <td style="text-align: right;"><?php echo $product->{DD_GAICHYU_PRICE}+0 ?></td>
            <td style="text-align: right;" class="right-text price"><?php echo $product->{DD_QUANTITY} * $product->{DD_GAICHYU_PRICE} ?></td>
        </tr>
        <?php }?>
        <tr>
            <td>値引き(%)</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text"><input style="text-align: right" class="discount_cate2" value="<?php echo $order->{ID_DISCOUNT_ORTHER} ?>"></td>
        </tr>
    </tbody>
</table>
<?php } else {?>
<input type="hidden" class="discount_cate2" value="0">
<?php }?>
</div>
<?php }?>
<div class="row first-row">
    <a class="print right save-created">保存 </a>
</div><!--End button row-->
</div>
<script>
    var base_url = '<?php echo (base_url()) ?>';
    var discount_gaichyu = <?php echo json_encode($discount_gaichyu) ?>;
</script>