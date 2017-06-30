window.onload = function(){
    var host = "../core/async_balance.php?fun=aQuery&arg=";
    var lista_id = ["balance_apartamentos", "cuentas", "fondos"];
    lista_id.forEach(function(id){
        getDataAjax(host, id, function(res){
            setTable(id, res, function(){
                tablePager(id, function(){
                    $('#'+id).find('tbody').children().each(function(){
                        if(id == 'balance_apartamentos'){
                            $(this).attr('onclick', 'showApt(this)');
                            $(this).children()[0].setAttribute('hidden', true);
                        }
                    });
                    $('#balance_apartamentos thead th')[0].setAttribute('hidden', true);
                    var foot = $('#'+id).find('tfoot') | 1;
                    if(foot != false){
                        $('#'+id).find("[data-type='total']")
                        .each(function(){
                            dataParser(this)
                        });
                    }
                });
            });
        });
    });
    var lista2 = ["corriente", "total_fondos"];
    lista2.forEach(function(id){
        getDataAjax(host, id, function(res){
            $('#'+id).html(res);
            document.getElementById(id).dataset.value = res;
            dataParser(document.getElementById(id), function(){
                var dis = document.getElementById('disponibilidad'),
                    corr = document.getElementById('corriente').dataset.value,
                    funds = document.getElementById('total_fondos').dataset.value;
                sum = parseFloat(corr) + parseFloat(funds);
                dis.dataset.value = sum;
                dis.innerHTML = sum;
                dataParser(dis);
            });
        });
    });
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
