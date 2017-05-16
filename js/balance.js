window.onload = function(){
    var a = document.getElementsByClassName('A17_id');
    for(var i = 0; i < a.length; i++){
        a.item(i).style.display = 'none';
    }
    rows = document.getElementById('aptos').querySelectorAll('.trow');
    vis = 10;
    for(var i = vis; i < rows.length; i++ ){
        rows.item(i).style.display = 'none';
    }
    var host = "/minha/core/async_balance.php?fun=aQuery&arg=";
    var lista_id = ["balance_apartamentos", "cuentas"];
        lista_id.forEach(function(id){
        getDataAjax(host, id, function(res){
            setTable(id, res, function(){
                tablePager(id, function(){
                    $('#'+id).find('tbody').children().each(function(){
                        $(this).attr('onclick', 'showApt(this)')
                    })
                })
            })
        })
    })
}

function showApt(self){
        var url = "/minha/core/query.php";
        var arg = "?fun=show_apt&number=";
        var td = self.children.namedItem('Apartamento')
        var n = td.getAttribute('value')
        AjaxPromete("/minha/core/query.php?fun=show_apt&number=" + n)
            .then(function(res2){return showUl(res2)})
            .then(function(res3){ventana('Información Apartamento', res3)})
            .then(function(res4){addButtonUsers(n)})
}
