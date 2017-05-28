window.onload = function(){
    host = "../core/async_user_payments.php?fun=pays&user=<?php echo $user; ?>&arg=";
    var id1 = "pagos";
    getDataAjax(host, id1, function(res){
        setTable(id1, res, function(){
            tablePager(id1, function(){
                $('#'+id1).find('tbody').children().each(function(){
                    $(this).attr('onclick', 'showInfo(this)')
                })
            })
        })
    })
    var id2 = "pagos_en_revision"
    getDataAjax(host, id2, function(res){
        setTable(id2, res, function(){
            tablePager(id2, function(){
                $('#'+id2).find('tbody').children().each(function(){
                    $(this).attr('onclick', 'showInfo(this)');
                })
            })
        })
    })
    var id3 = "devueltos"
    getDataAjax(host, id2, function(res){
        setTable(id2, res, function(){
            tablePager(id2, function(){
                $('#'+id2).find('tbody').children().each(function(){
                    $(this).attr('onclick', 'showInfo(this)');
                })
            })
        })
    })
    function radioYes(self){
        console.log('yes')
    };
    function radioNo(self){
        console.log('no')
    };
    function showInfo(self){
    };
}
