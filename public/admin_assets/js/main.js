$('#LoginForm').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا ادخال المعلومات لتسجيل الدخول</div>");
     }
     return res; 
});



$('#createuser').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا ادخال المعلومات المطلوبة</div>");
     }
     return res; 
});
    


$('#passwordRecoverForm').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#resultRecover').html("<div class='alert alert-danger'>المرجوا ادخال بريدك الإلكتروني</div>");
     }
     return res; 
});


$('#AdminGeneralInfo').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>لا يمكن ترك الحقول فارغة</div>");
     }
     return res; 
});




$('#AdminPasswords').submit(function() {
     var res = true;
     var eempty = false;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             eempty =true;
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(eempty == true){
         $('#resultpassword').html("<div class='alert alert-danger'>لا يمكن ترك الحقول فارغة</div>");
     }
     
    var new_pass = $('#new_pass').val();
    var new_pass_re = $('#new_pass_re').val();
    
    if(new_pass != new_pass_re) {
        res = false; 
       $('#resultpassword').html("<div class='alert alert-danger'>كلمتا المرور غير متطابقتين</div>");
    }
     return res; 
});




$('#ResetPasswordsForm').submit(function() {
     var res = true;
     var eempty = false;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             eempty =true;
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(eempty == true){
         $('#resultpassword').html("<div class='alert alert-danger'>لا يمكن ترك الحقول فارغة</div>");
     }
     
    var new_pass = $('#password').val();
    var new_pass_re = $('#confirmPassword').val();
    
    if(new_pass != new_pass_re) {
        res = false; 
       $('#resultpassword').html("<div class='alert alert-danger'>كلمتا المرور غير متطابقتين</div>");
    }
     return res; 
});










$('#CreateMenu').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا اضافة اسم القائمة</div>");
     }
     return res; 
});







$('#createPostCategory').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا اضافة اسم التصنيف ورابط التصنيف</div>");
     }
     return res; 
});



$('#generalSettings').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا ملأ الحقول المطلوبة</div>");
     }
     return res; 
});




$('#ShowLoginForm').click(function() {
    $('#passwordRecoverForm').hide();
    $('#LoginForm').show();
});

$('#ShowforgetForm').click(function() {
    $('#LoginForm').hide();
    $('#passwordRecoverForm').show();
});




$('#createProductCategory').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>المرجوا اضافة اسم التصنيف ورابط التصنيف</div>");
     }
     return res; 
});
    






$('#user_form').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>لا يمكن ترك الحقول المطلوبة فارغة</div>");
     }
     return res; 
});
    



$('#sendemail').submit(function() {
     var res = true;
     $(".frequired",this).each(function() {
         if($(this).val().trim() == "") {
             res = false; 
             $(this).addClass('errorFiled');
         }else{
             $(this).removeClass('errorFiled');
         }
     })
     if(res == false){
         $('#result').html("<div class='alert alert-danger'>لا يمكن ترك الحقول المطلوبة فارغة</div>");
     }
     return res; 
});
    











