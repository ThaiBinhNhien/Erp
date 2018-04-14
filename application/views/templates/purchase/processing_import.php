<style>
    .not-active {
      pointer-events: none;
      cursor: default;
      background:grey !important;
      border:1px solid grey !important;
    }
	.purchase #copy{
		display:block;
		text-align: center !important;
	}
	.purchase .processing-table th:nth-child(6){
		width:5%;
	}
	.sum{
		padding-right:5px !important;
	}
</style>
<style>
/* Popup container - can be anything you want */
.popup {
  //position:relative;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* The actual popup */
.popup .popuptext {
    visibility:  visible;
    background-color: #cc5757;
    color: #fff;
    text-align: center;
    border-radius: 3px;
    padding: 8px 6px;
    position: absolute;
    z-index: 9999;
    //bottom: 125%;
    left: 50%;
    margin-left: -80px;
    width: 160px;
    opacity:0.9;
}
.tooltip-inner {
  width: 160px !important;
  padding: 8px 6px !important;
}
/* Popup arrow */
.popup .popuptext::after {
    content: "";
    position: absolute;
    bottom: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #bb5c5c transparent transparent transparent;
    transform: rotate(180deg);
}
/* Toggle this class - hide and show the popup */
.popup .show {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s;
}
/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
    from {opacity: 0;}
    to {opacity: 1;}
}

@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity:1 ;}
}
table input{
  width:calc(100% - 2px) !important;
  border: 1px solid #878898 !important;
  margin:1px !important;
  height:32px;
  }
</style>
<div class="wrapper-contain purchase order">
<div class="row">
	<div class="col-md-8">
		<h3>発注伝票　入庫処理</h3>
	</div>
	<div class="right">
		<a href="<?php echo site_url('purchase') ?>" class="print top-print">MENU画面へ</a>
	</div>
</div>
<div class="row">
    <div class="col-md-5 col-sm-5">
    <table class="table_1 detail-table">
        <tr>
			<td>発注No:</td>
			<td id="order_id"><?php echo $id; ?></td>
			<input type="hidden" id="has_import" value="<?php echo ($has_import) ?>">
            <input type="hidden" id="update_date" value="<?php echo ($update_date) ?>">
		</tr>
		<tr>
			<td>起票者:</td>
			<td><?php echo $user; ?></td>
		</tr>
		<tr>
			<td>発注日:</td>
			<td id="order_date"><?php echo str_replace('-', '/', $create_date) ?></td>
		</tr>
		<tr>
			<td>仕入先:</td>
			<td><?php echo $supplier_place; ?></td>
            <input type="hidden" id="supplier_id" value="<?php echo ($supplier_id) ?>">
		</tr>
		<tr>
			<td>販売先:</td>
			<td><?php echo $sales_des; ?></td>
			<input type="hidden" id="sales_des_id" value="<?php echo $sales_des_id ?>">
		</tr>
		<tr>
			<td>発注内容:</td>
			<td><?php echo $order_content; ?></td>
			<input type="hidden" id="content_id" value="<?php echo ($content_id) ?>">
		</tr>
		<tr>
			<td>納品場所:</td>
			<td><?php echo $base; ?></td>
            <input type="hidden" id="stock_id" value="<?php echo ($base_id) ?>">
		</tr>
		<tr>
			<td>形態:</td>
			<td><?php if ($is_confirm) {
	echo "承認済";
} else {
	echo "未承認";
}
?></td>
		</tr>
		<tr>
           <td>入庫:</td>
           <td><?php if ($has_import) {
	echo ('済');
} else {
	echo ('未');
}
?></td>
		</tr>
		<tr>
           <td>承認者:</td>
           <td><?php if ($is_confirm) {
	echo $confirm_user;
} else {
	echo "__";
}
?></td>
		</tr>
	</table>
