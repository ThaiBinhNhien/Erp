<style>
	.created-revenues tr:hover{
		cursor: pointer;
	}
	.created-revenues th{
		cursor: auto;
	}
</style>
<div class="wrapper-contain created-revenues order" id="revenues">
<div class="row">
<div class="col-md-6">
	<h3>作成済請求書 </h3>
	</div>
  <a href="<?php echo site_url('revenues');?>"  class="print right print-auto top-print">未請求注文伝票一覧</a>
	</div>
<div class="row first-row">

 
<form class="form-horizontal" role="form" >
    <div class="row">
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">請求書No:</label>
          <div class="col-md-8">
            <input class="form-control " >
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputPassword" class="col-md-4 control-label">注文伝票No:</label>
          <div class="col-md-8">
          <input class="form-control " >
          </div>
        </div>
      </div>
		
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input7" class="col-md-4 control-label">起票者:</label>
          <div class="col-md-8">
            <select class="form-control"><option></option></select>
          </div>
        </div>
      </div>
		<div class="clearfix"></div>
                <div class="clearfix"></div>
     
		
		
		
		
        <div class="clearfix visible-lg-block visible-md-block"></div>
		<div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputPassword" class="col-md-4 control-label">売上(納品)日:</label>
          <div class="col-md-8">
            <span class="form-control form-control-input">
            <input  class="datepicker" >
           <span class=" icon-large icon-calendar "></span>
            </span>    
            
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group ">
          <label  class="col-md-4 control-label center" style="line-height:2.5;padding-top:0;"> <span id="character">~</span></label>
          <div class="col-md-8">
           <span class="form-control form-control-input">
            <input  class="datepicker" >
           <span class=" icon-large icon-calendar "></span>
            </span>    
          </div>
        </div>
      </div>
	 <div class="clearfix visible-lg-block visible-md-block"></div>
		
		
		
     <div class="col-sm-12 col-md-4 col-lg-4" style="margin-top:5px;">
        <div class="form-group">
          <label for="input9" class="col-md-4 control-label">得意先:</label>
          <div class="col-md-8">
              <select class="form-control"><option></option></select>
          </div>
        </div>
      </div>
   <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input9" class="col-md-4 control-label " style="line-height:2;">部署名:</label>
          <div class="col-md-8">
              <select class="form-control" style="margin-bottom:0;margin-top:5px;"><option></option></select>
          </div>
        </div>
      </div>
	 
    </div>
  </form>
</div>

       

<div class="row">
           <a href="" class="print left">表示</a>
</div>
<div class="row first-row">
         
                    <a href="" class="print">CSV出力</a>
</div>
<div class="row sec-row margin-bottom-table">
       <div style="overflow-x:auto !important;">
<table  class="display datatable responsive cell-border" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>請求書No</th>
            <th>作成日</th>
            <th>お得意先</th>
            <th>部署名</th>
            <!--<th>期間</th>-->
            <th>備考</th>
            <th>請求金額</th>
        </tr>
    </thead>
	
		   <tbody>
        <tr>
            <td>010-010</td>
            <td>2016.10.01</td>
            <td>株式会社ニューオータニ</td>
            <td>A部署、B部署</td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求明細書,　請求書（表紙）</td>
            <td>123,000</td>
        </tr>
        <tr>
            <td>010-010</td>
            <td>2016.10.01</td>
            <td>株式会社ニューオータニ</td>
            <td>C部署、D部署、E部署</td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求書（テナント）,　請求書（表紙）</td>
            <td>123,000</td>
        </tr>
        <tr>
            <td>010-010</td>
            <td>2016.10.01</td>
            <td>A社</td>
            <td></td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求明細書（値引き２％）</td>
            <td>123,000</td>
        </tr>
        <tr>
            <td>010-010</td>
            <td>2016.10.01</td>
            <td>株式会社ニューオータニ</td>
            <td>A部署、C部署</td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求明細書,　請求書（表紙）</td>
            <td>123,000</td>
        </tr>
        <tr>
            <td>010-010</td>
            <td>2016.10.01</td>
            <td>A社</td>
            <td></td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求明細書（値引き２％）</td>
            <td>123,000</td>
        </tr>
        <tr>
            <td>007-010</td>
            <td>2016.10.01</td>
            <td>B社</td>
            <td></td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求書（新北京）</td>
            <td>123,000</td>
        </tr>
        <tr>
            <td>006-000</td>
            <td>2016.08.01</td>
            <td>株式会社ニューオータニ</td>
            <td>D部署, F部署</td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求書（テナント）,　請求書（表紙）</td>
            <td>123,000</td>
        </tr>
        <tr>
            <td>000-005</td>
            <td>2016.08.01</td>
            <td>D社</td>
            <td></td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求明細書（値引き5%）</td>
            <td>123,000</td>
        </tr>
        <tr>
            <td>001</td>
            <td>2016.08.01</td>
            <td>E社</td>
            <td></td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求書（イン東京）</td>
            <td>123,000</td>
        </tr>
		<tr>
            <td>001</td>
            <td>2016.08.01</td>
            <td>E社</td>
            <td></td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求書（イン東京）</td>
            <td>123,000</td>
        </tr>
		<tr>
            <td>001</td>
            <td>2016.08.01</td>
            <td>E社</td>
            <td></td>
            <!--<td>2016.09.01-2016.09.30</td>-->
            <td>請求書（イン東京）</td>
            <td>123,000</td>
        </tr>

    </tbody>
</table> 



</div><!--End tab content -->
</div><!--End row-->
</div>

