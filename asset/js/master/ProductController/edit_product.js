
$(document).on("change","input[name=optradio]",function(){
    $("#product_form :input").prop("disabled", false);
    if(typeProduct == 1) {
      $("#t_catalogue ").prop( "disabled", true );
      $("#t_type_order ").prop( "disabled", true );
      $("#t_catalogue ").css( "background-color", "#fff" );
      $("#t_type_order ").css( "background-color", "#fff" );

      var value_type_event = $("#t_catalogue option:selected").data("flg");
      var value_type_order = $("#t_type_order option:selected").val();

       if(value_type_event == 0) {
            if(value_type_order == 1 || value_type_order == "1") {
                  FuncDisableHideOrder("");
                } else {
                  FuncDisableTo("");
                }
      } else if(value_type_event == 1) { 
        FuncDisableGaichyu("");
      } else {
        FuncDisableFull("");
      }
    } else if(typeProduct == 2) {
        FuncDisable2("");
    } else if(typeProduct == 3) {
      FuncDisable3("");
    }
});

$(document).on("change","#t_type_order",function(){
      var value_type_product = $("input[name=optradio]:checked").val();
      if(value_type_product == 1) {
        var value_type = $("#t_catalogue option:selected").data("flg");
        var value_type_order = $("#t_type_order option:selected").val();
        $("#product_form :input").prop("disabled", false);
        destroyFieldTootip();
    
        if(value_type == 0) {
          if(value_type_order == 1 || value_type_order == "1") {
            FuncDisableHideOrder("");
          } else {
            FuncDisableTo("");
          }
          
        } else if(value_type == 1) {
          FuncDisableGaichyu("");
        } else {
          FuncDisableFull("");
        }
    
        resetValueFieldDisabled();
      }
    });


function FuncDisable1( ){
      //toan quyen enable
      var arrayKey = ['buy_product_id','sell_product_id','t_type_order'];
      disableField(arrayKey);
      
}
function FuncDisable2( ){
      var arrayKey = ['sell_product_id','buy_product_id','sell_product_name','catalogue','category',
      'product_type','container_upper_mouting_amount','product_number_package',
      'production_sumary_code','product_organization_pile','product_organization_weight',
      't_category','product_wash_classification','product_dry_press_laundry'];
      disableField(arrayKey);
}
//option 3: 洗剤等Bột giặc,…
function FuncDisable3( ){
      var arrayKey = ['buy_product_id','buy_product_name','product_standard_stock_number',
      'product_wash_classification','product_laundry_segment','product_dry_press_laundry',
      't_catalogue','t_category','product_organization_pile','product_organization_weight',
      'product_remark','product_remark_2','product_number_package','category',
      'container_upper_mouting_amount','t_type_order'];
      disableField(arrayKey);
}
function FuncDisableFull( ){
  var arrayKey = ['buy_product_id','buy_product_name','product_organization_pile',
  'product_organization_weight','t_category','product_standard_stock_number',
  'product_wash_classification','product_remark','product_remark_2',
  'product_wash_classification','sell_product_id','sell_product_name',
  'product_number_package','product_type','category','production_sumary_code',
  'container_upper_mouting_amount','product_color_tone','product_unit',
  'product_standard','product_laundry_segment','product_dry_press_laundry','t_type_order'];
  disableField(arrayKey);
}

// Hide order
function FuncDisableHideOrder( ){
      var arrayKey = [
      'sell_product_name','product_number_package','product_type',
        'category','production_sumary_code','container_upper_mouting_amount',
      'product_laundry_segment'
    ];
      disableField(arrayKey);
}

// To
function FuncDisableTo( ){
  var arrayKey = [
  'product_laundry_segment','sell_product_id','buy_product_id'
];
  disableField(arrayKey);
}

