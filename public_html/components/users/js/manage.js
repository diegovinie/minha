/* public_html/components/users/manage.js
 *
 * Construye las tablas
 */

window.onload = function(){

    var items = new Array(
        'getusers',
        'getpendingusers'
    );

    $(items).each(function(p, item){
        getFromUsers(item)
        .then(function(){
            if(item == 'getpendingusers'){
                addTwoOptionsButtons(item, acceptUser, removeUser);
            }
        });
    });
    console.log('loaded');
}

/* Promesa.
 * Si resuelve no retorna nada.
 * Consulta el controlador según (id), luego pega la
 * tabla en un contenedor (id), formatea y pagina.
 */
function getFromUsers(id){
    return new Promise(function(resolve, reject){
        $.ajax({
            url: '/index.php/admin/usuarios/'+ id,
            type: 'get',
            dataType: 'html',
            error: function(err){
                console.log('Error en '+id+': ', err);
            }
        })
        .then(function(res){

            $('#'+id).html(res);
            $('#'+id+' td').each(function(p, td){
                dataParser(td);
            });

            tablePager(id);

            resolve();
        });
    });
}

/* Agrega 2 iconos activos al final de todas las filas de
 * una tabla con el id=tableid
 * Las funciones opt1 y opt2 son promesas, deben retornar:
 * [acción, tipo-de-alert]
 * Cuando acción = 'delete' elimina la fila
 */
function addTwoOptionsButtons(tableid, opt1, opt2){

    var tr = $('#'+tableid + ' tbody tr');
    tr.each(function(p, e){
        var iconOpt1 = document.createElement('a'),
            iconOpt2 = document.createElement('a');

        opt1(iconOpt1)
        .then(function(res){
            if(res[0] == 'delete'){
                $(e).addClass('alert alert-'+res[1]);
                setTimeout(function(){
                    $(e).remove();
                }, 2000);
            }
        });

        opt2(iconOpt2)
        .then(function(res){
            if(res[0] == 'delete'){
                $(e).addClass('alert alert-'+res[1]);
                setTimeout(function(){
                    $(e).remove();
                }, 2000);
            }
        });

        [iconOpt1, iconOpt2].forEach(function(ele, pos){
            var td = document.createElement('td');
            $(td).css('textAlign', 'center');
            $(td).append(ele);
            $(e).append(td);
        })
    });
}

/* Promesa.
 * Si resuelve retorna un array(resData)
 * Convierte el <a> (icon) en botón con su correspondiente
 * icono.
 * $.ajax apunta al controllers/updateuser.php y retorna:
 * json(status, msg)
 */
function acceptUser(icon){
    var resData = new Array(
        'delete',
        'success'
    );
    var updateUserTable = 'getusers';

    return new Promise(function(resolve, reject){
        $(icon).addClass('fa fa-edit').on('click', function(ev){
            var typeId = $(ev.currentTarget).parents('tr').find('td[data-type="id"]')[0];
            valueId = typeId.dataset.value;

            $.ajax({
                url: '/index.php/admin/usuarios/aceptar',
                type: 'post',
                data: {id: valueId},
                dataType: 'json',
                error: function(err){
                    console.log('Error en acceptUser: ', err);
                    reject();
                }
            })
            .then(function(res){
                console.log(res);
                res.status == true? resolve(resData) : reject(); 

                getFromUsers(updateUserTable);
            });
        });
    });
}

/* Promesa.
 * Si resuelve retorna un array(resData)
 * Convierte el <a> (icon) en botón con su correspondiente
 * icono.
 * $.ajax apunta al controllers/deleteuser.php y retorna:
 * json(status, msg)
 */
function removeUser(icon){

    var resData = new Array(
        'delete',
        'danger'
    );

    return new Promise(function(resolve, reject){
        $(icon).addClass('fa fa-times').on('click', function(ev){
            var tr = $(ev.currentTarget).parents('tr');
            var typeId = $(ev.currentTarget).parents('tr').find('td[data-type="id"]')[0];
            valueId = typeId.dataset.value;
            $(tr).addClass('alert alert-danger')

            $.ajax({
                url: '/index.php/admin/usuarios/eliminar',
                type: 'post',
                data: {id: valueId},
                dataType: 'json',
                error: function(err){
                    console.log('Error en deleteUser: ', err);
                    reject();
                }
            })
            .then(function(res){
                console.log(res);
                res.status == true? resolve(resData) : reject();
            });
        });
    });
}
