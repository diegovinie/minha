window.onload = function(){

    $('table [data-type="id"]').css('display', 'none');
}

function showInfo(self){
    var n = self.children.namedItem('id').dataset.value;
    var id = "mostrar_gasto";
    AjaxPromete("../core/async_bills.php?fun=aQueryTbody&arg=" + id +"&id=" + n)
    .then(function(res2){ventana('Información:', res2) })
    .then(function(){
        trasTable(id, function(){
            $('#t_'+id +' td').each(function(c, ele){
                dataParser(ele);
            });
        });
    });
}
