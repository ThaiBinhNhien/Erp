
<style>
img{
    height:22px;

}
table,th,td{
    border:1px solid #a3a3a3


}
table{
    padding:4px;
     border:1px solid #a3a3a3
}
tr,td{
    padding:10px;

}
th{
    padding:5px;

 text-align:center;
}
caption{
    background:none;
}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>商品区分　編集・新規追加</h3>
    </div>

	<div class="first-row">
  
    <form class="form-horizontal" role="form">
        
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品名:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="inputLabel4" >
                    </div>
                </div>
            </div>
           
    </form>
	</div>

    <div class="clearfix"></div>
   
	<div class="row third-row">
     <div class="col-md-5">        
        <table   width="100%">
        <caption>未追加商品</caption>
            <thead>
                <tr>
                    <th width=20%>注文No</th>
                    <th>区分名</th>
                    
                    
                </tr>
            </thead>
		
		
		 <tbody>
                <tr>
                    <td></td>
                    <td></td>
                   
                    
                </tr>
            </tbody>
        </table>
		
	</div> 
    <div class="col-md-2"> 
    <section id="iconSelectPullDown">
    
    <img src="<?php echo site_url('asset/img/');?>arrow_right.png" id="right"/>
    <div class="clearfix"></div>
    <img src="<?php echo site_url('asset/img/');?>arrow_all_right.png" id="right_all"/>
    <div class="clearfix"></div>
    <br>
    <div class="clearfix"></div>
    <img src="<?php echo site_url('asset/img/');?>arrow_left.png" id="left"/>
    <div class="clearfix"></div>
    <img src="<?php echo site_url('asset/img/');?>arrow_all_left.png" id="left_all"/>
    
    </section>
    </div>
        <div class="col-md-5">        
        <table  width="100%">
            <caption>追加済商品</caption>
            <thead>
                <tr>
                    <th width=20%>注文No</th>
                    <th>区分名</th>
                    
                    
                </tr>
            </thead>
        
        
         <tbody>
                <tr>
                    <td></td>
                    <td></td>
                   
                </tr>
            </tbody>
        </table>
        
    </div> 

    
    </div>
    <div class="row third-row" style="text-align:center;">
        <a href="" class="print">保存</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
</div>
