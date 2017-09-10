
function modalRemove(button){
    var modal = $(button).closest('div.modal');
    modal.modal('hide').remove();
}
