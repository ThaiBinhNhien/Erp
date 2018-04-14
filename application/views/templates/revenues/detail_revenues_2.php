<style>
.detail-revenues left-text{
		text-align: left !important;
	}
	.detail-revenues right-text{
		text-align: right !important;
	}
	.detail-revenues .center-text{
		text-align: center !important;
	}
	.detail-revenues td:nth-child(5){
		text-align: right;
	}
	.detail-revenues td:nth-child(3),.detail-revenues td:nth-child(4){
		text-align: center;
	}
	.detail-table td:nth-child(2){
		line-height: 1.5;
	}
	.detail-table td:nth-child(1){
		width:92px;
	}
</style>
<div class="wrapper-contain revenues order detail-revenues">
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
               <td>株式会社ニューオータニ　御中</td>
            </tr>
              <tr>
               <td>部署指定:</td>
               <td>A部署、B部署</td>
            </tr>
            <tr>
               <td>納品日:</td>
               <td>2016/08/30 - 2016/09/30</td>
           </tr>
            <!--  <tr>
               <td>部署指定:</td>
               <td>XXXX部署、YYYY部署、ZZZZZ部署</td>
            </tr>-->
           <tr>
               <td>得意先住所:</td>
               <td>〒000-0000   東京都</td>
               
           </tr>
         <!--   <tr>
               <td>注文No.</td>
               <td>001,002,003,004</td>
               
           </tr>-->
        </table>
    
    </div>
	<div class="button-right-side">
    <a  href="<?php echo site_url('revenues');?>" class="print right ">MENU画面へ </a>
	 <a href="" class="print right top-print">印刷 </a>
	 <a  href="" class="print right top-print">営業管理画面へ</a>
		</div>
</div>
	
<div class="clearfix"></div>
<div class="row">
    <div style="float:right;">
                    <a href="#dialog-form" class="print del-revenues">削除</a>
                    <a href="<?php echo site_url('revenues/edit-revenues');?>" class="print">編集</a>
                    
                </div>
</div>
<div class="row" style="margin:9px;">
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;padding-top:0;">請求書表紙</caption>
            <th style="width:65%;">部署名</th>
            <th style="width:35%;">金額（円） </th>
            <tr>
                <td>A部署  </td>
                <td class="right-text">107,500</td>
            </tr>
            <tr>
                <td>B部署</td>
                <td class="right-text">91,500</td>
         
            </tr>
            <tr>
                <td class="right-text"> 小計</td>
                <td class="right-text">199,000</td>
               
            </tr>
            <tr>
                <td class="right-text">値引き</td>
                <td class="right-text">0</td>
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
<div class="row third-row margin-top-table"  >
      <label class="" for="comment">備考</label>
      <textarea class=" form-control" rows="5" id="comment" disabled>  </textarea>
</div>   
<div class="row third-row">
<table  class="full-table">
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
            <td>100</td>
            <td>500</td> 
            <td class="right-text">50000 </td>
        </tr>
        <tr>
            <td>0000
            </td>
            <td>デュペ　イエロー</td>
            <td>15</td>
            <td>500</td> 
            <td class="right-text">7500 </td>
        </tr>
        <tr>
            <td>0000</td>
            <td>デュペ　ブラック</td>
            <td>100</td>
            <td>500</td> 
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
            <td class="right-text">0 </td>
        </tr>
        <tr>
            <td class="right-text">消費税</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">8,600</td>
        </tr>
        <tr class="sum-col">
            <td class="right-text">合計</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">116,100</td>
        </tr>
    </tbody>
</table>  								
</div>				
	                            
<div class="row third-row">										
<table  class="full-table">
    <tbody>
        <caption style="text-align:left;padding-top:0;">請求書明細書２：B部署</caption>
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
            <td class="right-text">0 </td>
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
</div>	
