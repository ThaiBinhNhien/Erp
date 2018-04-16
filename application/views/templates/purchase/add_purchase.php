<style>

table input{
  width:calc(100% - 2px) !important;
  border: 1px solid #878898 !important;
  margin:1px !important;
  height:32px;
}


</style>
<div class="wrapper-contain add-purchase purchase edit-purchase order">
<div class="row">
<div class="col-md-8"> 
    <h3>発注伝票　新規作成 </h3>
</div>
<div class="right">
    <a href="<?php echo site_url('purchase') ?>" class="print top-print">MENU画面へ</a>
    </div>
</div>
    <form class="form-horizontal" role="form"  name="add_purchase_order">
<fieldset>
<div class="first-row">

    <div class="row">
      <?php //var_dump($supplier);?>
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">発注No:</label>
          <div class="col-md-8">
            <input class="hide-input" type="text" value="" disabled>
            <input class="hide-input order_id" type="hidden" name="code" disabled value="<?php echo($max_id) ?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">起票者:</label>
          <div class="col-md-8">
    			  <input class="input__select__control" type="text" disabled value="<?php echo($_SESSION['login-info'][U_ID]) ?>" style="background:none;border:none;" name="issuer"/>
            <input type="hidden" id="user_id" value="<?php echo($_SESSION['login-info'][U_ID]) ?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">発注日:</label>
          <div class="col-md-8">
			      <span class="form-control form-control-input " style="margin-bottom:9px;">
            <input readonly id="date_create" class="datepicker_ input__select__control" value="<?php echo(date('Y/m/d')) ?>" name="order_date">
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
            <span class="form-control form-control-input " style="margin-bottom:9px;">
            <input readonly id="date_delivery" class="datepicker_ input__select__control" value="<?php echo(date('Y/m/d')) ?>" name="date_delivery">
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
            <select style="width:100%;" class="right-3 form-control" id="supplier_id" name="supplier">
              <option></option>
            <?php foreach($supplier_list as $supplier){ ?>
            <?php if($supplier->{SUP_ID}!=0){ ?>
              <option value="<?php echo($supplier->{SUP_ID}) ?>">
                <?php echo($supplier->{SUP_SUPPLIER_COMPANY_NAME}) ?>
              </option>
            <?php } ?>
            <?php } ?>
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
            <select disabled style="width:100%;" class="right-3 form-control" id="sales_des_id" name="sales_destination">
              <?php foreach ($sales_des_list as $sales_des){ ?>
              <?php if($sales_des->{TSD_OUTSOURCING}==0){?>
              <option value="<?php echo($sales_des->{TSD_ID}) ?>"><?php echo $sales_des->{TSD_DISTRIBUTOR_NAME} ?></option>
              <?php } ?>
              <?php } ?>
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
            <select class="form-control" name="content" id="content_id">
            <?php foreach($order_content_list as $order_content){ ?>
              <option value="<?php echo($order_content->{PC_ID}) ?>">
                <?php echo($order_content->{PC_PROCESSING_CONTENT}) ?>
              </option>
            <?php } ?>
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
            <select class="form-control first-opt-hidden" id="stock_id" name="place_of_delivery" <?php if(!$isAdmin) echo 'disabled'; ?>>
              <?php if($isAdmin){ ?><option disabled selected></option><?php } ?>
              <?php foreach($base_list as $base){ ?>
              <option value="<?php echo($base->{BM_BASE_CODE}) ?>">
                <?php echo($base->{BM_BASE_NAME}) ?>
              </option>
              <?php } ?>
              <?php if($isAdmin){ ?><option value="0">規定外</option><?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-8 col-lg-8">
        <div class="form-group">
          <label  class="col-md-2 control-label"></label>
          <div class="col-md-8">
            <input disabled style="width:100%;" class="right-3 input__select__control" id="stock_address" name="other_place_of_delivery"/>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">形態:</label>
          <div class="col-md-8">
            <input class="input__select__control" style="width:100%;border:1px solid white;background:white;" value="未承認" disabled/>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">入庫:</label>
          <div class="col-md-8">
            <input class="input__select__control" style="width:100%;border:1px solid white;background:white;" disabled value="未"/>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">承認者:</label>
          <div class="col-md-8">
          <!--  <input style="width:100%;border:none;" value="未"/>-->
          </div>
        </div>
      </div>
    </div>
    
</div>
<div class="wrapper-table" id="add-purchase-table" >
 <table class="no-order-table">
    <thead>
        <tr>
            <th style="width:10%">商品コード</th>
            <th style="width:18%">商品名</th>
            <th style="width: 9%">色調</th>
            <th style="width: 11%">規格</th>
            <th  style="width: 9%">数量</th>
            <th style="width: 10%">入庫累計</th>
            <th style="width: 10%">仕入単価</th>
            <th style="width: 9%">金額（円）</th>
            <!--<th>入庫日</th>-->
            <th style="width: 14%">コメント</th>
        </tr>
    </thead>
    <tbody>
    	<tr class='product'>
            <td>
              <div class="wrap">
                <span class="input-triangle"><b></b></span>
                <input class="product_id" name="product_id" disabled="disabled" autocomplete="off"/>
                <input class="real_id" type='hidden'>
              </div>
            </td>
            <td class="product_name" data-name></td>
            <td data-color></td>
            <td data-standard></td>
            <td><input type="text" class="amount" disabled="disabled"/></td>
            <td data-accumulation></td>
            <td class="price_unit" data-price-unit></td>
            <td class="price"></td>
            <td><input class="comment_product" type="text" name="comment" disabled="disabled"/></td>
        </tr>
       
		<tr class="sum-col">
			<td colspan="7" style="text-align:right;font-weight:bold;" >合計</td>
           
			<td class="sum-price"></td>
			<td></td>
        </tr>
        <tr class="sum-col no-pad">
            <td colspan="7" style="text-align:right;font-weight:bold;" > 値引(%)</td>
           
			<td><input class="vat discount" value="0" name="discount"></td>
			<td></td>
        </tr>
        <tr class="sum-col">
            <td colspan="7"  style="text-align:right;font-weight:bold;" >総合計</td>
           
			<td class="sum-total"></td>
			<td></td>
        </tr>
    </tbody>
</table> 
</div>

<div class="sec-row margin-top-table">
 	<label class="" for="comment">備考</label>
 	<textarea class=" form-control" rows="5" id="comment" name="comment"></textarea>
</div>
<div class="row first-row">
	<a class="print" id="insert-row-purchase"><!--<i class="fa fa-exchange" aria-hidden="true"></i>-->行挿入</a>
	<a href="" class="print" id="remove-row-purchase"><!--<i class="fa fa-trash"></i>-->行削除 </a>
	<label class="right" style="margin-right:8px;;display:inline;width:auto !important;height:auto !important;"><input disabled type="checkbox" checked id="request_to_confirm" style="height:auto;width:auto;padding-top:2px;margin-right:10px;">承認を依頼する</label>   
</div>
<div class='row margin-bottom-table'>
	<a class="print right" id="create-purchase-order"><!--<i class="fa fa-plus"></i>-->保存 </a>
	<a id="save-provisional" class="print right">一時保存 </a>
	</div>
</fieldset>
    </form>
</div>

<script type="text/javascript">
  var base_url = "<?php echo(base_url()) ?>";
  var sales_des_list = <?php echo(json_encode($sales_des_list)) ?>;
</script>