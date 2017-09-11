window.onload = function(){

    $('form').on('click', function(ev){
        ev.preventDefault();
        displayInvoice(ev.currentTarget);
    })
}


function displayInvoice(form){

    $.ajax({
        url: '/index.php/recibos/mostrar',
        type: 'post',
        data: $(form).serialize(),
        dataType: 'html',
        error: function(err){
            console.log('Error al mostrar recibo: ', err);
        }
    })
    .then(function(pdf){
        $('#pdf').attr('src','data:application/pdf;base64,'+ pdf);
        $('#pdf').parent().removeAttr('hidden');
    });
}

function downloadInvoice(){
    var content = document.getElementById('pdf').src;
    window.open(content, "recibo.pdf");
}
