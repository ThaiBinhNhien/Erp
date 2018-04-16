<style>
	footer { padding: 20px; background: #1A1A1A; color: white; text-align: center; }
	footer li { display: inline; border-right: 1px solid #3a3d3f; padding-right: 3%; padding-left: 3%; }
	footer li:last-child { border: none; }
</style>
<footer class="row">
	<div class="container">
	<ul class="col-md-9" style="text-align:left;">
		<li>会社情報</li>
		<li>個人情報保護の目的及び方針</li>
		<li>ご利用規約</li>
		<li>サービスご利用方法</li>
	</ul>
	<div class="col-md-3">
	    <span>Copyright : TO Linen All Rights Reserved</span>
	</div>
	</div>
</footer>
<script type="text/javascript">
    //message show empty data
    var message_empty_data = "<?= $this->lang->line('message_empty_data')?>";
    function isPhoneNumber(text){
         text = String(text);
         if(text.length>14){
          return false;
         }
         var patern = /^0/g;
         var beginZero = text.match(patern);
         if(beginZero == null || beginZero.length != 1){
          return false;
         }
         patern = /\d/g;
         var numbers = text.match(patern);
         if(numbers == null || numbers.length > 11){
          return false;
         }
         patern = /-/g;
         var chars1 = text.match(patern);
         if(chars1 != null && chars1.length>3){
          return false;
         }
         patern = /\s/g;
         var chars2 = text.match(patern);
         if(chars2 != null && chars2.length>3){
          return false;
         }
         if(chars1 != null && chars1.length !=0 && chars2 != null && chars2.length != 0){
          return false;
         }
         return true;
    }
    function isFax(text){
     text = String(text);
     if(text.length>8){
      return false;
     }
     var patern = /\d/g;
     var numbers = text.match(patern);
     if(numbers == null || numbers.length != 7){
      return false;
     }
     patern = /(-|\s)/g;
     var chars = text.match(patern);
     if(chars != null && chars.length>1){
      return false;
     }
     return true;
    }

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo base_url();?>asset/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo base_url();?>asset/js/jquery-ui-1.11.3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery.validate-1.14.0.min.js" /></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-validate.bootstrap-tooltip.js" /></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/jquery.dataTables.css"> 
<script type="text/javascript" charset="utf8" src="<?php echo base_url();?>asset/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>asset/js/bootstrap.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url();?>/asset/js/jquery.hello-world.js"></script>
<script type="text/javascript"  src="<?php echo base_url();?>asset/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url();?>asset/ajax-bootstrap-select/dist/js/ajax-bootstrap-select.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url();?>asset/bootstrap-duallistbox/src/jquery.bootstrap-duallistbox.js"></script>
<script src="<?php echo base_url();?>asset/js/jquery.inputpicker.js"></script>
<script src="<?php echo base_url();?>asset/js/config_validation.js"></script>
<script src="<?= base_url(); ?>/asset/js/inputpicker.js"></script>
<script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>
<!-- <script src="<?php //echo base_url();?>asset/js/bootstrap-notify.min.js"></script> -->

<script type="text/javascript">
    // String format
    if (!String.format) {
        String.format = function(format) {
        var args = Array.prototype.slice.call(arguments, 1);
        return format.replace(/{(\d+)}/g, function(match, number) { 
            return typeof args[number] != 'undefined'
            ? args[number] 
            : match
            ;
        });
        };
    }

    // Validation
    jQuery.extend(jQuery.validator.messages, {
        required: "<?= $this->lang->line('jquery_validation_required')?>", //"Trường này yêu cầu được phải nhập.",
        remote: "<?= $this->lang->line('jquery_validation_remote')?>", //"Trường này đã tồn tại.",
        email: "<?= $this->lang->line('jquery_validation_email')?>", //"Hãy nhập email.",
        url: "<?= $this->lang->line('jquery_validation_url')?>", //"Hãy nhập URL.",
        date: "<?= $this->lang->line('jquery_validation_date')?>", //"Hãy nhập ngày.",
        dateISO: "<?= $this->lang->line('jquery_validation_dateISO')?>", //"Hãy nhập ngày (ISO).",
        number: "<?= $this->lang->line('jquery_validation_number')?>", //"Hãy nhập số.",
        digits: "<?= $this->lang->line('jquery_validation_digits')?>", //"Hãy nhập chữ số.",
        creditcard: "<?= $this->lang->line('jquery_validation_creditcard')?>", //"Hãy nhập số thẻ tín dụng.",
        equalTo: "<?= $this->lang->line('jquery_validation_equalTo')?>", //"Hãy nhập thêm lần nữa.",
        extension: "<?= $this->lang->line('jquery_validation_extension')?>", //"Phần mở rộng không đúng.",
        maxlength: jQuery.validator.format("<?= $this->lang->line('jquery_validation_maxlength')?>"), //"Hãy nhập từ {0} kí tự trở xuống."), 
        minlength: jQuery.validator.format("<?= $this->lang->line('jquery_validation_minlength')?>"), //"Hãy nhập từ {0} kí tự trở lên."),
        rangelength: jQuery.validator.format("<?= $this->lang->line('jquery_validation_rangelength')?>"),//"Hãy nhập từ {0} đến {1} kí tự."),
        range: jQuery.validator.format("<?= $this->lang->line('jquery_validation_range')?>"),//"Hãy nhập từ {0} đến {1}."),
        max: jQuery.validator.format("<?= $this->lang->line('jquery_validation_max')?>"),//"Số này phải nhỏ hơn hoặc bằng {0}"),
        min: jQuery.validator.format("<?= $this->lang->line('jquery_validation_min')?>"),//"Số này phải lớn hơn hoặc bằng {0}"),
        //
        isPhoneNumber: jQuery.validator.format("<?= $this->lang->line('jquery_validation_invalid')?>"),// Số này bao gồm cả số didejn thoại và số fax
        isPostal: jQuery.validator.format("<?= $this->lang->line('jquery_validation_postal')?>"),

    });

    // Class Validation
    jQuery.validator.addClassRules("validation-required", {
        required: true
    });
    jQuery.validator.addClassRules("validation-email", {
        email: true
    });
    jQuery.validator.addClassRules("validation-phone", {
        maxlength: 20,
        regex: /^\+?\d*$/
    });
    jQuery.validator.addClassRules("validation-positive-number", {
        regex: /^\+?[0-9]*\.?[0-9]+$/
    });
    $.validator.addMethod("regex",function(value, element, regexp) {
           var re = new RegExp(regexp);
           return this.optional(element) || re.test(value);
       }, "<?= $this->lang->line('jquery_validation_phone')?>"
    );

</script>
<script type="text/javascript">
    //Datepicker
    jQuery('.datepicker').datepicker({
        dateFormat:'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
    }).attr('readonly','readonly');
	$("#monthpicker").datepicker( { 
        format: "mm/yyyy",
        startView: "year", 
        minView: "year"
    }).attr('readonly','readonly');

    jQuery('.datepicker_from').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
            var dt_to = $('.datepicker_to');
            var minDate = $(this).datepicker('getDate');
            dt_to.datepicker('option', 'minDate', minDate); 
        }
	}).attr('readonly','readonly');
	jQuery('.datepicker_to').datepicker({
		dateFormat:'yy/mm/dd',
		changeMonth: true,
        changeYear: true,
        onSelect: function () {
			var dt_from = $('.datepicker_from');
            var maxDate = $(this).datepicker('getDate');
            dt_from.datepicker('option', 'maxDate', maxDate);
        }
    }).attr('readonly','readonly');

    // Nhập ngày - tháng vào input
    /*function isDate(txtDate)
    {
        var rxDatePattern = /^\d{4}(\/|\-)((10|11|12)|0[1-9]{1})(\/|\-)(([0-2][1-9])|(3[01]{1}))$/g;
        return txtDate.match(rxDatePattern);
    };
    $('input.hasDatepicker').on('blur', function(){
        var txtVal =  $(this).val();
        if(!isDate(txtVal)){
            $(this).val("");
        }
    });*/
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery("#menu-a li").click(function(){
      $(".active").removeClass("active");
      $("#menu-a li.active").removeClass("active");
      $(this).addClass('active');
    });
});
</script>
<?php
if($this->router->fetch_method()=='editOrder')
{
    $link1=site_url('receive-order');
    $link2=site_url('order/edit-order');
    echo'<script type="text/javascript">';
    echo "jQuery('#save-order').helloWorld('注文情報を編集します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}

if($this->router->fetch_method()=='edit_delivery_order2')
{
    
    $link1=site_url('receive-order');
    $link2=site_url('order/edit-delivery-order-2');
    echo'<script type="text/javascript">';
    echo "jQuery('.edit-delivery').helloWorld('納品・売上処理を行います。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='editOrder2')
{
    $link1=site_url('receive-order');
    $link2=site_url('order/edit-order-2');
    echo'<script type="text/javascript">';
    echo "jQuery('.edit-order').helloWorld('注文情報を編集します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='createNewOrder2')
{
    $link1=site_url('receive-order');
    $link2=site_url('order/create-order');
    echo'<script type="text/javascript">';
    echo "jQuery('.save-new-order').helloWorld('注文情報を新規作成します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='createNewOrder2')
{
    $link1=site_url('receive-order');
    $link2=site_url('order/create-order');
    echo'<script type="text/javascript">';
    echo "jQuery('.save-temp-order').helloWorld('注文情報を一時保存します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}

	
if($this->router->fetch_method()=='checklist')
{
    $link1=site_url('order/checklist');
    $link2=site_url('order/checklist');
	//$('#dialog-form buton').hide();
    echo'<script type="text/javascript">';
    echo "jQuery('.print-out').helloWorld('チェックをしてください。','$link1','$link2');";
    echo'</script>';
	
}
if($this->router->fetch_method()=='createNewOrder3')
{
   
	//$link1=site_url('receive-order');
   // $link2=site_url('order/create-order-2');
    //'<script type="text/javascript">';
    //echo "jQuery('.save-new-order2').helloWorld('注文情報を新規作成します。よろしいですか？','$link1','$link2');";
    //echo'</script>';
	
}
 

if($this->router->fetch_method()=='edit_purchase_order') 
{
    $link1=site_url('purchase');
    $link2=site_url('purchase/editOrder');
    echo'<script type="text/javascript">';
    echo "jQuery('.save-purchase-order').helloWorld('発注伝票（編集）を保存します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='processing_import') 
{
    $link1=site_url('purchase');
    $link2=site_url('purchase/processing-order');
    echo'<script type="text/javascript">';
    echo "jQuery('.save-import-order').helloWorld('保存前に入庫日が正しいか確認してください。入庫伝票を保存してもよろしいですか？','$link1','$link2');";
    echo "jQuery('#dialog-form h3').css('margin-top','16%')";
	echo'</script>';
}
if($this->router->fetch_method()=='detail_purchase') 
{
    $link1=site_url('purchase');
    $link2=site_url('purchase/detail-order');
    echo'<script type="text/javascript">';
    echo "jQuery('.del-purchase-order').helloWorld('発注伝票を削除します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='edit_export_order') 
{
    $link1=site_url('purchase/export-order');
    $link2=site_url('purchase/edit-export-order');
    echo'<script type="text/javascript">';
    echo "jQuery('.save-export-order').helloWorld('出庫伝票（編集）を保存します。よろしいですか？','$link1','$link2');";
    echo'</script>';

}
if($this->router->fetch_method()=='detail_export_order') {
    $link1=site_url('purchase/export-order');
    $link2=site_url('purchase/detail-export-order');
    echo'<script type="text/javascript">';
    echo "jQuery('.del-export-order').helloWorld('出庫伝票を削除します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}

if($this->router->fetch_method()=='add_warehouse') 
{

    $link1=site_url('purchase/export-order');
    $link2=site_url('purchase/add-export-order');
    echo'<script type="text/javascript">';
    echo "jQuery('.add-export-order').helloWorld('出庫伝票（新規）を保存します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='add_revenues') 
{

    $link1=site_url('revenues/created_revenues');
    $link2=site_url('revenues/add-revenues');
    echo'<script type="text/javascript">';
    echo "jQuery('.save-revuenues').helloWorld('請求書を保存します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='edit_createdRevenues') 
{

    $link1=site_url('revenues/created_revenues');
    $link2=site_url('revenues/edit_createdRevenues');
    echo'<script type="text/javascript">';
    echo "jQuery('.save-created').helloWorld('請求情報を編集します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='view_revenues') 
{

    $link1=site_url('revenues/created_revenues');
    $link2=site_url('revenues/detail-revenues');
    echo'<script type="text/javascript">';
    echo "jQuery('.del-revenues').helloWorld('請求情報を削除します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='edit_revenues') 
{

    $link1=site_url('revenues/created_revenues');
    $link2=site_url('revenues/edit-revenues');
    echo'<script type="text/javascript">';
    echo "jQuery('.save-created').helloWorld('請求書を編集します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='detail_revenues_2') 
{

    $link1=site_url('revenues/created_revenues');
    $link2=site_url('revenues/detail-revenues-2');
    echo'<script type="text/javascript">';
    echo "jQuery('.del-revenues').helloWorld('請求書を削除します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='edit_shipment') 
{

    $link1=site_url('shipment');
    $link2=site_url('shipment/edit');
    echo'<script type="text/javascript">';
    echo "jQuery('.export').helloWorld('出荷確定します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='edit_shipment_2') 
{

    $link1=site_url('shipment');
    $link2=site_url('shipment/edit-type-2');
    echo'<script type="text/javascript">';
    echo "jQuery('.request-edit').helloWorld('変更依頼します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='edit_shipment_2') 
{

    $link1=site_url('shipment');
    $link2=site_url('shipment/edit-type-2');
    echo'<script type="text/javascript">';
    echo "jQuery('.request-export').helloWorld('発注確定します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='add_shipment') 
{
	
    $link1=site_url('shipment');
    $link2=site_url('shipment/add');
    echo'<script type="text/javascript">';
    echo "jQuery('.request-export').helloWorld('発注確定します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}

if($this->router->fetch_method()=='export') 
{

    $link1=site_url('shipment');
    $link2=site_url('shipment/export');
    echo'<script type="text/javascript">';
    echo "jQuery('.export').helloWorld('出荷確定します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
if($this->router->fetch_method()=='detail_shipment_2') 
{

    $link1=site_url('shipment');
    $link2=site_url('shipment/detail_shipment_2');
    echo'<script type="text/javascript">';
    echo "jQuery('.del-export-order').helloWorld('出荷伝票を削除します。よろしいですか？','$link1','$link2');";
    echo'</script>';
}
?>

<script type="text/javascript">
function formatMoney(number){
  return number.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
	jQuery('#delivery-order-copy').click(function(){
    $('.copy').each(function(){
        var value=$(this).text();
        var pos=  $(this).closest('td').next().find('input');
        //pos.html('<input'.value=value.'/>');
        if(value <= 0) {
          value = 0; 
        }
		pos.val(value);
    });

    // Change Amount
    $("#get_table_delivery > tbody > tr:not(.sum-col)").each(function(index){
      var quantity = $(this).find('td').find('.get_product_quantity').val();
      var price = $(this).find('td').find('.get_product_price').val();
      var price_gaichyu = $(this).find('td').find('.get_product_price_gaichyu').val();
      if(parseInt(quantity) > 0 && parseInt(price) > 0) {
        var amount = parseFloat(quantity) * parseFloat(price);
        var amount_gaichyu = parseFloat(quantity) * parseFloat(price_gaichyu);
        $(this).find('td').find('.get_amount').val(amount.toFixed(2));
        $(this).find('td').find('.get_amount_gaichyu').val(amount_gaichyu.toFixed(2));
      }
    });
    setTotalAmountDelivery();
    return false;
})
    jQuery('#thir-copy').click(function(){
    $('.copy').each(function(){
        var value=$(this).text();
        var pos=  $(this).closest('td').next().find('input');
        //pos.html('<input'.value=value.'/>');
		pos.val(value);
    });
    return false;
})
jQuery('#ship-copy').click(function(){
    $('.copy').each(function(){
        var value=$(this).text();
        var value_change=$(this).parent().find('.product_quantity_change').val();
        var pos=  $(this).closest('td').next().next().find('input');
        if(value == '') {
            value = 0;
        }
        if(value_change == '') {
            value_change = 0;
        }
        var total = parseFloat(value)+parseFloat(value_change);
		pos.val(total);
    });
    return false;
})
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
   $("#view-order").click(function(){
        $(this).find('ul').toggle();
    })
   $(".scroll tr:odd").click(function(){
      window.open("<?php echo site_url('order/detail-order');?>", '_blank');
      return false;
   })
   $("#order-table th").click(function(){
      
      return false;
   })
   $("#shipment th").click(function(){
      
      return false;
   })
   $(".created-revenues th").click(function(){
      
      return false;
   })
   $("#purchase th").click(function(){
      
      return false;
   })
   $("#export th").click(function(){
      
      return false;
   })
   //jQuery('.save-temp-2').helloWorld('請求書を削除します。よろしいですか？','<?php echo site_url("receive-order");?>','receive-order');
	
	jQuery('.save-temp-2').click(function(){
 	jQuery('.save-temp-2').helloWorld('注文情報を一時保存します。よろしいですか？','<?php echo site_url("receive-order");?>','<?php echo site_url("order/create-order-2");?>');
	
	})
	jQuery('.save-debt').click(function(){
 	jQuery('.save-debt').helloWorld('単価チェックを保存します。','<?php echo site_url("purchase/debt");?>','<?php echo site_url("purchase/detailDebt");?>');
	
	})
  	jQuery('#save-temp-ship').click(function(){
 	jQuery('#save-temp-ship').helloWorld('出荷情報を一時保存します。よろしいですか？','<?php echo site_url("shipment");?>','<?php echo site_url("shipment/add");?>');
	
	})/*
	jQuery('.purchase-confirm').click(function(){
 	jQuery('.purchase-confirm').helloWorld('承認します。','<?php echo site_url("purchase");?>','<?php echo site_url("purchase/detail-order");?>');
	
	})*/

   $("#shipment tr:odd").click(function(){
      window.open("<?php echo site_url('shipment/detail');?>", '_blank');
      return false;
   })
    $("#revenues-table tr").click(function(){
		//window.open("<?php echo site_url('revenues/detail-revenues-2');?>", '_blank');
		// return false;
   })

	$("#export tr").click(function(){
      // location.href=
       //window.open("<?php echo site_url('purchase/detail-export-order');?>", '_blank');
       //return false;
   })

    /*$("#revenues tr").dblclick(function(){
      window.open("<?php //echo site_url('revenues/detail-revenues');?>", '_blank');
      return false;
   })*/ 


});
//Link a
    $('#order a').click(function(e)
        {
                e.stopPropagation(); 
        });





	//Edit purchase order
	
$('#insert-purchase-order').click(function(){

		$('.del')
		.after('<tr><td><select><option>0000</option></select></td ><td></td><td></td><td></td><td><input type="text"/></td><td></td><td></td><td></td><td><input type="text"/></td></tr>');
	return false;
	
})

	//Edit purchase order
	
//----------Insert row when edit-order
$('#insert-order').click(function(){
	if(flag){
	$('.del')
		.after('<tr><td><select><option>0000</option></select></td><td class="no-sum-col"></td><td class="no-sum-col"></td><td class="no-sum-col"></td><td class="no-sum-col"></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td><input type="text"/></td><td class="no-sum-col"></td></tr>');
	}
		return false;
	
})

//----------End------------//		
//----------Insert row when edit-order-2
$('#edit-order-2').on('focus','input',function(){
	$('table').find('tr').removeClass('del');
	$(this).parent().parent().addClass('del');
})
$('#remove-order-2').on('click',function(){
	if(flag_order_2){
	$('.del').remove();	
	}
	
	return false;
})
$('#insert-order-2').click(function(){
	if(flag_order_2){
	$('.del')
		.after('<tr><td><select><option></option></select></td><td></td><td></td><td></td><td></td><td ><input value=""></td></tr>');
	}
	return false;
	
})
var flag_order_2;
$('#remove-order-2,#insert-order-2').hover(function(){
	var hasfocus=$('#edit-order-2 input').is(':focus');
	flag_order_2=hasfocus;
})
//----------End------------//
//Insert shipment
$('#add-shipment-table').on('focus','input',function(){
	$('table').find('tr').removeClass('del');
	$(this).parent().parent().addClass('del');
})
$('#insert-row-2').click(function(){	
	$('.del')
		.after('<tr><td><select><option></option></select></td><td></td><td></td><td></td><td></td><td ><input value=""></td></tr>');
	return false;
	
})
/*
$('#edit-order input').focus(function(){
		$('table').find('tr').removeClass('del');
	$(this).parent().parent().addClass('del');
})*/

$('#create-table-2').on('focus','input',function(){
	$('table').find('tr').removeClass('del');
	$(this).parent().parent().addClass('del');
})
$('#remove-row-2').on('click',function(){
	$('.del').remove();
	return false;
})
//Disable first colum
/*
$(window).resize(function(){
    if($(window).width()<768){
        $('#menu-a li a').removeAttr('target');
        $('#menu-a li a').removeAttr('onclick');   
        $('#menu-a li:has(ul) > a').on('click',function() {
            $(this).parent().find('ul').slideToggle();
            return false;
            e.stopPropagation(); 
        });
		 $('#menu-a li').on('click','a',function(e) {
            $(this).parent().find('ul').slideToggle();
           
            e.stopPropagation(); 
			  return false;
			//alert('tehan');
        });
    }
    else{
            $('#menu-a li a').attr('target','_blank');
            $('#menu-a li a').attr('onclick','window.location.reload(true)');
            $('#menu-a li:has(ul) > a').on('click',function() {
            //event.preventDefault();
        });
    }
});
    

if($(window).width()<768){
    $('#menu-a li a').removeAttr('target');
    $('#menu-a li a').removeAttr('onclick');   
    $('#menu-a li:has(ul) > a').on('click',function() {
    $(this).parent().find('ul').slideToggle();
        return false; 
        //e.stopPropagation(); 
    });   
}
//Bar menu
    $(".btn-navbar").click(function(e){
        $("#menu-a").toggle();
         e.stopPropagation(); 
    })
    
    $('ul li a').click(function(){
       //   e.stopPropagation(); 
    //    return false;
    })*/
//Bar menu
    $(".btn-navbar").click(function(e){
        $("#menu-a").toggle();
         e.stopPropagation(); 
    })
	$(".down").click(function(e){

		$(this).toggleClass('up');
		$(this).next().slideToggle();
		  e.stopPropagation(); 
	})
	$('[data-toggle="tooltip"]').tooltip();  
	$('.content li').hover(function(){
		
		var text=$(this).find('a').attr('title');
		//alert(text);
		$(this).show('<p>text</p>');
	})
	/*var tooltip = document.querySelectorAll('.coupontooltip');

document.addEventListener('mousemove', fn, false);

function fn(e) {
    for (var i=tooltip.length; i--;) {
        tooltip[i].style.left =( e.pageX )  + 'px';
        tooltip[i].style.top =( e.pageY-100)+ 'px';
    }
}*/
	//Check radio button
$('.m-radio').click(function() {
 if ($('.m-radio').is(":checked"))
		{
			$('.radio-1').removeAttr('disabled');
			$('.radio-2').attr('disabled','disabled');
			$('.radio-2').removeAttr('checked');
			//$('.disable').attr('disabled','disabled');
		}
	else{
		$('.radio-1').attr('disabled','disabled');
	}
 })
$('.n-radio').click(function() {
 if ($('.n-radio').is(":checked"))
		{
			$('.radio-2').removeAttr('disabled');
			$('.radio-1').attr('disabled','disabled');
			$('.radio-1').removeAttr('checked');
			//$('.disable').removeAttr('disabled','disabled');
		}
	else{
		$('.radio-2').attr('disabled','disabled');
	}
 })


$('#invent-1 > input').click(function() {
 if ($('#invent-1 > input').is(":checked"))
		{
        $('button').removeAttr('disabled');
		$('.invent-1').removeAttr('disabled');
		$('.invent-2').attr('disabled','disabled');
		$('.invent-3').attr('disabled','disabled');
		$('.invent-4').attr('disabled','disabled');
		$('.invent-5').attr('disabled','disabled');
		$('.invent-6').attr('disabled','disabled');
		$('.invent-7').attr('disabled','disabled');
		$('.invent-8').attr('disabled','disabled');
			/*$('.radio-1').attr('disabled','disabled');
			$('.radio-1').removeAttr('checked');
			$('.disable').removeAttr('disabled','disabled');*/
		}
	/*else{
		$('.invent-2').attr('disabled','disabled');
		$('.invent-3').attr('disabled','disabled');
		$('.invent-4').attr('disabled','disabled');
		$('.invent-5').attr('disabled','disabled');
		$('.invent-6').attr('disabled','disabled');
		$('.invent-7').attr('disabled','disabled');
		$('.invent-8').attr('disabled','disabled');
	}*/
 })

$('#invent-2 > input').click(function() {
 if ($('#invent-2 > input').is(":checked"))
		{
			$('part-2').find('*').prop('disabled',true);

            $('.invent-2').removeAttr('disabled');
			$('.invent-1').attr('disabled','disabled');
			$('.invent-3').attr('disabled','disabled');
			$('.invent-4').attr('disabled','disabled');
			$('.invent-5').attr('disabled','disabled');
			$('.invent-6').attr('disabled','disabled');
			$('.invent-7').attr('disabled','disabled');
			$('.invent-8').attr('disabled','disabled');
		}
	
 })

$('#invent-3 > input').click(function() {
 if ($('#invent-3 > input').is(":checked"))
		{
			$('.invent-3').removeAttr('disabled');
			$('.invent-1').attr('disabled','disabled');
			$('.invent-2').attr('disabled','disabled');
			$('.invent-4').attr('disabled','disabled');
			$('.invent-5').attr('disabled','disabled');
			$('.invent-6').attr('disabled','disabled');
			$('.invent-7').attr('disabled','disabled');
			$('.invent-8').attr('disabled','disabled');
		}
	
 })
$('#invent-4 > input').click(function() {
 if ($('#invent-4 > input').is(":checked"))
		{
			$('.invent-4').removeAttr('disabled');
			$('.invent-1').attr('disabled','disabled');
			$('.invent-3').attr('disabled','disabled');
			$('.invent-2').attr('disabled','disabled');
			$('.invent-5').attr('disabled','disabled');
			$('.invent-6').attr('disabled','disabled');
			$('.invent-7').attr('disabled','disabled');
			$('.invent-8').attr('disabled','disabled');
		}
	
 })
$('#invent-5 > input').click(function() {
 if ($('#invent-5 > input').is(":checked"))
		{
			$('.invent-5').removeAttr('disabled');
			$('.invent-1').attr('disabled','disabled');
			$('.invent-3').attr('disabled','disabled');
			$('.invent-4').attr('disabled','disabled');
			$('.invent-2').attr('disabled','disabled');
			$('.invent-6').attr('disabled','disabled');
			$('.invent-7').attr('disabled','disabled');
			$('.invent-8').attr('disabled','disabled');
		}
	
 })
$('#invent-6 > input').click(function() {
 if ($('#invent-6 > input').is(":checked"))
		{
			$('.invent-6').removeAttr('disabled');
			$('.invent-1').attr('disabled','disabled');
			$('.invent-3').attr('disabled','disabled');
			$('.invent-4').attr('disabled','disabled');
			$('.invent-5').attr('disabled','disabled');
			$('.invent-2').attr('disabled','disabled');
			$('.invent-7').attr('disabled','disabled');
			$('.invent-8').attr('disabled','disabled');
		}
	
 })
$('#invent-7 > input').click(function() {
 if ($('#invent-7 > input').is(":checked"))
		{
			$('.invent-7').removeAttr('disabled');
			$('.invent-1').attr('disabled','disabled');
			$('.invent-3').attr('disabled','disabled');
			$('.invent-4').attr('disabled','disabled');
			$('.invent-5').attr('disabled','disabled');
			$('.invent-6').attr('disabled','disabled');
			$('.invent-2').attr('disabled','disabled');
			$('.invent-8').attr('disabled','disabled');
			//$('.ui-datepicker-calendar').hide();
			
			//$('table').hide();
		}
	
	
 })
$('#invent-8 > input').click(function() {
 if ($('#invent-8 > input').is(":checked"))
		{
			$('.invent-8').removeAttr('disabled');
			$('.invent-1').attr('disabled','disabled');
			$('.invent-3').attr('disabled','disabled');
			$('.invent-4').attr('disabled','disabled');
			$('.invent-5').attr('disabled','disabled');
			$('.invent-6').attr('disabled','disabled');
			$('.invent-7').attr('disabled','disabled');
			$('.invent-2').attr('disabled','disabled');
			//$('body').removeClass("ui-datepicker-calendar");
		}
	else{
		
	}
	
 })
$(function() {
    $('#wrap .date-picker').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy/mm',
        beforeShow: function(el, dp) { 
            $('#ui-datepicker-div').addClass('hide-calendar');
        },
        onClose: function(dateText, inst) { 
            setTimeout(function(){$('#ui-datepicker-div').removeClass('hide-calendar');},300);
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
			
        }
    }).attr('readonly','readonly');

});
$('.date-picker').focus(function(){
	//$('body').addClass("ui-datepicker-calendar");
	//$('.ui-datepicker-calendar').css('display','none');
	//alert('thean');
	
})	
$('.date-picker').focusout(function(){
	//$('body').removeClass(".ui-datepicker-calendar");
	//$('.ui-datepicker-calendar').css('display','block');
	
	
})
$('.wrap-input-1 input,.wrap-input-2 input,.wrap-input-3 input,.wrap-input-4 input,.wrap-input-5 input,.wrap-input-6 input,.wrap-input-7 input,.wrap-input-7 select,.wrap-input-2 select,.wrap-input-3 select,.wrap-input-6 select,.wrap-input-8 input,.wrap-input-8 select').attr('disabled','disabled');


//Inventory select first option
$('.select-opt').change(function(){
	if($(this).val()=="1"){
		$('.opt-2').hide();	
	}
	else
		{
			$('.opt-2').show();
		}
	
})
/*$.datepicker.regional['fr'] = {clearText: 'Effacer', clearStatus: '',
    closeText: '選択', closeStatus: 'Fermer sans modifier',
    prevText: '<Préc', prevStatus: 'Voir le mois précédent',
    nextText: 'Suiv>', nextStatus: 'Voir le mois suivant',
    currentText: '本日', currentStatus: 'Voir le mois courant',
    monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
    'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
    monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
    'Jul','Aoû','Sep','Oct','Nov','Déc'],
    monthStatus: 'Voir un autre mois', yearStatus: 'Voir un autre année',
    weekHeader: 'Sm', weekStatus: '',
    dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
    dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
    dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
    dayStatus: 'Utiliser DD comme premier jour de la semaine', dateStatus: 'Choisir le DD, MM d',
    dateFormat: 'dd/mm/yy', firstDay: 0, 
    initStatus: 'Choisir la date', isRTL: false};
 $.datepicker.setDefaults($.datepicker.regional['fr']);*/
/*$(".date-picker").addClass(".ui-datepicker-calendar");	
$('.date-picker').css('display','none');*/



/*var tableOffset = $("#order").offset().top;
var $header = $("#order > thead").clone();
var $fixedHeader = $("#header-fixed").append($header);

$(window).bind("scroll", function() {
    var offset = $(this).scrollTop();
    
    if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
        $fixedHeader.show();
    }
    else if (offset < tableOffset) {
        $fixedHeader.hide();
    }
});*/


// Export csv
$(document).on("click", "#btnExport", function(){
    var getUrl = url_export.split("?")[0];
    window.open(getUrl);
});
$(document).on("click", "#btnExportDetail", function(){
    var get_type_csv = $('#get_type_csv option:selected').val();
    var getUrl = url_export.split("?")[0];
    getUrl = getUrl + "?type="+get_type_csv;
    window.open(getUrl);
});


// Export csv
$('#form_import_csv').on("submit", function(e){  
    e.preventDefault();

    var ext = $("#import_file").val().split(".").pop().toLowerCase();

	if($.inArray(ext, ["csv"]) == -1) {
		$(this).helloWorld("<?= $this->lang->line('jquery_validation_extension')?>");
		return false;
	}

    $.ajax({  
         url:url_import,  
         method:"POST",  
         data:new FormData(this),  
         contentType:false,
         cache:false,
         processData:false, 
         success: function(data){  
            var result = JSON.parse(data);
            if(result.success == true) {
                $(this).helloWorld(result.message, urlIndex);
            } else {
                $(this).helloWorld(result.message);
            }
         }
    });
});  

/*----PullDown Table-----*/
$(document).on("click",".value_pulldown_id, .input-triangle", function(e){
    //$( ".value_pulldown_id" ).unbind();
    $(".detail-pulldown-table").hide();
    $(this).parent().find('.detail-pulldown-table').show();
    e.stopPropagation();
});
$(document).click(function(e) {
    if( e.target.class != 'value_pulldown_id') {
      $(".detail-pulldown-table").hide();
      e.stopPropagation();
    }
});
$(document).on("click",".detail-pulldown-table tr", function(e){
    var valueTitle = $(this).data("title");
    var valueData = $(this).data("id");
    $(this).parent().parent().parent().find(".value_pulldown_id").val(valueTitle);
    $(this).parent().parent().parent().find(".value_pulldown_id").data("id",valueData);
    $(".detail-pulldown-table").hide();
    e.stopPropagation();
});

function forprint(){
    if (!window.print){

    return
    }
    window.print()
}

// Config bootstrap-duallistbox
var config_duallistbox = {
    nonSelectedListLabel: '未選択 ',
    selectedListLabel: '選択済 ',
    infoText: '全て表示 {0}',
    filterTextClear: '空リスト',
    filterPlaceHolder: '絞り込み', 
    moveSelectedLabel: '選択項目を移動',
    moveAllLabel : '全て移動',
    removeSelectedLabel : '選択項目を削除',
    removeAllLabel : '全て削除',
    infoTextEmpty: '空リスト',
    preserveSelectionOnMove: 'moved',
    moveOnSelect: false,
    infoTextFiltered: '<span class="label label-warning">絞り込み</span> {1} から {0}',
};


function check_number(class_name){
  $('table').on('keyup','.'+class_name,function(){
    var class_name = $(this).val();
    $(this).closest('td').find('.popup').remove();  
    if (class_name == ''){
      $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
      $('table').addClass('error');

    } else if( class_name >= 0){
      $('table').removeClass('error');
      $(this).closest('td').find('.popup').remove();  

    }/* else {
      $('table').addClass('error');
      $(this).closest('td').css('position','relative');
      $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">無効な番号</span></div>');
    } */
  })

}
function check_required(class_name){
  $( "."+class_name).each(function() {
      var valid = $(this) .val();
        if(valid == ''){
          $('table').addClass('error');
          $(this).closest('td').css('position','relative');
          $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
          setTimeout(function(){ $('.popup').fadeOut().remove(); }, 5000);
          return false;//Exit();
        }
  });
}
function check_re(){
        $( ".product_id").each(function() {
            if($(this).val() == ''){
                $('table').addClass('error');
                $(this).closest('td').css('position','relative');
                $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
          setTimeout(function(){ $('.popup').fadeOut().remove(); }, 5000);
          return false;//Exit();     
            }   
    });
}
function check_input_required(target){
    if($(target).val() == '')
    {
        $('table').addClass('error');
        $(target).closest('div').append('<div class="popup"><span class="popup_input" id="myPopup">必須です。ご入力ください。</span></div>'); 
    setTimeout(function(){ $('.popup').fadeOut().remove(); }, 5000);
    }
    else
    {
        $('table').removeClass('error');
    }
}
function check_valid(){
  if($('table').hasClass('error')){
      return false;
    } else {
      return true;
    } 
}
function keypress_number(tbl_frm,target){
$(tbl_frm).on('keypress',target,function(event){
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
      return true;
    }
});
}

function error_popup(position,target){
    $(target).closest(position).append('<div class="popup"><span class="popup_input" id="myPopup">必須です。ご入力ください。</span></div>'); 
    setTimeout(function(){ $('.popup').fadeOut().remove(); }, 5000);
}
/*function error_product(){
        $(this).closest('td').css('position','relative');
                $(this).closest('td').append('<div class="popup"><span class="popuptext" id="myPopup">必須です。ご入力ください。</span></div>');
          setTimeout(function(){ $('.popup').fadeOut().remove(); }, 5000);
}*/



(function($){
  //__Table is array json of fields
  /*
    detail-product
    product_id
  */
  $.fn.popup_table = function(table,filter_product){
/*__Display popup table when product_id is focus__*/
  $('table').on('click','.product_id',function(e){
    $(".detail-product").remove();
    var product_arr = [];
    var table = '';
    if(!jQuery.isEmptyObject(filter_product))
    {
    //__Get all product id and push array
    $(".real_id").each(function() {
      product_arr.push($(this).val());
    });
    //__Find and extract products selected
    var empty = 0;
    table+='<table class="detail-product">';
    for(var i in filter_product){
      var check = false;
      product_arr.forEach(function(element) {
      if(filter_product[i].id==element){
        check = true;
      }
    });
    if(!check){
      table+='<tr>'+'<td>'+(filter_product[i].buy_code==null ? '':filter_product[i].buy_code)+'</td>'+'<td>'+filter_product[i].name+'</td>'
      +"<input type='hidden' value='"+filter_product[i].id+"'>"+'</tr>';
      empty+=1;
    }
    }//__End for
    table+='</table>';
    //__Add table to current product_id input
    $(this).after(table);
    //__Display table if have product
    if(empty>0){
    $('.detail-product').css('display','block');
    }
    e.stopPropagation();
    }
});
    /*__Display table when click the triangle__*/
    $('table').on('click','.input-triangle',function(e){
     $('.product_id').trigger('click');
    });
    /*__End display table when click the triangle__*/
/*__End display products table when product_id is focus__*/

/*__Display information of product when select product__*/
    $('#'+table).on('click','.detail-product tr',function(){
    var val  =  $(this).children("td:first").text();
    var real_id = $(this).find('input').val();
    var prod =  $(this).closest('div');
    prod.find('.real_id').val(real_id);
    prod.find('.product_id').val(val);
    $(".detail-product").hide();
    //__Jump to amount input
    $('.amount').focus();
    //__Hide error popup
    $(this).closest('td').find('.popup').remove();
    //__Display detail product when selected
    var table = prod.closest('.product');
     for(var i in json_product_list){
        if(json_product_list[i].product_id==real_id){
            table.find('td[data-name]')        .text(json_product_list[i].name);
            table.find('td[data-color]')       .text(json_product_list[i].color);
            table.find('td[data-standard]')    .text(json_product_list[i].standard);
            table.find('td[data-accumulation]').text(json_product_list[i].accumulation);
            table.find('.amount').val(0);
            table.find('td[data-price-unit]')  .text(json_product_list[i].price_unit);
        }
      }
    })
/*__End display information of product when select__*/

/*__Search value by input__*/ 
    $('#'+table).on('keyup','.product_id',function(e){
    var input =$(this).val();
    var filter = input.toUpperCase();
    var prod =  $(this).closest('div');
    var tr = prod.find(".detail-product tr");
    $('.detail-product').show();
    if(input != ''){
    for (var i = 0; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
            } else {
            tr[i].style.display = "none";
            
            var numOfVisibleRows = $('.detail-product tbody > tr').filter(function() {
                return $(this).css('display') !== 'none';
                }).length;
            console.log(numOfVisibleRows);
            if(numOfVisibleRows == 0){
                $('.detail-product').hide();
            }
            }
          } 
        }//__End for 
    }//__End if
    //__Display detail of product when press enter
    if (e.keyCode == 13) {
    //__Get number row display
    var numOfVisibleRows = $('.detail-product tbody > tr').filter(function() {
        return $(this).css('display') !== 'none';
        }).length;
        //__Display detail if a row
        if(numOfVisibleRows == 1)
        {
            $(".detail-product tbody > tr:visible").addClass('active');
            var val=$(".active > td:first").text();
            $(this).val(val);
            var real_id = $(".active > input").val();
            var table = $(this).closest('tr');
            for(var i in json_product_list){
                if(json_product_list[i].product_id==real_id){
                table.find('.real_id').val(json_product_list[i].product_id);
                table.find('td[data-name]')        .text(json_product_list[i].name);
                table.find('td[data-color]')       .text(json_product_list[i].color);
                table.find('td[data-standard]')    .text(json_product_list[i].standard);
                table.find('td[data-accumulation]').text(json_product_list[i].accumulation);
                table.find('td[data-price-unit]')  .text(json_product_list[i].price_unit);
              }
            }//__End for
            $('.detail-product').remove();
      }
   }//__End if    
})




/*--------------End Search value by input -----------------*/ 
    //__Hide detail-product table when click outside
    $(document).click(function(e) {
      if( e.target.class != 'product_id') {
        $(".detail-product").hide();
        e.stopPropagation();
      }
    });
  }
})(jQuery);



// Automation trim for input
$(document).on("focusout","input", function(){
    $(this).val($.trim($(this).val()));
});

// integrate tooltipster with jQuery validator
jQuery.validator.setDefaults({
	highlight: function(element) {
        setTimeout(function(){
            $("select, input, textarea").each(function(){
                $(this).tooltip("destroy");
            });
        }, 6000);
    }
});

// Notifition
//var config_location_hostname = 'http://'+window.location.hostname+':3000';
//var config_location_hostname = 'https://erptolinennode.appspot.com/';
var config_location_hostname = 'http://erp-tolinen.vietvang.net:3000/';
function add_notification_realtime(data){
    var socket = io.connect(config_location_hostname);

    // connect by token
    socket.on('connect', function(){
        socket.emit('authenticate', {token: data.token});
    });

    // Connected for room
    socket.emit('room', data.username);

    socket.emit('new_count_message', { 
        username: data.username,
        new_count_message: data.new_count_message
    });

    socket.emit('new_message', { 
        username: data.username,
        subject: data.subject,
        message: data.message,
        created_at: data.created_at,
        id: data.id
    });
}

$(document).ready(function(){

    // Load message
    $.ajax({
        type: "POST",
        url: "<?= base_url("notification/get_list") ?>",
        dataType: "json",
        cache : false,
        success: function(dataajax){
            if(dataajax != null) {
                var message_html = "";
                if(dataajax.result != null) {
                    $.each(dataajax.result, function(index, value) {
                        message_html += '<li><div>';
                        message_html += '<p class="notification-title">'+value["<?= TN_SUBJECT ?>"]+'</p>';
                        message_html += ' <p class="notification-date">'+value["<?= TN_DATE_CREATER ?>"]+'</p> ';
                        if(value["<?= TN_STATUS ?>"] == 1 || value["<?= TN_STATUS ?>"] == "1") {
                            message_html += '<a class="on_check_notification" data-id="'+value["<?= TN_ID ?>"]+'"><i class="fa fa-icon-check fa-icon-check-on fa-check-circle"></i></a>';
                        } else {
                            message_html += '<a class="on_check_notification" data-id="'+value["<?= TN_ID ?>"]+'"><i class="fa fa-icon-check fa-icon-check-off fa-eye"></i></a>';
                        }
                        
                        message_html += '<span class="notification-content">'+html_entity_decode(value["<?= TN_MESSAGE ?>"])+'</span></div></li>';
                    });
                }
                $('#list_message_notification').html(message_html);
            }

            // Connect socket    
            var socket = io.connect(config_location_hostname);

            // connect by token
            socket.on('connect', function(){
                socket.emit('authenticate', {token: dataajax.token});
            });

            // new_count_message
            socket.on( 'new_count_message', function( data ) {
                $("#new_count_message" ).html( data.new_count_message );
                $('#notif_audio')[0].play();
            });

            // update_count_message
            socket.on( 'update_count_message', function( data ) {
                $("#new_count_message" ).html( data.update_count_message );
            });

            // new_message
            socket.on( 'new_message', function( data ) {
                var message_html = "";
                message_html += '<li><div>';
                message_html += '<p class="notification-title">'+data.subject+'</p>';
                message_html += ' <p class="notification-date">'+data.created_at+'</p> ';
                message_html += '<a class="on_check_notification" data-id="'+data.id+'"><i class="fa fa-icon-check fa-icon-check-off fa-eye"></i></a>';
                message_html += '<span class="notification-content">'+html_entity_decode(data.message)+'</span></div></li>';

                $('#list_message_notification').prepend(message_html);

            });

            socket.on('connect_error', function() {
                console.log("Disconnects notification !");
                socket.disconnect();
            });
        }
    });
});

function html_entity_decode(str) {
    if(str != null) {
        var ta = document.createElement("textarea");
        ta.innerHTML=str.replace(/</g,"&lt;").replace(/>/g,"&gt;");
        toReturn = ta.value;
        ta = null;
        return toReturn
    } else {
        return null;
    }
}

// click ready for notification
$(document).on("click", ".on_check_notification", function(){
    var id_notification = $(this).data("id");
    var dataString = {  
        id : id_notification
    };
    var myThis = $(this);
    $.ajax({
        type: "POST",
        url: "<?= base_url("notification/update_ready") ?>",
        data: dataString,
        dataType: "json",
        cache : false,
        success: function(data){
            if(data.success == true){
                myThis.find("i").removeClass( "fa-icon-check-off fa-eye" ).addClass( "fa-icon-check-on fa-check-circle" );

                var socket = io.connect(config_location_hostname);    

                // connect by token
                socket.on('connect', function(){
                    socket.emit('authenticate', {token: data.token});
                });

                socket.emit('room', data.username);
                socket.emit('update_count_message', { 
                    username: data.username,
                    update_count_message: data.new_count_message
                });
            } 
        } 
    });
});

// click message
var $menu = $('#list_message_notification');
$('.dropdown-notification a').click(function () {
    var lengthMenuSub = $(this).parent().find("ul li").length;
    if(lengthMenuSub > 0) {
        $menu.toggle();
    }
});

$(document).mouseup(function (e) {
   if (!$menu.is(e.target) // if the target of the click isn't the container...
   && $menu.has(e.target).length === 0) // ... nor a descendant of the container
   {
     $menu.hide();
  }
 });

$("#navi ul li").click(function() {
    $(this).find("a").click();
});

// Setting for message
var message_confirm_save_field = "<?= $this->lang->line('message_confirm_save_field')?>";
var message_error_ajax = "<?= $this->lang->line('message_error_ajax')?>";
var message_error_requeird_value = "<?= $this->lang->line('message_error_requeird_value')?>";
</script>
<?php
$router =& load_class('Router', 'core');
$controller=$router->fetch_class();
$action=$router->fetch_method();
$segment = $this->uri->segment(1);
if ( strcmp ($segment, 'master')== 0  ){

  echo '<script src="'.base_url().'asset/js/master/'.$controller.'/'.$action.'.js"></script>';
}
else{
    echo '<script src="'.base_url().'asset/js/'.$controller.'/'.$action.'.js"></script>';
}
?>

<script type="text/javascript">
var PAGE_SIZE_SELECTBOX = "<?= PAGE_SIZE_SELECTBOX ?>";

$("input,textarea").on("keyup", function (e) {
    if (e.which === 13) {
        $('#search').click();
        $('#btnSearch').click();
        $('#search_shipment').click();
    }
});

//tắt auto complete
$("input").attr('autocomplete','off');

</script>
</body>
</html>