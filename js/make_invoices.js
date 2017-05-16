function seeInvoice(self){
    var cont = document.getElementById('example');
    cont.removeAttribute('hidden');
}

function saveInvoices(id){
   var cont = document.getElementById(id);
   var name = 'FAC-' + cont.dataset.value;
   console.log(name);
   var data = cont.innerHTML;

   var invoices = JSON.parse(cont.innerHTML);
   console.log(invoices);
   $.ajax({
       type: "POST",
       url: "/minha/core/test.php",
       dataType: "text",
       data: {name, data},
       success: function (msg) {
           if (msg) {
               notification(true, msg, 'result', function(){
           //        window.history(-1);
                   console.log('echa pa atras');
               })
           } else {
               notification(false, "Ocurrió un error guardando", 'result');
           }
       },
   });
}
