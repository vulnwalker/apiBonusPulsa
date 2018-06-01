-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: bonus_pulsa
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `absen`
--

DROP TABLE IF EXISTS `absen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `absen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `tanggal` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absen`
--

LOCK TABLES `absen` WRITE;
/*!40000 ALTER TABLE `absen` DISABLE KEYS */;
INSERT INTO `absen` VALUES (4,'vulnwalker@elderscode.org','12-09-2017');
/*!40000 ALTER TABLE `absen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `histori_iklan`
--

DROP TABLE IF EXISTS `histori_iklan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `histori_iklan` (
  `email` text NOT NULL,
  `tanggal` text NOT NULL,
  `jam` text NOT NULL,
  `jenis_iklan` text NOT NULL,
  `saldo_dapat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `histori_iklan`
--

LOCK TABLES `histori_iklan` WRITE;
/*!40000 ALTER TABLE `histori_iklan` DISABLE KEYS */;
INSERT INTO `histori_iklan` VALUES ('cipta@getnada.com','11-09-2017','10:42','KLIK IKLAN','13'),('cipta@getnada.com','11-09-2017','10:30','TONTON VIDEO','47'),('cipta@getnada.com','11-09-2017','10:40','KLIK IKLAN','11'),('cipta@getnada.com','11-09-2017','11:49','KLIK IKLAN','15'),('cipta@getnada.com','11-09-2017','14:19','KLIK IKLAN','17'),('cipta@getnada.com','11-09-2017','14:23','TONTON VIDEO','23'),('cipta@getnada.com','11-09-2017','20:35','TONTON VIDEO','22'),('cipta@getnada.com','11-09-2017','20:57','TONTON VIDEO','37'),('vulnwalker@elderscode.org','11-09-2017','21:23','KLIK IKLAN','15'),('vulnwalker@elderscode.org','11-09-2017','22:02','KLIK IKLAN','16'),('vulnwalker@elderscode.org','11-09-2017','22:03','TONTON VIDEO','24'),('vulnwalker@elderscode.org','11-09-2017','22:07','TONTON VIDEO','47'),('vulnwalker@elderscode.org','12-09-2017','08:14','TONTON VIDEO','27'),('vulnwalker@elderscode.org','12-09-2017','08:58','KLIK IKLAN','12'),('vulnwalker@elderscode.org','12-09-2017','08:03','TONTON VIDEO','24'),('vulnwalker@elderscode.org','12-09-2017','08:30','TONTON VIDEO','17'),('vulnwalker@elderscode.org','12-09-2017','08:00','KLIK IKLAN','18'),('vulnwalker@elderscode.org','12-09-2017','08:16','TONTON VIDEO','17'),('vulnwalker@elderscode.org','12-09-2017','09:38','TONTON VIDEO','43'),('vulnwalker@elderscode.org','12-09-2017','09:10','TONTON VIDEO','45'),('vulnwalker@elderscode.org','12-09-2017','09:36','TONTON VIDEO','30'),('vulnwalker@elderscode.org','12-09-2017','09:53','TONTON VIDEO','49'),('vulnwalker@elderscode.org','12-09-2017','09:59','TONTON VIDEO','32'),('vulnwalker@elderscode.org','12-09-2017','09:48','TONTON VIDEO','38'),('vulnwalker@elderscode.org','12-09-2017','09:45','TONTON VIDEO','27'),('vulnwalker@elderscode.org','12-09-2017','09:59','TONTON VIDEO','50'),('vulnwalker@elderscode.org','12-09-2017','09:12','TONTON VIDEO','30'),('vulnwalker@elderscode.org','12-09-2017','09:02','TONTON VIDEO','26'),('vulnwalker@elderscode.org','12-09-2017','09:55','TONTON VIDEO','39'),('vulnwalker@elderscode.org','12-09-2017','09:18','TONTON VIDEO','48'),('vulnwalker@elderscode.org','12-09-2017','09:44','TONTON VIDEO','30'),('vulnwalker@elderscode.org','12-09-2017','09:55','TONTON VIDEO','47'),('vulnwalker@elderscode.org','12-09-2017','10:23','TONTON VIDEO','36'),('vulnwalker@elderscode.org','12-09-2017','10:18','TONTON VIDEO','19'),('vulnwalker@elderscode.org','12-09-2017','10:15','TONTON VIDEO','30'),('vulnwalker@elderscode.org','12-09-2017','10:28','TONTON VIDEO','41'),('vulnwalker@elderscode.org','12-09-2017','10:58','TONTON VIDEO','31'),('vulnwalker@elderscode.org','12-09-2017','10:02','TONTON VIDEO','47'),('vulnwalker@elderscode.org','12-09-2017','10:02','TONTON VIDEO','49'),('vulnwalker@elderscode.org','12-09-2017','10:22','TONTON VIDEO','37'),('vulnwalker@elderscode.org','12-09-2017','10:49','TONTON VIDEO','31'),('vulnwalker@elderscode.org','12-09-2017','10:18','TONTON VIDEO','16'),('vulnwalker@elderscode.org','12-09-2017','10:37','TONTON VIDEO','46'),('vulnwalker@elderscode.org','12-09-2017','10:16','TONTON VIDEO','30'),('vulnwalker@elderscode.org','12-09-2017','10:19','TONTON VIDEO','19'),('vulnwalker@elderscode.org','12-09-2017','10:52','TONTON VIDEO','38'),('vulnwalker@elderscode.org','12-09-2017','10:17','TONTON VIDEO','30'),('vulnwalker@elderscode.org','12-09-2017','10:42','TONTON VIDEO','32'),('vulnwalker@elderscode.org','12-09-2017','10:14','TONTON VIDEO','37'),('vulnwalker@elderscode.org','12-09-2017','10:29','TONTON VIDEO','50'),('vulnwalker@elderscode.org','12-09-2017','10:57','TONTON VIDEO','28'),('vulnwalker@elderscode.org','12-09-2017','10:33','TONTON VIDEO','49'),('vulnwalker@elderscode.org','12-09-2017','10:58','TONTON VIDEO','49'),('vulnwalker@elderscode.org','12-09-2017','10:14','TONTON VIDEO','21'),('vulnwalker@elderscode.org','12-09-2017','10:41','TONTON VIDEO','21'),('vulnwalker@elderscode.org','12-09-2017','10:47','TONTON VIDEO','45'),('vulnwalker@elderscode.org','12-09-2017','11:18','TONTON VIDEO','31'),('vulnwalker@elderscode.org','12-09-2017','11:57','TONTON VIDEO','47'),('vulnwalker@elderscode.org','12-09-2017','11:33','TONTON VIDEO','44'),('vulnwalker@elderscode.org','12-09-2017','11:40','TONTON VIDEO','37'),('vulnwalker@elderscode.org','12-09-2017','11:14','TONTON VIDEO','34'),('vulnwalker@elderscode.org','12-09-2017','11:01','TONTON VIDEO','32'),('vulnwalker@elderscode.org','12-09-2017','11:22','TONTON VIDEO','50'),('vulnwalker@elderscode.org','12-09-2017','11:20','TONTON VIDEO','21'),('vulnwalker@elderscode.org','12-09-2017','11:40','TONTON VIDEO','21'),('vulnwalker@elderscode.org','12-09-2017','11:19','TONTON VIDEO','39'),('vulnwalker@elderscode.org','12-09-2017','11:35','TONTON VIDEO','34'),('vulnwalker@elderscode.org','12-09-2017','11:55','TONTON VIDEO','35'),('vulnwalker@elderscode.org','12-09-2017','11:27','TONTON VIDEO','20'),('vulnwalker@elderscode.org','12-09-2017','12:44','TONTON VIDEO','49'),('vulnwalker@elderscode.org','12-09-2017','12:44','TONTON VIDEO','23'),('vulnwalker@elderscode.org','12-09-2017','12:52','TONTON VIDEO','17'),('vulnwalker@elderscode.org','12-09-2017','12:07','TONTON VIDEO','25'),('vulnwalker@elderscode.org','12-09-2017','12:48','TONTON VIDEO','16'),('vulnwalker@elderscode.org','12-09-2017','12:20','TONTON VIDEO','49'),('vulnwalker@elderscode.org','12-09-2017','12:54','TONTON VIDEO','43'),('vulnwalker@elderscode.org','12-09-2017','13:08','TONTON VIDEO','46'),('vulnwalker@elderscode.org','12-09-2017','13:55','TONTON VIDEO','27'),('vulnwalker@elderscode.org','12-09-2017','13:17','TONTON VIDEO','45'),('vulnwalker@elderscode.org','12-09-2017','14:36','TONTON VIDEO','48'),('vulnwalker@elderscode.org','12-09-2017','14:05','TONTON VIDEO','30'),('vulnwalker@elderscode.org','12-09-2017','15:14','TONTON VIDEO','28'),('vulnwalker@elderscode.org','12-09-2017','15:28','TONTON VIDEO','42'),('vulnwalker@elderscode.org','12-09-2017','15:26','TONTON VIDEO','41'),('vulnwalker@elderscode.org','12-09-2017','16:43','KLIK IKLAN','20'),('vulnwalker@elderscode.org','12-09-2017','16:08','TONTON VIDEO','23'),('vulnwalker@elderscode.org','12-09-2017','19:24','TONTON VIDEO','41'),('vulnwalker@elderscode.org','12-09-2017','19:17','TONTON VIDEO','23'),('vulnwalker@elderscode.org','12-09-2017','19:54','TONTON VIDEO','36'),('vulnwalker@elderscode.org','12-09-2017','20:53','ABSEN HARIAN','486'),('vulnwalker@elderscode.org','12-09-2017','20:20','ABSEN HARIAN','315'),('vulnwalker@elderscode.org','12-09-2017','20:56','ABSEN HARIAN','135'),('vulnwalker@elderscode.org','12-09-2017','20:15','KLIK IKLAN','10'),('vulnwalker@elderscode.org','12-09-2017','20:36','ABSEN HARIAN','497'),('vulnwalker@elderscode.org','12-09-2017','20:33','TONTON VIDEO','25'),('vulnwalker@elderscode.org','12-09-2017','21:14','TONTON VIDEO','35'),('vulnwalker@elderscode.org','12-09-2017','22:31','TONTON VIDEO','15');
/*!40000 ALTER TABLE `histori_iklan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `nama_lengkap` text NOT NULL,
  `no_telepon` text NOT NULL,
  `saldo` int(11) NOT NULL,
  `status` text NOT NULL,
  `verifikasi` text NOT NULL,
  `firebase_id` text NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES ('boniw@getnada.com','Hash2856','Imam mutaqien','085454845',0,'registered','belum',''),('cipta@getnada.com','123456','Cipta','08512454322',1614,'registered','ok','fqwNQPbrX9c:APA91bGUoyFyNV_GT62JoUw04TgQV6h1WNuilaVUZURNgjozTsrj9gExkMKYrt97mVQMz68POBywFdQuClvh32sd8HZhylt_6cEJyG6ou8AOYoIhb-UT5AoMZzSA6lY0eEIuYygblsxw'),('nando@krypton.com','123456','Roby Firnando Yusuf','08213124',101,'registered','ok','null'),('suspend@email.com','123456','suspend','0846480464',0,'suspend','ok',''),('vulnwalker@elderscode.org','rf09thebye','Vuln Walker','081223744803',1517204,'registered','ok','f8rBwvMek8c:APA91bFCD6FCCHLjvCQHUznxzsfdPrdQFmBZcPcEFamCqQzKqpiBjDAxtpLe5dOsRF2cvWJv2i9LrFvVkg3WwRwI8s-iFCqwFQ5mZbmo94i6_OR4u-pGvhQsHn27-vu7eKfsZBpRs5AV');
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penukaran`
--

DROP TABLE IF EXISTS `penukaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penukaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `id_tukar_point` text NOT NULL,
  `tanggal` text NOT NULL,
  `status` text NOT NULL,
  `tanggal_aksi` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penukaran`
--

LOCK TABLES `penukaran` WRITE;
/*!40000 ALTER TABLE `penukaran` DISABLE KEYS */;
INSERT INTO `penukaran` VALUES (19,'vulnwalker@elderscode.org','6','12-09-2017','DONE','12-09-2017'),(20,'vulnwalker@elderscode.org','5','12-09-2017','PROCESSING','');
/*!40000 ALTER TABLE `penukaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tukar_point`
--

DROP TABLE IF EXISTS `tukar_point`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tukar_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tukar` text NOT NULL,
  `jumlah_point` text NOT NULL,
  `jumlah_dapat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tukar_point`
--

LOCK TABLES `tukar_point` WRITE;
/*!40000 ALTER TABLE `tukar_point` DISABLE KEYS */;
INSERT INTO `tukar_point` VALUES (1,'PULSA RP 5.000','6500','5000'),(2,'PULSA  RP 10.000','12000','10000'),(3,'PULSA RP 20.000','21000','20000'),(4,'PULSA RP 25.000','25500','25000'),(5,'PULSA RP 50.000','50000','50000'),(6,'PULSA RP 100.000','90000','100000'),(7,'PULSA RP 200.000','175000','200000');
/*!40000 ALTER TABLE `tukar_point` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-12 15:52:19
