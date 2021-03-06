function uppercase(self, callback){
    var y;
    self.value = self.value.toUpperCase();
    callback? callback : false;
}

//Recibe una cadena de varias palabras y devuelve la primera letra
//en mayúscula. No retorna resultado, sino actua sobre el parámetro
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

//Validar la clave. No retorna resultado, sino que actúa sobre el DOM

//Eventos
function pressEnter(evt, action){
    var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
    if(keyCode == 13){
        action();
    }
}

//Mostrar u ocultar el botón de enviar. Parámetro booleano
function show_submit(self){
    var button = document.getElementById('submit');
    self == true? button.removeAttribute('disabled')
                : button.setAttribute('disabled', 'true');
    //document.getElementById('submit').style.display = self == 'true'? 'inline' : 'none';
}

//Passwords
function check_pwdretry(input){
    var pass1 = document.getElementById("pwd").value,
        pass2 = input.value;
    pass1 != pass2 ?
        errorLine(input, 'las claves no coinciden') : false;
}

function newPwd(self){
    var pwd = self.value;
    if(pwd.length > 5){
        $(self).parent().removeClass('has-error');
    }else{
        $('#pwdSubmit').attr('disabled', true);
        $(self).parent().addClass('has-error');
    }
}

function checkPwdChange(self){
    var pwd = $('#pwd').val(),
        ret = $(self).val();
    if(pwd === ret){
        $('#pwdSubmit').removeAttr('disabled');
        $(self).parent().removeClass('has-error');
    }else {
        $('#pwdSubmit').attr('disabled', true);
        $(self).parent().addClass('has-error');
    }
}

function check_pwd(input){
    if(input.value.length < 6){
        warningMsg(input, 'demasiado corto');
        $('#pwdSubmit').attr('disabled', true);
    }
}

//Mensajes
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

function errorLine(input, msg){
    var e = document.createElement('div');
    e.innerHTML = msg;
    $(e).css('color', 'red');
    input.nextElementSibling.appendChild(e);
    setTimeout(function(){
        e.remove();
        input.value = '';
    }, 1500);
}

var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
 num +='';
 var splitStr = num.split('.');
 var splitLeft = splitStr[0];
 var splitRight = splitStr.length &gt; 1 ? this.sepDecimal + splitStr[1] : '';
 var regx = /(\d+)(\d{3})/;
 while (regx.test(splitLeft)) {
 splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
 }
 return this.simbol + splitLeft +splitRight;
 },
 new:function(num, simbol){
 this.simbol = simbol ||'';
 return this.formatear(num);
 }
}

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
//Retornar un número con formato español y una cantidad de decimales
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

//Buscar el tipo de proveedor y devolver su nombre y rif
//no retorna resultado, sino que modifica el DOM
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

function check_user(input, cond){
    var msg = cond? 'usuario no existe' : 'usuario ya registrado';
    var user = input.value = input.value.toLowerCase();
        h = 'core/query.php?fun=checkmail&number=';
    getAjax(h, user, function(x, t){
        if(t == !cond){ errorLine(input, msg)};
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

function check_type(self){
    self.value = self.value.toUpperCase();
    var a = self.value;
    var list = ['PERSONAL', 'MATERIALES', 'SERVICIOS', 'BIENES', 'LEGAL'];
    if(list.indexOf(a) == -1){
        ventana('Error de selección', 'debe elegir entre: ' + list);
        self.value = '';
    }
}

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

//Tomar el monto, calcular el IVA, el total y pasar los datos al DOM.
//No devuelve resultado
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

/*$.ajax({
    url:'hostname',
    type:'get',
    dataType:'text',
    success: function(response){
        HOSTNAME = response;
    }
});*/
