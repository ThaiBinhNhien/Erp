// Ajax select
$(document).ready(function(){
    
    var classification_customer = $('select[name="list_set_product2[]"]').bootstrapDualListbox(config_duallistbox);
});

// On click
$(document).on("click","#valueSetCustomer", function(){
    FuncLoadCustomer();
}); 

// Function load customer
function FuncLoadCustomer(){
    var customer_code = $("#valueSetCustomer option:selected").val();

    if(customer_code != ''){
        $('#list_customer2').hide();
        $('#list_customer1').show();

        $('select[name="list_set_product[]"]').bootstrapDualListbox(config_duallistbox);
        
        // Check Ajax
        $.ajax({
            url:load_set_product_by_customer,
            data:{customer_code:customer_code},
            dataType:'json',
            method:'GET',
            success:function(result){
                $('#list_customer1 select option').prop('selected', false);
                if(result != null) {
                    for(var i=0; i<result.length; i++){
                        $('#list_customer1 select option[value="'+result[i]['set_product']+'"]').prop('selected', true);
                    }
                }
                $('select[name="list_set_product[]"]').bootstrapDualListbox('refresh', true);
            }
        });

    }
}

// Click to save
$(document).on("click","#onClickToSave", function(){
    // Setting validation
    $("#box-form").validate();

    $('#valueSetCustomer').rules('add', { required: true });

    $('#valueSetCustomer').tooltip({
        trigger: 'manual',
        placement:'top'
    });

    //Show loading display here
    var form = $("#box-form");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var customer_code = $("#valueSetCustomer option:selected").val();
    var set_product = $('select[name="list_set_product[]"]').val();

    // Ajax Add
    $(this).helloWorld(message_confirm_save_field ,urlIndex,null,
        {
            url:add_customer_setproduct_base,
            data:{customer_code:customer_code,set_product:set_product},
            error_message:message_error_ajax,
            is_master: true
        }
    );
});