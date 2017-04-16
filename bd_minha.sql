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
-- Table structure for table `A17`
--

DROP TABLE IF EXISTS `A17`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `A17` (
  `A17_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `A17_number` varchar(3) NOT NULL,
  `A17_weight` decimal(8,4) NOT NULL COMMENT 'Porcentaje ponderado',
  `A17_assigned` tinyint(1) NOT NULL DEFAULT '1',
  `A17_occupied` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Si esta habitado',
  `A17_notes` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`A17_id`),
  UNIQUE KEY `A17_number_2` (`A17_number`),
  KEY `A17_number` (`A17_number`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `A17`
--

LOCK TABLES `A17` WRITE;
/*!40000 ALTER TABLE `A17` DISABLE KEYS */;
INSERT INTO `A17` VALUES (1,'1A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (2,'1B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (3,'1C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (4,'1D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (5,'1E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (6,'1F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (7,'1G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (8,'1H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (9,'2A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (10,'2B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (11,'2C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (12,'2D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (13,'2E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (14,'2F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (15,'2G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (16,'2H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (17,'3A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (18,'3B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (19,'3C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (20,'3D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (21,'3E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (22,'3F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (23,'3G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (24,'3H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (25,'4A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (26,'4B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (27,'4C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (28,'4D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (29,'4E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (30,'4F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (31,'4G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (32,'4H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (33,'5A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (34,'5B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (35,'5C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (36,'5D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (37,'5E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (38,'5F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (39,'5G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (40,'5H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (41,'6A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (42,'6B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (43,'6C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (44,'6D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (45,'6E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (46,'6F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (47,'6G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (48,'6H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (49,'7A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (50,'7B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (51,'7C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (52,'7D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (53,'7E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (54,'7F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (55,'7G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (56,'7H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (57,'8A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (58,'8B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (59,'8C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (60,'8D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (61,'8E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (62,'8F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (63,'8G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (64,'8H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (65,'9A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (66,'9B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (67,'9C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (68,'9D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (69,'9E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (70,'9F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (71,'9G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (72,'9H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (73,'10A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (74,'10B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (75,'10C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (76,'10D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (77,'10E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (78,'10F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (79,'10G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (80,'10H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (81,'11A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (82,'11B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (83,'11C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (84,'11D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (85,'11E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (86,'11F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (87,'11G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (88,'11H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (89,'12A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (90,'12B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (91,'12C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (92,'12D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (93,'12E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (94,'12F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (95,'12G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (96,'12H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (97,'13A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (98,'13B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (99,'13C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (100,'13D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (101,'13E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (102,'13F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (103,'13G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (104,'13H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (105,'14A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (106,'14B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (107,'14C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (108,'14D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (109,'14E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (110,'14F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (111,'14G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (112,'14H',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (113,'15A',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (114,'15B',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (115,'15C',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (116,'15D',1.2498,1,1,NULL);
INSERT INTO `A17` VALUES (117,'15E',0.8332,1,1,NULL);
INSERT INTO `A17` VALUES (118,'15F',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (119,'15G',0.4166,1,1,NULL);
INSERT INTO `A17` VALUES (120,'15H',0.8332,1,1,NULL);
/*!40000 ALTER TABLE `A17` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Facturas de gastos realizados';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
INSERT INTO `bills` VALUES (2,'2017-04-04','Una descripcion','22000',1,3,1000.00,120.00,1120.00,1,'Una nota','usuario','2017-04-11 16:23:06');
INSERT INTO `bills` VALUES (3,'2017-04-12','Corporacición Eléctrica Nacional, S.A. (CORPOELEC)','G200100141',2,3,1111.00,133.32,1244.32,1,'','admin@caracol','2017-04-12 15:51:54');
INSERT INTO `bills` VALUES (4,'2017-04-11','Pedro Perez','V12331313',1,4,12121.21,1454.55,13575.76,2,'El señor se róbo la desmalezadora','admin@caracol','2017-04-12 15:55:08');
INSERT INTO `bills` VALUES (5,'2017-01-01','Hidrológica de la Regio Capital, C.A. (HIDROCAPITAL)','G200121076',3,3,5512.12,661.45,6173.57,1,'ninguna','admin@caracol','2017-04-14 16:45:27');
INSERT INTO `bills` VALUES (6,'2017-04-16','María Laura Mora Torta','V13900343',6,4,85000.00,0.00,85000.00,2,'            ','admin@caracol','2017-04-16 17:47:36');
INSERT INTO `bills` VALUES (7,'2017-04-15','Proyectos Técnicos, S.A.','J311429506',5,4,15490.70,1858.88,17349.58,1,'            ','admin@caracol','2017-04-16 17:48:12');
INSERT INTO `bills` VALUES (8,'2017-04-13','varios Proveedores','J000000000',7,4,23000.00,2760.00,25760.00,1,'20 bolsas de basura\r\n2 lts de detergente','admin@caracol','2017-04-16 17:49:29');
INSERT INTO `bills` VALUES (9,'2017-04-13','Hidrológica de la Regio Capital, C.A. (HIDROCAPITAL)','G200121076',3,4,8500.00,1020.00,9520.00,1,'            ','admin@caracol','2017-04-16 17:54:38');
INSERT INTO `bills` VALUES (10,'2017-04-16','Corporacición Eléctrica Nacional, S.A. (CORPOELEC)','G200100141',2,4,60000.44,7200.05,67200.49,1,'            ','admin@caracol','2017-04-16 17:56:01');
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
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
INSERT INTO `db_logs` VALUES (24,'2017-04-12 15:51:55','admin@caracol','INSERT INTO bills VALUES (NULL, \'2017-04-12\', \'Corporacición Eléctrica Nacional, S.A. (CORPOELEC)\', \'G200100141\', \'2\', \'4\', \'1111\', \'133.32\', \'1244.32\', \'1\', \'\', \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (25,'2017-04-12 15:55:08','admin@caracol','INSERT INTO bills VALUES (NULL, \'2017-04-11\', \'Pedro Perez\', \'V12331313\', \'1\', \'3\', \'12121.21\', \'1454.55\', \'13575.76\', \'2\', \'El señor se róbo la desmalezadora\', \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (26,'2017-04-13 01:37:06','register:$email','INSERT INTO users VALUES (NULL, \'dennis@berk\', \'1234\', 2, 0, \'register:dennis@berk\', NULL)');
INSERT INTO `db_logs` VALUES (27,'2017-04-13 14:51:09','admin@caracol','INSERT INTO users VALUES (NULL, \'oleg@caracol\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (28,'2017-04-13 14:54:20','admin@caracol','INSERT INTO users VALUES (NULL, \'oleg@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (29,'2017-04-13 14:55:30','admin@caracol','INSERT INTO users VALUES (NULL, \'ole@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (30,'2017-04-13 23:56:30','admin@caracol','INSERT INTO users VALUES (NULL, \'u1n@correo\', \'1234\', \'2\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (31,'2017-04-14 00:20:10','admin@caracol','INSERT INTO users VALUES (NULL, \'cheto@correo\', \'1234\', \'2\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (32,'2017-04-14 00:24:58','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (33,'2017-04-14 00:26:04','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (34,'2017-04-14 00:28:04','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (35,'2017-04-14 00:29:05','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (36,'2017-04-14 00:29:37','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (37,'2017-04-14 00:32:02','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (38,'2017-04-14 00:34:00','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (39,'2017-04-14 00:37:04','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (40,'2017-04-14 00:39:44','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (41,'2017-04-14 00:42:23','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (42,'2017-04-14 00:44:40','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (43,'2017-04-14 00:45:55','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (44,'2017-04-14 00:49:53','admin@caracol','INSERT INTO users VALUES (NULL, \'pun@correo\', \'1234\', \'1\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (45,'2017-04-14 00:51:35','admin@caracol','INSERT INTO users VALUES (NULL, \'puen@correo\', \'1234\', \'2\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (46,'2017-04-14 00:55:35','admin@caracol','INSERT INTO users VALUES (NULL, \'diego@caracol\', \'1234\', \'2\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (47,'2017-04-14 01:02:17','register:$email','INSERT INTO users VALUES (NULL, \'meri@mat\', \'1234\', 2, 0, \'register:meri@mat\', NULL)');
INSERT INTO `db_logs` VALUES (48,'2017-04-14 16:43:15','register:$email','INSERT INTO users VALUES (NULL, \'luz@gmail.com\', \'1234\', 2, 0, \'register:luz@gmail.com\', NULL)');
INSERT INTO `db_logs` VALUES (49,'2017-04-14 16:43:53','admin@caracol','UPDATE users SET user_active = 1 WHERE user_user = \'luz@gmail_com\' ');
INSERT INTO `db_logs` VALUES (50,'2017-04-14 16:45:27','admin@caracol','INSERT INTO bills VALUES (NULL, \'2017-01-01\', \'Hidrológica de la Regio Capital, C.A. (HIDROCAPITAL)\', \'G200121076\', \'3\', \'4\', \'5512.12\', \'661.45\', \'6173.57\', \'1\', \'ninguna\', \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (51,'2017-04-14 17:13:08','admin@caracol','INSERT INTO users VALUES (NULL, \'punn@correo\', \'1234\', \'2\', 1, \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (52,'2017-04-16 17:47:36','admin@caracol','INSERT INTO bills VALUES (NULL, \'2017-04-16\', \'María Laura Mora Torta\', \'V13900343\', \'6\', \'4\', \'85\', \'0\', \'85\', \'2\', \'            \', \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (53,'2017-04-16 17:48:12','admin@caracol','INSERT INTO bills VALUES (NULL, \'2017-04-15\', \'Proyectos Técnicos, S.A.\', \'J311429506\', \'5\', \'4\', \'15490.7\', \'1858.88\', \'17349.58\', \'1\', \'            \', \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (54,'2017-04-16 17:49:29','admin@caracol','INSERT INTO bills VALUES (NULL, \'2017-04-13\', \'varios Proveedores\', \'J000000000\', \'7\', \'4\', \'23000\', \'2760\', \'25760\', \'1\', \'20 bolsas de basura\r\n2 lts de detergente\', \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (55,'2017-04-16 17:54:38','admin@caracol','INSERT INTO bills VALUES (NULL, \'2017-04-13\', \'Hidrológica de la Regio Capital, C.A. (HIDROCAPITAL)\', \'G200121076\', \'3\', \'4\', \'8500\', \'1020\', \'9520\', \'1\', \'            \', \'admin@caracol\', NULL)');
INSERT INTO `db_logs` VALUES (56,'2017-04-16 17:56:01','admin@caracol','INSERT INTO bills VALUES (NULL, \'2017-04-16\', \'Corporacición Eléctrica Nacional, S.A. (CORPOELEC)\', \'G200100141\', \'2\', \'4\', \'60000.44\', \'7200.05\', \'67200.49\', \'1\', \'            \', \'admin@caracol\', NULL)');
/*!40000 ALTER TABLE `db_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `display_users`
--

DROP TABLE IF EXISTS `display_users`;
/*!50001 DROP VIEW IF EXISTS `display_users`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `display_users` AS SELECT 
 1 AS `Nombre`,
 1 AS `Apellido`,
 1 AS `C.I.`,
 1 AS `Apartamento`,
 1 AS `Correo`,
 1 AS `Tipo de Usuario`*/;
SET character_set_client = @saved_cs_client;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spendings_types`
--

LOCK TABLES `spendings_types` WRITE;
/*!40000 ALTER TABLE `spendings_types` DISABLE KEYS */;
INSERT INTO `spendings_types` VALUES (1,'NO FRECUENTE',0);
INSERT INTO `spendings_types` VALUES (2,'Servicios Básicos',0);
INSERT INTO `spendings_types` VALUES (3,'Gastos de Personal',0);
INSERT INTO `spendings_types` VALUES (4,'Servicios Básicos',0);
INSERT INTO `spendings_types` VALUES (5,'Servicios Ocasionales',0);
INSERT INTO `spendings_types` VALUES (6,'Trabajador Ocasional',0);
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
  `udata_number_fk` tinyint(3) unsigned NOT NULL COMMENT 'numero de apartamento',
  `udata_user_fk` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`udata_id`),
  KEY `fk_user` (`udata_user_fk`),
  KEY `udata_number_fk` (`udata_number_fk`),
  CONSTRAINT `link_users` FOREIGN KEY (`udata_user_fk`) REFERENCES `users` (`user_id`),
  CONSTRAINT `userdata_ibfk_1` FOREIGN KEY (`udata_number_fk`) REFERENCES `A17` (`A17_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userdata`
--

LOCK TABLES `userdata` WRITE;
/*!40000 ALTER TABLE `userdata` DISABLE KEYS */;
INSERT INTO `userdata` VALUES (1,'Gabriel','Batistuta','e80111234',1,1);
INSERT INTO `userdata` VALUES (2,'Stalin','Rivas','v9456345',2,2);
INSERT INTO `userdata` VALUES (3,'Carlos','Valderrama','v20445632',3,3);
INSERT INTO `userdata` VALUES (4,'Faustino','Asprilla','e82009342',4,4);
INSERT INTO `userdata` VALUES (6,'Salomon','Rondon','v14000333',5,6);
INSERT INTO `userdata` VALUES (7,'Paolo','Maldini','e83000212',5,7);
INSERT INTO `userdata` VALUES (8,'Dennis Adolfo','Berkham','E80445765',7,8);
INSERT INTO `userdata` VALUES (10,'Nombre','Apellido','V999999',29,26);
INSERT INTO `userdata` VALUES (11,'Nombre','Apellido','V999999',3,27);
INSERT INTO `userdata` VALUES (12,'Diego Jose','Viniegra Villalobos','V14891345',78,28);
INSERT INTO `userdata` VALUES (13,'Meridian','Matova','E88282822',78,29);
INSERT INTO `userdata` VALUES (14,'Luz Marina','Villalobos Alvarez','E81447878',78,30);
INSERT INTO `userdata` VALUES (15,'nombre','apellido','v999999',1,31);
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='Tabla de usuarios para el acceso';
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
INSERT INTO `users` VALUES (8,'dennis@berk','1234',2,0,'register:dennis@berk','2017-04-13 01:37:06');
INSERT INTO `users` VALUES (9,'oleg@caracol','1234',1,1,'admin@caracol','2017-04-13 14:51:09');
INSERT INTO `users` VALUES (10,'oleg@correo','1234',1,1,'admin@caracol','2017-04-13 14:54:20');
INSERT INTO `users` VALUES (11,'ole@correo','1234',1,1,'admin@caracol','2017-04-13 14:55:30');
INSERT INTO `users` VALUES (12,'u1n@correo','1234',2,1,'admin@caracol','2017-04-13 23:56:30');
INSERT INTO `users` VALUES (26,'pun@correo','1234',1,1,'admin@caracol','2017-04-14 00:49:53');
INSERT INTO `users` VALUES (27,'puen@correo','1234',2,1,'admin@caracol','2017-04-14 00:51:35');
INSERT INTO `users` VALUES (28,'diego@caracol','1234',2,1,'admin@caracol','2017-04-14 00:55:35');
INSERT INTO `users` VALUES (29,'meri@mat','1234',2,0,'register:meri@mat','2017-04-14 01:02:16');
INSERT INTO `users` VALUES (30,'luz@gmail.com','1234',2,0,'register:luz@gmail.com','2017-04-14 16:43:15');
INSERT INTO `users` VALUES (31,'punn@correo','1234',2,1,'admin@caracol','2017-04-14 17:13:08');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Proveedores Frecuentes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usual_providers`
--

LOCK TABLES `usual_providers` WRITE;
/*!40000 ALTER TABLE `usual_providers` DISABLE KEYS */;
INSERT INTO `usual_providers` VALUES (1,'Proveedor','','EXTRAORDINARIO',5,'');
INSERT INTO `usual_providers` VALUES (2,'Corporacición Eléctrica Nacional, S.A. (CORPOELEC)','G200100141','ELECTRICIDAD',2,'');
INSERT INTO `usual_providers` VALUES (3,'Hidrológica de la Regio Capital, C.A. (HIDROCAPITAL)','G200121076','HIDROCAPITAL',2,NULL);
INSERT INTO `usual_providers` VALUES (4,'José Alfredo Tamayo','V20112432','Jardinero',3,'Trabaja martes y jueves');
INSERT INTO `usual_providers` VALUES (5,'Proyectos Técnicos, S.A.','J311429506','MANT. ASCENSORES',1,NULL);
INSERT INTO `usual_providers` VALUES (6,'María Laura Mora Torta','V13900343','LIMPIEZA EDIFICIO',1,NULL);
INSERT INTO `usual_providers` VALUES (7,'varios Proveedores','J000000000','INSUMOS MANT.',1,NULL);
/*!40000 ALTER TABLE `usual_providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `display_users`
--

/*!50001 DROP VIEW IF EXISTS `display_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `display_users` AS select `userdata`.`udata_name` AS `Nombre`,`userdata`.`udata_surname` AS `Apellido`,`userdata`.`udata_ci` AS `C.I.`,`A17`.`A17_number` AS `Apartamento`,`users`.`user_user` AS `Correo`,`users`.`user_type` AS `Tipo de Usuario` from ((`users` join `userdata`) join `A17`) where ((`userdata`.`udata_user_fk` = `users`.`user_id`) and (`userdata`.`udata_number_fk` = `A17`.`A17_id`) and (`users`.`user_active` = 1)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-16 15:50:39
