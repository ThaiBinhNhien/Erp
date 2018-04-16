<style>
.wrapper-contain form{
    margin:0 !important;
}
.inputpicker-overflow-hidden{
  height:100%;
 }
th{
  line-height: 32px;
}
.full-width{
    width:557px;
    min-width:40px;
}
.scroll-table td{

}
input::-ms-clear {
    display: none;
}
.floor_input{
  min-width:40px !important;
}
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
<div class="wrapper-contain order edit-order detail-order">
<div class="row">
<div class="col-md-8 col-sm-8"> 
    <h3 >注文伝票　編集</h3>
</div>
<div class="right">
    <a href="<?php echo site_url('receive-order') ?>" class="print top-print">MENU画面へ</a>
    </div>
</div>
<form class="form-horizontal " role="form" id="order_form"  >
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
          <label name="lb-deliver" class="col-md-4 control-label">起票者:</label>
          <div class="col-md-8">
			  <input value="<?= $master['user_name'] ?>" disabled name="deliver" class="hide-input"/>
          </div>
        </div>
      </div>
    </div>
        <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">注文日:</label>
          <div class="col-md-8">
			<span class="form-control form-control-input bottom-print">
            <input  class="mydatepicker" readonly  value="" name="order_date" id="order_date">
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
                  echo '<option value="'.$value[CD_DEPARTMENT_CODE].'" data-base="'.$value["base_code"].'" '.($value[CD_DEPARTMENT_CODE]==$master[SL_DEPARTMENT_CODE]?'selected':'').' >'.$value[DL_DEPARTMENT_NAME].'</option>';
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
            <span class="form-control form-control-input bottom-print">
            <input  class="mydatepicker" value="" name="delivery_date" readonly id="delivery_date">
           <span class=" icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
      </div>
    </div>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">売上(納品)日:</label>
          <div class="col-md-8">
            <input disabled class="hide-input" />
          </div>
        </div>
      </div>
    </div>
    </fieldset>

