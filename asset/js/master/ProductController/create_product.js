$(document).ready(function(){
  funGetListEventBuy(1);
  FuncDisableTo("");
});
 
 var typeProduct = 1;
$(document).on("change","input[name=optradio]",function(){
    var value_type = $(this).val();
    typeProduct = value_type;
    $("#product_form :input").prop("disabled", false);
    resetValueField();
    destroyFieldTootip();
    if(value_type == 1) {
      FuncDisableTo("");
      $("#t_type_order").val(2);
    } else if(value_type == 2) {
        FuncDisable2("");
    } else if(value_type == 3) { 
        FuncDisable3("");
    }

    funGetListEventBuy(value_type);
});

$(document).on("change","#t_catalogue",function(){
  var value_type_product = $("input[name=optradio]:checked").val();
  if(value_type_product == 1) {
    var value_type = $(this).find("option:selected").data("flg");
    $("#product_form :input").prop("disabled", false);
    destroyFieldTootip();
  
    if(value_type == 0) {
      FuncDisableTo("");
    } else if(value_type == 1) {
      FuncDisableGaichyu("");
    } else {
      FuncDisableFull("");
    }

    resetValueFieldDisabled();
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

function funGetListEventBuy(value_type){
  // EVENT
  $.ajax({
    url:get_infor_event_buy,
    data:{type:value_type},
    dataType:'json',
    method:'GET',
    success:function(result){
        if(result != null) {
            var option = '<option value=""></option>';
            var selected ="";
          if(result != null){
            for(var i=0;i<result.length;i++){
              if(result[i]['flg_outsource'] == 0 && result[i]['type'] == 1){
                selected ="selected";
              }
              option += '<option '+selected+' value="'+result[i]['id']+'" data-flg="'+result[i]['flg_outsource']+'">'+result[i]['name']+'</option>';
            }
          }
            $("#t_catalogue").html(option);
        }
      }
  });
}

//
function FuncDisable1( ){ 
      //toan quyen enable
      //resetValueField();
    //resetValueField
}
function FuncDisable2( ){
      var arrayKey = ['sell_product_id','sell_product_name','catalogue','category',
      'product_type','container_upper_mouting_amount','product_number_package',
      'production_sumary_code','product_organization_pile','product_organization_weight',
      't_category','product_wash_classification','product_dry_press_laundry','t_type_order'];
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
  'product_laundry_segment'
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
      var flagBuy =0;
      var flagSell =0;
      arrKey.forEach(function(item) {
        //check  disable random key 
        if(item == "buy_product_id" ){
          $( ".btnRandomKeyBuy" ).addClass( "randomkey" );
          flagBuy = 1;
        }
        if(item == "sell_product_id" ){
          $( ".btnRandomKeySale" ).addClass( "randomkey" );
          flagSell = 1;
        }
        $("#"+item).prop( "disabled", true );
      });
      if(flagBuy == 1){
        $( ".btnRandomKeyBuy" ).removeClass( "randomkey" );
      }
      if(flagSell ==1){
        $( ".btnRandomKeySale" ).removeClass( "randomkey" );
      }
}
function destroyFieldTootip(){
  $("#product_form select, input").each(function(){
          $(this).tooltip("destroy");
      });
}
function resetValueField(){
    $("#product_form input" ).val("");
    $("#product_form select" ).val("");
}
function resetValueFieldDisabled(){
  $("#product_form input:disabled" ).val("");
  $("#product_form select:disabled" ).val("");
}

$(document).ready(function(){
 
  $('.save-new-product').click(function(){
    
    if(raiseValidate() == false)
      return false;
    var data = {meta:getMeta()};
    var url = createUrl ;
    $('.save-new-product').helloWorld(message_confirm_save_field ,urlIndex,null,{url:url,data:data,error_message:errorAjax});
    //$("#save").helloWorld(message_confirm_save_field ,null,null,{url:createUrl,data:data,error_message:'',success_callback_function:"add_record"});
  })
  $('.btnRandomKeyBuy').click(function(){
      //key =1000;
      var isDisabled = $('#buy_product_id').prop('disabled');
      if(isDisabled == true) {
        return false;
      }
        $.ajax({
        url:get_key_random,
        data:{type:1},
        dataType:'json',
        method:'GET',
        success:function(result){
            if(result != null) {
              $('#buy_product_id').val(result); 
            }
          }
      });
  })
 $('.btnRandomKeySale').click(function(){     
    var isDisabled = $('#sell_product_id').prop('disabled');
    if(isDisabled == true) {
      return false;
    }
        $.ajax({
        url:get_key_random,
        data:{type:2},
        dataType:'json',
        method:'GET',
        success:function(result){
            if(result != null) {
              $('#sell_product_id').val(result); 
            }
          }
      });
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
    //meta_data.catalogue           = $("#catalogue").val();
    meta_data.category          = $("#category").val();
    meta_data.product_name          = $("#product_name").val();
    meta_data.product_color_tone        = $("#product_color_tone").val();
    meta_data.product_standard        = $("#product_standard").val();

    meta_data.product_organization_pile     = $("#product_organization_pile").val();
    meta_data.product_organization_weight   = $("#product_organization_weight").val();
    //meta_data.product_organization_cal          = $("#product_organization_cal").val();
    //meta_data.product_organization_date     = $("#product_organization_date").val();
    //meta_data.produ
    ct_main_use        = $("#product_main_use").val();
            
    meta_data.product_remark        = $("#product_remark").val();
    meta_data.product_remark_2        = $("#product_remark_2").val();
    meta_data.product_standard_stock_number         = $("#product_standard_stock_number").val();
    //meta_data.product_yurata_classification_for_sale= $("#product_yurata_classification_for_sale").val();
    meta_data.product_wash_classification   = $("#product_wash_classification").val();
    meta_data.product_laundry_segment     = $("#product_laundry_segment").val();

    //meta_data.product_pl_categories       = $("#product_pl_categories").val();  
            meta_data.product_pl_categories                 =typeProduct;
    //meta_data.product_unit          = $("#product_unit").val();
    meta_data.product_dry_press_laundry     = $("#product_dry_press_laundry").val();
    meta_data.container_upper_mouting_amount        = $("#container_upper_mouting_amount").val();
    meta_data.t_catalogue         = $("#t_catalogue").val();

    meta_data.t_category          = $("#t_category").val();
    meta_data.product_type          = $("#product_type").val();
    //meta_data.use_sale          = $("#use_sale").val();

    meta_data.sell_product_id         = $("#sell_product_id").val();
    meta_data.buy_product_id          = $("#buy_product_id").val();
    meta_data.sell_product_name       = $("#sell_product_name").val();
    meta_data.buy_product_name        = $("#buy_product_name").val();
    meta_data.production_sumary       = $("#production_sumary_code").val();
    //meta_data.tokyo_flag              = $("#tokyo_flag").val();
    meta_data.product_number_package  = $("#product_number_package").val();
    meta_data.t_type_order  = $("#t_type_order").val();
    
    return meta_data;
  }

  

  $("#product_form").validate(
      {    
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
              //  required:true
              // },
              // product_yurata_classification_for_sale:{
              //  required:true
              // },
              // product_wash_classification:{
              //  required:true
              // },
              // product_pl_categories:{
              //  required:true
              // },
              // container_upper_mouting_amount:{
              //  required:true
              // },
              t_category:{
                required:true
              },
              product_type:{
                required:true
              },
              use_sale:{
                required:true
              },
              sell_product_id:VALIDATION_ID_BUY_SELL,
              buy_product_id:VALIDATION_ID_BUY_SELL,
              sell_product_name:{ 
                required:true
              },
              buy_product_name:{
                required:true
              },
              t_catalogue:{
                required:true
              },
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
              t_type_order:{
                required:true
              }
              
              
                  // production_sumary_code:{
                  //       required:true
                  // },
                  // tokyo_flag:{
                  //       required:true
                  // },
              
              // category:{
              //  required:true
              // }
 
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
              product_organization_weight: {
                placement: 'right'
              },
              t_type_order: {
                placement: 'bottom'
              },
              category: {
                placement: 'bottom'
              },
              // product_standard_stock_number: {
              //  placement: 'right'
              // },
              // product_yurata_classification_for_sale: {
              //  placement: 'top'
              // },
              // product_wash_classification: {
              //  placement: 'top'
              // },
              // product_pl_categories: {
              //  placement: 'top'
              // },
              // container_upper_mouting_amount: {
              //  placement: 'left'
              // },
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