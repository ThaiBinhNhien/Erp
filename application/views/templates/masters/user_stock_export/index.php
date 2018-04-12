
<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3><?php echo $title ?></h3>
    </div>

    <div class="first-row">
  
    <form class="form-horizontal" role="form" >
       <div class="row">
          <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">ID:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="ux_id" id="ux_id" >
                    </div>
                </div>
            </div>
     
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">氏名:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="ux_name" id="ux_name" >
                    </div>
                </div>
            </div>
               <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="ux_address" id="ux_address" >
                    </div>
                </div>
            </div>
               <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">電話番号:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="ux_number" id="ux_number" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">拠点:</label>
                    <div class="col-md-8">
                        <select class="form-control no-bottom-margin" id="ux_base" name="ux_base">
                           <option ></option>
                             <?php 
                             if(isset($list_base)) {
                             foreach ($list_base as $key => $value) {
                                echo '<option value="'.$value[BM_BASE_CODE].'">'.$value[BM_BASE_NAME].'</option>';
                             } } ?>   
                        </select>    
                    </div>
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
                    <th width=10%>ID</th>
                    <th>氏名 </th>
                    <th>シメイ </th>
                    <th>役職 </th>
                    <th>住所 </th>
                    <th>電話番号 </th>
                    <th>拠点</th>
                    <th width=8%>操作</th>
                   <!--  <th colspan="2" width=3%>操作</th> -->
                </tr>
            </thead>
        
        
         <tbody id="detail_data">

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
                <input type="hidden" id="dp_id" />
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">ID:</label>
                        <div class="col-md-8">
                            <input disabled="true" class="form-control" name="edit_ux_id"  id="edit_ux_id" value="" />
                                <span></span>
                        </div>
                    </div>
                </div>
                  
             
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">氏名:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control" name="edit_ux_name"  id="edit_ux_name" value="" />
                                <span></span>
                        </div>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">シメイ:</label>
                        <div class="col-md-8">
                            <input class="form-control" name="edit_ux_name1"  id="edit_ux_name1" value="" />
                                <span></span>
                        </div>
                    </div>
                </div>
                    
                    
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">役職:</label>
                        <div class="col-md-8">
                             <input id="edit_ux_regency" name="edit_ux_regency" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">住所:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                             <input id="edit_ux_address" name="edit_ux_address" class="form-control">
                        </div>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">電話番号:</label>
                        <div class="col-md-8">
                             <input id="edit_ux_number" name="edit_ux_number" class="form-control">
                        </div>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">拠点:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                             <select class="form-control no-bottom-margin" id="edit_ux_base" name="edit_ux_base">
                               <option></option>
                                  <?php 
                                  if(isset($list_base)) {
                                  foreach ($list_base as $key => $value) {
                                echo '<option value="'.$value[BM_BASE_CODE].'">'.$value[BM_BASE_NAME].'</option>';
                             } } ?> 
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
       <div class="col-sm-12">&nbsp;</div>
          <div class="col-sm-12 modal-footer" style="text-align:center;">
             <input type="button" id="edit" class="print print-edit" value="保存 ">
          </div>
          <div class="clearfix"></div>
        </div>
    </div>
</div>
<div id="create-form" class="modal fade" role="dialog">
    <div class="modal-dialog modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">新規追加 </h4>
        </div>
        <div class="modal-body">
         <form class="form-horizontal" role="form" id="form">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">ID:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control" name="create_ux_id"  id="create_ux_id" value="" />
                                <span></span>
                        </div>
                    </div>
                </div>
               
               
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">氏名:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control" name="create_ux_name"  id="create_ux_name" value="" />
                                <span></span>
                        </div>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">シメイ:</label>
                        <div class="col-md-8">
                            <input class="form-control" name="create_ux_name1"  id="create_ux_name1" value="" />
                                <span></span>
                        </div>
                    </div>
                </div>
                    
                    
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">役職:</label>
                        <div class="col-md-8">
                             <input id="create_ux_regency" name="create_ux_regency" class="form-control">
                        </div>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">住所:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                             <input id="create_ux_address" name="create_ux_address" class="form-control">
                        </div>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">電話番号:</label>
                        <div class="col-md-8">
                             <input id="create_ux_number" name="create_ux_number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">拠点:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                             <select class="form-control no-bottom-margin" id="create_ux_base" name="create_ux_base">
                               <option></option>
                                  <?php 
                                  if(isset($list_base)) {
                                  foreach ($list_base as $key => $value) {
                                echo '<option value="'.$value[BM_BASE_CODE].'">'.$value[BM_BASE_NAME].'</option>';
                             } } ?> 
                            </select>
                        </div>
                    </div>
                </div>
                
               
            </div>
        </form>
        <div class="col-sm-12">&nbsp;</div>
          <div class="col-sm-12 modal-footer"  style="text-align:center;">
            <input type="button" id="save" class="print print-add" value="保存 ">
          </div>
          <div class="clearfix"></div>
        </div>
    </div>
</div>
<script>
var createUrl = "<?= base_url("master/user_stock_export/create") ?>";
var catViewUrl = "<?= base_url("master/user_stock_export/search") ?>";
var edit_CatUrl = "<?= site_url('master/user_stock_export/edit')?>";
var assetImgUrl = "<?= site_url('asset/img/')?>";
var delUrl = "<?= site_url('master/user_stock_export/delete')?>";
var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
var urlIndex= "<?= base_url("master/user_stock_export") ?>";
var url_export = "<?= base_url("master/user_stock_export/export") ?>";
var url_import = "<?= base_url("master/user_stock_export/import") ?>";
var message_exits_id_error = "<?= $this->lang->line('message_exits_id_error')?>";
</script>
