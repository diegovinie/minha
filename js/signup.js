window.onload = function(){
    $("form").on("submit", function(event){
        event.preventDefault();
        $.ajax({
            url: 'core/async_users.php',
            type: 'post',
            data: $('form').serialize(),
            dataType: 'json',
            success: function(data){
                $.get('templates/alert.html').done(function(html){
                    $('body').append(html);
                    var modal = $('#alert'),
                        content = $('#alert_content'),
                        btn = $('#alert_btn');

                    content.html(data.msg);
                    btn.on('click', function(){
                        modal.modal('hide');
                    });
                    modal.on('hidden.bs.modal', function(){
                        if(data.status == true){
                            window.location.href = 'login.php';
                        }else{
                            window.location.reload();
                        }
                    });
                    content.addClass(data.status == true?
                        'alert-success' : 'alert-danger');
                    modal.modal();
                });
            },
            error: function(err){
                console.log('Error al enviar: ');
                console.log(err);
            }
        });
    });
    $.get('files/INDEX.json')
    .done(function(res){
        edfs = res.buildings;
        $(res.buildings).each(function(pos, ele){
            var op = document.createElement('option');
            $(op).html(ele.replace('_', ' ')).val(ele);
            $('#edf').append(op);
        });
    });

    $('#edf').on('change', function(){
        if($(this).val() == '') return 0;

        var ed = $(this).val()
        $.ajax({
            url: 'files/EDI-'+ed+'.json',
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
    })
}
