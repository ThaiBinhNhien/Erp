// Ajax select
$(document).ready(function() {
    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });
  });

// Add 
$(document).on("click","#onClickAdd", function(){

    // Setting validation
    $("#form_add_user").validate({ 
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - 50
            }, 800);

            /*setTimeout(function(){
                console.log(validator.errorList);
                if (validator.errorList.length > 0) {
                    for (var x=0;x<validator.errorList.length;x++) {
                        $('#'+validator.errorList[x].element.id).parent().find(".tooltip").hide();
                    }
                }
            }, 2000);*/
            
        }
    });

    $('#form_username').rules('add', VALID_USER_USERNAME);
    $('#form_user_name').rules('add', VALID_USER_NAME);
    $('#form_pass').rules('add', VALID_USER_PASS);
    $('#form_pass_confirm').rules('add', VALID_USER_PASSCONFIRM);
    $('#form_base').rules('add', VALID_USER_BASE);
    $('#form_user_phone').rules('add', VALID_USER_TEL);
    $('#form_user_tel').rules('add', VALID_USER_TEL);

    $('#form_username').tooltip({
        trigger: 'manual',
        placement:'top' 
    });
    $('#form_user_name').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#form_base').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#form_pass').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#form_pass_confirm').tooltip({
        trigger: 'manual',
        placement:'right'
    });
    $('#form_user_phone').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#form_user_tel').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    //Show loading display here
    var form = $("#form_add_user");

    // Validation
    setTimeout(function () {
        $('[data-toggle="tooltip"]').tooltip('destroy');
    }, 3000)

    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Ajax Add
    $(this).helloWorld(message_confirm_save_field ,urlIndex,null,
        {
            url:addPostMasterUser,
            data:form.serialize(),
            error_message:message_error_ajax,
            is_master: true
        }
    );

});