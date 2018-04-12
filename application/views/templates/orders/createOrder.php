<style>
.wrapper-contain form{
    margin:0 !important;
}
.inputpicker-overflow-hidden{
  height:100%;
 }
 
td.headcol,td.sec-col,td.thi-col,td.for-col,td.fif-col,td.six-col,td.sev-col{
  height:32px;
 }
td,th{
  height:32px;
}
th{
  line-height: 32px;
}
.sum-col .headcol,.sum-col .six-col,.sum-col .sev-col{
  line-height: 2.5;
}
</style>
<div class="wrapper-contain order create-order detail-order">
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
            <input class="hide-input" id="order_no" type="text" disabled  value="">
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">起票者:</label>
          <div class="col-md-8">
			  <input value="帝王太郎" disabled class="hide-input"/>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">発注日:</label>
          <div class="col-md-8">
			<span class="form-control form-control-input bottom-margin">
            <input  class="orderDate" name="order_date" id="order_date" readonly="">
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
            <select class="selectpicker customer_valid" name="customer" <?= count($list_customer) == 1?'disabled':'' ?> data-live-search="true" title="" data-live-search-placeholder="Search" id="customer">
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
          <label  class="col-md-4 control-label">納品予定日:</label>
          <div class="col-md-8">
            <span class="form-control form-control-input bottom-margin">
            <input  class="orderToDate" name="delivery_expected" id="delivery_expected" readonly>
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
        <a href="#" class="print" id="btn_prouduct_set" style="margin:0;">表示</a>	
      </div>
      
    </div>
	<div class="row">
      <div class="col-sm-5 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">売上(納品)日:</label>
          <div class="col-md-8">
            <input disabled class="hide-input" />
          </div>
        </div>
      </div>
      <div class="col-sm-5 col-md-4 col-lg-4">
        <div class="form-group">
            <label  class="col-md-4 control-label">自:</label>
            <div class="col-md-3">
              <input type="number" class="from_valid floor_from" id="floor_from" value="0" />
            </div>
            <label  class="col-md-2 control-label" style="width: 11.8%;" >至:</label>
            <div class="col-md-3">
              <input type="number" class="floor_to" id="floor_to" value="0" />
            </div>
          </div>
          
      </div>
      <div class="col-sm-2 col-md-1 col-lg-1">
        <a href="#" id="add_floor" class="print" style="margin: 0;" >フロア作成</a>  
      </div>
    </div>
    </fieldset>
  
</div>
 <div class="row sec-row  scroll-table">

		<table class="" id="create-table">
    <thead>
    <!--    <th>商品ID</th>
        <th>商品名</th>
        <th>規格</th>
        <th>カラー</th>
        <th>結束単位</th>
        <th class="addition">追加</th>
        <th>合計</th> -->
        <tr>
          <th class="headcol">商品ID</th>
          <th class="sec-col">商品名</th>
          <th class="thi-col">規格</th>
          <th class="for-col">カラー</th>
          <th class="fif-col">結束単位</th>
          <th class="addition temp"></th>
          <th class="six-col addition_col">追加</th>
          <th class="sev-col" >合計</th>
        </tr>
    </thead>
    <tbody>
      <tr>
        <td class="headcol">
          <!-- <select class="selectpicker productselect" data-live-search="true" title="" name="product_item" data-live-search-placeholder="Search" id="first_data" >
            <?php foreach ($list_product as $key => $value) {
              echo '<option value="'.$value[PL_PRODUCT_ID].'">'.$value[PL_PRODUCT_CODE_SALE].'</option>';
            }
            ?> -->
            <input class="form-control product_id" type="hidden" name="product_id" value=""  />
            <input class="form-control productselect1" name="product_item" value="" id="first_data" />
      
        </td>
        <td class="sec-col"></td>
        <td class="thi-col"></td>
        <td class="for-col"></td>
        <td class="fif-col"></td>
        <td class="temp"></td>

        <td class="six-col addition"><input name="addition0" type="text"/></td>
        <td class="sev-col" ></td>
      </tr>
       <tr class="sum-col">
        <td class="headcol">合計</td>
        <td class="sec-col"></td>
        <td class="thi-col"></td>
        <td class="for-col"></td>
        <td class="fif-col"> </td>
        <td class="temp"></td>
        <td class="six-col" id="sum_addition"></td>
        <td class="sev-col"></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="row wrapper-textarea">
	<label>備考</label>
	<textarea id="note" class="form-control" rows="5"></textarea><br />
</div>
  </form>
<div class="row margin-bottom-table">
	<a href="#" class="print left" id="insert">行挿入 </a>
	<a href="" class="print left" id="remove">行削除 </a>
	<a href="#dialog-form" class="print save-new-order right">保存 </a>
	<a href="#dialog-form" class="print save-temp-order right">一時保存 </a> 
</div>
	<div class="row margin-bottom-table margin-top-table ">
		<a href="<?php echo site_url('/receive-order');?>" class="print right">戻る  </a>
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
   // height: 30px;
}

</style>
<script>
 var viewUrl =  "<?= base_url('receive-order')?>";
 var createUrl =   "<?= site_url('/order/create-order')?>";
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
 var is_customer = "<?= $is_customer ?>";

</script>