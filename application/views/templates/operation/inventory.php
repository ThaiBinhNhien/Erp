<style>
	.inventory input[type="radio"]{
		width:auto !important;
	}
	.inventory button input{text-align: center;
		display:block;
		margin:0 auto;
	}
	.inventory button{
		min-height:73px;
	}
</style>
<div class="container">
<div class="wrapper-contain inventory order">
<div class="inventory-left">
<div class="row">
<div class="col-md-4">
	<h3>在庫管理</h3>
</div>
        <div class="button-right-side">
            <a href="<?php echo site_url('business-management');?>" class="print right" ><i class=""></i>営業管理</a>    
            <a href="<?php echo site_url('business/produce');?>" class="print right top-print"><i class=""></i>生産管理</a>
        </div>
</div>
<!----------------------------Part-1----------------------------------->
<!--	
<div class="row margin-top-table part-1">
	<button class="col-1"><input type="radio" name="produce" id="invent-1" ><label>貯蔵品一覧</label></button>
	<div class="col-2">
		<div class="row">
			<label class="label-form">拠点</label> 
			<label class="label-form line-2">期間</label> 
		</div>           
	</div>
	<div  class="select col-3">
			<select class="right-20 invent-1" disabled >
				<option>全拠点</option>
				<option>本社</option>
				<option>厚木</option>
			</select>
			<span class="right"><input  disabled class="datepicker invent-1">
			<span class="icon-large icon-calendar"></span></span>
	</div>  
	<div class="col-4">
			<label  class="label-form">タイプ</label>
	</div> 
	<div class="col-5" >
			<select class="right-20 invent-1" disabled><option>全商品  </option></select>
	</div>	
</div>
-->	
<!--End part-1-->
<!----------------------------Part-2----------------------------------->
<div class="row margin-top-table part-2">
	<button class="col-1" style="height:122px;"><input type="radio" id="invent-2" name="produce"><label>貯蔵品一覧</label></button>
	<div class="col-2">
		<label class="label-form" name="position" >拠点</label>
		<label class="label-form line-2" name="select-date">期間</label> 
		 <label  class="label-form" style="padding-top:24px;">タイプ</label>  
	</div>
	<div class="col-3">
		<select disabled class="right-20 invent-2" style="margin-bottom:8px !important;"><option>全拠点</option></select>
		<select disabled class="right-20 invent-2 select-opt" ><option value="1">仕入品</option><option value="2">洗剤等</option></select>
		<span class="right">
			<input disabled class="datepicker invent-2">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="col-4">
		<label  class="label-form" style="padding-top:56px;">条件</label>    
	</div>
	<div class="col-5">
		<select disabled class="right-20 invent-2" style="margin-top:52px;">
		<option class="opt-1">在庫一覧（決算用）  </option>
		<option class="opt-1">要発注商品のみ  </option>
		

		<option class="opt-2" style="display:none;">在庫一覧（仕入先別）</option>
		</select>
	</div>
</div><!--End part-2-->
<!----------------------------Part-3----------------------------------->
<div class="row margin-top-table part-3">
   		<button class="col-1"><input type="radio" name="produce"  id="invent-3"><label>納品達成率</label></button>
        <div class="col-2">
			<label class="label-form">期間</label> 
			<label class="label-form line-2">商品ID</label>  
        </div>
        <div class="col-3" >
			 <span disabled class="right"><input  class="datepicker invent-3">
                 <span class="icon-large icon-calendar"></span>
             </span>
			<input disabled  class="right-20 invent-3" style="margin-top:5px;">
        </div>
	  	<div class="col-4">
	  		<label class="label-form">~</label> 
	  	</div>
	  	<div class="col-5">
	  		<span class="right"><input  disabled class="datepicker invent-3">
             <span class="icon-large icon-calendar"></span></span>
	  	</div>
<!----------------------------Part-4-----------------------------------> 
</div><!--End part-3-->
<div class="row margin-top-table part-4">
	<button class="col-1" ><input id="invent-4"  type="radio" name="produce"  ><label>使用中リネン品<br/>回転率</label></button>
	<div class="col-2">
		<label class="label-form">拠点</label> 
		<label class="label-form line-2">期間</label> 
	</div>
	<div class="col-3" style="margin-top:8px !important;">
		<select disabled class="right-20 invent-4"><option>全拠点</option></select>
		<span class="right"><input  class="datepicker invent-4" disabled>
		<span class="icon-large icon-calendar"></span></span>
	</div>  
	<div class="col-4">
		<label  class="label-form">タイプ</label>
	</div> 
	<div class="col-5" >
		<select class="right-20 invent-4" disabled><option>全商品  </option></select>
	</div>	
