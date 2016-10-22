$(function(){
    $('#sendSmsBtn').click(function(){
        $.ajax({
            url: '/site/register',
            type: 'post',
            async : false,
            dataType:'json',
            data: {
                act:'send-sms',
                mobile:$('#registerform-mobile').val(),
                verifyCode:$('#registerform-verifycode').val()
            },
            success: function (data) {
                alert(data);
            }
        })
    });
});