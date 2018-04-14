function validateSubmit() {
    var id = $("input[name="+u_id+"]").val();
    var pass = $("input[name="+u_password+"]").val();
    var confPass = $("input[name=confirm-password]").val();
    if(!id) {
        jQuery("#forNotification").helloWorld(invalid_user_registration,urlIndex);
        return false;
    }
    if(!pass || pass != confPass) {
        jQuery("#forNotification").helloWorld(password_not_match,null);
        return false;
    }
};
$("input[name="+u_id+"]").change(function(){
    var id = $("input[name="+u_id+"]").val();
    if(id != null && id != '') {
        $.ajax({
            url:'check-existed',
            data:{'id':$("input[name="+u_id+"]").val()},
            method:'POST',
            dataType:'json',
            success:function(response){
                if(response.result == 1) {
                    jQuery("#forNotification").helloWorld(user_already_existed,null);
                    $("input[name="+u_id+"]").focus();
                }
            },
            error:function(a,b,c){
                console.log(a,b,c);
            }
        })
    }
})
if(message != '') {
    jQuery("#forNotification").helloWorld(message,null);
}
