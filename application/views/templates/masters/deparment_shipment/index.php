
<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>部署Ｍ　一覧 </h3> 
    </div>

	<div class="first-row">
    <form class="form-horizontal" role="form">
        <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">部署ID  :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="id" id="id" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">部署名 :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" id="name" >
                    </div>
                </div>
            </div>
            </form>
	</div>
    <div class="clearfix"></div>
    <div class="row left third-row">
        <a class="print" id="search">検索 </a>
    </div>
    <div class="clearfix"></div>
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
        <a href="#"  data-toggle="modal" data-target="#create-form" id="create" class="print">新規追加</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    <div class="clearfix"></div>
    
	<div class="row third-row" id="order-table">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width=10%>部署ID</th>
                    <th>部署名  </th>
                    <th  width=8%>操作</th>
                </tr>
            </thead>
		
		
		 <tbody id="detail_data">
            <?php 
            if(isset($department)) {
            foreach ($department as $key => $value) {?>
                <tr data-id="<?= $value[DSL_DEPARTMENT_CODE] ?>">
                    <td><?= $value[DSL_DEPARTMENT_CODE] ?></td>
                    <td><?= $value[DSL_DEPARTMENT_NAME] ?></td>
                    <td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a> 
                    <a href="#" class="delete" data-id="<?= $value[DSL_DEPARTMENT_CODE] ?>"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td>
                </tr>
            <?php } } ?>
                
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
               
                    <input type="hidden" id="dp_id" />
                    <div class="col-md-12 col-xs-12 form-group pad10">
                        <div class="col-md-3 col-md-offset-1"><label class="control-label">部署ID</label></div>
                        <div class="col-md-6">
                            <input disabled="true" type="text" id="edit_id" name="edit_id" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 form-group pad10">
                        <div class="col-md-3 col-md-offset-1"><label class="control-label">部署名<span class="label-form-request">*</span></label>
</div>
                        <div class="col-md-6">
                            <input type="text" id="edit_name" name="edit_name" class="form-control">
                        </div>
                    </div>
              </div>
        
            </div>
        </form>
        <br>
          <div class="" style="text-align:center;">
            <input type="button" id="edit" class="print print-edit" value="保存">
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
                <input type="hidden" id="dp_id" />
                <div class="col-md-12 col-xs-12 form-group pad10">
                    <div class="col-md-3 col-md-offset-1"><label class="control-label">部署ID<span class="label-form-request">*</span></label>
</div>
                    <div class="col-md-6">
                        <input type="number" id="create_id" name="create_id" class="form-control">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 form-group pad10">
                    <div class="col-md-3 col-md-offset-1"><label class="control-label">部署名<span class="label-form-request">*</span></label>
</div>
                    <div class="col-md-6">
                        <input type="text" id="create_name" name="create_name" class="form-control">
                    </div>
                </div>
              </div>
        
            </div>
        </form>
        <br>
          <div class=""  style="text-align:center;">
            <input type="button" id="save" class="print print-add" value="保存">
          </div>
        
        </div>
    </div>
</div>
<script>
var editUrl = "<?= base_url('master/department_shipment/edit')?>";
var imgUrl = "<?= site_url('asset/img/')?>";
var departmentViewUrl = "<?= base_url('master/department_shipment/get-department-view')?>";
var delUrl = "<?= base_url('master/department_shipment/remove')?>";
var createUrl = "<?= base_url('master/department_shipment/create')?>";
var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
var message_exits_id_error = "<?= $this->lang->line('message_exits_id_error')?>";
var urlIndex = "<?= base_url("master/department_shipment") ?>";
var url_export = "<?= base_url("master/department_shipment/export") ?>";
var url_import = "<?= base_url("master/department_shipment/import") ?>";
</script>