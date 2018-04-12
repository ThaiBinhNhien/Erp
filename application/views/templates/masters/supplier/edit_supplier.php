<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>仕入先 編集</h3>
    </div>

    <div class="first-row">
  
    <form class="form-horizontal" role="form"  id="supplier_form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">仕入先ID:</label>
                    <div class="col-md-8">
                        <input class="form-control " id="sup_id" disabled="true"  value="<?= $master[SUP_ID] ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">仕入先会社名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " id="sup_company_name" name="sup_company_name" value="<?= $master[SUP_SUPPLIER_COMPANY_NAME] ?>">
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">担当者名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " id="sup_contact_name" name="sup_contact_name" value="<?= $master[SUP_USER_ID] ?>">
                       <!--  <select class="form-control" id="sup_contact_name" name="sup_contact_name">
                            <option></option>
                            <?php
                             // foreach ($list_contact_user as $key => $value) {
                             //    echo '<option value="'.$value[U_ID].'" '.($value[U_ID]==$master[SUP_USER_ID]?'selected':'').' >'.$value[U_NAME].'</option>';
                             // }
                              ?>  
                        </select> -->
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">仕入先区分名 :<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <select class="form-control no-bottom-margin" id="sup_vendor_id" name="sup_vendor_id">
                           <option ></option>
                             <?php 
                             if(isset($list_sup_vendor)) {
                             foreach ($list_sup_vendor as $key => $value) {
                                echo '<option value="'.$value[TSC_ID].'" '.($value[TSC_ID]==$master[SUP_VENDOR_ID]?'selected':'').'>'.$value[TSC_NAME].'</option>';
                             } } ?>   
                        </select>  

                    
                    </div>
                </div>
            </div>
               <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">電話番号:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " id="sup_phone_number" name= "sup_phone_number" value="<?= $master[SUP_PHONE_NUMBER] ?>">
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">FAX番号:</label>
                    <div class="col-md-8">
                        <input class="form-control "  id="sup_fax_number" name="sup_fax_number" value="<?= $master[SUP_FAX_NUMBER] ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">郵便番号:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="sup_postal_code" name="sup_postal_code" value="<?= $master[SUP_POSTAL_CODE] ?>">
                    </div>
                </div>
            </div>
           
         
             
         <!--    <div class="clearfix"></div> -->
         
           
          
            <!-- <div class="clearfix"></div> -->
          
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所1:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " id="sup_address_1"  name="sup_address_1" value="<?= $master[SUP_ADDRESS_1] ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所2:</label>
                    <div class="col-md-8">
                        <input class="form-control "  id="sup_address_2" name="sup_address_2" value="<?= $master[SUP_ADDRESS_2] ?>" >
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">支払ｻｲﾄ :</label>
                    <div class="col-md-8">
                         <input class="form-control " id="sup_payment_site" name="sup_payment_site" value="<?= $master[SUP_PAYMENT_SITE] ?>">
                    </div>
                </div>
            </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">締日:</label>
                    <div class="col-md-8">
                         <span class="form-control form-control-input" style="margin-bottom:9px;">
                             <input class=" mydatepicker"  id="sup_closing_date" name="sup_closing_date" >
                             <span class=" icon-large icon-calendar "></span>
                         </span>
                    </div> 
                </div>
            </div>
            
            
        </div>
    </form>
    </div>
  
    
<div class="row third-row" style="text-align:center;">
        <a href="#dialog-form"  id="save_supplier" class="print save_supplier">保存</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
</div>
<script>
 var errorAjax      = "<?= $this->lang->line('message_error_ajax')?>";
 var editUrl        = "<?= site_url('/master/supplier/edit_supplier')?>";
 var master_id      = "<?= $master[SUP_ID]?>";
 var closing_date    = new Date("<?= $master[SUP_CLOSING_DATE] ?>");
 var message_confirm_save_field = "<?= $this->lang->line('message_confirm_save_field')?>";
 var urlIndex = "<?= base_url("master/supplier") ?>";
</script>