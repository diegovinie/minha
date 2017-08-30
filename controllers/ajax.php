<?php
/* controllers/ajax.php
 *
 */

function ajaxProgressResponse(/*int*/ $progress, /*string*/ $message=null){

    echo json_encode(array(
        'ajaxProgress'  => $progress,
        'ajaxMsg'       => $message
    ));
    flush();
    return true;
}

function ajaxFinalResponse(/*bool*/ $status, /*mixted*/ $data, /*string*/ $message=null){

    echo json_encode(array(
        'ajaxProgress' => 100,
        'status'  => $status,
        'ajaxMsg' => $message,
        'msg'     => $data
    ));
}

function ajaxErrorResponse($msg, $data=null){

    echo json_encode(array(
        'ajaxProgress' => 100,
        'status'  => false,
        'ajaxMsg' => $msg,
        'msg'     => $data
    ));

    die;
}
