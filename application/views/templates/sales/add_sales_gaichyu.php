<style>
	.add-revenues .add-table{
		width:100%;
	}
	.add-revenues .add-table td,.add-revenues .add-table th{
		height:34px;
		border:1px solid black;
	}
	.add-revenues .add-table td {
		padding-left:5px;
		padding-right:5px;
	}
	.add-revenues .add-table th{
		text-align: center;
	}
	.add-revenues caption{
		background:none;
	}
	.add-revenues left-text{
		text-align: left !important;
	}
	.add-revenues right-text{
		text-align: right !important;
	}
	.add-revenues .center-text{
		text-align: center !important;
	}
	.add-revenues .input{
		width:100%;
		margin:0;
		padding:0;
		height:95%;
		
	}
	.input{
		width:100%;
		margin:0;
		padding:0;
		height:95%;
	}
	.add-revenues .form-horizontal label{
		text-align: left !important;
		padding-left:30px;
	}
	.second-add-table td:nth-child(3),.second-add-table td:nth-child(4){
		text-align: center;
	}
	.first-add-table th:nth-child(n+3),.second-add-table th:nth-child(n+3){
		width:15%;
	}
	.first-add-table td:nth-child(3),.first-add-table td:nth-child(4){
		text-align: center;
	}
	.first-add-table td input.text,.second-add-table td input.text{
		padding-right:2px;
	}
