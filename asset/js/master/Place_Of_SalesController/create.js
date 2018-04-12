
$(document).ready(function(){

      $('.save-new-plase-sale').click(function(){
            if(raiseValidate() == false)
                  return false;
            var data = {meta:getMeta()};
            var url = createUrl ;
            $('.save-new-plase-sale').helloWorld(message_confirm_save_field ,urlIndex,null,{url:url,data:data,error_message:errorAjax});
            
      })


      function raiseValidate(){
            if($('#place_sale_form').valid() && $('#place_sale_form').data("validator")){
                  return true;
            }
            return false;
      }

      function getMeta(){
            var meta_data = {};
            meta_data.distributor_id = $("#distributor_id").val();
            meta_data.distributor_name = $("#distributor_name").val();
            meta_data.fax_number = $("#fax_number").val();
            meta_data.postal_code = $("#postal_code").val();
            meta_data.phone_number   = $("#phone_number").val();
            meta_data.address_1      = $("#address_1").val();
            meta_data.address_2      = $("#address_2").val();
            meta_data.user_id        = $("#user_id").val();
            meta_data.outsourcing    = $("#outsourcing").val();
            
            return meta_data;
      }

      $("#place_sale_form").validate({
            rules : {
                  distributor_name:{
                        required:true,
                  },
                  outsourcing:{
                        required:true,
                  },
                  user_id:{
                        required:true,
                  },
                  address_1:{
                        required:true,
                  },
                  phone_number:{
                      required:true,
                      isPhoneNumber: true
                  },
                  distributor_id:VALIDATION_ID,
                  postal_code:{
                        isPostal: true
                  },
                  fax_number:{
                    isPhoneNumber: true
                  },
                  
                  
                  
                  
                  // category:{
                  //    required:true
                  // }

            },
            tooltip_options: {  // <- totally invalid option
                  distributor_name: {
                      placement: 'top',html:true
                  },
                  outsourcing:{
                         placement: 'bottom'
                  },
                  user_id:{
                         placement: 'top'
                  },
                  address_1:{
                         placement: 'right'
                  },
                  phone_number:{
                         placement: 'bottom',

                  },
                  distributor_id:{
                         placement: 'top',
                  },
                  fax_number:{
                         placement: 'bottom',
                  },
                  
                  
                    // sup_phone_number: {
                    //     placement: 'top'
                    // },
                },
                invalidHandler: function(form, validator) {
                  if (!validator.numberOfInvalids())
                        return;

                  $('html, body').animate({
                        scrollTop: $(validator.errorList[0].element).offset().top - 50
                  }, 800);
            }
    });

})
