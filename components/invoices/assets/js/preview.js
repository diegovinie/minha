window.onload = function(){

}

function discardInvoicesBatch(button){

    var number = button.dataset.number;
    var path = '/index.php/admin/recibos/descartar?number=';

    return sendResults(path + number);
}

function saveInvoicesBatch(button){

    var number = button.dataset.number;
    var path = '/index.php/admin/recibos/guardar?number=';

    return sendResults(path + number);
}

function sendResults(url){

    $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        beforeSend: loadingBarOn(),
        error: function(err){
            console.log('Error al descartar: ', err);
        }
    })
    .always(loadingBarOff)
    .then(function(data){

        if(data.status == true){
            flashText('success', data.msg);
            setTimeout(function(){
                window.location.href = '/index.php/admin/recibos';
            }, 2000);
        }
        else{
            flashText('danger', data.msg);
        }
    });
}

function seeInvoice(button){
    var id = button.dataset.number;

    $.ajax({
        url: '/index.php/recibos/mostrar',
        type: 'post',
        data: {number: id},
        dataType: 'html',
        error: function(err){
            console.log('Error al mostrar el pdf: ', err);
        }
    })
    .then(function(pdf){
        $('#pdf').attr('src','data:application/pdf;base64,'+ pdf);
        $('#pdf').parent().removeAttr('hidden');
    })
}
