// Ajax select
$(document).ready(function(){
    var classification_customer = $('select[name="duallistbox_classification_customer[]"]').bootstrapDualListbox(config_duallistbox);
    var classification_base = $('select[name="duallistbox_classification_base[]"]').bootstrapDualListbox(config_duallistbox);
});

// Add 
$(document).on("click","#onClickEdit", function(){

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

    $('#form_number_truck').rules('add', VALID_SM_COURIER_TRUCK);

    $('#form_number_container').rules('add', VALID_SM_COURIER_CONTAINER);

    $('#form_number_max_truck').rules('add', VALID_SM_COURIER_MAX_TRUCK);

    $('#form_name').rules('add', VALID_SM_COURIER_NAME);

    $('#form_name').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('#form_number_max_truck').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#form_number_container').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('#form_number_truck').tooltip({
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

    // Add
    var name = $("#form_name").val();
    var number_container = $("#form_number_container").val();
    var number_truck = $("#form_number_truck").val();
    var number_max_truck = $("#form_number_max_truck").val();
    var classification_customer = $('select[name="duallistbox_classification_customer[]"]').val();
    var classification_base = $('select[name="duallistbox_classification_base[]"]').val();

    // Ajax Edit
    $(this).helloWorld(message_confirm_save_field ,urlIndex,null,
        {
            url:editListClassifition,
            data:{classification_id:classification_id,name:name,number_container:number_container,number_truck:number_truck,number_max_truck:number_max_truck,classification_customer:classification_customer,classification_base:classification_base},
            error_message:message_error_ajax,
            is_master: true
        }
    );
});