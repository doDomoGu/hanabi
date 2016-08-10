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


    $('.btn_area .btns .btn').click(function (){
        /*$('.btn_area .btns .btn').attr('disabled',true);
        $(this).attr('disabled',false);*/
        $('.btn_area .btns .btn').addClass('disabled');
        $(this).removeClass('disabled');
        $('#ok_btn').removeClass('hidden');
        $('#cancel_btn').removeClass('hidden');
    });

    $('#cancel_btn').click(function(){
        $('.btn_area .btns .btn').removeClass('disabled');
        $('#ok_btn').addClass('hidden');
        $('#cancel_btn').addClass('hidden');
    });
    /*$('#cue_btn').click(function(){
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
    })*/


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