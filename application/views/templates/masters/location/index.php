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
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">拠点コード:</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" id="form_id" name="form_id" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">拠点名:</label>
                    <div class="col-md-8">
                        <input class="form-control" id="form_name" name="form_name" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">会社名 :</label>
                    <div class="col-md-8">
                         <input class="form-control "  id="form_company" name="form_company" >
                    </div>
                </div>
            </div>
            
         <!--    <div class="clearfix"></div> -->
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">都道府県:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="form_province" name="form_province" >
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">電話番号:</label>
                    <div class="col-md-8">
                        <input class="form-control " id="form_post_phone" name="form_post_phone" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">郵便番号 :</label>
                    <div class="col-md-8">
                         <input class="form-control " id="form_post_office" name="form_post_office" >
                    </div>
                </div>
            </div>
            
            <!-- <div class="clearfix"></div> -->
           
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">FAX番号 :</label>
                    <div class="col-md-8">
                        <input class="form-control " id="form_post_fax" name="form_post_fax" >
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">住所:</label>
                    <div class="col-md-8">
                        <input class="form-control " id="form_post_address" name="form_post_address" >
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 10px;margin-top: -5px;">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">外注先:</label>
                    <div class="col-md-7">
                    <div class="checkbox text-left">
                        <input type="checkbox" value="true"  id="BM_MASTER_CHECK" name="BM_MASTER_CHECK" style="margin-left: 0;
                            padding-left: 0;
                            left: 0;
                            text-align: left;
                            width: 20px;
                            height: 20px;
                            margin-top: 0;">
                        </div>
                    </div>
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
        <a href="<?php echo site_url('master/location/add'); ?>" target="_blank" class="print">新規作成</a>
    </div>
    
	<div class="row third-row" id="list-table">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="10%">拠点コード</th>
                    <th>拠点名</th>
                    <th>会社名</th>
                    <th>郵便番号 </th>
                    <th>住所1</th>
                    <th>住所2</th>
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
                    <td></td>
        
                    <td><a href="#"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a> <a href="#"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td>
                </tr>
            </tbody>
        </table>
		
		</div>  
</div>
<script>
    var getListBaseMaster = "<?= base_url("master/location/get_list") ?>";
    var editBaseMaster = "<?= base_url("master/location/edit") ?>";
    var deleteBaseMaster = "<?= base_url("master/location/delete_post") ?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
    var urlIndex = "<?= base_url("master/location") ?>";
    var url_export = "<?= base_url("master/location/export") ?>";
    var url_import = "<?= base_url("master/location/import") ?>";
</script>

