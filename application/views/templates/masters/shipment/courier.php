
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
            <label class="col-md-4 control-label">配送便区分ID :</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="inputLabel3" >
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
            <label class="col-md-4 control-label">配送便区分名 :</label>
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
            <div class="col-md-3">
                <select class="form-control" name="get_type_csv" id="get_type_csv" style="    width: 100%;">
                    <option value="1">配送便</option>
                    <option value="2">配送便 - 得意先</option>
                    <option value="3">配送便 - 拠点マスタ</option>
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
    <a href="<?php echo site_url('master/shipment_courier/add'); ?>" class="print">新規追加</a>     
    </div>
    <div class="row third-row" id="list-table">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="12%">配送便区分ID</th>
                    <th>配送便区分名 </th>
                    <th>コンテナ上限台数</th>
                    <th>トラック台数</th>
                    <th>トラック最大積載量 </th>
                    <th width="8%">操作</th>
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

<script>
    var getListClassifition = "<?= base_url("master/shipment_courier/get_list") ?>";
    var editListClassifition = "<?= base_url("master/shipment_courier/edit") ?>";
    var deleteListClassifition = "<?= base_url("master/shipment_courier/delete") ?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
    //var message_confirm_delete_field = "<?= sprintf($this->lang->line('message_confirm_delete_field'), "AS"); ?>"
    var urlIndex = "<?= base_url("master/shipment_courier") ?>"; 
    var url_export = "<?= base_url("master/shipment_courier/export") ?>";
    var url_import = "<?= base_url("master/shipment_courier/import") ?>";
</script>
