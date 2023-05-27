-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: csms
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `admin_id` int unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `date_of_birth` date NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_id_UNIQUE` (`admin_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (5,'Gullar','Farzali','admin','gullar.farzali@mail.ru','2003-11-19');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devices` (
  `device_id` int unsigned NOT NULL AUTO_INCREMENT,
  `device_name` varchar(150) NOT NULL,
  `status_id` int NOT NULL,
  `comments` varchar(250) DEFAULT NULL,
  `service_id` int unsigned NOT NULL,
  `employee_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`device_id`),
  UNIQUE KEY `device_id_UNIQUE` (`device_id`),
  KEY `status_id_idx` (`status_id`),
  KEY `employee_id_idx` (`employee_id`),
  KEY `service_id_idx` (`service_id`),
  CONSTRAINT `employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`),
  CONSTRAINT `service_id` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  CONSTRAINT `status_id` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (54,'Macbook 1',2,NULL,12,NULL),(57,'Samsung',1,NULL,11,10),(58,'Huawei',1,'It\'s gonna be fine!',11,8),(59,'Lenovo thinkpad',3,'your order is being processed',8,11),(60,'plsss',1,NULL,10,11),(61,'My device',1,'',9,11),(62,'Acer',1,NULL,12,11),(63,'Enter name',1,'',8,11),(64,'laptop',1,NULL,11,11),(65,'latop',2,NULL,10,NULL),(66,'laptopppppp',2,NULL,11,NULL),(67,'HP',1,NULL,16,11),(68,'Lenovooo',1,NULL,13,11),(69,'My device',1,NULL,10,11);
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `employee_id` int unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(45) NOT NULL,
  `date_of_birth` date NOT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `employee_id_UNIQUE` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (7,'Ben','Smith','$2y$10$w0NWjFJe3hhZ0OVndlU.XuGcrRtKDw/fAPKygjfZMoLpGpvPochmO','bensmith@example.com','1987-10-08'),(8,'David','Park','$2y$10$MCQz39uVg3Kl.v9rrw6.NOi8z1S0Fl4mt2XD9oJVjFPSZxRKoj7Ce','davidpark@example.com','1993-06-03'),(9,'Maria','Bjorkkk','$2y$10$cel10popXNrxLBuSKIA1PuTabLjj3RVtVy0kaAwF6NIROhL23iTpS','mariabjork@example.com','1995-09-23'),(10,'Mary','Jane','$2y$10$GyLXJF.ZNqqNLVe4mlhmR.3uDEwS9XfdM5XyNTiR3DW8hETbbCv4C','maryjane@example.com','1996-02-11'),(11,'Ben','Smith','$2y$10$96RRMqfWN.HLIhK3u3tet.P9w77HmcO.12EZMd0zbDb79wW1qfl1.','ben.smith@example.com','1995-03-02'),(14,'Pop','Corn','$2y$10$Yat75osg30YuRj8tuhIkFuq.O.MwDN1cBsQl9/BrilF4dJjxzzM46','popcorn@example.com','2023-05-11');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int unsigned NOT NULL AUTO_INCREMENT,
  `total` float unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `device_id` int unsigned NOT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_id_UNIQUE` (`order_id`),
  UNIQUE KEY `device_id_UNIQUE` (`device_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (26,200,28,58),(28,10,512,60),(29,50,512,61),(30,30,512,62),(31,500,512,63),(32,200,512,64),(33,10,512,65),(34,200,512,66),(35,40,512,67),(36,60,512,68),(37,10,512,69);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `service_id` int unsigned NOT NULL AUTO_INCREMENT,
  `service_name` varchar(150) DEFAULT NULL,
  `total` float unsigned NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (8,'Anti Virus Installation / Removal',500),(9,'PC Troubleshoting',50),(10,'PC Setup',10),(11,'Hardware Repair',200),(12,'OS Updates',30),(13,'Memory Upgrades',60),(16,'PC Cleaning',40);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `statuses` (
  `status_id` int NOT NULL AUTO_INCREMENT,
  `status_name` enum('Recieved','Accepted','Rejected','In Process','Completed','Handed out') NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` VALUES (1,'Accepted'),(2,'Rejected'),(3,'In Process'),(4,'Completed'),(5,'Handed out'),(6,'Recieved');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `date_of_birth` date NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=515 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (28,'John','Doe','$2y$10$FUy6Jydd6ltnDpcDopKUReO5iDHA47QZD7tZwUUMJ/BSzVim.jraS','john.doe@example.com','2001-07-06'),(511,'One','One','$2y$10$vv6uc3OSstNfTZB6EzsOYeLkGvcBTfonpFiqszbBuh58uJ3B6/NlK','oneone@example.com','2023-05-03'),(512,'Zaka','Farzali','$2y$10$X68FzbPabihzIQx1HhNsMe3i3vPT80BqnZCgnVNzGywPsTLdCrSky','zaka.farzali@example.com','2023-05-05'),(513,'Two','Two','$2y$10$nfp5tQaYlBtdjxktkBz3OeY7/sB2dr/9CwCPXNjli0YouoMKjQ0Oy','twotwo@example.com','2023-05-04'),(514,'Ya','Ti','$2y$10$UQyJOuRM1XI8hyuPNA7LqupAMtbNYq2KaFXCI5mK8OF6PkTZH/9Q2','onona@example.com','2023-04-30');
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

-- Dump completed on 2023-05-27 21:53:11
