$(function(){
    var sendSmsFlag = true;

    $('#sendSmsBtn').click(function(){
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
            alert('已发送');
        }
    });

    var sendSmsBtnChange = function (){
        $('#sendSmsBtn').attr('disabled',true);
        var _time = 60;
        $('#sendSmsBtn').html(_time+'秒后可重新获取');
        _time = parseInt(_time - 1);
        var btnInterval = setInterval(function(){
            if(_time>0){
                $('#sendSmsBtn').html(_time+'秒后可重新获取');
                _time = parseInt(_time - 1);
            }else{
                $('#sendSmsBtn').html('获取短信验证码').attr('disabled',false);
                clearInterval(btnInterval);
            }
        },1000);

    };

    var checkSendSms = function (){
        var result = false;
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
                    result = true;
                }else{
                    result = false;
                }
            }
        });
        return result;
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