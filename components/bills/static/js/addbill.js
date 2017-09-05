window.onload = function(){

    var form = document.getElementById('addbill');
    $(form).on('submit', function(ev){
        ev.preventDefault();

        $.ajax({
            url: '/index.php/admin/gastos/agregar',
            type: 'post',
            data: $(form).serialize(),
            dataType: 'json',
            beforeSend: loadingBarOn(),
            error: function(err){
                console.log('Error al enviar: ', err);
            }
        })
        .always(loadingBarOff)
        .then(function(data){
            console.log(data);
            if(data.status == true){
                flashText('success', data.msg);
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
            else{
                flashText('danger', data.msg);
            }
        });
    });

    var types = document.getElementById('type');
    $(types).on('change', function(){

        var id = types.options[types.selectedIndex].value;

        $.ajax({
            url: '/index.php/admin/gastos/getactivities?id='+id,
            type: 'get',
            dataType: 'json',
            error: function(err){
                console.log("Error al recuperar actividades: ", err);
            }
        })
        .then(function(data){
            var select = document.getElementById('act');

            if(data.status == true){
                $(select).html('');

                var opt = document.createElement('option');
                $(opt).html('Seleccione:');
                $(select).append(opt);

                data.msg.forEach(function(item){
                    var option = document.createElement('option');

                    $(option).val(item.id);
                    $(option).html(item.name);
                    $(select).append(option);
                });
            }
        });
    });

    var activities = document.getElementById('act');
    $(activities).on('change', function(){

        var id = activities.options[activities.selectedIndex].value;

        $.ajax({
            url: '/index.php/admin/gastos/getproviders?id='+id,
            type: 'get',
            dataType: 'json',
            error: function(err){
                console.log("Error al recuperar proveedores: ", err);
            }
        })
        .then(function(data){
            var select = document.getElementById('prov');

            if(data.status == true){
                $(select).html('');

                var opt = document.createElement('option');
                $(opt).html('Seleccione:');
                $(select).append(opt);

                data.msg.forEach(function(item){
                    var option = document.createElement('option');

                    $(option).val(item.id);
                    $(option).html(item.name);
                    option.dataset.name = item.name;
                    option.dataset.alias = item.alias;
                    option.dataset.rif = item.rif;
                    $(select).append(option);
                });

                var option = document.createElement('option');
                $(option).val(0);
                $(option).html('Otro Proveedor');
                $(select).append(option);
            }
        });
    });
}

function selectProvider(select){

    var selected = select.options[select.selectedIndex];
    var rif = selected.dataset.rif,
        name = selected.dataset.name;

    $('#rif').val(rif);
    $('#name').val(name);
}
