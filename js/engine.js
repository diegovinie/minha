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
