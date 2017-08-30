<?php

if(isset($inputArgs['session'])){

    switch ($inputArgs['session']) {
        case '1':
            $_SESSION['user_id'] = 23;
            $_SESSION['user'] = $user;
            $_SESSION['status'] = 'active';
            $_SESSION['name'] = $values['udata_name'];
            $_SESSION['surname'] = $values['udata_surname'];
            $_SESSION['val'] = $values['user_active'];
            $_SESSION['number_id'] = $values['udata_number_fk'];
            $_SESSION['apt'] = $values['bui_apt'];
            $_SESSION['bui'] = $values['bui_name'];
            $_SESSION['type'] = 1;
            break;

        default:
            # code...
            break;
    }
}
