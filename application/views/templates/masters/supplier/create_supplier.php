<style>
img{
    height:22px;

}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>仕入先 ・新規作成</h3>
    </div>

    <div class="first-row">
  
    <form class="form-horizontal" role="form"  id="supplier_form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">仕入先ID:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " name="sup_id" id="sup_id" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">仕入先会社名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " id="sup_company_name" name="sup_company_name">
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label ">担当者名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " id="sup_contact_name" name="sup_contact_name" >
                      <!--  <select class="form-control" id="sup_contact_name" name="sup_contact_name">
                            <option></option>
                            <?php 
                            // foreach ($list_contact_user as $key => $value) {
                            //     echo '<option value="'.$value[U_ID].'">'.$value[U_NAME].'</option>';
                            //  }
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
                                echo '<option value="'.$value[TSC_ID].'">'.$value[TSC_NAME].'</option>';
                             } } ?>   
                        </select>  
                       <!--  <input type="text" class="form-control" id="sup_vendor_id" name="sup_vendor_id"> -->
                    </div>
                </div>
            </div>
           

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">電話番号:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " id="sup_phone_number" name= "sup_phone_number" >
                    </div>
                </div>
            </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label ">FAX番号:</label>
                    <div class="col-md-8">
                        <input class="form-control "  id="sup_fax_number" name="sup_fax_number">
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">郵便番号:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="sup_postal_code" name="sup_postal_code">
                    </div>
                </div>
            </div>
           
            
         <!--    <div class="clearfix"></div> -->
           
           

              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所1:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " id="sup_address_1"  name="sup_address_1" >
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所2:</label>
                    <div class="col-md-8">
                        <input class="form-control "  id="sup_address_2" name="sup_address_2" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">支払ｻｲﾄ :</label>
                    <div class="col-md-8">
                         <input class="form-control " id="sup_payment_site" name="sup_payment_site">
                    </div>
                </div>
            </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label ">締日:</label>
                    <div class="col-md-8">
                         <span class="form-control form-control-input" style="margin-bottom:9px;">
                             <input class=" closing_date"  id="sup_closing_date" name="sup_closing_date" >
                             <span class=" icon-large icon-calendar "></span>
                         </span>
                    </div>
                </div>
            </div>
           
            
            
            <!-- <div class="clearfix"></div> -->
        </div>
    </form>
    </div>
  
    
<div class="row third-row" style="text-align:center;">
        <a href="#dialog-form" class="print save-new-supplier">保存</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
</div>
<script>
 var createUrl =   "<?= site_url('/master/supplier/create_supplier')?>";
 var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
 var message_confirm_save_field = "<?= $this->lang->line('message_confirm_save_field')?>";
 var urlIndex = "<?= base_url("master/supplier") ?>";
</script>

