$(document).ready(function() {
    $("#checklist_table").DataTable( {
        "scrollY":        "360px",
        "scrollCollapse": true,
        "paging":         false,
        responsive: true,
        searching: false, paging: false,
        "ordering": false,
        "info":     false
    });
});

$(document).on("click","#btnSave", function(){
    var data = [];
    $("#checklist_table").find(".btn_checkprice:checked").each(function(item){
        data.push($(this).data("id"));
    })

    // Data
    if(data.length > 0){
        $.ajax({
            url:checkListUrl,
            data:{data:data},
            dataType:"json",
            method:"POST",
            success:function(result){
                if(result.success == true){
                    var url = window.location.href;
                    $(this).helloWorld(message_success_select_check_price,url);
                }
            }
        });
    }
    else{
        $(this).helloWorld(message_not_select_check_price,null);
    }

    return false;
});

// Check all
$(document).on("click","#checkAll",function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
});

// PDF
$(document).on("click","#btnPrintPdf",function () {
    var getUrl = url_pdf_check_price.split("?")[0];
    getUrl = getUrl + '?date_delivery_from=' + dateDeliveryFrom + 
    '&date_delivery_to=' + dateDeliveryTo + '&date_month=' + valueDateImport 
    + '&place_buy=' + getPlaceBuy + '&place_buy_name=' + getPlaceBuyName + '&place_sale=' + getPlaceSale + '&place_sale_name=' + getPlaceSaleName +'&type_report' + getTypeReport;
    window.open(getUrl, '_blank');
});
