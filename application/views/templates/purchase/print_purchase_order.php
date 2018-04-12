<style>
table input{
  width:calc(100% - 2px) !important;
  border: 1px solid #878898 !important;
  margin:1px !important;
  height:32px;
  }
table textarea{
  width:calc(100% - 2px) !important;
  border: none !important;
  margin-top:5px !important;
  height:100% !important;
  resize: none;
  /*/margin-top:10px ;*/
  }
  body{
    font-family : "sun-exta";
}
.panel{
    margin-top:9px;
}
.panel .print{
    width:105px;
}
.panel a:nth-child(1){
    margin-right:0px;
}
.order h3{
    font-size:34px;
}
/* Number order and date */
table.info-1{
    width:100%;
    margin-top:9px;
}
    .info-1 td{
        width:50%;
        font-size:14px;
        font-weight:500;
    }
    .info-1 td:nth-child(1){
        text-align: left;
        padding-left:10px;
    }
    .info-1 td:nth-child(2){
        text-align: right;
        padding-right:10px;
    }
.left-info-2{
    float:left;
    margin-left:9px;
}
.left-info-2 td{
    font-size:20px;
}

.right-info-2{
    float:right;
    margin-right:9px;
}
.left-info-2 td{
    border-bottom:1px solid black;
} 
.left-info-2 span{
    font-size:24px;
    font-weight: bold;
}
.left-info-2 td:nth-child(1){
    text-align: center;
}
.left-info-2 td:nth-child(2){
    padding-left:5px;
}
.right-info-2 td{
    font-size:14px;
}
th{
    background: rgb(74, 69, 60) !important;
}
p{
    font-size: 14px !important;
    font-weight: bold;
}
td p{
    font-weight: normal;
}
td input{
    border:none !important;
}
td input:focus,textarea:focus{
    //border:1px solid blue;
    background:#e4e48a;
}
.total_price{
    text-align: right !important;
    padding-right:5px !important;
    font-weight: bold;
    border:none !important;
}
#buying-detail td:nth-child(6),#buying-detail td:nth-child(7),#buying-detail td:nth-child(8){
    text-align: right;
    padding-right:5px;
}
#buying-detail .right-text{
    padding-right:5px;
    font-weight: bold;
}
.info-4{
    height: 150px;
}
form{
    margin:0 !important;
}
</style>
  <div class="panel panel-default">
    <div class="panel-body">
        <a href="<?php echo site_url('purchase') ?>" class="print right">MENU画面へ</a>
        <a class="print right print_pdf">印刷 </a>
    </div>
  </div>
<div class="wrapper-contain order" style="padding-bottom: 10px;">
<div class="row">
<table  class="info-1">
    <tr>
        <td>発注書NO:<?php echo $id ?> 仕入先NO:<?php echo $supplier_id ?></td>
        <td>発注日:<?php echo str_replace('-', '/', $create_date) ?></td>
    </tr>
</table>
</div>
<div class="row">
   <div class="col-md-12">
        <h3 class="text-center">発　注　伝　票（注文書）</h3>    
   </div>
</div>
<div class="row">
    <table class="left-info-2"> 
        <tr>
            <td><?php echo $supplier_place ?></td>
            <td><span>御中</span></td>
        </tr>
        <tr>
            <td><?php echo $supplier_user_name; ?></td>
            <td>様</td>
            <input type="hidden" id="user_login" value="<?php echo($_SESSION['login-info'][U_ID]) ?>">
        </tr>
    </table>
    <table class="right-info-2">
        <tr><td>
        <?php echo $base_master->{BM_COMPANY_NAME} ?></br>
        〒: <?php echo $base_master->{BM_POSTAL_CODE} ?></br>
        <?php echo $base_master->{BM_ADDRESS_1} ?></br>
        <?php echo $base_master->{BM_ADDRESS_2} ?></br>
        TEL:<?php echo $base_master->{BM_PHONE_NUMBER} ?> FAX:<?php echo $base_master->{BM_FAX_NUMBER} ?>
        </td></tr>
    </table>    
    
</div>

