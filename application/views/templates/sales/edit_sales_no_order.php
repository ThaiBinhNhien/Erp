<style>
table input{
  width:calc(100% - 2px) !important;
  border: 1px solid #878898 !important;
  margin:1px !important;
  height:32px;
  }
</style>
<div class="wrapper-contain revenues order detail-revenues">
<input type="hidden" id="invoice_no" value="<?php echo ($id) ?>">
<div class="row">
    <div class="col-md-8" style="margin-top: 20px;">

    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label  class="col-md-4 control-label">請求書No:</label>
          <div class="col-md-8">
            <input class="hide-input" name='invoice_id' id="invoice_id" type="text" value="<?php echo ($id) ?>" disabled>
            <input type="hidden" id="update_date" value="<?php echo $update_date ?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label  class="col-md-4 control-label" style="line-height:0.9">請求書種別:</label>
          <div class="col-md-8">
              <input value="<?php echo ($invoice) ?>" disabled style="background:none;border:none;"/>
        <input type="hidden" name="user_id" id="user_id" value="<?php echo ($_SESSION['login-info'][U_ID]) ?>">
        <input type="hidden" name="base_id" id="base_id" value="<?php echo ($_SESSION['login-info'][SL_BASE_CODE]) ?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-6">
          <div class="form-group">
            <label  class="col-md-4 control-label">作成日:</label>
            <div class="col-md-8">
                 <span class="form-control form-control-input" style="margin-bottom:9px;">
              <input name="start_date" id="paid_date_start" value="<?php echo $date_create ?>" disabled class="hide-input">
              </span>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label  class="col-md-4 control-label">お得意先:</label>
          <div class="col-md-8">
            <input type="text" id="cus_name" name="customer" value="<?php echo $customer_name ?>" class="form-control">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label  class="col-md-4 control-label">部署指定:</label>
          <div class="col-md-8">
           <input type="text" id="department_name" value="<?php echo $department_name; ?>" name="department" class="form-control">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-8 col-md-6 col-lg-6">
        <div class="form-group">
          <label  class="col-md-4 control-label">請求期間:</label>
          <div class="col-md-8">
               <span class="form-control form-control-input" style="margin-bottom:9px;">
            <input name="start_date" id="paid_date_start" value="<?php echo $paid_date['start'] ?>" class="datepicker">
            <span class=" icon-large icon-calendar"></span>
            </span>
          </div>
        </div>
      </div>
        <div class="col-sm-4 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="col-md-4 control-label center"> <span id="character">~</span></label>
          <div class="col-md-8">
            <span class="form-control form-control-input" style="margin-bottom:9px;">
            <input name="end_date" id="paid_date_end" value="<?php echo $paid_date['end'] ?>" class="datepicker">
            <span class=" icon-large icon-calendar "></span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label  class="col-md-4 control-label">得意先住所:</label>
          <div class="col-md-8">
                 <!-- <input type="text" value="<?php echo $address; ?>" name="address" id="address" /> -->
                 <textarea name="address" id="address" ><?php echo $address; ?></textarea>
          </div>
        </div>
      </div>
    </div>

</div>
	<div class="button-right-side col-md-4">
    <a  href="<?php echo site_url('sale'); ?>" class="print right ">MENU画面へ </a>
	 <a href="<?php echo (base_url('sale/print-invoice?inv_id=' . $id)) ?>" class="print right top-print">印刷 </a>
	 <a  href="" class="print right top-print">営業管理画面へ</a>
		</div>
</div>

<div class="clearfix"></div>
<div class="row" style="margin:9px;">
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;padding-top:0;"></caption>
            <th style="width: 17%;">
            <?php if ($sum_price_cate1 > 0) {
            	echo 'ﾘﾈﾝｻﾌﾟﾗｲ売上';
            }
            ?>
            </th>
            <th style="width: 15%;"></th>
            <th style="width: 17%">
            <?php if ($sum_price_cate2 > 0) {
            	echo 'ｸﾘｰﾆﾝｸﾞ他売上';
            }
            ?>
            </th>
            <th style="width: 17%">小　　　　計</th>
            <th style="width: 17%">
                <?php if ($tax > 0) {
                	echo "消費税" . $tax . "%";
                }
                ?>
            </th>
            <th style="width: 17%">請求金額（税込）</th>
            <tr>
                <td class="right-text sum_price_cate1">
                    <?php if ($sum_price_cate1 > 0) {
                    	echo $sum_price_cate1;
                    }
                    ?>
                </td>
                <td class="right-text"></td>
                <td class="right-text sum_price_cate2">
                    <?php if ($sum_price_cate2 > 0) {
                    	echo $sum_price_cate2;
                    }
                    ?>
                </td>
                <td class="right-text sum_price">
                    <?php
                    $sum_price = $sum_price_cate1 + $sum_price_cate2;
                    echo $sum_price;
                    ?>
                </td>
                <td class="right-text tax">
                    <?php if ($tax > 0) {
                    	echo $sum_price * $tax / 100;
                    } else {
                    	$tax = 0;
                    }

                    ?>
                </td>
                <td class="right-text total_price" id="total_price">
                    <?php echo $sum_price + $sum_price * $tax / 100; ?>
                </td>
            </tr>
    </tbody>
