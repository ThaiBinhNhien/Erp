
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
                    <label class="col-md-4 control-label">商品ID  :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="inputLabel3" >
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品名 :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="inputLabel4" >
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
                    <th width=10%>商品ID </th>
                    <th>商品名</th>
                    <th>商品重量</th>
                    <th width=12%>生産概要区分ID</th>
                    <th>生産概要区分</th>
                    <th width=8%>操作</th>
                </tr>
            </thead>
		
		 <tbody>
                <tr>
                    <td></td>
                    <td></td>
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
        <h4 class="modal-title modal-title-add">新規追加</h4>
         <h4 class="modal-title modal-title-edit">編集</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_add_category">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">商品ID:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control " type="number" name="group_id"  id="group_id" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">商品名:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control " name="group_name"  id="group_name" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">商品重量:</label>
                        <div class="col-md-8">
                            <input class="form-control " name="group_weight"  id="group_weight" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">生産概要区分:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control"  name="group_type"  id="group_type">
                                <?php 
                                if(isset($list_production_group)) {
                                foreach ($list_production_group as $key => $value) {
                                        echo '<option value="'.$value[POC_PRODUCTION_SUMMARY_CODE].'" title="'.$value[POC_CATEGORY_NAME].'">'.$value[POC_CATEGORY_NAME].'</option>';
                                    } }
                                     ?>
                            </select>
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
    var getListLink = "<?= base_url("master/towel/get_list") ?>";
    var editPostLink = "<?= base_url("master/towel/edit_post") ?>";
    var addPostLink = "<?= base_url("master/towel/add_post") ?>";
    var deleteLink = "<?= base_url("master/towel/delete_post") ?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
    var urlIndex = "<?= base_url("master/towel") ?>";
    var url_export = "<?= base_url("master/towel/export") ?>";
    var url_import = "<?= base_url("master/towel/import") ?>";
</script>