</div>
</div>
<div class="row sec-row">
<table class="no-order-table processing-table">
    <thead>
		<tr>
            <th width=10%>商品コード</th>
            <th width=20%>商品名</th>
            <th>色調</th>
            <th style="width:10%;">規格</th>
            <th style="width:5%;">数量</th>
            <th style="text-align:center;">入庫数<?php if (!$has_import) {?><a id="copy">コピー</a><?php }?></th>
            <th style="width: 6%">返品数</th>
            <th style="width:6%;">入庫累計</th>
            <th style="width:10%;">仕入単価</th>
            <th>金額（円)</th>
            <th style="width:10%;">入庫日</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($product_list as $product) {
	?>
        <tr>
            <td><?php echo $product->{PL_PRODUCT_CODE_BUY} ?><input class="product_id" type='hidden' value='<?php echo $product->{PL_PRODUCT_ID} ?>'/></td>
            <td class="left-text product_name"><?php echo $product->{PL_PRODUCT_NAME_BUY} ?></td>
            <td><?php echo $product->{PL_COLOR_TONE} ?></td>
            <td><?php echo $product->{PL_STANDARD} ?></td>
            <td class="number_order"><?php echo $product->{TGRI_NUMBER_OF_ORDERS} ?></td>
            <td >
<!-- <div class="popup"><span class="popuptext" id="myPopup">A Simple Popup!</span></div> -->
            <input <?php if ($has_import & ($product->amount == $product->{TGRI_NUMBER_OF_ORDERS} | $content_id == 11)) {
		echo "disabled";
	}
	?>
            class="number_purchase"
            value="<?php if ($content_id == 11) {
		echo $product->{TGRI_NUMBER_OF_ORDERS};
	} else {
		echo $product->amount;
	}
	?>"
            max="<?php echo $product->{TGRI_NUMBER_OF_ORDERS} ?>" />
            </td>
            <td>
            	<input class="back_number" <?php if ($product->amount < $product->{TGRI_NUMBER_OF_ORDERS} | $content_id == 11) {
		echo 'disabled';
	}
	?> value="<?php echo $product->back_number ?>"/>
            </td>
            <td class="accumulation"><?php if ($content_id == 11) {
		echo $product->{TGRI_NUMBER_OF_ORDERS};
	} else {
		echo $product->accumulation;
	}
	?></td>
            <td class="price_unit"><?php echo $product->{TGRI_UNIT_PRICE} ?></td>
            <td class="price"></td>
            <td><input class="datepicker datepicker_ product_date" <?php if ($content_id == 11) {
		echo "disabled";
	}
	?> value="<?php if (empty($product->date_import)) {
		echo date('Y-m-d');
	} else {
		echo $product->date_import;
	}
	?>"/></td>
        </tr>
        <?php }?>
        <tr class="sum-col">
            <td colspan="9" class="right-text" >合計</td>
            <td class="sum_price right-text"></td>
            <td></td>
        </tr>
        <tr class="sum-col">
            <td colspan="9" class="right-text"> 値引</td>
            <td class="discount right-text"><?php echo ($discount) ?></td>
            <td></td>
        </tr>
        <tr class="sum-col">
            <td colspan="9" class="sum right-text">総合計</td>
            <td class="total_price right-text"></td>
            <td></td>
        </tr>
    </tbody>
</table>
</div>
	<div class="row first-row">
		<a href="#" class="print left" style="pointer-events: none;background:grey;border:1px solid grey !important;">行挿入 </a>
		<a href="#" class="print left" style="pointer-events: none;background:grey;border:1px solid grey !important;">行削除  </a>
		<a class="print save-purchase right <?php if ($content_id == 11 || ($_SESSION['request-level'] == 'P' && $_SESSION['login_info'].U_ID != $user && $has_import)) {
	echo 'not-active';
}
?>">保存 </a>
	</div>
</div>
<script type="text/javascript">
    var base_url = "<?php echo (base_url()) ?>";
</script>