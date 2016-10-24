$(function(){
    $('#sendSmsBtn').click(function(){
        if(checkSendSms()){
            sendSms();
        }else
            return false;
    });

    var checkSendSms = function (){
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
                if(data.result){
                    return true;
                }else{
                    return false;
                }
            }
        });
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

                if(data.result){
                    alert(data.msg);
                    $('#sendSmsBtn').attr('disabled',true);
                }
            }
        })
    }

});