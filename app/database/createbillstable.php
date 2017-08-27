<?php
/*
 *
 */

include_once ROOTDIR.'/models/db.php';

function createBillsTable(/*string*/ $prefix=null){
    $db = connectDb($prefix);
    $prx = $db->getPrx();

    $ex = $db->exec(
        "SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE IF EXISTS {$prx}bills CASCADE;
        SET FOREIGN_KEY_CHECKS=1;"
    );

    $exe = $db->exec(
        "CREATE TABLE {$prx}bills (
          `bil_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
          `bil_date` date NOT NULL COMMENT 'Fecha de la factura',
          `bil_bui` varchar(30) CHARACTER SET utf8 NOT NULL,
          `bil_class` varchar(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'N/D' COMMENT 'Materiales, Sueldos, Proveedores Registrados',
          `bil_desc` varchar(40) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'N/D' COMMENT 'Nombre o Razon Social',
          `bil_name` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre o razon social',
          `bil_rif` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Rif o CI',
          `bil_acc_fk` tinyint(3) unsigned NOT NULL COMMENT 'Cuenta principal, Caja chica',
          `bil_method` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'TDC, TDD, Transferencia o con caja chica',
          `bil_log` varchar(30) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'N/D' COMMENT 'Factura, recibo de pago',
          `bil_lapse` int(3) unsigned DEFAULT '0' COMMENT 'Periodo de facturacion',
          `bil_amount` decimal(10,2) NOT NULL,
          `bil_iva` decimal(10,2) NOT NULL DEFAULT '0.00',
          `bil_total` decimal(10,2) NOT NULL,
          `bil_op` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Opciones especiales como fracciones por apartamento',
          `bil_user_fk` int(8) unsigned NOT NULL,
          `bil_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          
          PRIMARY KEY (`bil_id`),
          KEY `bil_fk_method` (`bil_acc_fk`),
          CONSTRAINT `{$prx}link_bil_acc` FOREIGN KEY (`bil_acc_fk`) REFERENCES `{$prx}accounts` (`acc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `{$prx}link_bil_user` FOREIGN KEY (`bil_user_fk`) REFERENCES `{$prx}users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Facturas de gastos realizados'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