</style>
<div class="wrapper-contain add-revenues order">
	<div class="row">
		  <a href="<?php echo site_url('sale');?>" class="print right top-print">MENU画面へ</a>  
	</div>
	<div class="row">
	<form class="form-horizontal" role="form">
    <div class="row">
		<div class="col-sm-12 col-md-4 col-lg-4">
			<div class="form-group">
				<label for="inputEmail" class="col-md-4 control-label">請求書No:</label>
				<div class="col-md-8">
					<!--<input class="form-control" style="border:none;background:none;" value="001" disabled>-->
					<span style="line-height:2.5;"></span>
					<input type="hidden" id="invoice_id" value="<?php echo($id) ?>">
				</div>
			</div>
		</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-sm-12 col-md-4 col-lg-4">	
			<div class="form-group">
				<label for="inputEmail" class="col-md-4 control-label">お得意先:</label>
				<div class="col-md-8">
					<!--<input class="form-control " value="株式会社ニューオータニ" style="border:none;background:none;" disabled>-->
                <input type="hidden" id="customer_id" value="<?php echo($customer_id) ?>">
				<span style="line-height:2.5;"><?php echo($customer_name) ?></span>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-md-4 control-label">請求書選択:</label>
				<div class="col-md-8">
                    <span style="line-height:2.5;"><?php echo $inv_group->{IG_INVOICE_NAME} ?></span>
                    <input type="hidden" id="invoice_group_id" value="<?php echo $inv_group->{IG_ID} ?>">
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-8 col-lg-8">	
			<div class="form-group">
				<label for="inputEmail" class="col-md-2 control-label" style="width:75px;">住所:</label>
				<div class="col-md-10">
					<textarea id="address" style="width:100%;height:68px;float:left;"><?php echo($inv_group->{IG_STREET_ADDRESS}) ?></textarea>
				</div>
			</div>
      </div>
	</div><!--End row -->	
	<div class="clearfix visible-lg-block visible-md-block"></div>
		<div class="col-sm-12 col-md-4 col-lg-4">
			<div class="form-group">
				<label for="inputPassword" class="col-md-4 control-label">売上(納品)日:</label>
				<div class="col-md-8">
					<span style="line-height:2.5;">
                        <?php echo $date_ship['start'].' ~ '.$date_ship['end']; ?> 
                    </span>
				</div>
			</div>
      </div>
	 <div class="clearfix visible-lg-block visible-md-block"></div>
     <div class="col-sm-12 col-md-4 col-lg-4" style="margin-top:5px;">
		 <div class="form-group">
			 <label for="input9" class="col-md-4 control-label">部署名:</label>
			 <div class="col-md-8">
				 <!--<input value="XXXX部署、YYYY部署、ZZZZZ部" class="no-bottom-margin"/>-->
				<span style="line-height:2.5;">
                 <?php echo($list_department) ?>
                </span>
			 </div>
        </div>
      </div>
    </div>
	</form>
	</div><!--End first row-->
	<div class="row sec-row">
		<table class="add-table margin-top-table first-add-table ">
		    <tbody>
		            <th style="width: 14%;">ﾘﾈﾝｻﾌﾟﾗｲ売上</th>
		            <th style="width: 13%;" class="col_2_name">
		            	<?php
		            	if($environment_tax > 0 & $sum_price_cate1 > 0) echo "ﾘﾈﾝ補充費";
		            	elseif($discount != 0 & $sum_price_cate1 > 0) echo "値引分".abs($discount)."%"; 
		            	?>
		            </th>
		            <th style="width: 14%">ｸﾘｰﾆﾝｸﾞ他売上</th>
		            <th style="width: 14%">管理業務料</th>
		            <th style="width: 15%">小　　　　計</th>
		            <th style="width: 15%" class="tax_name">
		            	<?php if($tax > 0) echo '消費税'.$tax.'%'; ?>
		            </th>
		            <th style="width: 15%">請求金額（税込）</th>
		            <tr>
		                <td class="right-text sum_price_cate1">
		                	<?php 
		                	if($sum_price_cate1>0) echo $sum_price_cate1;
		                	$discount_cate1 = $sum_price_cate1*$discount_gaichyu->linen_discount/100; 
		                	?>
		                </td><!--hàng khăn-->
		                <td class='right-text col_2_value'>
		                	<?php 
		                	if(($environment_tax != 0 | $discount != 0) & $sum_price_cate1>0) echo abs((int)$environment_tax+(int)$discount)*$sum_price_cate1/100;
		                	$discount_environment = $environment_tax*$sum_price_cate1*$discount_gaichyu->environment_discount/10000;
		                	?>
		                </td>
		                <input type="hidden" id="col_2_hide_value" value="<?php echo((int)$environment_tax+(int)$discount); ?>">
		                <td class="right-text sum_price_cate2">
		                	<?php 
		                	if($sum_price_cate2>0) echo $sum_price_cate2; 
		                	$discount_cate2 = $sum_price_cate2*$discount_gaichyu->other_discount/100;
		                	?>
						</td><!--hàng giặc-->

		                <td class="discount_gaichyu">
		                	<?php 
		                	$fee_gaichyu = $discount_cate1+$discount_environment+$discount_cate2;
		                	if($fee_gaichyu > 0) echo($fee_gaichyu); 
		                	?>
		                </td>

		                <?php $sum_price = $sum_price_cate1 + $sum_price_cate2 + ((int)$environment_tax+(int)$discount)*$sum_price_cate1/100 - $fee_gaichyu; 
		                ?>
		                <td class='right-text sum_price col_4_value'>
		                	<?php echo $sum_price; ?>
		                </td>
		                <td class='right-text tax'>
		                	<?php if($tax>0) echo $sum_price*$tax/100; ?>
		                </td>
		                <input type="hidden" id="tax_hide_value" value="<?php echo $tax ?>">
		                <td class='right-text total_price'><?php echo $sum_price + $sum_price*$tax/100; ?></td>
		            </tr>
		    </tbody>
		</table>     
	</div>
<div class="row sec-row ">
    <table class="add-table margin-top-table first-add-table ">
        <caption class="left-text " style="margin-bottom:15px;">請求内訳</caption>
    <tbody>
            <th style="width:50%;">項　　　　　　　　目（部署）</th>
            <th style="width:25%;">リネンサプライ売上</th>
            <th style="width:25%;">クリーニング他売上</th>
            <?php $sum_price = 0 ?>
            <?php foreach($order_list as $order){ ?>
            <tr class="order<?php echo $order->id ?>">
                <td class="left-text"><?php echo $order->department ?></td>
                <td class='right-text cate1'><?php if($order->sum_price_cate1 > 0) echo $order->sum_price_cate1; ?></td>
                <td class='right-text cate2'><?php if($order->sum_price_cate2 > 0) echo $order->sum_price_cate2; ?></td>
            </tr>
            <?php } ?>
    </tbody>
</table>     
<div class="row first-row">
            <label class="" for="comment">備考</label>
            <textarea class=" form-control" rows="5" id="comment">   
            </textarea>
