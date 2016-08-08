$(function(){
   var getPlayerInterval = setInterval(function(){
       $.ajax({
           url: '/game/ajax-get-player',
           type: 'post',
           async : false,
           dataType:'json',
           data: {
               id:$('#game_id').val()
           },
           success: function (data) {
               if(data.result==true){
                   $('.player1 .name_txt').html(data.name1);
                   $('.player2 .name_txt').html(data.name2);
                   $('.player1,.player2').removeClass('you');
                   if(data.ord==1){
                       $('#start_btn').removeClass('hidden');
                       $('#ready_btn').addClass('hidden');
                       $('.player1').addClass('you');
                       if(data.id2==0){
                           $('#start_btn').addClass('disabled');
                       }else{
                           if(data.player_ready==1){
                               $('#start_btn').removeClass('disabled');
                           }else{
                               $('#start_btn').addClass('disabled');
                           }
                       }
                   }else if(data.ord==2){
                       $('#start_btn').addClass('hidden');
                       $('#ready_btn').removeClass('hidden');
                       $('.player2').addClass('you');
                   }

                   if(data.id2==0){
                       $('.player2 .player_status').html('');
                   }else{
                       if(data.player_ready==1){
                           $('.player2 .player_status').html('准备完成');
                       }else{
                           $('.player2 .player_status').html('准备中');
                       }
                   }

               }else{
                   location.href = '/game';
               }
           }
       });
   },1000);

   $('#exit_btn').click(function(){
       clearInterval(getPlayerInterval);
       window.location = '/game/exit?id='+$('#game_id').val();
   });

   $('#ready_btn').click(function(){
       $.ajax({
           url: '/game/ajax-get-player-ready',
           type: 'post',
           async : false,
           dataType:'json',
           data: {
               id:$('#game_id').val(),
               act:$('#ready_act').val()
           },
           success: function (data) {
               if(data.result==true){
                   if($('#ready_act').val()=='do-not-ready'){
                       $('.player2 .player_status').html('准备中');
                       $('#ready_btn').html('准备');
                       $('#ready_act').val('do-ready');
                   }else if($('#ready_act').val()=='do-ready'){
                       $('.player2 .player_status').html('准备完成');
                       $('#ready_act').val('do-not-ready');
                       $('#ready_btn').html('取消准备');
                   }
               }else{
                   location.href = '/game';
               }
           }
       });
   });

    $('#start_btn').click(function(){
        $.ajax({
            url: '/game/ajax-start',
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