</div><!--End part-4-->
<!----------------------------Part-5----------------------------------->
<div class="row margin-top-table part-5" >
	<button class="col-1"><input id="invent-5"  name="produce"  type="radio"><label>入出庫状況</label></button>
	<div class="col-2">
		 <label class="label-form">期間</label> 
		 <label class="label-form line-2">商品ID</label>  
	</div>
        <div class="col-3">
			 <span class="right"><input disabled class="datepicker invent-5">
                 <span class="icon-large icon-calendar"></span>
                </span>
			<input  class="right-20 invent-5" disabled>
        </div>
	  	<div class="col-4">
	  		<label class="label-form">~</label>
			<label  class="label-form line-2">タイプ</label>
	  	</div>
	  	<div class="col-5">
	  		<span class="right" ><input disabled class="datepicker invent-5">
             <span class="icon-large icon-calendar"></span></span>
			<select disabled class="right-20 invent-5"><option>全商品  </option></select>
	  	</div>    
</div><!--End part-5-->
<!----------------------------Part-6----------------------------------->
<div class="row margin-top-table part-6">
	<button class="col-1"><input id="invent-6"  type="radio" name="produce"><label>仕入台帳</label></button>        
	<div class="col-2">
		<label class="label-form">タイプ</label>           
		<label class="label-form line-2">期間</label>  
		<label class="label-form line-2">仕入先</label>  
		<label class="label-form line-2">ベース</label>  
	</div>
	<div class="col-3">
		<select class="right-20 invent-6" disabled><option>仕入品  </option></select>
		<span class="right">
		<input class="datepicker invent-6 " disabled>
		<span class="icon-large icon-calendar"></span>
		</span>
		<select class="right-20 invent-6" disabled><option>  </option></select>  
		<select class="right-20 invent-6 no-bottom-margin" disabled>
			<option>入庫ベース</option>
			<option>出庫ベース</option>
		</select>
	</div>
	<div class="col-4">
		<label class="label-form">~</label> 
		<label class="label-form line-2">販売先 </label> 
		<label class="label-form line-2">出力区分  </label>  
	</div>
	<div class="col-5">
		<span class="right"><input disabled  class="datepicker">
		<span class="icon-large icon-calendar"></span></span>
		<select class="right-20 invent-6" disabled><option></option></select>
		<select class="right-20 invent-6  no-bottom-margin" disabled ><option></option></select>
	</div>
	<div class="col-6">
		<label class="label-form">形式</label>			   
	</div>			        
	<div class="col-7">
		<select  class="invent-6" disabled><option>通常</option></select>
	</div>               
</div><!--End col-6-->
<!----------------------------Part-7----------------------------------->
<div class="row margin-top-table part-7">
	<button class="col-1" ><input type="radio" id="invent-7"  name="produce" ><label>洗剤等使用状況</label></button>
	<div class="col-2">
			<label class="label-form line-2">期間</label> 
	</div>
	<div class="col-3">
			<span class="right" id="wrap"><input disabled name="startDate" id="startDate" class="date-picker invent-7" />
			<span class="icon-large icon-calendar"></span></span>
	</div>  
	
</div><!--End part-7-->		
<div class="row margin-top-table part-8" >
	<button class="col-1" ><input type="radio" name="produce"  id="invent-8" ><label>仕入品金額明細</label></button>
	<div class="col-2">
	
		<label class="label-form line-2">タイプ</label> 	
		<label class="label-form line-2">期間</label> 
		      
	</div>
	<div class="col-3">
			<select disabled class="right-20 invent-8">
				<option>仕入品</option>
				<option>洗剤等</option>
			</select>
			<span class="right"><input disabled  class="datepicker invent-8">
			<span class="icon-large icon-calendar"></span></span>
	</div>  
	<div class="col-4">
		<label class="label-form line-2" >帳票</label> 	
		<label class="label-form line-2" >~</label> 
	</div>
	<div class="col-5">
		<select disabled class="right-20 invent-8"><option>外注分売上明細</option></select>
		<span class="right"><input disabled class="datepicker invent-8">
			<span class="icon-large icon-calendar"></span></span>
	</div>
</div><!--End part-8-->	
<div class="row first-row">
	<div class="col-md-8">
		<a href="" class="print">CSV出力</a>
		<a href="" class="print">印刷 </a>
		<a href="" class="print">表示  </a>
	</div>
</div>
</div>
</div>
</div>
