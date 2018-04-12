$(document).ready(function(){

    $("#load").hide();
    $("#submit").click(function(){
        $( "#load" ).show();
 
        var dataString = { 
            username : $("#username").val(),
            subject : $("#subject").val(),
            message : $("#message").val()
        };

        $.ajax({
            type: "POST",
            url: url_add_post_notification,
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
                $( "#load" ).hide();
                $("#username").val('');
                $("#subject").val('');
                $("#message").val('');

                if(data.success == true){
                    // Success
                    add_notification_realtime(data);
                } else if(data.success == false){
                    $("#username").val(data.username);
                    $("#subject").val(data.subject);
                    $("#message").val(data.message);
                    $("#notif").html(data.notif);
                }
        
            } ,error: function(xhr, status, error) {
            alert(error);
            },
        });
    });

});