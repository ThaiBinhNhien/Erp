
$(document).ready(function(){
      $("#save").click(function(){
         var detail = getDetail();
            if(detail.length == 0){
              $('#save').helloWorld('部署を選択してください。',null);
                  return false;
            }
            if(raiseValidate() == false)
                  return false;
            var data = {};
            data.id = $("#id").val();
            data.user = $("#user").val();
            data.name = $("#name").val();
            data.display_name = $("#display_name").val();
            data.address = $("#address").val();
            data.address2 = $("#address2").val();
            data.post_office = $("#post_office").val();
            data.phone = $("#phone").val();
            data.fax = $("#fax").val();
            data.closing_date = $("#closing_date").val();
            data.aggregate = $("#aggregate").is(":checked") == true?1:0;
            data.collection_ouput = $("#collection_ouput").val();
            data.fixed_amount = $("#fixed_amount").val();
            data.discount = $("#discount").val();
            data.tax_check = $("#tax_check").is(":checked") == true?1:0;
            data.tax = $("#tax").val();
            data.environment_fee_check = $("#environment_fee_check").is(":checked") == true?1:0;
            data.environment_fee = $("#environment_fee").val();
            data.detail = detail;
            $('#save').helloWorld('注文伝票（新規）を保存します。よろしいですか？',viewUrl,null,{url:createUrl,data:data,error_message:''});
      })
      function raiseValidate(){
            if($('#form').valid() && $('#form').data("validator")){
                  return true;
            }
            return false;
      }
      function getDetail(){
        var data = new Array();
        $("#detail>tr").each(function(){
           var item = {
              'id_dp':$(this).find("td:eq(0) .id_dp").val(),
              'type': $(this).find(".type").val()
           };
           data.push(item);
        });
        return data;
      }
      $("#customer").change(function(){
        var val = $(this).val();
        $.ajax({
          url:cuspartUrl,
          data:{customer_id:val},
          method:"GET",
          dataType:"json",
          success:function(result){
            if(result != null){
              var html = '';
              for(var i=0 ; i<result.length;i++){
                html += '<tr>';
                html += '<td><input type="hidden" class="id_dp" value="'+result[i]['id']+'" />'+result[i]['department_id']+'</td>';
                html += '<td>'+result[i]['department']+'</td>';
                html == '</tr>';
              }
              $('#department').html(html);
              $("#detail").html('');
            }
          }
        })
      });
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
            html += '<td><input type="hidden" class="id_dp" value="'+$(this).find(".id_dp").val()+'" />'+$(this).find("td:eq(0)").text()+'</td>';
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
            html += '<td><input type="hidden" class="id_dp" value="'+$(this).find(".id_dp").val()+'" />'+$(this).find("td:eq(0)").text()+'</td>';
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
            html += '<td><input type="hidden" class="id_dp" value="'+$(this).find(".id_dp").val()+'" />'+$(this).find("td:eq(0)").text()+'</td>';
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
            html += '<td><input type="hidden" class="id_dp" value="'+$(this).find(".id_dp").val()+'" />'+$(this).find("td:eq(0)").text()+'</td>';
            html += '<td>'+$(this).find("td:eq(1)").text()+'</td>';
            html += '</tr>';
            $("#department").append(html);
          }
          
          $(this).remove();
        })
      })

      $("#form").validate({
            rules : {
              id:VALIDATION_ID,
            	name:{
            		required:true,
            	},
            	display_name:{
            		required:true
            	},
            	address:{
            		required:true
            	},
            	environment_fee:{
            		required:true
            	},
              tax:{
                required:true
              },
              tax:{
                number:true,
                min:0
              },
              environment_fee:{
                number:true,
                min:0
              },       
              user:{
                required:true,
              },
              tax:{
                number:true,
                min:0
              },
              discount:{
                number:true,
                min:0
              },
              fixed_amount:{
                number:true,
                min:0
              }
            },
            tooltip_options: {  // <- totally invalid option
		        name: {
		            placement: 'top',html:true
		        },
            display_name:{
              placement: 'top',html:true
            },
            address:{
              placement: 'bottom',html:true
            },
            environment_fee:{
               placement: 'right',html:true
            },
            tax:{
               placement: 'bottom',html:true
            },
            user:{
               placement: 'bottom',html:true
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
});
