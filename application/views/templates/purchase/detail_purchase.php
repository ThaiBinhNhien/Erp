<style>
	.detail-purchase-order .detail-table{
		margin-bottom:0 !important;
	}
	.detail-purchase-order .no-order-table .sum-col td:nth-child(1){
		text-align: right !important;
		padding-right:5px;
	}
	.detail-purchase-order .no-order-table td:nth-child(1){
		text-align: center;
	}
	.detail-purchase-order .no-order-table td:nth-child(2){
		padding-left:5px;
	}
	.detail-purchase-order .right-text{
		padding-right:5px !important;
	}
    a.disabled {
        cursor: not-allowed;
        background:#485a4a;
        border: 1px solid #485a4a;
        pointer-events: none;
        text-decoration:none;
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
<div class="wrapper-contain order purchase detail-purchase-order">
<div class="row">
   <div class="col-md-8">
    <h3>発注伝票 </h3>    

   </div>
	<div class="button-right-side">
	<a href="<?php echo site_url('purchase') ?>" class="print right">MENU画面へ</a>
	<a href="<?php echo site_url('purchase/print_purchase_order?id='.$id) ?>" class="print right top-print">印刷 </a>

    <!-- <a href="<?php echo site_url('purchase/export-delivery-note?id='.$id) ?>" class="print right top-print">納品書出力 </a> -->
</div>
    <div class="col-md-5 col-sm-8">
    <table id="detail" class="detail-table" style="border-bottom: 0px solid #485a4a !important;"> 
        <tr>
        <td>発注No:</td>
            <td id="order_id"><?php echo($id) ?></td>
        </tr>
        <tr>
            <td>起票者:</td>
            <td><?php echo $user; ?></td>
            <input type="hidden" id="user_login" value="<?php echo($_SESSION['login-info'][U_ID]) ?>">
        </tr>
        <tr>
            <td>発注日:</td>
            <td><?php echo str_replace('-', '/', $create_date); ?></td>
        </tr>
        <tr>
            <td>納品日:</td>
            <td><?php echo $date_import; ?></td>
        </tr>
        <tr>
            <td>仕入先:</td>
            <td><?php echo $supplier_place; ?></td>
        </tr>
        <tr>
            <td>販売先:</td>
            <td><?php echo $sales_des; ?></td>
        </tr>
        <tr>
            <td>発注内容:</td>
            <td><?php echo $order_content; ?></td>
        </tr>
        <tr>
            <td>納品場所:</td>
            <td><?php echo $stock; ?></td>
        </tr>
        <tr>
            <td>形態:</td>
            <td><?php if($is_confirm) echo "承認済";else echo "未承認"; ?></td>
        </tr>
        <tr>
            <td>入庫:</td>
            <td><?php if($done_import) echo('済'); else echo('未'); ?></td>
        </tr>
        <tr>
            <td>承認者:</td>
            <td><?php if($is_confirm) echo $confirm_user; ?></td>
        </tr>
	</table>
</div>
</div>
	<div class="row margin-bottom-table">

        <?php 
        //__Authority edit of user
        $disable = false;
        if($permission === false){
            if($user !== $info_user){
                $disable = true;
            } 
        }
        ?>
	<a href="<?php echo(base_url('purchase/editOrder?id='.$id)); ?>" class="print right <?php if($has_import||$disable) echo 'disabled'; ?>" onclick=" return <?php if($has_import||$disable) echo 'false';?> ;">
        編集 
    </a>                
    <a href="<?php echo(base_url('purchase/processing-purchase?id='.$id)); ?>" class="print right <?php if(!$is_confirm||$disable) echo 'disabled' ?>" onclick=" return <?php if(!$is_confirm||$disable) echo 'false';?> ;">入庫処理</a>
	</div>
<div style="clear:both;"></div>
<div class="row">
<div style="overflow-x:auto !important;" class="third-row">		

	<table class="no-order-table" id="buying-detail">
    <thead>
        <tr>
            <th>商品コード</th>
            <th>商品名</th>
            <th>色調</th>
            <th>規格</th>
            <th>数量</th>
            <th>入庫累計</th>
            <th>仕入単価</th>
            <th>金額（円）</th>  
            <!--<th>入庫日</th> --> 
        </tr>
    </thead>
    <tbody>
        <?php foreach($product_list as $product){ ?>
        <tr>
            <td class='center-text'><?php echo $product->{PL_PRODUCT_CODE_BUY}; ?></td>
            <td class='left-text'><?php echo $product->{PL_PRODUCT_NAME_BUY}; ?></td>
            <td><?php echo $product->{PL_COLOR_TONE} ?></td>
            <td><?php echo $product->{PL_STANDARD} ?></td>
            <td class='quantity'><?php echo $product->{TGRI_NUMBER_OF_ORDERS} ?></td>
            <td><?php echo $product->accumulation ?></td>
            <td class='price'><?php echo $product->{TGRI_UNIT_PRICE} ?></td>
            <td class='summarize'><?php echo $product->price ?></td>
        </tr>
        <?php } ?>
        <tr class="sum-col">
            <td colspan="7">合計</td>
            <td class="right-text"><?php echo $sum_price; ?></td>
            <!--<td></td>-->
        </tr>
         <tr class="sum-col">
            <td colspan="7"> 値引</td>
            <td class="right-text"><?php echo $discount; ?></td>
            <!--<td></td>-->
        </tr>
        <tr class="sum-col">
            <td colspan="7"> 総合計</td>
            <td class="right-text"><?php echo $total_price; ?></td>
            <!--<td></td>-->
        </tr>
    </tbody>
</table>
</div>
<div class="third-row margin-top-table">
        <label class="" for="comment">備考</label>
            <textarea class=" form-control" rows="5" id="comment" disabled><?php echo $remark; ?></textarea>
</div>
<div class="row margin-bottom-table	">
	<a class="print del-purchase-order left <?php if($has_import) echo 'disabled'; ?>">削除 </a>
<?php if($permission==1){ ?>
	<?php if(!$is_confirm & $status==1){?> <a class="print right purchase-confirm">承認する </a><?php } ?>
    <?php if($is_confirm){?> <a class="print right del-confirm <?php if($has_import) echo 'disabled'; ?>">承認を取り消す </a><?php } ?>

<?php } ?>
</div>
</div>                                  
</div>
<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
    var user_create = "<?php echo $user; ?>";
    var url_add_post_notification = "<?php echo base_url('notification/add');?>";
</script>