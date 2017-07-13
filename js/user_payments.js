window.onload = function(){
    token = new Date().getTime();
    var host = "core/async_user_payments.php?fun=pays&arg=";
    var id1 = "pagos";
    getDataAjax(host, id1, function(res){
        setTable(id1, res, function(){
            tablePager(id1, function(){
                $('#'+id1).find('tbody').children().each(function(){
                    $(this).attr('onclick', 'showInfo(this)')
                })
            })
        })
    })
    var id2 = "pagos_en_revision"
    getDataAjax(host, id2, function(res){
        setTable(id2, res, function(){
            tablePager(id2, function(){
                $('#'+id2).find('tbody').children().each(function(){
                    $(this).attr('onclick', 'showInfo(this)');
                })
            })
        })
    })
    var id3 = "devueltos"
    getDataAjax(host, id3, function(res3){
        //console.log(res3);
        setTable(id3, res3, function(){
            tablePager(id3, function(){
                $('#'+id3).find('tbody').children().each(function(){
                    //$(this).attr('onclick', 'showInfo(this)');

                })
                addEditRemoveButtons(id3, editPayment, removePayment);
            });
        });
    });
    function radioYes(self){
        console.log('yes')
    };
    function radioNo(self){
        console.log('no')
    };
    function showInfo(self){
    };
}

function newPayment(){
    return q = new Promise(function(resolve){
        $.get('templates/payment.html?'+token, function(html){
            $('body').append(html);
            var modal = $('#payment'),
                btnSubmit = $('#btnSubmit');
            modal.modal();
            $(btnSubmit).on('click', sendPayment);
            $('form').on('submit', function(ev){
                ev.preventDefault();
            });
        })
        .fail(function(err){
            console.log('Fallo al obtener payment.html');
            console.log(err);
        })
        .then(function(){
                $.ajax({
                    url: 'core/async_user_payments.php?fun=&arg=banks',
                    type: 'get',
                    dataType: 'json',
                    success: function(data){
                        new Promise(function(resolve2){
                            data.forEach(function(ele){
                                var op =document.createElement('option');
                                $(op).val(ele.bank_id).html(ele.bank_name);
                                $('#bank').append(op);
                            });
                        });
                    },
                    error: function(err){
                        console.log('Error en bancos');
                        console.log(err);
                    }
                }).then(resolve());

            $.ajax({
                url: 'core/async_user_payments.php?fun=&arg=apt',
                type: 'get',
                dataType: 'json',
                success: function(data){
                    $('#edif').val(data.bui_name);
                    $('#apt').val(data.bui_apt);
                },
                error: function(err){
                    console.log('Error en edif & apt');
                    console.log(err);
                }
            });
        })
        .then(function(){
            var list = ['date', 'type', 'n_op', 'bank', 'amount', 'notes'];
            pressEnterNext(list);
        })
        .done(function(){
            if(!navigator.userAgent.match(/Chrome/ig)){
                var dp = new dpicker(document.getElementById('date'));
            }
        });
    })
}

function editPayment(id){
    newPayment()
    .then(function(){
        $.get('core/async_user_payments.php?arg=editpayment&fun=&id='+id, function(res){
            ee = res;
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
        }, 'json');
    });
}

function removePayment(id){
    $.get('core/async_user_payments.php?arg=removepayment&fun=&id='+id, function(res){
        console.log(res);
    }, 'json');
}

function sendPayment(){
    $.ajax({
        url: 'core/async_user_payments.php',
        type: 'post',
        data: $('#payment form').serialize(),
        dataType: 'json',
        error: function(err){
            console.log('sendPayment: ' + err.responseText + ' status: ' + err.status);
        }
    }).done(function(res){
        console.log(res);
        $.get('templates/alert.html', function(html){
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
        }).fail(function(err){
            console.log('marca');
            console.log(err);
        });
    });
}
