// Validation Sử dụng chung
var VALIDATION_ID = { 
    required: true,
    number: true, 
    min: 0,
    max: 2147483647,
};
//validateion phải là số dương.
var VALIDATION_POSITIVE = { 
    number: true, 
    min: 0,
    max: 2147483647,
};
var VALIDATION_ID_BUY_SELL = { 
    number: true, 
    min: 0,
    maxlength:50
};
// Cứ điểm
var VALID_BASE_BM_BASE_NAME = { 
    required: true,
    maxlength: 50,
};
var VALID_BASE_BM_COMPANY_NAME = { 
    required: true,
    maxlength: 50, 
};
var VALID_BASE_BM_PAYEE_1_BANK_NAME = { 
    required: true,
    maxlength: 20,
 };
var VALID_BASE_BM_PAYEE_1_BRANCH_NAME = { 
    required: true,
    maxlength: 20,
};
var VALID_BASE_BM_PAYEE_1__ACCOUNT_NUMBER = {  
    required: true,
    maxlength: 7,
};
var VALID_BASE_BM_TRANSFER_DESTINATION_ACCOUNT_CLASSIFICATION = {
    min: -32768,
    max: 32767,
};
var VALID_BASE_BM_NAME_MAXLENGTH20 = {
    maxlength: 20,
};
var VALID_BASE_BM_NAME_MAXLENGTH7 = {
    maxlength: 7,
};
var VALID_BASE_BM_PHONE_NUMBER = {
    isPhoneNumber: true,
    maxlength: 20
}
var VALID_BASE_BM_FAX_NUMBER = {
    isPhoneNumber: true,
    maxlength: 20
}

// Phòng ban
var VALID_DEPARTMENT_CREATE_NAME = {
    required:true,
};

// User
var VALID_USER_USERNAME = {
    required: true
};
var VALID_USER_NAME = {
    required: true
};
var VALID_USER_PASS = {
    required: true
};
var VALID_USER_PASSCONFIRM = {
    required: true
};
var VALID_USER_BASE = {
    required: true
};
var VALID_USER_TEL = {
    isPhoneNumber: true,
    maxlength: 20
};

// Chuyển phát nhanh
var VALID_SM_COURIER_NAME = {
    required: true
}
var VALID_SM_COURIER_TRUCK = {
    required: true,
    number: true,
    min: 0,
    max: 2147483647  
}
var VALID_SM_COURIER_CONTAINER = {
    required: true,
    number: true,
    min: 0,
    max: 2147483647 
}
var VALID_SM_COURIER_MAX_TRUCK = {
    required: true,
    number: true,
    min: 0,
    max: 2147483647
}


//check phone
$.validator.addMethod("isPhoneNumber",function(value, element){
    if(value == "" || value.trim() ==""){
        return true;
    }
    return CheckTextIsPhone(value);
});
function isPhone(value){
     value = String(value);
     //10+3=13
    // alert('lenght=' + value.length);
     if(value.length>14){
      return false;
     }

     var patern = /^0/g;
     var beginZero = value.match(patern);
     if(beginZero == null || beginZero.length != 1){
      return false;
     }
     patern = /((?![\d-\s]+).)*/g;
     var isNumber = value.match(patern);
     isNumber = isNumber.filter(function(e){return e!=""}); 
     if(isNumber != null && isNumber.length != 0){
      return false;
     }
     patern = /\d/g;
     var numbers = value.match(patern);
     if(numbers == null || numbers.length > 11 || numbers.length <10){
      return false;
     }
     patern = /-/g;
     var chars1 = value.match(patern);
     if(chars1 != null && chars1.length>3){
      return false;
     }
     patern = /\s/g;
     var chars2 = value.match(patern);
     if(chars2 != null && chars2.length>3){
      return false;
     }
     if(chars1 != null && chars1.length !=0 && chars2 != null && chars2.length != 0){
      return false;
     }
     return true;
}
function CheckTextIsPhone(value){
     var indexChar = value.indexOf(',');
     if(indexChar<0){
      return isPhone(value);
     }else{
      var start_index = 0;
      while(true){
       var phone = null;
       if(indexChar > 0){
        phone = value.substring(start_index,indexChar);
       }else{
        phone = value;
       }
       if(!isPhone(phone)){
        return false;
       }
       if(indexChar < 0){
        break;
       }
       value = value.substring(indexChar+1);
       indexChar = value.indexOf(',');
      }
      
     }
     return true;
};



//check fax.

$.validator.addMethod("isPostal",function(value, element){
        if(value == "" || value.trim() ==""){
                return true;
        }
        value = String(value);
         if(value.length>8){
          return false;
         }
         var patern = /\d/g;
         var numbers = value.match(patern);
         if(numbers == null || numbers.length != 7){
          return false;
         }
         patern = /(-|\s)/g;
         var chars = value.match(patern);
         if(chars != null && chars.length>1){
          return false;
         }
         return true;
});