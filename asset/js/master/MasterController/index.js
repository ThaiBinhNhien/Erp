
// Click radio
$(document).on("change","input[name=data]", function(){
    var value = $(this).val();
    if(value == "master") {
        $('#value_url_master').prop( "disabled", false );
        $('#clickExportCSV').prop( "disabled", false );
    } else {
        $('#value_url_master').prop( "disabled", true );
        $('#clickExportCSV').prop( "disabled", true );
    }

    if(value == "production") {
        $('#production_data').prop( "disabled", false );
    } else {
        $('#production_data').prop( "disabled", true );
    }
}); 

// Click Import
$('#formImportCsv').on("submit", function(e){  
    e.preventDefault();
    var value = $("input[name=data]:checked").val();
    if(value == "master") {
        var value_url_master = $('#value_url_master option:selected').val();   
        var getUrl = value_url_master + "/import";

        $.ajax({  
            url:getUrl,  
            method:"POST",  
            data:new FormData(this),  
            contentType:false,
            cache:false,
            processData:false, 
            success: function(data){  
                var result = JSON.parse(data);
                if(result.success == true) {
                    $(this).helloWorld(result.message);
                } else {
                    $(this).helloWorld(result.message);
                }
            }
        });
    } else {
        $.ajax({  
            url:url_import_csv,  
            method:"POST",  
            data:new FormData(this),  
            contentType:false,
            cache:false,
            processData:false, 
            success: function(data){  
                var result = JSON.parse(data);
                if(result.success == true) {
                    $(this).helloWorld(result.message);
                } else {
                    $(this).helloWorld(result.message);
                }
            }
        });
    }
});

// Click Export
$(document).on("click","#clickExportCSV", function(){
    var value_url_master = $('#value_url_master option:selected').val();
    var value_type = $('#value_url_master option:selected').data('type');   
    var getUrl = value_url_master + "/export?type="+value_type;
    window.open(getUrl);
});

// change value_url_master
$(document).on("change","#value_url_master", function(){
    var value_type = $(this).find('option:selected').data('type');
    $('#get_type_csv').val(value_type);
});