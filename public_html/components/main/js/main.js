window.onload = function(){
    $.get('core/async_main.php?fun=oldpwd')
    .always(function(old){
        $.get('core/async_main.php?fun=new', function(b){
            console.log(b);
            if(b == 1){
                $.get('templates/changepwd.html', function(html){
                    $('body').append($.parseHTML(html));
                    $('#chpwd').modal();
                    $('#chpwd form input').val('');
                    $('#pwd_old').val(old).attr('readonly', 'true');
                }).fail(function(err){
                    console.log('Error en template: ');
                    console.log(err);
                }).done(function(){
                    $.get('templates/alert.html').done(function(html){
                        $('body').append(html);
                        var modal = $('#alert'),
                            content = $('#alert_content'),
                            btn = $('#alert_btn');
                        btn.remove();
                        modal.modal();
                        modal.on('hidden-bs-modal', function(){
                            modal.remove();
                        });
                        content.addClass('alert-danger');
                        content.html('<h4>Defina su clave ahora</h4>');
                        setTimeout(function(){
                            modal.modal('hide');
                        }, 2000);
                    });
                });
            }
        }).fail(function(err){
            console.log("error: ");
            console.log(err);
        })
    })

    $.ajax({
        type: 'GET',
        url: '/index.php/main/balance',
        dataType: 'json',
        success: function(res){
            console.log('ba: ', res);
            var cont = document.getElementById('balance');
            cont.innerHTML = 'Edificio: '+ res.data.bui_name + '<br/>Apartamento: ' +res.data.bui_apt + '<br/>Bs. ' + toBs(res.data.bui_balance);
        }
    });
}

function changePwd(){
    var param = {
            user: $("#user").val(),
            old: $("#pwd_old").val(),
            new: $("#pwd").val()
        };
    $.ajax({
        url: 'core/async_profile.php',
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
            console.log('changePwd: ' + err.responseText + ', status: ' +err.status);
        }
    });
}
