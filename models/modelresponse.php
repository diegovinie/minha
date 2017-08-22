<?php
/* models/jsonresponse.php
 *
 * Retorna un objeto json: {"status": $status, "msg": $msg}
 */

function jsonResponse($status, $msg){

    return json_encode(array(
        'status'    => $status,
        'msg'       => $msg
    ));
}

function jsonTableResponse($status, $data){

    return json_encode(array(
        'status' => $status,
        'table' => $data
    ));
}
