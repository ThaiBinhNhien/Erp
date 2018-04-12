
<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>得意先台帳　一覧 </h3>
    </div>

	<div class="first-row">
  
    <form class="form-horizontal" role="form">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">得意先ID  :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="id" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">得意先名 :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="name" >
                    </div>
                </div>
            </div>
           <!--  <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">担当者:</label>
                    <div class="col-md-8">
                        <select  class="form-control selectpicker" data-live-search="true" id="user" >
                        <option></option>
                        <?php foreach ($lstUser as $key => $value) { ?>
                            <option value="<?= $value[U_ID] ?>"><?= $value[U_NAME] ?></option>
                        <?php }?>
                        </select>
                    </div>
                </div>
            </div> -->
             
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">電話番号 :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="phone_number" >
                    </div>
                </div>
            </div>
           <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">FAX番号:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="fax" >
                    </div>
                </div>
            </div>
          
            
            <div class="col-sm-12 col-md-4 col-lg-4" >
                <div class="form-group">
                    <label class="col-md-4 control-label">住所:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="address" >
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
        
        <a href="<?php echo site_url('master/customer/create-customer'); ?>" class="print">新規追加</a>
    </div>
    <div class="clearfix"></div>
    
	<div class="row third-row" id="cus-table">
        <table  class="display datatable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width=10%>得意先ID</th>
                    <th>得意先名 </th>
                    <th>電話番号</th>
                    <th>住所1</th>
                    <th>住所2</th>
                    <th  width=8%>操作</th>

                </tr>
            </thead>
		

		 <tbody id="detail_data">
            <?php foreach ($lstCus as $key => $value) {

                ?>
                <tr>
                    <td><?= $value[CUS_ID] ?></td>
                    <td><?= $value[CUS_CUSTOMER_NAME] ?></td>
                    <td><?= $value[CUS_PHONE_NUMBER] ?></td>
                    <td><?= $value[CUS_ADDRESS_1] ?></td>
                    <td><?= $value[CUS_ADDRESS_2] ?></td>
                    <td>
                        <a href="<?= base_url("master/customer/edit-customer")."?id=".$value[CUS_ID] ?>"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a> 
                        <a href="#" class="delete" data-id="<?= $value[CUS_ID] ?>"><img src="<?php echo site_url('asset/img/');?>del.png"/></a>
                    </td>
  
                </tr>
            <?php } ?>

            </tbody>
        </table>
		
		</div> 
</div>
<style>
.bootstrap-select>.dropdown-toggle{
    width:88%;
}
.form-group button {
    background: #fff;
    border-radius: 2px;
    margin: 0;
}
.form-group .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 88%;
    line-height: 18px;
}
td .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 88%;
    line-height: 18px;
}
.bootstrap-select button{
    height: 30px;
}
</style>
<script>
var editUrl = "<?= base_url('master/customer/edit-customer')?>";
var imgUrl = "<?= site_url('asset/img/')?>";
var cusViewUrl = "<?= base_url('customer/get-customer-view')?>";
var delUrl = "<?= base_url('customer/remove')?>";
var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
var urlIndex = "<?= base_url("master/customer") ?>";
var url_export_master = "<?= base_url("master/customer/export") ?>";
var url_import_master = "<?= base_url("master/customer/import") ?>";
var url_export_detail_1 = "<?= base_url("master/customer-department/export") ?>";
var url_import_detail_1 = "<?= base_url("master/customer-department/import") ?>";
var url_import ="";
var url_export ="";
</script>