<div class="row">
<form id="print_pdf_purchase_order" method="POST" action="<?php echo site_url('purchase/print_pdf_purchase_order') ?>">
<input type="hidden" name="id" value="<?php echo($id) ?>">
<p style="font-size: 12px;">●下記商品のを発注を致しますので、ご不明な点等ございましたら左記へご連絡下さい。</p>
<div style="overflow-x:auto !important;" class="third-row">		

	<table class="no-order-table" id="buying-detail">
    <thead>
        <tr>
            <th>商品コード</th>
            <th>商品名</th>
            <th>色調</th>
            <th>規格</th>
            <th>素材</th>
            <th>数量</th>
            <th>仕入単価</th>
            <th>金額（円）</th>  
            <th>備 考</th> 
        </tr>
    </thead>
    <tbody>
        <?php foreach($product_list as $product){ ?>
        <tr>
            <td class='center-text'><?php echo $product->{PL_PRODUCT_CODE_BUY}; ?></td>
            <td class='left-text'><?php echo $product->{PL_PRODUCT_NAME_BUY}; ?></td>
            <td><?php echo $product->{PL_COLOR_TONE} ?></td>
            <td><?php echo $product->{PL_STANDARD} ?></td>
            <td><?php echo $product->{PL_ORGANIZATION_PILE} ?></td>
            <td class='quantity'><?php echo $product->{TGRI_NUMBER_OF_ORDERS} ?></td>
            <td class='price'><?php echo $product->{TGRI_UNIT_PRICE} ?></td>
            <td class='summarize'>¥<?php echo $product->price ?></td>
            <td><input name="remark[]" value="<?php echo $product->{PL_REMARKS} ?>" class="remark"></td>
        </tr>
        <?php } ?>
        <!--
        <tr class="sum-col">
            <td colspan="6" >合計</td>
            <td colspan="2" class="right-text"><?php echo $sum_price; ?></td>
        </tr>
         <tr class="sum-col">
            <td colspan="6"> 値引</td>
            <td colspan="2" class="right-text"><?php echo $discount; ?>(%)</td>
        </tr>
        -->
        <tr>
            <td colspan="7" class='total_price'>合計(税別)</td>
            <td class="right-text">¥<?php echo $total_price; ?></td>
        </tr>
    </tbody>
</table>
</div>
<div class="row">
    <div class="col-md-4">
    <table class="no-order-table info-4">
        <thead>
            <tr>
                <th>納　　品　　場　　所</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: left;">
                    <p style="font-size: 12px;margin:5px;"><?php echo $base->{BM_BASE_NAME} ?>工場</p>
                    <p style="font-size: 12px;margin:5px;">〒:<?php echo $base->{BM_POSTAL_CODE} ?></p>
                    <p style="font-size: 12px;margin:5px;"><?php echo $base->{BM_ADDRESS_1}." ".$base->{BM_ADDRESS_2} ?></p>
                    <p style="font-size: 12px;margin:5px;"><?php echo $base->{BM_COMPANY_NAME} ?></p>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    <div class="col-md-5" style="height: 100%">
        <table class="no-order-table info-4">
            <thead>
                <tr>
                    <th>注　　意　　事　　項　　等</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <textarea name="comment" id="comment">
●月末（26日以降）の納品及び分納の際はご一報下さい。
●納入枚数の変更や、納入日が決まりましたらご一報下さい。　　　
●納品は木・日曜日（定休日）を除く、午前（9：00～11：30）と午後（13：00～16：00）にお願い致します。
●納品書は物品に添付又は、商品到着前後の2日以内に厚木工場（発注者）迄ご郵送下さい。
                        </textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-2">
        <table class="no-order-table info-4">
            <thead>
                <tr>
                    <th>発注内容</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="height: 95px">
                        <p style="font-size: 12px;"><?php echo $order_content; ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-1">
        <table class="no-order-table info-4">
            <thead>
                <tr>
                    <th>発注者</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="height: 95px">
                        <p style="font-size: 12px;"><?php echo $user; ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>   
</form>                               
</div>
<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
</script>