function validateSubmit() {
    var id = $("input[name="+u_id+"]").val();
    var pass = $("input[name="+u_password+"]").val();
    var confPass = $("input[name=confirm-password]").val();
    if(!id) {
        alert(invalid_user_registration);
        return false;
    }
    if(pass && pass != confPass) {
        alert(password_not_match);
        return false;
    }
};
if(message != '') {
    jQuery("#forNotification").helloWorld(message,null);
}