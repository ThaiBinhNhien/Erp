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
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>売上先　編集</h3>
    </div>

    <div class="first-row">
  
    <form class="form-horizontal" role="form" id="place_sale_form">
        <div class="row">
           <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">売上先ID :</label>
                    <div class="col-md-8">
                        <input class="form-control " disabled="true"   name="distributor_id" id="distributor_id" value="<?= $master[TSD_ID] ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">売上先名:<span class="label-form-request">*</span></label>

                    <div class="col-md-8">
                        <input class="form-control "  name="distributor_name" id="distributor_name"  value="<?= $master[TSD_DISTRIBUTOR_NAME] ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">担当者名:<span class="label-form-request">*</span></label>

                    <div class="col-md-8">
                        <select class="form-control" id="user_id" name="user_id">
                            <?php foreach ($list_contact_user as $key => $value) {
                                echo '<option value="'.$value[U_ID].'" '.($value[U_ID]==$master[TSD_USER_ID]?'selected':'').' >'.$value[U_NAME].'</option>';
                             } ?>  
                        </select> 
                       
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">郵便番号:</label>
                    <div class="col-md-8">
                        <input class="form-control " id="postal_code" name="postal_code" value="<?= $master[TSD_POSTAL_CODE] ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所 1:<span class="label-form-request">*</span></label>

                    <div class="col-md-8">
                          <input class="form-control " id="address_1" name="address_1"  value="<?= $master[TSD_ADDRESS_1] ?>">
                    </div>
                </div>
            </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所 2:</label>
                    <div class="col-md-8">
                          <input class="form-control " id="address_2" name="address_2" value="<?= $master[TSD_ADDRESS_2] ?>">
                    </div>
                </div>
            </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">電話番号:<span class="label-form-request">*</span></label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" id="phone_number" name="phone_number"  value="<?= $master[TSD_PHONE_NUMBER] ?>">
                    </div>
                </div>
            </div>
           
             
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">FAX番号:</label>
                    <div class="col-md-8">
                         <input class="form-control " id="fax_number" name="fax_number" value="<?= $master[TSD_FAX_NUMBER] ?>">
                    </div>
                </div>
            </div>
            
           
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">外注:<span class="label-form-request">*</span></label>

                    <div class="col-md-8">
                        <select class="form-control "  name="outsourcing"  id="outsourcing">
                            <?php foreach ($list_outsourcing as $key => $value) {
                                echo '<option value="'.$key.'" '.($key==$master[TSD_OUTSOURCING]?'selected':'').' >'.$value.'</option>';
                             } ?>  
                        </select>
                       
                    </div>
                </div>
            </div>
           
          
           
           <!-- 
            <div class="clearfix"></div>
           
             -->
            
           
           
             
            
        </div>

    </form>
    </div>
    
   
    <div class="clearfix"></div>
     <div class="row third-row" style="text-align:center;">
        <a href="#dialog-form" id="save_sale" class="print save_sale">保存</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    
</div>
<script>
 var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
 var editUrl = "<?= site_url('/master/place_of_sales/edit')?>";
 var master_id = "<?= $master[TSD_ID]?>";
 var message_confirm_save_field = "<?= $this->lang->line('message_confirm_save_field')?>";
 var urlIndex = "<?= base_url("master/place_of_sales") ?>";
</script>