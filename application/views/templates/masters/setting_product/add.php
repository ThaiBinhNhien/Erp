<style>
img{
    height:22px;

}
caption{
    background:none;
}
table{
    padding:4px;
     border:1px solid #a3a3a3
}
table.dataTable.no-footer {
    border-bottom: 0 !important;
    padding: 0 !important;
    width: calc(100% + 20px) !important;
}
th{
    padding:5px;
    text-align:center;
}
tr,td{
    padding:10px;
}
.dataTables_scrollBody {
    height: 200px;
    border-bottom: 1px solid #a3a3a3 !important;
    border-left: 1px solid #a3a3a3 !important;
    border-right: 1px solid #a3a3a3 !important;
    overflow-x: hidden !important;
}
table.dataTable{
     border: 0 !important;
}
table:first-child caption{
    text-align:left;
}
h4 {
    font-weight: bold;
    padding-left: 8px;
}
.bootstrap-duallistbox-container .btn-group .btn {
    margin: 0;
}
.dataTables_scrollBody thead tr {
    height: 1px !important;
}
input[name="form_stt"] {
    width: 88% !important;
    text-align: right !important;
    float: right !important;
}
table.dataTable th {
    border: 0;
}
table.dataTable thead th, table.dataTable thead td {
    padding-left: 0 !important;
    padding-right: 50px !important;
}
table.dataTable tbody th, table.dataTable tbody td {
    border-bottom: 1px solid #a3a3a3 !important;
}
</style>
<div class="wrapper-contain order" id="box-page">
  <div class="col-md-8 third-row">
        <h3><?php echo $title; ?></h3>
    </div>
<form class="form-horizontal" role="form" id="form_add_set_product">
    <div class="first-row">
  
    
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品セットID:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                       <input class="form-control" type="number" name="id_set_product" id="id_set_product" />
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品セット名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                       <input class="form-control" name="name_set_product" id="name_set_product" />
                    </div>
                </div>
            </div>
            
        </div>

   
    </div>
    

    <div class="row third-row">
     <div class="col-md-5">        
        <table width="100%" id="tab_product">
        <caption> 未追加商品</caption>
            <thead>
                <tr>
                    <th>商品ID </th>
                    <th>商品名</th>
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
        <table  width="100%" class="table-fixed" id="tab_product_set">
            <caption>追加済商品</caption>
            <thead>
                <tr>
                  
                    <th class="col-xs-3">商品ID</th>
                    <th class="col-xs-7">商品名</th>
                    <th class="col-xs-2">連番</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        
    </div>  
    </div> 
   
    </form>
    <div class="clearfix"></div>
     <div class="row third-row" style="text-align:center;">
        <a id="btnAddSetProduct" class="print">保存</a>
    </div>
    
</div>

    
</div>

<script>
    var addListSetProduct = "<?= base_url("master/setting_product/add_post") ?>";
    var productViewUrl = "<?= base_url("master/product/get_product_view") ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var urlIndex = "<?= base_url("master/setting_product") ?>";
    var message_is_exits_set_product = "<?= $this->lang->line('message_is_exits_set_product')?>";
</script>
