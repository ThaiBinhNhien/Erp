<style>
textarea {
    border: none;
    background-color: transparent;
    resize: none;
    outline: none;
}
</style>
<div class="wrapper-contain revenues order detail-revenues">
<input type="hidden" id="invoice_no" value="<?php echo($id) ?>">
<div class="row">
    <div class="col-md-8">
  
        <table style="width: 100%" class="detail-table">
            <col width="30%" />
            <col width="70%" />
            <tr>
               <td>請書No:</td>
               <td><?php echo($id) ?></td>
            </tr>
            <tr>
               <td>請求書種別:</td>
               <td><?php echo($invoice) ?></td>
            </tr>
            <tr>
               <td>お得意先:</td>
               <td><?php echo($customer_name) ?></td>
            </tr>
              <tr>
               <td>部署指定:</td>
               <td><?php echo($department_list) ?></td>
            </tr>
            <tr>
               <td>納品日:</td>
               <td><?php echo($date_ship['start'].' - '.$date_ship['end']) ?></td>
           </tr>
           <tr>
               <td>得意先住所:</td>
               <td><textarea disabled><?php echo($address) ?></textarea></td>
               
           </tr>
        </table>
    
    </div>
	<div class="button-right-side">
    <a  href="<?php echo site_url('sale');?>" class="print right ">MENU画面へ </a>
	 <a href="<?php echo(base_url('sale/print-invoice?inv_id='.$id)) ?>" class="print right top-print">印刷 </a>
	 <a  href="" class="print right top-print">営業管理画面へ</a>
		</div>
</div>
	
<div class="clearfix"></div>
<div class="row">
    <div style="float:right;">
                    <a class="print del-sale">削除</a>
                    <a href="<?php echo site_url('sale/edit-sale?inv_id='.$id);?>" class="print edit_sale">編集
                    </a>
                    
                </div>
</div>
<div class="row" style="margin:9px;">
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;padding-top:0;"></caption>
            <th style="width: 17%;">ﾘﾈﾝｻﾌﾟﾗｲ売上
            </th>
            <th style="width: 15%;">
                <?php
                if($environment_tax > 0) echo "ﾘﾈﾝ補充費";
                elseif ($discount > 0) echo "値引分".$discount."%"; 
                ?>
            </th>
            <th style="width: 17%">
            <?php if($sum_price_cate2 > 0 ) echo 'ｸﾘｰﾆﾝｸﾞ他売上'; ?>
            </th>
            <th style="width: 17%">小　　　　計</th>
            <th style="width: 17%">
                <?php if($tax > 0) echo "消費税".$tax."%"; ?>
            </th>
            <th style="width: 17%">請求金額（税込）</th>
            <tr>
                <td class="right-text">
                    <?php if($sum_price_cate1 > 0) echo $sum_price_cate1; ?>
                </td>
                <td class="right-text">
                    <?php
                    if($environment_tax > 0 & $sum_price_cate1 > 0) echo $environment_tax*$sum_price_cate1/100;
                    elseif ($discount > 0 & $sum_price_cate1 > 0) echo $discount*$sum_price_cate1/100; 
                    ?>
                </td>
                <td class="right-text">
                    <?php if($sum_price_cate2 > 0) echo $sum_price_cate2; ?>
                </td>
                <td class="right-text">
                    <?php
                    $sum_price = $sum_price_cate1 - $discount*$sum_price_cate1/100 + $environment_tax*$sum_price_cate1/100 + $sum_price_cate2;
                    echo  $sum_price;
                    ?>
                </td>
                <td class="right-text">
                    <?php if($tax > 0) echo $sum_price*$tax/100; ?>
                </td>
                <td class="right-text">
                    <?php echo $sum_price + $sum_price*$tax/100; ?>
                </td>
            </tr>
    </tbody>
</table>
</div>
<div class="row third-row margin-top-table"  >
      <label class="" for="comment">備考</label>
      <textarea class=" form-control" rows="5" id="comment" disabled><?php echo($remark) ?></textarea>
