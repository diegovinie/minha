function tablePager(id, callback){
    var cantidad = 10;
    var page = 1;
    var num = 0;
    var t = $('#t_' + id)? $('#t_' + id) : $('#' + id);
    //var rows = $('#t_' + id).find('tbody').children();
    var rows = t.find('tbody').children();
    rows.each(function(x){
        num = Math.trunc(x++/10) + 1;
        $(this).attr('pag', num)
    })

    function tableSetPage(dif){
        page = page + dif
        rows.each(function(x){
            if(rows[x].getAttribute('pag') == page){
                rows[x].style.display = 'table-row';
            }else{
                rows[x].style.display = 'none';
            }
        })
    }

    function buttonsPrevNext(id){
        var group = document.createElement('div');
        group.setAttribute('align', 'center');
        var div = document.createElement('div');
        div.setAttribute('class', 'btn-group');
        var bprev = document.createElement('button');
        bprev.setAttribute('class', 'btn btn-default btn-sm');
        bprev.setAttribute('type', 'button');
        bprev.innerHTML = 'Anterior';
        bprev.addEventListener('click', function(){
            tableSetPage(-1)
            checkButtons()
        })
        var bnext = document.createElement('button');
        bnext.setAttribute('class', 'btn btn-default btn-sm');
        bnext.setAttribute('type', 'button');
        bnext.innerHTML = 'Próximo';
        bnext.addEventListener('click', function(){
            tableSetPage(1)
            checkButtons()
        })
        div.appendChild(bprev);
        div.appendChild(bnext);
        group.appendChild(div);
        document.getElementById(id).appendChild(group)

        function checkButtons(){
            if(page <= 1 && num != 1){
                bprev.setAttribute('disabled', true)
                bnext.removeAttribute('disabled')
            }else if(page > 1 && page < num){
                bnext.removeAttribute('disabled')
                bprev.removeAttribute('disabled')
            }else if(page >= num && num != 1){
                bprev.removeAttribute('disabled')
                bnext.setAttribute('disabled', true)
            }else if(page == 1 && num == 1){
                bprev.setAttribute('disabled', true)
                bnext.setAttribute('disabled', true)
            }
        }
        checkButtons()
    }
    callback? tableSetPage(0, callback(id)) : tableSetPage(0);
    buttonsPrevNext(id);
    tdChecker(id);
}

function setTable(id, content, callback){
    var aa = $('#'+id)
    aa.html(content);
    if (callback) { callback(id) }
}

function getDataAjax(h, id, callback){
    var ajax = objetoAjax();
    ajax.open("GET", h + id);
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4){
            ajax.status == 200? callback(ajax.responseText)
            : console.log('problemas de conexión: ' + id);
        }
    }
    ajax.send(null)
}

function trasTable(id){
    tabla = $('#t_'+id);
    var x = tabla.find('tr')
    x.each(function(r, v){
        v.style.float = 'left';
        v.style.display = 'block';
    })
    var y = tabla.find('td')
    y.each(function(r, v){
        v.style.display = 'block';
        v.style.textAlign = 'left';
    })
    var z = tabla.find('th')
    z.each(function(r, v){
        v.style.display = 'block';
    })
    var suma = 0;
    $('#t_'+id + ' tr').each(function(x){
        suma += parseFloat($(this).css('width'))
    })
    $('#ovCont')? $('#ovCont').css('width', suma + 70) : false;
}

function markSuccess(self){
    var row = self.parentElement.parentElement;
    self.checked == true ? row.setAttribute('class', 'alert alert-success') : row.removeAttribute('class');
}

function resetAlerts(self){
    panel = $(self).parent().parent();
    panel.find('tr').removeAttr('class');
}

function tdChecker(id){
    var group = ($('#t_'+id +' td')?
    $('#t_'+id +' td') : $('#'+id));
    group.each(function(x, td){
        dataParser(td);
    })
}

function dataParser(tag){
    var money = ['monto', 'iva', 'total', 'deuda', 'balance', 'saldo', 'cuota'];
    var date = ['fecha', 'date'];
    var rif = ['rif','/ci', 'c.i'];
    money.forEach(function(x){
        var needle = new RegExp(x, 'i');
        if (needle.test(tag.dataset.type)){
            tag.innerHTML = parseFloat(tag.dataset.value)
                .toLocaleString(undefined, { minimumFractionDigits: 2 });
            tag.style.textAlign = 'right';
        }
    });
    date.forEach(function(x){
        var needle = new RegExp(x, 'i');
        if(needle.test(tag.dataset.type)){
            var date = new Date(tag.dataset.value);
            tag.innerHTML = date.toLocaleString('es-ES',
            {year: 'numeric', month: 'numeric', day: 'numeric'});
        }
    });
    rif.forEach(function(x){
        var needle = new RegExp(x, 'i');
        if(needle.test(tag.dataset.type)){
            var v = tag.dataset.value;
            tag.innerHTML = v.slice(0,1) + '-'
            + v.slice(1,8)
            + (v.length == 10? '-' + v.slice(9) : '');
            tag.style.textAlign = 'left';

        }
    })
}

function addRadioToTable(tr, id){
    var trh = tr.parentElement.previousElementSibling.children[0],
        tdy = document.createElement('td'),
        tdn = document.createElement('td'),
        inputy = document.createElement('input'),
        inputn = document.createElement('input'),
        name;
    if($(trh).attr('id') != 'done'){
        var thy = document.createElement('th'),
            thn = document.createElement('th');
        $(trh).attr('id', 'done');
        thy.innerHTML = 'Aceptar';
        thn.innerHTML = 'Rechazar';
        trh.insertBefore(thn, trh.children[0]);
        trh.insertBefore(thy, trh.children[0]);
    }
    $(tr).children().each(function(n, td){
        td.dataset.type == id? name = td.dataset.value : false;
    })
    $(inputy).attr({'type': 'radio',
                    'name': name,
                    'value': 1,
                    'onclick':  "radioYes(this)"});
    $(inputn).attr({'type': 'radio',
                    'name': name,
                    'value': 2,
                    'onclick': "radioNo(this)"});
    tdy.appendChild(inputy);
    tdn.appendChild(inputn);
    tr.insertBefore(tdn, tr.children[0]);
    tr.insertBefore(tdy, tr.children[0]);
}
