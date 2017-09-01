/* project path
 *
 * Funciones para ser usadas en formularios de propósito general
 */

///// APLICADAS A CADENAS /////

function uppercase(self, callback){
    var y;
    self.value = self.value.toUpperCase();
    callback? callback : false;
}

/* Recibe una cadena de varias palabras y devuelve la primera letra
 * en mayúscula. No retorna resultado, sino actua sobre el parámetro
 */
function capitalize(self, callback){
    //Crea un array con elementos que fueron separados por espacio
    var a = self.value.toLowerCase();
    var b = a.trim().split(" ");
    for(i = 0; i < b.length; i++){
        if(b[i] == ""){
            b.splice(i, 1);
        }
    }
    var c;
    var d = [];
    var i;
    for(i = 0; i < b.length; i++){
        //Selecciona el primer elemento del array y lo pasa a mayúscula
        c = b[i].charAt(0);
        d[i] = b[i].replace(c, c.toUpperCase());
    }
    self.value = d.join(" ");
    if (callback) { callback(); }
}

function lowercase(self){
    self.value = self.value.toLowerCase();
}

////// APLICADAS A CONTRASEÑAS /////

function check_pwdretry(input){
    var pass1 = document.getElementById("pwd_new").value,
        pass2 = input.value;
    pass1 != pass2 ?
        errorLine(input, 'las claves no coinciden') : false;
}

/* Marca el campo rojo o verde si cumple con las condiciones
 * mientras se va escribiendo. (activa)
 * Desactiva el botón enviar si no cumple con las cond.
 */
function newPwd(input){
    var min = 6,        // El mínimo
        pwdSubmitId = 'pwdSubmit',  // ID del botón enviar
        pwd = input.value;

    if(pwd.length >= min){

        $(input).parent().removeClass('has-error');
    }else{

        $('#'+pwdSubmitId).attr('disabled', true);
        $(input).parent().addClass('has-error');
    }
}

/* Marca el campo rojo o verde si las claves coinciden o no.
 * Activa o desactiva el botón enviar
 * Depende de ids externas (Activa)
 */
function checkPwdChange(input){
    var newid = 'pwd_new',      // id del input nuevo password
        opt2 = 'pwd',
        submitid = 'pwdSubmit'; // id del botón enviar

    pwdE = document.getElementById(newid);
    if(!pwdE) var pwdE = document.getElementById(opt2);

    var pwd = $(pwdE).val(),
        ret = $(input).val(),
        submit = document.getElementById(submitid);

    if(pwd === ret){

        $(submit).removeAttr('disabled');
        $(input).parent().removeClass('has-error');
    }else {

        $(submit).attr('disabled', true);
        $(input).parent().addClass('has-error');
    }
}

/* Desactiva el botón enviar y manda el mensaje flash
 * (activa)
 */
function check_pwd(input){
    var min = 6,     // El mínimo
        submit = 'pwdSubmit',   // id del botón objetivo
        msg = 'Clave demasiado corta.';

    if(input.value.length < min){
        flashText('warning', msg);
        $('#pwdSubmit').attr('disabled', true);
    }
}

///// MENSAJES Y LOADERS /////

function warningMsg(self, msg, callback){
    var alert = document.createElement('div');
    $(alert).addClass('text-warning');
    $(alert).html(msg);
    $(self).after(alert);
    setTimeout(function(){
        alert.remove();
        if(callback) {
    callback;}
    }, 2000);
}

function flashText(clss, msg){
    var flash = document.createElement('div');
    flash.innerHTML = msg;
    $(flash).addClass('text-'+clss);

    var box = document.getElementById('_flash');

    if(box){
        $(box).html('');
        $(box).append(flash);

        //input.nextElementSibling.appendChild(e);
        setTimeout(function(){
            flash.remove();
            //input.value = '';
        }, 4000);
        return true;

    }else{
        console.log('No hay caja flash.');
        return false;
    }
}

/* envoltura para flashLine
 * Input debe ser eliminado
 */
function errorLine(input, msg){
    flashText('info', msg);
}

function loadingBarOn(){
    $('#_flash').html('');
    $('#_loadingbar').css('display', 'block');
}

function loadingBarOff(){
    $('#_loadingbar').css('display', 'none');
}

///// VALIDACIONES DE DATOS /////

//Chequeos de campos
function check_names(input){
    capitalize(input, function(){
        inn = input;
        if (input.value.length > 30)
            { errorLine(input, 'muy largo')}
        else if (input.value.split(' ').length > 2)
            {errorLine(input, 'máximo dos')}
    })
}

function check_ci(input){
    var ci = input.value = input.value.toUpperCase().replace(/\./g, '').replace(/-/g, '').replace(/ /, '');
    var n = ci.slice(1),
        x = ci.slice(0, 1);
    if(ci.indexOf('-') != -1 ||ci.indexOf('-') != -1 ||
        n.length <= 5 || n.length > 8 || !parseFloat(n) ||
        ['V', 'E'].indexOf(x) == -1 ){
        errorLine(input, 'Error en C.I.');
    }
}

function check_date(input){
    var date = input.value.split('-');
    console.log(date);
    if( !(date.length == 3) ||
    !(0 < date[2] <= 31) ||
    !(0 < date[1] <= 1) ||
    !(1990 <date[0] <= 2040)){
        errorLine(input, "error en fecha");

    }
}

