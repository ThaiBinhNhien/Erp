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
		  <a href="<?php echo site_url('revenues');?>" class="print right top-print">MENU画面へ</a>  
	</div>
	<div class="row">
	<form class="form-horizontal" role="form">
    <div class="row">
		<div class="col-sm-12 col-md-4 col-lg-4">
			<div class="form-group">
				<label for="inputEmail" class="col-md-4 control-label">請求伝票No:</label>
				<div class="col-md-8">
					<!--<input class="form-control" style="border:none;background:none;" value="001" disabled>-->
					<span style="line-height:2.5;">001</span>
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
				<span style="line-height:2.5;">株式会社ニューオータニ</span>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-md-4 control-label">請求書選択:</label>
				<div class="col-md-8">
<!--					<select ><option>請求明細書</option></select>-->
					<span style="line-height:2.5;">請求明細書</span>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-8 col-lg-8">	
			<div class="form-group">
				<label for="inputEmail" class="col-md-2 control-label" style="width:75px;">住所:</label>
				<div class="col-md-10">
					<textarea style="width:100%;height:68px;float:left;">
東京都 目黒区
XXXX 
〒 １２３－４５６ XXXXXXXXXXXXXXXXXXXXｘ
					</textarea>
				</div>
			</div>
      </div>
	</div><!--End row -->	
	<div class="clearfix visible-lg-block visible-md-block"></div>
		<div class="col-sm-12 col-md-4 col-lg-4">
			<div class="form-group">
				<label for="inputPassword" class="col-md-4 control-label">売上(納品)日:</label>
				<div class="col-md-8">
					<!--<span class="form-control form-control-input">
						<input  class="datepicker" >
						<span class=" icon-large icon-calendar "></span>
					</span> -->
					<span style="line-height:2.5;">2016/08/30 ~ 2016/09/30 </span>
				</div>
			</div>
      </div>
      <!--<div class="col-sm-12 col-md-4 col-lg-4">
		  <div class="form-group ">
			  <label  class="col-md-4 control-label center" style="line-height:2.5;padding-top:0;"> <span id="character">~</span></label>
			  <div class="col-md-8">
				  <span class="form-control form-control-input">
					  <input  class="datepicker" >
					  <span class=" icon-large icon-calendar "></span>
				  </span>    
			  </div>
		  </div>
      </div>-->
	 <div class="clearfix visible-lg-block visible-md-block"></div>
     <div class="col-sm-12 col-md-4 col-lg-4" style="margin-top:5px;">
		 <div class="form-group">
			 <label for="input9" class="col-md-4 control-label">部署名:</label>
			 <div class="col-md-8">
				 <!--<input value="XXXX部署、YYYY部署、ZZZZZ部" class="no-bottom-margin"/>-->
				 <span style="line-height:2.5;">XXXX部署、YYYY部署、ZZZZZ部</span>
			 </div>
        </div>
      </div>
    </div>
	</form>
	</div><!--End first row-->
<div class="row sec-row ">
    <table class="add-table margin-top-table first-add-table ">
        <caption class="left-text " style="margin-bottom:15px;">請求書表紙</caption>
    <tbody>
            <th style="width:65%;">部署名</th>
            <th style="width:35%;">金額（円） </th>
            <tr>
                <td class="left-text">A部署</td>
                <td class='right-text'>107,500</td>
            </tr>
            <tr>
                <td >B部署            </td>
                <td class='right-text'>91,500</td>
            </tr>
            <tr>
                <td class='right-text'> 小計</td>
                <td class='right-text'>199,000</td>
            </tr>
            <tr>
                <td class='right-text'>値引き</td>
                <td style="text-align:center;padding:0;"><input value="0" class="input right-text text"></td>
            </tr>
            <tr>
                <td class='right-text'>消費税</td>
                <td class='right-text '>15,920</td>
            </tr>
            <tr class="sum-col">
                <td class='right-text '>合計</td>
                <td class='right-text '>214,920</td>
            </tr>
    </tbody>
</table>     
<div class="row first-row">
            <label class="" for="comment">備考</label>
            <textarea class=" form-control" rows="5" id="comment">   
            </textarea>
</div>   
</div>
<div class="row sec-row">
<table class="add-table first-add-table">
    <tbody>
        <caption class="left">請求書明細書１：A部署</caption>
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
            <td>0000</td>
            <td>デュペ　イエロー</td>
            <td>15</td>
            <td>500</td> 
            <td class="right-text">7500 </td>
        </tr>
        <tr>
            <td>0000</td>
            <td>デュペ　ブラック  </td>
            <td>100</td>
            <td>500</td> 
            <td class="right-text">50000 </td>
        </tr>
        <tr>
            <td class="right-text">小計</td>
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
            <td  style="text-align:center;padding:0;"><input value="0" class="input right-text text"></td>
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
<div class="row third-row margin-top-table">											
<table class="add-table second-add-table">
    <tbody>
        <caption class="left">請求書明細書２：B部署 </caption>
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
            <td>45</td>
            <td>500</td> 
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
            <td class="right-text">小計</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">91500</td>
        </tr>
        <tr>
            <td class="right-text">値引き</td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:center;padding:0;"><input value="0" class="input right-text text"></td>
        </tr>
        <tr>
            <td class="right-text">消費税</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">7320</td>
        </tr>
        <tr class="sum-col">
            <td class="right-text">合計</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right-text">98,820</td>
        </tr>
    </tbody>
</table> 
</div>
<div class="row first-row">
	<a href="<?php echo site_url('revenues');?>" class="print print-1 left"><!--<i class="fa fa-floppy-o"></i>-->戻る</a>
	<a href="#dialog-form" class="print  print-1 save-revuenues right"><!--<i class="fa fa-floppy-o"></i>-->保存 </a>  
</div><!--End button row-->
</div><!--End wrapper contain-->

