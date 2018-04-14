<style>
table input{
  width:calc(100% - 2px) !important;
  border: 1px solid #878898 !important;
  margin:1px !important;
  height:32px;
  }

textarea {
  resize: vertical; /* user can resize vertically, but width is fixed */
}
textarea:first-child{
  margin-bottom:9px;
}
#no-order-invoice p{
  margin-top:0;
  margin-left:0;
  font-size:inherit;
}
#no-order-invoice{
  margin:0;
}
.tooltip{
  width:180px;
  border-radius:2px !important;
}
</style>
<div class="wrapper-contain order">

<div class="row">
  <div class="col-md-8"> 
    <h3>請求書　新規作成</h3>
  </div>
  <div class="right">
    <a href="<?php echo site_url('sale') ?>" class="print top-print">MENU画面へ</a>
  </div>
</div>
 <form class="form-horizontal" role="form" id="no-order-invoice" >
    <fieldset>
<div class="first-row">
<div class="row">
        <div class="form-group">
          <label  class="col-sm-2 control-label">請求伝票No:</label>
          <div class="col-sm-3">
            <input class="form-control" name="invoice_vs" disabled="disabled" style="background:#fff;border:none;">
            <input class="form-control" name='invoice_id' id="invoice_id" type="hidden" readonly value="<?php echo($invoice_id) ?>">
          </div>
        </div>
</div>
<div class="row">
    <div class="form-group">
          <label  class="col-md-2 control-label" style="line-height:0.9">起票者:</label>
          <div class="col-md-3">
        <input value="<?php echo($_SESSION['login-info'][U_NAME]) ?>" disabled style="background:none;border:none;"/>
        <input type="hidden" name="user_id" id="user_id" value="<?php echo($_SESSION['login-info'][U_ID]) ?>">
        <input type="hidden" name="base_id" id="base_id" value="<?php echo($_SESSION['login-info'][SL_BASE_CODE]) ?>">
          </div>
        </div>
</div>
<div class="row">
      <div class="form-group">
          <label  class="col-md-2 control-label">作成日:</label>
          <div class="col-md-3">
           <span class="form-control form-control-input" style="margin-bottom:9px;">
           <input name="date" id="date_create" value="<?php echo(date('Y/m/d')) ?>" readonly>
           <span class=" icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
</div>   
<div class="row">
        <div class="form-group">
          <label  class="col-md-2 control-label">得意先:</label>
          <div class="col-md-3">
             <input type="text" id="cus_name" name="customer" class="form-control">
          </div>
        </div>
</div>
<div class="row">
        <div class="form-group">
          <label  class="col-md-2 control-label">部署名:</label>
          <div class="col-md-3">
           <input type="text" id="department_name" name="department" class="form-control">
          </div>
        </div>
</div> 
<div class="row">
        <div class="form-group">
          <label  class="col-md-2 control-label">得意先住所:</label>
          <div class="col-md-7">
           <textarea class="form-control" rows="2" name="address" id="address"></textarea>
          </div>
        </div>
</div>
<div class="row">
        <div class="form-group">
          <label  class="col-md-2 control-label">請求期間:</label>
          <div class="col-md-3">
            <span class="form-control form-control-input" style="margin-bottom:9px;">
              <input name="start_date" id="paid_date_start" readonly>
              <span class=" icon-large icon-calendar "></span>
            </span>
          </div>

          <label class="col-md-2 control-label center"> <span id="character">~</span></label>
          <div class="col-md-3">
            <span class="form-control form-control-input" style="margin-bottom:9px;">
              <input name="end_date" id="paid_date_end" readonly>
              <span class=" icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
</div>
<div class="row">
  <div class="form-group">
  <label for="comment" class="control-label col-md-2">発行元:</label>
    <div class="col-md-7">    
      <div>  
      <p><?php echo($base_master->{BM_COMPANY_NAME}); ?><p>
      <p><b>〒</b><?php echo ($base_master->{BM_POSTAL_CODE}); ?></p>
      <p><b>TEL:</b> <?php echo ($base_master->{BM_PHONE_NUMBER}); ?> <b>FAX:</b> <?php echo ($base_master->{BM_FAX_NUMBER}); ?></p> 
      </div>
      <!-- </textarea> -->
    </div>
  </div>
</div>
<div class="row">
  <div class="form-group">
  <label for="comment" class="control-label col-md-2">備考:</label>
    <div class="col-md-7">    
      <textarea class="form-control" rows="2" name="remark" id="remark"></textarea>
    </div>
  </div>

</div>
</div><!--End first row-->

<div class="row sec-row">
		<table class="no-order-table " id="add-revenues-2">
			<thead>
				<tr>
					<th style="width:10%">商品コード</th>
					<th>商品名</th>
					<th style="width:10%">規格</th>
					<th style="width:10%">カラー</th>
					<th style="width:10%">数量</th>
					<th style="width:10%;">単価</th>
					<th style="width:10%;">金額</th>
				</tr>
			</thead>
			<tbody>
				<tr class="product">
					<td>
              <div class="wrap">
                <span class="input-triangle"><b></b></span>
                <input class="product_id" name="product_id"/>
                <input type="hidden" class="real_id"/>
              </div>

          </td>
					<td data-name class="name"></td>
					<td data-standard></td>
					<td data-color></td>
					
					<td data-amount><input style="text-align: right;" class="amount" type="text" name="amount"/></td>
          <td data-price class="sell_price"></td>
					<td data-sum class="price"></td>
				</tr>
        <?php if($tax > 0){ ?>
        <tr class="tax">
          <td>消費税(%)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td><?php echo $tax ?><input type="hidden" id="tax" value="<?php echo($tax) ?>"></td>
        </tr>
        <?php }else{ ?>
        <input type="hidden" id="tax" value="0">
        <?php } ?>
				 <tr class="sum-col">
					<td>合計</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td id="total_price"></td>
				</tr>
			</tbody>
		</table>
</div>
<div class="row first-row  margin-bottom-table">
	<a class="print left" id="insert-revenue-2">行挿入 </a>
	<a class="print left" id="remove-revenue-2">行削除 </a>
	<a href="#dialog-form" class="print save-revenue-2 right">保存 </a>
	<!--<a href="#dialog-form" class="print right save-temp-2">一時保存 </a> -->
</div>
<div class="row margin-bottom-table margin-top-table ">
	<a style="float:right" class="print back">戻る  </a>
</div>

</fieldset>

</form>
</div>
<script>
  var base_url = '<?php echo(base_url()) ?>';
  var json_product_list = <?php echo json_encode($product_list); ?>;
  //console.log(list_product);
</script>