</div>   
</div>
<?php $i=0 ?>
<?php foreach($order_list as $order){ ?>
<?php $i++ ?>
<input type="hidden" class="id_of_order" value="<?php echo $order->id ?>">
<?php if(!empty($order->product_list_cate1) | !empty($order->product_list_cate2)){ ?>
<p>請求明細: <strong><?php echo $order->department; ?></strong></p>
<?php } ?>
<?php if(!empty($order->product_list_cate1)){ ?>
<div class="row sec-row">
<table class="add-table first-add-table table_department">
    <tbody>
    	<input type="hidden" class="order_id" value="<?php echo $order->id ?>">
    	<input type="hidden" class="price_hide_cate1" value="<?php echo $order->sum_price_cate1 ?>">
    	<input type="hidden" class="department_id_cate1" value="<?php echo $order->department_id ?>">
        <caption class="left">種目：ﾘﾈﾝｻﾌﾟﾗｲ &ensp; <span class="price_cate1"><?php echo $order->sum_price_cate1 ?></span>円</caption>
            <th>商品コード</th>
            <th>商品名</th>
            <th>数量</th>
            <th>単価</th> 
            <th>金額（円） </th>
        <?php foreach($order->product_list_cate1 as $product){ ?>
        <tr>
            <td><?php echo $product->{PL_PRODUCT_CODE_SALE} ?></td>
            <td><?php echo $product->{PL_PRODUCT_NAME} ?></td>
            <td><?php echo $product->{DD_QUANTITY}+0 ?></td>
            <td><?php echo $product->{DD_GAICHYU_PRICE}+0 ?></td> 
            <td class="right-text"><?php echo $product->{DD_QUANTITY}*$product->{DD_GAICHYU_PRICE} ?></td>
        </tr>
        <?php } ?>
        <tr>
        	<td>値引き</td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td><input type="text" class="discount_cate1 input" style="text-align: right;" value="0"></td>
        </tr>
    </tbody>
</table>  								
</div>
<?php }else{ ?>
<input type="hidden" class="discount_cate1" value="0">
<?php } ?>

<?php if(!empty($order->product_list_cate2)){ ?>
<div class="row sec-row">
<table class="add-table first-add-table table_department">
    <tbody>
    	<input type="hidden" class="order_id" value="<?php echo $order->id ?>">
    	<input type="hidden" class="price_hide_cate2" value="<?php echo $order->sum_price_cate2 ?>">
    	<input type="hidden" class="department_id_cate2" value="<?php echo $order->department_id ?>" name="">
        <caption class="left">種目：ｸﾘｰﾆﾝｸﾞ他 &ensp; <span class="price_cate2"><?php echo $order->sum_price_cate2 ?></span>円</caption>
            <th>商品コード</th>
            <th>商品名</th>
            <th>数量</th>
            <th>単価</th> 
            <th>金額（円） </th>
        <?php foreach($order->product_list_cate2 as $product){ ?>
        <tr>
            <td><?php echo $product->{PL_PRODUCT_CODE_SALE} ?></td>
            <td><?php echo $product->{PL_PRODUCT_NAME} ?></td>
            <td><?php echo $product->{DD_QUANTITY}+0 ?></td>
            <td><?php echo $product->{DD_GAICHYU_PRICE}+0 ?></td> 
            <td class="right-text"><?php echo $product->{DD_QUANTITY}*$product->{DD_GAICHYU_PRICE} ?></td>
        </tr>
        <?php } ?>
        <tr>
        	<td>値引き</td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td><input type="text" class="discount_cate2 input" style="text-align: right;" value="0"></td>
        </tr>
    </tbody>
</table>		
</div>
<?php }else{ ?>
<input type="hidden" class="discount_cate2" value="0">
<?php } ?>
<?php } ?>
<div class="row first-row">
	<a href="<?php echo site_url('sale');?>" class="print print-1 left">戻る</a>
	<a class="print  print-1 save-sale right">保存 </a>  
</div><!--End button row-->
</div><!--End wrapper contain-->
<script>
    var base_url = "<?php echo base_url() ?>";
    var discount_gaichyu = <?php echo json_encode($discount_gaichyu) ?>;
</script>