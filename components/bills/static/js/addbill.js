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
}

function selectProvider(select){

    var selected = select.options[select.selectedIndex];
    var rif = selected.dataset.rif,
        name = selected.dataset.name;

    $('#rif').val(rif);
    $('#name').val(name);
}

function select_prov(self){
    var a = self.value;
    //Tomo el json incrustado en el html y lo analizo
    var j = document.getElementById("proveedor").innerHTML;
    var k = JSON.parse(j);
    var ename = document.getElementById("name");
    var erif = document.getElementById("rif");
    var etype = document.getElementById("spe_type");
    var edesc = document.getElementById("desc");
    var eop = document.getElementById("up_op");
    var op;
    if (a != 0){
        //Reviso todo el json hasta encontrar donde se igualan los datos del
        //parámetro, luego paso nombre y rif al DOM
        for(var i = 0; i < k.length; i++){
            if(k[i].up_id == a){
                ename.value = k[i].up_name;
                erif.value = k[i].up_rif;
                etype.value = k[i].spe_name;
                edesc.value = k[i].up_desc;
                op = k[i].up_op;
                document.getElementById('up_op_'+ k[i].up_op).setAttribute('selected', true);
                document.getElementById('up_fk_type_' + k[i].up_fk_type).setAttribute('selected', true);
            }
        }
    }else{
        ename.value = '';
        erif.value =  '';
        etype.value =  '';
        edesc.value = '';
    }
    //Si paso nombre y rif almacenados hago que los campos sean inmodificables
    if(a != 0){
        ename.setAttribute('readonly', 'true');
        erif.setAttribute('readonly', 'true');
        eop.setAttribute('readonly', true);

        if(op != 2){
            etype.setAttribute('readonly', 'true');
        }else{
            etype.removeAttribute('readonly');
        }
    }else{
        ename.removeAttribute('readonly');
        erif.removeAttribute('readonly');
        etype.removeAttribute('readonly');
        eop.removeAttribute('readonly');
    }
}
