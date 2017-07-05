function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function getAjax(h, id, third, fourth){
    var ajax = objetoAjax();
    ajax.open("GET", h + id);
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4){
            ajax.status == 200? third(id, ajax.responseText, fourth? fourth: false)
            : console.log('problemas de conexión: ' + id);
        }
    }
    ajax.send(null)
}

function AjaxPromete(datos){
    return new Promise(function(resolve, error){
        var ajax = objetoAjax();
        ajax.open("GET", datos);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4){
//                ajax.status == 200? resolve(ajax.responseText) : error('problema de conexión')
				ajax.status == 200? setTimeout(resolve, 200, ajax.responseText) : error('problema de conexión')
            }
        }
        ajax.send(null)
    }).catch(function(er){alert (er)})//.then(function(d){alert (d)})
}

function addButtonUsers(self){
    var button = document.createElement('button');
    button.setAttribute('type', 'button');
	button.setAttribute('class', 'btn btn-success btn-sm');
    button.addEventListener('click', function(){
        AjaxPromete("core/query.php?fun=show_users&number=" + self)
		.then(function(res){
			return showUl(res);
		})
		.then(function(res2){
			ventana('Usuarios Registrados', res2);
		});
	});
    button.innerHTML = 'Usuarios';
    document.getElementById('ovCont').appendChild(button);
}

function notification(response, msg, id, callback){
    var cont = document.getElementById(id);
    var alert = document.createElement('div');
    response? alert.setAttribute('class', 'alert alert-success') : alert.setAttribute('class', 'alert alert-danger');
    alert.innerHTML = msg;
    cont.appendChild(alert);
    setTimeout(function(){
        alert.remove();
        callback? callback() : false ;
    }, 5000);

}

function activateOnCheck(self, id, id2){
        var input = $('#'+id);
        self.checked ? input.removeAttr('disabled') :
        input.attr('disabled', true);
        if(id2){
          var input2 = $('#'+id2);
          self.checked ? input2.removeAttr('disabled') :
          input2.attr('disabled', true);
        }
}
