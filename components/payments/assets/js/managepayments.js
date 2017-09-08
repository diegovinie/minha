window.onload = function(){

    var items = new Array(
        'getcurrentmonth',
        'getlastmonth',
        'getlastthreemonths'


    );

    $(items).each(function(p, item){
        getFromPayments(item);
    });

    var tableid = 'pendingpayments',
        icons = {option1: 'fa fa-edit',
                 option2: 'fa fa-times'};

    //addChoiceButtons(tableid, setApproved, setRefused, icons);
    addActionIcon(tableid, setApproved, 'fa fa-edit');
    addActionIcon(tableid, setRefused, 'fa fa-times');

/*
    var host = "core/async_payments.php?fun=aQuery&arg=";
    var aQueryTablaPrin = "core/async_payments.php?fun=aQueryTablaPrin&arg=";
    getAjax(host, 'mes_actual', setTablaMes, tdChecker)
    getAjax(host, 'mes_anterior', setTablaMes, tdChecker)
    getAjax(host, 'ultimos_tres', setTablaMes, tdChecker)
    getAjax(host, 'pagos_rechazados', setTablaMes,  tablePager)
    getAjax(host, 'pagos_aprobados', setTablaMes,  tablePager)
    getAjax(aQueryTablaPrin, 'pagos_pendientes', setTablaMes, tablePager)

    setTimeout(function(){
        var id = 'pagos_pendientes';
        var tag = 'Apartamento';
        $('#t_'+id+' tbody')? setTag(id, tag) : setTimeout(function(){
            setTag(id, tag);
        }, 2000)
    }, 200)
}
function setTag(id, tag){
    var rows = $('#t_'+id + ' tbody').find('tr');
    rows.each(function(x,tr){
        var tds = $(tr).children();
        $(tds).each(function(j,td){
            $(td).data('type') == tag?
                tr.dataset.tag = $(td).data('value') : false;
        })
    })
}

function setTablaMes(id, res, callback){
    var aa = $('#'+id)
    aa.html(res);
    if (callback) {callback(id)}
}

function explain(self){
    var row = self.parentElement.parentElement;
    var n = self.getAttribute('name')
    var prev = document.getElementById('note_' + n)
    ventana('Nota para ' + row.dataset.tag, '');

    var msj = document.createElement('div');
    var text = document.createElement('textarea');
    text.setAttribute('id', 'text_msj');
    text.setAttribute('placeholder', 'Escriba el motivo aquí');
    text.addEventListener('keydown', function(key){
        key.keyCode == 13 ? document.getElementById('bsend').click() : false;
    })
    if(prev != null){
        text.value = prev.value;
    }
    var bgroup = document.createElement('div');
    var bsend = document.createElement('button');
    bsend.setAttribute('id', 'bsend');
    bsend.innerHTML = 'Enviar';
    bsend.addEventListener('click', function(){
        var note = document.createElement('input')
        row.setAttribute('class', 'alert alert-danger');
        note.setAttribute('name', 'note_' + n)
        note.setAttribute('id', 'note_' + n)
        note.setAttribute('value', text.value)
        note.setAttribute('hidden', 'true')
        row.appendChild(note)
        document.getElementById('overlay').remove()
    });
    var bcancel = document.createElement('button');
    bcancel.innerHTML = 'Cancelar';
    bcancel.addEventListener('click', function(){
        if (prev != null){
            document.getElementById('note_' + n).remove();
        }
        self.checked = false;
        row.removeAttribute('class')
        document.getElementById('overlay').remove()
    })
    bgroup.appendChild(bsend);
    bgroup.appendChild(bcancel);

    msj.appendChild(text);
    msj.appendChild(bgroup);
    var cont = document.getElementById('ovCont');
    cont.appendChild(msj);
    document.getElementById('text_msj').focus();
*/
}

function getFromPayments(id){
    return new Promise(function(resolve, reject){
        $.ajax({
            url: '/index.php/admin/pagos/'+ id,
            type: 'get',
            dataType: 'html',
            error: function(err){
                console.log('Error en '+id+': ', err);
            }
        })
        .then(function(res){
            $('#'+id).html(res);
            $('#'+id+' td').each(function(p, td){
                dataParser(td);
            });
            resolve();
        });
    });
}

function setApproved(id){
    return new Promise(function(resolve, reject){
        $.ajax({
            url: '/index.php/admin/pagos/aprobar?id='+id,
            type: 'get',
            dataType: 'json',
            error: function(err){
                console.log('Problemas al aprobar: ', err);
            }
        })
        .then(function(data){

            if(data.status == true){
                ret = {
                    class: 'alert alert-success',
                    remove: true,
                    callback: function(){
                        [
                            'refusedpayments', 'approvedpayments'
                        ].forEach(function(id){
                            console.log(id);
                            getFromPayments(id);
                        });
                    }
                };
                resolve(ret);
            }
            else{
                console.log('Falló: ', data.msg);
                reject(data.msg);
            }
        });
    });
}

function setRefused(id){
    return new Promise(function(resolve, reject){
        $.ajax({
            url: '/index.php/admin/pagos/rechazar?id='+id,
            type: 'get',
            dataType: 'json',
            error: function(err){
                console.log('Problemas al rechazar: ', err);
            }
        })
        .then(function(data){

            if(data.status == true){
                ret = {
                    class: 'alert alert-warning',
                    remove: true,
                    callback: function(){

                        [
                            'approvedpayments', 'refusedpayments'
                        ].forEach(function(id){
                            console.log(id);
                            getFromPayments(id);
                        });
                    }
                };
                resolve(ret);
            }
            else{
                console.log('Falló: ', data.msg);
                reject(data.msg);
            }
        });
    });
}
