var imgs =["3.jpg", "1.jpg", "2.jpg"];    //（设定想要显示的图片）
    var x = 0;        
        function time1(){
               x++;    
               x=x%3;         //         超过2则取余数，保证循环在0、1、2之间
               document.getElementById("back-img").src ="images/"+imgs[x];
        }setInterval("time1()",3000);