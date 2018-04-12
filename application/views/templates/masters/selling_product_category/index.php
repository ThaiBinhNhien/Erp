
<style>
img{
    height:22px;

}
.modal-backdrop{
    position:unset;
}
.modal {
    z-index: 0;
}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>売上商品区分　一覧 </h3>
    </div>

    <div class="first-row">
  
    <form class="form-horizontal" role="form">
          <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">売上商品区分ID:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="cat_id" id="cat_id" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">売上商品区分名:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="cat_name" id="cat_name" >
                    </div>
                </div>
            </div>
           
    </form>
    </div>
     <div class="clearfix"></div>
   <div class="row left third-row">
        <a  class="print" id="search">検索 </a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
   
    <div class="clearfix"></div>
    <!-- csv-->
    <div class="col-sm-12 col-md-10 col-lg-9">   
        <form class="form-horizontal" role="form" id="form_import_csv" method="POST" enctype="multipart/form-data">    
            <div class="col-md-4">
                <input type="file" class="form-control-file validation-required" name="import_file" id="import_file" required />
            </div>
            <div class="col-md-2"> 
                <input id="btnImport2" type="submit" class="print" value="CSV入力"  />
                <!-- <a id="btnImport" class="print">CSV入力</a> -->
            </div>
        </form> 
        <div class="col-md-2">
            <a id="btnExport" class="print">CSV出力</a>
        </div>
    </div>
      <div class="row right third-row">
        <a href="#" data-toggle="modal" data-target="#create-form"  class="print addModal">新規追加</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    <div class="row third-row" id="cat-table">
        <table  class="display datatable responsive cell-border edit_order" id="edit_order" cellspacing="0" width="100%">
            <thead>
                <tr id="table_header">
                    <th width=12%>売上商品区分ID </th>
                    <th>売上商品区分名  </th>
                    <th width=8%>操作</th>
                   <!--  <th colspan="2" width=3%>操作</th> -->
                </tr>
            </thead>
        
        
         <tbody id="detail_data">
                <tr>
                    <td></td>
                    <td></td>
                   
                   <!--  <td><a href="#"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a></td>
                    <td><a href="#"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td> -->
                </tr>
            </tbody>
        </table>
        
        </div> 
</div>
<div id="edit-form" class="modal fade" role="dialog">
    <div class="modal-dialog modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">編集</h4>
        </div>
        <div class="modal-body">
         <form class="form-horizontal" role="form" id="edit_form">
            <div class="row">
               <div class="col-md-12 col-xs-12 form-group pad10">
                    <div class="col-md-12 col-xs-12 form-group pad10">
                        <div class="col-md-3 col-md-offset-1"><label class="control-label">売上商品区分ID:</label></div>
                        <div class="col-md-6">
                            <input type="text" disabled="true" class="form-control" id="dp_id"/>
                        </div>
                    </div>
              </div>
              <div class="col-md-12 col-xs-12 form-group pad10">
                    <div class="col-md-12 col-xs-12 form-group pad10">
                        <div class="col-md-3 col-md-offset-1"><label class="control-label">売上商品区分名:<span class="label-form-request">*</span></label></div>
                        <div class="col-md-6">
                            <input type="text" id="edit_name" name="edit_name" class="form-control">
                        </div>
                    </div>

                
              </div>
       
            </div>
        </form>
        <div class="modal-footer" style="text-align:center;">
             <input type="button" id="edit" class="print print-edit" value="保存 ">
          </div>
        </div>
    </div>
</div>
<div id="create-form" class="modal fade" role="dialog">
    <div class="modal-dialog modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">新規追加</h4>
        </div>
        <div class="modal-body">
         <form class="form-horizontal" role="form" id="form">
            <div class="row">
              <div class="col-md-12 col-xs-12 form-group pad10">
                
                <div class="col-md-12 col-xs-12 form-group pad10">
                    <div class="col-md-3 col-md-offset-1"><label class="control-label">売上商品区分ID:<span class="label-form-request">*</span></label></div>
                    <div class="col-md-6">
                       <input type="text" id="create_id" name="create_id" class="form-control"/>
                    </div>
                </div>
               
              </div>
              <div class="col-md-12 col-xs-12 form-group pad10">
                <div class="col-md-12 col-xs-12 form-group pad10">
                    <div class="col-md-3 col-md-offset-1"><label class="control-label">売上商品区分名:<span class="label-form-request">*</span></label></div>
                    <div class="col-md-6">
                        <input type="text" id="create_name" name="create_name" class="form-control">
                    </div>
                </div>
               
              </div>
        
            </div>
        </form>
 
          <div class="modal-footer"  style="text-align:center;">
            <input type="button" id="save" class="print print-add" value="保存 ">
          </div>
        
        </div>
    </div>
</div>
<script>
var createUrl = "<?= base_url("master/selling_product_category/create_category") ?>";
var catViewUrl = "<?= base_url("master/selling_product_category/search_category") ?>";
var edit_CatUrl = "<?= site_url('master/selling_product_category/edit_category')?>";
var assetImgUrl = "<?= site_url('asset/img/')?>";
var delUrl = "<?= site_url('master/selling_product_category/delete_category')?>";
var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
var urlIndex= "<?= base_url("master/selling_product_category") ?>";
var url_export = "<?= base_url("master/selling_product_category/export") ?>";
var url_import = "<?= base_url("master/selling_product_category/import") ?>";

</script>
