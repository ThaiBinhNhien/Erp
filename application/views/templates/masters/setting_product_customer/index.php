<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3><?php echo $title; ?></h3>
    </div>

    <div class="col-sm-12 col-md-10 col-lg-9 col-md-offset-2">   
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
    <div class="clearfix"></div>

	<div class="first-row">
  
    <form class="form-horizontal" role="form" id="box-form">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-2 control-label">得意先:<span class="label-form-request">*</span></label>
                    <div class="col-md-3" style="padding-left: 15px;"> 
                       <select class="form-control" name="valueSetCustomer" id="valueSetCustomer">
                           <option></option>
                           <?php 
                           if(isset($list_customer)) {
                           foreach ($list_customer as $key => $value) {
                                    echo '<option value="'.$value[CSHIPMENT_ID].'" title="'.$value[CSHIPMENT_NAME].'">'.$value[CSHIPMENT_NAME].'</option>';
                                } }
                                ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-2 control-label">商品セット :</label>
                    <div class="col-md-6">
                        <div id="list_customer2">
                            <select multiple="multiple" size="10" name="list_set_product2[]">

                            </select>
                        </div>
                        <div id="list_customer1" style="display: none;">
                        <select multiple="multiple" size="10" name="list_set_product[]">
                            <?php 
                            if(isset($set_product)) {
                            foreach ($set_product as $key => $value) {
                                echo '<option value="'.$value[PSS_PRODUCT_SET_CODE].'" title="'.$value[PSS_PRODUCT_SET_NAME].'">'.$value[PSS_PRODUCT_SET_NAME].'</option>';
                            } } ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>
	</div>
   
    <div class="clearfix"></div>
     <div class="row third-row" style="text-align:center;">
        <a id="onClickToSave" class="print">保存</a>
    </div>
	
</div>

<script>
    var load_set_product_by_customer = "<?= base_url("master/setting_product_customer/load_set_product_by_customer") ?>";
    var add_customer_setproduct_base = "<?= base_url("master/setting_product_customer/add_post") ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var urlIndex = "<?= base_url("master/setting_product_customer") ?>";
    var url_export = "<?= base_url("master/setting_product_customer/export") ?>";
    var url_import = "<?= base_url("master/setting_product_customer/import") ?>";
</script>

