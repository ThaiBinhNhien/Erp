<div class="wrapper-contain business order">
<div class="row">
<div class="col-md-4">
	<h3>営業管理</h3>
</div>
<div class="button-right-side">
	<a href="<?php echo site_url('business/inventory');?>" class="print right" ><i class=""></i>在庫管理</a>    
	<a href="<?php echo site_url('business/produce');?>" class="print right top-print" ><i class=""></i>生産管理</a>
</div> 	
</div><!--End title-->
<div class="index">
<div class="row first-row">
	<div class="col-md-9  col-sm-10 ">
		<label >期間:</label>	<span><input  class="datepicker" type="text">
		<span class="icon-large icon-calendar"></span></span>
		<label id="todate">~</label><input  class="datepicker" type="text">
		<span class="icon-large icon-calendar"></span>   
	</div>
 </div>
<div class="row" >
    <div class="col-md-9  col-sm-10 ">
		<button class="btn-1"><input type="radio" class='m-radio' name="m-radio"><label>日計表</label></button>
		<label><input disabled="disabled"  type="radio" name="radio-1" class="radio-1">日計表A</label>
		<label><input disabled="disabled"  type="radio" name="radio-1" class="radio-1">日計表B</label>
	</div>
</div>
<div class="row first-row">
	<div class="col-md-9  col-sm-10 ">		
	<button  class="btn-2"><input type="radio" class='n-radio' name="m-radio"><label>売上一覧</label></button>
	<div class="column-2">
		<label style="line-height:2"><input disabled="disabled" class="radio-2" type="radio" name="radio-2">点数表 </label>
		<div class="row-2">                      
			<label><input disabled="disabled" class="radio-2" type="radio" name="radio-2">得意先別</label>    
			<input value="得意先名"  class="disable" type="text" >
		 </div>              
		<div class="row-3">          
			 <label><input disabled="disabled" class="radio-2" type="radio" name="radio-2">商品別</label> 
			 <input value="商品名"  class="disable"  type="text" >
		</div>                            
		 <select  class="disable" name="select-time">
			 <option>日報</option>
			 <option>旬報</option>
			 <option>月報</option>
			 <option>年報</option>
		 </select>
	</div>
	</div>  
</div>
<div class="row margin-bottom-table" >
	<a href="#" class="print" >CSV出力</a>
	<a href="#" class="print" >印刷 </a>
	<a href="#" class="print" >表示 </a>
</div>
</div>
</div>