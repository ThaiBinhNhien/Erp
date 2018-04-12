<style type="text/css">
    .not-active {
      pointer-events: none;
      cursor: default;
    }
    @media print
   {
      #detail {
        width:400px;
      }
/*      @page {
        size: 7in 9.25in;
        margin: 27mm 16mm 27mm 16mm;
    }*/
   }
</style>
<div class="wrapper-contain purchase order">
<div class="row">
	<div class="col-md-4">
	<div class="row"> 
		<h3>出庫伝票</h3>
	</div>
<div class="row">
		<table id="detail" class="detail-table">
			<tr>
			   <td>出庫No:</td>
			   <td id="id-export-order"><?php echo($id); ?></td>
			</tr>
			<tr>
			   <td>起票者:</td>
			   <td><?php echo($issuer); ?></td>
			</tr>
			<tr>
			   <td>出庫者:</td>
			   <td><?php echo($ship_issuer); ?></td>
			</tr>
			<tr>
			   <td>出庫日:</td>
			   <td><?php echo($date_export); ?></td>
			</tr>
			<tr>
			   <td>販売先:</td>
			   <td><?php echo($sales_destination); ?></td>
			</tr>
			<tr>
			   <td>出庫内容:</td>
			   <td><?php echo($processing_content); ?></td>
			</tr>
            <tr>
                <td>在庫場所:</td>
                <td><?php echo $stock; ?></td>
            </tr>
		</table>
	</div>         
	</div>
<div class="button-right-side">
		<a href="<?php echo site_url('purchase/export-purchase') ?>" class="print right">MENU画面へ</a>
		<a href="javascript:forprint()" class="print right top-print">印刷</a>
        <a href="<?php echo site_url('purchase/export-delivery-note?id='.$id) ?>" class="print right top-print
            <?php if($export_content[0]->id=='2'||$export_content[0]->id=='8'){ echo 'active'; } else { echo 'not-active' ;}?>">納品書出力 
        </a>
	</div>
</div>
<div class="row">
	<a href="<?php echo site_url('purchase/edit-export-purchase?id='.$id) ?>" class="print right <?php if($check_edit == 0) echo 'not-active' ?>">
    編集 
    </a>
</div>
<div class="row">
<div class="row sec-row margin-top-table">									
<table class="no-order-table">
    <thead>
        <tr>
            <th>商品コード</th>
            <th>商品名</th>
            <th>色調</th>
            <th>規格</th>
            <th>単価（円）</th>
            <th>現貯蔵品数</th>
            <th>出庫数</th>
            <th>合計（円）</th>  
        </tr>
    </thead>
    <tbody>
        <?php foreach ($product_list as $product){ ?>
            <tr>
                <td><?php echo $product->{PL_PRODUCT_CODE_BUY} //id ?></td>
                <td><?php echo $product->{PL_PRODUCT_NAME_BUY} //tên ?></td>
                <td><?php echo $product->{PL_COLOR_TONE} ?></td>
                <td><?php echo $product->{PL_STANDARD} ?></td>
                <td><?php echo $product->price_unit //đơn giá ?></td>
                <td><?php echo $product->amount_stock //số lượng trong kho ?></td>
                <td><?php echo $product->amount // số lượng xuất kho?></td>
                <td><?php echo $product->total_price // tổng tiền ?></td>
            </tr>
        <?php } ?>
        <!--<tr>
            <td>0000</td>
            <td>SDシーツ</td>
            <td>白</td>
            <td>55*100</td>
            <td>100</td>
            <td>235</td>
            <td>50</td>
            <td>5,000</td>
        </tr>-->
        <tr class="sum-col">
             <td>合計</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo $sum_total_price ?></td>
        </tr>
    </tbody>
</table>
</div>
<div class="sec-row margin-top-table">
	<label class="" for="comment">備考</label>
	<textarea class=" form-control" rows="5" id="comment" disabled><?php echo($note); ?></textarea>
</div>
</div>  
	<div class="row first-row">
	<a href="#" class="print del-export-order left <?php if($is_P) echo 'not-active'; ?>">削除</a>
	</div>
</div>
<script>
  var base_url = '<?php echo(base_url()) ?>';
</script>
