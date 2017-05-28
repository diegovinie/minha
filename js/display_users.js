window.onload = function(){
    var host = "../core/async_users.php?fun=display_users&arg=";
    var lista_id = ["usuarios_registrados", "usuarios_pendientes"];
    var id1 = "usuarios_registrados";
    getDataAjax(host, id1, function(res){
        setTable(id1, res, function(){
            tablePager(id1, function(){
                $('#'+id1).find('tbody').children().each(function(){
                    $(this).attr('onclick', 'showInfo(this)')
                })
            })
        })
    })
    var id2 = "usuarios_pendientes"
    getDataAjax(host, id2, function(res){
        setTable(id2, res, function(){
            tablePager(id2, function(){
                $('#'+id2).find('tbody').children().each(function(){
                    addRadioToTable(this, 'Correo');
                })
            })
        })
    })
}
function radioYes(self){
    console.log('yes')
};
function radioNo(self){
    console.log('no')
};
function showInfo(self){

};
