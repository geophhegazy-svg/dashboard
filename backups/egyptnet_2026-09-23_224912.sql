-- MySQL dump 10.13  Distrib 8.4.10, for Linux (x86_64)
--
-- Host: localhost    Database: egyptnet
-- ------------------------------------------------------
-- Server version	8.4.10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounting_periods`
--

DROP TABLE IF EXISTS `accounting_periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounting_periods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('open','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounting_periods_tenant_id_start_date_end_date_unique` (`tenant_id`,`start_date`,`end_date`),
  KEY `accounting_periods_tenant_id_status_index` (`tenant_id`,`status`),
  CONSTRAINT `accounting_periods_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounting_periods`
--

LOCK TABLES `accounting_periods` WRITE;
/*!40000 ALTER TABLE `accounting_periods` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounting_periods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('asset','liability','equity','revenue','expense') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nature` enum('debit','credit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` tinyint unsigned NOT NULL DEFAULT '1',
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounts_tenant_id_code_unique` (`tenant_id`,`code`),
  KEY `accounts_parent_id_foreign` (`parent_id`),
  KEY `accounts_tenant_id_parent_id_index` (`tenant_id`,`parent_id`),
  KEY `accounts_tenant_id_type_index` (`tenant_id`,`type`),
  CONSTRAINT `accounts_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `accounts_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,1,NULL,'1000','Assets','asset','debit',1,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56'),(2,1,1,'1100','Cash','asset','debit',2,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56'),(3,1,1,'1200','Accounts Receivable','asset','debit',2,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56'),(4,1,NULL,'2000','Liabilities','liability','credit',1,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56'),(5,1,4,'2100','Customer Wallet Liability','liability','credit',2,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56'),(6,1,NULL,'3000','Equity','equity','credit',1,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56'),(7,1,6,'3100','Owner Equity','equity','credit',2,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56'),(8,1,NULL,'4000','Revenue','revenue','credit',1,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56'),(9,1,8,'4100','Subscription Revenue','revenue','credit',2,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56'),(10,1,NULL,'5000','Expenses','expense','debit',1,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56'),(11,1,10,'5100','Network Expenses','expense','debit',2,1,1,NULL,'2026-07-15 12:09:56','2026-07-15 12:09:56');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `attribute_changes` json DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_tenant_id_foreign` (`tenant_id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,1,NULL,'Accounting','Journal Posted','Journal Entry JE-TEST-001 posted.','127.0.0.1','2026-07-15 14:30:48','2026-07-15 14:30:48'),(2,80,13,'test','tenant_a','A',NULL,'2026-08-31 17:46:11','2026-08-31 17:46:11'),(3,81,13,'test','tenant_b','B',NULL,'2026-08-31 17:46:11','2026-08-31 17:46:11'),(4,83,NULL,'subscription','renewed','Subscription renewed automatically.','127.0.0.1','2026-09-03 19:19:36','2026-09-03 19:19:36'),(5,1,NULL,'subscription','renewed','Subscription renewed automatically.','127.0.0.1','2026-09-03 19:20:47','2026-09-03 19:20:47');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_id` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_username_unique` (`username`),
  KEY `customers_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `customers_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,1,'╪╣┘à┘è┘ ╪ز╪ش╪▒┘è╪ذ┘è','01000000000',NULL,NULL,NULL,NULL,NULL,'active',NULL,'2026-07-12 07:30:43','2026-07-12 07:30:43',NULL),(2,1,'╪╣┘à┘è┘ ╪ز╪ش╪▒┘è╪ذ┘è','01012345678',NULL,'customer@example.com','$2y$12$tSjqaIabuG9JUGtsXy3X7eytO8s4smbqEqk4mjtkAEsm.AaZPxXim',NULL,NULL,'active',NULL,'2026-07-12 12:09:01','2026-07-12 12:09:01',NULL),(3,2,'╪╣┘à┘è┘ ╪ز╪ش╪▒┘è╪ذ┘è','01012345678',NULL,'customer@example.com','$2y$12$XEgAD.CIk2ZWmgZKmh67oOdG7b8LBCuhuweUJCnStyJokla8GaeCa',NULL,NULL,'active',NULL,'2026-07-12 12:10:54','2026-07-12 12:10:54',NULL),(4,3,'╪╣┘à┘è┘ ╪ز╪ش╪▒┘è╪ذ┘è','01012345678',NULL,'customer@example.com','$2y$12$ZTAGhWSx1LxdNVqsvNVrZuVKv.iIp7nb2p8BU/.F25Up1nyCHXC7y',NULL,NULL,'active',NULL,'2026-07-12 12:12:35','2026-07-12 12:12:35',NULL),(5,4,'╪╣┘à┘è┘ ╪ز╪ش╪▒┘è╪ذ┘è','01012345678',NULL,'customer@example.com','$2y$12$OpiSW8R8tqxkDZ7blksrD.xYKemfHh7IFFWgZTqmsrlMavncornjq',NULL,NULL,'active',NULL,'2026-07-12 12:21:40','2026-07-12 12:21:40',NULL),(6,1,'╪╣┘à┘è┘ ╪ز╪ش╪▒┘è╪ذ┘è','01012345678',NULL,'customer@example.com','$2y$12$VDbuS7pGyQJ0IXHSuqNoHuA4CTq53LbmwCrGYq.A6NblPmj/T3Aha',NULL,NULL,'active',NULL,'2026-07-12 12:27:37','2026-07-12 12:27:37',NULL),(7,1,'╪╣┘à┘è┘ ╪ز╪ش╪▒┘è╪ذ┘è','01012345678',NULL,'customer@example.com','$2y$12$C1shaAi43MQ3G/7sfElsA.stGP57Z21rkynS.wRqRJeEemIPj/jjO',NULL,NULL,'active',NULL,'2026-07-12 12:30:46','2026-07-12 12:30:46',NULL),(8,1,'╪╣┘à┘è┘ ╪ز╪ش╪▒┘è╪ذ┘è','01012345678',NULL,'customer@example.com','$2y$12$UCcB1wv5rryzchuVjnXzcetIC7g8G0NHYfJzwbmnbmC5n0AaBY3Fe',NULL,NULL,'active',NULL,'2026-07-12 12:32:03','2026-07-12 12:32:03',NULL),(9,1,'╪╣┘à┘è┘ ╪ز╪ش╪▒┘è╪ذ┘è','01012345678',NULL,'customer@example.com','$2y$12$D.zr7PYPsE8Vg4ygBAJa1OnAhqs29ykB7sXYqaEwdTh6vjPQry776',NULL,NULL,'active',NULL,'2026-07-12 12:34:44','2026-07-12 12:34:44',NULL),(10,7,'Mr. Isac Hodkiewicz','541.665.6437',NULL,'runolfsson.mekhi@example.com','$2y$12$XgpSFmLinfZk7jmqsSjv.uJT7.fO96lpOokCcj/BABfbd3G3edOPS','711 Heber Highway\nPort Berylside, DC 68856',NULL,'active',NULL,'2026-08-16 16:21:26','2026-08-16 16:21:26',NULL),(11,9,'Augustine Keeling MD','541-695-2549',NULL,'vauer@example.net','$2y$12$U.0jZ5XPP4/yLK7nsYZGOODZxo1NwdbtFUi1ejQdxp.MplAUAfEd6','7550 Harmon Harbor\nRosalindton, OH 10369',NULL,'active',NULL,'2026-08-16 16:21:27','2026-08-16 16:21:27',NULL),(12,13,'Dr. Garnett Ullrich DDS','+1-410-977-2514',NULL,'leonie15@example.com','$2y$12$R8HWr3UVueRDpu6TJpq1GOEmHUc.KeGGarCjsWlhvns8cjojvBPS2','545 Lakin Valley Apt. 386\nNorth Gabe, IN 49029-3227',NULL,'active',NULL,'2026-08-16 17:14:06','2026-08-16 17:14:06',NULL),(13,15,'Nona Langosh','413.781.1051',NULL,'bernadine18@example.net','$2y$12$oqXlRVX29IC.dWYAt7oQKu.800jw0JkaqpURvxB8agy.4k8NNU5/G','6927 Block Lane Suite 996\nRaleighland, SD 63379-8419',NULL,'active',NULL,'2026-08-16 17:14:06','2026-08-16 17:14:06',NULL),(14,21,'Prof. Mozelle Hackett','(631) 851-4268',NULL,'rolfson.anais@example.com','$2y$12$yOt6rxBB6jBZGK4wpomQGO87Y4beAWXLSO56f5hAF/WEqqB3X6mcy','75468 Kris Route Apt. 721\nSouth Nashborough, MI 95302-4894',NULL,'active',NULL,'2026-08-17 15:53:52','2026-08-17 15:53:52',NULL),(15,23,'Mrs. Thora Wilkinson','+1 (585) 610-4063',NULL,'vada.hansen@example.com','$2y$12$R4hLDJLQ5bFfwfg2l4k5ke0hu3sjpQPTCzkqdGHpnjYBDp5KXeI7q','45413 Bayer Spring Apt. 790\nSouth Zoie, IN 20534',NULL,'active',NULL,'2026-08-17 15:53:53','2026-08-17 15:53:53',NULL),(16,25,'Sheridan Kirlin Jr.','1-740-496-1246',NULL,'christiansen.danielle@example.com','$2y$12$BfN3xopotp8yjzFVZnT0l.xu5XvAfU2kMwhw9kLyVXNzDAp088vPm','4605 Ressie Park Apt. 246\nEast Aurelio, WY 11073-8476',NULL,'active',NULL,'2026-08-19 19:53:04','2026-08-19 19:53:04',NULL),(17,26,'Etha Gerlach','(802) 468-5970',NULL,'ngerhold@example.org','$2y$12$0zIhSftkOsF43n1ILby2CuVfzuf5pxchecpGnFGajhpNEMmKPKvcy','268 Zieme Grove\nWest Alexaneview, UT 61168',NULL,'active',NULL,'2026-08-19 19:55:50','2026-08-19 19:55:50',NULL),(18,29,'Abelardo Altenwerth','219-584-2083',NULL,'wilburn.durgan@example.net','$2y$12$p50CQhl5Grl1B87VeF1ie.SW8Or95ORgVGLz2dNLTIPkTx1qcnlxm','2243 Kshlerin Loaf\nKonopelskiland, VA 54050',NULL,'active',NULL,'2026-08-24 17:48:13','2026-08-24 17:48:13',NULL),(19,32,'Raquel Wehner Jr.','+1.534.654.5252',NULL,'anika93@example.com','$2y$12$Mg8PYtP5o5mD8bZKkI3pEu3V7JdafYXGZKbkBIQgtNHBN3S4XlQFW','9241 Donnelly Shore Suite 042\nEast Taliaport, WI 77550-4667',NULL,'active',NULL,'2026-08-24 17:56:52','2026-08-24 17:56:52',NULL),(20,35,'Ellis Bins III','+1.941.242.7758',NULL,'jedediah22@example.com','$2y$12$IX4It0DOqZL3xZCQHPfagOic9/dlAVLBlU/BNzfaK/zD3CQnHD88.','8717 Isidro Cape Apt. 347\nVestastad, FL 55971-3124',NULL,'active',NULL,'2026-08-27 19:09:18','2026-08-27 19:09:18',NULL),(21,37,'Claud Heaney','+1.346.632.2069',NULL,'georgiana52@example.org','$2y$12$C2EfY9f244ueH08LZf4zF.VHioHo4EbrkJXNDGBlfIjWdcz8B16Ze','319 Jerde Ports\nPort Meagan, VT 94104-6383',NULL,'active',NULL,'2026-08-27 19:09:18','2026-08-27 19:09:18',NULL),(22,39,'Deshaun Mosciski II','361-735-0525',NULL,'janie82@example.org','$2y$12$dUXpBsW6SCJAMdK8QJbNCOO8vaqp0qif.m9w.LxhVQZNlxvsokxEO','71985 Erdman Causeway Suite 223\nMacejkovicborough, MI 49429-4109',NULL,'active',NULL,'2026-08-28 13:12:16','2026-08-28 13:12:16',NULL),(23,42,'Corine Ullrich Jr.','313-949-6195',NULL,'sruecker@example.com','$2y$12$Z3U4fenP/91oP.8wPJQYCut6iSiHmpc/HL4FWGMKH.eAqRXS1H5My','759 Casper Flats Apt. 872\nCheyennebury, DC 50959-4464',NULL,'active',NULL,'2026-08-28 13:19:34','2026-08-28 13:19:34',NULL),(24,45,'Misael Blanda','1-952-224-5096',NULL,'ashleigh.weissnat@example.net','$2y$12$GRBhDUJWCADC3u.wNLJIhuaySHR.VGK.HAZapbQ7dXk3fwXhKKFZC','504 Arvid Gateway Suite 489\nLake Marciabury, MI 32180',NULL,'active',NULL,'2026-08-29 20:28:17','2026-08-29 20:28:17',NULL),(25,48,'Blanca Rosenbaum IV','732.679.1325',NULL,'eldridge.blanda@example.com','$2y$12$H3kznj4luk3XUQqBTzKRJurK26d2yknetYZrHOATZtm9Yx70tQi5.','46701 Windler Flat Apt. 566\nLake Garlandtown, TX 84366',NULL,'active',NULL,'2026-08-29 20:30:26','2026-08-29 20:30:26',NULL),(26,51,'Jenifer Keebler','+1 (678) 835-2416',NULL,'xhickle@example.com','$2y$12$/Xa07snffdeBXJyDStSwv.k5hTHZtsEpuyVrJ7qGr/ieRE9rY0BIC','601 Adrien Isle\nLake Nataliabury, AL 36931',NULL,'active',NULL,'2026-08-29 20:34:54','2026-08-29 20:34:54',NULL),(27,54,'Furman Gislason','+1 (251) 827-7783',NULL,'ferry.pamela@example.com','$2y$12$ZoD/s5.D0OP6AI.m7nz5AuiDGdIhFM1ivBmt7SU8Tc1TRanlVIM/6','691 Elmer Crescent\nLake Jamarcus, CT 33131',NULL,'active',NULL,'2026-08-29 20:37:58','2026-08-29 20:37:58',NULL),(28,57,'Miss Dorothea Bashirian','838.769.7709',NULL,'cristina46@example.net','$2y$12$6F6mTNsYMJSyOyBWGXrBU.7xBVMP1SLd9CmNqqhDlblCZ0HFD2aDS','6069 Murray Cliffs\nWisozkstad, AK 47707',NULL,'active',NULL,'2026-08-29 20:40:54','2026-08-29 20:40:54',NULL),(29,60,'Christelle Hegmann','1-828-545-7138',NULL,'glennie90@example.net','$2y$12$1ZAVvHwjNEWDemDHGwmWfu5q7iGg319sDGPLlzP9Pz8ua1Bty.Y8i','3876 Elta Viaduct Suite 247\nSouth Lawson, DE 05532',NULL,'active',NULL,'2026-08-29 20:43:38','2026-08-29 20:43:38',NULL),(30,63,'Mrs. Emilie Roob V','(910) 242-3032',NULL,'pearlie.volkman@example.com','$2y$12$fX2zF7ArWlABgqctwAdzzuMK0PAK.42d3.YDcfhGzbKAe3wriPZ2i','18431 Welch Trail\nWest Hannah, WA 79272-2493',NULL,'active',NULL,'2026-08-29 20:47:43','2026-08-29 20:47:43',NULL),(31,66,'Tomas Hartmann','856-425-6035',NULL,'alaina76@example.org','$2y$12$Np6yTpFlKZv6SgReZEbB9ufiiZf2oOGMtNky5l7uPgv/mhCJs4kMi','8343 Kristina Underpass Apt. 876\nLake Shanonshire, IN 49817',NULL,'active',NULL,'2026-08-29 20:50:41','2026-08-29 20:50:41',NULL),(32,69,'Eliza Bartell','+1-458-330-2007',NULL,'fleta.reinger@example.com','$2y$12$w28D.OXqQkfaM0CpeXQhaOevTILt3399wAo6kgukxiKf6SOmGW9C2','9802 Wuckert Pine Suite 647\nAngelaberg, OR 26894',NULL,'active',NULL,'2026-08-29 20:54:55','2026-08-29 20:54:55',NULL),(33,72,'Kyler Gutmann','772.579.3550',NULL,'stefanie.ebert@example.org','$2y$12$MeYD.1BFV1bNfBPGIE5vMeCoRMbIWKBrgoTjjvLYrclFs7S5HPyG.','955 Cummings Orchard Apt. 270\nFeestview, HI 87501',NULL,'active',NULL,'2026-08-29 20:57:34','2026-08-29 20:57:34',NULL),(34,76,'Miss Krista DuBuque','+1 (484) 468-8706',NULL,'osinski.jennie@example.org','$2y$12$RCpo/RemEJ5u.qr7JIqtZ.RXO/IsPR4fnv.BTxouRhTOa9OiU/zbq','112 O\'Connell Road Suite 341\nDeltamouth, WA 15103-2968',NULL,'active',NULL,'2026-08-31 15:50:54','2026-08-31 15:50:54',NULL),(35,78,'Rudy Bradtke','435-692-8542',NULL,'muller.georgette@example.org','$2y$12$dmEeH4OkcMClWWEGeGEDsOteVTzhHGC2LVnbWeFaX.63ew/2Cmvjm','90851 Bayer Springs\nWest Jerrell, WA 02740-5225',NULL,'active',NULL,'2026-08-31 15:52:03','2026-08-31 15:52:03',NULL),(36,84,'Yasmin Rowe III','+1-341-760-2311',NULL,'kub.angelita@example.com','$2y$12$eT0h/wPF1J.BsuyFQk31FuJ4.aVSW8TI94z3bRSy6s2/LwvJyC2gq','498 Sanford Ranch\nRennerfurt, CT 74043',NULL,'active',NULL,'2026-09-03 19:19:35','2026-09-03 19:19:35',NULL),(37,88,'Monserrate Heathcote','504.445.8466',NULL,'abernathy.elizabeth@example.net','$2y$12$.ICfhQLcutg5ZcfRRX7O.Oj3gEY37vzayhB/j5iL9WcJHkJxWphrS','19759 Huel Villages\nWittingfurt, CT 24934',NULL,'active',NULL,'2026-09-17 21:07:02','2026-09-17 21:07:02',NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `device_assignments`
--

DROP TABLE IF EXISTS `device_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `device_assignments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `device_id` bigint unsigned NOT NULL,
  `assigned_at` timestamp NOT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `status` enum('assigned','returned','lost','damaged') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'assigned',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `device_assignments_tenant_id_foreign` (`tenant_id`),
  KEY `device_assignments_customer_id_foreign` (`customer_id`),
  KEY `device_assignments_device_id_foreign` (`device_id`),
  CONSTRAINT `device_assignments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `device_assignments_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `device_assignments_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device_assignments`
--

LOCK TABLES `device_assignments` WRITE;
/*!40000 ALTER TABLE `device_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `device_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `device_type` enum('onu','router','mikrotik','switch','olt') COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mac_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','faulty','returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devices_serial_number_unique` (`serial_number`),
  KEY `devices_tenant_id_foreign` (`tenant_id`),
  KEY `devices_customer_id_foreign` (`customer_id`),
  CONSTRAINT `devices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `devices_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotspot_subscriptions`
--

DROP TABLE IF EXISTS `hotspot_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hotspot_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `package_id` bigint unsigned NOT NULL,
  `hotspot_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hotspot_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mikrotik_profile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `monthly_price` decimal(10,2) NOT NULL,
  `status` enum('active','expired','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hotspot_subscriptions_hotspot_username_unique` (`hotspot_username`),
  KEY `hotspot_subscriptions_tenant_id_foreign` (`tenant_id`),
  KEY `hotspot_subscriptions_customer_id_foreign` (`customer_id`),
  KEY `hotspot_subscriptions_package_id_foreign` (`package_id`),
  CONSTRAINT `hotspot_subscriptions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hotspot_subscriptions_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hotspot_subscriptions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotspot_subscriptions`
--

LOCK TABLES `hotspot_subscriptions` WRITE;
/*!40000 ALTER TABLE `hotspot_subscriptions` DISABLE KEYS */;
INSERT INTO `hotspot_subscriptions` VALUES (2,1,1,1,'94:FB:B2:20:77:41','1452','default','2026-07-12','2026-08-12',100.00,'active','2026-07-12 07:35:29','2026-07-12 07:35:29');
/*!40000 ALTER TABLE `hotspot_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotspot_users`
--

DROP TABLE IF EXISTS `hotspot_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hotspot_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mikrotik_device_id` bigint unsigned DEFAULT NULL,
  `profile` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','disabled','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `uptime` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `bytes_in` bigint NOT NULL DEFAULT '0',
  `bytes_out` bigint NOT NULL DEFAULT '0',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `session_expiry` timestamp NULL DEFAULT NULL,
  `expiry_date` timestamp NULL DEFAULT NULL,
  `last_sync_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hotspot_users_username_unique` (`username`),
  KEY `hotspot_users_customer_id_foreign` (`customer_id`),
  KEY `hotspot_users_mikrotik_device_id_foreign` (`mikrotik_device_id`),
  KEY `hotspot_users_username_index` (`username`),
  KEY `hotspot_users_status_index` (`status`),
  KEY `hotspot_users_is_online_index` (`is_online`),
  KEY `hotspot_users_expiry_date_index` (`expiry_date`),
  KEY `hotspot_users_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `hotspot_users_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `hotspot_users_mikrotik_device_id_foreign` FOREIGN KEY (`mikrotik_device_id`) REFERENCES `network_devices` (`id`) ON DELETE SET NULL,
  CONSTRAINT `hotspot_users_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=753 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotspot_users`
--

LOCK TABLES `hotspot_users` WRITE;
/*!40000 ALTER TABLE `hotspot_users` DISABLE KEYS */;
INSERT INTO `hotspot_users` VALUES (1,NULL,NULL,'default-trial','********',1,NULL,'disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(2,NULL,NULL,'08:10:76:B9:68:BF','1452',1,'2M','disabled',0,'67',80751,51089,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(3,NULL,NULL,'08:10:76:EF:3D:7B','1452',1,'default','disabled',0,'159',139452,222331,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(4,NULL,NULL,'00:E0:4C:89:C3:BB','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(5,NULL,NULL,'00:27:22:03:37:C0','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(6,NULL,NULL,'D8:47:32:2F:43:DF','1452',1,'3M','disabled',0,'351',31274,42539,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(7,NULL,NULL,'00:E0:4B:DD:85:52','1452',1,'2M','disabled',0,'37',20165,23782,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(8,NULL,NULL,'00:E0:4B:A9:1E:30','1452',1,'default','disabled',0,'493',1940841,88326633,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(9,NULL,NULL,'00:01:36:C7:8B:D1','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(10,NULL,NULL,'6C:5A:B0:03:83:1B','1452',1,'25M','disabled',0,'493',2895836,57728138,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(11,NULL,NULL,'78:44:76:9C:75:A1','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(12,NULL,NULL,'94:FB:B2:04:69:81','1452',1,'2M','disabled',0,'20',9872,19953,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(13,NULL,NULL,'1C:AB:32:03:04:46','1452',1,'3M','disabled',0,'334',2400715,46014146,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(14,NULL,NULL,'B8:3A:08:19:75:88','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(15,NULL,NULL,'08:10:76:E1:C0:C5','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(16,NULL,NULL,'78:44:76:A7:03:74','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(17,NULL,NULL,'08:10:76:9E:00:B9','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(18,NULL,NULL,'00:08:52:23:1D:79','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(19,NULL,NULL,'00:01:36:C9:FF:31','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:17','2026-09-23 19:45:38',NULL),(20,NULL,NULL,'00:30:0D:16:AB:7D','1452',1,'default','disabled',0,'494',1847839,36097738,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(21,NULL,NULL,'78:44:76:9A:19:37','1452',1,'15 M','disabled',0,'68',13650,45833,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(22,NULL,NULL,'00:E0:4C:82:75:B5','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(23,NULL,NULL,'78:44:76:9B:FA:55','1452',1,'default','disabled',0,'210',1495603,13894519,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(24,NULL,NULL,'00:66:4B:D2:F1:14','1452',1,'3M','disabled',0,'335',1992187,43860941,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(25,NULL,NULL,'78:44:76:A7:07:A7','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(26,NULL,NULL,'00:08:52:2A:E2:01','1452',1,'1M','disabled',0,'483',7139151,61695180,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(27,NULL,NULL,'78:44:76:83:2D:F9','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(28,NULL,NULL,'94:FB:B2:14:DB:A1','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(29,NULL,NULL,'00:08:52:1D:92:B1','1452',1,'2M','active',0,'0',0,0,NULL,NULL,NULL,'2026-07-10 20:44:18',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(30,NULL,NULL,'A8:02:DB:F8:77:42','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(31,NULL,NULL,'00:08:52:1F:18:99','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(32,NULL,NULL,'0C:80:63:56:3B:B7','1452',1,'default','disabled',0,'26',64,80,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(33,NULL,NULL,'AC:84:C6:7D:7B:E1','1452',1,'4M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(34,NULL,NULL,'00:E0:4B:97:55:16','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(35,NULL,NULL,'00:08:52:33:C1:69','1452',1,'default','disabled',0,'109',194584,278980,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(36,NULL,NULL,'C4:C7:A1:60:45:07','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(37,NULL,NULL,'94:FB:B2:20:77:41','1452',1,'out cut','disabled',0,'608',228,76,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(38,NULL,NULL,'08:10:76:DD:58:6C','1452',1,'225M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(39,NULL,NULL,'0C:80:63:2C:BD:55','1452',1,'25M','disabled',0,'496',8810621,14267834,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(40,NULL,NULL,'08:10:76:68:CB:81','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(41,NULL,NULL,'1C:A5:32:6F:03:21','1452',1,'out cut','disabled',0,'2300',8152972,71949878,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(42,NULL,NULL,'00:01:36:C6:12:D1','1452',1,'15 M','disabled',0,'334',3976905,40173355,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(43,NULL,NULL,'00:01:36:C9:5C:C9','1452',1,'out cut','active',0,'0',0,0,NULL,NULL,NULL,'2026-07-10 20:44:18',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(44,NULL,NULL,'C0:C2:C0:98:01:1A','1452',1,'25M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(45,NULL,NULL,'0C:80:63:B6:FC:95','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-07-10 20:44:18',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(46,NULL,NULL,'74:DA:38:20:5E:09','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(47,NULL,NULL,'00:08:52:1D:59:C1','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(48,NULL,NULL,'D8:29:18:E5:5F:41','1452',1,'4M','disabled',0,'58',74311,38689,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(49,NULL,NULL,'B4:F5:8E:AA:4D:CD','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(50,NULL,NULL,'08:10:76:78:DC:E7','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(51,NULL,NULL,'00:E0:4C:6F:30:26','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(52,NULL,NULL,'08:10:76:57:E4:47','1452',1,'1M','disabled',0,'494',19537635,36298972,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(53,NULL,NULL,'08:10:76:26:75:4B','1452',1,'560 KB','disabled',0,'476',11173,7358,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(54,NULL,NULL,'00:E0:4B:AC:97:52','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(55,NULL,NULL,'00:E0:4B:98:44:91','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(56,NULL,NULL,'00:E0:4B:A7:FD:7D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(57,NULL,NULL,'08:10:76:6D:4B:E9','1452',1,'225M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(58,NULL,NULL,'70:25:59:56:BA:11','1452',1,'3M','disabled',0,'74',27981,28956,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(59,NULL,NULL,'08:10:76:AD:F2:21','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(60,NULL,NULL,'08:10:76:F9:66:71','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(61,NULL,NULL,'D8:0D:17:63:0E:D1','1452',1,'3M','disabled',0,'494',214473,290617,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(62,NULL,NULL,'08:10:76:D3:DB:83','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(63,NULL,NULL,'08:10:76:5A:E9:D3','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(64,NULL,NULL,'00:E0:4B:AC:5C:98','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(65,NULL,NULL,'08:10:76:07:26:F8','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(66,NULL,NULL,'00:E0:4C:7B:F7:CD','1452',1,'560 KB','disabled',0,'495',4200202,32213804,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(67,NULL,NULL,'00:E0:4B:B3:38:E1','1452',1,'4M','disabled',0,'246',6299489,70803470,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(68,NULL,NULL,'00:E0:4B:A3:49:D7','1452',1,'default','disabled',0,'57',8107,20412,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(69,NULL,NULL,'00:E0:4B:EE:6D:46','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(70,NULL,NULL,'78:44:76:9B:6E:3D','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(71,NULL,NULL,'00:E0:4B:E5:D4:B7','1452',1,'default','disabled',0,'477',1692344,20253070,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(72,NULL,NULL,'08:10:76:5A:0C:5A','1452',1,'4M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(73,NULL,NULL,'E2:2A:8A:A7:04:03','1452',1,'default','disabled',0,'187',1454237,36684323,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(74,NULL,NULL,'00:01:36:BD:BF:11','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(75,NULL,NULL,'08:10:76:44:4D:19','1452',1,'5M','disabled',0,'287',47742,77883,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(76,NULL,NULL,'08:10:76:D7:02:E1','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(77,NULL,NULL,'00:27:1C:C5:70:E3','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(78,NULL,NULL,'00:E0:4B:AD:B4:FF','1452',1,'1M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(79,NULL,NULL,'04:09:B1:A5:01:11','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(80,NULL,NULL,'00:E0:4B:B0:8F:2C','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(81,NULL,NULL,'00:E0:4C:63:CD:E1','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-07-10 20:44:18',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(82,NULL,NULL,'00:E0:4B:B2:C1:1C','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(83,NULL,NULL,'00:E0:4B:A3:CA:1C','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(84,NULL,NULL,'00:E0:4C:4F:C3:31','1452',1,'225M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(85,NULL,NULL,'08:10:76:03:87:56','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:18','2026-09-23 19:45:38',NULL),(86,NULL,NULL,'08:10:76:2A:94:58','1452',1,'560 KB','disabled',0,'493',1468583,15334368,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(87,NULL,NULL,'00:E0:4B:9D:A7:53','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(88,NULL,NULL,'94:0C:6D:C8:15:81','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(89,NULL,NULL,'C0:C2:C0:E1:A3:28','1452',1,'275M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(90,NULL,NULL,'00:E0:4B:8F:59:50','1452',1,'25M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(91,NULL,NULL,'08:10:76:1F:A5:4D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(92,NULL,NULL,'CC:32:E5:9B:C5:B5','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(93,NULL,NULL,'00:90:C8:A1:24:73','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(94,NULL,NULL,'CC:32:E5:9B:B1:3B','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(95,NULL,NULL,'50:D4:F7:4A:8E:0F','1452',1,'2M','disabled',0,'98',414609,145353,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(96,NULL,NULL,'08:10:76:A1:7D:42','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(97,NULL,NULL,'08:10:76:B1:9B:4B','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(98,NULL,NULL,'08:10:76:77:4C:5E','1452',1,'default','disabled',0,'286',3684807,30697812,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(99,NULL,NULL,'1C:3B:F3:C4:9F:E9','1452',1,'2M','disabled',0,'351',1112362,2782951,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(100,NULL,NULL,'08:10:76:1A:BB:8A','1452',1,'4M','disabled',0,'63',1036946,2735937,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(101,NULL,NULL,'68:B5:99:EA:51:FB','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(102,NULL,NULL,'00:E0:4B:AA:B5:31','1452',1,'default','disabled',0,'529',4932059,24057372,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(103,NULL,NULL,'70:25:60:AB:07:B9','1452',1,'15 M','disabled',0,'351',3262555,58588747,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(104,NULL,NULL,'70:25:60:AA:01:D1','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(105,NULL,NULL,'08:10:76:8A:3C:52','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(106,NULL,NULL,'00:E0:4B:DD:85:30','1452',1,'1M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(107,NULL,NULL,'B8:3A:08:19:34:90','1452',1,'default','disabled',0,'479',2688,2688,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(108,NULL,NULL,'08:10:76:D7:F5:6F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(109,NULL,NULL,'86:81:C9:A7:AE:27','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(110,NULL,NULL,'D8:07:B6:91:5F:55','1452',1,'25M','disabled',0,'73',192,240,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(111,NULL,NULL,'00:E0:4B:A5:4C:CD','1452',1,'2M','disabled',0,'29',119,0,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(112,NULL,NULL,'08:10:76:3E:4E:A5','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(113,NULL,NULL,'08:5D:DD:50:FE:C0','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-07-10 20:44:19',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(114,NULL,NULL,'08:5D:DD:39:76:98','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(115,NULL,NULL,'00:E0:4B:AC:3F:46','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(116,NULL,NULL,'00:E0:4B:ED:F8:9D','1452',1,'25M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(117,NULL,NULL,'C4:C7:A1:66:44:32','1452',1,'275M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(118,NULL,NULL,'08:10:76:85:44:BA','1452',1,'2M','disabled',0,'352',4048697,81243197,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(119,NULL,NULL,'BC:96:80:97:91:E1','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(120,NULL,NULL,'08:5D:DD:39:4F:E4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(121,NULL,NULL,'C0:C2:C0:98:01:16','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(122,NULL,NULL,'00:27:1C:6A:C3:E7','1452',1,'2M','disabled',0,'187',542846,4106154,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(123,NULL,NULL,'08:10:76:5B:02:7D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-07-10 20:44:19',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(124,NULL,NULL,'08:10:76:F5:18:36','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(125,NULL,NULL,'08:10:76:A8:5B:70','1452',1,'2M','disabled',0,'352',1202977,10034055,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(126,NULL,NULL,'88:44:77:5F:B4:D4','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(127,NULL,NULL,'00:E0:4B:F3:15:41','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(128,NULL,NULL,'B0:4E:26:4D:D6:21','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(129,NULL,NULL,'00:27:22:4E:81:A1','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(130,NULL,NULL,'00:30:0D:10:C2:C7','1452',1,'15 M','disabled',0,'172',822620,5517765,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(131,NULL,NULL,'04:09:B2:A3:80:29','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(132,NULL,NULL,'00:27:1C:73:4F:7F','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(133,NULL,NULL,'08:10:76:EE:A9:84','1452',1,'1M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(134,NULL,NULL,'B8:3A:08:19:33:E0','1452',1,'3M','disabled',0,'328',1848,1848,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(135,NULL,NULL,'BC:96:80:BA:12:51','1452',1,'default','disabled',0,'19',319852,376989,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(136,NULL,NULL,'00:30:0D:BE:46:F9','1452',1,'default','disabled',0,'288',10730900,48737191,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(137,NULL,NULL,'08:10:76:6C:C9:71','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(138,NULL,NULL,'08:5D:DD:0A:0B:FC','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(139,NULL,NULL,'08:10:76:00:D5:C0','1452',1,'default','disabled',0,'225',71218,99045,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(140,NULL,NULL,'00:1F:1F:F2:AB:AF','1452',1,'default','disabled',0,'117',278051,324565,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(141,NULL,NULL,'00:27:1C:77:93:DB','1452',1,'275M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(142,NULL,NULL,'00:30:0D:BF:71:ED','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(143,NULL,NULL,'00:30:0D:BF:00:9B','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(144,NULL,NULL,'78:44:76:9C:30:49','1452',1,'2M','disabled',0,'375',2450792,5340701,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(145,NULL,NULL,'00:27:1C:DD:D7:E1','1452',1,'default','disabled',0,'495',5212691,104414406,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(146,NULL,NULL,'08:5D:DD:BF:25:4B','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(147,NULL,NULL,'78:44:76:9C:22:99','1452',1,'default','disabled',0,'486',415781,296891,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(148,NULL,NULL,'00:E0:4C:53:AA:78','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(149,NULL,NULL,'08:10:76:54:1F:43','1452',1,'275M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(150,NULL,NULL,'78:44:76:83:1B:E5','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(151,NULL,NULL,'00:30:0D:AE:48:CD','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(152,NULL,NULL,'00:27:1C:B8:00:F3','1452',1,'5M','disabled',0,'501',1115282,29446112,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(153,NULL,NULL,'00:30:0D:BF:5B:25','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:19','2026-09-23 19:45:38',NULL),(154,NULL,NULL,'08:10:76:29:28:0D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(155,NULL,NULL,'08:10:76:24:8A:A0','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(156,NULL,NULL,'00:E0:4C:07:BA:51','1452',1,'default','disabled',0,'352',2476531,53740627,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(157,NULL,NULL,'08:10:76:7F:AB:D9','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(158,NULL,NULL,'08:10:76:E5:98:0C','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(159,NULL,NULL,'0C:80:63:6B:F8:1D','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(160,NULL,NULL,'08:10:76:50:75:23','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(161,NULL,NULL,'08:10:76:BF:BF:8E','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(162,NULL,NULL,'08:10:76:88:0B:A2','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(163,NULL,NULL,'08:10:76:0A:A0:07','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(164,NULL,NULL,'00:30:0D:AB:E7:B3','1452',1,'default','disabled',0,'381',4224218,285597223,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(165,NULL,NULL,'C4:C7:A1:62:10:77','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(166,NULL,NULL,'08:10:76:5A:76:30','1452',1,'2M','disabled',0,'176',34811,22471,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(167,NULL,NULL,'08:10:76:3B:6F:73','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(168,NULL,NULL,'08:10:76:EE:B2:B2','1452',1,'10M','disabled',0,'495',4135117,57120602,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(169,NULL,NULL,'00:E0:4B:AD:2F:0B','1452',1,'default','disabled',0,'521',1961359,42761922,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(170,NULL,NULL,'08:10:76:8B:D1:C4','1452',1,'25M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(171,NULL,NULL,'00:E0:4C:07:78:AD','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(172,NULL,NULL,'08:10:76:17:FC:AF','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(173,NULL,NULL,'08:10:76:89:71:C2','1452',1,'default','disabled',0,'495',5524720,78623011,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(174,NULL,NULL,'00:30:0D:AD:F7:73','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(175,NULL,NULL,'08:10:76:2C:91:6F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(176,NULL,NULL,'08:10:76:6C:4F:EB','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(177,NULL,NULL,'94:FB:B2:09:46:02','1452',1,'560 KB','disabled',0,'484',74086,72662,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(178,NULL,NULL,'00:27:10:7D:B5:BC','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(179,NULL,NULL,'04:09:B1:A6:95:68','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(180,NULL,NULL,'08:10:76:F2:B7:81','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(181,NULL,NULL,'08:10:76:29:A5:0D','1452',1,'3M','disabled',0,'159',166402,375349,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(182,NULL,NULL,'08:10:76:FB:7F:EB','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(183,NULL,NULL,'00:E0:4B:98:E6:E2','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(184,NULL,NULL,'08:10:76:35:10:B8','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(185,NULL,NULL,'08:10:76:14:36:D4','1452',1,'225M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(186,NULL,NULL,'08:10:76:2F:E4:F1','1452',1,'3M','disabled',0,'37',2896534,6714297,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(187,NULL,NULL,'78:44:76:9C:2A:FD','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(188,NULL,NULL,'08:10:76:EF:B1:8C','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(189,NULL,NULL,'00:09:B1:A1:25:86','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(190,NULL,NULL,'08:5D:DD:09:C0:A4','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(191,NULL,NULL,'70:25:60:AA:02:13','1452',1,'default','disabled',0,'515',2783681,13568187,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(192,NULL,NULL,'00:E0:4B:B0:A6:E7','1452',1,'default','disabled',0,'60',11338,12163,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(193,NULL,NULL,'40:3F:8C:8F:69:61','1452',1,'2M','disabled',0,'333',2126799,28700842,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(194,NULL,NULL,'08:10:76:E3:1B:0B','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(195,NULL,NULL,'08:10:76:27:D1:79','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(196,NULL,NULL,'00:E0:4B:94:9A:AF','1452',1,'3M','disabled',0,'495',1802109,33373701,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:30',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(197,NULL,NULL,'08:10:76:41:DB:72','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(198,NULL,NULL,'08:10:76:0E:A0:89','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(199,NULL,NULL,'C0:C2:C0:A8:E9:97','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(200,NULL,NULL,'78:44:76:87:28:1D','1452',1,'default','disabled',0,'373',1348703,8114480,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(201,NULL,NULL,'user2','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(202,NULL,NULL,'user3','14522',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(203,NULL,NULL,'user4','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(204,NULL,NULL,'user5','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(205,NULL,NULL,'user6','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(206,NULL,NULL,'user7','14522',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(207,NULL,NULL,'user8','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(208,NULL,NULL,'user9','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(209,NULL,NULL,'user10','14522',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(210,NULL,NULL,'user12','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(211,NULL,NULL,'user13','14521',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(212,NULL,NULL,'user14','********',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(213,NULL,NULL,'00:30:0D:11:16:5B','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(214,NULL,NULL,'00:30:0D:AB:BA:97','1452',1,'3M','disabled',0,'493',8469108,91770757,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:20','2026-09-23 19:45:38',NULL),(215,NULL,NULL,'08:10:76:A7:B0:A7','1452',1,'default','disabled',0,'494',3627883,49648647,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(216,NULL,NULL,'08:10:76:43:57:9F','1452',1,'15 M','disabled',0,'39',2949,3807,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(217,NULL,NULL,'08:10:76:41:C2:C9','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(218,NULL,NULL,'08:10:76:11:DF:9F','1452',1,'default','disabled',0,'64',14593,18290,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(219,NULL,NULL,'08:10:76:48:08:1F','1452',1,'default','disabled',0,'494',1785178,75280819,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(220,NULL,NULL,'00:30:0D:10:34:09','1452',1,'15 M','disabled',0,'177',880471,9672289,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(221,NULL,NULL,'00:90:A2:02:90:91','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(222,NULL,NULL,'08:10:76:31:C5:84','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(223,NULL,NULL,'08:5D:DD:26:84:D4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(224,NULL,NULL,'00:E0:4B:9D:C5:C3','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(225,NULL,NULL,'08:10:76:60:70:8D','1452',1,'default','disabled',0,'495',3728000,75601276,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(226,NULL,NULL,'user15','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(227,NULL,NULL,'08:10:76:0F:EA:63','1452',1,'25M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(228,NULL,NULL,'08:10:76:75:25:75','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(229,NULL,NULL,'C0:C2:C0:E1:A9:69','1452',1,'25M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(230,NULL,NULL,'C0:06:C3:B6:49:2F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(231,NULL,NULL,'08:10:76:F5:6C:C5','1452',1,'15 M','disabled',0,'516',3341995,45447587,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(232,NULL,NULL,'08:10:76:53:AD:B9','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(233,NULL,NULL,'08:10:76:17:37:33','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(234,NULL,NULL,'00:30:0D:10:78:A5','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(235,NULL,NULL,'00:30:0D:11:19:C7','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(236,NULL,NULL,'00:E0:4B:97:9C:D0','1452',1,'225M','disabled',0,'10',40348,82739,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(237,NULL,NULL,'08:10:76:00:E5:47','1452',1,'25M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(238,NULL,NULL,'08:10:76:2E:36:1C','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(239,NULL,NULL,'00:E0:4C:80:7F:B0','1452',1,'default','disabled',0,'491',2311948,43172660,'2026-07-10 20:44:29',NULL,NULL,'2026-09-13 07:50:59',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(240,NULL,NULL,'08:10:76:0D:C8:69','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(241,NULL,NULL,'00:27:1C:32:75:23','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(242,NULL,NULL,'00:27:1C:B8:6E:83','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(243,NULL,NULL,'08:10:76:3D:F2:DA','1452',1,'default','disabled',0,'397',106047,157619,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(244,NULL,NULL,'08:10:76:55:EE:64','1452',1,'default','disabled',0,'481',14373,3748,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(245,NULL,NULL,'94:FB:B2:16:31:01','1452',1,'4M','disabled',0,'114',4132924,35164804,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(246,NULL,NULL,'00:E0:4C:6B:CE:21','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(247,NULL,NULL,'08:10:76:EA:42:B4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(248,NULL,NULL,'EE:C5:4F:60:72:31','1452',1,'1M','disabled',0,'66',574311,3805267,'2026-07-10 20:44:29',NULL,NULL,'2026-09-17 23:36:13',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(249,NULL,NULL,'08:10:76:CE:11:F7','1452',1,'4M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(250,NULL,NULL,'08:10:76:40:87:B1','1452',1,'3M','disabled',0,'10',5982,6169,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(251,NULL,NULL,'08:10:76:3B:33:C5','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(252,NULL,NULL,'08:10:76:F6:91:76','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(253,NULL,NULL,'08:10:76:67:E6:51','1452',1,'1M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(254,NULL,NULL,'08:10:76:26:88:3E','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(255,NULL,NULL,'08:10:76:42:1F:F4','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(256,NULL,NULL,'00:E0:4C:8E:2E:5B','1452',1,'default','disabled',0,'493',2365890,35390213,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(257,NULL,NULL,'1C:AB:32:04:12:26','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(258,NULL,NULL,'08:10:76:5D:2D:CD','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(259,NULL,NULL,'78:44:76:A6:FA:FB','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(260,NULL,NULL,'00:90:C1:A6:62:68','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(261,NULL,NULL,'74:B5:7E:02:86:F9','1452',1,'2M','disabled',0,'352',4225109,203994676,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(262,NULL,NULL,'08:10:76:8A:6F:6E','1452',1,'2M','disabled',0,'522',37759425,100440683,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(263,NULL,NULL,'08:10:76:0E:A5:4B','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(264,NULL,NULL,'08:10:76:CA:6C:D8','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(265,NULL,NULL,'08:10:76:78:BD:DE','1452',1,'7M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(266,NULL,NULL,'08:10:76:09:76:F1','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(267,NULL,NULL,'08:10:76:2C:16:F7','1452',1,'5M','disabled',0,'117',9261,15020,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(268,NULL,NULL,'08:10:76:1F:AA:14','1452',1,'45M','disabled',0,'64',25733,27861,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(269,NULL,NULL,'08:10:76:CE:E4:E0','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(270,NULL,NULL,'08:10:76:DC:07:B0','1452',1,'default','disabled',0,'163',5754229,114672495,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(271,NULL,NULL,'08:10:76:D8:38:71','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(272,NULL,NULL,'08:10:76:F3:05:50','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(273,NULL,NULL,'08:10:76:D1:C3:D0','1452',1,'default','disabled',0,'512',218696,353058,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(274,NULL,NULL,'08:10:76:F1:BE:DC','1452',1,'25M','disabled',0,'23',9103,15692,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(275,NULL,NULL,'08:10:76:15:C2:62','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(276,NULL,NULL,'08:10:76:B3:69:05','1452',1,'default','disabled',0,'522',2759833,42129926,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(277,NULL,NULL,'08:10:76:15:EA:79','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(278,NULL,NULL,'08:10:76:F3:D0:69','1452',1,'6M','active',0,'0',0,0,NULL,NULL,NULL,'2026-07-10 20:44:21',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(279,NULL,NULL,'08:10:76:EF:60:15','1452',1,'8M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(280,NULL,NULL,'70:25:60:AA:00:F8','1452',1,'default','disabled',0,'279',3784177,60836108,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:21','2026-09-23 19:45:38',NULL),(281,NULL,NULL,'08:10:76:45:C6:D1','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(282,NULL,NULL,'1C:AB:32:04:09:21','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(283,NULL,NULL,'00:E0:4B:AD:BE:8C','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(284,NULL,NULL,'08:10:76:0D:94:E6','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(285,NULL,NULL,'08:10:76:1F:77:7A','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(286,NULL,NULL,'08:10:76:AA:8E:3F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(287,NULL,NULL,'08:10:76:4C:4A:3B','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(288,NULL,NULL,'08:10:76:5E:80:5D','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(289,NULL,NULL,'08:10:76:DE:F3:70','1452',1,'default','disabled',0,'65',1902294,25189998,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(290,NULL,NULL,'00:E0:4B:FA:9F:C5','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(291,NULL,NULL,'00:E0:4C:0B:8A:D1','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(292,NULL,NULL,'00:E0:4C:4B:EF:76','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(293,NULL,NULL,'20:E8:82:9F:C3:86','1452',1,'25M','disabled',0,'27',207927,4124271,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(294,NULL,NULL,'08:10:76:18:8D:69','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(295,NULL,NULL,'00:E0:4C:4C:31:B7','1452',1,'8M','disabled',0,'262',4256660,75542404,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(296,NULL,NULL,'00:E0:4C:55:B2:80','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(297,NULL,NULL,'08:10:76:5F:2F:94','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(298,NULL,NULL,'08:10:76:B4:B7:61','1452',1,'default','disabled',0,'294',5217705,104843202,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(299,NULL,NULL,'08:10:76:9B:F3:29','1452',1,'8M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(300,NULL,NULL,'08:10:76:6D:CA:18','1452',1,'2M','disabled',0,'493',4769750,48610591,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(301,NULL,NULL,'08:10:76:A6:34:BE','1452',1,'default','disabled',0,'29',395,100,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(302,NULL,NULL,'00:E0:4B:BC:07:D3','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(303,NULL,NULL,'08:10:76:5B:31:C5','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(304,NULL,NULL,'AC:81:12:76:0B:C8','1452',1,'out cut','disabled',0,'2301',2535092,70768366,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(305,NULL,NULL,'user1','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(306,NULL,NULL,'00:E0:4C:4C:D3:39','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(307,NULL,NULL,'user16','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(308,NULL,NULL,'08:10:76:40:AB:F4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(309,NULL,NULL,'08:10:76:61:70:A2','1452',1,'3M','disabled',0,'247',465308,773428,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(310,NULL,NULL,'08:10:76:52:5A:C6','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(311,NULL,NULL,'08:10:76:FB:61:7A','1452',1,'2M','disabled',0,'505',4406853,60088889,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(312,NULL,NULL,'08:10:76:E4:AE:D6','1452',1,'4M','disabled',0,'159',427462,8617068,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(313,NULL,NULL,'08:10:76:C9:32:96','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(314,NULL,NULL,'08:10:76:8D:C8:C0','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(315,NULL,NULL,'08:10:76:9D:C3:70','1452',1,'3M','disabled',0,'197',949457,873056,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(316,NULL,NULL,'08:10:76:BF:A1:45','1452',1,'3M','disabled',0,'123',1339346,16627233,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(317,NULL,NULL,'08:10:76:4C:78:F4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(318,NULL,NULL,'C4:C7:A1:66:41:47','1452',1,'4M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(319,NULL,NULL,'08:10:76:26:47:E1','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(320,NULL,NULL,'04:09:B1:A6:95:41','1452',1,'3M','disabled',0,'456',4825915,26064242,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(321,NULL,NULL,'08:10:76:8A:DE:FB','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(322,NULL,NULL,'08:10:76:5B:35:89','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(323,NULL,NULL,'08:10:76:E8:69:A0','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(324,NULL,NULL,'00:E0:4B:FA:A0:50','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(325,NULL,NULL,'00:E0:4C:0C:97:5F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(326,NULL,NULL,'B8:3A:08:22:C7:1F','1452',1,'default','disabled',0,'477',2384727,37158073,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(327,NULL,NULL,'08:10:76:F8:3E:C7','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(328,NULL,NULL,'08:10:76:AD:55:00','1452',1,'default','disabled',0,'64',1116463,5430362,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(329,NULL,NULL,'08:10:76:AF:56:FA','1452',1,'10M','disabled',0,'76',578243,10065990,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(330,NULL,NULL,'08:10:76:3B:C2:15','1452',1,'10M','disabled',0,'12',359,237,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(331,NULL,NULL,'08:10:76:B4:83:63','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(332,NULL,NULL,'00:E0:4C:57:CA:54','1452',1,'default','disabled',0,'404',2875441,26105723,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(333,NULL,NULL,'00:E0:4C:7F:38:60','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(334,NULL,NULL,'58:D7:59:6F:22:AD','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(335,NULL,NULL,'08:10:76:78:00:CE','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(336,NULL,NULL,'08:10:76:11:2E:D7','1452',1,'2M','disabled',0,'571',3362909,98884879,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(337,NULL,NULL,'08:10:76:C9:D8:B9','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(338,NULL,NULL,'08:10:76:19:7C:A7','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(339,NULL,NULL,'user17','1452',1,' ','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(340,NULL,NULL,'08:10:76:8D:B7:35','1452',1,'3M','disabled',0,'510',1486842,9185657,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(341,NULL,NULL,'08:10:76:C3:86:9C','1452',1,'225M','disabled',0,'124',197133,482067,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(342,NULL,NULL,'08:10:76:B9:97:82','1452',1,'default','disabled',0,'38',10904,13213,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(343,NULL,NULL,'08:10:76:33:41:BE','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(344,NULL,NULL,'08:10:76:24:51:58','1452',1,'5M','disabled',0,'511',10817881,100040855,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(345,NULL,NULL,'00:01:36:03:16:91','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(346,NULL,NULL,'08:10:76:08:1B:21','1452',1,'3M','disabled',0,'155',638237,21022005,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(347,NULL,NULL,'08:10:76:1F:A3:5B','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(348,NULL,NULL,'08:10:76:0B:15:58','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(349,NULL,NULL,'00:E0:4C:81:96:C9','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(350,NULL,NULL,'08:10:76:21:FD:C5','1452',1,'default','disabled',0,'287',1029109,15036407,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:22','2026-09-23 19:45:38',NULL),(351,NULL,NULL,'08:10:76:77:E9:53','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(352,NULL,NULL,'08:10:76:61:3E:89','1452',1,'3M','disabled',0,'418',25082492,9587160,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(353,NULL,NULL,'08:10:76:3B:4D:A9','1452',1,'8M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(354,NULL,NULL,'08:10:76:5E:13:8E','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(355,NULL,NULL,'08:10:76:63:75:B8','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(356,NULL,NULL,'08:10:76:E4:E7:63','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(357,NULL,NULL,'08:10:76:57:75:0E','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(358,NULL,NULL,'08:10:76:DB:4D:3E','1452',1,'default','disabled',0,'345',663939,1199971,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(359,NULL,NULL,'08:10:76:6E:2B:4D','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(360,NULL,NULL,'08:10:76:F7:F9:00','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(361,NULL,NULL,'08:10:76:BD:2C:0E','1452',1,'2M','disabled',0,'129',886879,1426236,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(362,NULL,NULL,'08:10:76:E4:AE:17','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(363,NULL,NULL,'08:10:76:04:39:0B','1452',1,'default','disabled',0,'22',2456,8820,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(364,NULL,NULL,'user18','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(365,NULL,NULL,'08:10:76:8F:C3:73','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(366,NULL,NULL,'78:44:76:7F:FE:C5','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(367,NULL,NULL,'08:10:76:AB:CC:7C','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(368,NULL,NULL,'00:E0:4C:76:86:2D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(369,NULL,NULL,'00:E0:4C:53:CD:37','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(370,NULL,NULL,'00:E0:4C:5D:5C:B9','1452',1,'2M','disabled',0,'372',2890795,83343067,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(371,NULL,NULL,'08:10:76:B7:5D:94','1452',1,'8M','disabled',0,'373',3634783,32320521,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(372,NULL,NULL,'08:10:76:B9:15:42','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(373,NULL,NULL,'00:E0:4C:80:8C:67','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(374,NULL,NULL,'00:E0:4C:5C:91:3F','1452',1,'default','disabled',0,'492',3293699,80876751,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(375,NULL,NULL,'00:E0:4C:76:62:62','1452',1,'default','disabled',0,'533',2610857,3475277,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(376,NULL,NULL,'08:10:76:E2:E0:45','1452',1,'3M','disabled',0,'581',9923288,218576089,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(377,NULL,NULL,'00:E0:4C:76:67:BD','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(378,NULL,NULL,'00:E0:4C:55:4A:00','1452',1,'default','disabled',0,'219',1308552,8176870,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(379,NULL,NULL,'00:E0:4C:76:9A:31','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(380,NULL,NULL,'00:E0:4C:68:B3:BC','1452',1,'default','disabled',0,'523',3277869,69965215,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(381,NULL,NULL,'00:E0:4C:55:66:C1','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(382,NULL,NULL,'00:E0:4C:57:DC:CC','1452',1,'35M','disabled',0,'493',3958789,23677394,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(383,NULL,NULL,'00:E0:4C:73:33:B4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(384,NULL,NULL,'00:E0:4C:5C:A5:DA','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(385,NULL,NULL,'00:E0:4C:7C:9C:C4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(386,NULL,NULL,'00:E0:4C:57:FE:AC','1452',1,'default','disabled',0,'412',6737916,82892331,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(387,NULL,NULL,'C0:C2:C0:98:01:24','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(388,NULL,NULL,'00:E0:4C:74:DD:EE','1452',1,'default','disabled',0,'63',66215,88570,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(389,NULL,NULL,'08:10:76:64:12:A2','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(390,NULL,NULL,'08:10:76:20:44:5C','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(391,NULL,NULL,'08:10:76:42:6D:2E','1452',1,'225M','disabled',0,'215',1747227,25318236,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(392,NULL,NULL,'1C:A5:32:6E:D7:91','1452',1,'3M','disabled',0,'428',4020880,40669884,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(393,NULL,NULL,'08:10:76:9C:8A:21','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(394,NULL,NULL,'00:E0:4C:90:AB:2A','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(395,NULL,NULL,'00:E0:4C:6B:C8:E1','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(396,NULL,NULL,'00:E0:4C:7D:57:2E','1452',1,'15 M','disabled',0,'196',275028,406434,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(397,NULL,NULL,'user19','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(398,NULL,NULL,'74:DA:88:43:BD:87','1452',1,'10M','disabled',0,'494',9715085,176676767,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(399,NULL,NULL,'00:E0:4C:97:04:8C','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(400,NULL,NULL,'00:E0:4C:6C:58:07','1452',1,'default','disabled',0,'465',48504,128800,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(401,NULL,NULL,'00:E0:4C:76:91:23','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(402,NULL,NULL,'00:E0:4B:B0:71:07','1452',1,'default','disabled',0,'90',10097,7667,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(403,NULL,NULL,'08:10:76:EE:01:FC','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(404,NULL,NULL,'00:E0:4C:5D:12:7E','1452',1,'default','disabled',0,'494',5779336,40062045,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(405,NULL,NULL,'00:E0:4B:98:42:CE','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(406,NULL,NULL,'00:E0:4B:97:81:20','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(407,NULL,NULL,'8C:15:C7:F4:39:39','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(408,NULL,NULL,'00:E0:4B:95:4F:02','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(409,NULL,NULL,'00:E0:4C:08:87:CD','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(410,NULL,NULL,'08:10:76:A4:63:BF','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(411,NULL,NULL,'70:25:60:4E:24:6B','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(412,NULL,NULL,'00:E0:4B:E5:DA:46','1452',1,'225M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(413,NULL,NULL,'00:E0:4B:A3:95:9B','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(414,NULL,NULL,'08:10:76:44:A5:21','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(415,NULL,NULL,'08:10:76:55:68:C3','1452',1,'4M','disabled',0,'514',6413504,93685011,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(416,NULL,NULL,'B8:3A:08:19:74:48','1452',1,'default','disabled',0,'494',6267523,169564962,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(417,NULL,NULL,'A8:6E:84:9B:1D:4B','1452',1,'default','disabled',0,'490',2062412,36439795,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(418,NULL,NULL,'00:90:A2:E3:23:B5','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:23','2026-09-23 19:45:38',NULL),(419,NULL,NULL,'00:E0:4C:55:98:A8','1452',1,'35M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(420,NULL,NULL,'9C:74:03:89:2B:53','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(421,NULL,NULL,'00:27:22:1E:79:85','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(422,NULL,NULL,'94:FB:B2:04:F9:61','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(423,NULL,NULL,'00:E0:4C:82:52:B6','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(424,NULL,NULL,'00:E0:4B:8F:62:89','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(425,NULL,NULL,'3C:52:A1:9B:30:E1','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(426,NULL,NULL,'00:E0:4C:89:EA:93','1452',1,'5M','active',0,'151',4702019,15374821,'2026-07-10 20:44:29',NULL,NULL,'2026-07-10 20:44:24',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(427,NULL,NULL,'08:10:76:A5:34:E8','1452',1,'default','disabled',0,'294',6106900,17463123,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(428,NULL,NULL,'08:10:76:A2:B1:E4','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(429,NULL,NULL,'00:E0:4C:83:94:05','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(430,NULL,NULL,'00:E0:4C:60:ED:25','1452',1,'4M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(431,NULL,NULL,'00:E0:4C:59:85:9E','1452',1,'default','disabled',0,'515',6509446,55428583,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(432,NULL,NULL,'00:E0:4C:74:E0:84','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(433,NULL,NULL,'08:10:76:65:47:D6','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(434,NULL,NULL,'02:27:22:1E:82:0F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-07-10 20:44:24',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(435,NULL,NULL,'00:E0:4C:6D:B9:5B','1452',1,'2M','disabled',0,'115',883580,16432447,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(436,NULL,NULL,'08:10:76:B4:49:D4','1452',1,'3M','disabled',0,'44',4428,10081,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(437,NULL,NULL,'0C:80:63:F9:C8:51','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(438,NULL,NULL,'C0:C1:C0:1A:BE:A3','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(439,NULL,NULL,'08:10:76:11:DD:50','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(440,NULL,NULL,'08:10:76:97:1D:1E','1452',1,'default','disabled',0,'6',347,156,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(441,NULL,NULL,'B0:89:00:89:1D:8D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(442,NULL,NULL,'08:10:76:D0:97:BE','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(443,NULL,NULL,'00:E0:4B:C0:49:DD','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(444,NULL,NULL,'00:E0:4B:A6:01:50','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(445,NULL,NULL,'00:E0:4B:A9:92:86','1452',1,'225M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(446,NULL,NULL,'08:10:76:08:C6:0C','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(447,NULL,NULL,'08:10:76:99:4D:E7','1452',1,'default','disabled',0,'332',599738,1641499,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(448,NULL,NULL,'08:10:76:32:59:5F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(449,NULL,NULL,'64:6D:6C:96:5E:DF','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(450,NULL,NULL,'00:E0:4C:53:CD:FD','1452',1,'5M','disabled',0,'493',2435086,86486335,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(451,NULL,NULL,'08:10:76:7C:34:B7','1452',1,'default','disabled',0,'206',166175,825597,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(452,NULL,NULL,'00:E0:4C:73:15:7E','1452',1,'default','disabled',0,'489',4381810,73679099,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(453,NULL,NULL,'08:10:76:2D:A6:FC','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(454,NULL,NULL,'00:E0:4C:68:B7:0D','1452',1,'default','disabled',0,'43',47760,43607,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(455,NULL,NULL,'08:10:76:5B:95:30','1452',1,'default','disabled',0,'294',1566859,19521072,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(456,NULL,NULL,'08:10:76:18:2E:46','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(457,NULL,NULL,'08:10:76:0E:54:9A','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(458,NULL,NULL,'08:10:76:DF:7B:0B','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(459,NULL,NULL,'08:10:76:0A:14:D5','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(460,NULL,NULL,'08:10:76:B1:0E:94','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(461,NULL,NULL,'08:10:76:97:8D:41','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(462,NULL,NULL,'08:10:76:1D:D5:12','1452',1,'275M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(463,NULL,NULL,'00:E0:4B:B0:BB:B5','1452',1,'default','disabled',0,'85',21925,24463,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(464,NULL,NULL,'08:10:76:8F:0B:63','1452',1,'25M','disabled',0,'506',5297433,132319817,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(465,NULL,NULL,'08:10:76:1B:15:73','1452',1,'25M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(466,NULL,NULL,'C0:C1:C0:89:B2:65','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(467,NULL,NULL,'user21','********',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(468,NULL,NULL,'1C:A5:32:D8:AB:81','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(469,NULL,NULL,'B0:BE:76:70:0A:A7','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(470,NULL,NULL,'00:E0:4C:59:76:F1','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(471,NULL,NULL,'00:E0:4C:73:15:DE','1452',1,'default','disabled',0,'61',36607,22315,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(472,NULL,NULL,'00:E0:4C:53:B3:69','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(473,NULL,NULL,'00:E0:4B:FA:C0:E7','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(474,NULL,NULL,'58:D7:59:2D:42:C4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(475,NULL,NULL,'06:D2:50:FE:F3:F1','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(476,NULL,NULL,'44:94:FC:64:B7:BB','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(477,NULL,NULL,'00:E0:4C:08:30:D8','1452',1,'default','disabled',0,'564',784400,4332447,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(478,NULL,NULL,'00:E0:4C:56:AC:D5','1452',1,'default','disabled',0,'69',42062,74701,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(479,NULL,NULL,'B8:3A:08:22:AA:B7','1452',1,'default','disabled',0,'92',672,588,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(480,NULL,NULL,'00:E0:4C:07:89:BA','1452',1,'5M','disabled',0,'495',5276103,85841212,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(481,NULL,NULL,'user22','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(482,NULL,NULL,'08:10:76:62:0E:49','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(483,NULL,NULL,'00:E0:4C:4A:E1:66','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(484,NULL,NULL,'00:E0:4B:EE:13:BD','1452',1,'default','disabled',0,'511',1331505,2821613,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(485,NULL,NULL,'B8:3A:08:19:37:A8','1452',1,'default','disabled',0,'508',1821153,31437139,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(486,NULL,NULL,'00:E0:4C:55:C9:5D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(487,NULL,NULL,'00:E0:4B:A6:02:80','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(488,NULL,NULL,'08:10:76:9A:3F:03','1452',1,'default','disabled',0,'512',3684929,40718648,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(489,NULL,NULL,'08:10:76:6A:DB:AA','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:24','2026-09-23 19:45:38',NULL),(490,NULL,NULL,'08:10:76:68:8D:30','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(491,NULL,NULL,'08:10:76:46:C2:B3','1452',1,'default','disabled',0,'493',969951,30723292,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(492,NULL,NULL,'08:10:76:BD:FA:9C','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(493,NULL,NULL,'D6:99:13:17:FC:6E','1452',1,'3M','disabled',0,'108',22938,39327,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(494,NULL,NULL,'08:10:76:F9:EA:ED','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(495,NULL,NULL,'08:10:76:04:D5:5F','1452',1,'2M','disabled',0,'373',10184898,61140393,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(496,NULL,NULL,'08:10:76:F2:DD:BE','1452',1,'default','disabled',0,'169',1722302,30663085,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(497,NULL,NULL,'08:10:76:56:B6:59','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(498,NULL,NULL,'00:E0:4B:EE:9F:F1','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(499,NULL,NULL,'08:10:76:3A:EB:FB','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(500,NULL,NULL,'08:10:76:31:24:51','1452',1,'default','active',0,'0',0,0,NULL,NULL,NULL,'2026-07-10 20:44:25',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(501,NULL,NULL,'08:10:76:FC:A9:D0','1452',1,'default','disabled',0,'95',89905,714723,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(502,NULL,NULL,'08:10:76:F5:3C:44','1452',1,'35M','disabled',0,'512',461408,430073,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(503,NULL,NULL,'08:10:76:3D:7F:F8','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(504,NULL,NULL,'08:10:76:D8:69:66','1452',1,'default','disabled',0,'494',3910048,118162106,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(505,NULL,NULL,'F0:C8:50:F5:0F:89','1452',1,'default','disabled',0,'153',2802786,43493595,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(506,NULL,NULL,'08:10:76:59:BE:91','1452',1,'default','active',0,'0',0,0,NULL,NULL,NULL,'2026-07-10 20:44:25',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(507,NULL,NULL,'08:10:76:A7:B7:32','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(508,NULL,NULL,'08:10:76:12:09:07','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(509,NULL,NULL,'58:D0:61:84:E0:EA','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(510,NULL,NULL,'B8:3A:08:19:75:38','1452',1,'default','disabled',0,'283',36060,40222,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(511,NULL,NULL,'08:10:76:45:D8:E7','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(512,NULL,NULL,'08:10:76:FD:25:59','1452',1,'15 M','disabled',0,'130',8597917,21458692,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(513,NULL,NULL,'08:10:76:EC:8D:C9','1452',1,'3M','disabled',0,'130',796877,19720758,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(514,NULL,NULL,'08:10:76:29:77:E9','1452',1,'5M','disabled',0,'130',714561,4125919,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(515,NULL,NULL,'08:10:76:53:7A:1D','1452',1,'15 M','disabled',0,'106',2052,3003,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(516,NULL,NULL,'08:10:76:AF:0F:13','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(517,NULL,NULL,'CC:32:E5:9B:C3:EB','1452',1,'default','disabled',0,'39',312,290,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(518,NULL,NULL,'08:10:76:51:63:FE','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(519,NULL,NULL,'08:10:76:CB:DD:7E','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(520,NULL,NULL,'00:08:52:14:39:C1','1452',1,'default','disabled',0,'171',1311301,18520809,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(521,NULL,NULL,'08:10:76:B6:31:E1','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(522,NULL,NULL,'08:10:76:51:60:42','1452',1,'default','disabled',0,'340',833758,4567356,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(523,NULL,NULL,'08:10:76:85:85:0B','1452',1,'default','disabled',0,'39',128777,3056185,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(524,NULL,NULL,'08:10:76:F8:19:26','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(525,NULL,NULL,'08:10:76:C9:B1:61','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(526,NULL,NULL,'08:10:76:C7:04:1D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(527,NULL,NULL,'08:10:76:B3:32:F7','1452',1,'default','disabled',0,'39',158754,1517995,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(528,NULL,NULL,'08:10:76:6D:DF:49','1452',1,'3M','disabled',0,'287',3901482,55660419,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(529,NULL,NULL,'08:10:76:EE:B9:9C','1452',1,'default','disabled',0,'494',3830016,378955879,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(530,NULL,NULL,'08:10:76:B9:D4:01','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(531,NULL,NULL,'08:10:76:95:C1:D2','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(532,NULL,NULL,'user24','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(533,NULL,NULL,'08:10:76:10:5C:13','1452',1,'default','disabled',0,'59',24231,36808,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(534,NULL,NULL,'08:10:76:28:99:1C','1452',1,'2M','disabled',0,'542',6442468,80300502,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(535,NULL,NULL,'00:E0:4B:A0:52:58','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(536,NULL,NULL,'08:10:76:1B:9B:5F','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(537,NULL,NULL,'08:10:76:20:69:53','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(538,NULL,NULL,'08:10:76:50:88:7A','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(539,NULL,NULL,'08:10:76:48:1C:95','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(540,NULL,NULL,'08:10:76:BB:73:33','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(541,NULL,NULL,'08:10:76:E0:76:95','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(542,NULL,NULL,'08:10:76:90:18:CD','1452',1,'default','disabled',0,'237',1350449,4333646,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(543,NULL,NULL,'08:10:76:D6:45:81','1452',1,'10M','disabled',0,'334',1934338,20373769,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(544,NULL,NULL,'08:10:76:39:90:96','1452',1,'1M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(545,NULL,NULL,'16:97:3D:0B:11:FF','1452',1,'560 KB','disabled',0,'64',181823,4348354,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(546,NULL,NULL,'08:10:76:93:55:DA','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(547,NULL,NULL,'08:10:76:17:FB:D1','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(548,NULL,NULL,'08:10:76:9E:B2:34','1452',1,'default','disabled',0,'35',4205,3698,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(549,NULL,NULL,'08:10:76:F2:49:E4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(550,NULL,NULL,'08:10:76:D2:0D:A6','1452',1,'default','disabled',0,'30',60,99,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(551,NULL,NULL,'00:E0:4C:55:6C:67','1452',1,'1M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(552,NULL,NULL,'08:10:76:88:30:ED','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(553,NULL,NULL,'08:10:76:E7:2C:9C','1452',1,'default','disabled',0,'269',1387631,26131642,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(554,NULL,NULL,'08:10:76:62:71:10','1452',1,'default','disabled',0,'494',1790848,180677306,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(555,NULL,NULL,'C0:06:C3:E2:94:A5','1452',1,'default','disabled',0,'8',64,80,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(556,NULL,NULL,'08:10:76:43:36:EA','1452',1,'default','disabled',0,'78',113531,9403518,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:25','2026-09-23 19:45:38',NULL),(557,NULL,NULL,'08:10:76:81:18:99','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(558,NULL,NULL,'08:10:76:71:A0:C9','1452',1,'default','disabled',0,'276',105701659,2983677,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(559,NULL,NULL,'08:10:76:02:69:7D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(560,NULL,NULL,'08:10:76:30:98:0A','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(561,NULL,NULL,'08:10:76:50:11:3F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(562,NULL,NULL,'94:FB:B2:29:56:31','1452',1,'10M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(563,NULL,NULL,'08:10:76:3F:02:AF','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(564,NULL,NULL,'08:10:76:99:61:C4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(565,NULL,NULL,'08:10:76:0F:76:0F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(566,NULL,NULL,'08:10:76:4C:72:DE','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(567,NULL,NULL,'08:10:76:EA:42:2A','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(568,NULL,NULL,'08:10:76:26:50:98','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(569,NULL,NULL,'08:10:76:E1:35:12','1452',1,'default','disabled',0,'65',230670,938176,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(570,NULL,NULL,'08:10:76:07:A5:7F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(571,NULL,NULL,'08:10:76:D6:E0:3A','1452',1,'default','disabled',0,'40',374781,22411751,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(572,NULL,NULL,'78:44:76:87:2A:F9','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(573,NULL,NULL,'08:10:76:19:87:BC','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(574,NULL,NULL,'08:10:76:B8:8F:47','1452',1,'default','disabled',0,'495',1186360,14211822,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(575,NULL,NULL,'00:27:22:BB:30:51','1452',1,'default','disabled',0,'495',6550405,215788879,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(576,NULL,NULL,'08:10:76:F3:14:01','1452',1,'default','disabled',0,'40',284602,3470376,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(577,NULL,NULL,'B8:3A:08:22:C7:17','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(578,NULL,NULL,'08:10:76:9B:B9:0A','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(579,NULL,NULL,'08:10:76:3F:C2:65','1452',1,'default','disabled',0,'478',3533744,42241433,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(580,NULL,NULL,'08:10:76:6F:13:FD','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(581,NULL,NULL,'54:B8:0A:0D:8B:5D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(582,NULL,NULL,'08:10:76:7F:7D:DD','1452',1,'6M','disabled',0,'118',1321904,17801144,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(583,NULL,NULL,'08:10:76:FA:08:04','1452',1,'2M','disabled',0,'98',124479,1906771,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:35',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(584,NULL,NULL,'08:10:76:6C:A6:AE','1452',1,'default','disabled',0,'97',65062,110759,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(585,NULL,NULL,'08:10:76:AC:E2:50','1452',1,'default','disabled',0,'527',3502475,58014859,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(586,NULL,NULL,'08:10:76:05:02:28','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(587,NULL,NULL,'08:10:76:55:26:1A','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(588,NULL,NULL,'08:10:76:7C:76:1B','1452',1,'default','disabled',0,'288',371458,1267239,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(589,NULL,NULL,'C4:C7:A1:60:44:92','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(590,NULL,NULL,'C4:C7:A1:60:45:87','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(591,NULL,NULL,'C4:C7:A1:60:45:82','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(592,NULL,NULL,'08:10:76:E3:2D:66','1452',1,'4M','disabled',0,'406',2730929,50633718,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:26','2026-09-23 19:45:38',NULL),(593,NULL,NULL,'C4:C7:A1:60:44:82','1452',1,'10M','disabled',0,'95',598404,2118326,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(594,NULL,NULL,'C4:C7:A1:60:46:02','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(595,NULL,NULL,'C4:C7:A1:60:23:57','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(596,NULL,NULL,'1C:AB:32:03:02:91','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(597,NULL,NULL,'08:10:76:1A:CD:4B','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(598,NULL,NULL,'C4:C7:A1:60:21:57','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(599,NULL,NULL,'C4:C7:A1:66:44:72','1452',1,'4M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(600,NULL,NULL,'1C:AB:32:03:03:31','1452',1,'default','disabled',0,'492',3039355,62803579,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(601,NULL,NULL,'C4:C7:A1:66:45:62','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(602,NULL,NULL,'1C:AB:32:04:05:21','1452',1,'default','disabled',0,'263',1507472,19777835,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(603,NULL,NULL,'1C:AB:32:03:04:11','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(604,NULL,NULL,'1C:AB:32:03:03:91','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(605,NULL,NULL,'1C:AB:32:03:02:86','1452',1,'9M','disabled',0,'16',463217,2795816,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(606,NULL,NULL,'1C:AB:32:03:01:9A','1452',1,'4M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(607,NULL,NULL,'98:BA:5F:8A:B2:73','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(608,NULL,NULL,'1C:AB:32:03:04:21','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(609,NULL,NULL,'00:E0:4C:54:FF:D0','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(610,NULL,NULL,'1C:AB:32:04:10:91','1452',1,'default','disabled',0,'332',3565618,60826575,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(611,NULL,NULL,'1C:AB:32:04:00:9A','1452',1,'15 M','disabled',0,'515',4863314,33753374,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(612,NULL,NULL,'1C:AB:32:03:03:96','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(613,NULL,NULL,'08:10:76:51:B1:C1','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(614,NULL,NULL,'1C:AB:32:04:06:61','1452',1,'4M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(615,NULL,NULL,'08:10:76:A6:4B:BF','1452',1,'default','disabled',0,'511',3911577,149475308,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(616,NULL,NULL,'1C:AB:32:04:05:86','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(617,NULL,NULL,'C4:C7:A1:62:13:72','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(618,NULL,NULL,'B8:3A:08:19:33:88','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(619,NULL,NULL,'B8:3A:08:22:A4:DF','1452',1,'default','disabled',0,'515',2139622,40222295,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(620,NULL,NULL,'B8:3A:08:19:3A:10','1452',1,'default','disabled',0,'295',8072350,99210738,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(621,NULL,NULL,'08:10:76:F5:F7:52','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(622,NULL,NULL,'B8:3A:08:19:3B:D8','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(623,NULL,NULL,'B8:3A:08:22:C7:27','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(624,NULL,NULL,'B8:3A:08:19:42:58','1452',1,'default','disabled',0,'482',6983041,121179261,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(625,NULL,NULL,'B8:3A:08:22:C6:3F','1452',1,'default','disabled',0,'474',976674,3150452,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(626,NULL,NULL,'1C:AB:32:04:01:71','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(627,NULL,NULL,'B8:3A:08:19:3D:C8','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(628,NULL,NULL,'B8:3A:08:19:6E:B8','1452',1,'default','disabled',0,'585',3984,3504,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:27','2026-09-23 19:45:38',NULL),(629,NULL,NULL,'B8:3A:08:19:6E:E8','1452',1,'default','disabled',0,'585',4742106,2352962,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(630,NULL,NULL,'B8:3A:08:22:A4:5F','1452',1,'default','disabled',0,'277',1596,1596,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(631,NULL,NULL,'B8:3A:08:22:C6:57','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(632,NULL,NULL,'user11','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(633,NULL,NULL,'B8:3A:08:22:C5:B7','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(634,NULL,NULL,'B8:3A:08:22:BB:F7','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(635,NULL,NULL,'1C:A5:38:24:6B:A1','1452',1,'default','disabled',0,'493',2522067,83580456,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(636,NULL,NULL,'B8:3A:08:19:58:58','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(637,NULL,NULL,'B8:3A:08:19:58:38','1452',1,'10M','disabled',0,'280',1512,1512,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(638,NULL,NULL,'B8:3A:08:22:C6:BF','1452',1,'default','disabled',0,'335',1909291,62124450,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(639,NULL,NULL,'08:5D:DD:3E:01:A8','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(640,NULL,NULL,'B8:3A:08:22:C7:77','1452',1,'2M','disabled',0,'509',2856,2856,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(641,NULL,NULL,'B8:3A:08:22:C7:5F','1452',1,'default','disabled',0,'38',252,252,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(642,NULL,NULL,'B8:3A:08:19:3D:20','1452',1,'5M','disabled',0,'516',12964317,157561288,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(643,NULL,NULL,'B8:3A:08:22:C7:97','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(644,NULL,NULL,'B8:3A:08:19:3D:D8','1452',1,'default','disabled',0,'512',1157906,21126419,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(645,NULL,NULL,'B8:3A:08:22:99:8F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(646,NULL,NULL,'B8:3A:08:19:2D:50','1452',1,'default','disabled',0,'547',4536,2772,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(647,NULL,NULL,'user20','1452',1,'560 KB','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(648,NULL,NULL,'B8:3A:08:19:37:30','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(649,NULL,NULL,'B8:3A:08:22:C7:8F','1452',1,'2M','disabled',0,'294',2159021,29070765,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(650,NULL,NULL,'B8:3A:08:19:40:30','1452',1,'default','disabled',0,'492',4689070,54666162,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(651,NULL,NULL,'user23','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(652,NULL,NULL,'C4:C7:A1:66:24:87','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(653,NULL,NULL,'B8:3A:08:22:C6:FF','1452',1,'default','disabled',0,'1',84,0,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:36',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(654,NULL,NULL,'00:E0:4C:92:A8:E0','1452',1,'5M','disabled',0,'15',567482,7178116,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(655,NULL,NULL,'08:10:76:7C:CE:EC','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(656,NULL,NULL,'B8:3A:08:22:A6:6F','1452',1,'default','disabled',0,'91',93817,178995,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(657,NULL,NULL,'B8:3A:08:22:C7:E7','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(658,NULL,NULL,'B8:3A:08:19:56:38','1452',1,'default','disabled',0,'67',868960,12790288,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(659,NULL,NULL,'00:E0:4C:4E:DA:56','1452',1,'default','disabled',0,'494',1492215,1190824,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(660,NULL,NULL,'B8:3A:08:19:41:40','1452',1,'4M','disabled',0,'352',7156,12588,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(661,NULL,NULL,'B8:3A:08:22:99:4F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(662,NULL,NULL,'B8:3A:08:19:6D:F8','1452',1,'10M','disabled',0,'117',1092,588,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(663,NULL,NULL,'B8:3A:08:19:75:C8','1452',1,'default','disabled',0,'292',1003148,31232661,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(664,NULL,NULL,'94:FB:B2:10:2E:01','1452',1,'default','disabled',0,'48',39331,24601,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(665,NULL,NULL,'B8:3A:08:22:AA:BF','1452',1,'default','disabled',0,'335',3048058,25630060,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(666,NULL,NULL,'B8:3A:08:22:D5:17','1452',1,'3M','disabled',0,'510',509247,854609,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(667,NULL,NULL,'EC:08:6D:12:8A:7D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(668,NULL,NULL,'14:CC:20:E8:62:99','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(669,NULL,NULL,'CC:2D:E0:EB:95:35','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(670,NULL,NULL,'B8:3A:08:22:A8:1F','1452',1,'default','disabled',0,'513',4429107,113069600,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(671,NULL,NULL,'CC:2D:E0:EB:62:55','1452',1,'default','disabled',0,'287',3011477,114809132,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(672,NULL,NULL,'B8:3A:08:19:74:60','1452',1,'default','disabled',0,'97',3575,1461,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(673,NULL,NULL,'B8:3A:08:22:AA:DF','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(674,NULL,NULL,'B8:3A:08:19:77:B0','1452',1,'5M','disabled',0,'515',6317820,85769739,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(675,NULL,NULL,'CC:2D:E0:EB:10:35','1452',1,'default','disabled',0,'39',219706,6273389,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(676,NULL,NULL,'08:10:76:01:02:E7','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(677,NULL,NULL,'B8:3A:08:22:D5:67','1452',1,'default','disabled',0,'97',269841,8145610,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(678,NULL,NULL,'B8:3A:08:22:A8:37','1452',1,'default','disabled',0,'295',4115481,72357032,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(679,NULL,NULL,'B8:3A:08:19:75:80','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(680,NULL,NULL,'08:10:76:A2:4E:FF','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(681,NULL,NULL,'B8:3A:08:22:D9:B7','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(682,NULL,NULL,'B8:3A:08:22:A8:5F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(683,NULL,NULL,'98:FC:11:5A:FF:35','1452',1,'default','disabled',0,'103',194594,2590579,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(684,NULL,NULL,'08:10:76:18:8D:68','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(685,NULL,NULL,'00:27:22:6D:23:69','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(686,NULL,NULL,'1C:A5:32:75:BB:41','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(687,NULL,NULL,'A8:02:DB:F5:F9:C2','1452',1,'8M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(688,NULL,NULL,'B8:3A:08:19:74:B8','1452',1,'5M','disabled',0,'474',2688,2688,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(689,NULL,NULL,'B8:3A:08:22:D9:77','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(690,NULL,NULL,'00:E0:4C:57:64:93','1452',1,'default','disabled',0,'63',446174,10731220,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(691,NULL,NULL,'B8:3A:08:22:A7:E7','1452',1,'default','disabled',0,'273',1512,1512,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(692,NULL,NULL,'B8:3A:08:22:D9:27','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(693,NULL,NULL,'C6:9C:CA:A8:5A:A9','1452',1,'560 KB','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(694,NULL,NULL,'00:E0:4C:5C:81:70','1452',1,'default','disabled',0,'568',3687231,20674587,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(695,NULL,NULL,'70:25:60:AB:06:56','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(696,NULL,NULL,'08:10:76:69:F1:EF','1452',1,'default','disabled',0,'492',162230,247336,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(697,NULL,NULL,'00:0C:29:1A:1E:72','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(698,NULL,NULL,'aa','aa',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:28','2026-09-23 19:45:38',NULL),(699,NULL,NULL,'hs1','7bb4a9d0',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:29','2026-09-23 19:45:38',NULL),(700,NULL,NULL,'78:44:76:A6:FD:CB','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:29','2026-09-23 19:45:38',NULL),(701,NULL,NULL,'B8:3A:08:22:D9:0F','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:29','2026-09-23 19:45:38',NULL),(702,NULL,NULL,'1C:A5:32:76:D2:C1','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:29','2026-09-23 19:45:38',NULL),(703,NULL,NULL,'B8:3A:08:19:7E:C8','1452',1,'3M','disabled',0,'88',607978,17576594,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:29','2026-09-23 19:45:38',NULL),(704,NULL,NULL,'B8:3A:08:19:4F:20','1452',1,'default','disabled',0,'291',5035101,77773218,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:29','2026-09-23 19:45:38',NULL),(705,NULL,NULL,'B8:3A:08:22:D6:4F','1452',1,'default','disabled',0,'68',588,336,'2026-07-10 20:44:29',NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:29','2026-09-23 19:45:38',NULL),(706,NULL,NULL,'B8:3A:08:19:7E:20','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-07-10 20:44:29','2026-09-23 19:45:38',NULL),(707,NULL,NULL,'A8:88:CE:B3:3B:8B','1452',1,'560 KB','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:28',NULL,'2026-09-10 04:11:05','2026-09-23 19:45:38',NULL),(708,NULL,NULL,'90:0A:00:0A:B8:E7','1452',1,'out cut','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-09-10 04:11:06','2026-09-23 19:45:38',NULL),(709,NULL,NULL,'00:E0:4C:BB:F6:68','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-09-10 04:11:06','2026-09-23 19:45:38',NULL),(710,NULL,NULL,'BC:96:80:9A:55:81','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:29',NULL,'2026-09-10 04:11:06','2026-09-23 19:45:38',NULL),(711,NULL,NULL,'08:10:76:C2:5F:D8','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:32',NULL,'2026-09-10 04:11:09','2026-09-23 19:45:38',NULL),(712,NULL,NULL,'00:E0:4C:B0:C9:31','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:33',NULL,'2026-09-10 04:11:10','2026-09-23 19:45:38',NULL),(713,NULL,NULL,'08:5D:FD:86:4F:13','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-09-10 04:11:10','2026-09-23 19:45:38',NULL),(714,NULL,NULL,'08:10:76:82:34:0C','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-09-10 04:11:11','2026-09-23 19:45:38',NULL),(715,NULL,NULL,'08:10:76:85:64:BA','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:34',NULL,'2026-09-10 04:11:11','2026-09-23 19:45:38',NULL),(716,NULL,NULL,'48:83:B4:4B:9A:D3','1452',1,'1M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(717,NULL,NULL,'54:0E:58:74:B5:51','1452',1,'560 KB','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(718,NULL,NULL,'00:E0:4C:7E:6B:08','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(719,NULL,NULL,'00:01:36:91:50:E9','1452',1,'6M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(720,NULL,NULL,'00:E0:4C:8A:02:FE','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(721,NULL,NULL,'10:5A:95:22:9B:DD','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(722,NULL,NULL,'08:10:76:FA:AB:03','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(723,NULL,NULL,'1C:AB:32:05:3D:92','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(724,NULL,NULL,'00:E0:4C:B6:D0:D7','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(725,NULL,NULL,'00:E0:4C:B2:23:0D','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(726,NULL,NULL,'5C:16:48:FB:60:B3','1452',1,'560 KB','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(727,NULL,NULL,'02:27:22:9E:76:F0','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(728,NULL,NULL,'00:E0:4C:B0:89:15','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(729,NULL,NULL,'B8:3A:08:19:52:C0','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(730,NULL,NULL,'B8:3A:08:19:55:30','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(731,NULL,NULL,'00:E0:4C:89:D1:6F','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(732,NULL,NULL,'00:E0:4C:B5:56:B7','1452',1,'3M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(733,NULL,NULL,'24:A4:3C:01:02:71','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(734,NULL,NULL,'B4:F5:8E:BC:6B:F5','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(735,NULL,NULL,'76:09:53:6A:75:50','1452',1,'15 M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(736,NULL,NULL,'90:0A:00:0B:AF:23','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(737,NULL,NULL,'00:E0:4C:92:46:82','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(738,NULL,NULL,'00:E0:4C:BA:03:18','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 04:11:14','2026-09-23 19:45:38',NULL),(739,NULL,NULL,'90:0A:00:0A:71:A7','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-10 19:00:31','2026-09-23 19:45:38',NULL),(740,NULL,NULL,'00:E0:4C:BB:E7:C4','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:37',NULL,'2026-09-12 15:41:13','2026-09-23 19:45:38',NULL),(741,NULL,NULL,'00:E0:4C:AF:7E:3C','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-09-13 19:21:16','2026-09-23 19:45:38',NULL),(742,NULL,NULL,'00:E0:4C:B2:8D:90','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:38',NULL,'2026-09-15 18:41:48','2026-09-23 19:45:38',NULL),(743,NULL,NULL,'00:E0:4C:B5:5C:3E','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:38',NULL,'2026-09-16 15:31:04','2026-09-23 19:45:38',NULL),(744,NULL,NULL,'90:0A:00:0A:5C:AD','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:38',NULL,'2026-09-16 15:31:04','2026-09-23 19:45:38',NULL),(745,NULL,NULL,'00:E0:4C:B0:C9:41','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:38',NULL,'2026-09-18 20:40:33','2026-09-23 19:45:38',NULL),(746,NULL,NULL,'7E:8D:1C:BF:29:BC','1452',1,'1M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:31',NULL,'2026-09-18 20:40:34','2026-09-23 19:45:38',NULL),(747,NULL,NULL,'00:E0:4C:B8:49:40','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:38',NULL,'2026-09-18 20:40:42','2026-09-23 19:45:38',NULL),(748,NULL,NULL,'00:E0:4C:B0:C9:42','1452',1,'2M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-22 11:11:11',NULL,'2026-09-21 15:36:21','2026-09-23 19:45:38',NULL),(749,NULL,NULL,'00:E0:4B:EE:28:AA','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-21 16:40:34',NULL,'2026-09-21 16:30:37','2026-09-23 19:45:38',NULL),(750,NULL,NULL,'00:E0:4C:B2:8D:02','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:38',NULL,'2026-09-21 16:46:01','2026-09-23 19:45:38',NULL),(751,NULL,NULL,'B8:3A:08:22:D9:D7','1452',1,'5M','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:38',NULL,'2026-09-22 20:21:26','2026-09-23 19:45:38',NULL),(752,NULL,NULL,'00:30:0D:BE:FC:67','1452',1,'default','disabled',0,'0',0,0,NULL,NULL,NULL,'2026-09-23 19:45:38',NULL,'2026-09-23 19:00:30','2026-09-23 19:45:38',NULL);
/*!40000 ALTER TABLE `hotspot_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventories`
--

DROP TABLE IF EXISTS `inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `device_type` enum('onu','router','mikrotik','switch','olt') COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `minimum_quantity` int NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventories_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `inventories_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventories`
--

LOCK TABLES `inventories` WRITE;
/*!40000 ALTER TABLE `inventories` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `subscription_id` bigint unsigned NOT NULL,
  `hotspot_subscription_id` bigint unsigned DEFAULT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `renewal_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','paid','overdue','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  UNIQUE KEY `invoices_renewal_key_unique` (`renewal_key`),
  KEY `invoices_tenant_id_foreign` (`tenant_id`),
  KEY `invoices_customer_id_foreign` (`customer_id`),
  KEY `invoices_subscription_id_foreign` (`subscription_id`),
  KEY `invoices_hotspot_subscription_id_foreign` (`hotspot_subscription_id`),
  CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_hotspot_subscription_id_foreign` FOREIGN KEY (`hotspot_subscription_id`) REFERENCES `hotspot_subscriptions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `invoices_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,12,12,3,NULL,'INV-88171',NULL,105.00,'2026-09-16',NULL,'pending','Pariatur architecto non possimus ducimus et deleniti.','2026-08-16 17:14:06','2026-08-16 17:14:06'),(2,20,14,4,NULL,'INV-54627',NULL,800.00,'2026-09-17',NULL,'pending','Excepturi fugit quia et.','2026-08-17 15:53:53','2026-08-17 15:53:53'),(3,83,36,10,NULL,'INV-000003','queue-probe-001',350.00,'2026-10-03',NULL,'pending',NULL,'2026-09-03 19:19:35','2026-09-03 19:19:36'),(4,1,1,1,NULL,'INV-000004','queue-probe-002',100.00,'2026-08-14',NULL,'pending',NULL,'2026-09-03 19:20:47','2026-09-03 19:20:47');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_entries`
--

DROP TABLE IF EXISTS `journal_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journal_entries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `entry_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_date` date NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','posted','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `posted_at` timestamp NULL DEFAULT NULL,
  `posted_by` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `journal_entries_tenant_entry_number_unique` (`tenant_id`,`entry_number`),
  KEY `journal_entries_created_by_foreign` (`created_by`),
  KEY `journal_entries_approved_by_foreign` (`approved_by`),
  KEY `journal_entries_tenant_id_index` (`tenant_id`),
  KEY `journal_entries_entry_date_index` (`entry_date`),
  KEY `journal_entries_status_index` (`status`),
  KEY `journal_entries_posted_by_foreign` (`posted_by`),
  CONSTRAINT `journal_entries_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `journal_entries_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `journal_entries_posted_by_foreign` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `journal_entries_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_entries`
--

LOCK TABLES `journal_entries` WRITE;
/*!40000 ALTER TABLE `journal_entries` DISABLE KEYS */;
INSERT INTO `journal_entries` VALUES (1,1,'JE-TEST-001','2026-07-15','EVENTBUS-TEST','EgyptNet EventBus Integration Test','posted','2026-07-15 14:30:48',NULL,1,NULL,NULL,'2026-07-15 14:30:08','2026-07-15 14:30:48');
/*!40000 ALTER TABLE `journal_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_entry_lines`
--

DROP TABLE IF EXISTS `journal_entry_lines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journal_entry_lines` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `journal_entry_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `credit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `journal_entry_lines_journal_entry_id_foreign` (`journal_entry_id`),
  KEY `journal_entry_lines_account_id_index` (`account_id`),
  CONSTRAINT `journal_entry_lines_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `journal_entry_lines_journal_entry_id_foreign` FOREIGN KEY (`journal_entry_id`) REFERENCES `journal_entries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_entry_lines`
--

LOCK TABLES `journal_entry_lines` WRITE;
/*!40000 ALTER TABLE `journal_entry_lines` DISABLE KEYS */;
INSERT INTO `journal_entry_lines` VALUES (1,1,2,'Cash received',100.00,0.00,'2026-07-15 14:30:15','2026-07-15 14:30:15'),(2,1,9,'Subscription income',0.00,100.00,'2026-07-15 14:30:19','2026-07-15 14:30:19');
/*!40000 ALTER TABLE `journal_entry_lines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_26_022945_create_permission_tables',1),(5,'2026_06_26_023438_create_personal_access_tokens_table',1),(6,'2026_06_26_023500_create_activity_log_table',1),(7,'2026_06_26_023549_create_tenants_table',1),(8,'2026_06_26_024040_add_tenant_id_to_users_table',1),(9,'2026_06_26_094501_add_fields_to_tenants_table',1),(10,'2026_06_26_135105_create_customers_table',1),(11,'2026_06_26_145651_create_packages_table',1),(12,'2026_06_26_154023_create_subscriptions_table',1),(13,'2026_06_26_155824_create_invoices_table',1),(14,'2026_06_26_161414_create_payments_table',1),(15,'2026_06_26_184647_create_tickets_table',1),(16,'2026_06_26_190003_create_devices_table',1),(17,'2026_06_26_191138_create_inventories_table',1),(18,'2026_06_26_192649_create_device_assignments_table',1),(19,'2026_06_27_080118_add_mikrotik_fields_to_subscriptions_table',1),(20,'2026_06_27_124106_create_hotspot_subscriptions_table',1),(21,'2026_06_27_155421_add_mikrotik_profile_to_packages_table',1),(22,'2026_06_27_191556_add_hotspot_subscription_id_to_invoices_table',1),(23,'2026_06_28_063007_add_wallet_balance_to_subscriptions_tables',1),(24,'2026_06_28_195325_alter_payment_method_enum_on_payments_table',1),(25,'2026_06_28_203358_create_notifications_table',1),(26,'2026_06_28_203939_add_reminder_day_to_notifications_table',1),(27,'2026_06_28_213310_add_subscription_id_to_notifications_table',1),(28,'2026_06_28_220751_create_activity_logs_table',1),(29,'2026_06_29_073305_add_auth_fields_to_customers_table',1),(30,'2026_06_29_092030_create_wallet_transactions_table',1),(31,'2026_06_29_131730_create_ticket_replies_table',1),(32,'2026_07_03_202959_add_billing_fields_to_packages_table',1),(33,'2026_07_07_124200_create_network_devices_table',1),(34,'2026_07_07_131516_create_pppoe_users_table',1),(35,'2026_07_07_132058_add_username_to_customers_table',1),(36,'2026_07_07_133156_create_hotspot_users_table',1),(37,'2026_07_07_140818_fix_hotspot_profile_encoding',1),(38,'2026_07_07_171730_change_uptime_column_type',1),(39,'2026_07_07_173600_modify_hotspot_profile_length',1),(40,'2026_07_07_192610_add_tenant_id_to_network_tables',1),(41,'2026_07_08_101912_add_session_expiry_to_hotspot_users',1),(42,'2026_07_08_101912_create_accounts_table',1),(43,'2026_07_08_223702_create_journal_entries_table',1),(44,'2026_07_08_223758_create_journal_entry_lines_table',1),(45,'2026_07_09_000001_create_tasks_table',1),(46,'2026_07_09_180938_create_reports_table',1),(47,'2026_07_09_180959_create_report_exports_table',1),(48,'2026_07_09_181014_create_scheduled_reports_table',1),(49,'2026_07_10_095801_create_usage_snapshots_table',1),(50,'2026_07_10_180701_add_posting_fields_to_journal_entries_table',2),(51,'2026_07_13_200433_add_renewal_key_to_invoices_table',3),(52,'2026_07_19_225800_make_invoice_number_nullable',4),(53,'2026_08_18_000001_create_wallets_table',5),(54,'2026_08_19_000002_remove_legacy_wallet_balance_columns',6),(55,'2026_08_24_000001_add_grace_dates_to_subscriptions_table',7),(56,'2026_08_24_000002_align_subscription_status_enum',8),(57,'2026_09_06_185003_change_journal_entry_number_unique_constraint',9),(58,'2026_09_09_000001_create_accounting_periods_table',10);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
INSERT INTO `model_has_permissions` VALUES (1,'App\\Models\\User',10),(1,'App\\Models\\User',11);
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(1,'App\\Models\\User',10),(1,'App\\Models\\User',11),(7,'App\\Models\\User',17),(7,'App\\Models\\User',18);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `network_devices`
--

DROP TABLE IF EXISTS `network_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_devices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mikrotik',
  `port` int NOT NULL DEFAULT '8728',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `last_ping_at` timestamp NULL DEFAULT NULL,
  `last_sync_at` timestamp NULL DEFAULT NULL,
  `last_error` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `network_devices_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `network_devices_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_devices`
--

LOCK TABLES `network_devices` WRITE;
/*!40000 ALTER TABLE `network_devices` DISABLE KEYS */;
INSERT INTO `network_devices` VALUES (1,NULL,'MikroTik Router 1','2.2.2.2','hegazy','Gedo2010','mikrotik',8728,'active',1,'2026-09-23 18:36:35','2026-09-23 19:45:54',NULL,NULL,'2026-07-10 20:43:03','2026-09-23 19:45:54',NULL);
/*!40000 ALTER TABLE `network_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `subscription_id` bigint unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reminder_day` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_tenant_id_foreign` (`tenant_id`),
  KEY `notifications_customer_id_foreign` (`customer_id`),
  KEY `notifications_subscription_id_foreign` (`subscription_id`),
  CONSTRAINT `notifications_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifications_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifications_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `download_speed` int NOT NULL,
  `upload_speed` int NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `billing_cycle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'month',
  `billing_interval` smallint unsigned NOT NULL DEFAULT '1',
  `grace_days` smallint unsigned NOT NULL DEFAULT '0',
  `auto_suspend` tinyint(1) NOT NULL DEFAULT '1',
  `auto_expire` tinyint(1) NOT NULL DEFAULT '1',
  `quota_gb` int DEFAULT NULL,
  `mikrotik_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `packages_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `packages_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

LOCK TABLES `packages` WRITE;
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` VALUES (1,1,'╪ذ╪د┘é╪ر ╪ز╪ش╪▒┘è╪ذ┘è╪ر 100 ╪ش┘è╪ش╪د',10,5,100.00,'month',1,0,1,1,100,NULL,'active',NULL,'2026-07-12 07:30:32','2026-07-12 07:30:32'),(2,10,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Nihil culpa et aut aut et non assumenda.','2026-08-16 16:21:27','2026-08-16 16:21:27'),(3,16,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Eos non aliquam facere est aut.','2026-08-16 17:14:06','2026-08-16 17:14:06'),(4,24,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Magnam nostrum quas necessitatibus aut et sapiente et.','2026-08-17 15:53:53','2026-08-17 15:53:53'),(5,27,'Home 30M',30,10,100.00,'month',1,0,1,1,500,'default','active','Ea aut velit temporibus voluptates veniam.','2026-08-19 19:55:50','2026-08-19 19:55:50'),(6,30,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Iure aliquam a itaque modi.','2026-08-24 17:48:13','2026-08-24 17:48:13'),(7,33,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Quaerat sapiente modi culpa quia.','2026-08-24 17:56:52','2026-08-24 17:56:52'),(8,40,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Aut tenetur commodi nulla maxime natus ut.','2026-08-28 13:12:16','2026-08-28 13:12:16'),(9,43,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Pariatur quia rerum dolorem culpa suscipit facere soluta.','2026-08-28 13:19:34','2026-08-28 13:19:34'),(10,46,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Culpa laborum consequatur velit.','2026-08-29 20:28:17','2026-08-29 20:28:17'),(11,49,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Incidunt aliquam molestiae dolor aut explicabo ab est.','2026-08-29 20:30:26','2026-08-29 20:30:26'),(12,52,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Accusamus quia aliquam adipisci quia autem.','2026-08-29 20:34:54','2026-08-29 20:34:54'),(13,55,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Sed sit facilis voluptatum iusto non.','2026-08-29 20:37:58','2026-08-29 20:37:58'),(14,58,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Dolorem consequatur sit beatae sapiente.','2026-08-29 20:40:54','2026-08-29 20:40:54'),(15,61,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Pariatur corrupti magnam molestias vero voluptatem.','2026-08-29 20:43:38','2026-08-29 20:43:38'),(16,64,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Quisquam nesciunt voluptates facilis natus sunt et.','2026-08-29 20:47:43','2026-08-29 20:47:43'),(17,67,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Quis expedita tempore cupiditate.','2026-08-29 20:50:41','2026-08-29 20:50:41'),(18,70,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Laboriosam perferendis itaque fugiat quibusdam.','2026-08-29 20:54:55','2026-08-29 20:54:55'),(19,73,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Ea consequuntur autem ullam laudantium.','2026-08-29 20:57:34','2026-08-29 20:57:34'),(20,85,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Autem ut beatae et laboriosam.','2026-09-03 19:19:35','2026-09-03 19:19:35'),(21,90,'Home 30M',30,10,350.00,'month',1,0,1,1,500,'default','active','Quam deserunt quae commodi nesciunt facere sed ut.','2026-09-17 21:07:03','2026-09-17 21:07:03');
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `invoice_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` enum('cash','bank_transfer','vodafone_cash','instapay','card','wallet') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_tenant_id_foreign` (`tenant_id`),
  KEY `payments_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'tickets.update','web','2026-08-31 15:50:53','2026-08-31 15:50:53'),(2,'dashboard.view','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(3,'dashboard.statistics','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(4,'users.view','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(5,'users.create','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(6,'users.update','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(7,'users.delete','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(8,'tenants.view','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(9,'tenants.create','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(10,'tenants.update','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(11,'tenants.delete','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(12,'customers.view','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(13,'customers.create','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(14,'customers.update','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(15,'customers.delete','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(16,'activity.view','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(17,'packages.view','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(18,'packages.create','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(19,'packages.update','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(20,'packages.delete','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(21,'subscriptions.view','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(22,'subscriptions.create','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(23,'subscriptions.update','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(24,'subscriptions.delete','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(25,'subscriptions.activate','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(26,'subscriptions.suspend','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(27,'subscriptions.renew','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(28,'subscriptions.restore','web','2026-09-12 18:00:36','2026-09-12 18:00:36'),(29,'subscriptions.expire','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(30,'subscriptions.cancel','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(31,'subscriptions.link_pppoe','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(32,'hotspot.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(33,'hotspot.create','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(34,'hotspot.update','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(35,'hotspot.delete','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(36,'hotspot.activate','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(37,'hotspot.suspend','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(38,'invoices.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(39,'invoices.create','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(40,'invoices.update','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(41,'invoices.delete','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(42,'payments.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(43,'payments.create','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(44,'wallet.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(45,'wallet.deposit','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(46,'wallet.withdraw','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(47,'wallet.transactions','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(48,'notifications.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(49,'notifications.create','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(50,'notifications.delete','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(51,'notifications.read','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(52,'reports.dashboard','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(53,'reports.revenue','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(54,'reports.inventory','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(55,'reports.invoices','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(56,'reports.tickets','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(57,'tickets.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(58,'tickets.create','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(59,'tickets.delete','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(60,'tickets.reply','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(61,'tickets.assign','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(62,'tickets.change_status','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(63,'inventory.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(64,'inventory.create','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(65,'inventory.update','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(66,'inventory.delete','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(67,'devices.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(68,'devices.create','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(69,'devices.update','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(70,'devices.delete','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(71,'device_assignments.create','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(72,'device_assignments.return','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(73,'mikrotik.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(74,'mikrotik.pppoe.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(75,'mikrotik.pppoe.create','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(76,'mikrotik.pppoe.update','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(77,'mikrotik.pppoe.delete','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(78,'mikrotik.hotspot.view','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(79,'mikrotik.hotspot.create','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(80,'mikrotik.hotspot.update','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(81,'mikrotik.hotspot.delete','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(82,'scheduled_reports.view','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(83,'scheduled_reports.create','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(84,'scheduled_reports.update','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(85,'scheduled_reports.delete','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(86,'scheduled_reports.activate','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(87,'scheduled_reports.deactivate','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(88,'queue.view','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(89,'queue.create','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(90,'queue.update','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(91,'queue.delete','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(92,'queue.toggle','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(93,'firewall.view','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(94,'firewall.create','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(95,'firewall.update','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(96,'firewall.delete','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(97,'dhcp.view','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(98,'dhcp.create','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(99,'dhcp.update','web','2026-09-16 20:50:25','2026-09-16 20:50:25'),(100,'dhcp.delete','web','2026-09-16 20:50:25','2026-09-16 20:50:25');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pppoe_users`
--

DROP TABLE IF EXISTS `pppoe_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pppoe_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mikrotik_device_id` bigint unsigned DEFAULT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','disabled','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_sync_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pppoe_users_username_unique` (`username`),
  KEY `pppoe_users_customer_id_foreign` (`customer_id`),
  KEY `pppoe_users_mikrotik_device_id_foreign` (`mikrotik_device_id`),
  KEY `pppoe_users_username_index` (`username`),
  KEY `pppoe_users_status_index` (`status`),
  KEY `pppoe_users_is_online_index` (`is_online`),
  KEY `pppoe_users_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `pppoe_users_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pppoe_users_mikrotik_device_id_foreign` FOREIGN KEY (`mikrotik_device_id`) REFERENCES `network_devices` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pppoe_users_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pppoe_users`
--

LOCK TABLES `pppoe_users` WRITE;
/*!40000 ALTER TABLE `pppoe_users` DISABLE KEYS */;
INSERT INTO `pppoe_users` VALUES (1,NULL,NULL,'ppp1','123',1,'default',NULL,'disabled',0,NULL,'2026-09-23 19:45:54',NULL,'2026-09-10 04:11:25','2026-09-23 19:45:54',NULL),(2,NULL,NULL,'customer1','123456',1,'default',NULL,'disabled',0,NULL,'2026-09-23 19:45:54',NULL,'2026-09-10 04:11:25','2026-09-23 19:45:54',NULL),(3,NULL,NULL,'ppp2','999',1,'default',NULL,'disabled',0,NULL,'2026-09-23 19:45:54',NULL,'2026-09-10 04:11:25','2026-09-23 19:45:54',NULL);
/*!40000 ALTER TABLE `pppoe_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_exports`
--

DROP TABLE IF EXISTS `report_exports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_exports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `report_id` bigint unsigned NOT NULL,
  `format` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint unsigned NOT NULL DEFAULT '0',
  `exported_by` bigint unsigned DEFAULT NULL,
  `exported_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_exports_report_id_foreign` (`report_id`),
  KEY `report_exports_exported_by_foreign` (`exported_by`),
  KEY `report_exports_format_index` (`format`),
  KEY `report_exports_exported_at_index` (`exported_at`),
  CONSTRAINT `report_exports_exported_by_foreign` FOREIGN KEY (`exported_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `report_exports_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_exports`
--

LOCK TABLES `report_exports` WRITE;
/*!40000 ALTER TABLE `report_exports` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_exports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `filters` json DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `generated_by` bigint unsigned DEFAULT NULL,
  `generated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_generated_by_foreign` (`generated_by`),
  KEY `reports_name_index` (`name`),
  KEY `reports_type_index` (`type`),
  KEY `reports_status_index` (`status`),
  KEY `reports_generated_at_index` (`generated_at`),
  CONSTRAINT `reports_generated_by_foreign` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (1,'customers','Customers Report','manual','[]','completed',3,'2026-08-17 15:25:44','2026-08-17 15:25:45','2026-08-17 15:25:45'),(2,'customers','Customers Report','manual','[]','completed',5,'2026-08-17 15:29:01','2026-08-17 15:29:02','2026-08-17 15:29:02');
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,2),(23,2),(24,2),(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2),(33,2),(34,2),(35,2),(36,2),(37,2),(38,2),(39,2),(40,2),(41,2),(42,2),(43,2),(44,2),(45,2),(46,2),(47,2),(48,2),(49,2),(50,2),(51,2),(52,2),(53,2),(54,2),(55,2),(56,2),(57,2),(58,2),(59,2),(60,2),(61,2),(62,2),(63,2),(64,2),(65,2),(66,2),(67,2),(68,2),(69,2),(70,2),(71,2),(72,2),(73,2),(74,2),(75,2),(76,2),(77,2),(78,2),(79,2),(80,2),(81,2),(82,2),(83,2),(84,2),(85,2),(86,2),(87,2),(88,2),(89,2),(90,2),(91,2),(92,2),(93,2),(94,2),(95,2),(96,2),(97,2),(98,2),(99,2),(100,2),(2,3),(3,3),(12,3),(13,3),(14,3),(17,3),(18,3),(19,3),(21,3),(25,3),(26,3),(27,3),(52,3),(53,3),(54,3),(55,3),(57,3),(60,3),(63,3),(67,3),(82,3),(83,3),(84,3),(85,3),(86,3),(87,3),(12,4),(21,4),(38,4),(39,4),(42,4),(43,4),(44,4),(47,4),(52,4),(53,4),(55,4),(82,4),(12,5),(21,5),(48,5),(51,5),(57,5),(60,5),(62,5),(25,6),(26,6),(28,6),(63,6),(67,6),(69,6),(73,6),(74,6),(76,6),(78,6),(80,6);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','web','2026-08-31 15:50:53','2026-08-31 15:50:53'),(2,'Tenant Admin','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(3,'Manager','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(4,'Accountant','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(5,'Support','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(6,'Technician','web','2026-09-12 18:00:37','2026-09-12 18:00:37'),(7,'Customer','web','2026-09-12 18:00:37','2026-09-12 18:00:37');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduled_reports`
--

DROP TABLE IF EXISTS `scheduled_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scheduled_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'csv',
  `filters` json DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_run_at` timestamp NULL DEFAULT NULL,
  `next_run_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scheduled_reports_created_by_foreign` (`created_by`),
  KEY `scheduled_reports_report_name_index` (`report_name`),
  KEY `scheduled_reports_frequency_index` (`frequency`),
  KEY `scheduled_reports_is_active_index` (`is_active`),
  KEY `scheduled_reports_next_run_at_index` (`next_run_at`),
  CONSTRAINT `scheduled_reports_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduled_reports`
--

LOCK TABLES `scheduled_reports` WRITE;
/*!40000 ALTER TABLE `scheduled_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `scheduled_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('6jgkaR8W0yVVsabOa5gV9Fi52aJ3G211ruyMArCq',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJ2WExOMHhKYlhZN0JyYzRXa0QyZ1o5SUhZRFI0aFp3WEdkVjRXNXIyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9xdWV1ZXM/ZGV2aWNlX2lkPTEiLCJyb3V0ZSI6InF1ZXVlcy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1785705591),('ABOKdVUy3kwoFDRRF7iyDI9QmCgNB0C52pHm1I3D',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJ0RzZLMkhZNkRZTnpKbEFJR091bmdRRkI3c3dwNDlNbUhhRjZDc3NWIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784226588),('B4PNh5MU0XOy8AanPgs5USMWIVK8KDUfKCRLiDx4',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiI4ZThqWUtBMEJLZzlFY1J4TGRrVGxRaDNUVDZjVUhXSkNTOUdsSlRDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9maXJld2FsbD9kZXZpY2VfaWQ9MSIsInJvdXRlIjoiZmlyZXdhbGwuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784226586),('cmqUamOSModVvunLPg2h0ndUT4ySqIn832X1JD1B',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJqNmNBSE13M0kxUE5ucWhpU0FOU2hLY0V6MmdpWW5URlVPRHYwMXdwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9xdWV1ZXM/ZGV2aWNlX2lkPTEiLCJyb3V0ZSI6InF1ZXVlcy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1786909840),('hK10bPMtZA3tn9DYUfYlPki5wub1Le0zr8foMoVu',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJqczJTdlIxRjc0ODRlVU5panlENHNZREtDMDBhbHVHZ0xIbndFMDFPIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9maXJld2FsbD9kZXZpY2VfaWQ9MSIsInJvdXRlIjoiZmlyZXdhbGwuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784111841),('hyDAzQDK4LyKMluB8L4iV4EhiJgpFrrvEAAl74Lv',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJOMVlJRW1OVkl1MUhOdmJSTUJjUUlQOGpDNkFwWWV0MXJnTkh0aHR2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9xdWV1ZXM/ZGV2aWNlX2lkPTEiLCJyb3V0ZSI6InF1ZXVlcy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1785282606),('INYmBYyseghjWyfPJXIXuFgWeKNPRgrHpAZDovUh',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJHbkJFSll3SmhTeVBvMXA5SDZsdzZVQnFvNGpyYmRFWEo5NGlnWFlqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9maXJld2FsbD9kZXZpY2VfaWQ9MSIsInJvdXRlIjoiZmlyZXdhbGwuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1783718173),('Jt2PwNx21TDeXOvvqVGWCylv4qUiMVlNkYX6eKM6',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiI0REVidjVuRzdKZHFvcGphZ1Zaamxqb0FQdFk1ZW90M3YySXBDQXZ2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9kaGNwP2RldmljZV9pZD0xIiwicm91dGUiOiJkaGNwLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784111847),('LfMaMY1aLNDRNaiKdR7sLPBEbukdyrJ1j12Z7B8B',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJmSDd2Y0tzbHJ6em11UWhYdGRUMnhuYkV2OVBLS2dkanhybU1mTHBUIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9kaGNwP2RldmljZV9pZD0xIiwicm91dGUiOiJkaGNwLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784660775),('MP7jHqtsNulhb39t0ZCYLFlOCwlzbWJjOOlebn6S',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJuV0hDTFpicm1nQWtGd2VRSTRQNUtaR0g0VUZSTVAzRlk1blZFbUVBIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9xdWV1ZXM/ZGV2aWNlX2lkPTEiLCJyb3V0ZSI6InF1ZXVlcy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784111843),('oYqVJsA8n9UqlMJwqaxpKPHHKMMGJoQxEgbN08zY',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiIyMnVENjhrQ3JacWQycnJRbXBwSDBSZkRpREpkYW5xMWdtNFhYc2RUIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9kaGNwP2RldmljZV9pZD0xIiwicm91dGUiOiJkaGNwLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783759534),('PoaCKzDQw93zxj9GIPuIkdWCoIlxHSwaAjsZi5Qg',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJyMDlJZzh4bzlpS294cUplSlE2bTB6bkVadDZvaXZaRFFuSXJsWlRjIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9jdXN0b21lclwvbG9naW4iLCJyb3V0ZSI6ImN1c3RvbWVyLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783858223),('qS93ekQNgDS3CFzLuHkpUOBIKI4QmzZK6ufLAIwI',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJpMm1ENWN2SzlKdDRpUlVVamlmODV2UUJCMzRSWkY2YVdCREp5YmpsIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9kaGNwP2RldmljZV9pZD0xIiwicm91dGUiOiJkaGNwLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784226637),('rtd1RDQT7nKr8BrWb9ER9NZAq14BunjOf7UJOKsO',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiI3VEdmRjFlTE02ajdPQnNHbXB2czlSaDRHYUJXNjBRaFRoN2ZsM1N1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9maXJld2FsbD9kZXZpY2VfaWQ9MSIsInJvdXRlIjoiZmlyZXdhbGwuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1783759529),('VF7CaolIWb6Nu5Zg3zTZKHFnEob4RGxkl3J4kStt',NULL,'127.0.0.1','curl/8.14.1','eyJfdG9rZW4iOiJuR0VVTUJaZGpzUmlBYXlPMFJBSFhQZXNUZlRtcEFUM0M3ejZyM082IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kaGNwIiwicm91dGUiOiJkaGNwLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783711032),('vFMNeBh1IT70hEHjOausRpMAtzCgziGAoGeXv6qz',NULL,'127.0.0.1','Symfony','eyJfdG9rZW4iOiJFYm0xUHV5Y0t3dDRCVWRvSTRJdllyWTFYOWp5UHlsOWVpckdKcERQIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvcXVldWVzIiwicm91dGUiOiJxdWV1ZXMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1789591135),('vlmoOeWE4IMvqSvzEtxWEGGT8MmYLjYvrsrtIMFg',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJFNEFCNzZrbGtJZEUzWGlZdUFwVmw5T1FmSnBuNmtXcko5aWYxalpCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9jdXN0b21lclwvbG9naW4iLCJyb3V0ZSI6ImN1c3RvbWVyLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784226637),('vnEbwlHw73gPvGMS7ZxZTJSUbuE7uNxA2aXyT5ro',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJJUE1KOUt1emVpbldhcHdxRktHamJobDJ4WlN1bm03TlBBbHh3WnpQIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9xdWV1ZXM/ZGV2aWNlX2lkPTEiLCJyb3V0ZSI6InF1ZXVlcy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784660722),('X2GRn8PL6jdvRI8pMD47ozbEB3yJXersUOPdLlBe',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiJVYWJjRXAwQ3FWcHVDU0p5b1NpaTBjcXpkOWJWWkVibUk5RXpqemFHIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9xdWV1ZXM/ZGV2aWNlX2lkPTEiLCJyb3V0ZSI6InF1ZXVlcy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784226586),('YyQhhO8MMLWPq7llrqyPpnU06ZudB7PhtaT5lQ5Q',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0','eyJfdG9rZW4iOiI5TUxXbWp4R3ZsOUl0T3IwZHlUR3hrV0F0WW1HRDBLTmUwVzQ2bERlIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9xdWV1ZXM/ZGV2aWNlX2lkPTEiLCJyb3V0ZSI6InF1ZXVlcy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1783759529);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `package_id` bigint unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `grace_start_date` date DEFAULT NULL,
  `grace_end_date` date DEFAULT NULL,
  `monthly_price` decimal(10,2) NOT NULL,
  `status` enum('draft','pending','active','grace','suspended','expired','cancelled','terminated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `pppoe_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pppoe_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mikrotik_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_tenant_id_foreign` (`tenant_id`),
  KEY `subscriptions_customer_id_foreign` (`customer_id`),
  KEY `subscriptions_package_id_foreign` (`package_id`),
  CONSTRAINT `subscriptions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscriptions_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscriptions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (1,1,1,1,'2026-07-15','2026-08-14',NULL,NULL,100.00,'suspended',NULL,'test_user','123456','10M','2026-07-15 15:06:32','2026-07-15 15:49:56'),(2,8,11,2,'2026-08-16','2026-09-16','2026-09-23','2026-09-16',350.00,'grace','Similique aut deserunt quis consectetur sit nulla laudantium error.','estefania23','123456','default','2026-08-16 16:21:27','2026-09-23 00:11:02'),(3,14,13,3,'2026-08-16','2026-09-16','2026-09-23','2026-09-16',350.00,'grace','Molestiae sunt consequatur ullam adipisci soluta.','johara','123456','default','2026-08-16 17:14:06','2026-09-23 00:11:02'),(4,22,15,4,'2026-08-17','2026-09-17','2026-09-23','2026-09-17',350.00,'grace','Impedit quibusdam enim aliquam rem tenetur.','hudson.precious','123456','default','2026-08-17 15:53:53','2026-09-23 00:11:02'),(5,26,17,5,'2026-08-19','2026-09-19','2026-09-23','2026-09-19',100.00,'grace','Optio totam molestiae repudiandae neque necessitatibus sit.','mherman','123456','default','2026-08-19 19:55:50','2026-09-23 00:11:02'),(8,44,24,10,'2026-08-29','2026-09-08','2026-09-23','2026-09-08',350.00,'grace','Cumque rerum voluptatem impedit fuga rem pariatur.','dbrown','123456','default','2026-08-29 20:28:17','2026-09-23 00:11:02'),(9,47,25,11,'2026-08-29','2026-09-08','2026-09-23','2026-09-08',350.00,'grace','Autem non tenetur sequi voluptates cum.','geraldine.skiles','123456','default','2026-08-29 20:30:26','2026-09-23 00:11:02'),(10,83,36,20,'2026-09-03','2026-10-03',NULL,NULL,350.00,'active','Sed repellendus officiis et labore laboriosam autem.','claude.gutkowski','123456','default','2026-09-03 19:19:35','2026-09-03 19:19:35'),(11,89,37,21,'2026-09-17','2026-09-12',NULL,NULL,350.00,'expired','Ipsum unde amet ipsa sequi est nihil laborum velit.','tkrajcik','123456','default','2026-09-17 21:07:03','2026-09-17 21:07:03');
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `priority` enum('low','medium','high','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` enum('pending','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_tenant_id_foreign` (`tenant_id`),
  KEY `tasks_user_id_foreign` (`user_id`),
  CONSTRAINT `tasks_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,86,15,'Doloribus molestias natus saepe fugit.','Cupiditate rerum esse quidem vel quod. Dolorem saepe voluptatem officia adipisci rerum culpa sequi quas. Enim nisi perferendis maiores illo. Et officiis dolorem dolores doloribus. Voluptatem et alias doloribus.','high','pending',NULL,NULL,NULL,'[]','2026-09-15 20:55:44','2026-09-15 20:55:44'),(2,87,16,'Qui quia temporibus architecto enim.','Enim rem asperiores recusandae sed quos. Alias temporibus et voluptates sed quo fuga. Enim recusandae omnis et dolore repellat voluptate ea laudantium.','critical','pending',NULL,NULL,NULL,'[]','2026-09-15 20:55:44','2026-09-15 20:55:44');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,'2026-07-11 15:42:02','2026-07-11 15:42:02','EgyptTest',NULL,NULL,NULL,NULL,'active',NULL),(2,'2026-07-12 12:10:54','2026-07-12 12:10:54','╪د┘╪┤╪▒┘â╪ر ╪د┘╪▒╪خ┘è╪│┘è╪ر',NULL,NULL,NULL,'main.egyptnet.com','active',NULL),(3,'2026-07-12 12:12:34','2026-07-12 12:12:34','╪د┘╪┤╪▒┘â╪ر ╪د┘╪▒╪خ┘è╪│┘è╪ر',NULL,NULL,NULL,'main.egyptnet.com','active',NULL),(4,'2026-07-12 12:21:40','2026-07-12 12:21:40','╪د┘╪┤╪▒┘â╪ر ╪د┘╪▒╪خ┘è╪│┘è╪ر',NULL,NULL,NULL,'main.egyptnet.com','active',NULL),(5,'2026-08-16 13:27:58','2026-08-16 13:27:58','Bernier, Romaguera and Jacobi','emmitt17@hane.com','+1-352-647-0518','613 Alene Fords\nNew Ivyborough, TX 77171','strosin.com','active',NULL),(6,'2026-08-16 16:21:25','2026-08-16 16:21:25','Ernser and Sons','kohler.elmo@wyman.org','252-885-0810','48504 Roberta Orchard Apt. 842\nEast Stanleyhaven, IL 49595-1646','stracke.com','active',NULL),(7,'2026-08-16 16:21:26','2026-08-16 16:21:26','Wiza Group','corine.hartmann@osinski.net','520.291.0390','65223 Heidenreich Court Suite 790\nLake Blanchefurt, CO 93786','koch.com','active',NULL),(8,'2026-08-16 16:21:26','2026-08-16 16:21:26','Wolff-White','hartmann.kristoffer@skiles.com','+19709476981','52718 Jaylin Mountain\nLake Hilbertview, NV 17604-1282','hermann.net','active',NULL),(9,'2026-08-16 16:21:27','2026-08-16 16:21:27','Fahey-Hill','yklein@hamill.biz','1-520-694-2992','461 Elsie Mission\nEast Robertafort, VA 67780','beier.com','active',NULL),(10,'2026-08-16 16:21:27','2026-08-16 16:21:27','Cronin-Douglas','amelie53@hegmann.info','323-285-6294','11646 Kole Brook\nLake Jamir, AZ 34721-2524','witting.com','active',NULL),(11,'2026-08-16 17:14:05','2026-08-16 17:14:05','Friesen, Treutel and Schneider','boyle.albin@fritsch.com','1-530-538-9607','284 Wehner Heights\nEast Elishamouth, IN 48440-4548','zulauf.com','active',NULL),(12,'2026-08-16 17:14:05','2026-08-16 17:14:05','Johnston Inc','guy29@wunsch.com','+1-510-471-0209','2366 Krajcik Extensions\nLewburgh, MA 14707-8290','muller.net','active',NULL),(13,'2026-08-16 17:14:06','2026-08-16 17:14:06','Heller Ltd','qsanford@gibson.biz','(539) 769-6055','39370 Stuart Run Suite 278\nKilbackton, RI 44935-4390','parisian.com','active',NULL),(14,'2026-08-16 17:14:06','2026-08-16 17:14:06','Rosenbaum PLC','omosciski@windler.com','1-845-870-0532','950 Emanuel Shores Suite 032\nNorth Reymundoville, ID 98976','littel.org','active',NULL),(15,'2026-08-16 17:14:06','2026-08-16 17:14:06','Mitchell Inc','felton.kessler@bogisich.com','+1 (225) 969-8500','8181 Jarvis Glens\nNaderhaven, OK 45120-6293','cummings.org','active',NULL),(16,'2026-08-16 17:14:06','2026-08-16 17:14:06','Padberg, Krajcik and Schuster','ankunding.arvid@schmitt.com','+12703874106','8279 Miles Unions Apt. 700\nBarbaratown, NY 62079','goodwin.org','active',NULL),(17,'2026-08-17 15:41:53','2026-08-17 15:41:53','White-Jacobson','roger61@kemmer.com','458.868.7974','42946 Emiliano Lights Suite 084\nNew Tierra, NV 04781-4994','gerhold.com','active',NULL),(18,'2026-08-17 15:44:40','2026-08-17 15:44:40','Tremblay, Luettgen and Rohan','ankunding.ransom@lakin.info','253-666-8712','843 Billie Mill Suite 945\nNorth Gilda, ID 50702','will.com','active',NULL),(19,'2026-08-17 15:53:52','2026-08-17 15:53:52','Doyle Inc','kaylee.hessel@haag.com','323-295-5696','328 Rodriguez Islands\nNew Juana, MD 63209','herman.biz','active',NULL),(20,'2026-08-17 15:53:52','2026-08-17 15:53:52','Langosh-Block','brandt.windler@walker.org','540.659.6493','21994 Leonor Union\nRogeliofort, MI 77141-8794','cruickshank.org','active',NULL),(21,'2026-08-17 15:53:52','2026-08-17 15:53:52','Becker-Schuppe','aubrey.kihn@weimann.org','1-386-304-6697','64001 Jaskolski Drive\nLake Justice, HI 03926','dare.com','active',NULL),(22,'2026-08-17 15:53:53','2026-08-17 15:53:53','Bechtelar, Hoppe and Trantow','jenkins.keeley@zboncak.com','+13379826044','4354 Heber Garden\nNew May, NJ 61382-3355','wilderman.org','active',NULL),(23,'2026-08-17 15:53:53','2026-08-17 15:53:53','West-Haag','kohler.myrna@glover.com','(757) 746-3031','50807 Conroy Landing\nGreenholtburgh, MD 24969','ratke.com','active',NULL),(24,'2026-08-17 15:53:53','2026-08-17 15:53:53','Reichel-Klocko','elza.yundt@cole.info','+1-516-563-2051','270 Edwina Brooks\nLake Rosa, DC 53068','windler.com','active',NULL),(25,'2026-08-19 19:53:04','2026-08-19 19:53:04','Weber, Tremblay and McCullough','pswaniawski@wehner.biz','(610) 297-7740','80501 Mayert Neck Apt. 131\nSipesfort, OR 74298-9496','macejkovic.info','active',NULL),(26,'2026-08-19 19:55:50','2026-08-19 19:55:50','Langworth, Hodkiewicz and Baumbach','frath@bashirian.net','978.434.2254','79490 Baumbach Way\nSteuberborough, MI 80922-7758','doyle.biz','active',NULL),(27,'2026-08-19 19:55:50','2026-08-19 19:55:50','Cruickshank, Gerhold and Dicki','olesch@kunze.com','+15348871853','201 Halvorson Mills Suite 708\nWittington, NE 41909-7924','windler.org','active',NULL),(28,'2026-08-24 17:48:13','2026-08-24 17:48:13','Quitzon LLC','dean66@adams.info','820.257.3920','77194 Logan Islands Suite 453\nDestinmouth, OK 63245','abernathy.org','active',NULL),(29,'2026-08-24 17:48:13','2026-08-24 17:48:13','Collins Group','rmarvin@grant.biz','+17194495981','96526 Kassulke Flats\nEllsworthmouth, TX 59697-4265','wiegand.com','active',NULL),(30,'2026-08-24 17:48:13','2026-08-24 17:48:13','Boyle and Sons','wbeer@glover.info','+1-949-992-2428','200 Kamille Pass\nIvahside, OR 90965','daniel.net','active',NULL),(31,'2026-08-24 17:56:52','2026-08-24 17:56:52','Hahn, Quitzon and Kilback','heathcote.lenna@harvey.com','801.949.8109','15557 Ebert Via Suite 784\nNew Adrienne, IL 78317','collins.biz','active',NULL),(32,'2026-08-24 17:56:52','2026-08-24 17:56:52','Hauck-Murazik','dawson.williamson@jacobson.biz','+1-814-559-8851','12399 Tyson Knolls\nNorth Gillianfort, CA 73733','bosco.com','active',NULL),(33,'2026-08-24 17:56:52','2026-08-24 17:56:52','Langosh-Waters','jordyn.emard@mohr.com','872.606.7076','7464 Lauryn Way Apt. 981\nWest Camden, HI 12476','waelchi.net','active',NULL),(34,'2026-08-27 19:09:18','2026-08-27 19:09:18','Wilkinson Group','lwalker@carter.com','571.937.5649','6178 Zella Common Apt. 418\nReynoldsburgh, NV 99653','tillman.com','active',NULL),(35,'2026-08-27 19:09:18','2026-08-27 19:09:18','Ullrich-Huels','ybalistreri@zboncak.com','504.378.6101','10700 Nella Rapids Suite 088\nLionelstad, ME 70758-0360','kautzer.net','active',NULL),(36,'2026-08-27 19:09:18','2026-08-27 19:09:18','Lind-Spencer','weissnat.catharine@brekke.net','385.887.4426','22780 Allen Crossroad Suite 208\nJonesberg, NY 31417','windler.com','active',NULL),(37,'2026-08-27 19:09:18','2026-08-27 19:09:18','Lindgren Inc','cadams@rowe.com','+1-617-479-8098','983 Justine Field Apt. 732\nWest Deionberg, SD 31739-3781','hartmann.biz','active',NULL),(38,'2026-08-28 13:12:15','2026-08-28 13:12:15','Renner, Grimes and Welch','xfahey@feeney.com','(425) 508-3423','64505 Pfeffer Crossing Apt. 752\nWest Muhammadburgh, AK 07534','nader.com','active',NULL),(39,'2026-08-28 13:12:16','2026-08-28 13:12:16','Nikolaus PLC','wunsch.megane@barrows.com','1-862-564-8718','4735 Kane Extensions Apt. 299\nElvaview, CO 68738','white.info','active',NULL),(40,'2026-08-28 13:12:16','2026-08-28 13:12:16','Treutel-Howell','jessyca89@lowe.com','+1.725.248.4565','4936 Leta Square\nJenniestad, MO 19953','johnson.com','active',NULL),(41,'2026-08-28 13:19:33','2026-08-28 13:19:33','Raynor, Larson and Roob','dock.dubuque@west.org','+1.585.939.1066','25402 Cornelius Crescent\nPort Hector, MD 65465','kunze.com','active',NULL),(42,'2026-08-28 13:19:34','2026-08-28 13:19:34','Kling, Batz and Koelpin','kovacek.bernice@beahan.com','+14586600017','82383 Camron Fall\nLake Ardithland, FL 78083','wolf.com','active',NULL),(43,'2026-08-28 13:19:34','2026-08-28 13:19:34','Gerlach Group','amani.luettgen@jast.com','+1.620.940.9487','9205 Raymond Crossing Suite 582\nPort Brenden, MI 24569','walter.org','active',NULL),(44,'2026-08-29 20:28:16','2026-08-29 20:28:16','Bosco, Haag and Hahn','vledner@dickinson.net','+1 (510) 307-1675','40568 Kiehn Path\nPort Nikko, ND 48663-3104','ondricka.com','active',NULL),(45,'2026-08-29 20:28:17','2026-08-29 20:28:17','Hahn Inc','mcglynn.johnpaul@cremin.com','+1.661.449.1772','442 Mohammed Rue Apt. 564\nWest Ed, KS 23613','brakus.com','active',NULL),(46,'2026-08-29 20:28:17','2026-08-29 20:28:17','Ernser, Nader and Daniel','rebeca51@boyer.com','559.534.9525','879 Stephon Dale\nPort Lorenz, IA 52147-3918','watsica.biz','active',NULL),(47,'2026-08-29 20:30:26','2026-08-29 20:30:26','Altenwerth and Sons','olga09@hoppe.biz','(978) 209-6032','6158 Kautzer Heights\nPort Citlalli, TN 71861-2971','rutherford.org','active',NULL),(48,'2026-08-29 20:30:26','2026-08-29 20:30:26','Howe, Satterfield and Raynor','nschoen@hill.com','+1 (989) 662-8986','8332 Ernestine Row Apt. 176\nSengertown, LA 35142','walsh.info','active',NULL),(49,'2026-08-29 20:30:26','2026-08-29 20:30:26','Kuhn PLC','london71@grant.com','+19525977194','416 Blanda Summit\nWest Melisa, NV 75293-3791','funk.net','active',NULL),(50,'2026-08-29 20:34:54','2026-08-29 20:34:54','Pfannerstill Ltd','lindgren.ibrahim@ruecker.info','430-246-2425','8979 Magnus Greens Apt. 768\nCarterburgh, TN 52835','brakus.com','active',NULL),(51,'2026-08-29 20:34:54','2026-08-29 20:34:54','Littel-Marquardt','darby92@schumm.com','+16109263507','513 Mya Oval Suite 735\nLake Leilani, AR 33481','murphy.info','active',NULL),(52,'2026-08-29 20:34:54','2026-08-29 20:34:54','Bogan-Stoltenberg','hturner@damore.org','737.831.7640','72853 Lamont Plains\nDavinmouth, CA 39714','kshlerin.net','active',NULL),(53,'2026-08-29 20:37:58','2026-08-29 20:37:58','Kris Inc','tkiehn@windler.com','1-571-445-5839','22601 Margarette Orchard Apt. 246\nAlphonsochester, OK 95148-5173','yost.net','active',NULL),(54,'2026-08-29 20:37:58','2026-08-29 20:37:58','Rohan and Sons','kabshire@tillman.com','(504) 904-6088','7380 Lionel Square\nHailieville, SC 58320','jones.com','active',NULL),(55,'2026-08-29 20:37:58','2026-08-29 20:37:58','Tremblay LLC','carmen.hill@yost.com','(626) 318-9124','2397 Jordy Greens Apt. 641\nEast Rigobertotown, SD 09554-2374','bauch.com','active',NULL),(56,'2026-08-29 20:40:54','2026-08-29 20:40:54','Koch Group','retta.bechtelar@homenick.com','(573) 205-0648','6730 Lueilwitz Mountains\nSouth Rubye, CO 72593-9361','stark.com','active',NULL),(57,'2026-08-29 20:40:54','2026-08-29 20:40:54','Gutkowski-Herzog','stan.stroman@ohara.com','+18704712173','325 Saul Garden\nSouth Derickton, ID 34630-5641','douglas.net','active',NULL),(58,'2026-08-29 20:40:54','2026-08-29 20:40:54','Pacocha, VonRueden and Gerhold','mueller.aubrey@botsford.com','970.817.3583','255 Fleta Lodge\nMannport, MO 51165-7500','kulas.com','active',NULL),(59,'2026-08-29 20:43:38','2026-08-29 20:43:38','Cummings Group','oma26@corkery.info','(930) 616-4533','20268 Rahsaan Lights Suite 864\nWest Esmeralda, HI 28014','dicki.net','active',NULL),(60,'2026-08-29 20:43:38','2026-08-29 20:43:38','Marquardt-Bartell','owalker@lebsack.com','575.861.7394','518 Lesch Flats Suite 748\nSouth Delphine, ME 00777-0323','swaniawski.com','active',NULL),(61,'2026-08-29 20:43:38','2026-08-29 20:43:38','Mayert, Sipes and Grady','jasper.white@berge.com','1-385-583-4794','568 Russel Prairie Apt. 601\nSouth Glennie, ND 72648','schaefer.biz','active',NULL),(62,'2026-08-29 20:47:42','2026-08-29 20:47:42','Cummerata-Shields','ehermiston@schowalter.com','+1-857-426-9267','4275 Danyka Green\nReichertberg, MA 03734-1163','keebler.org','active',NULL),(63,'2026-08-29 20:47:43','2026-08-29 20:47:43','Kulas, Hartmann and Lind','bschmidt@beier.biz','+1-463-467-1634','952 Kyra Expressway Apt. 027\nNorth Yeseniachester, MD 62744','rolfson.net','active',NULL),(64,'2026-08-29 20:47:43','2026-08-29 20:47:43','Schultz, Bogisich and McGlynn','fkessler@sanford.biz','1-346-367-0339','7136 Turner Port\nElbertview, MO 67339-0989','mcdermott.biz','active',NULL),(65,'2026-08-29 20:50:40','2026-08-29 20:50:40','Pfannerstill-Cartwright','elvie13@schaefer.com','1-380-581-9795','6937 Windler Drive\nRusselton, VT 48149-9677','mante.com','active',NULL),(66,'2026-08-29 20:50:41','2026-08-29 20:50:41','Hayes, Stamm and Witting','webster61@hauck.com','409.356.3839','7574 Lakin Divide\nPagacfort, IN 45368-1344','gibson.net','active',NULL),(67,'2026-08-29 20:50:41','2026-08-29 20:50:41','Smitham Ltd','oma41@corkery.net','740.202.5384','911 Noble Cliffs\nNew Javonteland, ID 77817','trantow.net','active',NULL),(68,'2026-08-29 20:54:55','2026-08-29 20:54:55','Runolfsson and Sons','wolf.magdalena@ebert.com','(352) 388-0393','348 Carlie Union\nPfefferchester, AL 85659','oreilly.com','active',NULL),(69,'2026-08-29 20:54:55','2026-08-29 20:54:55','Nicolas PLC','bogan.osbaldo@schinner.com','1-215-210-2152','31437 Isobel Hills\nSouth Lukas, KS 09982-9946','thiel.org','active',NULL),(70,'2026-08-29 20:54:55','2026-08-29 20:54:55','Fay, West and Mohr','kailey63@heaney.com','660.500.1259','20595 Delmer Mountains\nRobertview, VA 16257','nicolas.com','active',NULL),(71,'2026-08-29 20:57:34','2026-08-29 20:57:34','Larson-Rolfson','schinner.vilma@streich.com','458.691.4155','8930 Homenick Knolls\nSouth Libby, VT 72544','treutel.biz','active',NULL),(72,'2026-08-29 20:57:34','2026-08-29 20:57:34','Johnson, Stokes and Gusikowski','mosciski.eda@botsford.com','(435) 717-2863','30021 Bins Brook\nKeshaunburgh, MN 63565-7603','conn.biz','active',NULL),(73,'2026-08-29 20:57:34','2026-08-29 20:57:34','Crona-Morar','norberto.harber@borer.org','678.357.6169','68177 German Islands\nEast Cassieside, DE 59112-6949','schmidt.org','active',NULL),(74,'2026-08-31 15:47:36','2026-08-31 15:47:36','Weimann-Steuber','mante.arielle@bins.com','+1 (817) 836-0041','898 Selina Cliff\nHodkiewiczchester, WV 85471','batz.info','active',NULL),(75,'2026-08-31 15:50:53','2026-08-31 15:50:53','Stiedemann-Turner','cronin.richie@howe.com','+1-401-759-4914','6465 Runolfsson Turnpike Suite 369\nTyrastad, NH 09708-0898','flatley.com','active',NULL),(76,'2026-08-31 15:50:54','2026-08-31 15:50:54','Hane and Sons','creola40@barrows.com','+12312977025','367 Watson Meadow\nEast Citlalli, KY 64463','armstrong.com','active',NULL),(77,'2026-08-31 15:52:02','2026-08-31 15:52:02','Jenkins-Raynor','kiehn.emmanuel@hartmann.com','1-435-819-8917','62071 Kunde Fork Suite 317\nNorth Williehaven, NJ 94172','cronin.info','active',NULL),(78,'2026-08-31 15:52:03','2026-08-31 15:52:03','Stark and Sons','gutmann.derrick@daugherty.org','(347) 963-0992','535 Barrows Overpass\nAltafort, MA 28928-9328','kozey.com','active',NULL),(79,'2026-08-31 17:01:56','2026-08-31 17:01:56','Toy, Nienow and Hermiston','osinski.emmalee@herzog.com','903.548.5913','59302 Kshlerin Hollow\nAylinburgh, AR 68182','rau.info','active',NULL),(80,'2026-08-31 17:46:10','2026-08-31 17:46:10','O\'Conner Inc','hoeger.jaylan@murphy.com','586-753-9586','30156 Zieme Field\nBartonfort, GA 05878-1340','armstrong.com','active',NULL),(81,'2026-08-31 17:46:10','2026-08-31 17:46:10','Predovic, Welch and Kessler','alec84@stehr.com','+1-872-678-9402','2110 Lakin Heights\nNew Gennaromouth, MD 59003-1585','watsica.com','active',NULL),(82,'2026-08-31 17:52:10','2026-08-31 17:52:10','Quitzon-Miller','little.concepcion@haag.com','267-680-1583','31005 Madge Vista\nPacochaburgh, AR 57799','nicolas.com','active',NULL),(83,'2026-09-03 19:19:35','2026-09-03 19:19:35','Wilkinson-Mante','gladyce00@koelpin.com','+1-640-394-8008','4879 Laurel Fall Suite 699\nWest Ben, LA 31424','huel.info','active',NULL),(84,'2026-09-03 19:19:35','2026-09-03 19:19:35','Beahan LLC','koch.frances@rempel.com','+1 (445) 375-0019','99558 Abdul Wall\nWest Alfonso, SD 73187-1102','dach.com','active',NULL),(85,'2026-09-03 19:19:35','2026-09-03 19:19:35','Purdy, Kuhlman and Corkery','williamson.janessa@baumbach.com','+13124892260','414 Reynolds Shoals Apt. 534\nNew Berthachester, NC 58375-1832','hackett.net','active',NULL),(86,'2026-09-15 20:55:42','2026-09-15 20:55:42','Crooks LLC','barrows.virginie@friesen.com','954.990.0651','886 Max Valley Suite 094\nNorth Sandratown, AK 06447','prosacco.net','active',NULL),(87,'2026-09-15 20:55:43','2026-09-15 20:55:43','West, Johnson and Hane','craig.leuschke@treutel.com','719-220-1580','2127 Ondricka Mountains Apt. 187\nWest Melissatown, ID 60129','grimes.info','active',NULL),(88,'2026-09-17 21:07:02','2026-09-17 21:07:02','Lockman Group','ysmith@jacobs.com','(870) 239-6555','825 Cayla Neck\nEast Audie, DC 58428-1553','huels.org','active',NULL),(89,'2026-09-17 21:07:02','2026-09-17 21:07:02','Bogisich, Abbott and Brekke','travis99@shields.biz','1-270-772-9004','95190 Kohler Extensions Suite 338\nLake Bradley, VA 26847-6204','spencer.com','active',NULL),(90,'2026-09-17 21:07:02','2026-09-17 21:07:02','Klocko-Lehner','harvey.taurean@purdy.biz','(267) 274-3611','8775 Robel Mills\nTreutelfort, SD 48253','dach.biz','active',NULL);
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_replies`
--

DROP TABLE IF EXISTS `ticket_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_replies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_staff` tinyint(1) NOT NULL DEFAULT '0',
  `sent_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_replies_ticket_id_foreign` (`ticket_id`),
  KEY `ticket_replies_customer_id_foreign` (`customer_id`),
  KEY `ticket_replies_user_id_foreign` (`user_id`),
  CONSTRAINT `ticket_replies_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ticket_replies_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_replies`
--

LOCK TABLES `ticket_replies` WRITE;
/*!40000 ALTER TABLE `ticket_replies` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ticket_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` enum('low','medium','high','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` enum('open','in_progress','resolved','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `opened_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tickets_ticket_number_unique` (`ticket_number`),
  KEY `tickets_tenant_id_foreign` (`tenant_id`),
  KEY `tickets_customer_id_foreign` (`customer_id`),
  KEY `tickets_user_id_foreign` (`user_id`),
  CONSTRAINT `tickets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tickets_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,36,21,NULL,'TKT-6340095431','Ut quod alias porro molestiae fugit sed.','Molestias et aut aut sit eos. Facere dolor praesentium et dignissimos. Repellat saepe facilis eos nihil sit sit.','high','open','2026-08-27 19:09:18',NULL,NULL,'2026-08-27 19:09:18','2026-08-27 19:09:18'),(2,75,34,NULL,'TKT-9281211168','Est blanditiis et corporis et quis.','Libero quia assumenda totam quia aperiam nihil voluptas sint. Tempore odit possimus et aut fugit. Ipsum fugiat est id voluptatem.','critical','open','2026-08-31 15:50:54',NULL,NULL,'2026-08-31 15:50:54','2026-08-31 15:50:54'),(3,77,35,NULL,'TKT-3386187187','Natus quisquam pariatur nemo magni aut.','Nihil molestias nisi soluta facilis nisi. Ut tenetur rem nihil nemo. Atque repellat vel nemo vero quas expedita fugiat. Fugit voluptas ut nobis nisi fuga temporibus debitis officia.','critical','open','2026-08-31 15:52:03',NULL,NULL,'2026-08-31 15:52:03','2026-08-31 15:52:03');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usage_snapshots`
--

DROP TABLE IF EXISTS `usage_snapshots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usage_snapshots` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `connection_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bytes_download` bigint unsigned NOT NULL DEFAULT '0',
  `bytes_upload` bigint unsigned NOT NULL DEFAULT '0',
  `recorded_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usage_snapshots_tenant_id_foreign` (`tenant_id`),
  KEY `usage_snapshots_customer_id_connection_type_recorded_at_index` (`customer_id`,`connection_type`,`recorded_at`),
  KEY `usage_snapshots_username_connection_type_recorded_at_index` (`username`,`connection_type`,`recorded_at`),
  CONSTRAINT `usage_snapshots_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `usage_snapshots_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usage_snapshots`
--

LOCK TABLES `usage_snapshots` WRITE;
/*!40000 ALTER TABLE `usage_snapshots` DISABLE KEYS */;
/*!40000 ALTER TABLE `usage_snapshots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `users_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Hegazy','hegazy@egyptnet.local',NULL,'$2y$12$rhskra36x3PM01gNOpN52u1SReYusVyVI9yht6aUnkZKRMUB1eCdW',NULL,'2026-07-11 15:47:06','2026-07-11 15:47:06'),(3,NULL,'Armani Jaskolski','delaney.walsh@example.net','2026-08-17 15:25:44','$2y$12$Ks1Xqh8z1Gc2K6/fSNYZQurdRvIxtZG898gmb6My3CgXXf.4kYYwS','YqJ11rf6RK','2026-08-17 15:25:45','2026-08-17 15:25:45'),(4,NULL,'Santiago Weissnat','muller.emmanuel@example.com','2026-08-17 15:25:45','$2y$12$Ks1Xqh8z1Gc2K6/fSNYZQurdRvIxtZG898gmb6My3CgXXf.4kYYwS','2FlSY3F3oS','2026-08-17 15:25:45','2026-08-17 15:25:45'),(5,NULL,'Annabelle Lynch','nauer@example.com','2026-08-17 15:29:01','$2y$12$JulftlQfOcrZISMZtwzovOc9ejflf/6ReSUko5hT36GAB099P8aG.','wio6EKElpT','2026-08-17 15:29:02','2026-08-17 15:29:02'),(6,NULL,'Dr. Boris Smith','charley.pacocha@example.com','2026-08-17 15:29:02','$2y$12$JulftlQfOcrZISMZtwzovOc9ejflf/6ReSUko5hT36GAB099P8aG.','q5FW86vSRF','2026-08-17 15:29:02','2026-08-17 15:29:02'),(7,NULL,'Dr. Issac Waelchi','dubuque.ludwig@example.com','2026-08-27 19:09:19','$2y$12$mXvdzvoHNHBa3h/9jYLcYO3b7dtAhjo6/ndqYta2FtYpZ8Yz8yFP6','Lla7sD0YYy','2026-08-27 19:09:19','2026-08-27 19:09:19'),(8,NULL,'Prof. Chester Fisher DVM','slesch@example.com','2026-08-31 15:47:09','$2y$12$GyPV5rjkXIJ1XkIxnbde3uYGlnfJuNEOu0y1TlNS1mpcd30Qa1wpa','AJq6bUs0Ma','2026-08-31 15:47:09','2026-08-31 15:47:09'),(9,74,'Mr. Jermain Roob','wnitzsche@example.net','2026-08-31 15:47:37','$2y$12$HYaD2.E1vKafMbXFQpO.yezV4w.d6xULhQ6fuha0A.nfNB.0h9IUy','dAt4sE66ea','2026-08-31 15:47:37','2026-08-31 15:47:37'),(10,75,'Jay Littel V','buck89@example.org','2026-08-31 15:50:54','$2y$12$p5Vbxww2fTGvG/J5klarRuUgB7vqDaWTTHkUWW0lA4k0LMx5HweHS','dZuUl9oelr','2026-08-31 15:50:54','2026-08-31 15:50:54'),(11,77,'Elfrieda Kihn','joaquin.padberg@example.org','2026-08-31 15:52:02','$2y$12$ZlcKJwYYKnqZlm2XywzkTenvBWIe4PuQuKWknetnAMnJioaYoX1ZG','u9OVXIviVU','2026-08-31 15:52:02','2026-08-31 15:52:02'),(12,79,'Mr. Esteban Skiles Sr.','yrippin@example.net','2026-08-31 17:01:56','$2y$12$YKhrnwqIPs3I52g3jVgLUOry2rxNWWQhfByia/IJIJG7gTICuiLj2','xEo7ZcYD7Q','2026-08-31 17:01:57','2026-08-31 17:01:57'),(13,80,'Christop Monahan','emmie32@example.com','2026-08-31 17:46:10','$2y$12$C3gohwxMma/.CFLw3qSOre/fOsvoID58.fcY6HGMvIFXc/BRW6NZm','fR3R6zjnEw','2026-08-31 17:46:11','2026-08-31 17:46:11'),(14,82,'Dr. Casper Kunde','brenna.zulauf@example.net','2026-08-31 17:52:11','$2y$12$WIxujlgHWwhvvgvkuwrVKOh0Gxkc3whv248EmnxcIgHonCNGKbbGe','KZgcfmKdLt','2026-08-31 17:52:11','2026-08-31 17:52:11'),(15,NULL,'Mrs. Myriam Jerde','orland.steuber@example.net','2026-09-15 20:55:43','$2y$12$jmWllkIaaRERK23YJ3Hufu8/OjfCSriNRcOdOSRNMA4iYCmjByxRe','hOEwKzTyGL','2026-09-15 20:55:43','2026-09-15 20:55:43'),(16,NULL,'Vivienne Kuvalis','kuvalis.nannie@example.net','2026-09-15 20:55:44','$2y$12$jmWllkIaaRERK23YJ3Hufu8/OjfCSriNRcOdOSRNMA4iYCmjByxRe','NAXeKRfUiQ','2026-09-15 20:55:44','2026-09-15 20:55:44'),(17,NULL,'Orpha Witting','tterry@example.org','2026-09-15 20:55:44','$2y$12$jmWllkIaaRERK23YJ3Hufu8/OjfCSriNRcOdOSRNMA4iYCmjByxRe','CyFrpzOUFP','2026-09-15 20:55:44','2026-09-15 20:55:44'),(18,NULL,'Miss Karli Koch','zboncak.tamara@example.net','2026-09-16 19:15:06','$2y$12$0yjWKNdowA6nhCFmcUjonOkw/PXXCjMFjBJriDfFqXPqZc7/2ZLku','iZ8Ek7JqKK','2026-09-16 19:15:07','2026-09-16 19:15:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_transactions`
--

DROP TABLE IF EXISTS `wallet_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `balance_before` decimal(10,2) NOT NULL,
  `balance_after` decimal(10,2) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet_transactions_tenant_id_foreign` (`tenant_id`),
  KEY `wallet_transactions_customer_id_foreign` (`customer_id`),
  CONSTRAINT `wallet_transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wallet_transactions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_transactions`
--

LOCK TABLES `wallet_transactions` WRITE;
/*!40000 ALTER TABLE `wallet_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallet_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallets_tenant_id_customer_id_unique` (`tenant_id`,`customer_id`),
  KEY `wallets_customer_id_foreign` (`customer_id`),
  CONSTRAINT `wallets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wallets_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallets`
--

LOCK TABLES `wallets` WRITE;
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;
INSERT INTO `wallets` VALUES (1,25,16,50.00,'2026-08-19 19:53:04','2026-08-19 19:53:05'),(2,26,17,50.00,'2026-08-19 19:55:50','2026-08-19 19:55:51');
/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'egyptnet'
--

--
-- Dumping routines for database 'egyptnet'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-23 19:49:13
