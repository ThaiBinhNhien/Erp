<html>
<head>
    <meta charset="utf-8" />
    <style>
    .buying-order table{
        border-collapse: collapse;
    }
.buying-order table td,.buying-order table th{
    border:1px solid black;
    text-align: center;
    padding:5px;
}
table input{
  width:calc(100% - 2px) !important;
  border: 0px solid #878898 !important;
  margin:1px !important;
  height:32px;
  }
table textarea{
  width:calc(100% - 2px) !important;
  border: 0px solid #878898 !important;
  margin:1px !important;
  height:100% !important;
  resize: none;
  }
body{
    font-family : "sun-exta";
}
.order_number{
    float:left;
    width:50%;
}
.date{
    float:right;
    width:50%;
    text-align: right;
}
h3{
    font-size: 34px;
    text-align: center;
    font-weight: bold;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    margin-bottom:20px;
}
.left-info-2{
    float:left;
    width:60%;
}
.left-info-2 table td{
    font-size:18px;
}

.right-info-2{
    float:right;
    width:40%;
}
.right-info-2 table{

}
.left-info-2 table{
    border-collapse: collapse;
}
.left-info-2 table td{
    border-bottom:1px solid black;
} 
h4{
    font-size:24px;
    font-weight: bold;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
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
p{
    font-size: 14px !important;
    font-weight: bold;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}
th{
    background: rgb(166, 166, 165) !important;
    color:#000;
}
#buying .total_price{
    text-align: right !important;
    padding-right:5px !important;
    font-weight: bold;
    border:none !important;
}
#buying-detail td:nth-child(6),#buying-detail td:nth-child(7),#buying-detail td:nth-child(8){
    text-align: right;
    padding-right:5px;
}
.footer table{
    border-collapse:separate;
    border-spacing:5px 0;
}
.footer table td,.footer table th{
    border:1px solid black;
    padding:3px;
}
.footer td:nth-child(4),.footer td:nth-child(3){
    text-align: center;
    margin-left:5px;
}
.footer th:nth-child(1),.footer th:nth-child(2){
    letter-spacing: 10px;
}
.footer tbody td{
    font-size: 11px;
}
</style>
</head>
<body>
<div style="padding-bottom: 10px;">
    <h3>発 注 伝 票(注文書)</h3>    
</div>
<div>
<div class="wrapper-contain order">
    <div class="left-info-2">
    <table> 
        <tr>
            <td><?php echo $supplier_place ?></td>
            <td><h4>御中</h4></td>
        </tr>
        <tr>
            <td><?php echo $supplier_user_name; ?></td>
            <td>様</td>
            <input type="hidden" id="user_login" value="<?php echo($_SESSION['login-info'][U_ID]) ?>">
        </tr>
    </table>
    </div>
    <div  class="right-info-2">
        <table>
        <tr><td>
            
        <?php echo $base_master->{BM_COMPANY_NAME} ?><br>
        〒: <?php echo $base_master->{BM_POSTAL_CODE} ?><br>
        <?php echo $base_master->{BM_ADDRESS_1} ?><br>
        <?php echo $base_master->{BM_ADDRESS_2} ?><br>
        TEL:<?php echo $base_master->{BM_PHONE_NUMBER} ?> FAX:<?php echo $base_master->{BM_FAX_NUMBER} ?>
        
        </td></tr>
    </table>  
    </div>
    
</div>

<div class="buying-order">
<div style="overflow-x:auto !important;" class="third-row">     
<p>●下記商品のを発注を致しますので、ご不明な点等ございましたら左記へご連絡下さい。</p>
    <table id="buying-detail" width="100%">
    <thead>
        <tr class="header">
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
        <?php $i = 0; ?>
        <?php foreach($product_list as $product){ ?>
        <tr>
            <td class='center-text'><?php echo $product->{PL_PRODUCT_CODE_BUY}; ?></td>
            <td class='left-text'><?php echo $product->{PL_PRODUCT_NAME_BUY}; ?></td>
            <td><?php echo $product->{PL_COLOR_TONE} ?></td>
            <td><?php echo $product->{PL_STANDARD} ?></td>
            <td><?php echo $product->{PL_ORGANIZATION_PILE} ?></td>
            <td class='quantity'><?php echo $product->{TGRI_NUMBER_OF_ORDERS} ?></td>
            <td class='price'>¥<?php echo $product->{TGRI_UNIT_PRICE} ?></td>
            <td class='summarize'>¥<?php echo $product->price ?></td>
            <td><?php echo $remark_arr[$i]; ?></td>
            <?php $i++; ?>
        </tr>
        <?php } ?>
        <!-- <tr class="sum-col">
            <td colspan="6" style="border-style: none !important;text-align: right;">合計</td>
            <td colspan="2" style="text-align: right;"><?php echo $sum_price; ?></td>
        </tr>
         <tr class="sum-col">
            <td colspan="6" style=" border-style: none !important;text-align: right;"> 値引</td>
            <td colspan="2" class="right-text" style="text-align: right;"><?php echo $discount; ?>(%)</td>
        </tr>
        <tr class="sum-col">
            <td colspan="6" style="border-style: none !important;text-align: right;"> 総合計</td>
            <td colspan="2" class="right-text" style="text-align: right;"><?php echo $total_price; ?></td>
        </tr> -->
         <tr>
            <td colspan="7" style="border-style: none !important;text-align: right;font-weight:bold;" class='total_price'>合計(税別)</td>
            <td class="right-text">¥<?php echo $total_price; ?></td>
        </tr>
    </tbody>
</table>
</div>

</div>                                  
</div>
</body>
</html>