
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
                <label class="col-md-4 control-label">ユーザ名 :</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="inputLabel1" >
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="col-md-4 control-label">氏名 :</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="inputLabel2" >
                </div>
            </div> 
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="col-md-4 control-label">拠点 :</label>
                <div class="col-md-8">
                    <select class="form-control right-75" id="inputLabel3" name="inputLabel3">
                    <option></option>
                    <?php 
                    if(isset($baseMaster)) {
                    foreach($baseMaster as $base) { ?>
                    <option value="<?php echo $base[BM_BASE_CODE]; ?>" <?php if(isset($user) and $user[U_BASE_CODE] == $base[BM_BASE_CODE]) echo 'selected'; ?>><?php echo $base[BM_BASE_NAME]; ?></option>
                    <?php } } ?>
                </select>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
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
         <a href="<?php echo site_url('master/user/add');?>" class="print">新規追加</a>
    </div>
    <div class="row third-row" id="list-table">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
		<thead>
 			<tr>
 				<th width="15%">ユーザ名</th>
 				<th width="15%">氏名</th>
 				<th width="15%">シメイ</th>
 				<th width="15%">拠点</th>
 				<th width="15%">役職</th>
                <th width="15%">更新日</th>
 				<th width=10%>操作</th>
 			</tr>

            <tbody>
                <tr>
                    <td></td>
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

<script>
    var getListMasterUser = "<?= base_url("master/user/get_list") ?>";
	var editMasterUser = "<?= base_url("master/user/edit") ?>";
	var deleteMasterUser = "<?= base_url("master/user/delete_post") ?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
    var urlIndex = "<?= base_url("master/user") ?>"; 
    var url_export = "<?= base_url("master/user/export") ?>";
    var url_import = "<?= base_url("master/user/import") ?>";
    var user_id = "<?= $user_id; ?>";
</script>
