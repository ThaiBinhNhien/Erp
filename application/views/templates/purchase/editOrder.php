<style>
	.edit-purchase .sum-col td:nth-child(1){
		padding-right:5px;
	}
	.edit-purchase .edit-table td:nth-child(n+7){
		width:8%;
	}
     a.disabled {
        pointer-events: none;
    }
</style>
<style>
.detail-product{
  position:absolute;
  display: none;
  max-height: 100px;
  overflow-y:auto;
  background:lemonchiffon;
  width:200%;
  z-index:9999;
  border:1px solid goldenrod;
  box-shadow: 0 8px 6px -6px #989898;
  border-bottom-left-radius:4px;
  border-bottom-right-radius:4px;
  margin-top:1px;
}
.detail-product tr{
  width:200%;
  border-bottom:1px solid goldenrod;
}
.detail-product td{
    height:24px !important;
    border:none;
}
.detail-product tr:hover{
  background:#d2c097;
}
.detail-product tr:last-child{
  border-bottom:none;
}
/* Begin Setting the width of td */
.detail-product td:nth-child(1){
  width:3%;
  text-align: left;
  padding-left:5px;
}
.detail-product td:nth-child(2){
  width:7%;
  text-align: left;
}
/* End Setting the width of td */
.product_id{
  //padding:5px !important;
}
.input-triangle{
      position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
    height: 20px;
    cursor: pointer;
}
.input-triangle b {
    border-color:#888 transparent transparent;
    border-style: solid;
    border-width: 5px 4px 0;
    height: 0;
    left: 50%;
    top: 50%;
    margin-left: -4px;
    margin-top: -2px;
    position: absolute;
    width: 0;
    font-weight: 700;
}
.wrap{
  position:relative;
}

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
    bottom: 125%;
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
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #bb5c5c transparent transparent transparent;
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
<div class="wrapper-contain purchase edit-purchase order">
<div class="row">
	<div class="col-md-8">
		<h3>発注伝票　編集</h3>
	</div>
	<div class="right">
		<a href="<?php echo site_url('purchase') ?>" class="print top-print">MENU画面へ</a>
	</div>
</div>
<form class="form-horizontal" role="form" name="edit_purchase_order">
    <fieldset>
<div class="first-row">

        <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">発注No:</label>
          <div class="col-md-8">
            <input class="hide-input order_id" disabled type="text" value="<?php echo ($id) ?>">
            <input type="hidden" id="update_date" value="<?php echo $update_date ?>">
          </div>
        </div>
      </div>
    </div>
        <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">起票者:</label>
          <div class="col-md-8">
			  <input disabled style="background:none;border:none;" value="<?php echo ($user) ?>" />
          </div>
        </div>
      </div>
    </div>
        <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">発注日:</label>
          <div class="col-md-8">
			<span class="form-control form-control-input" style="margin-bottom:9px;">
            <input  class="" value="<?php echo str_replace('-', '/', $create_date); ?>" id="date_create" name="order_date">
            <span class=" icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">納品日:</label>
          <div class="col-md-8">
			<span class="form-control form-control-input" style="margin-bottom:9px;">
            <input  class="" id="delivery_date" name="delivery_date" value="<?php echo str_replace('-', '/',$delivery_date); ?>">
            <span class=" icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-8 col-lg-8">
        <div class="form-group">
          <label for="inputEmail" class="col-md-2 control-label">仕入先:</label>
          <div class="col-md-8">
            <select style="width:100%;" disabled class="right-3 form-control" id="supplier_id">
            <?php foreach ($supplier_list as $supplier) {
	?>
            <option value="<?php echo ($supplier->{SUP_ID}) ?>" <?php if ($supplier_id == $supplier->{SUP_ID}) {
		echo "selected";
	}
	?>>
              <?php echo ($supplier->{SUP_SUPPLIER_COMPANY_NAME}) ?>
            </option>
            <?php }?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-8 col-lg-8">
        <div class="form-group">
          <label for="inputEmail" class="col-md-2 control-label">販売先:</label>
          <div class="col-md-8">
            <select disabled style="width:100%;" class="right-3 form-control" id="sales_des_id">
              <?php foreach ($sales_des_list as $sales_des) {
	?>
              <option value="<?php echo $sales_des->{TSD_ID} ?>" <?php if ($sales_des->{TSD_ID} == $sales_des_id) {
		echo "selected";
	}
	?>>
                <?php echo $sales_des->{TSD_DISTRIBUTOR_NAME}; ?>
              </option>
              <?php }?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">発注内容:</label>
          <div class="col-md-8">
            <select disabled class="form-control" id="content_id">
              <?php foreach ($order_content_list as $content) {
	?>
              <option value="<?php echo ($content->{PC_ID}) ?>" <?php if ($order_content_id == $content->{PC_ID}) {
		echo "selected";
	}
	?>>
                <?php echo ($content->{PC_PROCESSING_CONTENT}) ?>
              </option>
              <?php }?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">納品場所:</label>
          <div class="col-md-8">
            <select disabled id="stock_id" class="form-control" <?php if (!$isAdmin) {
	echo 'disabled';
}
?>>
              <?php if ($isAdmin && $base_id==0) {?><option selected value="0">規定外</option><?php }?>
              <?php foreach ($base_list as $base) {
	?>
                <option value="<?php echo ($base->{BM_BASE_CODE}) ?>" <?php if ($base_id == $base->{BM_BASE_CODE}) {
		echo "selected";
	}
	?>>
                  <?php echo $base->{BM_BASE_NAME} ?>
                </option>
              <?php }?>
            </select>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-8 col-lg-8">
        <div class="form-group">
          <label for="inputEmail" class="col-md-2 control-label"></label>
          <div class="col-md-8">
            <input id="stock_address" style="width:100%;" <?php if ($base_id != 0) {
	echo 'disabled';
}
?> class="right-3" value="<?php echo ($stock_address) ?>" />
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">形態:</label>
          <div class="col-md-8">
            <input style="width:100%;border:1px solid white;background:white;" value="<?php if ($is_confirm) {
	echo "承認済";
} else {
	echo "未承認";
}
?>" disabled/>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">入庫:</label>
          <div class="col-md-8">
            <input style="width:100%;border:1px solid white;background:white;" disabled value="未"/>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">承認者:</label>
          <div class="col-md-8">
           <input style="width:100%;border:1px solid white;background:white;" disabled value="<?php if ($is_confirm) {
	echo $confirm_user;
}
?>"/>
          </div>
        </div>
      </div>
    </div>

