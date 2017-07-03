window.onload = function(){
    var ele  = document.getElementById('response'),
        btn = $(ele).parent().next().next().children()[0],
        email = $('#email').focus();
    ele.onkeydown = function(evt){
        pressEnter(evt, function(){
            ele.blur();
            checkResponse(btn);
        });
    };

    var list = ['email', 'question', 'response'];
    pressEnterNext(list);
}

function checkEmail(self){
    email = $(self).val();
    if(email != ''){
        $.ajax({
            url: 'core/authentication.php?fun=email&user=' + email,
            type: 'get',
            dataType: 'text',
            success: function(data){
                if (data == ''){
                    warningMsg(self, 'Usuario no encontrado');
                }
                $('#question').val(data);
            },
            error: function(err){
                console.log('checkEmail: ' + err.responseText + ', status: ' + err.status);
            }
        });
    }

}

function checkResponse(self){
    param = {
        question: $('#question').val(),
        response: $('#response').val(),
        email: $('#email').val(),
        fun: 'checkResponse'
    }
    $.ajax({
        url: 'core/authentication.php',
        data: param,
        type: 'post',
        dataType: 'json',
        success: function(data){
            var response = $(self).parent().prev();
            response.addClass('text-warning');
            response.html(data.msg);
            if(data.status == true){
                $('#newPwd').modal()
                $('#pwdSubmit').on('click', function(){
                    savePwd(param);
                    $('#newPwd').modal('hide');
                });
                $('#pwd').focus();
                var list = ['pwd', 'pwd_ret'];
                pressEnterNext(list);
            }else {
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        },
        error: function(err){
            console.log('checkResponse: ' + err.responseText + ', status: ' + err.status);
        }
    })

}

function savePwd(args){
    params = {
        email: args.email,
        response: args.response,
        pwd: $('#pwd').val(),
        fun: 'savepassword'
    };
    $.ajax({
        url: 'core/authentication.php',
        data:params,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data.status);
            var modal = $('#alert'),
                content = $('#alert_content'),
                btn = $('#alert_btn');
            modal.modal();
            modal.on('hidden.bs.modal', function(){
                window.location = (data.status == true? 'login.php' : 'recovery.php');
            });
            content.html(data.msg);
            if(data.status == true){
                content.addClass('alert-success');
            }else{
                content.addClass('alert-danger');
            }
            btn.on('click', function(){
                modal.modal('hide');
            });
        },
        error: function(err){
            console.log('savePwd: ' + err.responseText + ', status: ' + err.status);
        }
    });
}
