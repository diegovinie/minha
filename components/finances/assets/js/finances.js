window.onload = function(){

    var list = [
        'aptbalances',
        'accounts',
        'funds'
    ];

    $(list).each(function(p, ele){
        tablePager(ele);
        $('#'+ele).find('td,th').each(function(p2, td){
            dataParser(td);
        });
    });

    var accounts = $('#totalaccounts').data('value'),
        funds = $('#totalfunds').data('value');

    var disp = document.getElementById('disponibility');
    disp.dataset.value = parseFloat(accounts)+parseFloat(funds);
    dataParser(disp);

    $('table [data-type="id"]').css('display', 'none');
}

function showApt(self){
    var n = self.children.namedItem('id').dataset.value;
    var id = "apartamento";
    AjaxPromete("core/async_balance.php?fun=aQueryTbody&arg=" + id +"&id=" + n)
        .then(function(res2){ventana('Información:', res2) })
        .then(function(){ trasTable(id) })
        .then(function(res4){addButtonUsers(n)})
        .then(function(res5){
            $('#t_' +id +' tbody td').each(
            function(pos, td){dataParser(td); })
        })
}

function openNewAccountDialog(){

    $.ajax({
        url: '/index.php/admin/finanzas/nuevacuenta',
        type: 'get',
        dataType: 'html',
        error: function(err){
            console.log('Error al obtener modal: ', err);
        }
    })
    .then(function(html){

        $('body').append(html);
        var account = document.getElementById('account');
        $(account).modal();
        $(account).find('form').on('submit', function(ev){

            ev.preventDefault();
            addAccount(ev.currentTarget);
        });
        //$('#account').modal();
    });
}

function addAccount(form){

    $.ajax({
        url: '/index.php/admin/finanzas/crearcuenta',
        type: 'post',
        data: $(form).serialize(),
        dataType: 'json',
        error: function(err){
            console.log('Error al crear cuenta: ', err);
        }
    })
    .then(function(data){
        if(data.status == true){
            flashText('success', data.msg);
            setTimeout(function(){
                $('#account').modal('hide').remove();
            }, 2000);
        }
        else{
            flashText('danger', data.msg);
        }
    });
}
