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
            'session'       => isset($_SESSION['role'])? $_SESSION['role'] : false,
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
                    'balance'       => '/index.php/admin/finanzas'
                ),
                // Security - Enlaces:
                'security'      => array(
                    'logout'        => '/index.php/logout'
                ),
                //Invoices - Enlaces:
                'invoices'      => array(
                    'manage'        => '/index.php/admin/recibos/',
                    'invoices'      => '/index.php/recibos'
                ),
                // Sim - Enlaces:
                'sim'           => array(
                    'login'         => '/index.php/sim',
                    'register'      => '/index.php/sim/registrarse',
                    'crear'         =>'/index.php/sim/crear'
                ),

                'bills'         => array(
                    'index'         => '/index.php/admin/gastos',
                    'new'           => '/index.php/admin/gastos/nuevo'
                )
            )
        ),
        'loading'      => 'views/widgets/loading.html.twig'
    )
);
