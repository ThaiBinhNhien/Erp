
<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>部署台帳　一覧 </h3>
    </div>

    <div class="first-row">
    <form class="form-horizontal" role="form">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">在庫場所  :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" id="name" >
                    </div>
                </div>
            </div>
</form>
    </div>
    <div class="clearfix"></div>
    <div class="row left third-row">
        <a href="#" id="search" class="print">検索 </a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    <div class="row right third-row">
        <a href="#"  data-toggle="modal" data-target="#create-form" class="print">新規追加</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    <div class="clearfix"></div>
    <div class="left third-row col-sm-12 col-md-8 col-lg-8">
            <form action="<?= base_url('master/warehouse/import')?>" method="POST" enctype="multipart/form-data">
                <div class="col-md-4">
                    <input type="file" class="form-control-file" name="import_file" />
                </div>
                <div class="col-md-2">
                    <input type="submit" class="print" value="CSV入力"  />
                </div>
            </form>
            <form action="<?= base_url('master/warehouse/export')?>" method="POST">
                <div class="col-md-2">
                    <input type="submit" class="print" value="CSV出力"/>
                </div>
            </form>
        </div>
    <div class="row third-row" id="order-table">
        <table  class="display datatable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width=10%>注文No</th>
                    <th>在庫場所 </th>
                    <th  width=6%>操作</th>
                </tr>
            </thead>
        
        
         <tbody id="detail_data">
            <?php 
            if(isset($warehouse)) {
            foreach ($warehouse as $key => $value) {?>
                <tr data-id="<?= $value[TSP_ID] ?>">
                    <td><?= $value[TSP_ID] ?></td>
                    <td><?= $value[TSP_INVENTORY_LOCATION] ?></td>
                    <td><a href="#" data-toggle="modal" data-target="#edit-form" class="edit"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a>
                    <a href="#" class="delete" data-id="<?= $value[TSP_ID] ?>"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td>
                </tr>
            <?php } } ?>
                
            </tbody>
        </table>
        
        </div> 
</div>
<div id="edit-form" class="modal fade" role="dialog">
    <div class="modal-dialog modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">EDIT</h4>
        </div>
        <div class="modal-body">
         <form class="form-horizontal" role="form" id="edit_form">
            <div class="row">
              <div class="col-md-12 col-xs-12 form-group pad10">
                    <div class="col-md-12 col-xs-12 form-group pad10">
                        <div class="col-md-3 col-md-offset-1"><label class="control-label">部署名</label></div>
                        <div class="col-md-6">
                            <input type="text" disabled id="edit_id" name="edit_id" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 form-group pad10">
                        <div class="col-md-3 col-md-offset-1"><label class="control-label">集計ｺｰド</label></div>
                        <div class="col-md-6">
                            <input type="text" id="edit_name" name="edit_name" class="form-control">
                        </div>
                    </div>
                
              </div>
       
            </div>
        </form>
          <div class="modal-footer">
            <input type="button" id="edit" class="btn btn-primary" value="EDIT">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCEL">
          </div>
        </div>
    </div>
</div>
<div id="create-form" class="modal fade" role="dialog">
    <div class="modal-dialog modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">CREATE</h4>
        </div>
        <div class="modal-body">
         <form class="form-horizontal" role="form" id="form">
            <div class="row">
              <div class="col-md-12 col-xs-12 form-group pad10">
                <div class="col-md-12 col-xs-12 form-group pad10">
                    <div class="col-md-3 col-md-offset-1"><label class="control-label">集計ｺｰド</label></div>
                    <div class="col-md-6">
                        <input type="text" id="create_name" name="create_name" class="form-control">
                    </div>
                </div>

              </div>
        
            </div>
        </form>
          <div class="modal-footer">
            <input type="button" id="save" class="btn btn-primary" value="CREATE">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="CANCEL">
          </div>
        
        </div>
    </div>
</div>
<script>
var editUrl = "<?= base_url('warehouse/edit')?>";
var imgUrl = "<?= site_url('asset/img/')?>";
var warehouseViewUrl = "<?= base_url('warehouse/get-warehouse-view')?>";
var delUrl = "<?= base_url('warehouse/remove')?>";
var createUrl = "<?= base_url('warehouse/create')?>";
</script>