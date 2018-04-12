<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>仕入先　一覧 </h3>
    </div>

    <div class="first-row">
  
    <form class="form-horizontal" role="form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">仕入先ID:</label>
                    <div class="col-md-8">
                        <input class="form-control " id="sup_id" >
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">会社名:</label>
                    <div class="col-md-8">
                        <input class="form-control " id="sup_company_name" >
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">担当者名:</label>
                    <div class="col-md-8">
                        <input class="form-control " id="sup_contact_name" name="sup_contact_name" >
                    </div>
                </div>
            </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">郵便番号 :</label>
                    <div class="col-md-8">
                        <input class="form-control "  id="sup_postal_code">
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所:</label>
                    <div class="col-md-8">
                        <input class="form-control " id="sup_address" >
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">電話番号:</label>
                    <div class="col-md-8">
                         <input class="form-control " id="sup_phone_number">
                    </div>
                </div>
            </div>
           
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">FAX番号 :</label>
                    <div class="col-md-8">
                         <input class="form-control " id="sup_fax_number">
                    </div>
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
       
        <a href="<?php echo site_url('master/supplier/create_supplier'); ?>" class="print">新規作成</a>
    </div>
    <div class="row third-row" id="supplier-table">
        <table  class="display datatable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr id="table_header">
                    <th width="10%">仕入先ID</th>
                    <th>会社名</th>
                    <th>郵便番号 </th>
                    <th>住所1</th>
                    <th>住所2</th>
                    <th width="8%">操作</th>
                   
                </tr>
            </thead>
        
        
         <tbody id="detail_data">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        </div> 
</div>
<script>
var supplierViewUrl = "<?= base_url("master/supplier/search_supplier") ?>";
var edit_supplierUrl = "<?= site_url('master/supplier/edit_supplier')?>";
var assetImgUrl = "<?= site_url('asset/img/')?>";
var delUrl = "<?= site_url('master/supplier/delete_supplier')?>";
var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
var urlIndex= "<?= base_url("master/supplier") ?>";
var url_export = "<?= base_url("master/supplier/export") ?>";
var url_import = "<?= base_url("master/supplier/import") ?>";
</script>
