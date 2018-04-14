<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $title ?></title>
	<style type="text/css">
		.table td,.table_ td{
			border: 1px solid black;
    		border-collapse: collapse;
    		font-size: 12px;
		}

		.table,.table_{
			border: 1px solid black;
    		border-collapse: collapse;
		}
		.thead{
			background-color: LightGray;
		}
		.thead td{
			text-align: center !important;
		}
		p,span{
			font-family : "sun-exta" !important;
		}
	
		.table_ td:nth-child(2),.table_ td:nth-child(4),.table_ td:nth-child(5),.table_ td:nth-child(6),.table_ td:nth-child(7){
			text-align: center;
		}
		.table_ td:nth-child(3){
			text-align: left;
		}
		h6{
			line-height: 0.5;
			font-weight:200;
			margin-bottom:0;
		}
		h6 b{
			font-weight:bold;
			font-size:15px;
		}
		
		.l_footer {
			position:absolute;
			bottom:1.8cm;
		}
		.r_footer{
			position:absolute;
			bottom:1.5cm;
			right:1.5cm;
		}
		.r-table{
			border-collapse: collapse;
		}
		.r-table td{
			border:1px solid black !important;
			height:1.8cm;
			width:1.8cm;
		}
		.l-table{
			border-collapse: collapse;
		}
		.l-table td{
			text-align: left;
			padding-right:5px !important;
		}
	</style>
</head>
<body style="position: relative;">
<div style="text-align: center">
	<h1>請　　求　　書</h1>
	<p><?php echo $date_ship['start'] ?>&nbsp;&sim;&nbsp;<?php echo $date_ship['end'] ?></p>
</div>
<table width="100%">
	<tr>
		<td width="40%" style="text-align: left;font-size: 12px;">
			<span>〒</span> <?php echo($invoice_group->{IG_POST_OFFICE}) ?><br>
			<?php echo(str_replace("\n", "<br>", $address)); ?><br><br>
			<?php echo($customer->{CUS_CUSTOMER_NAME}) ?>
		</td>
		<td width="20%" style="padding-top: 70px;text-align: center">
			<h2>御中</h2>
		</td>
		<td width="40%" style="text-align: left;font-size: 12px;">
			株式会社テーオーリネンサプライ<br>
			<span>〒</span> 102-8578<br>
			東京都千代田区紀尾井町4-1<br>
			ﾎﾃﾙﾆｭｰｵｰﾀﾆ内<br>
			TEL 03-3221-4081 &nbsp;&nbsp;&nbsp;FAX 03-3221-4120
		</td>
	</tr>
</table>
<table class="table" width="100%">
	<tr class="thead">
		<td width="16%"><?php if($sum_price_cate1>0) echo 'ﾘﾈﾝｻﾌﾟﾗｲ売上'; ?></td>
		<td width="16%">
			<?php 
				if($environment_tax>0 & $sum_price_cate1>0) echo('ﾘﾈﾝ補充費');
				elseif($discount > 0 & $sum_price_cate1>0) echo('値引分'.$discount.'%');
			?>
		</td>
		<td width="16%"><?php if($sum_price_cate2>0) echo 'ｸﾘｰﾆﾝｸﾞ他売上'; ?></td>
		<td width="16%">小　計</td>
		<td width="16%"><?php if($tax>0) echo('消費税'.$tax.'%')?></td>
		<td width="20%">請求金額（税込）</td>
	</tr>
	<tr>
		<td>
			<?php if($sum_price_cate1>0) echo $sum_price_cate1; ?>
		</td>
		<td>
			<?php 
			if($sum_price_cate1>0) echo number_format($sum_price_cate1*($environment_tax+$discount)/100);
			$col_2_value = $environment_tax - $discount;
			?>
		</td>
		<td><?php 
				if($sum_price_cate2>0) echo $sum_price_cate2;
			?>
		</td>
		<td>
		<?php 
		$sum_price = $sum_price_cate1 + $sum_price_cate1*$col_2_value/100 + $sum_price_cate2;
		echo number_format($sum_price); 
		?>
		</td>
		<td><?php if($tax>0) echo $sum_price*$tax/100; ?></td>
		<td><?php echo number_format($sum_price + $sum_price*$tax/100); ?></td>
	</tr>
</table>
<h4 style="margin-bottom: 10px;">請求内訳</h4>
<table class="table" width="100%">
	<tr class="thead">
		<td width="50%">項　　　　　　　　目（部署）</td>
		<td width="25%">リネンサプライ売上</td>
		<td width="25%">クリーニング他売上</td>
	</tr>
	<?php foreach($list_order as $order){ ?>
	<tr>
		<td style="text-align: left;"><?php echo($order->{DL_DEPARTMENT_NAME}) ?></td>
		<td style="text-align: right;">
			<?php echo($order->sum_price_cate1) ?>
		</td>
		<td style="text-align: right;">
			<?php echo($order->sum_price_cate2) ?>
		</td>
	</tr>
	<?php } ?>
