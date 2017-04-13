function uppercase(self){
    var y;
    self.value = self.value.toUpperCase();
}


function capitalize(self){
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
//        b[i] = b[i].trim();
        c = b[i].charAt(0);
        d[i] = b[i].replace(c, c.toUpperCase());
    }
    self.value = d.join(" ");
}

function lowercase(self){
    self.value = self.value.toLowerCase();
}

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

function numToSpa(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

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

function fun1(self){
    var a = self.value;
    var j = document.getElementById("proveedor").innerHTML;
    var k = JSON.parse(j);
    for(var i = 0; i < k.length; i++){
        if(k[i].up_id == a){
            var ename = document.getElementById("name");
            ename.value = k[i].up_name;
            var erif = document.getElementById("rif");
            erif.value = k[i].up_rif;
        }
    }
    if(a != 1){
        ename.setAttribute('readonly', 'true');
        erif.setAttribute('readonly', 'true');
    }else{
        ename.removeAttribute('readonly');
        erif.removeAttribute('readonly');
    }
}

function setIvaTotal(){
    var amount = document.getElementById('amount').value;
    amount = parseFloat(amount.replace(",", "."));
    var alic = parseFloat(document.getElementById('alic').value);
    var iva = amount * alic;
    var total = amount + (amount * alic);
    document.getElementById('amount').value = numToSpa(amount, 2);
    document.getElementById('iva').value = numToSpa(iva, 2);
    document.getElementById('total').value =  numToSpa(total, 2);
}

function show_submit(self){
    document.getElementById('submit').style.display = self == 'true'? 'inline' : 'none';
}

function check_number(self){
    uppercase(self);
    var a = document.getElementById('apart').innerHTML;
    if(a.indexOf(self.value) == -1){
        alert('No existe');
        show_submit('false');
    }else{
        show_submit('true');
    }
}
