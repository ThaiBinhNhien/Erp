
$(document).ready(function(){

	$('.closing_date').datepicker({
		changeMonth: true,
        changeYear: true,
        dateFormat: 'yy年mm月dd日 (DD)',
        dayNames: ['日', '月', '火', '水', '水', '金', '土'],
        minDate: 'today',
    }).attr('readonly','readonly');
    $('.closing_date').datepicker('setDate', 'today');

	$('.save-new-supplier').click(function(){

		if(raiseValidate() == false)
			return false;
		var data = {meta:getMeta()};
		var url = createUrl ;
       $('.save-new-supplier').helloWorld(message_confirm_save_field ,urlIndex ,null,{url:url,data:data,error_message:errorAjax});
	})


	function raiseValidate(){
		if($('#supplier_form').valid() && $('#supplier_form').data("validator")){
			return true;
		}
		return false;
	}


	function getMeta(){
		var meta_data = {};

		meta_data.sup_id 			 = $("#sup_id").val();
		meta_data.sup_company_name 	 = $("#sup_company_name").val();
		meta_data.sup_phone_number 	 = $("#sup_phone_number").val();
		meta_data.sup_contact_name 	 = $("#sup_contact_name").val();
		meta_data.sup_fax_number 	 = $("#sup_fax_number").val();
		meta_data.sup_address_1 	 = $("#sup_address_1").val();
		meta_data.sup_address_2 	 = $("#sup_address_2").val();
		meta_data.sup_postal_code 	 = $("#sup_postal_code").val();
		meta_data.sup_vendor_id 	 = $("#sup_vendor_id").val();
		meta_data.sup_closing_date = $.datepicker.formatDate("yy-mm-dd", $("#sup_closing_date").datepicker('getDate'));
		meta_data.sup_payment_site 	 = $("#sup_payment_site").val();
		
		return meta_data;
	}
	
	$("#supplier_form").validate({
            rules : {
            	sup_id:VALIDATION_ID,
            	sup_company_name:{
            		required:true,
            	},
            	sup_contact_name:{
            		required:true
            	},
            	sup_address_1:{
            		required:true
            	},
            	sup_phone_number:{
            		required:true,
            		isPhoneNumber: true
            	},
            	sup_vendor_id:{
            		required: true
            	},
            	sup_fax_number:{
            		isPhoneNumber: true
            	},
            	sup_postal_code:{
            		isPostal: true
            	},
            	
            },
            tooltip_options: {  // <- totally invalid option
            	sup_id:{
            		placement: 'top'
            	},
		        sup_company_name: {
		            placement: 'top',html:true
		        },
		        sup_contact_name:{
            		placement: 'right'
            	},
            	sup_address_1:{
            		placement: 'right'
            	},
            	sup_phone_number:{
            		placement: 'bottom'
            	},
            	sup_vendor_id:{
            		placement: 'bottom'
            	},
            	sup_fax_number:{
            		placement: 'bottom'
            	},
            	
            	sup_postal_code:{
            		placement: 'bottom'
            	},
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

