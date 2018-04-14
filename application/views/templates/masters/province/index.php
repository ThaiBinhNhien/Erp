
<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>都道府県　一覧 </h3>
    </div>

	<div class="first-row">
  
    <form class="form-horizontal" role="form">
        
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">都道府県 :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="inputLabel4" >
                    </div>
                </div>
            </div>
           
    </form>
	</div>
    <div class="row left third-row">
        <a href="" class="print">検索 </a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    <div class="row right third-row">
        <a href="" class="print">新規追加</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    <div class="clearfix"></div>
    
	<div class="row third-row" id="order-table">
        <table  class="display datatable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width=10%>注文No</th>
                    <th>商品区分名 </th>
                    
                    <th colspan="2" width=3%>操作</th>
                </tr>
            </thead>
		
		
		 <tbody>
                <tr>
                    <td></td>
                    <td></td>
                   
                    <td><a href="#"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a></td>
                    <td><a href="#"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td>
                </tr>
            </tbody>
        </table>
		
		</div> 
</div>
