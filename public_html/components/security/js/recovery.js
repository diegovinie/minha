/* JQuery, pressEnter(), checkResponse()
 * #response, #email
 *
 */

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


function getQuestion(input){
    email = $(input).val();
    if(email != ''){
        var question = $('#question');
        question.val('');
        $.ajax({
            url: '/index.php/recovery/getquestion/?email=' + email,
            type: 'get',
            dataType: 'json',
            success: function(json){
                if(json.status == true){
                    question.val(json.question);
                }else{
                    flashText('warning', 'Usuario no encontrado.');
                }
            },
            error: function(err){
                console.log('getQuestion: ' + err.responseText + ', status: ' + err.status);
            }
        });
    }
}

function checkResponse(input){
    param = {
        question: $('#question').val(),
        response: $('#response').val(),
        email: $('#email').val()
    };
    loadingBarOn();

    $.ajax({
        url: '/index.php/recovery/checkresponse',
        data: param,
        type: 'post',
        dataType: 'json',
        success: function(data){
            flashText('danger', data.msg);

            if(data.status == true){
                $('#newPwd').modal()
                $('#pwdSubmit').on('click', function(){
                    setPwd(param);
                    $('#newPwd').modal('hide');
                });
                $('#pwd').focus();
                var list = ['pwd', 'pwd_ret'];
                pressEnterNext(list);
            }
        },
        error: function(err){
            console.log('checkResponse: ' + err.responseText + ', status: ' + err.status);
        }
    })
    .always(function(){
        loadingBarOff();
    });

}

function setPwd(args){
    params = {
        email: args.email,
        response: args.response,
        pwd: $('#pwd').val()

    };
    $.ajax({
        url: '/index.php/recovery/setpwd',
        data:params,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data.msg);
            var modal = $('#alert'),
                content = $('#alert_content'),
                btn = $('#alert_btn');
            modal.modal();
            modal.on('hidden.bs.modal', function(){
                window.location = (data.status == true? '/index.php/login' : '/index.php/recovery');
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
