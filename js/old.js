function move(arg){
    vis += (vis < 10 - arg || vis > rows.length - arg)? 0 : arg;
    for(var i = 0; i < rows.length; i++){
        if((i > vis-Math.abs(arg)-1) && (i <= vis-1)){
            rows.item(i).style.display = 'table-row';
        }else {
            rows.item(i).style.display = 'none';
        }
    }
}
function makeWindow(){
            var a = AjaxPromete("/minha/core/make_invoice.html")
                .then(function(res){ventana("Generar Recibos", res)});
            var b = AjaxPromete("/minha/core/query.php?fun=sel_lapse&number=0")
                .then(function(res3){return showSelect(res3)});
            Promise.all([a, b])
                .then(function(res2){document.getElementById('lapse').innerHTML = res2});
}

function makeFact(){
    function result(res){
        ventana(res, '');
        setTimeout(function(){
    //            document.getElementById('overlay').remove()
            location.reload()
        }, 2000);
    }
    var save = function(){
        AjaxPromete("/minha/core/engine.php?fun=save_fact&number=" + n)
        .then(function(r){result(r)})
    }

    var discard = function(){
        var n = document.getElementById('Gen%20Num').value
        AjaxPromete("/minha/core/engine.php?fun=discard&number=" + n)
        .then(function(r){result(r)})
    }

    var lap = document.getElementById('lapse').value
    document.getElementById('overlay').remove();
    AjaxPromete("/minha/core/engine.php?fun=generate&lapse=" + lap)
        .then(function(res){
            ventana('prueba',showUl(res))
        })
        .then(function(res2){addButtonsChoice(save, discard)})
}

function addButtonsChoice(accept, refuse){
    var buttonYes = document.createElement('button');
    buttonYes.addEventListener('click', accept);
    buttonYes.innerHTML = 'Guardar';
    var buttonNo = document.createElement('button');
    buttonNo.addEventListener('click', refuse);
    buttonNo.innerHTML = 'Descartar';
    var div = document.createElement('div');
    div.appendChild(buttonYes);
    div.appendChild(buttonNo);
    document.getElementById('ovCont').appendChild(div);
    return true;
}
