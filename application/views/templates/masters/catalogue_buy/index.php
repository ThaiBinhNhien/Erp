
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
                    <label class="col-md-4 control-label">種目区分ID  :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="inputLabel3" >
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">種目区分名  :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="inputLabel4" >
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品ｶﾃｺﾞﾘ  :</label>
                    <div class="col-md-8">
                        <select class="form-control " name="type_product" id="type_product">
                            <option value=""></option>
                            <option value="1">リネンサプライ</option>
                            <option value="2">洗剤等</option>
                         </select>
                    </div>
                </div>
            </div>
           
    </form>
	</div>
    <div class="clearfix"></div>
    <div class="row left third-row">
        <a id="btnSearch" class="print">検索 </a> 
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
        <a id="btnInsert" class="print">新規追加</a>
    </div>
	<div class="row third-row" id="list-table">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width=12%>種目区分ID</th>
                    <th>種目区分名 </th>
                    <th>商品ｶﾃｺﾞﾘ </th>
                    <th width=8%>操作</th>
                </tr>
            </thead>
		
		 <tbody>
                <tr>
                    <td></td>
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
        <h4 class="modal-title modal-title-add">新規追加 </h4>
        <h4 class="modal-title modal-title-edit">編集</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_add_category">
            <div class="row">

                <div class="col-sm-12 col-md-12 col-lg-12" id="lab_insert_type">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="radio-inline col-md-3">リネンサプライ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="optradioTypeInsert" checked value="1"></label>
                        <label class="radio-inline col-md-3" style="margin-left: 40px;">洗剤等&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="optradioTypeInsert" value="2"></label>
                        <div class="col-md-4">
                            <select class="form-control"  name="create_type_product"  id="create_type_product">
                            <option value="1">当社分</option>
                            <option value="2">外注分</option>
                        </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">種目区分ID:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control" type="number" name="group_id"  id="group_id" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">種目区分名:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control " name="group_name"  id="group_name" >
                        </div>
                    </div>
                </div>
                
                
                <div class="col-sm-12 col-md-12 col-lg-12">&nbsp;</div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                        <input type="hidden" name="id_set_category"  id="id_set_category" >
                        <a id="btnAddCategory" class="print print-add" style="display: none;">保存</a>
                    <a id="btnEditCategory" class="print print-edit" style="display: none;">保存</a>
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
    var getListCatelogue = "<?= base_url("master/catalogue_buy/get_list") ?>";
    var editPostCatelogue = "<?= base_url("master/catalogue_buy/edit_post") ?>";
    var addPostCatelogue = "<?= base_url("master/catalogue_buy/add_post") ?>";
    var deleteCatelogue = "<?= base_url("master/catalogue_buy/delete_post") ?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
    var urlIndex = "<?= base_url("master/catalogue_buy") ?>";
    var url_export = "<?= base_url("master/catalogue_buy/export") ?>";
    var url_import = "<?= base_url("master/catalogue_buy/import") ?>";
</script>
