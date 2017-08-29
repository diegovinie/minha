/* public_html/components/demo/js/register.js
 *
 */

window.onload = function(){
    /*
    $("form").on("submit", function(event){
        event.preventDefault();
        // Envío del formulario
        $.ajax({
            url: '/index.php/demo/crear',
            type: 'post',
            data: $('form').serialize(),
            dataType: 'json',
            error: function(err){
                console.log('Error en create: ', err);
            }
        })
        .then(function(data){
            if(data.status != true){
                flashText('warning', data.msg);
            }
            else{
                // Pedir el modal
                $.get('/index.php/views/modals/alert.html')
                .done(function(html){
                    $('body').append(html);
                    var modal = $('#alert'),
                        content = $('#alert_content'),
                        btn = $('#alert_btn');
                    // Mensaje del modal
                    content.html(data.msg);
                    // Colores del modal
                    content.addClass('alert-success');

                    btn.on('click', function(){
                        modal.modal('hide');
                    });
                    modal.on('hidden.bs.modal', function(){
                        window.location.href = '/index.php/demo/iniciar';
                    });

                    modal.modal();
                })
                .catch(function(err){
                    console.log('Problema con modal: ');
                    console.log(err);
                });
            }
        });
    });
    */

    // Lista de edificios en el select
    $.ajax({
        url: '/index.php/register/edificios',
        type: 'get',
        dataType: 'json',
        error: function(err){
            console.log("problemas con los edificios");
            console.log(err);
        }
    })
    .done(function(res){
        edfs = res.buildings;
        $(res.buildings).each(function(pos, ele){
            var op = document.createElement('option');
            $(op).html(ele.replace('_', ' ')).val(ele);
            $('#edf').append(op);
        });
    });

    // Lista de apartamentos al cambiar edificio
    $('#edf').on('change', function(){
        if($(this).val() == '') return 0;

        var ed = $(this).val()
        $.ajax({
            url: '/index.php/register/apartamentos/'+ed,
            type: 'get',
            dataType: 'json',
            success: function(data){
                apts = data.apts;
                $('#apt').html('');
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
    var lista = ['name', 'surname', 'email', 'edf', 'apt', 'cond', 'pwd', 'rpwd'];
    pressEnterNext(lista);
}
