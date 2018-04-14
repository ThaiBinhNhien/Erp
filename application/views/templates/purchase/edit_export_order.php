<style>
	label{
		line-height: 1.3;
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
  z-index:99999999;
  border:1px solid goldenrod;
  box-shadow: 0 8px 6px -6px #989898;
  border-bottom-left-radius:4px;
  border-bottom-right-radius:4px;
  margin-top:1px;
}
.detail-product tr{
  width:100%;
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
  padding:5px !important;
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
  text-align: center;
  }
</style>
<div class="wrapper-contain purchase order #export">
<div class="row">
	<div class="col-md-8">
		<h3>出庫伝票　編集 </h3>
	</div>
	<div class="right">
		<a href="<?php echo site_url('purchase/export-purchase') ?>" class="print top-print">MENU画面へ</a>
	</div>
</div>
<div class="first-row">
    <form class="form-horizontal" role="form"  >
		<fieldset>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">出庫No:</label>
          <div class="col-md-8">
            <input class="form-control warehouse_id" type="text" value="<?php echo $id ?>" style="border:none;background:none;" disabled>
            <input type="hidden" id="order_id" value="<?php echo ($id) ?>">
            <input type="hidden" id="tolinen_sale" value="<?php echo ($tolinen_sale) ?>">
            <input type="hidden" id="stock_id" value="<?php echo ($stock_id) ?>">
            <input type="hidden" id="voter_id" value="<?php echo $_SESSION['login-info'][U_ID]; ?>">
            <input type="hidden" id="update_date" value="<?php echo $update_date ?>">
          </div>
        </div>
      </div>
    </div>
        <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label" style="line-height:0.8 !important;">起票者:</label>
          <div class="col-md-8">
			  <input value="<?php echo ($issuer) ?>" disabled style="background:none;border:none;"/>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">出庫者:</label>
          <div class="col-md-8">
            <select class="form-control ship_issuer">
              <?php foreach ($user_list as $user) {
	?>
                <option <?php if ($ship_issuer_id == $user->{UX_ID}) {
		echo 'selected';
	}
	?> value="<?php echo $user->{UX_ID} ?>"><?php echo $user->{UX_NAME} ?></option>
              <?php }?>
            </select>
          </div>
        </div>
      </div>
    </div>
        <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">出庫日:</label>
          <div class="col-md-8">
			<span class="form-control form-control-input" style="margin-bottom:9px;">
            <input  class="datepicker_ date_export" value="<?php echo str_replace('-', '/', $date_export) ?>">
           	<span class=" icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-8 col-lg-8">
        <div class="form-group">
          <label for="inputEmail" class="col-md-2 control-label">販売先:</label>
          <div class="col-md-8">
            <select class="SALES_DESTINATION_SELECT" style="width:100%;" class="right-3 form-control" disabled>
              <?php foreach ($sales_destination_list as $sales_des) {
	?>
              <option <?php if ($sales_destination_id == $sales_des->{TSD_ID}) {
		echo 'selected';
	}
	?> value="<?php echo $sales_des->id ?>"><?php echo $sales_des->{TSD_DISTRIBUTOR_NAME} ?></option>
              <?php }?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">出庫内容:</label>
          <div class="col-md-8">
            <!--<input class="hide-input no-bottom-margin" value="外注分出荷"/>-->
			      <select class="form-control content-processing" disabled>
              <?php foreach ($processing_content_list as $processing_content) {
	?>
              <option <?php if ($processing_content_id == $processing_content->{PC_ID}) {
		echo 'selected';
	}
	?> value="<?php echo $processing_content->{PC_ID} ?>"><?php echo $processing_content->{PC_PROCESSING_CONTENT} ?></option>
              <?php }?>
            </select>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4 form-group">
        <label for="inputEmail" class="col-md-4 control-label">在庫場所:</label>
        <div class="col-md-8"><input disabled type="text" value="<?php echo ($stock_name) ?>"></div>
      </div>
    </div>
    </fieldset>
    </form>
</div>
<div class="row sec-row">
<div>
<table class="no-order-table " id="export-table">
    <thead>
        <tr>
            <th style="width:10%;">商品コード</th>
            <th style="width:20%;">商品名</th>
            <th>色調</th>
            <th>規格</th>
            <th style="width:10%;">単価（円）</th>
            <th style="width:10%;">現貯蔵品数</th>
            <th style="width:10%;">出庫数</th>
            <th style="width:10%;">合計（円）</th>
        </tr>
    </thead>
    <tbody>
      <?php foreach ($product_list as $product) {
	?>
        <tr class="product">
            <td >
                <div class="wrap">
                <span class="input-triangle"><b></b></span>
                <?php $i = 0;?>
                <?php foreach ($list_product_id as $product_id) {?>
                <?php if ($product->{TGRI_PRODUCT_ID} == $product_id->{TPCT_PRODUCT_ID}) {?>
                <?php if ($i == 0) {
                  echo '<input class="product_id" name="product_id" value="' . $product_id->{PL_PRODUCT_CODE_BUY} . '"/>';
                  echo '<input type="hidden" value="'.$product_id->{TPCT_PRODUCT_ID}.'" class="real_id"/>';
                }

		$i++;?>

                <?php }?>


                 <?php }?>
              </div>
            </td>
            <td data-name class="product_name"><?php echo ($product->{TGRI_PRODUCT_NAME}) ?></td>
            <td data-color class="color"><?php echo ($product->{PL_COLOR_TONE}) ?></td>
            <td data-standard class="standard"><?php echo ($product->{PL_STANDARD}) ?></td>
            <td data-price class="price"><?php echo ($product->price_unit) ?></td>
            <td data-stock class="total_stock_product"><?php echo ($product->amount_stock + $product->amount) ?></td>
            <td><input  type="text" class="amount_export" value="<?php echo ($product->amount) ?>"/></td>
            <td class="total_price"><?php echo ($product->total_price) ?></td>
        </tr>
      <?php }?>
        <tr class="sum-col">
             <td>合計</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="sum_total_price"><?php echo ($sum_total_price) ?></td>
        </tr>
    </tbody>
</table>
</div>
<div class="row first-row">
	<label class="" for="comment">備考</label>
	<textarea class="note form-control" rows="5" id="comment"><?php echo ($note) ?></textarea>
</div>
</div>
  <div class="row margin-bottom-table">
		<a href="#" class="print left" id="insert-export-row">行挿入 </a>
		<a href="" class="print left" id="remove-export-row">行削除</a>
		<a class="print save-export-order right">保存</a>
	</div>
</div>
<script>
  var json_product_list = <?php echo ($json_list_product); ?>;
  var base_url = '<?php echo (base_url()) ?>';
  var tolinen_sale = <?php echo $tolinen_sale; ?>;
</script>