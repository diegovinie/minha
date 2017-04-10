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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-09 20:17:10
