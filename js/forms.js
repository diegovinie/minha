function uppercase(self){
    var y;
    self.value = self.value.toUpperCase();
}

//Recibe una cadena de varias palabras y devuelve la primera letra
//en mayúscula. No retorna resultado, sino actua sobre el parámetro
function capitalize(self){
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
}

function lowercase(self){
    self.value = self.value.toLowerCase();
}

//Validar la clave. No retorna resultado, sino que actúa sobre el DOM
function val_pwd(){
    var pass1 = document.getElementById("pwd").value;
    var pass2 = document.getElementById("rpwd").value;
    document.getElementById("pwd_e").style.display = (pass1 == pass2) ? 'none' : 'block';
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
    var op = 0;
    if (a != 0){
        //Reviso todo el json hasta encontrar donde se igualan los datos del
        //parámetro, luego paso nombre y rif al DOM
        for(var i = 0; i < k.length; i++){
            if(k[i].up_id == a){
                ename.value = k[i].up_name;
                erif.value = k[i].up_rif;
                etype.value = k[i].spe_name;
                var op = k[i].up_op;
            }
        }
    }else{
        ename.value = '';
        erif.value =  '';
        etype.value =  '';
    }
    //Si paso nombre y rif almacenados hago que los campos sean inmodificables
    if(a != 0){
        ename.setAttribute('readonly', 'true');
        erif.setAttribute('readonly', 'true');

        if(op != 2){
            etype.setAttribute('readonly', 'true');
        }else{
            etype.removeAttribute('readonly');
        }
    }else{
        ename.removeAttribute('readonly');
        erif.removeAttribute('readonly');
        etype.removeAttribute('readonly');
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

//Tomar el monto, calcular el IVA, el total y pasar los datos al DOM.
//No devuelve resultado
function setIvaTotal(){
    var amount = document.getElementById('amount').value;
    //Reemplaza las comas decimales por punto antes de pasarlo a float
    amount = parseFloat(amount.replace(",", "."));
    var alic = parseFloat(document.getElementById('alic').value);
    var iva = amount * alic;
    var total = amount + (amount * alic);
    //Regresa los números a formato español y los incrusta en el DOM
    document.getElementById('amount').value = numToSpa(amount, 2);
    document.getElementById('iva').value = numToSpa(iva, 2);
    document.getElementById('total').value =  numToSpa(total, 2);
}

//Mostrar u ocultar el botón de enviar. Parámetro booleano
function show_submit(self){
    document.getElementById('submit').style.display = self == 'true'? 'inline' : 'none';
}

//Revisar si el apartamento está en la lista incrustada en el html
function check_number(self){
    uppercase(self);
    //Toma la lista incrustada
    var a = document.getElementById('apart').innerHTML;
    //Busca si el apartamento está indexado en la lista, si no es (-1)
    if(a.indexOf(self.value) == -1){
        alert('No existe');
        show_submit('false');
    }else{
        show_submit('true');
    }
}
