<?php
/* models/jsonresponse.php
 *
 * Retorna un objeto json: {"status": $status, "msg": $msg}
 */

defined('_EXE') or die('Acceso restringido');

function jsonResponse(/*bool*/ $status, /*mix*/ $msg){

    return json_encode(array(
        'status'    => $status,
        'msg'       => $msg
    ));
}

function jsonTableResponse(/*bool*/ $status, /*mix*/ $data){

    return json_encode(array(
        'status' => $status,
        'table' => $data
    ));
}

/**
 * @return jsonResponse(bool, mix)
 */
function checkErrorsResponse(/*mix*/ $response, /*array*/ $cb = null){
    global $_globals;

    if(isset($_globals['errors']) && $_globals['errors'] > 0){

        // Callback si hay errores.
        if($cb) $cb[0]($cb[1], $cb[2]);

        // Recupera el registro de errores para la ejecución.
        $hdr = fopen(VARDIR.'error-'.TOKEN.'.log', 'r');
        $f = '';
        while(!feof($hdr)){
            $f .= fgets($hdr);
        }

        $err = $_globals['errors'];
        return jsonResponse(false, "Se encontraron $err errores.");
    }
    else{
        return jsonResponse(true, $response);
    }
}
