window.onload = function(){
    $.ajax({
        url: '../core/async_profile.php?fun=load',
        type: 'get',
        dataType: 'json',
        success: function(data){
            dat = data;
            for(let key in data){
                if(key == 'cond'){
                    switch (data[key]) {
                        case '1':
                            document.getElementById('titular').checked = true;
                            break;
                        case '2':
                            document.getElementById('familiar').checked = true;
                            break;
                        default:
                            break;
                    }
                }else{
                    document.getElementById(key).value = data[key];
                }
            }
        },
        error: function(err){
            console.log('algo paso: ' + err);
            er = err;
        }
    });
    $.ajax({
        url: '../core/async_profile.php?fun=notes',
        type: 'get',
        dataType: 'json',
        success: function(notes){
            note = notes;
            for(key in notes){
                switch(key){
                    case 'multi':
                        if(notes[key] == true) $('#'+key).attr('checked', true);
                        break;
                    case 'uni':
                        if(notes[key] == true) $('#'+key).attr('checked', true);
                        break;
                    case 'cars':
                        $('#'+key).val(notes[key]);
                        break;
                    case 'motos':
                        $('#'+key).val(notes[key]);
                        break;
                    default:
                        switch (notes[key]) {
                            case '1':
                                $('#op'+key).attr('checked', true);
                                break;
                            case '2':
                                $('#de'+key).attr('checked', true);
                                break;
                            case '3':
                                $('#no'+key).attr('checked', true);
                                break;
                            default:
                                break;
                        }
                        break;
                }
            }
        },
        error: function(err) {
            console.log('algo en notes ' + err);
            er2 = err;
        }
    });
}

function edit(self){
    $(self).prev().removeAttr('readonly');
}

function pwdDialog(){
    $.get('../templates/changepwd.html', function(html){
        $('body').append($.parseHTML(html));
        $('#chpwd').modal();
        $('#chpwd form input').val('');
        $('#pwdSubmit').on('click', function(ev){
            ev.preventDefault();
        });

    }).fail(function(err){
        console.log('Error en template: ');
        console.log(err);
    });
}

function changePwd(){
    var param = {
            //user: $("#user").val(),
            old: $("#pwd_old").val(),
            new: $("#pwd").val()
        };
    $.ajax({
        url: '../core/async_profile.php',
        type: 'post',
        data: param,
        dataType: 'json',
        success: function(data){
            console.log(data);
            $('#resp').html(data.msg);
            if(data.status ==true){
                setTimeout(function(){
                    $('#resp').html('');
                    $('#chpwd').modal('hide');
                }, 2000);
            }else{
                setTimeout(function(){
                    $('#resp').html('');
                }, 2000);
            }
        },
        error: function(err){
            console.log('changePwd: ' + err.responseText + ', status: ' +err.status);
        }
    });
}

function resetInput($form){
    $form.find('input').each(function(pos, ele){
        ele.value = '';
    });
}

function changeCel(self){
    var prefix = $('#cambioCel select').val(),
        number = $('#cambioCel input').val();
    var param = {
        //user: $('#user').val(),
        fun : 'changeCel',
        cel: prefix + number
    };
    console.log(param);
    $.ajax({
        url: '../core/async_profile.php',
        type: 'post',
        data: param,
        dataType: 'json',
        success: function(data){
            var response = $(self).parent().prev();
            response.html(data.msg);
            if(data.status ==true){
                setTimeout(function(){
                    response.html('');
                    $('#cambioCel').modal('hide');
                }, 2000);
            }else{
                setTimeout(function(){
                    response.html('');
                }, 2000);
            }
        },
        error: function(err){
            var response = $(self).parent().prev();
            response.html(err.responseText);
            setTimeout(function(){
                response.html('');
            }, 2000);
            console.log('cambioCel: ' + err.responseText + ', status: ' +err.status);
        }
    }).then(function(){
        $.ajax({
            url: '../core/async_profile.php?fun=cel',
            type: 'get',
            dataType: 'text',
            success: function(cel){
                $('#cel').val(cel);
            }
        })
    });
}

function getQuestion(){
    $.ajax({
        url: '../core/async_profile.php?fun=quest',
        type: 'get',
        dataType: 'text',
        success: function(data){
            $('#question').val(data);
        },
        error: function(err){
            console.log('getQuestion: ' + err.responseText + ', status: ' +err.status);
        }
    })
}

function changeQuestion(self){
    var param = {
        question: $('#question').val(),
        answer: $('#answer').val(),
        //user: $('#user').val()
    }
    $.ajax({
        url: '../core/async_profile.php',
        type: 'post',
        data: param,
        dataType: 'json',
        success: function(data){
            var response = $(self).parent().prev();
            response.html(data.msg);
            setTimeout(function(){
                response.html('');
                $('#cambioPregunta').modal('hide');
            }, 2000);
        },
        error: function(err){
            console.log('cambioPregunta: ' + err.responseText + ', status: ' +err.status);
        }
    })
}
