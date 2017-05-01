function addButtonsChoice(accept, refuse){
    var buttonYes = document.createElement('button');
    buttonYes.addEventListener('click', accept);
    buttonYes.innerHTML = 'Guardar';
    var buttonNo = document.createElement('button');
    buttonNo.addEventListener('click', refuse);
    buttonNo.innerHTML = 'Descartar';
    var div = document.createElement('div');
    div.appendChild(buttonYes);
    div.appendChild(buttonNo);
    document.getElementById('ovCont').appendChild(div);
    return true;
}
