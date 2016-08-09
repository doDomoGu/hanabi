$(function(){
    var socketInterval = setInterval(function(){
        $.ajax({
            url: '/game/ajax-game-playing-socket',
            type: 'post',
            async : false,
            dataType:'json',
            data: {
                id:$('#game_id').val()
            },
            success: function (data) {
                if(data.result==true){
                    if(data.end==true){ //游戏结束
                        location.href = location.href;
                    }
                }
            }
        })
    },1000);




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