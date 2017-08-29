window.onload = function(){

   var bills = 'addbills';
   tablePager(bills);

   $('#'+bills+' table td').each(function(p, ele){
       dataParser(ele);
   });
   setCheckboxRow(bills);
   /*

   var host = "core/async_invoices.php?fun=show_funds&arg=";
   var id = "fondos";
   getDataAjax(host, id, function(res){
       var container = document.getElementById("accordion");
       var divRes = document.createElement('div');
       divRes.innerHTML = res;
       $(divRes).find('td').each(function(n, td){
           dataParser(td);
       })
       while(divRes.firstChild) {
           container.appendChild(divRes.firstChild);
       }
   });
   var host2 = "core/async_invoices.php?fun=show_bills&arg=";
   var id2 = "agregar_gastos";
   getDataAjax(host2, id2, function(res2){
       var container = document.getElementById(id2);
       container.innerHTML = res2;
       tablePager(id2, function(){
           var thead = $('#'+id2).find('thead tr');
           var th = document.createElement('th');
           th.innerHTML = 'Agregar';
           thead.append(th);
           var tbody = $('#'+id2).find('tbody');
           tbody.children().each(function(x){
               var e = document.createElement('td');
               var input = document.createElement('input');
               input.setAttribute('type', 'checkbox');
               var n = this.children[0].innerHTML
               input.setAttribute('name', n);
               input.value = 1;
               e.appendChild(input);
               $(this).append(e);
           })
       });
   })
   $('#gen').attr('disabled', true);
   document.getElementById('ready').checked = false;
   */
}

function activateOnCheck(chk, id){

    var ids = typeof id == "string" ? [id] : id;

    $(ids).each(function(){

        if(chk.checked){
            $('#'+this).removeAttr('disabled');
        }
        else{
            $('#'+this).attr('disabled', 'true');
        }
    });
}
