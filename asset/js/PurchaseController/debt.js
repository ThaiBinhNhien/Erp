$(document).ready(function() {
var thisWindow;



    $('#getValueMonth').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy/mm',    
        onChangeMonthYear: function(year, month, widget) {
            setTimeout(function() {
               $('.ui-datepicker-calendar').hide();
            });
    	},
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    }).click(function(){
    	$('.ui-datepicker-calendar').hide();
    }).attr('readonly','readonly');
});

$(document).on("click","#btnReport", function(){
    var value = $("input:radio[name=content]:checked").val();
    var valueDateImport = $("#getValueMonth").val();
    var dateDeliveryFrom = $("#getValueDeliveryFrom").val();
    var dateDeliveryTo = $("#getValueDeliveryTo").val();
    var getPlaceBuy = $("#getValuePlaceBuy").find(":selected").val();
    var getPlaceSale = $("#getValuePlaceSale").find(":selected").val();

    if(valueDateImport == '') { 
        $(this).helloWorld(message_error_not_select_date_import_inventory);
    } else {
        if(value == 1) {
            var getUrl = Our_Accounts_Payable_Details.split("?")[0];
            getUrl = getUrl + '?date_from=&date_to=&product_type=&report=1' + '&date_delivery_from=' + dateDeliveryFrom + 
            '&date_delivery_to=' + dateDeliveryTo + '&date_month=' + valueDateImport + '&place_buy=' + getPlaceBuy + '&place_sale=' + getPlaceSale +'&print=false';
            window.open(getUrl, '_blank');
        } else if(value == 2) {
            var getUrl = Our_Accounts_Payable_Details.split("?")[0];
            getUrl = getUrl + '?date_from=&date_to=&product_type=&report=2' + '&date_delivery_from=' + dateDeliveryFrom + 
            '&date_delivery_to=' + dateDeliveryTo + '&date_month=' + valueDateImport + '&place_buy=' + getPlaceBuy + '&place_sale=' + getPlaceSale +'&print=false';
            window.open(getUrl, '_blank'); 
        } else {
            var getUrl = url_check_price.split("?")[0];
            var getTypeReport = $("#check_moneybill").find(":selected").val();
            var getPlaceBuyName = $("#getValuePlaceBuy").find(":selected").text();
            var getPlaceSaleName = $("#getValuePlaceSale").find(":selected").text();
            getUrl = getUrl + '?date_delivery_from=' + dateDeliveryFrom + 
            '&date_delivery_to=' + dateDeliveryTo + '&date_month=' + valueDateImport 
            + '&place_buy=' + getPlaceBuy + '&place_buy_name=' + getPlaceBuyName + '&place_sale=' + getPlaceSale + '&place_sale_name=' + getPlaceSaleName +'&type_report' + getTypeReport;
            window.open(getUrl, '_blank');
        }
    }
});

$(document).on("change","input:radio[name=content]", function(){
    var value = $(this).val();
    if(value == 1) {
        $('#getValuePlaceSale').val("");
        $('#getValuePlaceBuy').val("");
        $('#getValuePlaceSale').prop('disabled', true);
        $('#getValuePlaceBuy').prop('disabled', false);
    } else if(value == 2) {
        $('#getValuePlaceSale').val("");
        $('#getValuePlaceBuy').val("");
        $('#getValuePlaceSale').prop('disabled', false);
        $('#getValuePlaceBuy').prop('disabled', true);
    } else {
        $('#getValuePlaceSale').val("");
        $('#getValuePlaceBuy').val("");
        $('#getValuePlaceSale').prop('disabled', false);
        $('#getValuePlaceBuy').prop('disabled', false);
    }
});