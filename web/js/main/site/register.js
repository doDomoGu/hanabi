$(function(){
    $('#sendSmsBtn').click(function(){
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
    });
});