<?php

if(isset($inputArgs['post'])){

    switch ($inputArgs['post']) {
        case 'A17':
            $_POST['bui'] = 'A17';
            break;

        default:
            # code...
            break;
    }
}
