
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
                    <label class="col-md-4 control-label">グループID</label>
                    
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="id" >
                    </div>
                </div>
            </div>
           
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label"><?= $this->lang->line('label_input_search')?></label>
                    
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
                    <th width=10%>グループID</th> 
                    <th>グループ名</th>
                    <th>タイプ</th>
                    <th>日計表</th>
                    <th width=8%>操作</th>
                </tr>
            </thead>
		
		 <tbody>
                <tr>
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
        <h4 class="modal-title modal-title-add">新規追加 </h4>
        <h4 class="modal-title modal-title-edit">編集</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_add_set_product">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">グループID:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control " type="number" name="id_group_code"  id="id_group_code" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">グループ名:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control " name="name_group_code"  id="name_group_code" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">日計表:</label>
                        <div class="col-md-8">
                            <select class="form-control" name="id_group_schedule" id="id_group_schedule">
                            <option value="0"></option>
                            <option value="3">全て</option>
                            <option value="1">日計表Ａ</option>
                            <option value="2">日計表Ｂ</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">タイプ:</label>
                        <div class="col-md-8">
                            <select class="form-control" name="id_group_type" id="id_group_type">
                            <option value="0"></option>
                            <option value="1">ｺﾝﾄﾛｰﾙ</option>
                            <option value="2">浴衣補充費</option>
                            </select>
                        </div>
                    </div>
                </div>
               
                <div class="col-sm-12 col-md-12 col-lg-12">&nbsp;</div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                        <input type="hidden" name="id_set_group_code"  id="id_set_group_code" >
                        <a id="btnAddGroupCode" class="print print-add" style="display: none;">保存</a>
                    <a id="btnEditGroupCode" class="print print-edit" style="display: none;">保存</a>
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
    var getListStatisticalGroup = "<?= base_url("master/statistical_group/get_list") ?>";
    var editPostStatisticalGroup = "<?= base_url("master/statistical_group/edit_post") ?>";
    var addPostStatisticalGroup = "<?= base_url("master/statistical_group/add_post") ?>";
    var deleteStatisticalGroup = "<?= base_url("master/statistical_group/delete_post") ?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
    var message_exits_id_error = "<?= $this->lang->line('message_exits_id_error')?>";
    var urlIndex = "<?= base_url("master/statistical_group") ?>";
    var url_export = "<?= base_url("master/statistical_group/export") ?>";
    var url_import = "<?= base_url("master/statistical_group/import") ?>";
</script>
