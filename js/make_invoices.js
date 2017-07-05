
function seeInvoice(self){
    var lapse = self.dataset.lapse;
    open('core/pdf_invoice.php?lapse='+lapse);
}

function saveInvoices(id){
   var cont = document.getElementById(id);
   var name = cont.dataset.value;
   $.ajax({
       type: "GET",
       url: HOSTNAME + 'core/engine.php?fun=save_fact&number=' + name,
       dataType: 'text',
       success: function (msg) {
           if (msg) {
              notification(true, msg, 'result', function(){
                  window.location.href = 'main.php';
              })
           } else {
               notification(false, "Ocurrió un error guardando", 'result');
           }
       },
   });
}

function discard(id){
    var cont = document.getElementById(id);
    var name = cont.dataset.value;
    $.ajax({
        type: "GET",
        url: HOSTNAME + 'core/engine.php?fun=discard&number=' + name,
        dataType: "text",
        success: function(msg){
            notification(false, msg, 'result', function(){
                window.location.href = 'main.php';
                console.log('echa pa atras');
            })
        }
    })
}
