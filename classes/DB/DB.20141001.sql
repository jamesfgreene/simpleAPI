-- MySQL dump 10.13  Distrib 5.5.37, for Linux (x86_64)
--
-- Host: localhost    Database: jamesfgr_db
-- ------------------------------------------------------
-- Server version	5.5.37-cll

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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `product_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `product_sku` varchar(255) CHARACTER SET latin1 NOT NULL,
  `product_quantity` bigint(20) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Dota 2','TSHRT-DOTA2',1,110.00,'L'),(2,'Dota 2','TSHRT-DOTA3',1,110.00,'XL'),(3,'Dota 2','TSHRT-DOTA4',1,110.00,'M'),(4,'Dota 2','TSHRT-DOTA5',1,110.00,'S'),(5,'Dota 2','TSHRT-DOTA6',1,110.00,'XXL'),(6,'LOL','TSHRT-LOL-1',1,120.00,'L'),(7,'LOL','TSHRT-LOL-2',1,120.00,'M'),(8,'LOL','TSHRT-LOL-3',1,120.00,'S'),(9,'LOL','TSHRT-LOL-4',1,120.00,'XL'),(10,'LOL','TSHRT-LOL-5',1,120.00,'XXL'),(11,'Terraria','TSHRT-TER-1',1,100.00,'L'),(12,'Terraria','TSHRT-TER-2',1,100.00,'XL'),(13,'Terraria','TSHRT-TER-3',1,100.00,'M'),(14,'Terraria','TSHRT-TER-4',1,100.00,'S'),(15,'Terraria','TSHRT-TER-5',1,100.00,'XXL');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-01 16:27:57
