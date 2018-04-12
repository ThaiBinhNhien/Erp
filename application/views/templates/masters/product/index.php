<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>商品マスター　一覧 </h3>
    </div>

    <div class="first-row">
  
    <form class="form-horizontal" role="form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品コード :</label>
                    <div class="col-md-8">
                        <input class="form-control " id="product_id">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品名:</label>
                    <div class="col-md-8">
                         <input type="text" class="form-control" id="product_name" >
                    </div>
                </div>
            </div> 
            
<!-- 
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品名:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="product_name" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">仕入区分:</label>
                    <div class="col-md-8">

                         <select class="form-control" id="t_category">
                            <option value=''></option>
                        </select>
                    </div>
                </div>
            </div>
            
  
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品区分 :</label>
                    <div class="col-md-8">
                         <select class="form-control" id="category">
                            <option value=''></option>    
                        </select> 
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">仕入項目:</label>
                    <div class="col-md-8">
                        <select class="form-control" id="t_catalogue">
                            <option value=''></option>
                        </select>
                    </div>
                </div>
            </div> -->
          <!--   <div class="clearfix visible-lg-block visible-md-block"></div> -->
            <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">種目区分 :</label>
                    <div class="col-md-8">
                        <select class="form-control no-bottom-margin" id="catalogue" >
                            <option value=''></option>
                            
                        </select>
                    </div>
                </div>
            </div> -->
            
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
       
        <a href="<?php echo site_url('master/product/create-product'); ?>" class="print">新規作成</a>
    </div>
    <div class="row third-row" id="product-table">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr id="table_header">
                    <th width="10%">ID</th>
                    <th>仕入商品コード</th>
                    <th>仕入商品名</th>
                    <th>売上商品コード</th>
                    <th>売上商品名</th>
                    <th>規格</th>
                    <th>色調</th>
                    <th width="8%">操作</th>
                   <!--  <th colspan="2" width=3%>操作</th> -->
                </tr>
            </thead>
        
        
         <tbody id="detail_data">
                
         </tbody>
        </table> 
        
        </div> 
</div>
<script>
var productViewUrl = "<?= base_url("master/product/get_product_view") ?>";
var edit_productUrl = "<?= site_url('master/product/edit-product')?>";
var assetImgUrl = "<?= site_url('asset/img/')?>";
var delUrl = "<?= site_url('master/product/delete-product')?>";
var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
var urlIndex= "<?= base_url("master/product") ?>";
var url_export = "<?= base_url("master/product/export") ?>";
var url_import = "<?= base_url("master/product/import") ?>";
</script>