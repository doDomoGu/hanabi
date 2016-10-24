$(function(){
    var sendSmsFlag = true;

    $('#sendSmsBtn').click(function(){
        if(sendSmsFlag){
            sendSmsFlag = false;
            if(checkSendSms()){
                $('#sendSmsBtn').attr('disabled',true);
                sendSms();
            }else{
                sendSmsFlag = true;
                return false;
            }

        }else{
            alert('已发送');
        }

    });

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
    }

});