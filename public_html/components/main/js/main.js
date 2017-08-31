window.onload = function(){
    $.ajax({
        url: '/index.php/login/checkoldpassword',
        type: 'get',
        dataType: 'json',
        error: function(err){
            console.log('Error en checkoldpassword: ', err);
        }
    })
    .then(function(json){

        if(json.status == true){
            $.ajax({
                url: '/index.php/main/notices',
                type: 'get',
                dataType: 'html',
                error: function(err){
                    console.log('Error en notices: ', err);
                }
            })
            .then(function(html){
                $('#anuncio').html(html);
            });

            $.ajax({
                url: '/index.php/get/modals/changepwd.html',
                type: 'get',
                dataType: 'html',
                error: function(err){
                    console.log('Error en la plantilla: ', err);
                }
            })
            .then(function(html){

                return new Promise(function(resolve){
                    $('body').append($.parseHTML(html));

                    setTimeout(function(){
                        $('#chpwd').modal();
                        $('#chpwd form input').val('');
                        $('#pwd_old').val(json.msg.old).attr('readonly', 'true');
                        $('#chpwd form').on('submit', function(ev){
                            ev.preventDefault();
                        });
                        resolve();
                    }, 1000);
                });
            });
        }
    });

    $.ajax({
        type: 'GET',
        url: '/index.php/main/balance',
        dataType: 'json',
        error: function(err){
            console.log('Error al pedir balance: ', err);
        }
    })
    .then(function(res){
        var cont = document.getElementById('balance');

        cont.innerHTML = 'Edificio: '+ res.data.bui_name
                        + '<br/>Apartamento: ' + res.data.apt_name
                        + '<br/>Bs. ' + toBs(res.data.apt_balance);
    });
}

function updatePassword(){
    var param = {
            old: $("#pwd_old").val(),
            new: $("#pwd").val()
        };

    $.ajax({
        url: '/index.php/login/updatepassword',
        type: 'post',
        data: param,
        dataType: 'json',
        error: function(err){
            console.log('Error updatepassword: ', err);
        }
    })
    .then(function(data){

        if(data.status ==true){

            flashText('success', data.msg);

            setTimeout(function(){
                $('#chpwd').modal('hide');
            }, 2000);
        }else{
            flashText('danger', data.msg);
        }
    });
}
