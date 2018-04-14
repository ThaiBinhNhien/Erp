
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
                    <label class="col-md-5 control-label">受発注専用得意先ID :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="inputLabel3" >
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">受発注専用得意先名 :</label>
                    <div class="col-md-7">
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
            <div class="col-md-3">
                <select class="form-control" name="get_type_csv" id="get_type_csv" style="    width: 100%;">
                    <option value="1">受発注専用得意先M</option>
                    <option value="2">受発注専用得意先M-部署Ｍ</option>
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
        <!-- <a id="btnInsert" class="print">新規追加</a> -->
        <a href="<?= base_url("master/customer_shipment/create-customer") ?>" target="_blank" class="print">新規追加</a>
    </div>
	<div class="row third-row" id="list-table">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="10%">受発注専用得意先ID</th>
                    <th>受発注専用得意先名</th>
                    <th>得意先</th>
                    <th width="8%">操作</th>
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

                <div class="col-sm-12 col-md-8 col-offset-md-2">
                    <div class="form-group">
                        <label class="col-md-5 control-label">受発注専用得意先ID:</label>
                        <div class="col-md-7">
                            <input class="form-control " type="number" name="group_id"  id="group_id" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-8 col-offset-md-2">
                    <div class="form-group">
                        <label class="col-md-5 control-label">受発注専用得意先名:</label>
                        <div class="col-md-7">
                            <input class="form-control " name="group_name"  id="group_name" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-8 col-offset-md-2">
                    <div class="form-group">
                        <label class="col-md-5 control-label">得意先:</label>
                        <div class="col-md-7">
                            <select class="form-control"  name="group_customer"  id="group_customer">
                                <?php 
                                if(isset($list_customer)) {
                                foreach ($list_customer as $key => $value) {
                                        echo '<option value="'.$value[CUS_ID].'" title="'.$value[CUS_CUSTOMER_NAME].'">'.$value[CUS_CUSTOMER_NAME].'</option>';
                                    } } ?>
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
    var getListLink = "<?= base_url("master/customer_shipment/get_list") ?>";
    var editPostLink = "<?= base_url("master/customer_shipment/edit_post") ?>";
    var addPostLink = "<?= base_url("master/customer_shipment/add_post") ?>";
    var deleteLink = "<?= base_url("master/customer_shipment/delete_post") ?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
    var urlIndex = "<?= base_url("master/customer_shipment") ?>";
    var url_export = "<?= base_url("master/customer_shipment/export") ?>";
    var url_import = "<?= base_url("master/customer_shipment/import") ?>";
    var url_edit_customer = "<?= base_url("master/customer_shipment/edit-customer") ?>";
</script>
