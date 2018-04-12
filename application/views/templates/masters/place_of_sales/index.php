
<style>
img{
    height:22px;

}
#receive-order .col-lg-4 ._create { float: right; margin-right: 18px; }
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>売上先　一覧</h3>
    </div>

    <div class="first-row">
  
    <form class="form-horizontal" role="form">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">売上先ID :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="distributor_id" id="distributor_id" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">売上先名:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="distributor_name" id="distributor_name" >
                    </div>
                </div>
            </div>
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
                    <label class="col-md-4 control-label">郵便番号 :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="postal_code" name="postal_code">
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所 :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                </div>
            </div>
           
           
           <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">FAX番号:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="fax_number" name="fax_number" >
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
            <a id="btnExport" class="print" >CSV出力</a>
        </div>
    </div>
  
    <div class="row right third-row">
         <a href="<?php echo site_url('master/place_of_sales/create'); ?>" class="print _create">新規追加</a>
    </div>

    <div class="row third-row" id="place-sale-table">
        <table  class="display datatable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr id="table_header">
                    <th width=10%>売上先ID</th>
                    <th>売上先名</th>
                    <th>郵便番号</th>
                    <th>電話番号</th>
                    <th>住所1</th>
                    <th>住所2</th>
                    <!-- <th colspan="2" width=3%>操作</th> -->
                    <th width=8%>操作</th>
                </tr>
            </thead>
        
        
         <tbody id="detail_data">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  <!--   <td><a href="#"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a></td>
                    <td><a href="#"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td> -->
                </tr>
            </tbody>
        </table>
        
        </div> 
</div>
<script>
var viewUrl = "<?= base_url("master/place_of_sales/search") ?>";
var edit_Url = "<?= site_url('master/place_of_sales/edit')?>";
var assetImgUrl = "<?= site_url('asset/img/')?>";
var delUrl = "<?= site_url('master/place_of_sales/delete')?>";
var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
var urlIndex= "<?= base_url("master/place_of_sales") ?>";
var url_export = "<?= base_url("master/place_of_sales/export") ?>";
var url_import = "<?= base_url("master/place_of_sales/import") ?>";
</script>