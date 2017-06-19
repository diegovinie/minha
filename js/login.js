window.onload = function(){
    $("form").on("submit", function(event){
    event.preventDefault();
    });
}

function sendLogin(){
    $.ajax({
        url: 'core/authentication.php',
        type: 'post',
        data: $('form').serialize(),
        dataType: 'json',
        error: function(err){
            console.log('sendLogin: ' + err.responseText + ', status: ' + err.status);
        }
    }).done(function(res){
        if(res.status == true){
            window.location = 'main.php';
        }
        if(res.status == false){
            $.get('templates/alert.html', function(html){
                $('body').append($.parseHTML(html));
                var modal = $('#alert'),
                    content = $('#alert_content'),
                    btn = $('#alert_btn');
                modal.modal();
                content.addClass('alert-danger');
                modal.on('hidden.bs.modal', function(){
                    window.location.reload();
                });
                content.html(res.msg);
                btn.on('click', function(){
                    modal.modal('hide');
                });
            }).fail(function(err){
                console.log('marca');
                console.log(err);
            });
        }
    });
}

function demoAdmin(){
    setTimeout(function(){
        //window.locate.href = "resetdb.php";
        alert('reset');
    }, (5*60*1000));
    window.location.href = "demo.php?arg=1";
}

function demoUser(){
    setTimeout(function(){
        //window.locate.href = "resetdb.php";
        alert('reset');
    }, (5*60*1000));
    window.location.href = "demo.php?arg=2";
}
