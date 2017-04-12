function uppercase(self){
    var y;
    self.value = self.value.toUpperCase();
    y = self.value.split(" ");
    alert(y);
    var x = [];
    var i;
}


function capitalize(self){
    var a = self.value.toLowerCase();
    var b = a.trim().split(" ");
    alert(b);
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
    alert(d);
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
