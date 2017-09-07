function genPdf(item){
    var fun = item.dataset.fun;
    window.open(model + '?wrapper=genPdf&fun=' + fun);
}

function tablePager(id, callback){
    var cantidad = 10;
    var page = 1;
    var num = 0;
    var t = $('#'+id+' table');
    //var t = $('#t_' + id)? $('#t_' + id) : $('#' + id);
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

function trasTable(id, callback){
    var tabla = $('#t_'+id);
    var x = tabla.find('tr'),
        y = tabla.find('td'),
        z = tabla.find('th'),
        suma = 0;
    tabla.find('thead, tbody, tfoot').each(function(){
        $(this).css('float', 'left');
    });
    x.each(function(r, v){
        v.style.float = 'left';
        v.style.display = 'block';
    });
    y.each(function(r, v){
        v.style.display = 'block';
        v.style.textAlign = 'left';
    });
    z.each(function(r, v){
        v.style.display = 'block';
    });
    x.each(function(x){
        var w = parseFloat($(this).css('width'));
        suma += w;
    });
    $('#ovCont')? $('#ovCont').css('width', suma + 70) : void(0);
    //$(tabla).css('width', suma + 25);
    if(callback) callback();
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

function dataParser(tag, callback){
    var money = ['monto', 'iva', 'total', 'deuda', 'balance', 'saldo', 'cuota'];
    var date = ['fecha', 'date'];
    var rif = ['rif','/ci', '[^a-z]ci[^oóa]'];
    var others = ['asignado', 'ocupado'];
    var bills = ['Cargado'];
    money.forEach(function(x){
        var needle = new RegExp(x, 'i');
        if (needle.test(tag.dataset.type) && tag.dataset.value){
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
    });
    others.forEach(function(x){
        var needle = new RegExp(x, 'i');

        if(needle.test(tag.dataset.type)){
            var bool = tag.dataset.value;
            tag.innerHTML = bool == 1? "Sí" : "No";
        }
    });
    bills.forEach(function(x){
        var needle = new RegExp(x, 'i');

        if(needle.test(tag.dataset.type)){
            switch (tag.dataset.value) {
                case '0':
                    tag.innerHTML = 'Por Relacionar';
                    break;
                case '99':
                    tag.innerHTML = 'En revisión';
                    break;
                default:
                    tag.innerHTML = periodo(tag.dataset.value);
            }
        }
        function periodo(number){
            var mes = {
                1: 'Enero',
                2: 'Febrero',
                3: 'Marzo',
                4: 'Abril',
                5: 'Mayo',
                6: 'Junio',
                7: 'Julio',
                8: 'Agosto',
                9: 'Septiembre',
                10: 'Octubre',
                11: 'Noviembre',
                12: 'Diciembre'
            };
            var year = 2017;
            while(number > 12){
                ++year;
                number = number -12;
            }
            return mes[number] + '/' + year;
        }
    })

    if(callback) callback();
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

function pressEnterNext(list){
    $('#'+list[0]).focus();
    $(list).each(function(pos, id_n){
        var input = $('#'+id_n);
        var valid = 'input, button, select';
        input.on('keypress', function(evt){
            var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
            if(keyCode == 13){
                evt.preventDefault();
                var next = document.getElementById(list[pos+1]);
                next? $(next).focus() : findernext(this, valid);
            }
        });
    });
    function findernext(i, valid){
        var input = $(i);
        var $next = input.parent().next().find(valid);
        if($next.is(valid)){
            $next.each(function(pos, ele){
                if(ele.type === "submit") $(ele).focus();
            });
        }else{
            $next = input.parent().parent().next();
            if($next.is(valid)){
                $next.each(function(pos, ele){
                    if(ele.type === "submit") $(ele).focus();
                });
            }else{
                $next = input.parent().next().next().find(valid);
                if($next.is(valid)){
                    $next.each(function(pos, ele){
                        if(ele.type === "submit") $(ele).focus();
                    });
                }else{
                    $next = $(this).next();
                    if($next.is(valid)){
                        $next.each(function(pos, ele){
                            if(ele.type === "submit") $$(ele).focus();
                        });
                    }else{
                        next = input.parent().parent().next().next();
                        if($(next)){
                            $(next).focus();
                        }else {
                            throw "Problema con el cambio de elemento con enter";
                        }
                    }
                }
            }
        }
    }
}

function addChoiceButtons(tableid, promOpt1, promOpt2, icons){
    var tr = $('#'+tableid + ' tbody tr');
    tr.each(function(p, e){
        var op1 = document.createElement('a'),
            op2 = document.createElement('a');

        $(op1).addClass(icons.option1).on('click', function(ev){
            var typeId = $(ev.currentTarget).parents('tr').find('td[data-type="id"]')[0];
            valueId = parseInt(typeId.dataset.value);

            if(typeof valueId == "number"){
                promOpt1(valueId)
                .then(function(res){
                    $(tr).addClass('alert').addClass('alert-'+res.alert);
                    if(res.delete){
                        setTimeout(function(){
                            $(tr).remove();
                        }, 1000);
                    }
                    if(res.callback) res.callback();
                })
                .catch(function(err){
                    console.log('ocurrió un error: ', err);
                });
            }
            else{
                throw 'No hay Id';
            }
        });

        $(op2).addClass(icons.option2).on('click', function(ev){
            var typeId = $(ev.currentTarget).parents('tr').find('td[data-type="id"]')[0];
            valueId = parseInt(typeId.dataset.value);

            if(typeof valueId == "number"){
                promOpt2(valueId)
                .then(function(res){
                    $(tr).addClass('alert').addClass('alert-'+res.alert);
                    if(res.delete){
                        setTimeout(function(){
                            $(tr).remove();
                        }, 1000);
                    }
                    if(res.callback) res.callback();
                })
                .catch(function(err){
                    console.log('ocurrió un error: ', err);
                });
            }
        });
        [op1, op2].forEach(function(ele, pos){
            var td = document.createElement('td');
            $(td).css('textAlign', 'center');
            $(td).append(ele);
            $(e).append(td);
        });
    });
}

function addEditRemoveButtons(tableid, edit, remove){
    var tr = $('#'+tableid + ' tbody tr');
    tr.each(function(p, e){
        var edt = document.createElement('a'),
            rem = document.createElement('a');
        $(edt).addClass('fa fa-edit').on('click', function(ev){
            var typeId = $(ev.currentTarget).parents('tr').find('td[data-type="id"]')[0];
            valueId = typeId.dataset.value;
            edit(valueId);
        });

        $(rem).addClass('fa fa-times').on('click', function(ev){
            var tr = $(ev.currentTarget).parents('tr');
            var typeId = $(ev.currentTarget).parents('tr').find('td[data-type="id"]')[0];
            valueId = typeId.dataset.value;
            remove(valueId);
            setTimeout(function(){
                $(tr).remove();
            }, 2000);
            $(tr).addClass('alert alert-danger')
        });

        [edt, rem].forEach(function(ele, pos){
            var td = document.createElement('td');
            $(td).css('textAlign', 'center');
            $(td).append(ele);
            $(e).append(td);
        })
    });
}



function setCheckboxRow(id){

    var rows = $('#'+id+' table tbody').find('tr');
        th = document.createElement('th');

    $(th).css('textAlign', 'center')
         .html('Agregar');
    $('#'+id+' table thead tr').append(th);

    rows.each(function(pos,ele){
        var td = document.createElement('td'),
            inp = document.createElement('input');

        var name = $(this).find('[name="id"]').data('value');
        $(inp).attr('type', 'checkbox')
              .attr('name', 'chk_'+name).val(1);
        $(td).css('textAlign', 'center')
             .append(inp);

        $(this).append(td);
    });
}
