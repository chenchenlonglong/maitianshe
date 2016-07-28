/**
 * Created by PhpStorm.
 * User: ty
 * Date: 2016/3/18
 * Time: 11:45
 */
$(function(){
   $('#login_submit').on('click',function(){
       var data_url=$('#login_submit').attr('data_url');
       var username=$('#login_username').val();
       var password=$('#login_password').val();
       var data_redirect=$('#login_redirect').attr('data_redirect');
       $.ajax({
           type:'post',
           url:data_url,
           dataType:'json',
           data:{username:username,password:password},
           success:function(data){
               if(data['status']=='fail'){
                   alert(data['msg']);
               }else{
                   window.location.href=data_redirect;
               }
           },
       })
   })

})
