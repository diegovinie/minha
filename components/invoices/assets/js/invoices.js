window.onload = function(){

   var bills = 'addbills';
   tablePager(bills);

   $('#'+bills+' table td').each(function(p, ele){
       dataParser(ele);
   });
   setCheckboxRow(bills);
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
