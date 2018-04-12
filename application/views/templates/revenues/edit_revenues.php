<style>
	.detail-table input[type="text"]{
		border:1px solid rgba(154, 161, 168, 0.46) !important;
	}
	.edit-revenues left-text{
		text-align: left !important;
	}
	.edit-revenues right-text{
		text-align: right !important;
	}
	.edit-revenues .center-text{
		text-align: center !important;
	}
	.edit-revenues .input{
		width:100%;
		margin:0;
		padding:0;
		height:95%;
		border:1px solid rgba(154, 161, 168, 0.46);
	}
	.edit-revenues .first-edit-table td:nth-child(n+3){
		width:15%;
	}
	.edit-revenues .first-edit-table td:nth-child(1)
	{
		width:20%;
	}
	td input.text{
		padding-right:2px !important;
	}
</style>
<div class="wrapper-contain  edit-revenues order">
<div class="row">
    <div class="col-md-4">
    
		<table class="detail-table">
            <tr>
               <td>注文No:</td>
               <td>000-001</td>
            </tr>
            <tr>
               <td>請求書種別:</td>
               <td>請求明細書</td>
            </tr>
            <tr>
               <td>お得意先:</td>
               <td>株式会社ニューオータニ</td>
            </tr>
            <tr>
               <td>部署指定:</td>
               <td>XXXX部署、YYYY部署、ZZZZZ部署</td>
            </tr>
            <tr>
               <td>納品日:</td>
               <td>2016/08/30 - 2016/09/30</td>
           </tr>
           <tr>
               <td>得意先住所</td>
               <td><input  type="text" value="〒000-0000   東京都" style="width:250%"></td>
           </tr>
        </table>
	</div>
<div class="right">
	<a href="<?php echo site_url('revenues/detail-revenues-2');?>" class="print top-print">MENU画面へ</a>
	</div>
</div>
<div class="row third-row">
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;">請求書表紙</caption>
            <th style="width:65%;">部署名</th>
            <th style="width:35%;">金額（円） </th>
            <tr>
                <td>A部署  </td>
                <td class="right-text">107,500</td>
            </tr>
            <tr>
                <td>B部署            </td>
                <td class="right-text">91,500</td>
            </tr>
            <tr>
                <td class="right-text"> 小計</td>
                <td class="right-text">199,000</td>
            </tr>
            <tr>
                <td class="right-text" >値引き</td>
                <td style="text-align:center;padding:0;"><input value="0" class="input right-text text"></td>
            </tr>
            <tr>
                <td class="right-text">消費税</td>
                <td class="right-text">15,920</td>
            </tr>
            <tr class="sum-col">
                <td class="right-text">合計</td>
                <td class="right-text">214,920
                </td>
            </tr>
    </tbody>
</table>
</div>
<div class="row third-row" >
      <label class="" for="comment">備考</label>
      <textarea class=" form-control" rows="5" id="comment">  </textarea>
</div>   
<div class="row sec-row">
<table  class="full-table first-edit-table">
    <tbody>
        <caption style="text-align:left;padding-top:0;">請求書明細書１：A部署</caption>
            <th>商品コード</th>
            <th>商品名</th>
            <th>数量</th>
            <th>単価</th> 
            <th>金額（円） </th>
            
        <tr>
            <td>0000</td>
            <td>デュペ　ピンク</td>
            <td class="center-text">100</td>
            <td class="center-text">500</td> 
            <td class="right-text">50000 </td>
        </tr>
        <tr>
            <td>0000
            </td>
            <td>デュペ　イエロー</td>
            <td class="center-text">15</td>
            <td class="center-text">500</td> 
            <td class="right-text">7500 </td>
        </tr>
        <tr>
            <td>0000</td>
            <td>デュペ　ブラック</td>
            <td class="center-text">100</td>
            <td class="center-text">500</td> 
            <td class="right-text">50000 </td>
        </tr>
        <tr>
            <td class="right-text" >小計</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">107500 </td>
        </tr>
        <tr>
            <td class="right-text">値引き</td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:center;padding:0;"><input value="0" class="input right-text text"></td>
        </tr>
        <tr>
            <td class="right-text" >消費税</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">8,600</td>
        </tr>
        <tr class="sum-col">
            <td class="right-text" >合計</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">116,100</td>
        </tr>
    </tbody>
</table>  								
</div>				
	                            
<div class="row third-row margin-top-table">										
<table  class="full-table first-edit-table">
    <tbody>
        <caption class="left" style="padding-top:0;">請求書明細書２：B部署</caption>
            <th>商品コード</th>
            <th>商品名</th>
            <th>数量</th>
            <th>単価</th> 
            <th>金額（円） </th>
        <tr>
            <td>0000</td>
            <td>デュペ　ピンク</td>
            <td class="center-text">120</td>
            <td class="center-text">500</td> 
            <td class="right-text">60000 </td>
        </tr>
        <tr>
            <td>0000</td>
            <td>デュペ　ブラック  </td>
            <td class="center-text">45</td>
            <td class="center-text">500</td> 
            <td class="right-text">22500 </td>
        </tr>
        <tr>
            <td>0000</td>
            <td>SS　白</td>
            <td class="center-text">30</td>
            <td class="center-text">300</td> 
            <td class="right-text">9000 </td>
        </tr>
        <tr>
            <td  class="right-text">小計</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">91500 </td>
        </tr>
        <tr>
            <td class="right-text">値引き</td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:center;padding:0;"><input value="0" class="input right-text text"></td>
        </tr>
        <tr>               
            <td  class="right-text">消費税</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">7320</td>
        </tr>
        <tr class="sum-col">
            <td  class="right-text">合計</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">98,820</td>
        </tr>
    </tbody>
</table>
    
</div>		
	<div class="row margin-bottom-table">
        <a href="#dialog-form" class="print right  save-created">保存 </a>  
    </div>
</div>	
