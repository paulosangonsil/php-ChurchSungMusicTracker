CREATE DATABASE  IF NOT EXISTS `escolhamusica` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `escolhamusica`;
-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: escolhamusica
-- ------------------------------------------------------
-- Server version	8.0.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `escolhamusica_tb_categ`
--

DROP TABLE IF EXISTS `escolhamusica_tb_categ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escolhamusica_tb_categ` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escolhamusica_tb_categ`
--

LOCK TABLES `escolhamusica_tb_categ` WRITE;
/*!40000 ALTER TABLE `escolhamusica_tb_categ` DISABLE KEYS */;
INSERT INTO `escolhamusica_tb_categ` VALUES (1,'Adoraci&oacute;n'),(2,'Alabanza');
/*!40000 ALTER TABLE `escolhamusica_tb_categ` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escolhamusica_tb_exec`
--

DROP TABLE IF EXISTS `escolhamusica_tb_exec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escolhamusica_tb_exec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `songs` varchar(500) NOT NULL,
  `date` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `song_idx` (`songs`),
  KEY `user_idx` (`user`),
  CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `escolhamusica_tb_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escolhamusica_tb_exec`
--

LOCK TABLES `escolhamusica_tb_exec` WRITE;
/*!40000 ALTER TABLE `escolhamusica_tb_exec` DISABLE KEYS */;
INSERT INTO `escolhamusica_tb_exec` VALUES (1,1,'1;2;3;4;5',20190417),(2,1,'9;6;7;8',20190418),(3,1,'10;11;12',20190502),(4,1,'1;69;16;15',20190516),(5,1,'19;23;25;31;52;5',20190606),(6,1,'27;45;2;24;36',20190613),(7,1,'21;29;14;44;22',20190620),(8,1,'30;27;69;5',20190622),(9,1,'34;28;17;40;56',20190627),(10,1,'54;59;26;49;50',20190704),(11,1,'35;37;55;47;71',20190718),(12,1,'65;13;10;67;43',20190725),(13,1,'42;72;32;60;48',20190801),(14,1,'33;68;62;58;22',20190808),(15,1,'73;19;27;34;22;24',20190822),(16,1,'25;53;66;4;57',20190901),(17,1,'28;35',20190905),(18,1,'6;13;9;8;62',20190916),(19,1,'21;40;22;66;24',20190923),(20,1,'14;30;9;24;61',20190929),(21,1,'31;68;23;64;41;51',20190930),(22,1,'30;25;47;46;56;5',20191007),(23,1,'1;52;39;15;44;36',20191014),(24,1,'54;74;11;8;60;4',20191021),(25,1,'20;9;24;55;56',20191111),(26,1,'14;62;48;57',20191118),(27,1,'16;19;49;44;40',20191125),(28,1,'6;45;32;50;51',20191202),(29,1,'2;7;57;55;58',20191209);
/*!40000 ALTER TABLE `escolhamusica_tb_exec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escolhamusica_tb_singer`
--

DROP TABLE IF EXISTS `escolhamusica_tb_singer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escolhamusica_tb_singer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escolhamusica_tb_singer`
--

LOCK TABLES `escolhamusica_tb_singer` WRITE;
/*!40000 ALTER TABLE `escolhamusica_tb_singer` DISABLE KEYS */;
INSERT INTO `escolhamusica_tb_singer` VALUES (1,'Barak'),(2,'Kabed'),(3,'Miel San Marcos'),(4,'Jos&eacute; Luis Reyes'),(5,'Julio Melgar'),(6,'New Wine'),(7,'Marco Barrientos'),(8,'Marcos Witt'),(9,'Art Aguillera'),(10,'Marcos Brunet'),(11,'Christine D&apos;Clario'),(12,'Way Maker'),(13,'BJ Putnam'),(14,'En Espiritu y En Verdad'),(15,'Alex Campos'),(16,'Emir Sensini'),(17,'Generaci&oacute;n 12'),(18,'Danilo Montero'),(19,'Juan Carlos Alvarado'),(20,'Danny Berrios'),(21,'Marcela Gandara'),(22,'Jes&uacute;s Adri&aacute;n Romero'),(23,'Coalo Zamorano'),(24,'Ingrid Rosario'),(25,'Hillsong'),(26,'Gladys Mu&ntilde;oz'),(27,'Israel Houston'),(28,'Doris Machin'),(29,'Davi Sacer'),(30,'Toque no Altar');
/*!40000 ALTER TABLE `escolhamusica_tb_singer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escolhamusica_tb_song`
--

DROP TABLE IF EXISTS `escolhamusica_tb_song`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escolhamusica_tb_song` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `singer` int(10) unsigned NOT NULL,
  `category` int(10) unsigned NOT NULL,
  `category_aux` longblob,
  `link_ytube` varchar(500) DEFAULT NULL,
  `link_pback_ytube` varchar(500) DEFAULT NULL,
  `notes` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_idx` (`category`),
  KEY `singer_idx` (`singer`),
  CONSTRAINT `category` FOREIGN KEY (`category`) REFERENCES `escolhamusica_tb_categ` (`id`) ON DELETE CASCADE,
  CONSTRAINT `singer` FOREIGN KEY (`singer`) REFERENCES `escolhamusica_tb_singer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escolhamusica_tb_song`
--

LOCK TABLES `escolhamusica_tb_song` WRITE;
/*!40000 ALTER TABLE `escolhamusica_tb_song` DISABLE KEYS */;
INSERT INTO `escolhamusica_tb_song` VALUES (1,'Ven Esp&iacute;ritu Santo Ven',1,1,NULL,NULL,NULL,NULL),(2,'In&uacute;ndanos',2,1,NULL,NULL,NULL,NULL),(3,'Danzo En El R&iacute;o',3,2,NULL,NULL,NULL,NULL),(4,'Eres Incre&iacute;ble',3,2,NULL,NULL,NULL,NULL),(5,'Los Muros Caer&aacute;n',3,2,NULL,NULL,NULL,NULL),(6,'Est&aacute; Cayendo',4,1,NULL,NULL,NULL,NULL),(7,'Recibe Toda la Gloria',5,1,NULL,NULL,NULL,NULL),(8,'Grande y Fuerte',3,2,NULL,NULL,NULL,NULL),(9,'Incomprensible Amor',6,1,NULL,NULL,NULL,NULL),(10,'Ven Esp&iacute;ritu Ven',7,1,NULL,NULL,NULL,NULL),(11,'Gracias',8,1,NULL,NULL,NULL,NULL),(12,'Yo Te Busco',8,1,NULL,NULL,NULL,NULL),(13,'Creo En Ti',5,1,NULL,NULL,NULL,NULL),(14,'Digno',10,1,NULL,NULL,NULL,NULL),(15,'Hay Libertad',9,2,NULL,NULL,NULL,NULL),(16,'Libre',3,1,NULL,'https://www.youtube.com/watch?v=oRlSy7lwWTY',NULL,NULL),(17,'No Hay Lugar M&aacute;s Alto',11,1,NULL,NULL,NULL,NULL),(19,'Por Mi Muri&oacute;',7,1,NULL,NULL,NULL,NULL),(20,'La Tierra Canta',1,1,NULL,NULL,NULL,NULL),(21,'Te Quiero Adorar',1,1,NULL,NULL,NULL,NULL),(22,'Libre Soy',1,2,NULL,NULL,NULL,NULL),(23,'Tu Eres Rey',11,1,NULL,NULL,NULL,NULL),(24,'Glorioso',13,2,NULL,NULL,NULL,NULL),(25,'Admirable',11,1,NULL,NULL,NULL,NULL),(26,'Como Dijiste',11,1,NULL,NULL,NULL,NULL),(27,'Dios de Lo Imposible',11,1,NULL,NULL,NULL,NULL),(28,'Dios de Maravillas',11,1,NULL,NULL,NULL,NULL),(29,'Que Se Abra El Cielo',11,1,NULL,NULL,NULL,NULL),(30,'Rey',11,1,NULL,NULL,NULL,NULL),(31,'Hoy Te Rindo Mi Ser',23,1,NULL,NULL,NULL,NULL),(32,'La Casa de Dios',18,2,NULL,NULL,NULL,NULL),(33,'Dios Cuida de Mi',20,1,NULL,NULL,NULL,NULL),(34,'Gracia Sublime Es',16,1,NULL,NULL,NULL,NULL),(35,'El Gran Yo Soy',14,1,NULL,NULL,NULL,NULL),(36,'Te Doy Gloria',14,2,NULL,NULL,NULL,NULL),(37,'Todo lo Haces Nuevo',17,1,NULL,NULL,NULL,NULL),(38,'Hermoso Nombre',17,1,NULL,NULL,NULL,NULL),(39,'Digno y Santo',24,1,NULL,NULL,NULL,NULL),(40,'Te Dar&eacute; Lo Mejor',22,2,NULL,NULL,NULL,NULL),(41,'Jehova Es Mi Guerrero',19,2,NULL,NULL,NULL,NULL),(42,'No Basta',19,1,NULL,NULL,NULL,NULL),(43,'Amor Sin Condici&oacute;n',7,2,NULL,NULL,NULL,NULL),(44,'De Gloria en Gloria',7,2,NULL,NULL,NULL,NULL),(45,'Dios Incomparable',7,1,NULL,NULL,NULL,NULL),(46,'El Camino del Se&ntilde;or',7,2,NULL,NULL,NULL,NULL),(47,'Hosanna',7,2,NULL,NULL,NULL,NULL),(48,'Nada Es Imposible',7,2,NULL,NULL,NULL,NULL),(49,'Preciosa Sangre',7,1,NULL,NULL,NULL,NULL),(50,'Rey de Reyes',7,2,NULL,NULL,NULL,NULL),(51,'Se&ntilde;or Eres Fiel',7,2,NULL,NULL,NULL,NULL),(52,'Padre Nuestro',7,1,NULL,NULL,NULL,NULL),(53,'Digno Es El Se&ntilde;or',7,1,NULL,NULL,NULL,NULL),(54,'Mi Pan Mi Luz',8,1,NULL,NULL,NULL,NULL),(55,'Danzar&eacute;, Cantar&eacute;',8,2,NULL,NULL,NULL,NULL),(56,'Dios Imparable',8,2,NULL,NULL,NULL,NULL),(57,'En los Montes, En los Valles',8,2,NULL,NULL,NULL,NULL),(58,'Hay Poder',8,2,NULL,NULL,NULL,NULL),(59,'Solo Por Tu Sangre',8,1,NULL,NULL,NULL,NULL),(60,'Tu Eres el Gozo',8,2,NULL,NULL,NULL,NULL),(61,'Tu y Yo',8,2,NULL,NULL,NULL,NULL),(62,'Desciende',3,2,NULL,NULL,NULL,NULL),(64,'Invencible',3,2,NULL,NULL,NULL,NULL),(65,'Me Enamoro Mas',3,1,NULL,NULL,NULL,NULL),(66,'M&uacute;sica del Cielo',3,2,NULL,NULL,NULL,NULL),(67,'Bienvenido Esp&iacute;ritu Santo',3,2,NULL,NULL,NULL,NULL),(68,'Vientos de Gloria',6,1,NULL,NULL,NULL,NULL),(69,'Aqu&iacute; Est&aacute;s',12,1,NULL,NULL,NULL,NULL),(71,'Te Alabamos Dios',24,2,NULL,NULL,NULL,NULL),(72,'Tu Gracia Me Basta',29,1,NULL,NULL,NULL,NULL),(73,'Miradme',30,1,NULL,NULL,NULL,NULL),(74,'Hermoso Nombre',25,1,NULL,NULL,NULL,NULL),(75,'Amor Como Fuego',25,1,NULL,'https://www.youtube.com/watch?v=mHz0KYu2ON8',NULL,NULL),(78,'Por El Poder de Tu Amor',24,1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `escolhamusica_tb_song` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escolhamusica_tb_user`
--

DROP TABLE IF EXISTS `escolhamusica_tb_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escolhamusica_tb_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `passwd` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escolhamusica_tb_user`
--

LOCK TABLES `escolhamusica_tb_user` WRITE;
/*!40000 ALTER TABLE `escolhamusica_tb_user` DISABLE KEYS */;
INSERT INTO `escolhamusica_tb_user` VALUES (1,'ilpp_01',NULL);
/*!40000 ALTER TABLE `escolhamusica_tb_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-11 22:55:02
