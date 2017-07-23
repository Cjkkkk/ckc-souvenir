
 $(document).ready(function () {
    $.ajax({
        url: 'http://sale.ckcsu.com/api/getpersoninfo',// getpersonalinf
        type: "GET",
        xhrFields: {
            withCredentials: true
        },
         
        
       dataType:"json",

        success: function (jsondata) {

            if (jsondata.status == "T") {
                 
                 $("#check-in").before('<a class="popup-with-zoom-anim" href="#" id="success-login"></a>'); 
                 $("#check-in").remove();
                 $("#success-login").html(jsondata.data.name+'/注销');


            }
        },
        error: function (jsondata) {
            console.log(jsondata);
        }

    })






    //新元素绑定事件

$("#change").on("click","#success-login",function(){
     
        $.ajax({
        url: 'http://sale.ckcsu.com/api/logout',// logout
        type: "GET",
        xhrFields: {
            withCredentials: true
        },

            dataType:"json",
        success: function (data) {
            if (data.status == 'T') {
               
                 $("#success-login").replaceWith('<a class="popup-with-zoom-anim" href="#注册" id="check-in">登录/注册</a>');
                 swal("注销成功", "你已经安全注销啦~", "success");
                  setTimeout(function () {window.location = 'home.html'; }, 2000);
            }
        },
        error: function (data) {
            console.log(data);
        }
    })
    });





//特殊处理一些按钮的样式

    $("#form-register").hide();
       
        $("#register").click(function(){
          $("#sign-in").toggle("slow");
           $("#form-register").toggle("slow");

        });

         $("#goback").click(function(){
          $("#sign-in").toggle("slow");
           $("#form-register").toggle("slow");

        });





    //登录


    $("#login").click(function () {

        console.log($("#username").val(), $("#password").val());
        $.ajax({
            url: 'http://sale.ckcsu.com/api/login ',
            type: "POST",
            xhrFields: {
                withCredentials: true
            },
            data: {
                "email": $("#email").val(),
                "password": $("#password").val()
            },
 //
            dataType:"json",
 //
            success: function (data) {
                console.log(data.status)
                if (data.status == 'T') {
                    swal("登录成功",data.message, "success");
                   location.reload();

                } else {
                    swal("登录失败",data.message, "error");
                }
                console.log(data);
            },
            error: function (data) {
                swal("登录失败", "未知错误", "error");
                console.log(data);
            }

        })
    });
//注册
    $("#registerr").click(function () {
    	var str1=$("#password-for-register").val();
    	var str2=$("#confirmation").val();
    	var str3=$("#email-for-register").val();
    	var str4=$("#telephone").val();
        var str5=$("#address").val();
        var str6=$("#name").val();
        if (str1.length==0||str2.length==0||str3.length==0||str4.length==0||str5.length==0||str6.length==0) {
                  swal("注册失败","个人信息未填写完整","error");
        }
        else{

        if (str1!=str2) {
            swal("注册失败", "密码两次输入不一致", "error");

        }
        else{
        
       
       
        $.ajax({
            url: 'http://sale.ckcsu.com/api/register',
            type: "POST",
            xhrFields: {
                withCredentials: true
            },
            data: {
                "email": $("#email-for-register").val(),
                "name":$("#name").val(),
                "password": $("#password-for-register").val(),
                "confirmation":$("#confirmation").val(),
                "telephone":$("#telephone").val(),
                "address":$("#address").val()
            },

            dataType:"json",
            success: function (data) {
                if (data.status == 'T') {
                    
                    swal("注册成功", data.message, "success");
                    setTimeout(function () {window.location = 'home.html'; }, 2000);

                    
                } else {
                    swal("注册失败", data.message, "error");
                }
                console.log(data);
            },
            error: function (data) {
                swal("登录失败", "未知错误", "error");
                console.log(data);
            }


           })
         }
        }
        
    });


})

