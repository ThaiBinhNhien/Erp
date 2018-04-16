<style>
button{
  height:31px;
}
.btn-group{
  width: calc(100% - 25px) !important;
}
.filter-option{
  margin-top:-1%;
}

.no-sum-col, .sev-col{
  line-height: 2.5;
}
.productselect1 {
  text-align: center;
}
</style>
<div class="wrapper-contain order">
 <div class="row">
<div class="col-md-8"> 
    <h3>注文伝票　新規作成</h3>
</div>
<div class="right">
    <a href="<?php echo site_url('receive-order') ?>" class="print top-print">MENU画面へ</a>
    </div>
</div>
<form class="form-horizontal" role="form" id="order_form" >
<div class="first-row">
    
		<fieldset>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">発注No:</label>
          <div class="col-md-8">
            <input class="form-control " id="order_no" type="text" disabled style="border:none;background:none;" value="">
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label" style="line-height:0.9">起票者:</label>
          <div class="col-md-8">
			  <input value="帝王太郎" disabled style="background:none;border:none;"/>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">発注日:</label>
          <div class="col-md-8">
			<span class="form-control form-control-input" style="margin-bottom:9px;">
            <input  class="orderDate" id="order_date" name="order_date" readonly>
           <span class=" icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">得意先名:</label>
          <div class="col-md-8">
            <select class="selectpicker " data-live-search="true" name="customer" <?= count($list_customer) == 1?'disabled':'' ?> data-live-search-placeholder="Search" id="customer">
            <?php foreach ($list_customer as $key => $value) {
              echo '<option '.(count($list_customer) == 1?'selected':'' ).' value="'.$value[CUS_ID].'">'.$value[CUS_CUSTOMER_NAME].'</option>';
            }
            ?>
            </select>
          </div>
        </div>
      </div>
		<div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">部署名:</label>
          <div class="col-md-8">
            <select class="form-control" name="customer_department" id="customer_department"><option></option></select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-5 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">予定日:</label>
          <div class="col-md-8">
            <span class="form-control form-control-input" style="margin-bottom:9px;">
            <input  class="orderToDate" id="delivery_expected" name="delivery_expected" readonly>
           <span class=" icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
      </div>
		<div class="col-sm-5 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">ワンタッチ:</label>
          <div class="col-md-8">
            <select class="form-control" id="product_set"><option></option></select>
          </div>
        </div>
      </div>
		<div class="col-sm-2 col-md-1 col-lg-1">
        <a class="print" id="btn_prouduct_set" style="margin:0;">表示</a>	
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">売上(納品)日:</label>
          <div class="col-md-8">
            <input disabled style="border:none;background:none;" />
          </div>
        </div>
      </div>
    </div>
    </fieldset>

</div>
<div class="row sec-row">
		<table class="no-order-table edit-table" id="create-table">
			<thead>
				<tr>
					<th width="10%">商品ID</th>
					<th>商品名</th>
					<th>規格</th>
					<th>カラー</th>
					<th>結束単位</th>
					<th>数量</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
            <!-- <select class="selectpicker productselect" data-live-search="true" name="product_item" data-live-search-placeholder="Search" id="first_data" >
              <?php foreach ($list_product as $key => $value) {
                echo '<option value="'.$value[PL_PRODUCT_ID].'">'.$value[PL_PRODUCT_CODE_SALE].'</option>';
              }
              ?>
            </select> -->
            <input class="form-control product_id" type="hidden" name="product_id" value=""  />
            <input class="form-control productselect1" name="product_item" value="" id="first_data" />
          </td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><input type="text" name="0_quantity" class="quantity_input"/></td>
				</tr>
				 <tr class="sum-col">
					<td>合計</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
</div>
</form>
<div class="row wrapper-textarea">
	<label>備考</label>
	<textarea class="form-control" id="note" rows="5"></textarea><br />
</div>
<div class="row margin-bottom-table">
	<a class="print left" id="insert">行挿入 </a>
	<a class="print left" id="remove">行削除 </a>
	<a class="print save-new-order right">保存 </a>
	<a class="print right save-temp-order">一時保存 </a> 
</div>
<div class="row margin-bottom-table margin-top-table ">
	<a href="<?php echo site_url('receive-order');?>" style="float:right" class="print">戻る  </a>
</div>
</div>
<style type="text/css" media="screen">

.form-group button {
    background: #fff;
    border-radius: 2px;
    margin: 0;
}
.form-group .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 88%;
    line-height: 18px;
}
td .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 100px;
    line-height: 18px;
}
.bootstrap-select button{
    height: 30px;
}

table input, table select{
     width:100% !important;
     height:100%;
     padding:0;
     margin:0 !important;
     padding:0px !important;
     text-align:center;

 }
 .inputpicker-overflow-hidden{
  height:100%;
 }
</style>
<script>
 var viewUrl =  "<?= base_url('receive-order')?>";
 var createUrl =   "<?= site_url('/order/create-order-2')?>";
 var productInfoUrl =  "<?= site_url('/product/get')?>";
 var productSearchUrl = "<?= site_url('/product/search-by-sale-code-with-special')?>";
 var customerSearchUrl = "<?= site_url('/customer/search-by-name')?>";
 var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
 var baseUrl =  "<?= base_url('')?>";
 var customerDepartmentUrl = "<?= base_url("order/get-department") ?>";
 var departmentCustomerUrl = "<?= base_url("order/get-customer") ?>";
 var customerProductSetUrl = "<?= base_url("customer/get-productset") ?>";
 var productSetUrl = "<?= base_url("productset/get-information") ?>";
  var base_id = "<?= $base_id ?>";
  var is_customer = <?= $is_customer ?>;
</script>