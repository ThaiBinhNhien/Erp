<style>
.no-order-table th {
    padding: 10px 5px;
}
</style>
<?php
$sum_checklist = 0;
$count_checklist = 0;
?>
<div class="wrapper-contain order edit-order">
	<div class="row">
	<div class="col-md-8"> 
		<h3>注文伝票　納品・売上処理編集</h3>
	</div>
	<div class="right">
		<a href="<?php echo site_url('receive-order') ?>" class="print top-print">MENU画面へ</a>
		</div>
	</div>
  <form class="form-horizontal" role="form" id="form_delivery_edit"  >
<div class="first-row">
<fieldset>
	<div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">注文No:</label>
          <div class="col-md-8">
            <input class="hide-input" type="text" id="get_order_code" value="<?= $master[SL_ID] ?>" disabled>
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
            <input  class="datepicker_delivery hide-input" value="<?= $master['orderdate_print'] ?>" disabled >
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
			  <input class="hide-input" value="<?= $master[CUS_CUSTOMER_NAME] ?>" disabled/>
          </div>
        </div>
      </div>
		<div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label">部署:</label>
          <div class="col-md-8">
			     <input class="hide-input" value="<?= $master[DL_DEPARTMENT_NAME] ?>" disabled/>
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
            <input  class="datepicker_delivery_plan hide-input" value="<?= $master['deliveryexpected_date_print'] ?>" disabled>
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
            <span class="form-control form-control-input bottom-margin">
            <input type="hidden" id="set_delivery_date"  name="set_delivery_date" value="<?= $master['delivery_date_print']?>">
            <input class="datepicker_delivery_ship " readonly id="get_delivery_date" name="get_delivery_date">
           <span class="icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
      </div>
    </div>
    </fieldset>
    