// Gaichyu
function FuncDisableGaichyu( ){
  var arrayKey = [
    'buy_product_id','buy_product_name',
  't_category','product_standard_stock_number',
  'product_wash_classification',
  'product_wash_classification',
  'product_number_package','product_type','category','production_sumary_code',
  'container_upper_mouting_amount','product_unit',
  'product_laundry_segment','product_dry_press_laundry','t_type_order'];
  disableField(arrayKey);
}
function disableField(arrKey){
      arrKey.forEach(function(item) {
        $("#"+item).prop( "disabled", true );
      });
}
function destroyFieldTootip(){
  $("#product_form select, input").each(function(){ 
          $(this).tooltip("destroy");
      });
}
$(document).ready(function(){
      $("input[type=radio]").attr('disabled', true);
      $('input:radio[name=optradio][value='+ typeProduct+ ']').change();
      $('.save_product').click(function(){
            if(raiseValidate() == false)
                  return false;
            var data = {id:master_id,meta:getMeta()};
            var url = editUrl;
            $('.save_product').helloWorld(message_confirm_save_field,urlIndex,null,{url:url,data:data,error_message:errorAjax});
            
      });


      function raiseValidate(){
            if($('#product_form').valid() && $('#product_form').data("validator")){
                  return true;
            }
            return false;
      }


      function getMeta(){
            var meta_data = {};
            //meta_data.product_id = $("#product_id").val();
            meta_data.catalogue                           = $("#catalogue").val();
            meta_data.category                              = $("#category").val();
            meta_data.product_name                          = $("#product_name").val();
            meta_data.product_color_tone                    = $("#product_color_tone").val();
            meta_data.product_standard                      = $("#product_standard").val();

            meta_data.product_organization_pile             = $("#product_organization_pile").val();
            meta_data.product_organization_weight           = $("#product_organization_weight").val();
            //meta_data.product_organization_cal              = $("#product_organization_cal").val();
            //meta_data.product_organization_date             = $("#product_organization_date").val();
            //meta_data.product_main_use                      = $("#product_main_use").val();

            meta_data.product_remark                        = $("#product_remark").val();
            meta_data.product_remark_2                      = $("#product_remark_2").val();
            meta_data.product_standard_stock_number         = $("#product_standard_stock_number").val();
            //meta_data.product_yurata_classification_for_sale= $("#product_yurata_classification_for_sale").val();
            meta_data.product_wash_classification           = $("#product_wash_classification").val();
            meta_data.product_laundry_segment               = $("#product_laundry_segment").val();

            meta_data.product_pl_categories                 =typeProduct;
            //meta_data.product_unit                          = $("#product_unit").val();
            meta_data.product_dry_press_laundry             = $("#product_dry_press_laundry").val();
            meta_data.container_upper_mouting_amount        = $("#container_upper_mouting_amount").val();
            meta_data.t_catalogue                           = $("#t_catalogue").val();

            meta_data.t_category                            = $("#t_category").val();
            meta_data.product_type                          = $("#product_type").val();
            //meta_data.use_sale                              = $("#use_sale").val();

            meta_data.sell_product_id                       = $("#sell_product_id").val();
            meta_data.buy_product_id                        = $("#buy_product_id").val();
            meta_data.sell_product_name                     = $("#sell_product_name").val();
            meta_data.buy_product_name                      = $("#buy_product_name").val();
            meta_data.production_sumary                     = $("#production_sumary_code").val();
            meta_data.tokyo_flag                            = $("#tokyo_flag").val();
            meta_data.product_number_package                = $("#product_number_package").val();
            meta_data.t_type_order                = $("#t_type_order").val();
    
            return meta_data;
      }

      

      
      $("#product_form").validate({
            rules : {
                  product_id:{
                        required:true,
                  },
                  product_name:{
                        required:true
                  },
                  catalogue:{
                        required:true
                  },
                  category:{
                        required:true
                  },
                  // product_standard_stock_number:{
                  //    required:true
                  // },
                  // product_yurata_classification_for_sale:{
                  //    required:true
                  // },
                  // product_wash_classification:{
                  //    required:true
                  // },
                  // product_pl_categories:{
                  //    required:true
                  // },
                  // container_upper_mouting_amount:{
                  //    required:true
                  // },
                  t_category:{
                        required:true
                  },
                  product_type:{
                        required:true
                  },
                  t_type_order:{
                        required:true
                  },
                  use_sale:{
                        required:true
                  },
                  sell_product_id:{
                        required:true
                  },
                  buy_product_id:{
                        required:true
                  },
                  sell_product_name:{
                        required:true
                  },
                  buy_product_name:{
                        required:true
                  },
                  t_catalogue:{
                        required:true
                  },
                  // production_sumary_code:{
                  //       required:true
                  // },
                  // tokyo_flag:{
                  //       required:true
                  // },
                  // category:{
                  //    required:true
                  // }
                    product_number_package:{
                      min: 1,
                      number: true
                    },
                    product_standard_stock_number:{
                     
                      number: true
                    },
                    container_upper_mouting_amount:{
                     
                      number: true
                    },
                    product_organization_weight:{
                        required:true,
                        min: 0,
                        number: true
                      },

            },
            tooltip_options: {  // <- totally invalid option
                    product_id: {
                        placement: 'bottom',html:true
                    },
                    product_name: {
                        placement: 'top'
                    },
                    catalogue: {
                        placement: 'right'
                  },
                    
                  category: {
                        placement: 'bottom'
                  },
                  t_type_order: {
                        placement: 'bottom'
                  },
                  // product_standard_stock_number: {
                  //    placement: 'right'
                  // },
                  // product_yurata_classification_for_sale: {
                  //    placement: 'top'
                  // },
                  // product_wash_classification: {
                  //    placement: 'top'
                  // },
                  // product_pl_categories: {
                  //    placement: 'top'
                  // },
                  // container_upper_mouting_amount: {
                  //    placement: 'left'
                  // }, 
                  product_organization_weight: {
                        placement: 'right'
                      },
                  t_category: {
                        placement: 'right'
                  },
                  product_type: {
                        placement: 'right'
                  },
                  use_sale: {
                        placement: 'left'
                  },
                  sell_product_id: {
                        placement: 'top'
                  },
                  buy_product_id: {
                        placement: 'top'
                  },
                  sell_product_name: {
                        placement: 'bottom'
                  },
                  buy_product_name: {
                        placement: 'bottom'
                  },
                  t_catalogue:{
                        placement: 'bottom'
                  },
                   product_number_package:{
                      placement: 'bottom'
                    },
                    product_standard_stock_number:{
                      placement: 'top'
                    },
                    container_upper_mouting_amount:{
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