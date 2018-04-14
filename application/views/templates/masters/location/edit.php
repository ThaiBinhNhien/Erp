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
        <h3><?php echo $title; ?></h3>
    </div>

	<div class="first-row">
  <?php if(isset($data_meta) && isset($data_meta[0])) { ?>
    <form class="form-horizontal" role="form" id="box-form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">拠点コード:</label>
                    <div class="col-md-7">
                         <input class="form-control" id="BM_BASE_CODE" name="BM_BASE_CODE" value="<?php echo $data_meta[0][BM_BASE_CODE]; ?>" disabled >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">拠点名:<span class="label-form-request">*</span></label>
                    <div class="col-md-7">
                         <input class="form-control" id="BM_BASE_NAME" name="BM_BASE_NAME" value="<?php echo $data_meta[0][BM_BASE_NAME]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">会社名:<span class="label-form-request">*</span></label>
                    <div class="col-md-7">
                        <input class="form-control"  id="BM_COMPANY_NAME" name="BM_COMPANY_NAME" value="<?php echo $data_meta[0][BM_COMPANY_NAME]; ?>" >
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">郵便番号:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="BM_POSTAL_CODE" name="BM_POSTAL_CODE" value="<?php echo $data_meta[0][BM_POSTAL_CODE]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">都道府県:</label>
                    <div class="col-md-7">
                          <input class="form-control " id="BM_PREFECTURES" name="BM_PREFECTURES" value="<?php echo $data_meta[0][BM_PREFECTURES]; ?>" >
                    </div>
                </div>
            </div>
            
           
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">住所1:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_ADDRESS_1" name="BM_ADDRESS_1" value="<?php echo $data_meta[0][BM_ADDRESS_1]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">住所2 :</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_ADDRESS_2" name="BM_ADDRESS_2" value="<?php echo $data_meta[0][BM_ADDRESS_2]; ?>" >
                    </div>
                </div>
            </div>
            <!-- <div class="clearfix visible-lg-block visible-md-block"></div> -->
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">電話番号:</label>
                    <div class="col-md-7">
                         <input class="form-control " id="BM_PHONE_NUMBER" name="BM_PHONE_NUMBER" value="<?php echo $data_meta[0][BM_PHONE_NUMBER]; ?>" >
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">FAX番号:</label>
                    <div class="col-md-7">
                         <input class="form-control " id="BM_FAX_NUMBER" name="BM_FAX_NUMBER" value="<?php echo $data_meta[0][BM_FAX_NUMBER]; ?>" >
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 10px;margin-top: -5px;">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">外注先:</label>
                    <div class="col-md-7">
                    <div class="checkbox text-left">
                    <?php 
                    $check_gaichyu = "";
                    if($data_meta[0][BM_MASTER_CHECK] == 1 || $data_meta[0][BM_MASTER_CHECK] == "1") {
                         $check_gaichyu = "checked";
                    } else {
                        $check_gaichyu = "";
                    } ?>
                        <input type="checkbox" <?= $check_gaichyu; ?>  id="BM_MASTER_CHECK" name="BM_MASTER_CHECK" style="margin-left: 0;
                            padding-left: 0;
                            left: 0;
                            text-align: left;
                            width: 20px;
                            height: 20px;
                            margin-top: 0;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先１＿口座区分:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION" name="BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION" value="<?php echo $data_meta[0][BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION]; ?>" >
                    </div>
                </div>
            </div>
    
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先２＿口座区分:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION" name="BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION" value="<?php echo $data_meta[0][BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION]; ?>"  >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先３＿口座区分:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION" name="BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION" value="<?php echo $data_meta[0][BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先１＿銀行名:<span class="label-form-request">*</span></label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_PAYEE_1_BANK_NAME" name="BM_PAYEE_1_BANK_NAME" value="<?php echo $data_meta[0][BM_PAYEE_1_BANK_NAME]; ?>" >
                    </div>
                </div>
            </div>
   
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先２＿銀行名:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_TRANSFER_DESTINATION_2_BANK_NAME" name="BM_TRANSFER_DESTINATION_2_BANK_NAME" value="<?php echo $data_meta[0][BM_TRANSFER_DESTINATION_2_BANK_NAME]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先３＿銀行名:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_TRANSFER_DESTINATION_3_BANK_NAME" name="BM_TRANSFER_DESTINATION_3_BANK_NAME" value="<?php echo $data_meta[0][BM_TRANSFER_DESTINATION_3_BANK_NAME]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先１＿銀行名＿英語:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH" name="BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH" value="<?php echo $data_meta[0][BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH]; ?>" >
                    </div>
                </div>
            </div>
    
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先２＿銀行名＿英語:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH" name="BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH" value="<?php echo $data_meta[0][BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先３＿銀行名＿英語:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH" name="BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH" value="<?php echo $data_meta[0][BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先１＿支店名:<span class="label-form-request">*</span></label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_PAYEE_1_BRANCH_NAME" name="BM_PAYEE_1_BRANCH_NAME" value="<?php echo $data_meta[0][BM_PAYEE_1_BRANCH_NAME]; ?>" >
                    </div>
                </div>
            </div>
    
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先２＿支店名:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_BANK_TRANSFER_2_BRANCH_NAME" name="BM_BANK_TRANSFER_2_BRANCH_NAME" value="<?php echo $data_meta[0][BM_BANK_TRANSFER_2_BRANCH_NAME]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先３＿支店名:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_PAYEE_3_BRANCH_NAME" name="BM_PAYEE_3_BRANCH_NAME" value="<?php echo $data_meta[0][BM_PAYEE_3_BRANCH_NAME]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先１＿支店名＿英語:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_PAYEE_1__BRANCH_NAME__ENGLISH" name="BM_PAYEE_1__BRANCH_NAME__ENGLISH" value="<?php echo $data_meta[0][BM_PAYEE_1__BRANCH_NAME__ENGLISH]; ?>" >
                    </div>
                </div>
            </div>
    
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先２＿支店名＿英語:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH" name="BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH" value="<?php echo $data_meta[0][BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先３＿支店名＿英語:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH" name="BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH" value="<?php echo $data_meta[0][BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先１＿口座番号:<span class="label-form-request">*</span></label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_PAYEE_1__ACCOUNT_NUMBER" name="BM_PAYEE_1__ACCOUNT_NUMBER" value="<?php echo $data_meta[0][BM_PAYEE_1__ACCOUNT_NUMBER]; ?>" >
                    </div>
                </div>
            </div>
    
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先２＿口座番号:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER" name="BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER" value="<?php echo $data_meta[0][BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER]; ?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-5 control-label">振込先３＿口座番号:</label>
                    <div class="col-md-7">
                        <input class="form-control " id="BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER" name="BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER" value="<?php echo $data_meta[0][BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER]; ?>" >
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div> 

    </form>
  <?php } ?>
	</div>
    
   
    <div class="clearfix"></div>
     <div class="row third-row" style="text-align:center;">
        <a id="btnSave" class="print">保存</a>
    </div>
	
</div>

<script>
    var editBaseMaster = "<?= base_url("master/location/edit_post") ?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var urlIndex = "<?= base_url("master/location") ?>";
    var id_location = "<?= $this->input->get("id"); ?>";
</script>
