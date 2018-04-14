<style>
input[type="radio"]
	{
		width:auto !important;
	}
</style>
<div class="wrapper-contain order" id="operation">
	<div class="row">
		<div class="col-md-4"><h3>営業管理</h3></div>
		
		<div class="button-right-side" style="width:150px">
			<a href="<?php echo site_url('operation/inventory');?>" class="print top-print print-auto">在庫管理</a>  
            <a href="<?php echo site_url('operation/produce');?>" class="print top-print print-auto">生産管理</a>
		</div>
		  
	</div>
<div class="row first-row">
    <form class="form-horizontal" role="form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">期間:</label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input class="datepicker" id="delivery_from" >
                            <span class="icon-large icon-calendar"></span>
                        </span>   
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label center"> <span id="character">~</span></label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input class="datepicker" id="delivery_to">
                            <span class="icon-large icon-calendar"></span>
                        </span>    
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row" style="margin-top:20px"></div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                     <label class="col-md-4 control-label ">日計表</label>
                    <div class="col-md-4">
                        <span class="form-control form-control-input">
                            <input  type="radio">
                        </span>    
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-2 col-lg-2">
                <div class="form-group">
                     <label class="col-md-4 control-label ">日計表A</label>
                    <div class="col-md-4">
                        <span class="form-control form-control-input">
                            <input  type="radio">
                        </span>    
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-2 col-lg-2">
                <div class="form-group">
                     <label class="col-md-4 control-label ">日計表B</label>
                    <div class="col-md-4">
                        <span class="form-control form-control-input">
                            <input  type="radio">
                        </span>    
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                     <label class="col-md-4 control-label ">売上一覧</label>
                    <div class="col-md-4">
                        <span class="form-control form-control-input">
                            <input  type="radio">
                        </span>    
                    </div>
                </div>
            </div>
            <div class="col-sm-8 col-md-4 col-lg-4">
                <div class="form-group">
                     <label class="col-md-4 control-label ">点数表</label>
                    <div class="col-md-4">
                        <span class="form-control form-control-input">
                            <input  type="radio">
                        </span>    
                    </div>
                </div>
                <div class="form-group">
                     <label class="col-md-4 control-label ">得意先別</label>
                    <div class="col-md-4">
                        <span class="form-control form-control-input">
                            <input  type="radio">
                        </span>    
                    </div>
                    <div class="col-md-4">
                        <select class="form-control">
                            <option value=""></option>
                            
                        </select>    
                    </div>
                </div>
                <div class="form-group">
                     <label class="col-md-4 control-label ">商品別</label>
                    <div class="col-md-4">
                        <span class="form-control form-control-input">
                            <input  type="radio">
                        </span>    
                    </div>
                    <div class="col-md-4">
                        <select class="form-control">
                            <option value=""></option>
                            
                        </select>    
                    </div>
                </div>
                <div class="form-group">
                     <label class="col-md-2 control-label "></label>
                    <div class="col-md-4">
                        <select class="form-control">
                            <option value=""></option>
                            
                        </select>     
                    </div>
                </div>
            </div>
        </div>
    </form>
 </div><!--End form-horizontal-->
<div class="row first-row">        
		<a href="" class="print left">CSV出力</a>
		<a href="" class="print left">印刷</a>
		<a href="" class="print left" >表示</a>  
	</div>
</div><!--End wrapper-contain-->