</table>
<?php foreach($list_order as $order){ ?>
<div style="margin-top: 30px;"><span><b>請求明細 </b></span><span><?php echo($order->{DL_DEPARTMENT_NAME}) ?></span></div>
<!-- product list of category 1 -->
<?php if(!empty($order->product_list_cate1)){ ?>
<div>
	<span>種目：ﾘﾈﾝｻﾌﾟﾗｲ </span>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<span><?php echo number_format($order->sum_price_cate1) ?>円</span>
</div>
<table width="100%" class="table_">
	<tr class="thead">
		<td width="10%">日付</td>
		<td width="10%">商品ID</td>
		<td>商品名</td>
		<td width="10%">色調</td>
		<td width="10%">規格</td>
		<td width="10%">数量</td>
		<td width="10%">単価</td>
		<td width="10%">金額</td>
	</tr>
	<?php $i=1; ?>
	<?php $sum_price = 0; ?>
	<?php foreach($order->product_list_cate1 as $product){ ?>
	<tr>
		<td><?php if($i == 1) echo(explode(' ', $product->{SL_REVENUE_DATE})[0]);$i=0; ?></td>
		<td><?php echo($product->{PL_PRODUCT_CODE_SALE}) ?></td>
		<td><?php echo($product->{DD_PRODUCT_NAME}) ?></td>
		<td><?php echo($product->{PL_COLOR_TONE}) ?></td>
		<td><?php echo($product->{PL_STANDARD}) ?></td>
		<td><?php echo($product->{DD_QUANTITY}) ?></td>
		<td><?php echo($product->{DD_UNIT_PRICE}) ?></td>
		<td><?php echo number_format($product->{DD_QUANTITY}*$product->{DD_UNIT_PRICE}) ?></td>
		<?php $sum_price += $product->{DD_QUANTITY}*$product->{DD_UNIT_PRICE}; ?>
	</tr>
	<?php } ?>
	<?php if($order->{ID_DISCOUNT_SUPPLIER}>0){ ?>
	<tr>
		<td></td>
		<td>値引き</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><?php echo number_format($sum_price*$order->{ID_DISCOUNT_SUPPLIER}/100) ?></td>
	</tr>
	<?php } ?>
</table>
<?php } ?>
<!-- product list of category 2 -->
<?php if(!empty($order->product_list_cate2)){ ?>
<div>
<span>種目：ｸﾘｰﾆﾝｸﾞ他 </span>
&nbsp;&nbsp;&nbsp;&nbsp;
<span><?php echo($order->sum_price_cate2) ?>円</span>
</div>
<table width="100%" class="table_">
	<tr class="thead">
		<td width="10%">日付</td>
		<td width="10%">商品ID</td>
		<td>商品名</td>
		<td width="10%">色調</td>
		<td width="10%">規格</td>
		<td width="10%">数量</td>
		<td width="10%">単価</td>
		<td width="10%">金額</td>
	</tr>
	<?php $i=1; $sum_price = 0; ?>
	<?php foreach($order->product_list_cate2 as $product){ ?>
	<tr>
		<td><?php if($i) echo(explode(' ', $product->{SL_REVENUE_DATE})[0]);$i=0; ?></td>
		<td><?php echo($product->{PL_PRODUCT_CODE_SALE}) ?></td>
		<td><?php echo($product->{DD_PRODUCT_NAME}) ?></td>
		<td><?php echo($product->{PL_COLOR_TONE}) ?></td>
		<td><?php echo($product->{PL_STANDARD}) ?></td>
		<td><?php echo($product->{DD_QUANTITY}) ?></td>
		<td><?php echo($product->{DD_UNIT_PRICE}) ?></td>
		<td><?php echo($product->{DD_QUANTITY}*$product->{DD_UNIT_PRICE}) ?></td>
		<?php $sum_price += $product->{DD_QUANTITY}*$product->{DD_UNIT_PRICE}; ?>
	</tr>
	<?php } ?>
	<?php if($order->{ID_DISCOUNT_ORTHER}>0){ ?>
	<tr>
		<td></td>
		<td>値引き</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><?php echo number_format($sum_price*$order->{ID_DISCOUNT_ORTHER}/100) ?></td>
	</tr>
	<?php } ?>
</table>
<?php } ?>
<?php } ?>
<div class="l_footer">
	<table class="l-table">
		<tr>
			<td>お振込みは右記の銀行に</td>
			<td>三井住友銀行</td>
			<td>赤坂支店</td>
			<td>普通　７１２９２３８</td>
		</tr>
		<tr>
			<td>お願い申し上げます。</td>
			<td>三菱東京UFJ銀行</td>
			<td>麹町中央店</td>
			<td>普通　４６７９３８８</td>
		</tr>
		<tr>
			<td></td>
			<td>みずほ銀行</td>
			<td>五反田支店</td>
			<td>普通　１４３１６５０</td>
		</tr>
	</table>
</div>
<div class="r_footer">
	<table class="r-table">
		<tr>
			<td></td>
			<td></td>
		</tr>
	</table>
</div>

</body>
</html>