$(function(){
   var getPlayerInterval = setInterval(function(){
       $.ajax({
           url: '/game/ajax-get-player',
           type: 'post',
           async : false,
           dataType:'json',
           data: {
               id:$('#room_id').val()
           },
           success: function (data) {
               if(data.result==true){
                   $('.player1 .name_txt').html(data.name1);
                   $('.player2 .name_txt').html(data.name2);
                   $('.player1,.player2').removeClass('you');
                   if(data.ord==1){
                       $('.player1').addClass('you');
                   }else if(data.ord==2){
                       $('.player2').addClass('you');
                   }
               }else{
                   location.href = '/room';
               }
           }
       });
   },1000);

   $('#exit_btn').click(function(){
       clearInterval(getPlayerInterval);
       window.location = '/room/exit?id='+$('#room_id').val();
   })
});