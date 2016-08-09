$(function(){
   $('#end_btn').click(function(){
       $.ajax({
           url: '/game/ajax-end',
           type: 'post',
           async : false,
           dataType:'json',
           data: {
               id:$('#game_id').val()
           },
           success: function (data) {
               if(data.result==true){
                   //游戏开始成功 刷新页面
                   location.href=location.href;
               }else{
                   //console.log(data);
                   location.href = '/game';
               }
           }
       });
   })
});