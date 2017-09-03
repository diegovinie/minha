
var form = document.getElementById('form1');

$(form).on("submit", function(event){
    event.preventDefault();

    var url = "/index.php/sim/crearsim",
        method = "POST",
        //data = $("form").serialize();
        data = new FormData(form);
    //console.log(data);

    sendRequest(method, url, data);
});

function sendRequest(method, url, data){
    if (!window.XMLHttpRequest){
        alert("Your browser does not support the native XMLHttpRequest object.");
        return;
    }
    try{
        var xhr = new XMLHttpRequest();
        xhr.previous_text = '';
        var result;
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
                        }, 800);
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

        xhr.open(method, url, true);

        xhr.send(data);
    }
    catch (e){
        console.log("[XHR REQUEST] Exception: " + e);
    }
}
