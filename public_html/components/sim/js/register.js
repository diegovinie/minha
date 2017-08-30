/* public_html/components/demo/js/register.js
 *
 */

window.onload = function(){

    var form = document.getElementById('form1');

    $(form).on("submit", function(event){
        event.preventDefault();

        var url = "/index.php/sim/crear",
            method = "POST",
            //data = $("form").serialize();
            data = new FormData(form);
        //console.log(data);

        sendRequest(method, url, data);
    });



    // Lista de edificios en el select
    $.ajax({
        url: '/index.php/register/edificios',
        type: 'get',
        dataType: 'json',
        error: function(err){
            console.log("problemas con los edificios");
            console.log(err);
        }
    })
    .done(function(res){
        edfs = res.buildings;
        $(res.buildings).each(function(pos, ele){
            var op = document.createElement('option');
            $(op).html(ele.replace('_', ' ')).val(ele);
            $('#edf').append(op);
        });
    });

    // Lista de apartamentos al cambiar edificio
    $('#edf').on('change', function(){
        if($(this).val() == '') return 0;

        var ed = $(this).val()
        $.ajax({
            url: '/index.php/register/apartamentos/'+ed,
            type: 'get',
            dataType: 'json',
            success: function(data){
                apts = data.apts;
                $('#apt').html('');
                $(data.apts).each(function(pos, ele){
                    var op = document.createElement('option');
                    $(op).html(ele).val(ele);
                    $('#apt').append(op);
                })
            },
            error: function(err){
                console.log('Recibiendo apts: ' +err.responseText + ' estatus: '+ err.status);
            }
        });
    });
    var lista = ['name', 'surname', 'email', 'edf', 'apt', 'cond', 'pwd', 'rpwd'];
    pressEnterNext(lista);
}

function sendRequest(method, url, data){
    if (!window.XMLHttpRequest){
        alert("Your browser does not support the native XMLHttpRequest object.");
        return;
    }
    try{
        var xhr = new XMLHttpRequest();
        xhr.previous_text = '';
        var result;
        console.log(xhr);
        xhr.onerror = function() {
            console.log("[XHR] Fatal Error.");
        };

        xhr.onreadystatechange = function() {
            try{
                $('#progressbar').css('display', 'block');

                if (xhr.readyState == 4){

                    console.log(result);

                    if(result.status == true){
                        setTimeout(function(){
                            window.location.href="/index.php/";
                        }, 1000);
                    }
                }
                else if (xhr.readyState > 2){
                    var newResponse = xhr.responseText.substring(xhr.previous_text.length);

                    result = JSON.parse( newResponse );

                    document.getElementById("_msg").innerHTML = result.ajaxMsg;
                    document.getElementById('_progress').style.width = result.ajaxProgress + "%";

                    xhr.previous_text = xhr.responseText;
                }
            }
            catch (e){
                console.log("[XHR STATECHANGE] Exception: " + e);
                console.log(xhr);
            }
        };

        xhr.open("POST", "/index.php/sim/crear", true);

        xhr.send(data);
    }
    catch (e){
        console.log("[XHR REQUEST] Exception: " + e);
    }
}

function simCreationDone(i){
    console.log(i);
    console.log(i.response.substring(previous_text.length));
}
