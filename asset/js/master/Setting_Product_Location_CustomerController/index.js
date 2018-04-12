// Ajax select
$(document).ready(function(){
    
    var classification_customer = $('select[name="list_customer2[]"]').bootstrapDualListbox(config_duallistbox);
});

// On click
$(document).on("click","#valueSetProduct", function(){
    FuncLoadCustomer();
});

$(document).on("click","#valueSetBase", function(){
    FuncLoadCustomer();
});

// Function load customer
function FuncLoadCustomer(){
    var set_product = $("#valueSetProduct option:selected").val();
    var base_code = $("#valueSetBase option:selected").val();

    if(set_product != '' && base_code != ''){
        $('#list_customer2').hide();
        $('#list_customer1').show();

        $('select[name="list_customer[]"]').bootstrapDualListbox(config_duallistbox);

        // Check Ajax
        $.ajax({
            url:load_customer_by_set_product_base,
            data:{set_product:set_product,base_code:base_code},
            dataType:'json',
            method:'GET',
            success:function(result){
                $('#list_customer1 select option').prop('selected', false);
                for(var i=0; i<result.length; i++){
                    $('#list_customer1 select option[value="'+result[i]['customer_code']+'"]').prop('selected', true);
				}
                $('select[name="list_customer[]"]').bootstrapDualListbox('refresh', true);
            }
        });

    }
}

// Click to save
$(document).on("click","#onClickToSave", function(){
    // Setting validation
    $("#box-form").validate();

    $('#valueSetProduct').rules('add', { required: true });
    $('#valueSetBase').rules('add', { required: true });

    $('#valueSetProduct').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('#valueSetBase').tooltip({
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
    var set_product = $("#valueSetProduct option:selected").val();
    var base_code = $("#valueSetBase option:selected").val();
    var list_customer = $('select[name="list_customer[]"]').val();

    // Ajax Add
    $(this).helloWorld(message_confirm_save_field ,urlIndex,null,
        {
            url:add_customer_setproduct_base,
            data:{set_product:set_product,base_code:base_code,list_customer:list_customer},
            error_message:message_error_ajax,
            is_master: true
        }
    );
});