window.onload = function(){

    $('form').each(function(pos, form){
        $(form).on('submit', function(ev){
            ev.preventDefault();
        });
    });

    // Obtiene los datos para la plantilla correspondiente al edificio
    $.ajax({
        url: '/index.php/admin/usuarios/notas',
        type: 'get',
        dataType: 'json',
        error: function(err){
            console.log('Error en notas: ', err);
        }
    })
    .then(function(res){
        if(res.status == true){
            var notes = res.msg

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
        }

    });

    // Para avanzar con la tecla enter
    var list = ['name', 'surname', 'ci', 'nac', 'cel', 'gen'];
    pressEnterNext(list);

    // Si no es Chrome usa un datepicker
    if(!navigator.userAgent.match(/Chrome/ig)){
        var dp = new dpicker(document.getElementById('nac'));
    }
}

function edit(self){
    $(self).prev().removeAttr('readonly');
}

function updatePersonal(submit){

    var form = $(submit).closest('form')[0];

    $.ajax({
        url: '/index.php/usuarios/updatepersonal',
        type: 'post',
        data: $(form).serialize(),
        dataType: 'json',
        error: function(err){
            console.log('Error el updatePersonal: ', err);
        }
    })
    .then(function(data){

        var response = document.createElement('div');
        $(response).attr('align', 'center');
        $(form).append(response);

        if(data.status == true){
            console.log(data.msg);
            $(response).addClass('alert alert-success');

        }else{
            $(response).addClass('alert alert-danger');
        }

        setTimeout(function(){
            $(response).remove();
        }, 2000);

        $(response).html(data.msg);

    });
}

function updateNotes(submit){

    var form = $(submit).closest('form')[0];

    $.ajax({
        url: '/index.php/usuarios/updatenotes',
        type: 'post',
        data: $(form).serialize(),
        dataType: 'json',
        error: function(err){
            console.log('Error el updatePersonal: ', err);
        }
    })
    .then(function(data){

        var response = document.createElement('div');
        $(response).attr('align', 'center');
        $(form).append(response);

        if(data.status == true){
            console.log(data.msg);
            $(response).addClass('alert alert-success');

        }else{
            $(response).addClass('alert alert-danger');
        }

        setTimeout(function(){
            $(response).remove();
        }, 2000);

        $(response).html(data.msg);
    });
}

function getPasswordDialog(){

    $.ajax({
        url: '/index.php/usuarios/getpassworddialog',
        type: 'get',
        dataType: 'html',
        error: function(err){
            console.log('Error en getPasswordDialog: '+err);
        }
    })
    .then(function(res){
        var cont = document.createElement('div');

        $(cont).append($.parseHTML(res.toString()));
        $('body').append(cont);
        $(cont.firstChild).modal().on('hidden.bs.modal', function(){
            $(cont).remove();
        });

        $(cont).find('form').on('submit', function(ev){
            ev.preventDefault();
            setPassword(this);
        });
    })
    .then(function(){
        var list = ['pwd_old', 'pwd_new', 'pwd_rep'];
        pressEnterNext(list);
    });
}

function setPassword(form){

    $.ajax({
        url: '/index.php/usuarios/setpassword',
        type: 'post',
        data: $(form).serialize(),
        dataType: 'json',
        error: function(err){
            console.log('Error en setPassword: ', err);
        }
    })
    .then(function(data){
        var response = document.createElement('div');
        $('#_response').append(response);

        if(data.status == true){
            console.log(data.msg);
            $(response).addClass('alert alert-success');

            setTimeout(function(){
                $(response).html('');
                $('.modal').modal('hide');
            }, 2000);
        }else{
            $(response).addClass('alert alert-danger');
            setTimeout(function(){
                $(response).remove();
            }, 2000);
        }

        $(response).html(data.msg);

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
        url: 'core/async_profile.php',
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
            url: 'core/async_profile.php?fun=cel',
            type: 'get',
            dataType: 'text',
            success: function(cel){
                $('#cel').val(cel);
            }
        })
    });
}

function getQuestionDialog(){
    $.ajax({
        url: '/index.php/usuarios/getquestion',
        type: 'get',
        dataType: 'html',
        error: function(err){
            console.log('Error en getQuestionDialog: ', err);
        }
    })
    .then(function(res){
        var cont = document.createElement('div');

        $(cont).append($.parseHTML(res.toString()));
        $('body').append(cont);
        $(cont.firstChild).modal().on('hidden.bs.modal', function(){
            $(cont).remove();
        });

        $(cont).find('form').on('submit', function(ev){
            ev.preventDefault();
            setQuestionResponse(this);
        });
    })
    .then(function(){
        var list = ['question', 'response'];
        pressEnterNext(list);
    });
}

function setQuestionResponse(form){

    $.ajax({
        url: '/index.php/usuarios/setquestionresponse',
        type: 'post',
        data: $(form).serialize(),
        dataType: 'json',
        error: function(err){
            console.log('Error en setquestionresponse: ', err);
        }
    })
    .then(function(data){
        var response = document.createElement('div');
        $('#_response').append(response);

        if(data.status == true){
            console.log(data.msg);
            $(response).addClass('alert alert-success');

            setTimeout(function(){
                $(response).html('');
                $('.modal').modal('hide');
            }, 2000);
        }else{
            $(response).addClass('alert alert-danger');
            setTimeout(function(){
                $(response).remove();
            }, 2000);
        }

        $(response).html(data.msg);
    })
}

function showFamily(){
    $.get('templates/family.html', function(html){
        $('body').append($.parseHTML(html));
        var modal = $('#family');
        modal.modal();
        modal.on('hidden.bs.modal', function(){
            console.log('aqui');
            modal.remove();
        });
    }, 'html')
    .then(function(){
        $.get('core/async_profile.php?fun=family', function(data){
            var content = $('#familycontent');
            content.html(data);
            //trasTable('family');
        }, 'html')
        .catch(function(err){
            console.log(err);
        })
        .then(function(){
            //pegar eventos
        })
    })
}
