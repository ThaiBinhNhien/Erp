<div class="wrapper-contain order edit-order-2">
<div class="row" >
<div class="col-md-8"> 
    <h3>注文伝票　編集</h3>
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
          <label  class="col-md-4 control-label">注文No:</label>
          <div class="col-md-8">
            <input class="hide-input" type="text" value="<?= $master[SL_ID] ?>" name="order_no" disabled>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label name="lb-issuer" class="col-md-4 control-label">起票者:</label>
          <div class="col-md-8">
			  <input value="帝王太郎" disabled name="issuer" class="hide-input"/>
			
          </div>
        </div>
      </div>
    </div>
        <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">注文日:</label>
          <div class="col-md-8">
			<span class="form-control form-control-input bottom-margin">
            <input  class="mydatepicker" readonly value="" id="order_date" name="order_date">
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
            <select class="selectpicker " data-live-search="true" disabled="" name="customer" data-live-search-placeholder="Search" id="customer">
            <?php foreach ($list_customer as $key => $value) {
              echo '<option value="'.$value[CUS_ID].'" '.($value[CUS_ID]==$master[SL_CUSTOMER_ID]?'selected':'').' >'.$value[CUS_CUSTOMER_NAME].'</option>';
              
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
            <select class="form-control" name="customer_department" data-previous="<?= $master[SL_DEPARTMENT_CODE] ?>" id="customer_department">
              <option value=""></option>
             <?php foreach ($department as $key => $value) {
              echo '<option value="'.$value[CD_DEPARTMENT_CODE].'" '.($value[CD_DEPARTMENT_CODE]==$master[SL_DEPARTMENT_CODE]?'selected':'').' >'.$value[DL_DEPARTMENT_NAME].'</option>';
            }
            ?>
            </select>
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
            <input  class="mydatepicker" readonl value="" id="delivery_date" name="delivery_date">
           <span class=" icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
      </div>
		
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label class="col-md-4 control-label">売上(納品)日:</label>
          <div class="col-md-8">
            <input disabled class="hide-input" />
          </div>
        </div>
      </div>
    </div>
    </fieldset>

</div>
<div class="row">
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row sec-row">
                    <table class="no-order-table edit-table" id="edit_order">
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
                            <?php $sum_total = 0;
                                    foreach ($detail['order_data'] as $key => $value) {
                                    $total = 0.0;
                                    $sum_total += $value[OD_QUANTITY];
                                    $disabled = "";
                                    if($value[PL_SPECIAL] == 1){
                                      $disabled = "disabled";
                                    }
                                    echo '<tr>';
                                    echo    '<td class="not-sum-row">';
                                    echo    '<input type="hidden" class="sp_id" value="'.$value['id'].'">';
                                   /* echo     '<select class="selectpicker productselect" name="product_item_'.$key.'" data-live-search="true" data-live-search-placeholder="Search" id="first_data" >';
                                             foreach ($list_product as $item) {
                                              echo '<option value="'.$item[PL_PRODUCT_ID].'" '.($item[PL_PRODUCT_ID]==$value[OD_PRODUCT_CODE]?'selected':'').' >'.$item[PL_PRODUCT_CODE_SALE].'</option>';
                                            }
                
                                    echo    '</select>';*/
                                    echo    '<input class="form-control product_id" type="hidden" name="product_id"  value="'.$value[OD_PRODUCT_CODE].'"  />';
                                    echo    '<input class="form-control productselect1" name="product_item_'.$key.'" value="'.$value[PL_PRODUCT_CODE_SALE].'" id="first_data" />';
                                    echo    '</td>';

                                    echo    '<td class="not-sum-row">'.$value[PL_PRODUCT_NAME].'</td>';
                                    echo    '<td class="not-sum-row">'.$value[PL_STANDARD].'</td>';
                                    echo    '<td class="not-sum-row">'.$value[PL_COLOR_TONE].'</td>';
                                    echo    '<td class="not-sum-row">'.$value[PL_NUMBER_PACKAGE].'</td>';
                                    echo    '<td class="not-sum-row addition"><input type="text" '.$disabled.' class="quantity_input" name="'.$key.'_quantity" value="'.number_format($value[OD_QUANTITY],2).'"/></td>';
                                    echo '</tr>';
                            } ?>
                            <tr class="sum-col">
                                <td>合計</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?= number_format($sum_total,2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
		<div class="row wrapper-textarea">
			<label>備考</label>
			<textarea id="note" class="form-control" rows="5"><?= $master[SL_SUMMARY] ?></textarea><br />
			</div>
		</div>
		<div class="row margin-bottom-table">
			<a href="" class="print left" id="insert">行挿入 </a>
			<a href="" class="print left" id="remove">行削除 </a> 
			<a href="#dialog-form" id="save_order" class="print save_order right">保存 </a> 
			<a href="<?php echo site_url('order/detail-order-2');?>" class="print right " >戻る </a>
		</div>
	</div>
</div>
</form>
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
    width: 100%;
    line-height: 18px;
}
.bootstrap-select button{
    height: 30px;
}
table input{
    width:40px !important;
    padding:2px !important;
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
    var order_date = new Date("<?= $master['order_date'] ?>");
    var delivery_date = new Date("<?= $master['delivery_expected'] ?>");
    var createUrl =   "<?= site_url('/order/create-order')?>";
    var productInfoUrl =  "<?= site_url('/product/get')?>";
    var productSearchUrl = "<?= site_url('/product/search-by-sale-code-with-special')?>";
    var customerSearchUrl = "<?= site_url('/customer/search-by-name')?>";
    var baseUrl =  "<?= base_url('')?>";
    var master_id = "<?= $master['id']?>";
    var editUrl = "<?= site_url('/order/edit-order-2')?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var numberRow = <?= count($detail['order_data']) ?>;
    var customerDepartmentUrl = "<?= base_url("customer/get-department") ?>";
    var viewUrl =  "<?= base_url('receive-order')?>";
    var date_update = "<?= $master[SL_UPDATE_DATE] ?>";
    <?php
    echo "var list_product = ". json_encode($list_product) . ";";
    ?>
     var base_id = "<?= $base_id ?>";
      var is_customer = <?= $is_customer ?>;
</script>