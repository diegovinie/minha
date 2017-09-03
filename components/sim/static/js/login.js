window.onload = function(){
    $('#login').on('submit', function(ev){
        ev.preventDefault(ev);
        sendFormLogin();
    });
}

function sendFormLogin(){

    $.ajax({
        url: '/index.php/sim/simcheck',
        type: 'post',
        data: $('#login').serialize(),
        dataType: 'json',
        error: function(err){
            console.log("Error en sendFormLogin: ", err);
        },
        beforeSend: loadingBarOn()
    })
    .always(loadingBarOff)
    .then(function(data){
        console.log(data);
        if(data.status == false){
            flashText('danger', data.msg);
        }
        else if(data.status == 'sim') {
            var sims = $.parseHTML(data.msg);
            $('#hide').append(sims);
        }
        else if(data.status == 'new'){
            flashText('warning', data.msg);
            setTimeout(function(){
                window.location = '/index.php/sim/nuevo';
            }, 500);
        }
        else if(data.status == 1){
            window.location = '/index.php';
        }
    });
}
