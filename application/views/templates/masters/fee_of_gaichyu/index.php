
<style>
img{
    height:22px;

}
.cboDisable {
    -webkit-appearance: none;
    -moz-appearance: none;
}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>管理業務料　一覧 </h3>
    </div>

    <div class="first-row">
  
    <form class="form-horizontal" role="form" >
       <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">得意先  :</label>
                    <div class="col-md-8">
                        <select class="form-control no-bottom-margin" id="gaichyu_customer" name="gaichyu_customer">
                           <option ></option>
                             <?php foreach ($list_gaichyu_customer as $key => $value) {
                                echo '<option value="'.$value[CUS_ID].'">'.$value[CUS_CUSTOMER_NAME].'</option>';
                             } ?>   
                        </select>    
                      <!--   <input type="text" class="form-control" name="cat_id" id="cat_id" > -->
                    </div>
                </div>
            </div>

          <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">担当外注先 :</label>
                    <div class="col-md-8">
                        <select class="form-control no-bottom-margin" id="gaichyu_base" name="gaichyu_base">
                           <option ></option>
                             <?php foreach ($list_gaichyu_base as $key => $value) {
                                echo '<option value="'.$value[BM_BASE_CODE].'">'.$value[BM_BASE_NAME].'</option>';
                             } ?>   
                        </select>   
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">担当者 :</label>
                    <div class="col-md-8">
                        <select class="form-control no-bottom-margin" id="gaichyu_user" name="gaichyu_user">
                            <option ></option>
                             <?php foreach ($list_gaichyu_user as $key => $value) {
                                echo '<option value="'.$value[U_ID].'">'.$value[U_NAME].'</option>';
                             } ?>   
                        </select>   
                    </div>
                </div>
            </div>
           <div class="clearfix"></div>
           <br/>
          <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">管理費免除部署 :</label>
                    <div class="col-md-8">
                        <select class="form-control no-bottom-margin" id="deparment" name="deparment">
                           <option ></option>
                             <?php foreach ($list_department as $key => $value) {
                                echo '<option value="'.$value[DL_DEPARTMENT_CODE].'">'.$value[DL_DEPARTMENT_NAME].'</option>';
                             } ?>   
                        </select>    
                    </div>
                </div>
            </div>
           
    </form>
    </div>
    <br/>
     <div class="clearfix"></div>
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
                    <th>得意先 </th>
                    <th>担当外注先 </th>
                    <th>担当者 </th>
                    <th>ﾘﾈﾝｻﾌﾟﾗｲ売上 </th>
                    <th>ﾘﾈﾝ補充費 </th>
                    <th>ｸﾘｰﾆﾝｸﾞ他売上 </th>
                    <th>管理費免除部署 </th>
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
                        <label class="col-md-4 control-label">得意先:</label>
                        <div class="col-md-8">
                              <input type="text" disabled="true" class="form-control" id="edit_gaichyu_customer"/>
                            
                        </div>
                    </div>
             </div>
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label cboDisable">担当外注先:</label>
                        <div class="col-md-8">
                              <input type="text" disabled="true" class="form-control" id="edit_gaichyu_base"/>
                        </div>
                    </div>
                </div>
              
              <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label cboDisable">担当者 :</label>
                        <div class="col-md-8">
                              <input type="text" disabled="true" class="form-control" id="edit_gaichyu_user"/>
                           
                        </div>
                    </div>
                </div>
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label" style="padding-left: 0;font-size: 88%;">管理費免除部署:</label>
                        <div class="col-md-8">
                             <select class="form-control" id="edit_deparment" name="edit_deparment" style="margin-bottom: 9px;">
                               <option ></option>
                                <?php foreach ($list_department as $key => $value) {
                                     echo '<option value="'.$value[DL_DEPARTMENT_CODE].'">'.$value[DL_DEPARTMENT_NAME].'</option>';
                                 } ?>   
                            </select>   
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">ﾘﾈﾝｻﾌﾟﾗｲ売上:</label>
                        <div class="col-md-8">
                             <input  id="edit_tolinen_fee" name="edit_tolinen_fee" class="form-control">
                        </div>
                    </div>
                </div>
               
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">ﾘﾈﾝ補充費:</label>
                        <div class="col-md-8">
                            <input  id="edit_enviroment_fee" name="edit_enviroment_fee" class="form-control"> 
                        </div>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label" style="padding-left: 0;">ｸﾘｰﾆﾝｸﾞ他売上:</label>
                        <div class="col-md-8">
                             <input  id="edit_laundry_fee" name="edit_laundry_fee" class="form-control">
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
                        <label class="col-md-4 control-label">得意先:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control no-bottom-margin" id="create_gaichyu_customer" name="create_gaichyu_customer">
                               <option ></option>
                                <?php foreach ($list_gaichyu_customer as $key => $value) {
                                     echo '<option data-username="'.$value["username"].'" data-base="'.$value["base_code"].'" data-gaichyu="'.$value["gaichyu_flg"].'" value="'.$value[CUS_ID].'">'.$value[CUS_CUSTOMER_NAME].'</option>';
                                } ?>   
                            </select>                              
                        </div>
                    </div>
             </div>
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">担当外注先:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                             <select class="form-control no-bottom-margin cboDisable" id="create_gaichyu_base" name="create_gaichyu_base" disabled>
                               <option></option>
                                  <?php foreach ($list_gaichyu_base as $key => $value) {
                                        echo '<option value="'.$value[BM_BASE_CODE].'">'.$value[BM_BASE_NAME].'</option>';
                                     } ?>   
                            </select>
                        </div>
                    </div>
                </div>
                <br/><br/>
              <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">担当者:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                             <select class="form-control no-bottom-margin cboDisable" id="create_gaichyu_user" name="create_gaichyu_user" disabled>
                               <option ></option>
                                 <?php foreach ($list_gaichyu_user as $key => $value) {
                                    echo '<option value="'.$value[U_ID].'">'.$value[U_NAME].'</option>';
                                } ?> 
                            </select>   
                           
                        </div>
                    </div>
                </div>
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label" style="padding-left: 0;font-size: 88%;">管理費免除部署:</label>
                        <div class="col-md-8">
                             <select class="form-control" id="create_deparment" name="create_deparment"  style="margin-bottom: 9px;">
                               <option ></option>
                                <?php foreach ($list_department as $key => $value) {
                                     echo '<option value="'.$value[DL_DEPARTMENT_CODE].'">'.$value[DL_DEPARTMENT_NAME].'</option>';
                                 } ?>   
                            </select>   
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">ﾘﾈﾝｻﾌﾟﾗｲ売上:</label>
                        <div class="col-md-8">
                             <input id="create_tolinen_fee" name="create_tolinen_fee" class="form-control">
                        </div>
                    </div>
                </div>
               
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">ﾘﾈﾝ補充費:</label>
                        <div class="col-md-8">
                            <input  id="create_enviroment_fee" name="create_enviroment_fee" class="form-control"> 
                        </div>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label" style="padding-left: 0;">ｸﾘｰﾆﾝｸﾞ他売上:</label>
                        <div class="col-md-8">
                             <input  id="create_laundry_fee" name="create_laundry_fee" class="form-control">
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
var createUrl = "<?= base_url("master/fee_of_gaichyu/create") ?>";
var catViewUrl = "<?= base_url("master/fee_of_gaichyu/search") ?>";
var edit_CatUrl = "<?= site_url('master/fee_of_gaichyu/edit')?>";
var assetImgUrl = "<?= site_url('asset/img/')?>";
var delUrl = "<?= site_url('master/fee_of_gaichyu/delete')?>";
var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
var urlIndex= "<?= base_url("master/fee_of_gaichyu") ?>";
var url_export = "<?= base_url("master/fee_of_gaichyu/export") ?>";
var url_import = "<?= base_url("master/fee_of_gaichyu/import") ?>";
var message_exits_id_error = "<?= $this->lang->line('message_exits_id_error')?>";

</script>
