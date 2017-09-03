/* public_html/components/sim/js/newsim.js
 *
 */

window.onload = function(){

    var form = document.getElementById('form1');

    $(form).on("submit", function(event){
        event.preventDefault();

        $.ajax({
            url: "/index.php/sim/crearsim",
            type: 'post',
            dataType: 'json',
            data: $(form).serialize(),
            beforeSend: loadingBarOn(),
            error: function(err){
                console.log('Error al enviar crearsim: ', err);
            }
        })
        .always(loadingBarOff)
        .then(function(data){
            console.log(data);
            if(data.status == true){
                flashText('success', data.msg);

                setTimeout(function(){
                    window.location = '/index.php';
                }, 500);
            }
            else{
                flashText('danger', data.msg);
            }
        });
    });

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
