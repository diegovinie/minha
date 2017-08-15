<?php
/*
 *
 *
 */

$_globals = array(
    'view'         => array(
        'menu'         => array(
            'name'          => NAME,
            'version'       => VERSION,
            'session'       => isset($_SESSION['type'])? $_SESSION['type'] : false,
            'user'          => array(
                'name'          => isset($_SESSION['name'])? $_SESSION['name'] : false,
            ),
            'href'          => array(
                // Payments - Enlaces:
                'payments'      => array(
                    'index'         => '/index.php/pagos/',
                    'manage'        => '/index.php/admin/pagos/'
                ),
                // Users - Enlaces:
                'users'         => array(
                    'manage'        => '/index.php/usuarios/',
                    'profile'       => '/index.php/usuarios/perfil'
                ),
                // Finances - Enlaces:
                'finances'      => array(
                    'balance'       => '/index.php/admin/balance'
                ),
                // Security - Enlaces:
                'security'      => array(
                    'logout'        => '/index.php/logout'
                )
            )
        ),
        'loading'      => 'views/widgets/loading.html.twig'
    )
);
