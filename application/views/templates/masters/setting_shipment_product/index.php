
<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3><?php echo $title; ?></h3>
    </div>

    <div class="first-row">
  
    <form class="form-horizontal" role="form">
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品セット名M ID :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="input_search_id" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品セット名M:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="input_search_name" >
                    </div>
                </div>
            </div>
           
    </form>
    </div>
     <div class="clearfix"></div>
     <br/>
    <div class="row left third-row">
        <a id="btnSearch" class="print">検索 </a>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12 col-md-10 col-lg-9">   
        <form class="form-horizontal" role="form" id="form_import_csv" method="POST" enctype="multipart/form-data">    
            <div class="col-md-4">
                <input type="file" class="form-control-file validation-required" name="import_file" id="import_file" required />
            </div>
            <div class="col-md-3">
                <select class="form-control" name="get_type_csv" id="get_type_csv" style="    width: 100%;">
                    <option value="1">商品セットM</option>
                    <option value="2">商品セットM-商品</option>
                </select>
            </div>
            <div class="col-md-2"> 
                <input type="submit" class="print" value="CSV入力"  />
            </div>
        </form>
        <div class="col-md-2">
            <a id="btnExportDetail" class="print">CSV出力</a>
        </div>
    </div>
    <div class="row right third-row">
        <a href="<?= base_url("master/setting_shipment_product/add") ?>" target="_blank" class="print">新規追加</a>
    </div>
    <div class="clearfix"></div>
    
    <div class="row third-row" id="list-table">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width=13%>商品セット名M ID</th>
                    <th>商品セット名M</th>
                    <th width=8%>操作</th>
                </tr>
            </thead>
        
        
         <tbody>
                <tr>
                    <td></td>
                    <td></td>
                   
                    <td><a href="#"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a> <a href="#"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td>
                </tr>
            </tbody>
        </table>
        
        </div> 
</div>

<!-- Modal sale -->
<div id="myModalAdd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-add">商品セット名M　編集・新規追加</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_add_set_product">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">商品セット名M:</label>
                        <div class="col-md-8">
                            <input class="form-control " name="name_set_product"  id="name_set_product" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label"></label>
                        <div class="col-md-8">
                        <input type="hidden" name="id_set_product"  id="id_set_product" >
                        <a id="btnAddSetProduct" class="print print-add" style="display: none;">保存</a>
                    <a id="btnEditSetProduct" class="print print-edit" style="display: none;">保存</a>
                        </div>
                    </div>
                </div>

            </div>
        </form>
      </div>
    </div>
 
  </div>
</div>

<script>
    var getListSetProduct = "<?= base_url("master/setting_shipment_product/get_list") ?>";
    var editSetProduct = "<?= base_url("master/setting_shipment_product/edit") ?>";
    var deleteListSetProduct = "<?= base_url("master/setting_shipment_product/delete_post") ?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
    var urlIndex = "<?= base_url("master/setting_shipment_product") ?>";
    var url_export = "<?= base_url("master/setting_shipment_product/export") ?>";
    var url_import = "<?= base_url("master/setting_shipment_product/import") ?>";
    var message_is_exits_set_product = "<?= $this->lang->line('message_is_exits_set_product')?>";
</script>
