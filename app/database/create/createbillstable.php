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
          `bil_desc` varchar(64) NOT NULL DEFAULT 'N/D' COMMENT 'Descripcion del gasto',
          `bil_date` date NOT NULL COMMENT 'Fecha de la factura',
          `bil_bui_fk` int(8) unsigned NOT NULL COMMENT 'Enlace con edificios',
          `bil_hab_fk` int(8) unsigned NOT NULL COMMENT 'Enlace con habitantes',
          `bil_prov_fk` int(8) unsigned NOT NULL COMMENT 'Enlace con proveedores',
          `bil_acc_fk` int(8) unsigned NOT NULL COMMENT 'Cuenta principal, Caja chica',
          `bil_act_fk` int(8) unsigned NOT NULL COMMENT 'Enlace a activities',

          `bil_log` varchar(30) NOT NULL DEFAULT 'N/D' COMMENT 'Factura, recibo de pago',
          `bil_lapse` int(3) unsigned DEFAULT NULL COMMENT 'Periodo de facturacion',
          `bil_amount` decimal(10,2) NOT NULL,
          `bil_iva` decimal(10,2) NOT NULL DEFAULT '0.00',
          `bil_total` decimal(10,2) NOT NULL,
          `bil_op` int(1) unsigned DEFAULT NULL COMMENT 'Opciones especiales como fracciones por apartamento',
          `bil_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

          PRIMARY KEY (`bil_id`),
          KEY `bil_acc_fk` (`bil_acc_fk`),
          KEY `bil_hab_fk` (`bil_hab_fk`),
          KEY `bil_bui_fk` (`bil_bui_fk`),
          KEY `bil_prov_fk` (`bil_prov_fk`),
          KEY `bil_act_fk` (`bil_act_fk`),
          CONSTRAINT `{$prx}link_bil_acc` FOREIGN KEY (`bil_acc_fk`) REFERENCES `{$prx}accounts` (`acc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `{$prx}link_bil_prov` FOREIGN KEY (`bil_prov_fk`) REFERENCES `{$prx}providers` (`prov_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `{$prx}link_bil_bui` FOREIGN KEY (`bil_bui_fk`) REFERENCES `glo_buildings` (`bui_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `{$prx}link_bil_act` FOREIGN KEY (`bil_act_fk`) REFERENCES `glo_activities` (`act_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
          CONSTRAINT `{$prx}link_bil_hab` FOREIGN KEY (`bil_hab_fk`) REFERENCES `{$prx}habitants` (`hab_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Facturas de gastos realizados'"
    );

    if(!$exe){
        echo $db->errorInfo()[2];
    }

    return $exe;
}
