$(document).on("click","#save", function(){

  // Setting validation
  $("#form_add_category").validate({
    invalidHandler: function(form, validator) {
if (!validator.numberOfInvalids())
  return;

$('html, body').animate({
  scrollTop: $(validator.errorList[0].element).offset().top - 50
}, 800);
}
});

  $('#group_name').rules('add', { required: true });
  $('#group_id').rules('add', VALIDATION_ID);
  $('#group_name').tooltip({
      trigger: 'manual',
      placement:'top'
  });
  $('#group_id').tooltip({
      trigger: 'manual',
      placement:'top'
  });

  //Show loading display here
  var form = $("#form_add_category");

  // Validation
  var validator = form.data("validator");
  if (!validator || !form.valid()) {
      return false;
  }

  // Add
  var id = $("#group_id").val();
  var name = $("#group_name").val();
  var customer = $('#group_customer option:selected');
  var customerList = [];
  $(customer).each(function(index, value){
    customerList.push($(this).val());
  });

  var departmentList = new Array();
  $("#detail>tr").each(function(){
    var item = $(this).find(".id_dp").val();
    departmentList.push(item); 
    
  });

  // Validation
  if(customerList.length < 1) {
    $(this).helloWorld("得意先は必須です。ご入力ください。");
  }
  if(departmentList.length < 1) {
    $(this).helloWorld("部署は必須です。ご入力ください。");
  }

  // Ajax Add
  $(this).helloWorld(message_confirm_save_field ,urlIndex,null,
    {
        url:addPostLink,
        data:{id:id,name:name,customer:customerList,department:departmentList },
        error_message:message_error_ajax,
        is_master: true
    }
  );
});


$(document).ready(function(){
      
      function raiseValidate(){
            if($('#form').valid() && $('#form').data("validator")){
                  return true;
            }
            return false;
      }
      
      $(document).on("click","#detail>tr",function(){
        $(this).css("cssText","background-color:#9fbfdf !important");
        $(this).addClass("chosen");
        $(this).siblings().css("cssText","background-color: white !important");
        $(this).siblings().removeClass("chosen");
      })
      $(document).on("click","#department>tr",function(){
        $(this).css("cssText","background-color:#9fbfdf !important");
        $(this).addClass("chosen");
        $(this).siblings().css("cssText","background-color: white !important");
        $(this).siblings().removeClass("chosen");
      })
      $("#right").click(function(){
        $("#department>tr.chosen").each(function(){
          if($("#detail").find(".id_dp[value="+$(this).find(".id_dp").val()+"]").length == 0  ){
            var html="<tr>";
            html += '<td width="20%"><input type="hidden" class="id_dp" value="'+$(this).find(".id_dp").val()+'" />'+$(this).find(".id_dp").val()+'</td>';
            html += '<td>'+$(this).find("td:eq(1)").text()+'</td>';
            html += '</tr>';
            $("#detail").append(html);
          }
          
          $(this).remove();
        })
      })

      $("#right_all").click(function(){
        $("#department>tr").each(function(){
          if($("#detail").find(".id_dp[value="+$(this).find(".id_dp").val()+"]").length == 0  ){
            var html="<tr>";
            html += '<td width="20%"><input type="hidden" class="id_dp" value="'+$(this).find(".id_dp").val()+'" />'+$(this).find(".id_dp").val()+'</td>';
            html += '<td>'+$(this).find("td:eq(1)").text()+'</td>';
            html += '</tr>';
            $("#detail").append(html);
          }
          
          $(this).remove();
        })
      })

      $("#left").click(function(){
        $("#detail>tr.chosen").each(function(){
          if($("#department").find(".id_dp[value="+$(this).find(".id_dp").val()+"]").length == 0  ){
            var html="<tr>";
            html += '<td width="20%"><input type="hidden" class="id_dp" value="'+$(this).find(".id_dp").val()+'" />'+$(this).find(".id_dp").val()+'</td>';
            html += '<td>'+$(this).find("td:eq(1)").text()+'</td>';
            html += '</tr>';
            $("#department").append(html);
          }
          
          $(this).remove();
        })
      })

      $("#left_all").click(function(){
        $("#detail>tr").each(function(){
          if($("#department").find(".id_dp[value="+$(this).find(".id_dp").val()+"]").length == 0  ){
            var html="<tr>";
            html += '<td width="20%"><input type="hidden" class="id_dp" value="'+$(this).find(".id_dp").val()+'" />'+$(this).find(".id_dp").val()+'</td>';
            html += '<td>'+$(this).find("td:eq(1)").text()+'</td>';
            html += '</tr>';
            $("#department").append(html);
          }
          
          $(this).remove();
        })
      })
      
});
