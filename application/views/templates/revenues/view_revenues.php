<div class="wrapper-contain revenues">
<div class="row" style="margin-top:9px;">
    <div class="col-md-6">
    <div  class="wrapper-table">
        <table class="table_1">
            <tr>
               <td>注文No:</td>
               <td>000-001</td>
            </tr>
 <!--           <tr>
               <td>請求書種別:</td>
               <td><input type="text" value="請求明細書 "  style="border:none;"></td>
            </tr>-->
     <!--       <tr>
               <td>お得意先:</td>
               <td><input type="text" value="株式会社ニューオータニ　御中 "  style="border:none;"></td>
            </tr>-->
            <tr>
               <td>請求書選択:</td>
               <td>株式会社ニューオータニ</td>
            </tr>
          
            <tr>
               <td> 売上(納品)日:</td>
               <td>2016/08/30 - 2016/09/30</td>
           </tr>
              <tr>
               <td>部署指定:</td>
               <td>XXXX部署、YYYY部署、ZZZZZ部署</td>
            </tr>
           <tr>
               <td>得意先住所</td>
               <td>〒000-0000   東京都</td>
               
           </tr>
         <!--   <tr>
               <td>注文No.</td>
               <td>001,002,003,004</td>
               
           </tr>-->
        </table>
    </div>
    </div>
    <a style="float:right;" href="" class="print">印刷 </a>
</div>

<div class="clearfix"></div>
<div class="row">
    <div style="float:right;">
                    <a href="#dialog-form" class="print del-revenues">削除</a>
                    <a href="<?php echo site_url('revenues/edit-revenues');?>" class="print">編集</a>
                    
                </div>
</div>
<div class="row display">
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;">請求書表紙</caption>
            <th style="width:65%;">部署名</th>
            <th style="width:35%;">金額（円） </th>
            <tr>
                <td>A部署  </td>
                <td>107,500</td>
            </tr>
            <tr>
                <td>B部署            </td>
                <td>91,500</td>
         
            </tr>
            <tr>
                <td class="align-right"> 小計</td>
                <td>199,000</td>
               
            </tr>
            <tr>
                <td class="align-right">値引き</td>
                <td>0</td>
            </tr>
            <tr>
                <td class="align-right">消費税</td>
                <td>15,920</td>
            </tr>
            <tr>
                <td class="align-right">合計</td>
                <td>214,920
                </td>
            </tr>
    </tbody>
</table>
</div>
<div class="row" style="margin:9px;">
      <label class="" for="comment">備考（納品）</label>
      <textarea class=" form-control" rows="5" id="comment">  </textarea>
</div>   
<div class="row display">
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;">請求書明細書１：A部署</caption>
            <th>商品コード</th>
            <th>商品名</th>
            <th>数量</th>
            <th>単価</th> 
            <th>金額（円） </th>
        <tr>
            <td>0000</td>
            <td>デュペ　ピンク</td>
            <td>100</td>
            <td>500</td> 
            <td>50000 </td>
        </tr>
        <tr>
            <td>0000
            </td>
            <td>デュペ　イエロー</td>
            <td>15</td>
            <td>500</td> 
            <td>7500 </td>
        </tr>
        <tr>
            <td>0000</td>
            <td>デュペ　ブラック</td>
            <td>100</td>
            <td>500</td> 
            <td>50000 </td>
        </tr>
        <tr>
            <td class="align-right" >小計</td>
            <td></td>
            <td></td>
            <td></td>
            <td>107500 </td>
        </tr>
        <tr>
            <td class="align-right">値引き</td>
            <td></td>
            <td></td>
            <td></td>
            <td>0 </td>
        </tr>
        <tr>
            <td class="align-right" >消費税</td>
            <td></td>
            <td></td>
            <td></td>
            <td>8,600</td>
        </tr>
        <tr>
            <td class="align-right" >合計</td>
            <td></td>
            <td></td>
            <td></td>
            <td>116,100</td>
        </tr>
    </tbody>
</table>  								
</div>				
	                            
<div class="row display">										
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;">請求書明細書２：B部署</caption>
            <th>商品コード</th>
            <th>商品名</th>
            <th>数量</th>
            <th>単価</th> 
            <th>金額（円） </th>
        <tr>
            <td>0000</td>
            <td>デュペ　ピンク</td>
            <td>120</td>
            <td>500</td> 
            <td>60000 </td>
        </tr>
        <tr>
            <td>0000</td>
            <td>デュペ　ブラック  </td>
            <td>45</td>
            <td>500</td> 
            <td>22500 </td>
        </tr>
        <tr>
            <td>0000</td>
            <td>SS　白</td>
            <td>30</td>
            <td>300</td> 
            <td>9000 </td>
        </tr>
        <tr>
            <td  class="align-right">小計</td>
            <td></td>
            <td></td>
            <td></td>
            <td>91500 </td>
        </tr>
        <tr>
            <td class="align-right">値引き</td>
            <td></td>
            <td></td>
            <td></td>
            <td>0 </td>
        </tr>
        <tr>               
            <td  class="align-right">消費税</td>
            <td></td>
            <td></td>
            <td></td>
            <td>7320</td>
        </tr>
        <tr>
            <td  class="align-right">合計</td>
            <td></td>
            <td></td>
            <td></td>
            <td>98,820</td>
        </tr>
    </tbody>
</table>  
</div>		                               
</div>	
