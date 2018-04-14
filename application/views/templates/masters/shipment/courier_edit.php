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
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3><?php echo $title; ?></h3>
    </div>

	<div class="first-row">
  <?php if(isset($data_meta)) { ?>
    <form class="form-horizontal" role="form" id="box-form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">配送便区分ID:</label>
                    <div class="col-md-8">
                       <input class="form-control" disabled name="form_id" value="<?php echo $data_meta[0][DC_ID]; ?>" id="form_id" />
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">配送便区分名:<span class="label-form-request">*</span></label>
                     <div class="col-md-8">
                       <input class="form-control" name="form_name" value="<?php echo $data_meta[0][DC_NAME]; ?>" id="form_name" />
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">コンテナ上限台数<span class="label-form-request">*</span></label>
                     <div class="col-md-8">
                        <input class="form-control" name="form_number_container" value="<?php echo $data_meta[0][DC_NUMBER_CONTAINER]; ?>" id="form_number_container" />
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">トラック台数:<span class="label-form-request">*</span></label>
                     <div class="col-md-8">
                        <input class="form-control" name="form_number_truck" value="<?php echo $data_meta[0][DC_NUMBER_TRUCK]; ?>" id="form_number_truck" />
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label" style="padding-left: 0;">トラック最大積載量:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="form_number_max_truck" value="<?php echo $data_meta[0][DC_NUMBER_MAX_TRUCK]; ?>" id="form_number_max_truck" />
                    </div>
                </div>
            </div>
        </div>

    </form>
  <?php } ?>
	</div>
    <div class="row third-row">
     <div class="col-md-6">        
        <h4>配送便 - 得意先</h4>
        <select multiple="multiple" size="10" name="duallistbox_classification_customer[]">
            <?php 
            if(isset($list_customer)) {
            foreach ($list_customer as $key => $value) {
                $valSelected = '';
                if(isset($data_customer)) {
                    foreach ($data_customer as $keyCus => $valueCus) {

                        if($value[CSHIPMENT_ID] == $valueCus[DCC_CUSTOMER_ID]) {
                            $valSelected = 'selected="selected"';
                            break;
                        }
                        else {
                            $valSelected = '';
                        }
                    }
                }

                echo '<option value="'.$value[CSHIPMENT_ID].'" '.$valSelected.' title="'.$value[CSHIPMENT_NAME].'">'.$value[CSHIPMENT_NAME].'</option>';
                
            } } ?>
        </select>
        
    </div> 

        <div class="col-md-6">        
        <h4>配送便 - 拠点マスタ</h4>
        <select multiple="multiple" size="10" name="duallistbox_classification_base[]">
            <?php 
            if(isset($list_base)) {
            foreach ($list_base as $key => $value) {
                $valSelected = '';
                if(isset($data_base)) {
                    foreach ($data_base as $keyCus => $valueCus) {

                        if($value[BM_BASE_CODE] == $valueCus[DB_BASE_CODE]) {
                            $valSelected = 'selected="selected"';
                            break;
                        }
                        else {
                            $valSelected = '';
                        }
                    }
                }
                echo '<option value="'.$value[BM_BASE_CODE].'" '.$valSelected.' title="'.$value[BM_BASE_NAME].'">'.$value[BM_BASE_NAME].'</option>';
            } } ?>
        </select>
        
    </div> 

    
    </div>
   
   
    <div class="clearfix"></div>
     <div class="row third-row" style="text-align:center;">
        <a id="onClickEdit" class="print">保存</a>
    </div>
    
</div>

	
</div>

<script>
    var editListClassifition = "<?= base_url("master/shipment_courier/edit_post") ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var urlIndex = "<?= base_url("master/shipment_courier") ?>";
    var classification_id = "<?= $this->input->get("id"); ?>"; 
</script>
