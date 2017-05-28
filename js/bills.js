window.onload = function(){
    var host = "../core/async_bills.php?fun=aQuery&arg=";
    var lista_id = ["proveedores", "gastos"];
    lista_id.forEach(function(id){
        getDataAjax(host, id, function(res){
            setTable(id, res, function(){
                tablePager(id, function(){
                    $('#'+id).find('tbody').children().each(function(){
                        $(this).attr('onclick', 'showInfo(this)')
                    })
                })
            })
        })
    })
}

function showInfo(self){
    var n = self.children.namedItem('id').dataset.value;
    var id = "mostrar_gasto";
    AjaxPromete("../core/async_bills.php?fun=aQueryTbody&arg=" + id +"&id=" + n)
        .then(function(res2){ventana('Información:', res2) })
        .then(function(){ trasTable(id) })
}
