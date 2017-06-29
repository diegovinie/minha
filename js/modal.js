function ventana(titulo, texto) {
    if(document.querySelector('.overlay') == null){
        var ov = document.createElement('div')
        ov.setAttribute('class', 'overlay')
        ov.setAttribute('id', 'overlay')
        document.body.appendChild(ov)
    }else{
        var ov = document.querySelector('.overlay')
    }
    var ovCont = document.createElement('div'),
        tit = document.createElement('h3'),
        cont = document.createElement('div'),
        but = document.createElement('a');

    
    but.addEventListener("click", function(){
        ov.remove()
    } )
    window.addEventListener("keydown", function(key){
        key.keyCode == 27? ov.remove() : false;
    })

    ovCont.setAttribute('class', 'overlay-content')

    ovCont.setAttribute('id', 'ovCont')
    but.setAttribute('class', 'but')
    but.innerHTML = 'X'

    tit.innerHTML = titulo
    cont.innerHTML = texto

    ovCont.appendChild(tit)
    ovCont.appendChild(cont)
    ovCont.appendChild(but)
    ov.appendChild(ovCont)
    return true
}

function hideModal(id){
    var cont = document.getElementById(id);
    cont.setAttribute('hidden', true);
}
