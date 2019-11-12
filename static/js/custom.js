$(document).ready(function(){
    $.material.init();
    $(document).on("submit","#reset",function(e){
        e.preventDefault();
        var form=$('#reset').serialize();
        $.ajax({
            url:'/forgot',
            type:'POST',
            data:form,
            success:function(response){
                if(response=="success"){
                    $("#emessage").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Check Your Email For Password Reset Link</strong></div>");
                }else if(response=="no_exist"){
                    $("#emessage").html("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>User with Such Email Does Not Exist</strong></div>");
                }else{
                    $("#emessage").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!!!Could Not send the Email</strong></div>");
                }
            }
        });
    });
    $(document).on("submit","#login_form",function(e){
        e.preventDefault();
        var form=$("#login_form").serialize();
        $.ajax({
            url:'/login',
            type:'POST',
            data:form,
            success:function(response){
                if(response=="error"){
                    $("#status_bar").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Login Failure!</strong>Please Provide Correct Details</div>");
                }
                else{
                    $("#status_bar").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Success!Redirecting to Dashboard</strong></div>");
                    function redirect(){
                        window.location.href="/home";
                    }
                    setTimeout(redirect, 1000);
                }
            }
        });
    });
    $(document).on("submit","#register-form",function(event){
        event.preventDefault();
        var form=$("#register-form").serialize();
        $.ajax({
            url:'/reg',
            type:'POST',
            data:form,
            success:function(response){
                if(response=="pass_no_match"){//for the passwords do not match
                    $("#error").html("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Passwords Do not Match</strong></div>");
                }else if(response=="success"){
                    $("#error").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Success!Please Login</strong></div>");
                    function redirect(){
                        window.location.href="/";
                    }
                    setTimeout(redirect, 4000);
                }else if(response=="exists"){
                    $("#error").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>The Username,Email,id_number or Phone has been registered, Try again</strong></div>");
                }
            }
        });
    });
    $(document).on('submit','#passres',function(e){
        e.preventDefault();
        var form=$("#passres").serialize()
        $.ajax({
            url:'/pchange',
            type:'POST',
            data:form,
            success:function(res){
                if(res=="success"){
                    $("#rmessage").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>The Password Has Been Updated</strong></div>");
                    $("#form").val().text("");
                }else if(res=="error_old"){
                    $("#rmessage").html("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Enter the Correct Old Password</strong></div>");
                }else{
                    $("#rmessage").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!!!The New Passwords do not Match</strong></div>");
                }
            }
        });
    });
    $(document).on('submit','#school',function(e){
        e.preventDefault();
        var form=$("#school").serialize();
        $.ajax({
            url:'/schoolname',
            type:'POST',
            data:form,
            success:function(e){
                if(e=="success"){
                   window.location='/school';
                }else{
                    $("#rmessage").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!!!Update Failed</strong></div>");
                }
            }
        })
    })
    $(document).on('submit','#contact',function(e){
        e.preventDefault();
        var form=$("#contact").serialize()
        $.ajax({
            url:'/schoolcont',
            type:'POST',
            data:form,
            success:function(res){
                if(res=="success"){
                    window.location="/school";
                 }else{
                     $("#rmessage").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!!!Update Failed</strong></div>");
                 }
            }
        })
    })
    $(document).on('submit','#pobox',function(event){
        event.preventDefault()
        var form=$("#pobox").serialize();
        $.ajax({
            url:'/post',
            type:'POST',
            data:form,
            success:function(e){
                if(e=="success"){
                    window.location="/school";
                 }else{
                     $("#rmessage").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!!!Update Failed</strong></div>");
                 }
            }
        })
    });
    /*----------------------------------Contact form----------------------------------------*/
    /*----------------------------------Start Holiday Form----------------------------------------*/
    $(document).on('submit','#holiday',function(e){
        e.preventDefault();
        var form=$('#holiday').serialize();
        $.ajax({
            url:'/hol',
            type:'POST',
            data:form,
            success:function(e){
                if(e=="success"){
                    //$("#rmessage").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Success!!!Holiday Added</strong></div>");
                    window.location="/holiday";
                }else{
                    $("#rmessage").html("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!!!Holiday Not Added</strong></div>");
                }
            }
        })
    });
    /*----------------------------------End Holiday Form----------------------------------------*/
});
