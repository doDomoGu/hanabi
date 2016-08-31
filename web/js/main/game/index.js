$(function(){
    //游戏记录区域，滚动到底部
    $('#sidebar .record_list').scrollTop($('#sidebar .record_list')[0].scrollHeight);

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
                        //判断是否要交换游戏回合
                        if(data.is_your_round){
                            if($('#round_player').val()!=$('#player_no').val()){
                                changeRound();
                            }
                        }else{
                            if($('#round_player').val()==$('#player_no').val()){
                                changeRound();
                            }
                        }

                        //游戏记录
                        if(data.record.length>0){
                            for(var i in data.record){
                                $('#sidebar .record_list ul').append('<li>'+data.record[i]+'</li>');
                            }
                            $('#sidebar .record_list').scrollTop($('#sidebar .record_list')[0].scrollHeight);
                        }

                        //对方手牌信息
                        if(data.opposite_card.length > 0){
                            for(var i in data.opposite_card){
                                $($('.top_area .hand_card ul li')[i]).html(data.opposite_card[i].color+' - '+data.opposite_card[i].num);

                            }
                        }

                        //数字更新
                        $('#cue_num').val(data.cue_num);
                        $('#chance_num').val(data.chance_num);
                        $('.cue_num_txt').html(data.cue_num);
                        $('.chance_num_txt').html(data.chance_num);
                        $('.cue_num_out_txt').html(data.cue_num_2);
                        $('.chance_num_out_txt').html(data.chance_num_2);
                        $('.card_num_in_library_txt').html(data.card_num_in_library);
                        $('.card_num_in_discard_txt').html(data.card_num_in_discard);
                    }
                }
            }
        })
    },1000);

    var recoverBtnStatus = function(){
        //恢复按钮初始状态
        $('.btn_area .btns .btn')
            .removeClass('disabled')
            .addClass('disabled')
            .removeClass('act_selected');
        $('#ok_btn')
            .removeClass('hidden')
            .addClass('hidden')
            .addClass('disabled');
        $('#cancel_btn')
            .removeClass('hidden')
            .addClass('hidden');

        //清空手牌选择
        $('.hand_card ul li').removeClass('selected');
        $('.top_area .hand_card').removeClass('enable_sel');
        $('.bottom_area .hand_card').removeClass('enable_sel');

        //清空线索提示相关
        $('.cue_area .btn').removeClass("cue_sel");
        $('#cue_type').val('');
        $('.cue_area .cue_txt').html('');
        $('.cue_area').removeClass('hidden').addClass('hidden');

        //根据是否是你的游戏回合，显示不同的按钮状态
        if($('#round_player').val()==$('#player_no').val()){
            $('.btn_area .btns .btn')
                .removeClass('disabled')
                .removeClass('act_selected');
            if(parseInt($('#cue_num').val())==0){
                $('#cue_btn').addClass('disabled');
            }
        }
    };

    var changeRound = function(){
        if($('#round_player').val()==1){
            $('#round_player').val(2);
        }else{
            $('#round_player').val(1);
        }
        recoverBtnStatus();
    };

    recoverBtnStatus();



    $('.btn_area .btns .btn').click(function (){
        $('.btn_area .btns .btn').addClass('disabled');
        $(this).removeClass('disabled');
        $(this).addClass('act_selected');
        //点击线索按钮时，高亮对方手牌，否则高亮自己的手牌
        if($(this).attr('act')=='cue'){
            $('.top_area .hand_card').addClass('enable_sel');
        }else{
            $('.bottom_area .hand_card').addClass('enable_sel');
        }
        $('#ok_btn').removeClass('hidden');
        $('#cancel_btn').removeClass('hidden');
    });

    $('#game_area').on('click','.hand_card.enable_sel ul li',function(){
        _act_btn = $('.btns .btn.act_selected');
        if(_act_btn.length==1){
            _act = _act_btn.attr('act');
            _length = $('.hand_card.enable_sel ul li.selected').length;

            if($(this).hasClass('selected')){
                $(this).removeClass('selected');
                if(_act=='change_ord'){
                    if(_length==2){
                        $('#ok_btn').addClass('disabled');
                    }
                }else if(_act=='discard'){
                    if(_length==1){
                        $('#ok_btn').addClass('disabled');
                    }
                }else if(_act=='cue'){
                    if(_length==1){
                        $('#ok_btn').addClass('disabled');
                        $('.cue_area').hide();
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
                }else if(_act=='discard'){
                    if(_length<1){
                        $(this).addClass('selected');
                        $('#ok_btn').removeClass('disabled');
                    }
                }else if(_act=='cue'){
                    if(_length<1){
                        $(this).addClass('selected');
                        $('#ok_btn').removeClass('disabled');
                        $('.cue_area').removeClass('hidden');
                    }
                }
            }
        }/*else{
            alert('操作错误001');
        }*/
    });

    $('#cue_type_color').click(function(){
        if(!$(this).hasClass('cue_sel')){
            $(this).addClass('cue_sel');
            $('#cue_type_num').removeClass('cue_sel');
            $('#cue_type').val('color');
            $('.cue_area .cue_txt').html('提示所有相同颜色的牌');
        }
    });

    $('#cue_type_num').click(function(){
        if(!$(this).hasClass('cue_sel')){
            $(this).addClass('cue_sel');
            $('#cue_type_color').removeClass('cue_sel');
            $('#cue_type').val('num');
            $('.cue_area .cue_txt').html('提示所有相同数字的牌');
        }
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
                            recoverBtnStatus();
                        }
                    }
                })
            }else if(_act=='discard' && _length==1){
                _sel = $($('.hand_card ul li.selected')[0]).index();
                $.ajax({
                    url: '/game/ajax-do-discard-player-card',
                    type: 'post',
                    async : false,
                    dataType:'json',
                    data: {
                        id:$('#game_id').val(),
                        player:$('#round_player').val(),
                        sel:_sel
                    },
                    success: function (data) {
                        if(data.result==true){
                            alert('弃牌成功');
                            changeRound();
                        }
                    }
                })
            }else if(_act=='cue' && _length==1){
                _sel = $($('.hand_card ul li.selected')[0]).index();
                _cue_type = $('#cue_type').val();
                $.ajax({
                    url: '/game/ajax-do-cue',
                    type: 'post',
                    async : false,
                    dataType:'json',
                    data: {
                        id:$('#game_id').val(),
                        player:$('#round_player').val(),
                        sel:_sel,
                        cue_type:_cue_type
                    },
                    success: function (data) {
                        if(data.result==true){
                            alert('提示线索成功');
                            changeRound();
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
        /*$('.btn_area .btns .btn').removeClass('disabled').removeClass('act_selected');
        if(parseInt($('#cue_num').val())==0){
            $('#cue_btn').addClass('disabled');
        }
        $('.hand_card ul li').removeClass('selected');
        $('.top_area .hand_card').removeClass('enable_sel');
        $('.bottom_area .hand_card').removeClass('enable_sel');
        $('.cue_area .btn').removeClass("cue_sel");
        $('#cue_type').val('');
        $('.cue_area .cue_txt').html('');
        $('.cue_area').hide();
        $('#ok_btn').addClass('hidden').addClass('disabled');
        $('#cancel_btn').addClass('hidden');*/
        recoverBtnStatus();
    });

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