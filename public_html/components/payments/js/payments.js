window.onload = function(){
    token = new Date().getTime();

    var ids = ['getpayments', 'getpendingpayments', 'getreturnedpayments'];
    $(ids).each(function(pos, id){
        $.ajax({
            url: '/index.php/payments/' + id,
            type: 'get',
            dataType: 'html',
            error: function(err){
                console.log('Error en '+id+': ', err);
            }
        })
        .then(function(html){
            if(html == false ){
                $('#'+id).html('<div align="center">No se encontraron registros.</div>');
            }else{
                $('#'+id).html(html);
                tablePager(id, function(){
                    if(id === 'getreturnedpayments'){
                        addEditRemoveButtons(id, editPayment, removePayment);
                    }else{
                        $('#'+id).find('tbody').children().each(function(){
                            $(this).attr('onclick', 'showInfo(this)')
                        });
                    }
                });
            }
        });
    })
}

function newPayment(){
    return new Promise(function(resolve, reject){
        $.ajax({
            url: '/index.php/payments/add',
            type: 'get',
            dataType: 'html',
            error: function(err){
                console.log('Error al traer la plantilla: ', err);
            }
        })
        .then(function(html){
            $('body').append(html);
            var modal = $('#payment'),
                btnSubmit = $('#btnSubmit');
            modal.modal();
            $(btnSubmit).on('click', sendPayment);
            $('form').on('submit', function(ev){
                ev.preventDefault();
            });
        })
        .then(function(){
            var list = ['date', 'type', 'n_op', 'bank', 'amount', 'notes'];
            pressEnterNext(list);
        })
        .then(function(){
            if(!navigator.userAgent.match(/Chrome/ig)){
                var dp = new dpicker(document.getElementById('date'));
            }
            resolve();
        });
    })
}

function editPayment(id){
    newPayment()
    .then(function(){
        return new Promise(function(resolve,reject){
            $.ajax({
                url: '/index.php/payments/edit/?id='+id,
                type: 'get',
                dataType: 'json',
                error: function(err){
                    console.log('Error en editPayment: ', err);
                    reject(err);
                },
                success: function(json){
                    resolve(json);
                }
            });
        });
    })
    .then(function(json){
        var res = json.data;
        ['chk', 'id'].forEach(function(ele, pos){
            var e = document.createElement('input');
            $(e).attr('hidden', true).attr('name', ele).attr('value', (pos == 0? 0 : id));
            $('#payment form').append(e);
        });
        document.getElementById('amount').value = res.Monto;
        document.getElementById('date').value = res.Fecha;
        document.getElementById('type').selectedIndex = res.type -1;
        document.getElementById('bank').selectedIndex = res.bankid;
        document.getElementById('n_op').value = res.n_op;
        document.getElementById('notes').value = res.notes;
    })

}

function removePayment(id){
    $.get('/index.php/payments/remove/?id='+id, function(res){
        console.log(res);
    }, 'json');
}

function sendPayment(){
    $.ajax({
        url: '/index.php/payments/sendpayment',
        type: 'post',
        data: $('#payment form').serialize(),
        dataType: 'json',
        error: function(err){
            console.log('Error sendpayment: ', err);
        }
    })
    .then(function(res){
        console.log(res);
        $.get('/index.php/views/modals/alert.html', function(html){
            $('body').append($.parseHTML(html));
            var modal = $('#alert'),
                content = $('#alert_content'),
                btn = $('#alert_btn');
            modal.modal();
            content.html(res.msg);
            modal.on('hidden.bs.modal', function(){
                window.location.reload();
            });
            btn.on('click', function(){
                    modal.modal('hide');
            });
            if(res.status == true){
                content.addClass('alert-success');
            }else{
                content.addClass('alert-danger');
            }
        })
        .fail(function(err){
            console.log('Error en el modal: ', err);
        });
    });
}
