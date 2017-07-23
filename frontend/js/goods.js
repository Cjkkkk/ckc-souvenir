

     $(document).ready(function(){
     	       
                
               
     	        $(".reply-body").slideUp();
             	
         
             $(".reply").click(function(){
                 $(this).next(".reply-body").slideToggle("slow");
             });
              $(".slide-up").click(function(){
              
                 $(this).parent(".reply-body").slideToggle("slow");
              });
                  
                










//获取评论功能
     $("#getcomment").click(function(){
                     $.ajax({
              
        url: 'http://sale.ckcsu.com/api/getcomment',// 获取评论
        // url: '../getcomment',
        type: "GET",
        xhrFields: {
            withCredentials: true
        }, 
      
        data:{  "goodsname":$("#goodsname").html(),
               
        	},
		   dataType:"json",
        success: function (data) {
                 
            if (data.status == 'T') {
                
                var total=data.data.length;

               
                var page_number;
                var state;
                if(total%5==0){
                    page_number=total/5;
                    state=1;
                }
                else{
                     page_number= ((total-total%5)/5+1);
                     state=2;
                }
                
                if(total<=5){
                    var need_move=5-total;
                    for(i=0;i<=need_move-1;i++){
                              console.log(i)
                             $(".li-container:eq(0)").remove();
                    }
                }
              
                
                  //填充评论功能 
                 
                
                  for(i=0;i<=4;i++){
                    
                         $(".username:eq("+i+")").html(data.data[i].name);
                        $(".comment-body:eq("+i+")").html(data.data[i].comment);
                        $(".time:eq("+i+")").html("发表于"+data.data[i].time);
                           //console.log(isNaN(i))
                        //  console.log(data.data[i].name) 
                        }
                  
                 






                   //修改数字功能

                   //到上一页面
             $("#min").click(function(){
             var number=$("#current").html();
             number=parseInt(number);
            if(number==page_number||number!=1)
             {
                location.reload() ; 
             }
                      if(number==1){
               
                 }
                else{
                   number=number-1;
                   $("#current").html(number);
                //刷新评论
                   var begin=(number-1)*5;
                   var end=begin+4;
                    var index=0;
                   for(i=begin;i<=end;i++){
                       $(".username:eq("+index+")").html(data.data[i].name);
                        $(".comment-body:eq("+index+")").html(data.data[i].comment);
                        $(".time:eq("+index+")").html("发表于"+data.data[i].time);
                           index++;
                           
                                         }
                    }
             
                
                });









           //到下一页

            $("#plus").click(function(){
             var number=$("#current").html();
             number=parseInt(number);
             
            if(number==page_number){
                
                 swal("获取失败", "已经没有更多信息", "error");
            }
            else{//刷新评论
                if(number+1==page_number){
                     number=number+1;
                    if(state==2){
                             var need_move=5-total%5;
                             for(i=0;i<=need_move-1;i++){
                             $(".li-container:eq("+i+")").remove();
                             //console.log(i)
                    }
                             
                    }


                $("#current").html(number);
                var begin=(number-1)*5;
                var end=begin+4;
                var index=0;
                for(i=begin;i<=end;i++){
                     $(".username:eq("+index+")").html(data.data[i].name);
                        $(".comment-body:eq("+index+")").html(data.data[i].comment);
                        $(".time:eq("+index+")").html("发表于"+data.data[i].time);
                           index++;
                }
                }
                else{  
                       number=number+1;
                $("#current").html(number);
                var begin=(number-1)*5;
                var end=begin+4;
                var index=0;
                for(i=begin;i<=end;i++){  //console.log(i)
                     $(".username:eq("+index+")").html(data.data[i].name);
                        $(".comment-body:eq("+index+")").html(data.data[i].comment);
                        $(".time:eq("+index+")").html("发表于"+data.data[i].time);
                           index++;
                }
                }
               
            }
     });
                 
            }



           
        },
        
        error: function (data) {
            console.log(data);
        }

    })
     });
   
















       //评论功能
$("#hand-in").click(function(){
         var str=$("#success-login").html();
     	  var pos=str.indexOf('/');
     	  var str2=str.slice(0,pos);
         
              $.ajax({
              
        url: 'http://sale.ckcsu.com/api/goodscomment',// /feedback
        type: "POST",
        xhrFields: {
            withCredentials: true
        }, 
      
       
        data:{  "goodsname":$("#goodsname").html(),
               "comment":$("#comment").val(),
                "name":str2,
                "time":"2333"
                
        	},
		   dataType:"json",
        success: function (data) {

            if (data.status == 'T') {
                 swal("发送成功", data.message, "success");
                 location.reload();
            }
            else{
        	swal("发送失败", data.message, "error");
            console.log($("#comment").val())
        }
        },
        
        error: function (data) {
            console.log(data);
        }

    })
});



     });


//