</div>

<div class="row third-row">
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;padding-top:0;">請求書明細書</caption>
            <th width="50%">項　　　　　目（部署）</th>
            <th width="25%">リネンサプライ売上</th>
            <th width="25%">クリーニング他売上</th>
        <?php foreach ($list_order as $order) { ?>
        <tr>
            <td><?php echo $order->{DL_DEPARTMENT_NAME} ?></td>
            <td style="text-align: right;"><?php echo $order->sum_price_cate1 ?></td>
            <td style="text-align: right;"><?php echo $order->sum_price_cate2 ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>                                
</div>  
<?php foreach($list_order as $order){ ?>
<div style="padding-left: 10px; font-size: 20px;"><b>請求明細: </b> <?php echo $order->{DL_DEPARTMENT_NAME} ?> </div>
<div class="row third-row">
<?php if(!empty($order->product_list_cate1)){ ?>
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;padding-top:0;">種目：ﾘﾈﾝｻﾌﾟﾗｲ売上 &ensp;<span><?php echo $order->sum_price_cate1 ?></span>円</caption>
            <th width="15%">商品コード</th>
            <th width="25%">商品名</th>
            <th width="20%">数量</th>
            <th width="20%">単価</th> 
            <th width="20%">金額（円） </th>
        <?php foreach($order->product_list_cate1 as $product){ ?>
        <tr>
            <td><?php echo $product->{PL_PRODUCT_CODE_SALE} ?></td>
            <td><?php echo $product->{DD_PRODUCT_NAME} ?></td>
            <td style="text-align: right;"><?php echo $product->{DD_QUANTITY}+0 ?></td>
            <td style="text-align: right;"><?php echo $product->{DD_UNIT_PRICE}+0 ?></td> 
            <td class="right-text"><?php echo $product->{DD_QUANTITY}*$product->{DD_UNIT_PRICE} ?></td>
        </tr>
        <?php } ?>
        <?php if($order->{ID_DISCOUNT_SUPPLIER} > 0){ ?>
        <tr>
            <td>値引き(%)</td>
            <td></td>
            <td></td>
            <td></td> 
            <td class="right-text"><?php echo $order->{ID_DISCOUNT_SUPPLIER}.'%' ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>
<?php if(!empty($order->product_list_cate2)){ ?>
<table  class="full-table" style="margin-top: 10px">
    <tbody>
        <caption style="text-align:left;padding-top:0;">種目：ｸﾘｰﾆﾝｸﾞ他売上 &ensp;<span><?php echo $order->sum_price_cate2 ?></span>円</caption>
            <th width="15%">商品コード</th>
            <th width="25%">商品名</th>
            <th width="20%">数量</th>
            <th width="20%">単価</th> 
            <th width="20%">金額（円） </th>
        <?php foreach($order->product_list_cate2 as $product){ ?>
        <tr>
            <td><?php echo $product->{PL_PRODUCT_CODE_SALE} ?></td>
            <td><?php echo $product->{DD_PRODUCT_NAME} ?></td>
            <td style="text-align: right;"><?php echo $product->{DD_QUANTITY}+0 ?></td>
            <td style="text-align: right;"><?php echo $product->{DD_UNIT_PRICE}+0 ?></td> 
            <td class="right-text"><?php echo $product->{DD_QUANTITY}*$product->{DD_UNIT_PRICE} ?></td>
        </tr>
        <?php } ?>
        <?php if($order->{ID_DISCOUNT_ORTHER} > 0){ ?>
        <tr>
            <td>値引き(%)</td>
            <td></td>
            <td></td>
            <td></td> 
            <td class="right-text"><?php echo $order->{ID_DISCOUNT_ORTHER}.'%' ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>    								
</div>
<?php } ?>	
</div>	
<script>
    var base_url = '<?php echo(base_url()) ?>';
</script>