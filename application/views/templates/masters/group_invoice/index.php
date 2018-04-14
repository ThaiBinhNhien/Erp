
<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>請求書グループ　一覧 </h3>
    </div>

	<div class="first-row">
  
    <form class="form-horizontal" role="form">
        <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">グループID  :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="id" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">グループ名 :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="name" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">請求書上に表示名:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="display_name" >
                    </div>
                </div>
            </div>
           
    </form>
	</div>
    <div class="clearfix"></div>
    <div class="row left third-row">
        <a class="print" id="search">検索 </a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12 col-md-10 col-lg-9">   
        <form class="form-horizontal" role="form" id="form_import_csv" method="POST" enctype="multipart/form-data">    
            <div class="col-md-4">
                <input type="file" class="form-control-file validation-required" name="import_file" id="import_file" required />
            </div>
            <div class="col-md-3">
                <select class="form-control" id="get_type_csv" style="    width: 100%;">
                    <option value="1">得意先</option>
                    <option value="2">得意先部署</option>
                </select>
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
        <a href="<?php echo site_url('master/group-invoice/create'); ?>" class="print">新規追加</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    <div class="clearfix"></div>
    
	<div class="row third-row" id="order-table">
        <table  class="display datatable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width=10%>グループID </th>
                    <th>グループ名 </th>
                    <th>洗濯区分名 </th>
                    <th>住所</th>
                    <th>割引</th>
                    <th>補充費 </th>
                    <th>請求書上に総定額</th>
                    <th  width=8% >操作</th>
                </tr>
            </thead>
		
		
		 <tbody id="detail_data">
            <?php foreach ($group_invoice as $key => $value) {?>
                <tr>
                    <td><?= $value[IG_ID] ?></td>
                    <td><?= $value[IG_INVOICE_NAME] ?></td>
                    <td><?= $value[IG_DISPLAY_NAME] ?></td>
                    <td><?= $value[IG_STREET_ADDRESS] ?></td>
                    <td><?= $value[IG_DISCOUNT] ?></td>
                    <td><?= $value[IG_ENVIRONMENTAL_LOAD] ?></td>
                    <td><?= $value[IG_FIXED_AMOUNT] ?></td>
                    <td><a href="<?= base_url("master/group-invoice/edit")."?id=".$value[IG_ID] ?>"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a>
                    <a href="#" class="delete" data-id="<?= $value[IG_ID] ?>"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td>
                </tr>
                
            <?php }?>
                
            </tbody>
        </table>
		
		</div> 
</div>
<script>
var editUrl = "<?= base_url('master/group-invoice/edit')?>";
var imgUrl = "<?= site_url('asset/img/')?>";
var groupViewUrl = "<?= base_url('group-invoice/get-group-invoice-view')?>";
var delUrl = "<?= base_url('group-invoice/remove')?>";
var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
var message_exits_id_error = "<?= $this->lang->line('message_exits_id_error')?>";
var urlIndex = "<?= base_url("master/group-invoice") ?>";
var url_export_master = "<?= base_url("master/group-invoice/export") ?>";
var url_import_master = "<?= base_url("master/group-invoice/import") ?>";
var url_export_detail = "<?= base_url("master/group-invoice-detail/export") ?>";
var url_import_detail = "<?= base_url("master/group-invoice-detail/import") ?>";
var url_import ="";
var url_export ="";
</script>