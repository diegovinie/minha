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
    button.addEventListener('click', function(){
        AjaxPromete("/minha/core/query.php?fun=show_users&number=" + self).then(function(res){return showUl(res)}).then(function(res2){ventana('Usuarios Registrados', res2)})})
    button.innerHTML = 'Usuarios';
    document.getElementById('ovCont').appendChild(button);
}
