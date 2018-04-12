<style>

table input{
  width:calc(100% - 2px) !important;
  border: 1px solid #878898 !important;
  margin:1px !important;
  height:32px;
  }
/*Edit column table*/
.order .edit-table th:nth-child(7), .edit-table th:nth-child(8){
  width:auto;
}
</style>
<div class="wrapper-contain purchase edit-purchase order">
<input type="hidden" id="voter-id" value="<?php echo $_SESSION['login-info'][U_ID]; ?>">
<input type="hidden" id="user_base" value="<?php echo $_SESSION['login-info'][U_BASE_CODE]; ?>">
<div class="row">
	<div class="col-md-8"> 
		<h3>出庫伝票　新規作成</h3>
	</div>
	<div class="right">
		<a href="<?php echo site_url('purchase') ?>" class="print top-print">MENU画面へ</a>
	</div>
</div>
<form class="form-horizontal" role="form" name="add_export_order" >
    <fieldset>
<div class="first-row">
    
        <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">出庫No:</label>
          <div class="col-md-8">
            <input class="hide-input" type="text" value="" disabled>
            <input class="hide-input warehouse_id" type="hidden" value="<?php echo($max_id) ?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">起票者:</label>
          <div class="col-md-8">
			  <input value="<?php echo $_SESSION['login-info'][U_ID]; ?>" disabled style="background:none;border:none;"/>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">出庫者:</label>
          <div class="col-md-8">
            <select id="issuer" class="form-control first-opt-hidden">
              <option value=''></option>
              <?php foreach ($warehouse_person as $person){ ?>
              <?php if($person->{UX_NAME}!=''){ ?>
              <option value="<?php echo $person->{UX_ID} ?>"><?php echo $person->{UX_NAME}; ?></option>
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
          <label for="inputEmail" class="col-md-4 control-label">出庫日:</label>
          <div class="col-md-8">
			<span class="form-control form-control-input" style="margin-bottom:9px;">
            <input readonly class="datepicker_" value="<?php echo(date('Y/m/d')) ?>">
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
            <select class="input__select__control form-control SALES_DESTINATION_SELECT first-opt-hidden" name="SALES_DESTINATION_id" style="width:100%;" >
              <option value=''></option>
              <!--<option disabled selected value></option>
              <?php foreach($Sales_Destinations as $T_SALES_DESTINATION){ ?>
              <option value="<?php echo $T_SALES_DESTINATION->id ?>"><?php echo $T_SALES_DESTINATION->{TSD_DISTRIBUTOR_NAME} ?></option>
              <?php } ?>-->
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
            <select class="no-bottom-margin form-control content-processing first-opt-hidden" name="processing-content">
              <option></option>
              <?php foreach($processing_list as $processing){ ?>
              <option value="<?php echo $processing->{PC_ID} ?>" >
                <?php echo $processing->{PC_PROCESSING_CONTENT} ?>  
              </option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-6 row">
        <div class="form-group col-sm-6">
          <label for="inputEmail" class="col-md-4 control-label" name="stock">在庫場所</label>
          <div class="col-md-8">
            <select class="no-bottom-margin first-opt-hidden form-control stock_from" <?php //if(!$isAdmin) echo "disabled"; ?> name="stock_from">
              <?php if($isAdmin){ ?><option></option><?php } ?>
              <?php foreach($base_list_1 as $base){ ?>
              <option value="<?php echo($base->{BM_BASE_CODE}) ?>"><?php echo($base->{BM_BASE_NAME}) ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group col-sm-6" id="stock_to" style="display: none">
          <label for="inputEmail" class="col-md-4 control-label">移動先</label>
          <div class="col-md-8">
            <select class="no-bottom-margin form-control stock_to" name="stock_to">
              <option></option>
              <?php foreach($base_list_2 as $base){ ?>
              <option value="<?php echo($base->{BM_BASE_CODE}) ?>"><?php echo($base->{BM_BASE_NAME}) ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>
    
    
</div>
<div class="sec-row">
 <table class="no-order-table" id="export-table">
    <thead>
        <tr>
            <th width="10%">商品コード</th>
            <th width="20%">商品名</th>
            <th>色調</th>
            <th>規格</th>
            <th>単価円</th>
            <th>現貯蔵品数</th>
            <th style="width:10%;">出庫数</th>
            <th width="10%">合計円</th>
        </tr>
    </thead>
    <tbody id="warehouse_table">
		<tr class='product'>
            <td>
             <div class="wrap">
                <span class="input-triangle"><b></b></span>
                <input class="product_id" disabled="disabled" name="product_id"/>
                <input class="real_id" type="hidden">
              </div>

            </td>
            <td class="product_name" data-name></td>
            <td class="color" data-color></td>
            <td class="standard" data-standard></td>
            <td class="price" data-price></td>
            <td class="total_stock_product" data-stock></td>
            <td data-amount><input class="amount_export" disabled="disabled" value="" type="text" name="amount_export"/></td>
            <td class="total_price"></td>
        </tr>
		    <tr class="sum-col">
            <td>合計</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td id="sum">0</td>
        </tr>
    </tbody>
</table> 
</div>
<div class="sec-row margin-top-table">
	<label class="" for="comment">備考</label>
	<textarea class="form-control note" name="comment" rows="5" id="comment"></textarea>
</div>

<div class="row first-row" >
	<a class="print left" id="insert-export-row">行挿入 </a>
	<a href="" class="print left" id="remove-export-row">行削除</a>
	<a class="print add-export-order right">保存 </a>
</div>

</fieldset>
</form>
</div>

<script>
  var base_url = "<?php echo base_url() ?>";
  var sales_des_list = <?php echo(json_encode($Sales_Destinations)) ?>;
</script>
