window.onload = function(){
    $("form").on("submit", function(event){
        event.preventDefault();
    });

    var list = ['name', 'surname', 'ci', 'apt', 'email', 'type', 'cond'];
    pressEnterNext(list);

    $.ajax({
        url: '../core/async_users.php?edificio',
        type: 'get',
        dataType: 'text',
        success: function(data){
        },
        error: function(err){
            console.log('Recibiendo edificio: ' + err.responseText + ' estatus: '+ err.status);
        }
    }).then(function(res){
        $.ajax({
            url: '../files/EDI-'+res+'.json',
            type: 'get',
            dataType: 'json',
            success: function(data){
                apts = data.apts;
                $(data.apts).each(function(pos, ele){
                    var op = document.createElement('option');
                    $(op).html(ele).val(ele);
                    $('#apt').append(op);
                })
            },
            error: function(err){
                console.log('Recibiendo apts: ' +err.responseText + ' estatus: '+ err.status);
            }
        });
    });
}

function sendNewuser(){
    $.ajax({
        url:'../core/async_users.php',
        type: 'post',
        data: $('form').serialize(),
        dataType: 'json',
        error: function(err){
            console.log('sendNewuser: ' +err.responseText + ' estatus: '+ err.status);
        }
    }).done(function(res){
        $.get('../templates/alert.html', function(html){
            $('body').append($.parseHTML(html));
            var modal = $('#alert'),
                content = $('#alert_content'),
                btn = $('#alert_btn');
            modal.modal();
            modal.on('hidden.bs.modal', function(){
                window.location.reload();
            });
            content.html(res.msg);
            btn.on('click', function(){
                modal.modal('hide');
            });
            if(res.status == true){
                content.addClass('alert-success');
            }else{
                content.addClass('alert-danger');
            }

        }).fail(function(err){
            console.log(err);
        });
    });
}
