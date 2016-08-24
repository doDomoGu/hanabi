$(function(){
    var socketInterval = setInterval(function(){
        $.ajax({
            url: '/game/ajax-game-playing-socket',
            type: 'post',
            async : false,
            dataType:'json',
            data: {
                id:$('#game_id').val(),
                room_id:$('#room_id').val(),
                record_offset:$('#sidebar .record_list ul li').length
            },
            success: function (data) {
                if(data.result==true){
                    if(data.end==true){ //游戏结束
                        location.href = '/room/'+data.room_id;
                    }else{
                        if(data.record.length>0){
                            for(var i in data.record){
                                $('#sidebar .record_list ul').append('<li>'+data.record[i]+'</li>');
                            }
                        }

                        if(data.opposite_card.length > 0){
                            var oc_html;
                            for(var i in data.opposite_card){
                                oc_html += '<li>'+data.opposite_card[i].color+' - '+data.opposite_card[i].num+'</li>';
                            }
                            $('.opposite_card .hand_card ul').html(oc_html);
                        }


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
        $(this).addClass('act_selected');
        $('#ok_btn').removeClass('hidden');
        $('#cancel_btn').removeClass('hidden');
    });


    $('.hand_card ul li').click(function(){
        _act_btn = $('.btns .btn.act_selected');
        if(_act_btn.length==1){
            _act = _act_btn.attr('act');
            _length = $('.hand_card ul li.selected').length;

            if($(this).hasClass('selected')){
                $(this).removeClass('selected');
                if(_act=='change_ord'){
                    if(_length==2){
                        $('#ok_btn').addClass('disabled');
                    }
                }
            }else{
                if(_act=='change_ord'){
                    if(_length<2){
                        $(this).addClass('selected');
                        if(_length==1){
                            $('#ok_btn').removeClass('disabled');
                        }
                    }
                }
            }
        }/*else{
            alert('操作错误001');
        }*/
    });

    $('#ok_btn').click(function(){
        _act_btn = $('.btns .btn.act_selected');
        if(_act_btn.length==1){
            _act = _act_btn.attr('act');
            _length = $('.hand_card ul li.selected').length;
            if(_act=='change_ord' && _length==2){
                _ord1 = $($('.hand_card ul li.selected')[0]).index();
                _ord2 = $($('.hand_card ul li.selected')[1]).index();
                $.ajax({
                    url: '/game/ajax-do-change-player-card-ord',
                    type: 'post',
                    async : false,
                    dataType:'json',
                    data: {
                        id:$('#game_id').val(),
                        player:$('#round_player').val(),
                        ord1:_ord1,
                        ord2:_ord2
                    },
                    success: function (data) {
                        if(data.result==true){
                            alert('交换成功');
                            $('.btn_area .btns .btn').removeClass('disabled').removeClass('act_selected');
                            $('.hand_card ul li').removeClass('selected');
                            $('#ok_btn').addClass('hidden').addClass('disabled');
                            $('#cancel_btn').addClass('hidden');
                        }
                    }
                })
            }else{
                alert('操作错误0021');
            }
        }else{
            alert('操作错误002')
        }
    });

    $('#cancel_btn').click(function(){
        $('.btn_area .btns .btn').removeClass('disabled').removeClass('act_selected');
        $('.hand_card ul li').removeClass('selected');
        $('#ok_btn').addClass('hidden').addClass('disabled');
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
                    location.href='/room/'+data.room_id;
                }else{
                    //console.log(data);
                    location.href = '/room  ';
                }
            }
        });
    })
});