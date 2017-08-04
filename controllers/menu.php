<?php
/*
 *
 *
 */

$_menu = array(
    'name'      => NAME,
    'version'   => VERSION,
    'session'   => $_SESSION['type'],
    'user'      => array(
        'name'      => $_SESSION['name']
    ),
    'href'      => array()
);

// Payments - Enlaces:
$_menu['href']['payments'] =  array(
        'index' => '/index.php/payments/'
);

// Profile - Enlaces:
$_menu['href']['profile'] = array(
    'profile' => '/index.php/profile'
);

// Security - Enlaces:
$_menu['href']['security'] = array(
    'logout' => '/index.php/logout'
);
