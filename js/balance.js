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
    var host = "../core/async_balance.php?fun=aQuery&arg=";
    var lista_id = ["balance_apartamentos", "cuentas", "fondos"];
    lista_id.forEach(function(id){
        getDataAjax(host, id, function(res){
            setTable(id, res, function(){
                tablePager(id, function(){
                    $('#'+id).find('tbody').children().each(function(){
                        $(this).attr('onclick', 'showApt(this)');
                    })
                })
            })
        })
    })
    var lista2 = ["corriente", "total_fondos"];
    lista2.forEach(function(id){
        getDataAjax(host, id, function(res){
            $('#'+id).html(res);
            document.getElementById(id).dataset.value = res;
            setTimeout(function(){
                dataParser(document.getElementById(id));
            }, 500)

        })
    })

    setTimeout(function(){
        var dis = document.getElementById('disponibilidad'),
            corr = document.getElementById('corriente').dataset.value,
            funds = document.getElementById('total_fondos').dataset.value;
        sum = parseFloat(corr) + parseFloat(funds);
        dis.dataset.value = sum;
        dis.innerHTML = sum;
        dataParser(dis);
    }, 2000)

}

function showApt(self){
    var n = self.children.namedItem('id').dataset.value;
    var id = "apartamento";
    AjaxPromete("../core/async_balance.php?fun=aQueryTbody&arg=" + id +"&id=" + n)
        .then(function(res2){ventana('Información:', res2) })
        .then(function(){ trasTable(id) })
        .then(function(res4){addButtonUsers(n)})
        .then(function(res5){
            $('#t_' +id +' tbody td').each(
            function(pos, td){dataParser(td); })
        })
}
