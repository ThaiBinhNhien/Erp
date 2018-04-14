
<style>
img{
    height:22px;

}
.imageAdd{
  float: right;
    margin-top: -35px;
    margin-right: -30px;
}
.cboDisable {
    -webkit-appearance: none;
    -moz-appearance: none;
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
                    <label class="col-md-4 control-label">拠点名:</label>
                    <div class="col-md-8">
                        <select class="form-control no-bottom-margin" id="in_base" name="in_base">
                           <option ></option>
                             <?php foreach ($list_base as $key => $value) {
                                echo '<option value="'.$value[BM_BASE_CODE].'">'.$value[BM_BASE_NAME].'</option>';
                             } ?>   
                        </select>    
                    </div>
                </div>
            </div>
           
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-3 control-label">日付:</label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input  class="" id="in_from_date" readonly>
                            <span class="icon-large icon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group ">
                    <label  class="col-md-4 control-label center"> <span id="character">~</span></label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input  class="" id="in_to_date" readonly >
                            <span class="icon-large icon-calendar"></span>
                        </span>    
                    </div>
                </div>
            </div>
            <div class="clearfix"></div> 
            <br/>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">売上商品名:</label>
                    <div class="col-md-8">
                        <select class="form-control no-bottom-margin" id="in_product" name="in_product">
                           <option ></option>
                             <?php foreach ($list_product as $key => $value) {
                                echo '<option value="'.$value[PL_PRODUCT_ID].'">'.$value[PL_PRODUCT_NAME].'</option>';
                             } ?>   
                        </select>    
                      <!--   <input type="text" class="form-control" name="cat_id" id="cat_id" > -->
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
                    <th>拠点名 </th>
                    <th>売上商品名</th>
                    <th>棚卸 </th>
                    <th>日付 </th>
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
                        <label class="col-md-4 control-label">拠点 :</label>
                        <div class="col-md-8">
                             <select  class="form-control no-bottom-margin cboDisable" id="edit_in_base" name="edit_in_base" disabled>
                               <option></option>
                                  <?php foreach ($list_base as $key => $value) {
                                echo '<option value="'.$value[BM_BASE_CODE].'">'.$value[BM_BASE_NAME].'</option>';
                             } ?> 
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">日付:</label>
                            <div class="col-md-8">
                              <span class="form-control-input">
                                <input  style="width: 100%;height: 30px;" class="datepicker" id="edit_in_date" name="edit_in_date" readonly disabled>
                            </span>                           
                            </div>
                        </div>
                 </div>
                 <br/><br/>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">売上商品名:</label>
                        <div class="col-md-8">
                             <select class="form-control no-bottom-margin cboDisable" id="edit_in_product" name="edit_in_product" disabled>
                               <option></option>
                                  <?php foreach ($list_product as $key => $value) {
                                echo '<option value="'.$value[PL_PRODUCT_ID].'">'.$value[PL_PRODUCT_NAME].'</option>';
                             } ?>  
                            </select>
                        </div>
                    </div>
                </div>
                    
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-3 control-label">棚卸:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                             <input id="edit_initial_amount" name="edit_initial_amount" class="form-control">
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
          <h4 class="modal-title">新規追加 </h4>
        </div>
        <div class="modal-body">
         <form class="form-horizontal" role="form" id="form">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">拠点:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                             <select class="form-control no-bottom-margin" id="create_in_base" name="create_in_base">
                               <option></option>
                                  <?php foreach ($list_base as $key => $value) {
                                echo '<option value="'.$value[BM_BASE_CODE].'">'.$value[BM_BASE_NAME].'</option>';
                             } ?> 
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">日付:<span class="label-form-request">*</span></label>
                            <div class="col-md-8">
                              <span class="form-control-input">
                                <input  style="width: calc(100% - 25px);height: 30px" class="datepicker" id="create_in_date" name="create_in_date" readonly>
                                <span class=" icon-large icon-calendar "></span>
                            </span>                           
                            </div>
                        </div>
                 </div>
                 <br/><br/>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">売上商品名:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control create_in_product" name="create_in_product"  id="create_in_product" value="" />
                                <span></span>
                        </div>
                    </div>
                </div>
                    
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-3 control-label">棚卸:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                             <input id="create_initial_amount" name="create_initial_amount" class="form-control">
                        </div>
                    </div>
                </div>
               
            </div>
        </form>
          <div class="modal-footer"  style="text-align:center;">
            <input type="button" id="save" class="print print-add" value="保存 ">
             <input type="button" id="addRow" class="print print-add" value="行挿入">
          </div>
       
        </div>
    </div>
</div>
<script>
var createUrl = "<?= base_url("master/initial_inventory/create") ?>";
var catViewUrl = "<?= base_url("master/initial_inventory/search") ?>";
var edit_CatUrl = "<?= site_url('master/initial_inventory/edit')?>";
var assetImgUrl = "<?= site_url('asset/img/')?>";
var delUrl = "<?= site_url('master/initial_inventory/delete')?>";
var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
var urlIndex= "<?= base_url("master/initial_inventory") ?>";
var url_export = "<?= base_url("master/initial_inventory/export") ?>";
var url_import = "<?= base_url("master/initial_inventory/import") ?>";
var message_exits_id_error = "<?= $this->lang->line('message_exits_id_error')?>";
var get_product_selectbox = "<?= base_url("product/get_product_selectbox") ?>";
var message_exits_name_product_error = "<?= $this->lang->line('message_exits_name_product_error')?>";
</script>