</div>
<div class="row">
<div>
<table class="no-order-table" id="edit-purchase-table">
    <thead>
        <tr>
            <th style="width:10%">商品ID</th>
            <th style="width:20%">商品名</th>
            <th width=10%>色調</th>
            <th width=10%>規格</th>
            <th style="width:5%">数量</th>
            <th width=8%>入庫累計</th>
            <th width=8%>仕入単価</th>
            <th width=8%>金額（円）</th>
            <th>コメント</th>
        </tr>
    </thead>
    <tbody>
      <?php foreach ($product_list as $product) {
	?>
          <tr class="product">
            <td>
               <div class="wrap">
                <span class="input-triangle"><b></b></span>
                <input class="product_id" name="product_id" value="<?php echo $product->{PL_PRODUCT_CODE_BUY}; ?>"/>
                <input class="real_id" type="hidden" value="<?php echo $product->{PL_PRODUCT_ID}; ?>"/>
                

              </div>


            </td>
            <td data-name class='left-text product_name' ><?php echo $product->{PL_PRODUCT_NAME_BUY}; ?></td>
            <td data-color><?php echo $product->{PL_COLOR_TONE}; ?></td>
            <td data-standard><?php echo $product->{PL_STANDARD}; ?></td>
            <td class=''><input class="amount center-text" value="<?php echo $product->{TGRI_NUMBER_OF_ORDERS}; ?>"></td>
            <td data-accumulation><?php echo $product->accumulation; ?></td>
            <td data-price-unit class='price_unit tall'><?php echo $product->{TGRI_UNIT_PRICE}; ?></td>
            <td class='summarize price'><?php echo $product->price; ?></td>
            <td ><input name="comment" class="comment_product" value="<?php echo ($product->remark) ?>"></td>
          </tr>
      <?php }?>
        <tr class="sum-col">
			<td colspan="7" class="right-text">合計</td>
            <td class="center-text sum-price"><?php echo ($sum_price) ?></td>
            <!--<td></td>-->
            <td></td>
        </tr>
         <tr class="sum-col">
			<td colspan="7" class="right-text"> 値引(%)</td>
            <td class="center-text"><input value="<?php echo $discount ?>" class="center-text  right-text discount" name="discount"></td>
            <td></td>
        </tr>
        <tr class="sum-col">
            <td colspan="7" class="right-text"> 総合計</td>
            <td class="center-text sum-total"><?php echo ($total_price) ?></td>
            <!--<td></td>-->
            <td></td>
        </tr>
    </tbody>
</table>
</div>
</div>

<div class="third-row margin-top-table">
        <label class="" for="comment">備考</label>
            <textarea class=" form-control" rows="5" id="comment"><?php echo $remark ?></textarea>
</div>


<div class="row">

                  <a class="print left" id="insert-row-purchase">行挿入 </a>
                  <a class="print left" id="remove-row-purchase">行削除  </a>
                  <label class="right" style="margin-right:8px;"><input checked disabled type="checkbox" style="height:auto;width:auto;margin-right:10px;">承認を依頼する</label>


</div>




<div class="row first-row">
                     <a id="create-purchase-order" class="print save-purchase-order right <?php if ($level_user == 'P' && $info_user != $user) {
	echo 'disabled';
}
?>" data-id="<?php echo $id; ?>">保存</a>
</div>
</fieldset>
    </form>
</div>
<script type="text/javascript">
  var base_url = "<?php echo (base_url()) ?>";
  var json_product_list = <?php echo ($json_product_list) ?>;
  var sales_des_list = <?php echo (json_encode($sales_des_list)) ?>;
</script>