///// LOCALES Y MONETARIAS /////

function checkNumEsp(input){
    var num = input.value.replace(/[^0-9\.,]/g, '');
    num = num.toString().match(/,/)? num : num + ',00';
    var reg = /^\d{1,3}(\.\d{3})?(\.\d{3})?(,\d{2})?$/;
    //$(input).addClass('alert');
    if(num.match(reg)){
        $(input).addClass('alert-success').removeClass('alert-danger');
    }else{
        $(input).addClass('alert-danger').removeClass('alert-success');
        errorLine(input, 'error en número');
    }
    input.value = num;
}

/* Retornar un número con formato español
 * y una cantidad de decimales
 */
function numToSpa(amount, decimals) {
    // por si pasan un numero en vez de un string
    amount += '';
    // elimino cualquier cosa que no sea numero o punto
    amount = parseFloat(amount.replace(/[^0-9\.]/g, ''));

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0)
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

    return amount_parts.join(',');
}

/* Tomar el monto, calcular el IVA,
 * el total y pasar los datos al DOM.
 * No devuelve resultado
 */
function setIvaTotal(){
    var format = {"minimumFractionDigits": 2, "maximumFractionDigits": 2},
        eAmount = document.getElementById('amount'),
        eIva = document.getElementById('iva'),
        eTotal = document.getElementById('total'),
        eAlic = document.getElementById('alic');
    var amount = eAmount.dataset.value? eAmount.dataset.value
        : eAmount.dataset.value = eAmount.value
            .replace(',', '*').replace(/\./g, '').replace(/\*/, '.');
    amount = parseFloat(amount);
    //amount = amount.match(regx)? parseFloat(amount) : parseFloat(amount.replace(",", "."));
    //Reemplaza las comas decimales por punto antes de pasarlo a float
    //amount = parseFloat(amount.replace(",", "."));
    var alic = parseFloat(eAlic.value);
    var iva = amount * alic;
    var total = amount + (amount * alic);
    //Regresa los números a formato español y los incrusta en el DOM
    eAmount.value = amount.toLocaleString('es-ES', format);
    eIva.value = iva.toLocaleString('es-ES', format);
    eTotal.value = total.toLocaleString('es-ES', format);
    alertNumberEs(eAmount);
    $(eAmount).on('change', function(){
        $(eAmount).removeAttr('data-value');
    });
}

function toBs(number){
    return parseFloat(number)
        .toLocaleString(undefined, { minimumFractionDigits: 2 });
}

/* Verifica si el número cumple con el patrón de moneda
 * española ###.###.###,##
 */
function alertNumberEs(ele){
    var amount = ele.value;
    //$(ele).addClass('alert');
    reg2 = /^\d{1,3}(\.\d{3})?(\.\d{3})?(,\d{1,2})?$/
    if(!amount.match(reg2)){
        $(ele).addClass('alert-danger').removeClass('alert-success');
    } else{
        $(ele).addClass('alert-success').removeClass('alert-danger');
    }
}

///// EVENTOS /////

/* Ejecuta una acción [action] al pulsar enter
 *
 */
function pressEnter(evt, action){
    var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
    if(keyCode == 13){
        action();
    }
}

/* Mostrar u ocultar el botón de enviar. Parámetro booleano
 * Depende del id del botón enviar
 */
function show_submit(input){
    var submit = 'submit',      // Id del botón
        button = document.getElementById('submit');

    input == true? button.removeAttribute('disabled')
                : button.setAttribute('disabled', 'true');

}

///// DEPRECIADAS /////

function check_user(input, cond){
    var msg = cond? 'El usuario no existe.' : 'Usuario ya registrado.';
    var email = input.value = input.value.toLowerCase();

    if(input.value == '') return true;

    $.ajax({
        url: '/index.php/login/checkemail/?email=' + email,
        type: 'get',
        dataType: 'json',
        error: function(err){
            console.log('Error chequeando el email :', err);
        }
    })
    .always(function(){
        loadingBarOff();
    })
    .then(function(json){
        if(json.status !== cond) flashText('warning', msg);
    })

        /*
        h = 'core/query.php?fun=checkmail&number=';
    getAjax(h, user, function(x, t){
        if(t == !cond){ errorLine(input, msg)};
    })*/
}

function check_type(self){
    self.value = self.value.toUpperCase();
    var a = self.value;
    var list = ['PERSONAL', 'MATERIALES', 'SERVICIOS', 'BIENES', 'LEGAL'];
    if(list.indexOf(a) == -1){
        ventana('Error de selección', 'debe elegir entre: ' + list);
        self.value = '';
    }
}

//Revisar si el apartamento está en la lista incrustada en el html
function check_number(self){
    uppercase(self);
    //Toma la lista incrustada
    var a = document.getElementById('apart').innerHTML;
    //Busca si el apartamento está indexado en la lista, si no es (-1)
    if(a.indexOf(self.value) == -1){
        errorLine(self, 'No existe');
    }
}

//Buscar el tipo de proveedor y devolver su nombre y rif
//no retorna resultado, sino que modifica el DOM
