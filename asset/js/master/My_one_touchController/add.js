// Click to Add
$(document).on("click","#btnAdd",function(){
    $('#my_one_touch_customer').val("");
    $('#my_one_touch_department').val("");
    $('#my_one_touch_product').val("");
    $('#my_one_touch_quantity').val("");
    $('#my_one_touch_container').val("");
    $('#my_one_touch_container2').val("");
    $('#my_one_touch_comment').val("");
    $('#myModalProductAdd').modal("show");
});

// Add 
$(document).on("click","#btnAddProductDetail", function(){

    // Setting validation
    $("#form_add_product_detail").validate({
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - 50
            }, 800);
        }
    });

    $('#my_one_touch_quantity').rules('add', { 
        number: true,
        min: 0 
    });

    $('#my_one_touch_container').rules('add', { 
        number: true,
        min: 0 
    });

    $('#my_one_touch_container2').rules('add', { 
        number: true,
        min: 0 
    });

    $('#my_one_touch_customer').rules('add', { required: true });
    $('#my_one_touch_department').rules('add', { required: true });
    $('#my_one_touch_product').rules('add', { required: true });

    $('#my_one_touch_customer').tooltip({ 
        trigger: 'manual',
        placement:'top'
    });
    $('#my_one_touch_department').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('#my_one_touch_quantity').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#my_one_touch_container').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#my_one_touch_container2').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#my_one_touch_product').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    //Show loading display here
    var form = $("#form_add_product_detail");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) { 
        return false;
    }

    var my_one_touch_customer = $('#my_one_touch_customer option:selected').val();
    var my_one_touch_customer_name = $('#my_one_touch_customer option:selected').text();
    var my_one_touch_department = $('#my_one_touch_department option:selected').val();
    var my_one_touch_department_name = $('#my_one_touch_department option:selected').text();
    var my_one_touch_product = $('#my_one_touch_product').val();
    var my_one_touch_product_name = $('#inputpicker-1').val();
    var my_one_touch_quantity = $('#my_one_touch_quantity').val();
    var my_one_touch_container = $('#my_one_touch_container').val();
    var my_one_touch_container2 = $('#my_one_touch_container2').val();
    var my_one_touch_comment = $('#my_one_touch_comment').val();

    var html = "";
    html += '<tr data-customer="'+my_one_touch_customer+'" data-department="'+my_one_touch_department+'" data-product="'+my_one_touch_product+'" data-quantity="'+my_one_touch_quantity+'" data-container="'+my_one_touch_container+'" data-container2="'+my_one_touch_container2+'" data-comment="'+my_one_touch_comment+'">';
    html += '<td>'+my_one_touch_customer_name+'</td>';
    html += '<td>'+my_one_touch_department_name+'</td>';
    html += '<td>'+my_one_touch_product_name+'</td>';
    html += '<td><input class="form-control my_one_touch_quantity" type="number" value="'+my_one_touch_quantity+'"></td>';
    html += '<td><input class="form-control my_one_touch_container" type="number" value="'+my_one_touch_container+'"></td>';
    html += '<td><input class="form-control my_one_touch_container2" type="number" value="'+my_one_touch_container2+'"></td>';
    html += '<td><input class="form-control my_one_touch_comment" type="number" value="'+my_one_touch_comment+'"></td>';
    html += '<td><a class="btnDeleteProduct"><img src="'+urlImage+'del.png"/></a></td>';
    html += '</tr>';

    $('#list-table tbody').append(html);
});

// Click Delete
$(document).on("click", ".btnDeleteProduct", function(){
    $(this).parent().parent().remove();
});

// Click to save
$(document).on("click","#onClickAdd", function(){
    // Setting validation
    $("#box-form").validate({
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - 50
            }, 800);
        }
    });

    $('#form_id').rules('add', VALIDATION_ID);
    $('#form_name').rules('add', { required: true });
    $('#t_my_one_touch_username').rules('add', { required: true });
    $('#t_my_one_touch_classification').rules('add', { required: true });

    $('#form_id').tooltip({
        trigger: 'manual',
        placement:'top'
    });
    $('#form_name').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#t_my_one_touch_username').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });
    $('#t_my_one_touch_classification').tooltip({
        trigger: 'manual',
        placement:'bottom'
    });

    //Show loading display here
    var form = $("#box-form");

    // Validation
    var validator = form.data("validator");
    if (!validator || !form.valid()) {
        return false;
    }

    // Add
    var username = $("#t_my_one_touch_username option:selected").val();
    var classification = $("#t_my_one_touch_classification option:selected").val();
    var form_name = $('#form_name').val();
    var form_id = $('#form_id').val();
    var detail = [];
    $('#list-table tbody tr').each(function(){
        var customer = $(this).data("customer");
        var department = $(this).data("department");
        var product = $(this).data("product");
        var quantity = $(this).find(".my_one_touch_quantity").val();
        var container = $(this).find(".my_one_touch_container").val();
        var container2 = $(this).find(".my_one_touch_container2").val();
        var comment = $(this).find(".my_one_touch_comment").val();

        detail.push({
            "customer":customer,
            "department":department,
            "product":product,
            "quantity":quantity,
            "container":container,
            "container2":container2,
            "comment":comment,
        });
    });

    if(detail.length <= 0) {
        $(this).helloWorld("商品は必須です。ご入力ください。");
        return false;
    }
    
    // Ajax Add
    $(this).helloWorld(message_confirm_save_field ,urlIndex,null,
        {
            url:addMyOneTouchDetail,
            data:{form_id:form_id,form_name:form_name,classification:classification,username:username,detail:detail},
            error_message:message_error_ajax,
            is_master: true
        }
    );
});

$(document).on("change", "#my_one_touch_customer", function(){
    var customer_id = $(this).val();
    $("input#my_one_touch_product").inputpicker({
        width:'250px',
        url: get_product_selectbox,
        urlParam : {"type_product":2,"customer_shipment":customer_id},
        fields:[{"name":"販売商品コード", "text":"売上商品コード"}, {"name":"販売商品名", "text":"売上商品名"}],
        fieldText:'販売商品コード',
        fieldValue:'商品ID',
        filterOpen: true,
        autoOpen: true,
        headShow: true,
        pagination: true,   // false: no
        pageMode: '',  // '' or 'scroll'
        pageField: 'p',
        pageLimitField: 'per_page',
        limit: PAGE_SIZE_SELECTBOX,
        pageCurrent: 1,
    });

    if(customer_id == '' || customer_id == null){
        $("#my_one_touch_department").html("");
        return;
    }
    $.ajax({
        url:getDepartmentByCustomer,
        data:{customer_id:customer_id},
        dataType:'json',
        method:'GET',
        success:function(result){
            var option = '<option value=""></option>';
            if(result != null){
                for(var i=0;i<result.length;i++){
                    option += '<option value="'+result[i]['department_id']+'">'+result[i]['department']+'</option>';
                }
            }
            $("#my_one_touch_department").html(option);
        }
    });
});