<style>
	.product input[type="radio"]{
		width:auto !important;
	}
	.product button input{text-align: center;
		display:block;
		margin:0 auto;
	}
</style>
<div class="container">
<div class="wrapper-contain product order">
<div class="inventory-left">
<div class="row">
<div class="col-md-4">
	<h3>生産管理</h3>
</div>
        <div class="button-right-side">
            <a href="<?php echo site_url('business-management');?>" class="print right" ><i class=""></i>営業管理</a>    
            <a href="<?php echo site_url('business/inventory');?>" class="print right top-print " ><i class=""></i>在庫管理</a>
			
        </div>
</div>

<div class="row first-row">
	<button class="col-1"><input type="radio" name="report-produce" id="prod-1"><label>営業日報</label></button>	
	<div class="wrap-input-1">
	<div class="wrap-col">
    <div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3">
		<span class="right "><input  class="datepicker" type="text">
			<span class="icon-large icon-calendar"></span>
		</span>
    </div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="prod-row-2">
	    <label><input type="radio" name="report-place">ホテル</label>
		<label ><input type="radio" name="report-place">テナント</label>
		<label >リネンコントロール代金</label>
    </div>
	</div>
	<div class="col-5" style="clear:right;">
		<span class="right line-1"><input  class="datepicker" type="text">
			<span class="icon-large icon-calendar"></span>
		</span>
		<input type="text" class="line-2"/>
	</div>
	</div>
</div>

<div class="row">
	<button class="col-1"><input type="radio" name="report-produce" id="prod-1"><label>生産実績表</label></button>	
	<div class="wrap-input-1">
	<div class="wrap-col-2">
    <div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3">
		<span class="right "><input  class="datepicker" type="text">
			<span class="icon-large icon-calendar"></span>
		</span>
    </div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="col-5">
		<span class="right line-1"><input  class="datepicker" type="text">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="prod-row-2 no-top-margin">
	    <label><input type="radio" name="report-place">ホテル</label>
		<label ><input type="radio" name="report-place">テナント</label>
		<select><option>得意先別生産実績表（商品別)</option></select>
		<a href="#" class="print">Excel出力</a>
    </div>
	</div>
	</div>
</div>

<div class="row first-row">
	<button class="col-1"><input type="radio" name="report-produce" id="prod-3"><label>納品集計表</label></button>	
	<div class="wrap-input-3">
	<div class="col-2">
		<label class="label-form">期間</label>
		<label class="lb-line-2">得意先</label> 
	</div>
	<div class="col-3">
		<span class="right line-1"><input  class="datepicker" type="text">
			<span class="icon-large icon-calendar"></span>
		</span>
		<select class="line-2"><option>ニューオータニ</option></select>
	</div>
	<div class="col-4">
		 <label class="label-todate" style="">~</label>
	</div>
	<div class="col-5">
		<span class="right"><input  class="datepicker" type="text">
		<span class="icon-large icon-calendar"></span></span>
	</div>
	</div>
</div>

<div class="row">
	<button class="col-1"><input type="radio" name="report-produce" id="prod-4"><label>納品量合計</label></button>	
	<div class="wrap-input-4">
	<div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3">
		<span class="right "><input  class="datepicker">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="col-5">
		<span class="right first-input"><input  class="datepicker">
		<span class="icon-large icon-calendar"></span></span>
	</div>
	</div>
</div>

<div class="row first-row">
<button class="col-1"><input type="radio" name="report-produce" id="prod-5"><label>仕上状況</label></button>	
	<div class="wrap-input-5">
	<div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3">
		<span class="right"><input  class="datepicker" >
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="col-5">
		<span class="right first-input"><input  class="datepicker">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	</div>	
</div>

<div class="row margin-bottom-table">
	<button class="col-1 btn-part-6"><input type="radio" name="report-produce" id="prod-6"><label>生産状況</label></button>	
	<div class="wrap-input-6">
	<div class="wrap-col-6">
	<div class="col-2">
		<label class="label-form" style="line-height:0.5;">期間</label>
	</div>
	<div class="col-3">
		<span class="right "><input  class="datepicker">
			<span class="icon-large icon-calendar"></span>
		</span>		
	</div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="col-5">
		<span class="right first-input"><input  class="datepicker">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="prod-row-2">
	<div class="lb-row-1">
		<label><input type="radio" name="number-type-1">機種別洗濯量</label>
		<label><input type="radio" name="number-type-1">生産概要別洗濯量</label>
	</div>
	<div class="lb-row-2">
		<label><input type="radio" name="number-type-2" >機種別洗濯コース別洗剤使用量</label>
		<label><input type="radio" name="number-type-2" >洗剤別機種別使用量</label>
	</div>
	<div class="lb-row-3">
		<label>（＊現機器別洗剤使用量）</label>
		<label>（＊現洗剤別使用量）</label>
	</div>
	</div>
	</div>
	<div class="col-6">
		<label class="label-form">機器</label>
		<label class="lb-line-2">洗濯</label>
	</div>
	<div class="col-7">
		<select class="line-2"><option>（すべて）</option></select>
		<select class="line-2"><option>（すべて）</option></select>
	</div>
	</div>
</div>

<div class="row top-10">
	<button class="col-1"><input type="radio" name="report-produce" id="prod-7"><label>月間生産概要</label></button>	
	<div class="wrap-input-7">
	<div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3">
		<span class="right"><input  class="datepicker">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="col-4">
		 <label class="label-todate">~</label>
	</div>
	<div class="col-5">
		<span class="right"><input  class="datepicker">
		<span class="icon-large icon-calendar"></span></span>
		</div>
	</div>
</div>

<div class="row margin-top-table">
<button class="col-1"><input type="radio" name="report-produce" id="prod-8"><label>ボイラー運転状況</label></button>	
	<div class="wrap-input-8">
	<div class="wrap-col-2">
	<div class="col-2">
		<label class="label-form">期間</label>
	</div>
	<div class="col-3"><span class="right "><input  class="datepicker">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="col-4">
		 <label class="label-todate" style="">~</label>
	</div>
	<div class="col-5">
		<span class="right first-input"><input  class="datepicker">
			<span class="icon-large icon-calendar"></span>
		</span>
	</div>
	<div class="prod-row-2">
		<label ><input type="radio"  name="field">新帳票（数値）</label>
		<label ><input type="radio"  name="field">旧帳票（数値）</label>
		<label ><input type="radio"  name="field">旧帳票（グラフ）</label>
		<label >種類</label><select class="line-2"><option>（すべて）</option></select>
	</div>
	</div>
	</div>
</div>
<div class="row first-row">
	<a href="" class="print no-left-margin">CSV出力</a>
	<a href="" class="print">印刷 </a>
	<a href="" class="print">表示</a>
</div>
</div>
</div><!-- End container-->
</div><!-- End wrapper-contain-->
