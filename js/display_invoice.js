window.onload = function(){
    $('form').on('submit', function(ev){
        ev.preventDefault();
        aja = $.ajax({
            url: 'core/pdf_invoice.php',
            type: 'post',
            dataType: 'html',
            data: $(this).serialize(),
            success: function(res){
                $('#pdf').attr('src','data:application/pdf;base64,'+ res);
                $('#pdf').parent().removeAttr('hidden');
            },
            error: function(er){
                console.log('error con el PDF:');
                console.log(er);
            }
        });
    });
}

function sendMail(){
    $.ajax({
        url: 'core/pdf_invoice.php?fun=sendmail',
        type: 'post',
        dataType: 'json',
        data: $('form').serialize(),
        success: function(res){
            $.get('templates/alert.html', function(html){
                $('body').append($.parseHTML(html));
                var modal = $('#alert'),
                    content = $('#alert_content'),
                    btn = $('#alert_btn');
                modal.modal();

                content.html(res.msg);
                btn.on('click', function(){
                    modal.modal('hide');
                });
                if(res.status == true){
                    content.addClass('alert-success');
                }else{
                    content.addClass('alert-danger');
                }
            });
        },
        error: function(err){
            console.log(err);
        }
    });
}

function downloadInvoice(){
    var content = document.getElementById('pdf').src;
    window.open(content, "recibo.pdf");
}
