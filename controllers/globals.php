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
            'session'       => $_SESSION['type'],
            'user'          => array(
                'name'          => $_SESSION['name'],
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
