 // Add 
$(document).on("click","#btnSave", function(){

    // Setting validation
    $("#box-form").validate({
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - 50
            }, 800);
        }
    });

    $('#BM_BASE_NAME').rules('add', VALID_BASE_BM_BASE_NAME);
    $('#BM_BASE_CODE').rules('add', VALIDATION_ID);
    $('#BM_COMPANY_NAME').rules('add', VALID_BASE_BM_COMPANY_NAME);
    $('#BM_PAYEE_1_BANK_NAME').rules('add', VALID_BASE_BM_PAYEE_1_BANK_NAME); 
    $('#BM_PAYEE_1_BRANCH_NAME').rules('add', VALID_BASE_BM_PAYEE_1_BRANCH_NAME);
    $('#BM_PAYEE_1__ACCOUNT_NUMBER').rules('add', VALID_BASE_BM_PAYEE_1__ACCOUNT_NUMBER);
    $('#BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION').rules('add', VALID_BASE_BM_TRANSFER_DESTINATION_ACCOUNT_CLASSIFICATION);
    $('#BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION').rules('add', VALID_BASE_BM_TRANSFER_DESTINATION_ACCOUNT_CLASSIFICATION);
    $('#BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION').rules('add', VALID_BASE_BM_TRANSFER_DESTINATION_ACCOUNT_CLASSIFICATION);
    
    $('#BM_POSTAL_CODE').rules('add', VALID_BASE_BM_NAME_MAXLENGTH20);
    $('#BM_PREFECTURES').rules('add', VALID_BASE_BM_NAME_MAXLENGTH20);
    $('#BM_TRANSFER_DESTINATION_2_BANK_NAME').rules('add', VALID_BASE_BM_NAME_MAXLENGTH20);
    $('#BM_TRANSFER_DESTINATION_3_BANK_NAME').rules('add', VALID_BASE_BM_NAME_MAXLENGTH20);
    $('#BM_BANK_TRANSFER_2_BRANCH_NAME').rules('add', VALID_BASE_BM_NAME_MAXLENGTH20);
    $('#BM_PAYEE_3_BRANCH_NAME').rules('add', VALID_BASE_BM_NAME_MAXLENGTH20);

    $('#BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER').rules('add', VALID_BASE_BM_NAME_MAXLENGTH7);
    $('#BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER').rules('add', VALID_BASE_BM_NAME_MAXLENGTH7);

    //phone
    $('#BM_PHONE_NUMBER').rules('add', VALID_BASE_BM_PHONE_NUMBER);
    //fax
    $('#BM_FAX_NUMBER').rules('add', VALID_BASE_BM_FAX_NUMBER);

    $('#BM_BASE_CODE').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#BM_BASE_NAME').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#BM_COMPANY_NAME').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#BM_PAYEE_1_BANK_NAME').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#BM_PAYEE_1_BRANCH_NAME').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#BM_PAYEE_1__ACCOUNT_NUMBER').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#BM_PHONE_NUMBER').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#BM_FAX_NUMBER').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    //Show loading display here
    var form = $("#box-form");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    var BM_MASTER_CHECK = false;
    if ($('#BM_MASTER_CHECK').is(":checked"))
    {
        BM_MASTER_CHECK = true;
    }

    // Add
    var data_post = [];
    data_post.push({
        "BM_BASE_CODE":$("#BM_BASE_CODE").val(),
        "BM_BASE_NAME":$("#BM_BASE_NAME").val(),
        "BM_COMPANY_NAME":$("#BM_COMPANY_NAME").val(),
        "BM_POSTAL_CODE":$("#BM_POSTAL_CODE").val(),
        "BM_PREFECTURES":$("#BM_PREFECTURES").val(),
        "BM_ADDRESS_1":$("#BM_ADDRESS_1").val(),
        "BM_ADDRESS_2":$("#BM_ADDRESS_2").val(),
        "BM_PHONE_NUMBER":$("#BM_PHONE_NUMBER").val(),
        "BM_FAX_NUMBER":$("#BM_FAX_NUMBER").val(),
        "BM_PAYEE_1_BANK_NAME":$("#BM_PAYEE_1_BANK_NAME").val(),
        "BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH":$("#BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH").val(),
        "BM_PAYEE_1_BRANCH_NAME":$("#BM_PAYEE_1_BRANCH_NAME").val(),
        "BM_PAYEE_1__BRANCH_NAME__ENGLISH":$("#BM_PAYEE_1__BRANCH_NAME__ENGLISH").val(),
        "BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION":$("#BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION").val(),
        "BM_PAYEE_1__ACCOUNT_NUMBER":$("#BM_PAYEE_1__ACCOUNT_NUMBER").val(),
        "BM_TRANSFER_DESTINATION_2_BANK_NAME":$("#BM_TRANSFER_DESTINATION_2_BANK_NAME").val(),
        "BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH":$("#BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH").val(),
        "BM_BANK_TRANSFER_2_BRANCH_NAME":$("#BM_BANK_TRANSFER_2_BRANCH_NAME").val(),
        "BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH":$("#BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH").val(),
        "BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION":$("#BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION").val(),
        "BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER":$("#BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER").val(),
        "BM_TRANSFER_DESTINATION_3_BANK_NAME":$("#BM_TRANSFER_DESTINATION_3_BANK_NAME").val(),
        "BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH":$("#BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH").val(),
        "BM_PAYEE_3_BRANCH_NAME":$("#BM_PAYEE_3_BRANCH_NAME").val(),
        "BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH":$("#BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH").val(),
        "BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION":$("#BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION").val(),
        "BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER":$("#BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER").val(),
        "BM_MASTER_CHECK":BM_MASTER_CHECK,
    });

    // Ajax Add
    $(this).helloWorld(message_confirm_save_field ,urlIndex,null,
        {
            url:addBaseMaster,
            data:{data_post:data_post},
            error_message:message_error_ajax,
            is_master: true
        }
    );
});