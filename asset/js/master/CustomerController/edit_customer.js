
$(document).ready(function(){
      $("#save").click(function(){
            if($("#department").val() == null){
              $('#save').helloWorld('部署を選択してください。',null);
                  return false;
            }
            if(raiseValidate() == false)
                  return false;
            var data = {};
            data.id = cusId;
            data.name = $("#name").val();
            data.user = $("#user").val();
            data.end_code = $("#end_code").val();
            data.address1 = $("#address1").val();
            data.address2 = $("#address2").val();
            data.phone_number = $("#phone_number").val();
            data.fax = $("#fax").val();
            data.classification = $("#classification").val();
            data.username = $("#username").val();
            data.password = $("#password").val();
            var departmentList = new Array();
            $("#detail>tr").each(function(){
              var item = new Array(
                $(this).find(".id_dp").val(),
                ($(this).find(".not_ask_money").is(":checked") == true?1:0),
                $(this).find("#user").val(),
                ($(this).find(".flag").is(":checked") == true?1:0)
              );
              departmentList.push(item);
              
            })
            if(departmentList.length == 0) 
              return;
            data.department = departmentList;
            $('#save').helloWorld('保存します。よろしいですか？',viewUrl,null,{url:editUrl,data:data,error_message:''});
      })
      function raiseValidate(){
            if($('#form').valid() && $('#form').data("validator")){
                  return true;
            }
            return false;
      }
      /*$("#user").change(function(){
        var username = $(this).val();
        $.ajax({
          url:checkProductTypeUrl,
          data:{'username':username},
          method:"get",
          dataType:"json",
          success:function(result){
            if(result == 1){
              $("#username").parent().parent().parent().css("display","none");
              $("#username").data("have-account","0");
              $("#password").parent().parent().parent().css("display","none");
              $("#password").data("have-account","0");

            }else{
              $("#username").parent().parent().parent().css("display","block");
              $("#username").data("have-account","1");
              $("#password").parent().parent().parent().css("display","block");
              $("#password").data("have-account","1");
            }
          }
        })
      })*/
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
            html += '<td width="15%"><input type="hidden" class="id_dp" value="'+$(this).find(".id_dp").val()+'" />'+$(this).find(".id_dp").val()+'</td>';
            html += '<td>'+$(this).find("td:eq(1)").text()+'</td>';
            html += '<td width="15%"><input type="checkbox" class="not_ask_money"></td>';
            html += '<td width="15%" style="padding:4px 4px 0px 4px " >';
            html += '<select class="form-control" style="margin-bottom:4px " name="user"  id="user">';
            for(var i=0;i<lstUser.length;i++){
              html += '<option>' + lstUser[i]['id'] + '</option>';
            }
            
            html += '</select></td>';
            html += '<td width="24%"><input type="checkbox" class="flag" name="flag" ></td>';
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
            html += '<td width="15%"><input type="hidden" class="id_dp" value="'+$(this).find(".id_dp").val()+'" />'+$(this).find(".id_dp").val()+'</td>';
            html += '<td>'+$(this).find("td:eq(1)").text()+'</td>';
            html += '<td width="15%"><input type="checkbox" class="not_ask_money"></td>';
            html += '<td width="15%" style="padding:4px 4px 0px 4px " >';
            html += '<select class="form-control" style="margin-bottom:4px " name="user"  id="user">';
            for(var i=0;i<lstUser.length;i++){
              html += '<option>' + lstUser[i]['id'] + '</option>';
            }
            
            html += '</select></td>';
            html += '<td width="24%"><input type="checkbox" class="flag" name="flag" ></td>';
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
      $('#department').bootstrapDualListbox(config_duallistbox);
      $("#form").validate({
            rules : {
            	name:{
            		required:true,
            	},
            	short_name:{
            		required:true
            	},
            	reading:{
            		required:true
            	},
            	user:{
            		required:true
            	},
                  end_code:{
                        required:true
                  },
                  address1:{
                        required:true
                  },
                  address2:{
                        required:true
                  },
                  phone_number:{
                        required:true,
                        isPhoneNumber:true
                  },
                  fax:{
                        required:true,
                        isPhoneNumber:true
                  },
                  department:{
                        required:true
                  }
            },
            tooltip_options: {  // <- totally invalid option
		        name: {
		            placement: 'top',html:true
		        },
		        short_name: {
		            placement: 'top'
		        },
		        reading: {
		            placement: 'top'
		        },
            	 user:{
            		placement: 'bottom'
            	 },
                   end_code:{
                        placement: 'right'
                   },
                   address1:{
                        placement: 'right'
                   },
                   address2:{
                        placement: 'bottom'
                   },
                   phone_number:{
                        placement: 'bottom'
                   },
                   fax:{
                        placement: 'bottom'
                   },
            	 department:{
                        placement: 'top'
                   }
        },
        invalidHandler: function(form, validator) {
          if (!validator.numberOfInvalids())
            return;
  
          $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top - 50
          }, 800);
        }
      });
});
