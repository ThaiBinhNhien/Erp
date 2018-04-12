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
        }
    }); 

    $('#form_username').rules('add', VALID_USER_USERNAME);
    $('#form_user_name').rules('add', VALID_USER_NAME);
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
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Ajax Edit
    $(this).helloWorld(message_confirm_save_field ,urlIndex,null,
        {
            url:editPostMasterUser,
            data:form.serialize(),
            error_message:message_error_ajax,
            is_master: true
        }
    );

});