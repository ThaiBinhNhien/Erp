
$(document).ready(function(){

	$('.save-new-product').click(function(){
		if(raiseValidate() == false)
			return false;
		var data = {meta:getMeta()};
		var url = createUrl;
		$('.save-new-product').helloWorld('商品マスターを保存します。よろしいですか？',urlIndex,null,{url:url,data:data,error_message:errorAjax});
		
	})


	function raiseValidate(){
		if($('#product_form').valid() && $('#product_form').data("validator")){
			return true;
		}
		return false;
	}


	function getMeta(){
		var meta_data = {};
		//meta_data.product_id = $("#product_id").val();
		meta_data.catalogue 						= $("#catalogue").val();
		meta_data.category 							= $("#category").val();
		meta_data.product_name 						= $("#product_name").val();
		meta_data.product_color_tone 				= $("#product_color_tone").val();
		meta_data.product_standard 					= $("#product_standard").val();

		meta_data.product_organization_pile 		= $("#product_organization_pile").val();
		meta_data.product_organization_weight		= $("#product_organization_weight").val();
		meta_data.product_organization_cal		    = $("#product_organization_cal").val();
		meta_data.product_organization_date			= $("#product_organization_date").val();
		meta_data.product_main_use 					= $("#product_main_use").val();

		meta_data.product_remark 					= $("#product_remark").val();
		meta_data.product_standard_stock_number 	= $("#product_standard_stock_number").val();
		meta_data.product_yurata_classification_for_sale = $("#product_yurata_classification_for_sale").val();
		meta_data.product_wash_classification		= $("#product_wash_classification").val();
		meta_data.product_laundry_segment			= $("#product_laundry_segment").val();

		meta_data.product_pl_categories 			= $("#product_pl_categories").val();	
		meta_data.product_unit 						= $("#product_unit").val();
		meta_data.product_dry_press_laundry			= $("#product_dry_press_laundry").val();
		meta_data.container_upper_mouting_amount	= $("#container_upper_mouting_amount").val();
		meta_data.t_catalogue						= $("#t_catalogue").val();

		meta_data.t_category						= $("#t_category").val();
		meta_data.product_type						= $("#product_type").val();

		return meta_data;
	}

	

	$("#product_form").validate({
            rules : {
            	product_id:VALIDATION_ID,
            	product_name:{
            		required:true
            	},
            	// category:{
            	// 	required:true
            	// }

            },
            tooltip_options: {  // <- totally invalid option
		        product_id: {
		            placement: 'bottom',html:true
		        },
		        product_name: {
		            placement: 'top'
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