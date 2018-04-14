<style>
img{
    height:22px;

}
caption{
    background:none;
}
table,th,td{
    border:1px solid #a3a3a3


}
table{
    padding:4px;
     border:1px solid #a3a3a3
}
tr,td{
    padding:10px;

}
th{
    padding:5px;

 text-align:center;
}
table select{
    width: 50% !important;
    float: right;
    margin-left: 10px;
    margin-right:35%;
}
table:first-child caption{
    text-align:left;
}
h4 {
    font-weight: bold;
    padding-left: 8px;
}
.bootstrap-duallistbox-container .btn-group .btn {
    margin: 0;
}
.form-control {
    margin-bottom: 9px;
}
#list-table input {
    width: 100%;
    text-align: center;
}
</style>

<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3><?php echo $title; ?></h3>
    </div>
<?php if(isset($data_meta) && isset($data_meta[0])) { ?>
	<div class="first-row">
  
    <form class="form-horizontal" role="form" id="box-form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">ワンタッチID:</label>
                    <div class="col-md-8">
                       <input class="form-control" disabled name="form_id" id="form_id" value="<?php echo $data_meta[0][MOT_ID]; ?>" />
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">ワンタッチ名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                       <input class="form-control" name="form_name" id="form_name" value="<?php echo $data_meta[0][MOT_NAME]; ?>" />
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">ユーザ:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="t_my_one_touch_username"  id="t_my_one_touch_username">
                           <option value=""></option>
                           <?php 
                           if(isset($list_user)) {
                           foreach ($list_user as $key => $value) {
                                    $valSelected = '';
                                    if($value[U_ID] == $data_meta[0][MOT_USER_ID]) {
                                        $valSelected = 'selected="selected"';
                                    }
                                        echo '<option value="'.$value[U_ID].'" title="'.$value[U_NAME].'" '.$valSelected.'>'.$value[U_NAME].'</option>';
                                    } } ?> 
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">配送便区分:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="t_my_one_touch_classification"  id="t_my_one_touch_classification">
                           <option value=""></option>
                            <?php 
                            if(isset($list_classification)) {
                            foreach ($list_classification as $key => $value) {
                                $valSelected = '';
                                if($value[DC_ID] == $data_meta[0][MOT_DELIVERY_CLASSIFICATION]) {
                                    $valSelected = 'selected="selected"';
                                }
                                echo '<option value="'.$value[DC_ID].'" '.$valSelected.'>'.$value[DC_NAME].'</option>';
                             } } ?>  
                        </select>
                    </div>
                </div>
            </div>

        </div>

    </form>
    </div>
    <div class="row right third-row">
        <a id="btnAdd" class="print">行挿入 </a>
       
    </div>
   

   
    <div><br></div>
    <div class="row third-row" id="list-table">
        
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>得意先</th>
                    <th>部署</th>
                    <th>商品</th>
                    <th width=10%>発注数</th>
                    <th width=10%>コンテナ</th>
                    <th width=10%>コンテナ2</th>
                    <th width=15%>コメント</th>
             
                    <th width=10%>操作</th>
                </tr>
            </thead>
		
		 <tbody>
                             <?php if(isset($data_detail)) { 
                                 foreach ($data_detail as $key => $value) {
                                 ?>
                                <tr data-customer="<?php echo $value[MOTD_CUSTOMER_ID]; ?>" 
                                data-department="<?php echo $value[MOTD_DEPARTMENT_ID]; ?>" 
                                data-product="<?php echo $value[MOTD_PRODUCT_CODE]; ?>" data-quantity="" data-container="" data-container2="" data-comment="">
                                <td><?php echo $value["customer_name"]; ?></td>
                                <td><?php echo $value["department_name"]; ?></td>
                                <td><?php echo $value["product_name"]; ?></td>
                                <td><input class="form-control my_one_touch_quantity" type="number" value="<?php echo $value[MOTD_QUANTITY]; ?>"></td>
                                <td><input class="form-control my_one_touch_container" type="number" value="<?php echo $value[MOTD_CONTAINER1]; ?>"></td>
                                <td><input class="form-control my_one_touch_container2" type="number" value="<?php echo $value[MOTD_CONTAINER2]; ?>"></td>
                                <td><input class="form-control my_one_touch_comment" type="text" value="<?php echo $value[MOTD_COMMENT]; ?>"></td>
                                <td><a class="btnDeleteProduct"><img src="<?php echo site_url('asset/img/del.png'); ?>"></a></td>
                            </tr>
                             <?php } } ?>
         </tbody>
        </table>
		
		</div> 
   
   
    <div class="clearfix"></div>
     <div class="row third-row" style="text-align:center;">
        <a id="onClickAdd" class="print">保存</a>
    </div>
    
</div>



                            <?php } ?>
</div>


<!-- Modal sale -->
<div id="myModalProductAdd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-add">新規追加</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_add_product_detail">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label class="col-md-4 control-label">得意先:</label>
                        <div class="col-md-8">
                            <select class="form-control" name="my_one_touch_customer"  id="my_one_touch_customer">
                            <option value=""></option>
                            <?php 
                            if(isset($list_customer)) {
                            foreach ($list_customer as $key => $value) {
                                        echo '<option value="'.$value[CSHIPMENT_ID].'" title="'.$value[CSHIPMENT_NAME].'">'.$value[CSHIPMENT_NAME].'</option>';
                                    } }
                                     ?>
                                </select>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">部署:</label>
                        <div class="col-md-8">
                            <select class="form-control"  name="my_one_touch_department"  id="my_one_touch_department">
                            <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">商品:</label>
                        <div class="col-md-8">
                            <input class="form-control " name="my_one_touch_product"  id="my_one_touch_product" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">発注数:</label>
                        <div class="col-md-8">
                            <input class="form-control " name="my_one_touch_quantity"  id="my_one_touch_quantity" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">コンテナ:</label>
                        <div class="col-md-8">
                            <input class="form-control " name="my_one_touch_container"  id="my_one_touch_container" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">コンテナ2:</label>
                        <div class="col-md-8">
                            <input class="form-control " name="my_one_touch_container2"  id="my_one_touch_container2" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label class="col-md-2 control-label">コメント:</label>
                        <div class="col-md-10">
                            <input class="form-control " name="my_one_touch_comment"  id="my_one_touch_comment" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
                    <input type="hidden" id="id_my_one_touch" >
                    <a id="btnAddProductDetail" class="print print-add">保存</a>
                    <a id="btnEditProductDetail" class="print print-add" style="display: none;">保存</a>
                </div>
            </div>
        </form>
      </div>
    </div>
 
  </div>
</div>


<script>
    var editMyOneTouchDetail = "<?= base_url("master/my_one_touch/edit_post") ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var urlIndex = "<?= base_url("master/my_one_touch") ?>";
    var id_my_one_touch = "<?= $this->input->get("id"); ?>";
    var get_product_selectbox = "<?= base_url("product/get_product_selectbox") ?>";
    var getDepartmentByCustomer = "<?= base_url("shipment/get-department") ?>";
</script>
