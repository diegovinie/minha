var model = '../core/async_payments.php';

window.onload = function(){
    var host = "../core/async_payments.php?fun=aQuery&arg=";
    var aQueryTablaPrin = "../core/async_payments.php?fun=aQueryTablaPrin&arg=";
    getAjax(host, 'mes_actual', setTablaMes, tdChecker)
    getAjax(host, 'mes_anterior', setTablaMes, tdChecker)
    getAjax(host, 'ultimos_tres', setTablaMes, tdChecker)
    getAjax(host, 'pagos_rechazados', setTablaMes,  tablePager)
    getAjax(host, 'pagos_aprobados', setTablaMes,  tablePager)
    getAjax(host, 'pagos_pendientes', setTablaMes, tablePager)

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

}