</div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="row sec-row">
                <table class="no-order-table edit-table table-delivery" id="get_table_delivery">
                    <thead>
                        <tr>
                            <th width=8%>商品ID </th> 
                            <th>商品名</th>
                            <th width=8%>規格</th>
                            <th width=8%>COLOR</th>
                            <th width=8%>結束単位</th>
                            <th width=8%>注文数</th>
                            <th>納品数<br/><a id="delivery-order-copy">コピー</a>

                            <?php if($is_gaichyu == true) { 
                              if($is_gaichyu_login == true) {
                                ?>
                                <th width=8%>単価</th>
                                <?php
                              } else {
                              ?>
                              <th width=8%>売上単価</th> 
                              <th width=8%>外注専用単価</th>
                            <?php } } else { ?>
                              <th width=8%>単価</th>
                            <?php } ?>
                            <?php if($is_gaichyu_login == true) { ?>
                              <th width=8%>金額（外注）</th>
                            <?php } else { ?>
                              <th width=8%>金額（納品）</th>
                            <?php } ?>
                            

                            <th width=6%>チェック</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $sum_total = 0;
                        $total = 0;
                        foreach ($detail['delivery_data'] as $key => $value) {
                          $disable_value = "";
                          $count_checklist++;
                          if(isset($value[DD_CHECK]) && $value[DD_CHECK] == 1) {
                            $sum_checklist++;
                            $disable_value = "disabled";
                          }
                            echo '<tr>';
                            echo    '<td><input type="hidden" class="get_order_id" value="'.$value[OD_ID].'" /><input type="hidden" class="get_product_id" value="'.$value[DD_PRODUCT_CODE].'" />'.$value[PL_PRODUCT_CODE_SALE].'</td>';
                            $value_product_name = "";
                            if($value['product_name_delivery'] != null && $value['product_name_delivery'] != "") {
                              $value_product_name = $value['product_name_delivery'];
                            } else if($value['product_name_price'] != null && $value['product_name_price'] != "") {
                              $value_product_name = $value['product_name_price'];
                            } else {
                              $value_product_name = $value[PL_PRODUCT_NAME];
                            }
                            echo    '<td><input type="hidden" class="value_product_name" value="'.$value_product_name.'" />'.$value_product_name.'</td>';
                            echo    '<td>'.$value[PL_STANDARD].'</td>';
                            echo    '<td>'.$value[PL_COLOR_TONE].'</td>';
                            echo    '<td>'.$value[PL_NUMBER_PACKAGE].'</td>';
                            
                            if($value[PL_SPECIAL] != 1) {
                              echo    '<td class="copy">'.number_format(($value[OD_QUANTITY]+$value[OD_ADD]),2).'</td>';
                            }
                            else {
                                echo '<td></td>';
                            }
                            /* Quantity Delivery */
                            if($value[PL_SPECIAL] != 1) {
                              echo    '<td><input '.$disable_value.' type="number" name="get_product_quantity'.$key.'" class="valid_positive_number get_product_quantity" data-old="'.$value['quantity_delivery'].'" value="'.$value['quantity_delivery'].'" /></td>';
                            }
                            else{
                              echo    '<td><input type="hidden" class="valid_positive_number get_product_quantity" name="get_product_quantity'.$key.'" data-old="0" value="0" /></td>';
                            } 

                            /* PRICE */
                            if($is_gaichyu == true) {
                              // trường hợp khách hàng gián tiếp
                              if($is_gaichyu_login == true) {
                                echo '<td>';
                                  if($value[PL_SPECIAL] != 1) {
                                    if($value['price_delivery_gaichyu'] != NULL && $value['price_delivery_gaichyu'] != "" && $value['price_delivery_gaichyu'] > 0) {
                                      if($value['price_gaichyu'] != NULL && $value['price_gaichyu'] > 0) {
                                        echo '<input '.$disable_value.' type="number" class="frm-input-disabled get_product_price_gaichyu" name="get_product_price_gaichyu'.$key.'" value="'.$value['price_delivery_gaichyu'].'" disabled />';
                                      }
                                      else {
                                        echo '<input '.$disable_value.' type="number" class="valid_positive_number get_product_price_gaichyu" name="get_product_price_gaichyu'.$key.'" value="'.$value['price_delivery_gaichyu'].'" />';
                                      }
                                      
                                    }
                                    else {
                                      if($value['price_gaichyu'] != NULL && $value['price_gaichyu'] > 0) {
                                        echo '<input '.$disable_value.' type="number" class="frm-input-disabled get_product_price_gaichyu" name="get_product_price_gaichyu'.$key.'" value="'.$value['price_gaichyu'].'" disabled />';
                                      }
                                      else {
                                        echo '<input '.$disable_value.' type="number" name="get_product_price_gaichyu'.$key.'" class="valid_positive_number get_product_price_gaichyu" value="" />';
                                      }
                                    }
                                  }
                                  else{
                                    echo    '<input type="hidden" name="get_product_price_gaichyu'.$key.'" class="get_product_price_gaichyu" value="0" />';
                                  }
                                  echo '<input type="hidden" name="get_product_price'.$key.'" class="get_product_price" value="'.$value['price'].'" />';
                                echo '</td>';
                              } else {
                                // price sell
                              echo '<td>';
                              if($value[PL_SPECIAL] != 1) {
                                if($value['price_delivery'] != NULL && $value['price_delivery'] != "" && $value['price_delivery'] > 0) {
                                  if($value['price'] != NULL && $value['price'] > 0) {
                                    echo '<input '.$disable_value.' type="number" class="frm-input-disabled get_product_price" name="get_product_price'.$key.'" value="'.$value['price_delivery'].'" disabled />';
                                  }
                                  else {
                                    echo '<input '.$disable_value.' type="number" class="valid_positive_number get_product_price" name="get_product_price'.$key.'" value="'.$value['price_delivery'].'" />';
                                  }
                                  
                                }
                                else {
                                  if($value['price'] != NULL && $value['price'] > 0) {
                                    echo '<input '.$disable_value.' type="number" class="frm-input-disabled get_product_price" name="get_product_price'.$key.'" value="'.$value['price'].'" disabled />';
                                  }
                                  else {
                                    echo '<input '.$disable_value.' type="number" name="get_product_price'.$key.'" class="valid_positive_number get_product_price" value="" />';
                                  }
                                }
                              }
                              else{
                                echo    '<input type="hidden" name="get_product_price'.$key.'" class="get_product_price" value="0" />';
                              }
                              echo '</td>';

                              // price gaichyu
                              echo '<td>';
                              if($value[PL_SPECIAL] != 1) {
                                if($value['price_delivery_gaichyu'] != NULL && $value['price_delivery_gaichyu'] != "" && $value['price_delivery_gaichyu'] > 0) {
                                  if($value['price_gaichyu'] != NULL && $value['price_gaichyu'] > 0) {
                                    echo '<input '.$disable_value.' type="number" class="frm-input-disabled get_product_price_gaichyu" name="get_product_price_gaichyu'.$key.'" value="'.$value['price_delivery_gaichyu'].'" disabled />';
                                  }
                                  else {
                                    echo '<input '.$disable_value.' type="number" class="valid_positive_number get_product_price_gaichyu" name="get_product_price_gaichyu'.$key.'" value="'.$value['price_delivery_gaichyu'].'" />';
                                  }
                                  
                                }
                                else {
                                  if($value['price_gaichyu'] != NULL && $value['price_gaichyu'] > 0) {
                                    echo '<input '.$disable_value.' type="number" class="frm-input-disabled get_product_price_gaichyu" name="get_product_price_gaichyu'.$key.'" value="'.$value['price_gaichyu'].'" disabled />';
                                  }
                                  else {
                                    echo '<input '.$disable_value.' type="number" name="get_product_price_gaichyu'.$key.'" class="valid_positive_number get_product_price_gaichyu" value="" />';
                                  }
                                }
                              }
                              else{
                                echo    '<input type="hidden" name="get_product_price_gaichyu'.$key.'" class="get_product_price_gaichyu" value="0" />';
                              }
                              echo '</td>';
                              }

                            } else {
                              // trường hợp khách hàng trực tiếp
                              echo '<td>';
                              if($value[PL_SPECIAL] != 1) {
                                if($value['price_delivery'] != NULL && $value['price_delivery'] != "" && $value['price_delivery'] > 0) {
                                  if($value['price'] != NULL && $value['price'] > 0) {
                                    echo '<input '.$disable_value.' type="number" class="frm-input-disabled get_product_price" name="get_product_price'.$key.'" value="'.$value['price_delivery'].'" disabled />';
                                  }
                                  else {
                                    echo '<input '.$disable_value.' type="number" class="valid_positive_number get_product_price" name="get_product_price'.$key.'" value="'.$value['price_delivery'].'" />';
                                  }
                                  
                                }
                                else {
                                  if($value['price'] != NULL && $value['price'] > 0) {
                                    echo '<input '.$disable_value.' type="number" class="frm-input-disabled get_product_price" name="get_product_price'.$key.'" value="'.$value['price'].'" disabled />';
                                  }
                                  else {
                                    echo '<input '.$disable_value.' type="number" name="get_product_price'.$key.'" class="valid_positive_number get_product_price" value="" />';
                                  }
                                }
                              }
                              else{
                                echo    '<input type="hidden" name="get_product_price'.$key.'" class="get_product_price" value="0" />';
                              }
                              echo '<input type="hidden" name="get_product_price_gaichyu'.$key.'" class="get_product_price_gaichyu" value="0" />';
                              echo '</td>';
                              
                            }

                            /* THANH TIEN GIAO HANG */
                            $amount = $value[DD_DELIVERY_AMOUNT];
                            $amount_gaichyu = $value['price_delivery_gaichyu'] * $value['quantity_delivery'];

                            if($is_gaichyu_login == true) {
                              if($value[PL_SPECIAL] != 1) {
                                echo    '<td>
                                <input '.$disable_value.' type="text" class="frm-input-disabled get_amount_gaichyu" value="'.number_format($amount_gaichyu,2,',', '').'" disabled />
                                <input type="hidden" class="frm-input-disabled get_amount" value="'.$amount.'" disabled />
                                </td>';
                              }
                              else{
                                echo '<td>
                                <input '.$disable_value.' type="text" class="valid_positive_number get_amount_gaichyu" name="get_amount_gaichyu'.$key.'" value="'.number_format($amount_gaichyu,2,',', '').'" />
                                <input type="hidden" class="valid_positive_number get_amount" name="get_amount'.$key.'" value="'.$value[DD_DELIVERY_AMOUNT].'" />
                                </td>';
                              }
                            }
                            else {
                              if($value[PL_SPECIAL] != 1) {
                                echo    '<td><input '.$disable_value.' type="text" class="frm-input-disabled get_amount" value="'.$amount.'" disabled /></td>';
                              }
                              else{
                                echo '<td><input '.$disable_value.' type="text" class="valid_positive_number get_amount" name="get_amount'.$key.'" value="'.$value[DD_DELIVERY_AMOUNT].'" /></td>';
                              }
                            }
                            

                            $value_hidden = '<input type="hidden" name="get_special'.$key.'" class="get_special" value="'.$value[PL_SPECIAL].'" /><input type="hidden" name="get_special'.$key.'" class="get_check" value="'.$value[DD_CHECK].'" />';
                            
                            if(isset($value[DD_CHECK]) && $value[DD_CHECK] == 1) {
                                echo    '<td>レ'.$value_hidden.'</td>';
                            }
                            else{
                                echo    '<td>'.$value_hidden.'</td>';
                            }
                            echo '</tr>';

                            // Total
                            $sum_total += $amount;
                            $sum_total_gaichyu += $amount_gaichyu;
                            
                            // number order
                            if($value[PL_SPECIAL] != 1) {
                              $total += ($value[OD_QUANTITY]+$value[OD_ADD]);
                            }
                        } ?>
                        <tr class="sum-col">
                          <td>合計</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <?php if($is_gaichyu == true) {
                            if($is_gaichyu_login == true) {
                              ?>
                              <td></td>
                              <?php
                            } else {
                            ?>
                            <td></td>
                            <?php } } else { ?>
                              <td></td>
                            <?php } ?>
                          
                          <td><?= number_format($total,2) ?></td>
                          <td></td>
                          <td></td>
                          <?php if($is_gaichyu_login == true) { ?>
                            <td id="delivery_total_amount_gaichyu"><?= number_format($sum_total_gaichyu,2) ?></td>
                          <?php } else { ?>
                            <td></td>
                            <td id="delivery_total_amount"><?= number_format($sum_total,2) ?></td>
                            <?php } ?>
                          
                          <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row wrapper-textarea">
                <label>備考</label>
                <textarea class="form-control" rows="5" id="get_delivery_note"><?= $master[SL_DELIVERY_NOTE] ?></textarea><br />
            </div>
        </div>
    <div class="row margin-bottom-table">
        <div class="right">
          <?php 
          $getType = $this->input->get("type");
          if($getType == 2) {
          ?>
          <a href="<?php echo site_url('order/detail-order-2?id='.$master[SL_ID]).'&tab=2'; ?>" class="print">戻る</a>
          <?php } else { ?>
            <a href="<?php echo site_url('order/detail-order?id='.$master[SL_ID]).'&tab=2'; ?>" class="print">戻る</a>
          <?php } ?>
            <a class="print save-delivery" id="save-delivery">保存</a>
        </div>
    </div>
    </form>
</div>
<script>
var editUrl = "<?= base_url("order/edit-delivery-post") ?>";
var deleteUrl = "<?= base_url("order/delete-order") ?>";
var receivedUrl = "<?= base_url("receive-order") ?>";
var message_error_ajax = "<?= $this->lang->line('message_error_ajax') ?>"; 
var message_fix_confirm_delivery = "<?= $this->lang->line('message_fix_confirm_delivery') ?>"; 
var message_add_error_price_gaichyn = "<?= $this->lang->line('message_add_error_price_gaichyn') ?>"; 
var dateOrder = "<?= $master['orderdate_print'] ?>";
var date_update = "<?php echo $master[SL_UPDATE_DATE];?>";
var count_checklist = <?= $count_checklist;?>;
var sum_checklist = <?= $sum_checklist;?>;
var message_not_redirect_to_delivery = "<?= $this->lang->line('message_not_redirect_to_delivery')?>";
</script>