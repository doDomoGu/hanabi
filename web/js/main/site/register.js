$(function(){
    var sendSmsFlag = true;
    var sendSmsBtn = $('#sendSmsBtn');
    sendSmsBtn.on('click',function(){
        if(sendSmsFlag){
            sendSmsFlag = false;
            if(checkSendSms()){
                sendSmsBtnChange();
                sendSms();
            }else{
                sendSmsFlag = true;
                return false;
            }

        }else{
            return false;
        }
    });

    var sendSmsBtnChange = function (){
        var _time = 60;
        sendSmsBtn.attr('disabled',true).html(_time+'秒后可重新获取');
        _time = parseInt(_time - 1);
        var btnInterval = setInterval(function(){
            if(_time>0){
                $('#sendSmsBtn').html(_time+'秒后可重新获取');
                _time = parseInt(_time - 1);
            }else{
                $('#sendSmsBtn').html('获取短信验证码').attr('disabled',false);
                clearInterval(btnInterval);
                sendSmsFlag = true;
            }
        },1000);

    };

    var checkSendSms = function (){
        var re = false;
        $.ajax({
            url: '/site/register',
            type: 'post',
            async : false,
            dataType:'json',
            data: {
                act: 'check-send-sms',
                RegisterForm: {
                    mobile: $('#registerform-mobile').val(),
                    verifyCode: $('#registerform-verifycode').val()
                }
            },
            success: function (data) {
                if(data.result=='valid-success'){
                    re = true;
                }else{
                    re = false;
                    for(var i in data.errors){
                        if(!$('.field-'+i).hasClass('has-error')){
                            $('.field-'+i).addClass('has-error');
                        }
                        $('.field-'+i+' .help-block-error').html(data.errors[i][0]);
                    }
                }
            }
        });
        return re;
    };

    var sendSms = function () {
        $.ajax({
            url: '/site/register',
            type: 'post',
            async : false,
            dataType:'json',
            data: {
                act: 'send-sms',
                RegisterForm: {
                    mobile: $('#registerform-mobile').val(),
                    verifyCode: $('#registerform-verifycode').val()
                }
            },
            success: function (data) {

                if(data.result=='send-success'){
                    alert(data.msg);
                    //$('#sendSmsBtn').attr('disabled',true);
                }else{
                    alert('发送失败');
                }
            }
        })
    };

});