</table>
</div>
<div class="row third-row margin-top-table"  >
      <label class="" for="comment">備考</label>
      <textarea class=" form-control" rows="5" id="comment"><?php echo ($remark) ?></textarea>
</div>

<div class="row third-row">
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;padding-top:0;">請求書明細書</caption>
            <th width="50%">項　　　　　目（部署）</th>
            <th width="25%">リネンサプライ売上</th>
            <th width="25%">クリーニング他売上</th>
        <tr>
            <td><?php echo $department_name ?></td>
            <td class="sum_price_cate1"><?php echo $sum_price_cate1 ?></td>
            <td class="sum_price_cate2"><?php echo $sum_price_cate2 ?></td>
        </tr>
    </tbody>
</table>
</div>
<div style="padding-left: 10px; font-size: 20px;"><b>請求明細: </b> <?php echo $department_name ?> </div>
<div class="row third-row">
<?php if (!empty($product_list_cate1)) {
	?>
<table  class="full-table">
    <tbody class="tb_cate1">
        <caption style="text-align:left;padding-top:0;">種目：ﾘﾈﾝｻﾌﾟﾗｲ売上 &ensp;<span class="sum_price_cate1"><?php echo $sum_price_cate1 ?></span>円</caption>
            <th width="15%">商品コード</th>
            <th width="35%">商品名</th>
            <th width="15%">数量</th>
            <th width="15%">単価</th>
            <th width="20%">金額（円） </th>
        <?php foreach ($product_list_cate1 as $product) {?>
        <tr class="product_cate1 product_detail">
            <td><?php echo $product->{PL_PRODUCT_CODE_SALE} ?><input type='hidden' class="product_id" value='<?php echo $product->{IOD_PRODUCT_ID} ?>'/></td>
            <td><?php echo $product->{IOD_PRODUCT_NAME} ?></td>
            <td>
                <?php
                if ($product->{IOD_PRICE} != 0) {
              		echo $product->{IOD_AMOUNT}+0;
              	} else {
              		echo "<input type='text' class='amount_cate1 amount_no_order' value='" . $product->{IOD_AMOUNT} . "' style='text-align:right' />";
              	}
                ?>
            </td>
            <td><?php echo $product->{IOD_PRICE}+0 ?></td>
            <td class="right-text">
                <?php
                if ($product->{IOD_PRICE} != 0) {
            			echo $product->{IOD_AMOUNT} * $product->{IOD_PRICE};
            		} else {
            			echo "<input type='text' class='price_cate1 price_no_order' value='" . $product->{IOD_SUM_PRICE} . "' style='text-align:right;' />";
            		}
                ?>
            </td>
        </tr>
        <?php }?>
    </tbody>
</table>
<?php }?>
<?php if (!empty($product_list_cate2)) {
	?>
<table  class="full-table" style="margin-top: 10px">
    <tbody class="tb_cate2">
        <caption style="text-align:left;padding-top:0;">種目：ｸﾘｰﾆﾝｸﾞ他売上 &ensp;<span class="sum_price_cate2"><?php echo $sum_price_cate2 ?></span>円</caption>
            <th width="15%">商品コード</th>
            <th width="35%">商品名</th>
            <th width="15%">数量</th>
            <th width="15%">単価</th>
            <th width="20%">金額（円） </th>
        <?php foreach ($product_list_cate2 as $product) {?>
        <tr class="product_cate2 product_detail">
            <td><?php echo $product->{PL_PRODUCT_CODE_SALE} ?><input type='hidden' class="product_id" value='<?php echo $product->{IOD_PRODUCT_ID} ?>'/></td>
            <td><?php echo $product->{IOD_PRODUCT_NAME} ?></td>
            <td>
                <?php
                if ($product->{IOD_PRICE} != 0) {
              		echo $product->{IOD_AMOUNT}+0;
              	} else {
              		echo "<input type='text' class='amount_cate2 amount_no_order' value='" . $product->{IOD_AMOUNT} . "' style='text-align:right' />";
              	}
                ?>
            </td>
            <td><?php echo $product->{IOD_PRICE}+0 ?></td>
            <td class="right-text">
                <?php
                if ($product->{IOD_PRICE} != 0) {
            			echo $product->{IOD_AMOUNT} * $product->{IOD_PRICE};
            		} else {
            			echo "<input type='text' class='price_cate2 price_no_order' value='" . $product->{IOD_SUM_PRICE} . "' style='text-align:right;' />";
            		}
                ?>
            </td>
        </tr>
        <?php }?>
    </tbody>
</table>
<?php }?>
</div>
<div class="row first-row">
    <a class="print right save-no-order">保存 </a>
</div>
</div>
<script>
    var base_url = '<?php echo (base_url()) ?>';
    var tax = <?php echo $tax ?>;
</script>