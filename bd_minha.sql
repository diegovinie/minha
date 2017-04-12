-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: bd_minha
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `backup_bills`
--

DROP TABLE IF EXISTS `backup_bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_bills` (
  `bkb_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `bkb_name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`bkb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tipo de soporte de gasto';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_bills`
--

LOCK TABLES `backup_bills` WRITE;
/*!40000 ALTER TABLE `backup_bills` DISABLE KEYS */;
INSERT INTO `backup_bills` VALUES (1,'Factura');
INSERT INTO `backup_bills` VALUES (2,'Recibo de Pago');
/*!40000 ALTER TABLE `backup_bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banks` (
  `bank_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(50) NOT NULL,
  `bank_rif` varchar(1) DEFAULT NULL,
  `bank_op` int(1) DEFAULT NULL COMMENT 'Indicador para uso futuro',
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banks`
--

LOCK TABLES `banks` WRITE;
/*!40000 ALTER TABLE `banks` DISABLE KEYS */;
INSERT INTO `banks` VALUES (1,'Banco Bicentenario, C.A.',NULL,NULL);
INSERT INTO `banks` VALUES (2,'Banco de Venezuela, S.A.',NULL,NULL);
INSERT INTO `banks` VALUES (3,'Banco del Tesoro, C.A.',NULL,NULL);
INSERT INTO `banks` VALUES (4,'Banco Provincial, S.A.',NULL,NULL);
INSERT INTO `banks` VALUES (5,'Banesco Banco Universal, C.A',NULL,NULL);
INSERT INTO `banks` VALUES (6,'BFC Banco Fondo Común, C.A.',NULL,NULL);
INSERT INTO `banks` VALUES (7,'Mercantil, C.A.',NULL,NULL);
INSERT INTO `banks` VALUES (8,'Banco Nacional de Crédito, C.A.',NULL,NULL);
INSERT INTO `banks` VALUES (9,'Banco Occidental de Descuento C.A.',NULL,NULL);
/*!40000 ALTER TABLE `banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills` (
  `bil_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `bil_date` date NOT NULL COMMENT 'Fecha de la factura',
  `bil_desc` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre o Razon Social',
  `bil_rif` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Rif o CI',
  `bil_type_fk` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Proveedor frecuente',
  `bil_lapse_fk` int(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Periodo de facturacion',
  `bil_amount` decimal(10,2) NOT NULL,
  `bil_iva` decimal(10,2) NOT NULL,
  `bil_total` decimal(10,2) NOT NULL,
  `bil_bk_fk` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Tipo de soporte',
  `bil_notes` varchar(250) COLLATE utf8_spanish_ci NOT NULL DEFAULT '' COMMENT 'Observaciones',
  `bil_user` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `bil_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bil_id`),
  KEY `bil_type_fk` (`bil_type_fk`),
  KEY `bil_lapse_fk` (`bil_lapse_fk`),
  KEY `bil_bk_fk` (`bil_bk_fk`),
  CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`bil_type_fk`) REFERENCES `usual_providers` (`up_id`),
  CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`bil_lapse_fk`) REFERENCES `lapses` (`lap_id`),
  CONSTRAINT `bills_ibfk_3` FOREIGN KEY (`bil_bk_fk`) REFERENCES `backup_bills` (`bkb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Facturas de gastos realizados';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
INSERT INTO `bills` VALUES (2,'2017-04-04','Una descripcion','22000',1,3,1000.00,120.00,1120.00,1,'Una nota','usuario','2017-04-11 16:23:06');
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_logs`
--

DROP TABLE IF EXISTS `db_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_logs` (
  `logs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `logs_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logs_user` varchar(50) NOT NULL,
  `log_query` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`logs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_logs`
--

LOCK TABLES `db_logs` WRITE;
/*!40000 ALTER TABLE `db_logs` DISABLE KEYS */;
INSERT INTO `db_logs` VALUES (1,'2017-04-09 04:08:56','login:admin@caracol','SELECT user_user, user_pwd, user_type FROM users WHERE user_user = \'admin@caracol\' AND user_pwd = \'1234\'');
INSERT INTO `db_logs` VALUES (2,'2017-04-09 04:11:25','admin@caracol','SELECT user_id FROM users WHERE user_user = \'gab@bat\'');
INSERT INTO `db_logs` VALUES (3,'2017-04-09 04:11:26','admin@caracol','INSERT INTO users VALUES (NULL, \'gab@bat\', \'1234\', \'2\', \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (4,'2017-04-09 04:11:26','admin@caracol','SELECT user_id FROM users WHERE user_user = \'gab@bat\'');
INSERT INTO `db_logs` VALUES (5,'2017-04-09 04:11:26','admin@caracol','INSERT INTO userdata VALUES (NULL, \'Gabriel\', \'Batistuta\', \'e80111234\', \'1A\', 1)');
INSERT INTO `db_logs` VALUES (6,'2017-04-09 04:12:40','admin@caracol','SELECT user_id FROM users WHERE user_user = \'admin@caracol\'');
INSERT INTO `db_logs` VALUES (7,'2017-04-09 04:12:40','admin@caracol','INSERT INTO users VALUES (NULL, \'admin@caracol\', \'1234\', \'1\', \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (8,'2017-04-09 04:12:40','admin@caracol','SELECT user_id FROM users WHERE user_user = \'admin@caracol\'');
INSERT INTO `db_logs` VALUES (9,'2017-04-09 04:12:40','admin@caracol','INSERT INTO userdata VALUES (NULL, \'Stalin\', \'Rivas\', \'v9456345\', \'9H\', 2)');
INSERT INTO `db_logs` VALUES (10,'2017-04-09 04:18:51','admin@caracol','INSERT INTO users VALUES (NULL, \'guest@caracol\', \'1234\', \'2\', \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (11,'2017-04-09 05:24:53','admin@caracol','INSERT INTO users VALUES (NULL, \'un@correo\', \'1234\', \'2\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (13,'2017-04-09 14:21:54','register:$email','INSERT INTO users VALUES (NULL, \'salo@correo\', \'1234\', 2, 0, \'register:salo@correo\', NULL)');
INSERT INTO `db_logs` VALUES (14,'2017-04-09 14:23:10','register:$email','INSERT INTO users VALUES (NULL, \'paolo@correo\', \'1234\', 2, 0, \'register:paolo@correo\', NULL)');
INSERT INTO `db_logs` VALUES (15,'2017-04-09 15:46:33','admin@caracol','UPDATE users SET user_active = 1 WHERE user_user = \'gab@bat\' OR user_user = \'salo@correo\' ');
INSERT INTO `db_logs` VALUES (16,'2017-04-09 16:17:34','register:$email','INSERT INTO users VALUES (NULL, \'pa@cor\', \'1234\', 2, 0, \'register:pa@cor\', NULL)');
INSERT INTO `db_logs` VALUES (17,'2017-04-09 16:18:05','register:$email','INSERT INTO users VALUES (NULL, \'mari@marara\', \'1234\', 2, 0, \'register:mari@marara\', NULL)');
INSERT INTO `db_logs` VALUES (18,'2017-04-09 16:18:40','admin@caracol','UPDATE users SET user_active = 1 WHERE user_user = \'gab@bat\' ');
INSERT INTO `db_logs` VALUES (19,'2017-04-09 16:20:58','admin@caracol','UPDATE users SET user_active = 1 WHERE user_user = \'gab@bat\' ');
INSERT INTO `db_logs` VALUES (20,'2017-04-09 16:50:14','admin@caracol','DELETE FROM users WHERE user_user = \'pa@cor\' OR user_user = \'mari@marara\' ');
INSERT INTO `db_logs` VALUES (21,'2017-04-09 16:55:26','admin@caracol','UPDATE users SET user_active = 1 WHERE user_user = \'salo@correo\' ');
INSERT INTO `db_logs` VALUES (22,'2017-04-09 16:55:47','register:$email','INSERT INTO users VALUES (NULL, \'che@ge\', \'1234\', 2, 0, \'register:che@ge\', NULL)');
INSERT INTO `db_logs` VALUES (23,'2017-04-09 16:56:04','admin@caracol','DELETE FROM users WHERE user_user = \'che@ge\' ');
/*!40000 ALTER TABLE `db_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lapses`
--

DROP TABLE IF EXISTS `lapses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lapses` (
  `lap_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `lap_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `lap_month` int(2) NOT NULL,
  `lap_year` int(4) NOT NULL,
  PRIMARY KEY (`lap_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lapses`
--

LOCK TABLES `lapses` WRITE;
/*!40000 ALTER TABLE `lapses` DISABLE KEYS */;
INSERT INTO `lapses` VALUES (1,'Enero 2017',1,2017);
INSERT INTO `lapses` VALUES (2,'Febrero 2017',2,2017);
INSERT INTO `lapses` VALUES (3,'Marzo 2017',3,2017);
INSERT INTO `lapses` VALUES (4,'Abril 2017',4,2017);
/*!40000 ALTER TABLE `lapses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `pay_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pay_date` date NOT NULL COMMENT 'Fecha de la operacion',
  `pay_number` varchar(6) NOT NULL COMMENT 'Apartamento',
  `pay_fk_type` int(1) NOT NULL COMMENT 'Tipo de operacion',
  `pay_op` mediumint(8) unsigned NOT NULL COMMENT 'Numero de operacion',
  `pay_fk_bank` tinyint(3) unsigned NOT NULL COMMENT 'Banco',
  `pay_amount` decimal(10,0) NOT NULL COMMENT 'Monto del pago',
  `pay_check` int(1) DEFAULT NULL COMMENT 'Si ya fue relacionado',
  `pay_obs` varchar(250) DEFAULT NULL COMMENT 'Observaciones',
  `pay_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pay_fk_udata` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`pay_id`),
  KEY `index_pay` (`pay_fk_udata`,`pay_fk_type`),
  KEY `pay_fk_bank` (`pay_fk_bank`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`pay_fk_bank`) REFERENCES `banks` (`bank_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spendings_types`
--

DROP TABLE IF EXISTS `spendings_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spendings_types` (
  `spe_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `spe_name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `spe_op` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`spe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spendings_types`
--

LOCK TABLES `spendings_types` WRITE;
/*!40000 ALTER TABLE `spendings_types` DISABLE KEYS */;
INSERT INTO `spendings_types` VALUES (1,'NO FRECUENTE',0);
INSERT INTO `spendings_types` VALUES (2,'Servicios Básicos',0);
INSERT INTO `spendings_types` VALUES (3,'Gastos de Personal',0);
/*!40000 ALTER TABLE `spendings_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userdata`
--

DROP TABLE IF EXISTS `userdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userdata` (
  `udata_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `udata_name` varchar(50) NOT NULL,
  `udata_surname` varchar(50) NOT NULL,
  `udata_ci` varchar(10) NOT NULL COMMENT 'cedula o rif',
  `udata_number` varchar(8) NOT NULL COMMENT 'numero de apartamento',
  `fk_user` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`udata_id`),
  KEY `fk_user` (`fk_user`),
  CONSTRAINT `link_users` FOREIGN KEY (`fk_user`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userdata`
--

LOCK TABLES `userdata` WRITE;
/*!40000 ALTER TABLE `userdata` DISABLE KEYS */;
INSERT INTO `userdata` VALUES (1,'Gabriel','Batistuta','e80111234','1A',1);
INSERT INTO `userdata` VALUES (2,'Stalin','Rivas','v9456345','9H',2);
INSERT INTO `userdata` VALUES (3,'Carlos','Valderrama','v20445632','6B',3);
INSERT INTO `userdata` VALUES (4,'Faustino','Asprilla','e82009342','14C',4);
INSERT INTO `userdata` VALUES (6,'Salomon','Rondon','v14000333','5e',6);
INSERT INTO `userdata` VALUES (7,'Paolo','Maldini','e83000212','15g',7);
/*!40000 ALTER TABLE `userdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_user` varchar(50) NOT NULL COMMENT 'e-mail como usuario',
  `user_pwd` varchar(50) NOT NULL,
  `user_type` int(1) NOT NULL COMMENT 'tipo de usuario',
  `user_active` int(1) DEFAULT NULL,
  `user_logged_user` varchar(50) DEFAULT NULL,
  `user_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Tabla de usuarios para el acceso';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'gab@bat','1234',2,1,'admin@caracol','2017-04-09 04:11:25');
INSERT INTO `users` VALUES (2,'admin@caracol','1234',1,1,'admin@caracol','2017-04-09 04:12:40');
INSERT INTO `users` VALUES (3,'guest@caracol','1234',2,1,'admin@caracol','2017-04-09 04:18:51');
INSERT INTO `users` VALUES (4,'un@correo','1234',2,1,'admin@caracol','2017-04-09 05:24:53');
INSERT INTO `users` VALUES (6,'salo@correo','1234',2,1,'register:salo@correo','2017-04-09 14:21:53');
INSERT INTO `users` VALUES (7,'paolo@correo','1234',2,0,'register:paolo@correo','2017-04-09 14:23:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usual_providers`
--

DROP TABLE IF EXISTS `usual_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usual_providers` (
  `up_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `up_name` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre o Razon Social',
  `up_rif` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Rif o CI',
  `up_alias` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `up_group_fk` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Tipo de gasto',
  `up_notes` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Documentacion relacionada',
  PRIMARY KEY (`up_id`),
  KEY `up_group_fk` (`up_group_fk`),
  CONSTRAINT `usual_providers_ibfk_1` FOREIGN KEY (`up_group_fk`) REFERENCES `spendings_types` (`spe_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Proveedores Frecuentes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usual_providers`
--

LOCK TABLES `usual_providers` WRITE;
/*!40000 ALTER TABLE `usual_providers` DISABLE KEYS */;
INSERT INTO `usual_providers` VALUES (1,'Proveedor Extra Ordinario','0','EXTRAORDINARIO',1,'');
INSERT INTO `usual_providers` VALUES (2,'Corporacición Eléctrica Nacional, S.A. (CORPOELEC)','G200100141','ELECTRICIDAD',1,'');
/*!40000 ALTER TABLE `usual_providers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-11 20:06:04