</div>
<div class="row" >
                    <div class="row sec-row scroll-table">
                    <table class="" id="edit_order">
                      <thead>
                            <tr>
                                <th class="headcol width-th">商品ID</th>
                                <th class="sec-col width-th">商品名</th>
                                <th class="thi-col width-th">規格</th>
                                <th class="for-col width-th">カラー</th>
                                <th class="fif-col width-th">結束単位</th>
                                <?php foreach($detail['floor'] as $value){
                                      $width = "auto";
                                        if(count($detail['floor']) ==1 ){
                                            $width = "100%";
                                        }
                                        echo '<th width="'.$width.'"" class="width-th" data-floor="'.$value[F_FLOOR_NAME].'">'.$value[F_FLOOR_NAME].'</th>';
                                    }?>
                                <th class="six-col width-th">追加</th>
                                <th class="sev-col width-th">合計</th>
                            </tr>
                        </thead> 
                        <tbody>
      
                            <?php $sum_total = 0;
                                  $addition = 0;
                                    foreach ($detail['order_data'] as $key => $value) {
                                    $total = 0.0;
                                    $addition += $value[OD_ADD];
                                    $disabled = "";
                                    if($value[PL_SPECIAL] == 1){
                                      $disabled = "disabled";
                                    }
                                    echo '<tr>';
                                    echo    '<td class="headcol not-sum-row">';
                                    echo    '<input type="hidden" class="sp_id" value="'.$value[OD_ID].'">';
                                    /*echo     '<select class="selectpicker productselect" name="product_item_'.$key.'" data-live-search="true"  data-live-search-placeholder="Search" id="first_data" >';
                                             foreach ($list_product as $item) {
                                              echo '<option value="'.$item[PL_PRODUCT_ID].'" '.($item[PL_PRODUCT_ID]==$value[OD_PRODUCT_CODE]?'selected':'').' >'.$item[PL_PRODUCT_CODE_SALE].'</option>';
                                            }
                
                                    echo    '</select>';*/
                                    echo    '<input class="form-control product_id" type="hidden" name="product_id" value="'.$value[OD_PRODUCT_CODE].'"  />';
                                    echo    '<input class="form-control productselect1" name="product_item_'.$key.'" value="'.$value[PL_PRODUCT_CODE_SALE].'" id="first_data" />';
                                    echo    '</td>';

                                    echo    '<td class="sec-col not-sum-row">'.$value[PL_PRODUCT_NAME].'</td>';
                                    echo    '<td class="thi-col not-sum-row">'.$value[PL_STANDARD].'</td>';
                                    echo    '<td class="for-col not-sum-row">'.$value[PL_COLOR_TONE].'</td>';
                                    echo    '<td class="fif-col not-sum-row">'.$value[PL_NUMBER_PACKAGE].'</td>';

                                        foreach($detail['floor'] as $index => $item){
                                            echo '<td data-floor="'. $item[F_FLOOR_NAME] .'"><input type="text" '.$disabled.' class="floor_input" name="'.$key.'_'.$item[F_FLOOR_NAME].'" value="'.$value[$item[F_FLOOR_NAME]].'" /></td>';
                                            $total += $value[$item[F_FLOOR_NAME]] == ''?0:$value[$item[F_FLOOR_NAME]];
                                            $sum_total += $value[$item[F_FLOOR_NAME]] == ''?0:$value[$item[F_FLOOR_NAME]];
                                            
                                            if(isset($detail['floor'][$index]['total']))
                                                $detail['floor'][$index]['total'] +=  $value[$item[F_FLOOR_NAME]];
                                            else
                                                $detail['floor'][$index]['total'] = $value[$item[F_FLOOR_NAME]];
                                        }
                                    $total += $value[OD_ADD];
                                    $sum_total += $value[OD_ADD];
                                    if($total == 0 && $value[OD_QUANTITY] == 1){
                                            $total = 1;
                                            $sum_total += 1;
                                        }   
                                    echo    '<td class="six-col not-sum-row addition"><input type="text" '.$disabled.' class="input_addition" name="addition$key" value="'.$value[OD_ADD].'"/></td>';
                                    echo    '<td class="sev-col not-sum-row">'.number_format($total,2).'</td>';
                                    echo '</tr>';
                            } ?>
                            <tr class="sum-col">
                                <td class="headcol">合計</td>
                                <td class="sec-col"></td>
                                <td class="thi-col"></td>
                                <td class="for-col"></td>
                                <td class="fif-col"></td>
                                <?php foreach($detail['floor'] as $value){
                                        echo '<td data-floor="'. $value[F_FLOOR_NAME] .'">'.number_format($value['total'],2).'</td>';
                                }?>
                                <td id="sum_addition" class="six-col"><?= number_format($addition,2)?></td>
                                <td class="sev-col"><?= number_format($sum_total,2)?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row wrapper-textarea">
                    <label>備考</label>
                    <textarea class="form-control" rows="5" id="note"><?= $master[SL_SUMMARY] ?></textarea><br />
                    </div>
                <div class="row margin-bottom-table">
                    <div class="">
                    <a href="" class="print left" id="insert">行挿入  </a>
                    <a href="" class="print left" id="remove">行削除  </a>
                   
                    <a href="#dialog-form" class="print right" id="save_order">保存  </a>  
                     <a href="<?php echo site_url('order/detail-order?id=');?><?= $master[SL_ID] ?>" class="print right">戻る   </a>
                </div>
                </div>
</div>
</form>
</div>
<style type="text/css" media="screen">

/*.form-group button {
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
*/
</style>
<script>
    var order_date = new Date("<?= $master[SL_SALES_DATE] ?>");
    var delivery_date = new Date("<?= $master[SL_DELIVERY_DATE] ?>");
    var createUrl =   "<?= site_url('/order/create-order')?>";
    var productInfoUrl =  "<?= site_url('/product/get')?>";
    var productSearchUrl = "<?= site_url('/product/search-by-sale-code-with-special')?>";
    var customerSearchUrl = "<?= site_url('/customer/search-by-name')?>";
    var baseUrl =  "<?= base_url('')?>";
    <?php
    echo "var floor_array = ". json_encode($detail['floor']) . ";";
    echo "var list_product = ". json_encode($list_product) . ";";
    ?>
    var viewUrl =  "<?= base_url('receive-order')?>";
    var master_id = "<?= $master[SL_ID]?>";
    var editUrl = "<?= site_url('/order/edit-order')?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var numberRow = <?= count($detail['order_data'])?>;
    var customerDepartmentUrl = "<?= base_url("customer/get-department") ?>";
    var date_update = "<?= $master[SL_UPDATE_DATE] ?>";
     var base_id = "<?= $base_id ?>";
      var is_customer = "<?= $is_customer ?>";
</script>
<!--End wrapper contain --->   

