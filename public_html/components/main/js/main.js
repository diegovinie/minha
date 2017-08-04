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
                url: '/index.php/views/modals/changepwd.html',
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
                        $('#pwd_old').val(json.old).attr('readonly', 'true');
                        $('#chpwd form').on('submit', function(ev){
                            ev.preventDefault();
                        });
                        resolve();
                    }, 1000);
                });
            })


        }
    })

    $.ajax({
        type: 'GET',
        url: '/index.php/main/balance',
        dataType: 'json',
        success: function(res){
            var cont = document.getElementById('balance');
            cont.innerHTML = 'Edificio: '+ res.data.bui_name + '<br/>Apartamento: ' +res.data.bui_apt + '<br/>Bs. ' + toBs(res.data.bui_balance);
        }
    });
}

function updatePassword(){
    var param = {
            user: $("#user").val(),
            old: $("#pwd_old").val(),
            new: $("#pwd").val()
        };
    $.ajax({
        url: '/index.php/login/updatepassword',
        type: 'post',
        data: param,
        dataType: 'json',
        success: function(data){
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
            console.log('Error updatepassword: ', err);
        }
    });
}
