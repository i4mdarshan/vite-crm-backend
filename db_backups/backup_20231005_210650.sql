-- MariaDB dump 10.17  Distrib 10.4.14-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: crm_web_app_laravel_2
-- ------------------------------------------------------
-- Server version	10.4.14-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `announcement_title` varchar(255) DEFAULT NULL,
  `announcement_description` longtext DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `announcement_date` datetime DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcement`
--

LOCK TABLES `announcement` WRITE;
/*!40000 ALTER TABLE `announcement` DISABLE KEYS */;
INSERT INTO `announcement` VALUES (1,'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatum quidem eaque accusamus consectetur numquam, praesentium ratione dolorem eos similique eum nam corrupti totam reiciendis, ut veniam ex? Inventore, asperiores illo provident vero culpa rer','&lt;div style=&quot;text-align: center;&quot;&gt;&lt;b style=&quot;font-size: 36px;&quot;&gt;&lt;u&gt;Test Title&lt;/u&gt;&lt;/b&gt;&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;&lt;ul&gt;&lt;li style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;﻿List Sample 1&lt;/span&gt;&lt;/li&gt;&lt;li style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;List Sample 2&lt;/span&gt;&lt;/li&gt;&lt;li style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;List Sample 3&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;Simple Paragraph&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;font-size: 18px; background-color: rgb(255, 255, 0);&quot;&gt;&lt;font color=&quot;#000000&quot;&gt;Highlighted Text&lt;/font&gt;&lt;/span&gt;&lt;/p&gt;&lt;/div&gt;',NULL,NULL,'2022-03-16 00:00:00','2022-03-07 17:02:32','2022-03-24 20:02:35'),(2,'announcement 2','hello',NULL,NULL,'2022-03-16 22:31:58','2022-03-07 17:02:32','2022-03-07 17:02:32'),(6,'hjkss','&lt;p&gt;&lt;u&gt;fiuiuii&lt;b&gt;ssd&lt;/b&gt;&lt;/u&gt;&lt;/p&gt;',NULL,NULL,'2022-03-16 00:00:00','2022-03-09 06:03:07','2022-03-09 06:03:07'),(7,'fdsaa','&lt;p&gt;dseryyy&lt;/p&gt;',NULL,NULL,'2022-03-26 00:00:00','2022-03-09 06:03:20','2022-03-09 06:03:20'),(9,'hdraa','&lt;p&gt;adsd&lt;/p&gt;',NULL,NULL,'2022-03-29 00:00:00','2022-03-09 06:05:11','2022-03-09 06:05:11');
/*!40000 ALTER TABLE `announcement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_settings`
--

DROP TABLE IF EXISTS `app_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `billing_address` longtext NOT NULL,
  `tax_percent` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_settings`
--

LOCK TABLES `app_settings` WRITE;
/*!40000 ALTER TABLE `app_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collection`
--

DROP TABLE IF EXISTS `collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `mode_of_payment` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `collected_by_person_name` varchar(255) DEFAULT NULL,
  `collected_from_person_name` varchar(255) DEFAULT NULL,
  `money_received` varchar(255) DEFAULT NULL,
  `money_received_date` date DEFAULT NULL,
  `money_pending` varchar(255) DEFAULT NULL,
  `money_pending_date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `collection_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `collection_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collection`
--

LOCK TABLES `collection` WRITE;
/*!40000 ALTER TABLE `collection` DISABLE KEYS */;
INSERT INTO `collection` VALUES (10,1,35,'cash',NULL,'Darshan Mahajan','25','5000','2022-10-15','0',NULL,1,'2022-10-15 19:58:46','2022-10-15 20:10:18'),(11,1,35,'cash',NULL,'Darshan Mahajan','25','4000','2022-10-16','0',NULL,1,'2022-10-15 20:10:56','2022-10-15 20:10:56'),(12,1,35,'cash',NULL,'Darshan Mahajan','25','5000','2022-10-16','0',NULL,1,'2022-10-15 20:12:44','2022-10-15 20:14:26');
/*!40000 ALTER TABLE `collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaint_images`
--

DROP TABLE IF EXISTS `complaint_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaint_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `complaint_id` int(11) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `complaint_id` (`complaint_id`),
  CONSTRAINT `complaint_images_ibfk_1` FOREIGN KEY (`complaint_id`) REFERENCES `customer_lead_complaints` (`id`),
  CONSTRAINT `complaint_images_ibfk_2` FOREIGN KEY (`complaint_id`) REFERENCES `customer_lead_complaints` (`id`),
  CONSTRAINT `complaint_images_ibfk_3` FOREIGN KEY (`complaint_id`) REFERENCES `customer_lead_complaints` (`id`),
  CONSTRAINT `complaint_images_ibfk_4` FOREIGN KEY (`complaint_id`) REFERENCES `customer_lead_complaints` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaint_images`
--

LOCK TABLES `complaint_images` WRITE;
/*!40000 ALTER TABLE `complaint_images` DISABLE KEYS */;
INSERT INTO `complaint_images` VALUES (1,8,'Screenshot (210).png','2022-05-12 01:47:37','2022-05-12 13:47:37'),(2,8,'Screenshot (209).png','2022-05-12 01:47:37','2022-05-12 13:47:37'),(3,9,'16_19.jpg','2022-06-09 21:55:37','2022-06-10 09:55:37'),(4,9,'20220530_193951.jpg','2022-06-09 21:55:37','2022-06-10 09:55:37'),(7,10,'2022_08_23_02_18_40_20220530_193951.jpg','2022-08-22 20:48:40','2022-08-23 08:48:40');
/*!40000 ALTER TABLE `complaint_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaint_statuses`
--

DROP TABLE IF EXISTS `complaint_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaint_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaint_statuses`
--

LOCK TABLES `complaint_statuses` WRITE;
/*!40000 ALTER TABLE `complaint_statuses` DISABLE KEYS */;
INSERT INTO `complaint_statuses` VALUES (1,'in_progress','2022-03-27 10:00:09','2022-03-27 10:00:09'),(2,'awaiting_approval','2022-03-27 10:17:38','2022-03-27 10:17:38'),(3,'closed','2022-03-27 10:17:46','2022-03-27 10:17:46');
/*!40000 ALTER TABLE `complaint_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_lead_appointments`
--

DROP TABLE IF EXISTS `customer_lead_appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_lead_appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `appointment_date` datetime DEFAULT NULL,
  `appointment_time` varchar(255) NOT NULL,
  `appointment_with` varchar(255) DEFAULT NULL,
  `appointment_description` longtext DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  `isLead` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_lead_appointments_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `customer_lead_appointments_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_lead_appointments`
--

LOCK TABLES `customer_lead_appointments` WRITE;
/*!40000 ALTER TABLE `customer_lead_appointments` DISABLE KEYS */;
INSERT INTO `customer_lead_appointments` VALUES (11,1,19,'2022-06-10 00:00:00','12:45 PM','18','Order confirmations','2022-06-09 19:31:46','2022-06-09 19:31:46',0),(12,1,14,'2022-06-10 00:00:00','4:00 PM','21','Discuss quotations','2022-06-09 19:43:40','2022-06-09 19:43:40',1),(13,1,32,'2022-10-12 00:00:00','1:15 PM','24','Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consectetur nisi facere earum velit distinctio eos eum, tempora nulla sint explicabo quibusdam porro cupiditate nihil veritatis atque? Tempora nostrum eius dolores sequi saepe dolorem qui, nam doloribus. Nostrum fuga voluptates doloribus, temporibus autem eum tempora id dicta. Autem est ratione distinctio.','2022-10-09 03:44:09','2022-10-09 03:44:09',1),(14,1,19,'2022-10-12 00:00:00','2:00 PM','17','Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consectetur nisi facere earum velit distinctio eos eum, tempora nulla sint explicabo quibusdam porro cupiditate nihil veritatis atque? Tempora nostrum eius dolores sequi saepe dolorem qui, nam doloribus. Nostrum fuga voluptates doloribus, temporibus autem eum tempora id dicta. Autem est ratione distinctio.','2022-10-09 03:57:55','2022-10-09 03:57:55',0),(15,1,14,'2022-10-26 00:00:00','3:00 PM','21','Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, itaque eum reiciendis consequatur libero nesciunt! Voluptate id impedit eos atque sint accusamus culpa porro quibusdam quia aliquid consectetur molestias, eum temporibus beatae iste, fugiat saepe! Deserunt eos corrupti sint nobis molestiae? Impedit quibusdam nobis quos nam iste, molestias voluptate at, nisi deserunt nulla debitis consectetur voluptatem! Illo optio quos dolore ullam suscipit harum accusantium dolor beatae voluptatibus, sint quibusdam necessitatibus voluptate itaque? Tenetur, nulla veniam. Nostrum, tempora facere. Cupiditate commodi reprehenderit voluptate voluptas aliquam obcaecati molestiae, eos natus eveniet vitae pariatur, ipsum suscipit similique quam quae sapiente ea doloribus architecto.','2022-10-25 04:47:10','2022-10-25 04:47:10',1);
/*!40000 ALTER TABLE `customer_lead_appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_lead_behaviour`
--

DROP TABLE IF EXISTS `customer_lead_behaviour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_lead_behaviour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `nature` varchar(255) DEFAULT NULL,
  `order_contact` varchar(255) DEFAULT NULL,
  `payment_contact` varchar(255) DEFAULT NULL,
  `payment_condition` varchar(255) DEFAULT NULL,
  `order_followups_required` varchar(11) DEFAULT NULL,
  `payment_followups_required` varchar(11) DEFAULT NULL,
  `price_cross_checker` varchar(11) DEFAULT NULL,
  `payment_safety` varchar(11) DEFAULT NULL,
  `friendly` varchar(11) DEFAULT NULL,
  `soft_corner` varchar(255) DEFAULT NULL,
  `technical_helping` varchar(11) DEFAULT NULL,
  `educated` varchar(11) DEFAULT NULL,
  `brand_price_lover` varchar(11) DEFAULT NULL,
  `loyal` varchar(11) DEFAULT NULL,
  `years_for_generation` varchar(255) DEFAULT NULL,
  `trail_done_before` varchar(255) DEFAULT NULL,
  `another_business` varchar(11) DEFAULT NULL,
  `past_payment_defaulter` varchar(255) DEFAULT NULL,
  `duration_of_joining` varchar(255) DEFAULT NULL,
  `competitor_conn` varchar(255) DEFAULT NULL,
  `partnership` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_lead_behaviour_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_lead_behaviour`
--

LOCK TABLES `customer_lead_behaviour` WRITE;
/*!40000 ALTER TABLE `customer_lead_behaviour` DISABLE KEYS */;
INSERT INTO `customer_lead_behaviour` VALUES (6,20,'Rude',NULL,NULL,NULL,'yes','yes','yes',NULL,'yes',NULL,'no','yes',NULL,NULL,'3',NULL,NULL,NULL,'3 months',NULL,'Partnership','2022-06-10 06:29:26','2022-06-10 06:29:26'),(7,19,'Innocent',NULL,'Jay',NULL,NULL,'yes','yes',NULL,NULL,NULL,'yes','yes',NULL,'no','2',NULL,'yes',NULL,NULL,'5',NULL,'2022-06-10 06:35:06','2022-06-10 06:35:06');
/*!40000 ALTER TABLE `customer_lead_behaviour` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_lead_calls`
--

DROP TABLE IF EXISTS `customer_lead_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_lead_calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `call_date` date DEFAULT NULL,
  `call_time` varchar(255) DEFAULT NULL,
  `call_with` int(11) DEFAULT NULL,
  `call_description` longtext DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  `isLead` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_lead_calls_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `customer_lead_calls_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_lead_calls`
--

LOCK TABLES `customer_lead_calls` WRITE;
/*!40000 ALTER TABLE `customer_lead_calls` DISABLE KEYS */;
INSERT INTO `customer_lead_calls` VALUES (14,1,20,'2022-06-10','3:00 PM',19,'Order details where discussed','2022-06-09 21:52:21','2022-06-09 21:52:21',0),(15,1,21,'2022-07-02','11:00 AM',22,'Discussion on quotation','2022-07-02 06:02:40','2022-07-02 06:02:40',1),(16,1,32,'2022-10-06','4:30 PM',24,'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consectetur nisi facere earum velit distinctio eos eum, tempora nulla sint explicabo quibusdam porro cupiditate nihil veritatis atque? Tempora nostrum eius dolores sequi saepe dolorem qui, nam doloribus. Nostrum fuga voluptates doloribus, temporibus autem eum tempora id dicta. Autem est ratione distinctio.','2022-10-09 03:44:36','2022-10-09 03:44:36',1),(17,1,14,'2022-10-25','4:00 PM',21,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, itaque eum reiciendis consequatur libero nesciunt! Voluptate id impedit eos atque sint accusamus culpa porro quibusdam quia aliquid consectetur molestias, eum temporibus beatae iste, fugiat saepe! Deserunt eos corrupti sint nobis molestiae? Impedit quibusdam nobis quos nam iste, molestias voluptate at, nisi deserunt nulla debitis consectetur voluptatem! Illo optio quos dolore ullam suscipit harum accusantium dolor beatae voluptatibus, sint quibusdam necessitatibus voluptate itaque? Tenetur, nulla veniam. Nostrum, tempora facere. Cupiditate commodi reprehenderit voluptate voluptas aliquam obcaecati molestiae, eos natus eveniet vitae pariatur, ipsum suscipit similique quam quae sapiente ea doloribus architecto.','2022-10-25 04:47:45','2022-10-25 04:47:45',1);
/*!40000 ALTER TABLE `customer_lead_calls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_lead_complaint_status`
--

DROP TABLE IF EXISTS `customer_lead_complaint_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_lead_complaint_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `complaint_id` int(11) DEFAULT NULL,
  `complaint_status_id` int(11) DEFAULT NULL,
  `complaint_status_comments` longtext DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_lead_complaint_status`
--

LOCK TABLES `customer_lead_complaint_status` WRITE;
/*!40000 ALTER TABLE `customer_lead_complaint_status` DISABLE KEYS */;
INSERT INTO `customer_lead_complaint_status` VALUES (2,1,7,1,'This complaint is under review.','2022-05-12 00:54:30','2022-05-12 00:54:30'),(3,1,8,1,'This complaint is under review.','2022-05-12 01:47:37','2022-05-12 01:47:37'),(4,1,9,1,'This complaint is under review.','2022-06-09 21:55:37','2022-06-09 21:55:37'),(6,1,9,3,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci nulla itaque incidunt tenetur saepe laudantium vitae amet fugiat harum iste.','2022-08-05 20:38:33','2022-08-05 20:38:33'),(7,1,10,1,'This complaint is under review.','2022-08-09 06:52:32','2022-08-09 06:52:32'),(8,1,10,2,'test','2022-09-11 06:14:09','2022-09-11 06:14:09'),(9,1,11,1,'This complaint is under review.','2022-10-25 04:50:15','2022-10-25 04:50:15');
/*!40000 ALTER TABLE `customer_lead_complaint_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_lead_complaints`
--

DROP TABLE IF EXISTS `customer_lead_complaints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_lead_complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `complaint_received_by` int(11) DEFAULT NULL,
  `complaint_raised_by` int(11) DEFAULT NULL,
  `complaint_subject` varchar(500) DEFAULT NULL,
  `complaint_description` longtext DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_lead_complaints_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_lead_complaints`
--

LOCK TABLES `customer_lead_complaints` WRITE;
/*!40000 ALTER TABLE `customer_lead_complaints` DISABLE KEYS */;
INSERT INTO `customer_lead_complaints` VALUES (7,18,1,16,'Products are not as expected.','Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores tenetur, voluptas blanditiis est consequuntur quas quaerat cumque unde. Ipsum assumenda atque, perferendis, temporibus reprehenderit neque laborum id, saepe reiciendis modi porro dolorum voluptatibus? Nostrum magnam accusamus consectetur! Impedit praesentium odio consequuntur fugit cupiditate ullam, quidem earum. Officia, vitae repellendus harum esse doloremque asperiores ad! Repellat facere libero repudiandae debitis aspernatur impedit explicabo, voluptas magnam et rem veniam eveniet. Facilis animi eius non mollitia. Vitae praesentium nulla odit, officiis iure explicabo. Sapiente maiores animi debitis inventore, iste minus numquam molestiae voluptatem laboriosam provident eius vero culpa, velit aperiam corrupti autem maxime.','2022-05-12 00:54:30','2022-05-12 00:54:30'),(8,18,1,16,'Order not delivered yet.','Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum possimus laborum, accusamus amet reiciendis accusantium, labore alias dicta et exercitationem obcaecati ex autem porro. Ad mollitia, repellat fugiat minima veritatis labore libero ipsum itaque, omnis iure incidunt numquam et quis. Ad nesciunt dolorem iste eveniet? Quibusdam, nihil eaque! Ipsum, mollitia?','2022-05-12 01:47:37','2022-05-12 01:47:37'),(9,20,1,19,'Defect in products','Products were damaged','2022-06-09 21:55:37','2022-06-09 21:55:37'),(10,24,1,23,'Order not delivered yet. edited','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sunt possimus similique placeat provident cupiditate? Ullam magni aliquid unde, molestiae ex quis voluptatibus hic sapiente necessitatibus sit blanditiis, dolorem saepe assumenda, ab officiis magnam dolores quia tenetur. Cum, omnis doloribus nihil eveniet facilis, illum iste officiis ipsa nulla voluptatem at repellendus. edited','2022-08-09 06:52:32','2022-08-22 20:48:40'),(11,19,1,18,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, itaque eum reiciendis consequatur lib','Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, itaque eum reiciendis consequatur libero nesciunt! Voluptate id impedit eos atque sint accusamus culpa porro quibusdam quia aliquid consectetur molestias, eum temporibus beatae iste, fugiat saepe! Deserunt eos corrupti sint nobis molestiae? Impedit quibusdam nobis quos nam iste, molestias voluptate at, nisi deserunt nulla debitis consectetur voluptatem! Illo optio quos dolore ullam suscipit harum accusantium dolor beatae voluptatibus, sint quibusdam necessitatibus voluptate itaque? Tenetur, nulla veniam. Nostrum, tempora facere. Cupiditate commodi reprehenderit voluptate voluptas aliquam obcaecati molestiae, eos natus eveniet vitae pariatur, ipsum suscipit similique quam quae sapiente ea doloribus architecto.','2022-10-25 04:50:15','2022-10-25 05:02:37');
/*!40000 ALTER TABLE `customer_lead_complaints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_lead_contacts`
--

DROP TABLE IF EXISTS `customer_lead_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_lead_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `contact_person_image` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `contact_designation` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_notes` longtext DEFAULT NULL,
  `isActive` int(11) NOT NULL,
  `isLead` tinyint(4) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_lead_contacts_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `customer_lead_contacts_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_lead_contacts`
--

LOCK TABLES `customer_lead_contacts` WRITE;
/*!40000 ALTER TABLE `customer_lead_contacts` DISABLE KEYS */;
INSERT INTO `customer_lead_contacts` VALUES (16,26,18,NULL,'Aman Kumtakar','9988776655','SalesPerson','aman@gmail.com',NULL,1,0,'2022-05-07 01:14:07','2022-05-07 01:14:07'),(17,1,19,NULL,'Jayesh','8879654321','SalesPerson','jayesh@gmail.com',NULL,1,0,'2022-06-09 03:48:43','2022-06-09 03:48:43'),(18,25,19,NULL,'Suresh 1','9978654321','SalesPerson','surech@gmail.com',NULL,1,0,'2022-06-09 04:02:28','2022-06-10 07:06:45'),(19,25,20,NULL,'Jay','8877665432','SalesPerson','jay@gmail.com',NULL,1,0,'2022-06-09 04:08:57','2022-06-09 04:08:57'),(20,29,20,NULL,'John','1223346578','SalesPerson','john@cog.com',NULL,1,0,'2022-06-09 04:17:02','2022-06-09 04:17:02'),(21,1,14,NULL,'Mahesh','7798730914','SalesPerson','mahesh@gmail.com',NULL,1,0,'2022-06-09 19:43:04','2022-06-09 19:43:04'),(22,1,21,NULL,'Deep','7755664422','SalesPerson','deep@gmail.com',NULL,1,0,'2022-07-02 06:00:25','2022-07-02 06:00:25'),(23,1,24,'2022_08_09_12_20_43_photo.jpg','Om','7755664411','Sales Person','om@gmail.com',NULL,1,0,'2022-08-09 06:50:43','2022-08-09 06:50:43'),(24,1,32,NULL,'Colton Goodwin','2122121221','sales','zaroqewy@mailinator.com','Aut sint quo ut reiciendis iure elit doloremque est sunt tempora maxime excepturi maxime rem reiciendis tenetur voluptatem',1,0,'2022-10-09 03:43:20','2022-10-09 03:43:20'),(25,1,35,NULL,'Nathaniel Juarez','1212121212','Quae','mabijodu@mailinator.com','Consequatur minus ipsum veniam id culpa duis quisquam quibusdam omnis corrupti exercitationem id',1,0,'2022-10-13 03:24:59','2022-10-13 03:24:59');
/*!40000 ALTER TABLE `customer_lead_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_lead_notes`
--

DROP TABLE IF EXISTS `customer_lead_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_lead_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `notes_date` date DEFAULT NULL,
  `notes_time` varchar(255) DEFAULT NULL,
  `notes_description` longtext DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_lead_notes_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `customer_lead_notes_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_lead_notes`
--

LOCK TABLES `customer_lead_notes` WRITE;
/*!40000 ALTER TABLE `customer_lead_notes` DISABLE KEYS */;
INSERT INTO `customer_lead_notes` VALUES (6,1,19,'2022-06-10','12:00 PM','The customer was not satisfied','2022-06-10 07:08:09','2022-06-10 07:08:09'),(7,1,20,'2022-06-10','2:45 PM','Notes test','2022-06-09 21:54:25','2022-06-09 21:54:25');
/*!40000 ALTER TABLE `customer_lead_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_lead_profile`
--

DROP TABLE IF EXISTS `customer_lead_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_lead_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `firm_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_owner_name` varchar(255) DEFAULT NULL,
  `customer_type` varchar(255) DEFAULT NULL,
  `customer_no1` varchar(255) DEFAULT NULL,
  `customer_no2` varchar(255) DEFAULT NULL,
  `customer_mail` varchar(255) DEFAULT NULL,
  `customer_mail2` varchar(255) DEFAULT NULL,
  `manager_name` varchar(255) DEFAULT NULL,
  `manager_number` varchar(255) DEFAULT NULL,
  `accountant_name` varchar(255) DEFAULT NULL,
  `accountant_number` varchar(255) DEFAULT NULL,
  `customer_address` longtext DEFAULT NULL,
  `customer_gst_no` varchar(255) DEFAULT NULL,
  `office_address` varchar(255) DEFAULT NULL,
  `office_country` varchar(255) DEFAULT NULL,
  `office_state` varchar(255) DEFAULT NULL,
  `office_district` varchar(255) DEFAULT NULL,
  `office_taluka` varchar(255) DEFAULT NULL,
  `office_pin_code` int(40) DEFAULT NULL,
  `customer_country` varchar(255) DEFAULT NULL,
  `customer_state` varchar(255) DEFAULT NULL,
  `customer_district` varchar(255) DEFAULT NULL,
  `customer_taluka` varchar(255) DEFAULT NULL,
  `customer_pin_code` varchar(255) DEFAULT NULL,
  `customer_website` varchar(255) DEFAULT NULL,
  `customer_assigned_to` varchar(255) DEFAULT NULL,
  `customer_notes` longtext DEFAULT NULL,
  `lead_convert_date` varchar(255) DEFAULT NULL,
  `isLead` int(11) NOT NULL DEFAULT 0,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `firm_id_ibfk_2` (`firm_id`),
  CONSTRAINT `customer_lead_profile_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `firm_id_ibfk_2` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_lead_profile`
--

LOCK TABLES `customer_lead_profile` WRITE;
/*!40000 ALTER TABLE `customer_lead_profile` DISABLE KEYS */;
INSERT INTO `customer_lead_profile` VALUES (14,1,1,'And Ceramics','Owner Name','manufacturer','9876543210',NULL,'andceramics@gmail.com',NULL,NULL,NULL,NULL,NULL,'Plot__Lorem__ipsum__lorem__lorem__lorem',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'27','Thane','Thane',NULL,NULL,'22',NULL,NULL,1,1,'2022-05-03 04:29:05','2022-06-10 04:34:33'),(15,1,1,'ABC Emporia','Owner Name','retailer','9876453210',NULL,'abcemporia@gmail.com',NULL,NULL,NULL,NULL,NULL,'901/Woodville__Rodas Enclave__Hiranandani Estate__Patliapada__GB road__400607',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'27','Thane','Thane',NULL,NULL,'26',NULL,'2022-05-03 10:53:15',0,1,'2022-05-03 04:31:09','2022-07-02 05:33:17'),(16,1,1,'MandM','Owner Name','dealer','1023456789',NULL,'mandm@gmail.com',NULL,NULL,NULL,NULL,NULL,'Plot__Lorem__ipsum__lorem__lorem__lorem',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'27','Thane','Thane',NULL,NULL,'25',NULL,'2022-05-07 05:50:28',0,1,'2022-05-03 04:33:27','2022-05-07 00:20:28'),(17,26,1,'Jinals Lead','Owner Name','manufacturer','9988776655',NULL,'lead99@gmail.com',NULL,NULL,NULL,NULL,NULL,'Plot__Lorem__ipsum__lorem__lorem__lorem',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'27','Thane','Thane',NULL,NULL,'26',NULL,'2022-05-07 05:45:32',0,1,'2022-05-07 00:14:01','2022-05-07 00:15:32'),(18,1,1,'Darshans Customer','Owner Name','manufacturer','9987665544',NULL,'cust88@gmail.com',NULL,NULL,NULL,NULL,NULL,'Plot__Lorem__ipsum__lorem__lorem__lorem',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'27','Thane','Thane',NULL,NULL,'26',NULL,NULL,0,1,'2022-05-07 00:21:35','2022-05-07 00:21:35'),(19,1,1,'Paradise Ceramics','Owner Name','manufacturer','9875643210','9945678123','paradiseceramics@gmail.com',NULL,NULL,NULL,NULL,NULL,'Plot__Lorem__ipsum__lorem__lorem__lorem',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'India','27','Thane','Thane','400607','www.paradiseceramica.com','25',NULL,'2022-06-10 09:58:41',0,1,'2022-06-09 03:47:30','2022-06-10 07:05:30'),(20,25,1,'Milestone','Owner Name Changed','distributor','998784321',NULL,'milestone@gmail.com',NULL,NULL,NULL,NULL,NULL,'Plot__Lorem__ipsum__lorem__lorem__lorem',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'18','Thane','Thane',NULL,NULL,'29',NULL,'2022-06-09 11:24:44',0,1,'2022-06-09 04:08:15','2022-07-20 20:30:14'),(21,1,1,'OM Tiles','Owner Name','manufacturer','8732234988',NULL,'om@gmail.com',NULL,NULL,NULL,NULL,NULL,'Plot__Lorem__line 6',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'17','Thane','Thane',NULL,NULL,'26',NULL,NULL,1,1,'2022-06-23 04:15:21','2022-08-18 19:39:38'),(22,1,2,'Sample','Owner Name Changed','distributor','8899663344',NULL,'sample1@gmail.com',NULL,NULL,NULL,NULL,NULL,'test__test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'21','Thane','Thane',NULL,NULL,'29',NULL,NULL,1,1,'2022-07-11 07:10:32','2022-08-18 19:39:53'),(23,1,NULL,'Jason Holt','Flavia Townsend','dealer','7788996655',NULL,'natiryzahu@mailinator.com',NULL,NULL,NULL,NULL,NULL,'91 East Clarendon Freeway__Dignissimos facilis__Cumque laboris qui u__Amet dolor do volup__Fugiat a nesciunt__Incidunt dolorum ve',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Corrupti deserunt q','24','Minima sint amet au','Velit molestiae rati',NULL,'https://www.noqucemeqibu.net','27','Qui ipsa et est en',NULL,0,1,'2022-08-08 00:08:55','2022-08-08 00:08:55'),(24,1,1,'Dexter Sloan','Donovan Kim','distributor','5566447733',NULL,'gihy@mailinator.com',NULL,NULL,NULL,NULL,NULL,'432 Nobel Parkway__Aspernatur sunt esse__Ullam sed nisi et fu__Est porro nesciunt__Nulla tempor molliti__Omnis irure est ess',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Nobis laborum Optio','32','Animi commodi aliqu','Deleniti sint aut ve',NULL,'https://www.pyxyrivu.org','22','Impedit impedit so',NULL,0,1,'2022-08-08 01:08:06','2022-09-11 06:45:24'),(25,1,1,'Yvette Guzman','Zachery Reyes','distributor','3344556677',NULL,'dobe@mailinator.com','likivyku@mailinator.com',NULL,NULL,NULL,NULL,'41 East White Old Drive__Ad quas porro volupt__Esse corporis anim__Enim exercitation di__Ut magna earum culpa__Libero voluptate mol',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Sed deserunt quo aut','9','Odio sed quaerat et','Facere voluptates pa',NULL,'https://www.vipugudipe.org','22','Dolor consequatur u',NULL,0,0,'2022-08-08 01:31:18','2022-08-08 01:36:29'),(26,23,1,'Melinda Mcknight','Hoyt Cameron','retailer','6464646464',NULL,'zovuwad@mailinator.com','qiwi@mailinator.com',NULL,NULL,NULL,NULL,'37 Green First Boulevard__Id est accusamus optio et re__Velit anim qui impedit aut__Vitae expedita dolorum commodo__Non vero eligendi non earum au__Et dolor sunt minima id quo m',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'22','Veritatis enim nihil in aut ni','Qui ratione sed laborum Animi','24','https://www.lerifipuq.ws','23',NULL,NULL,1,1,'2022-09-08 23:03:00','2022-10-02 03:54:01'),(27,1,1,'Uriah Wilkinson','Venus Jacobson','manufacturer','2424242424',NULL,'qisapamu@mailinator.com','ziwupapym@mailinator.com',NULL,NULL,NULL,NULL,'37 First Parkway__Occaecat quae numquam sunt qui__Dolore distinctio Recusandae__Aut eum quo ut et nisi ab__Delectus culpa a non quidem__Molestiae delectus in aut vol',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'24','Laboris','Deserunt','24','https://www.pynedapej.ca','22',NULL,NULL,1,1,'2022-10-02 03:11:07','2022-10-02 03:11:07'),(28,22,1,'Gail Vargas','Brooke Peck','dealer','8181818181',NULL,'zomak@mailinator.com','goqepygic@mailinator.com',NULL,NULL,NULL,NULL,'317 New Avenue__Delectus voluptatem non cumqu__Fugiat minima alias esse pari__Eveniet ullam sint quo non ve__Ut consequatur quos ut iste s__In quia sequi veniam pariatur',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'25','Explicabo','Reprehenderit','680001','https://www.wolumefi.cc','22',NULL,NULL,1,1,'2022-10-02 03:14:05','2022-10-02 03:14:05'),(29,22,1,'Venus Wells','Odysseus Holden','manufacturer','8585858585',NULL,'gaden@mailinator.com','dawawa@mailinator.com',NULL,NULL,NULL,NULL,'141 White Old Road__Anim dolor aut placeat repreh__Consectetur eum dolore exercit__Amet rerum sunt qui commodi s__Repellendus Non aute eius a s__Quisquam voluptas quis natus i',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'37','Quo','Quaerat','93','https://www.galoqadumogy.co.uk','24',NULL,NULL,1,1,'2022-10-02 03:15:13','2022-10-02 03:15:13'),(30,24,1,'Yoko Kent','Hunter Hopper','distributor','3232323232',NULL,'dydemi@mailinator.com','pogo@mailinator.com',NULL,NULL,NULL,NULL,'676 Clarendon Extension__Quaerat nostrud ea mollitia au__Pariatur Et necessitatibus eu__Iure distinctio Fugit eum no__Beatae officia quis qui vero d__Accusamus quisquam vitae natus',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'6','Qui','Omnis','43434343','https://www.lubi.org.uk','24',NULL,NULL,1,1,'2022-10-02 03:16:58','2022-10-02 03:35:14'),(31,23,1,'Robin Pace','Cleo Harvey','dealer','4141414141',NULL,'betufu@mailinator.com','peda@mailinator.com',NULL,NULL,NULL,NULL,'89 North Nobel Court__Sed velit labore nisi deleniti__Qui elit praesentium voluptat__Dolor cumque iure dolorum dolo__Aliqua Ea magnam consequatur__Laborum Possimus fugiat non',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','Dolore','Repellendus','87878787','https://www.davylopaly.ca','23',NULL,NULL,1,0,'2022-10-02 03:54:37','2022-10-02 03:55:27'),(32,22,1,'Finn Ballard','Lacey Molina','retailer','4545454545',NULL,'zudihuc@mailinator.com',NULL,NULL,NULL,NULL,NULL,'24 Nobel Road__Officia eum quam perferendis c__Id sint at occaecat aliqua Mi__Officia eum quam perferendis c__Deserunt ullam voluptatem qui__Dicta enim blanditiis adipisic','06BZAHM6385P6Z2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'35','Qui','Et minus','96969696','https://www.givi.co.uk','22',NULL,NULL,1,1,'2022-10-02 03:56:07','2023-01-25 23:21:26'),(33,1,1,'Velma Christian','Anne Wooten','retailer','6060606060',NULL,'qykageda@mailinator.com','qejev@mailinator.com',NULL,NULL,NULL,NULL,'45 Old Boulevard__Quod quasi non ipsum ut itaque__Exercitation Nam id rerum et p__Incididunt enim quaerat optio__Sed consequatur sequi earum cu__Neque ipsa laboris eum quia e',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Dignissimos accusamus nostrud','1','Modi est consequat In aliquam','Ut in corrupti dignissimos in','45454545','https://www.hoga.me','1','Rerum perferendis est id et',NULL,0,1,'2022-10-02 04:01:24','2022-10-02 04:02:50'),(34,1,1,'Maisie Puckett','Irene Mcfadden','manufacturer','3737373737',NULL,'tetugusyh@mailinator.com','gixyduje@mailinator.com',NULL,NULL,NULL,NULL,'920 Oak Avenue__Omnis nemo laborum Incidunt__Nihil assumenda beatae enim cu__In eiusmod vero eum et volupta__Minima et ipsum occaecat accus__Qui magni vel itaque ad ad dol',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Enim et dignissimos minim eos','19','Consectetur et explicabo Cumq','Eum asperiores recusandae Fug','53535353','https://www.fasenagu.in','22','Odit itaque magnam voluptate ducimus qui qui consequatur dolor ipsa ut earum a exercitationem aut rerum accusantium',NULL,0,1,'2022-10-02 04:02:38','2022-10-02 04:03:04'),(35,1,1,'Kennan Stephenson','Briar Calhoun','manufacturer','7979797979',NULL,'fira@mailinator.com',NULL,NULL,NULL,NULL,NULL,'653 North Nobel Road__Aute adipisci est consectetur__In in consequuntur et laborios__Adipisicing incididunt deserun__Et quisquam voluptas et qui vo__Amet optio reiciendis natus','06BZAHM6385P6Z2',NULL,NULL,NULL,NULL,NULL,NULL,'Fuga Exercitation atque accus','4','Cillum reiciendis aliqua Elit','Iusto et dolore et dolorem arc','19191919',NULL,'23','Impedit id praesentium exercitationem debitis voluptas at fugiat adipisci est architecto expedita saepe',NULL,0,1,'2022-10-02 04:04:41','2023-01-25 07:03:56');
/*!40000 ALTER TABLE `customer_lead_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_order_particulars`
--

DROP TABLE IF EXISTS `customer_order_particulars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_order_particulars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `product_category_name` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_hsn` varchar(255) DEFAULT NULL,
  `product_nos` int(11) DEFAULT NULL,
  `product_packaging` int(11) DEFAULT NULL,
  `product_unit` varchar(255) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_price` varchar(255) DEFAULT NULL,
  `product_gst` varchar(255) DEFAULT NULL,
  `product_amount` varchar(255) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_order_id_fk` (`customer_order_id`),
  KEY `product_category_id_fk` (`product_category_id`),
  CONSTRAINT `customer_order_id_fk` FOREIGN KEY (`customer_order_id`) REFERENCES `customer_orders` (`id`),
  CONSTRAINT `product_category_id_fk` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_order_particulars`
--

LOCK TABLES `customer_order_particulars` WRITE;
/*!40000 ALTER TABLE `customer_order_particulars` DISABLE KEYS */;
INSERT INTO `customer_order_particulars` VALUES (27,18,25,NULL,NULL,'Bayferrox 4125','123456',4,25,'1',100,'100','18','11800.00','2022-11-07 07:05:28','2022-11-07 07:05:28');
/*!40000 ALTER TABLE `customer_order_particulars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_orders`
--

DROP TABLE IF EXISTS `customer_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `order_made_by` varchar(255) DEFAULT NULL,
  `order_date` varchar(255) NOT NULL,
  `dispatch_date` varchar(255) NOT NULL,
  `dispatch_status` varchar(255) NOT NULL,
  `transport` varchar(255) DEFAULT NULL,
  `term_of_supply` varchar(255) NOT NULL,
  `order_sub_total` varchar(255) DEFAULT '0',
  `order_total` varchar(255) NOT NULL,
  `order_tax` varchar(255) DEFAULT '0',
  `order_tax_percent` varchar(255) NOT NULL DEFAULT '0',
  `payment_condition` varchar(255) NOT NULL,
  `payment_time` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `firm_name` varchar(255) DEFAULT NULL,
  `firm_address` varchar(255) DEFAULT NULL,
  `firm_gst_no` varchar(255) DEFAULT NULL,
  `firm_bank_name` varchar(255) DEFAULT NULL,
  `firm_branch_name` varchar(255) DEFAULT NULL,
  `firm_bank_account_no` varchar(255) DEFAULT NULL,
  `firm_bank_ifsc` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_address` varchar(255) DEFAULT NULL,
  `booking_destination` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `customer_id_ibfk_2` (`customer_id`),
  CONSTRAINT `customer_id_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`),
  CONSTRAINT `customer_orders_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_orders`
--

LOCK TABLES `customer_orders` WRITE;
/*!40000 ALTER TABLE `customer_orders` DISABLE KEYS */;
INSERT INTO `customer_orders` VALUES (18,1,35,'SO\\NOV\\0001\\22-23','Darshan Mahajan','2022-11-07','2022-11-07','dispatch','ABC transport','paid','0','11800.00','0','0','0','none','advance','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content he','Anjali Chemicals','401,4th Floor,\r\nHardik Residency\r\nNear Vithal Rukhmani Mandir\r\nSector -1, Airoli\r\nNavi Mumbai\r\nMaharashtra, Code : 27\r\nGSTIN: 27AJEPA4925F1ZK\r\nContact: 022-27792232,9326337723 /8425849809','27AJEPA4925F1ZK','IDBI BANK LIMITED','AIROLI','0367102000003322','IBKL0000367','Kennan Stephenson','Briar Calhoun\r\n653 North Nobel Road\r\nAute adipisci est consectetur\r\nIn in consequuntur et laborios\r\nAdipisicing incididunt deserun\r\nEt quisquam voluptas et qui vo\r\nAmet optio reiciendis natus','Goa','2022-11-07 07:05:28','2022-11-07 07:05:28');
/*!40000 ALTER TABLE `customer_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `firms`
--

DROP TABLE IF EXISTS `firms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `firms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_name` varchar(255) DEFAULT NULL,
  `firm_owner_name` varchar(255) DEFAULT NULL,
  `firm_email` varchar(255) DEFAULT NULL,
  `firm_address` longtext DEFAULT NULL,
  `firm_gst_no` varchar(255) DEFAULT NULL,
  `firm_contact_no` varchar(255) DEFAULT NULL,
  `firm_signatory_image` varchar(255) DEFAULT NULL,
  `firm_bank_name` varchar(255) DEFAULT NULL,
  `firm_bank_account_no` varchar(255) DEFAULT NULL,
  `firm_bank_ifsc_code` varchar(255) NOT NULL,
  `firm_bank_branch_name` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `firms`
--

LOCK TABLES `firms` WRITE;
/*!40000 ALTER TABLE `firms` DISABLE KEYS */;
INSERT INTO `firms` VALUES (1,'Anjali Chemicals','Sachin Agrawal','sachin@anjalichemicals.com','401,4th Floor,__Hardik Residency__Near Vithal Rukhmani Mandir__Sector -1, Airoli__Navi Mumbai__Maharashtra, Code : 27','27AJEPA4925F1ZK','022-27792232,9326337723 /8425849809',NULL,'IDBI BANK LIMITED','0367102000003322','IBKL0000367','AIROLI','2022-04-11 11:25:44','2022-06-08 19:38:10'),(2,'Radha Industries','Sachin Agrawal',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,'2022-04-11 11:26:05','2022-04-11 11:26:05'),(3,'Kamalkishor & Company','Sachin Agrawal',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,'2022-04-11 11:26:05','2022-04-11 11:26:05'),(4,'Kriya Chemicals','Sachin Agrawal',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,'2022-07-10 15:00:44','2022-07-10 15:00:44');
/*!40000 ALTER TABLE `firms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2013_04_09_062329_create_revisions_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `updated` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'Dashboard','home','ni ni-tv-2',NULL,'2021-12-29 20:07:40','2021-12-29 20:07:40'),(2,'Roles','manage_roles','ni ni-key-25',NULL,'2021-12-29 20:09:15','2021-12-29 20:09:15'),(3,'Products','manage_products','ni ni-app',NULL,'2021-12-29 20:09:58','2021-12-29 20:09:58'),(6,'Leads','manage_leads','fas fa-user-clock',NULL,'2022-01-06 05:19:35','2022-01-06 05:19:35'),(7,'Announcement','manage_announcement','ni ni-notification-70',NULL,'2022-01-06 05:20:18','2022-01-06 05:20:18'),(8,'Employees','manage_employee','fas fa-user-tie',NULL,'2022-01-06 07:37:02','2022-01-06 07:37:02'),(9,'Sales Transactions','manage_quotations','ni ni-collection',NULL,'2022-01-28 05:25:44','2022-01-28 05:25:44'),(10,'Customers','manage_customers','fas fa-user-alt',NULL,'2022-01-30 09:57:20','2022-01-30 09:57:20'),(11,'Tasks','manage_tasks','fas fa-clipboard-list',NULL,'2022-02-25 05:13:33','2022-02-25 05:13:33'),(13,'Reports','manage_reports','ni ni-chart-bar-32',NULL,'2022-03-30 16:55:39','2022-03-30 16:55:39'),(14,'Firms','manage_firms','fas fa-building',NULL,'2022-06-04 15:02:03','2022-06-04 15:02:03');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules_roles`
--

DROP TABLE IF EXISTS `modules_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `modify_access` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `modules_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`),
  CONSTRAINT `modules_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`),
  CONSTRAINT `modules_roles_ibfk_3` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules_roles`
--

LOCK TABLES `modules_roles` WRITE;
/*!40000 ALTER TABLE `modules_roles` DISABLE KEYS */;
INSERT INTO `modules_roles` VALUES (42,4,1,0,'2022-01-15 04:32:22','2022-01-15 04:32:22'),(43,5,3,0,'2022-01-15 05:39:54','2022-01-15 05:39:54'),(44,5,7,1,'2022-01-15 05:39:54','2022-01-15 05:39:54'),(142,1,1,1,'2022-03-30 16:56:33','2022-03-30 16:56:33'),(143,1,2,1,'2022-03-30 16:56:33','2022-03-30 16:56:33'),(144,1,3,1,'2022-03-30 16:56:33','2022-03-30 16:56:33'),(145,1,6,1,'2022-03-30 16:56:33','2022-03-30 16:56:33'),(146,1,7,1,'2022-03-30 16:56:33','2022-03-30 16:56:33'),(147,1,8,1,'2022-03-30 16:56:33','2022-03-30 16:56:33'),(148,1,9,1,'2022-03-30 16:56:33','2022-03-30 16:56:33'),(149,1,10,1,'2022-03-30 16:56:33','2022-03-30 16:56:33'),(150,1,11,1,'2022-03-30 16:56:33','2022-03-30 16:56:33'),(151,1,13,1,'2022-03-30 16:56:33','2022-03-30 16:56:33'),(201,1,14,1,'2022-06-04 15:02:25','2022-06-04 15:02:25'),(223,2,1,0,'2022-08-08 12:46:10','2022-08-08 12:46:10'),(224,2,2,0,'2022-08-08 12:46:10','2022-08-08 12:46:10'),(225,2,3,1,'2022-08-08 12:46:10','2022-08-08 12:46:10'),(226,2,6,1,'2022-08-08 12:46:10','2022-08-08 12:46:10'),(227,2,7,0,'2022-08-08 12:46:10','2022-08-08 12:46:10'),(228,2,8,1,'2022-08-08 12:46:10','2022-08-08 12:46:10'),(229,2,9,1,'2022-08-08 12:46:10','2022-08-08 12:46:10'),(230,2,10,1,'2022-08-08 12:46:10','2022-08-08 12:46:10'),(231,2,11,1,'2022-08-08 12:46:10','2022-08-08 12:46:10'),(236,3,3,0,'2022-10-16 10:55:04','2022-10-16 10:55:04'),(237,3,6,1,'2022-10-16 10:55:04','2022-10-16 10:55:04'),(238,3,7,0,'2022-10-16 10:55:04','2022-10-16 10:55:04'),(239,3,10,0,'2022-10-16 10:55:04','2022-10-16 10:55:04'),(240,3,11,1,'2022-10-16 10:55:04','2022-10-16 10:55:04');
/*!40000 ALTER TABLE `modules_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_nos` int(11) DEFAULT NULL,
  `product_packaging` int(11) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_price` float DEFAULT NULL,
  `product_gst` varchar(255) DEFAULT NULL,
  `product_tax` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_detail`
--

LOCK TABLES `order_detail` WRITE;
/*!40000 ALTER TABLE `order_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_made_by` varchar(255) DEFAULT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `transport` varchar(255) DEFAULT NULL,
  `booking_destination` varchar(255) DEFAULT NULL,
  `dispatch_date` datetime DEFAULT NULL,
  `dispatch_status` tinyint(4) DEFAULT NULL,
  `order_total` float DEFAULT NULL,
  `term_of_supply` varchar(255) NOT NULL,
  `payment_time` int(11) NOT NULL,
  `payment_condition` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `firm_id` int(11) DEFAULT NULL,
  `firm_name` varchar(255) DEFAULT NULL,
  `firm_address` text DEFAULT NULL,
  `firm_gst_no` varchar(255) DEFAULT NULL,
  `firm_bank_name` varchar(255) DEFAULT NULL,
  `firm_branch_name` varchar(255) DEFAULT NULL,
  `firm_bank_account_no` varchar(255) DEFAULT NULL,
  `firm_bank_ifsc` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `customer_id` (`customer_id`),
  KEY `firm_id` (`firm_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`),
  CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_ibfk_6` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`),
  CONSTRAINT `orders_ibfk_7` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (9,'Red Iron Oxide Pigments',1,'2022-03-25 11:54:11','2022-03-25 11:54:11'),(10,'Yellow Iron Oxide Pigments',1,'2022-03-25 11:54:23','2022-03-25 11:54:23'),(11,'Black Iron Oxide Pigments',1,'2022-03-25 11:54:34','2022-03-25 11:54:34'),(12,'Brown Iron Oxide Pigments',1,'2022-03-25 11:54:44','2022-03-25 11:54:44'),(15,'Other Pigments',1,'2022-03-25 11:55:32','2022-03-25 11:55:32'),(16,'Chemicals Division',1,'2022-03-25 11:55:49','2022-03-25 11:55:49'),(18,'Moulds Division',1,'2022-03-25 11:56:13','2022-03-25 11:56:13');
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_details`
--

DROP TABLE IF EXISTS `product_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `product_category` int(11) DEFAULT NULL,
  `product_origin` varchar(255) DEFAULT NULL,
  `product_price` varchar(255) DEFAULT NULL,
  `product_hsn` varchar(255) DEFAULT NULL,
  `product_packaging` varchar(255) DEFAULT NULL,
  `product_tax` int(11) DEFAULT NULL,
  `product_tds` varchar(255) DEFAULT NULL,
  `product_msds` varchar(255) DEFAULT NULL,
  `product_unit` int(11) NOT NULL,
  `isActive` tinyint(4) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_category` (`product_category`),
  KEY `product_unit_ibfk_2` (`product_unit`),
  CONSTRAINT `product_details_ibfk_1` FOREIGN KEY (`product_category`) REFERENCES `product_category` (`id`),
  CONSTRAINT `product_unit_ibfk_2` FOREIGN KEY (`product_unit`) REFERENCES `product_units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_details`
--

LOCK TABLES `product_details` WRITE;
/*!40000 ALTER TABLE `product_details` DISABLE KEYS */;
INSERT INTO `product_details` VALUES (22,'Bayferrox 4100',9,'China','1000','123456','25',18,NULL,NULL,1,0,'2022-03-25 00:19:18','2022-09-11 06:06:35'),(23,'Bayferrox 4110',9,'China','2000','123456','25',18,NULL,NULL,1,1,'2022-03-25 00:20:42','2022-03-25 00:20:42'),(24,'Bayferrox 4100/402',9,'China','2000','123456','25',18,NULL,NULL,1,1,'2022-03-25 00:21:06','2022-03-25 00:21:06'),(25,'Bayferrox 4125',9,'China','3000','123456','25',18,NULL,NULL,1,1,'2022-03-25 00:21:31','2022-03-25 00:21:31'),(26,'Bayferrox 4130',9,'China','3000','123456','25',18,NULL,NULL,1,1,'2022-03-25 00:22:07','2022-03-25 00:22:07'),(27,'Bayferrox 4905',10,'China','3000','123456','25',18,NULL,NULL,1,1,'2022-03-25 00:22:38','2022-03-25 00:22:38'),(28,'Bayferrox 4910',10,'China','2500','123456','25',18,NULL,NULL,1,1,'2022-03-25 00:23:15','2022-03-25 00:23:15'),(29,'Yellow Oxide 920',10,'China','3000','123456','20',18,NULL,NULL,1,1,'2022-03-25 00:23:49','2022-03-25 00:23:49'),(30,'IOX Y02',10,'Germany','2500','123456','20',18,NULL,NULL,1,1,'2022-03-25 00:24:23','2022-03-25 00:24:23'),(31,'Bayferrox 4330',11,'China','2500','123456','25',18,NULL,NULL,1,1,'2022-03-25 00:25:00','2022-03-25 00:39:22'),(32,'Bayferrox 360 (Micronized)',11,'Germany','2500','123456','25',18,NULL,NULL,1,1,'2022-03-25 00:25:42','2022-03-25 00:25:42'),(33,'Titanium Dioxide- Rutile',15,'India /Imported','5000','12345678','25',10,NULL,NULL,1,1,'2022-03-25 00:26:30','2022-10-16 04:58:40'),(37,'Idona Banks',18,'Itaque sunt culpa aliqua Do',NULL,'67676767','94',25,'2022_10_26_12_19_18_Screenshot_20221025_202727.png','2022_10_26_12_19_18_Screenshot_20221025_203725.png',1,1,'2022-10-26 06:49:18','2022-10-26 06:49:18'),(38,'Candace Whitehead test',16,'Indian',NULL,'23232399','30',18,'2022_11_06_11_45_37_Roadmap.pdf','2022_11_06_11_45_37_ABC EMPORIA_Q_NOV_0001_22-23 (1).pdf',3,1,'2022-11-06 06:15:37','2022-11-05 20:45:17'),(39,'Candace Whitehead',10,'China',NULL,'24352436','10',0,NULL,NULL,1,1,'2023-01-24 19:52:59','2023-01-24 19:59:20');
/*!40000 ALTER TABLE `product_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_units`
--

DROP TABLE IF EXISTS `product_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_units`
--

LOCK TABLES `product_units` WRITE;
/*!40000 ALTER TABLE `product_units` DISABLE KEYS */;
INSERT INTO `product_units` VALUES (1,'kg','2022-03-25 12:11:36','2022-03-25 12:11:36'),(3,'ltr','2022-03-25 12:12:07','2022-03-25 12:12:07');
/*!40000 ALTER TABLE `product_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotation_particulars`
--

DROP TABLE IF EXISTS `quotation_particulars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotation_particulars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `product_category_name` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_hsn` varchar(255) DEFAULT NULL,
  `product_nos` int(11) DEFAULT NULL,
  `product_packaging` int(11) DEFAULT NULL,
  `product_unit` varchar(255) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_price` varchar(255) DEFAULT NULL,
  `product_gst` varchar(255) DEFAULT NULL,
  `product_amount` varchar(255) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `quotation_id_fk` (`quotation_id`),
  KEY `product_category_ibfk` (`product_category_id`),
  CONSTRAINT `product_category_ibfk` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`),
  CONSTRAINT `quotation_id_fk` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotation_particulars`
--

LOCK TABLES `quotation_particulars` WRITE;
/*!40000 ALTER TABLE `quotation_particulars` DISABLE KEYS */;
INSERT INTO `quotation_particulars` VALUES (131,25,24,9,'Red Iron Oxide Pigments','Bayferrox 4100/402','123456',5,25,'1',125,'120','18','17700.00','2022-11-05 03:39:57','2022-11-05 03:39:57'),(132,25,29,10,'Yellow Iron Oxide Pigments','Yellow Oxide 920','123456',5,20,'1',100,'100','18','11800.00','2022-11-05 03:39:57','2022-11-05 03:39:57'),(138,26,29,10,'Yellow Iron Oxide Pigments','Yellow Oxide 920','123456',5,20,'1',100,'100','18','11800.00','2022-11-06 05:42:54','2022-11-06 05:42:54'),(139,26,31,11,'Black Iron Oxide Pigments','Bayferrox 4330','123456',10,25,'1',250,'120','18','35400.00','2022-11-06 05:42:54','2022-11-06 05:42:54'),(140,26,30,10,'Yellow Iron Oxide Pigments','IOX Y02','123456',10,20,'1',200,'100','18','23600.00','2022-11-06 05:42:54','2022-11-06 05:42:54'),(141,26,33,15,'Other Pigments','Titanium Dioxide- Rutile','12345678',10,25,'1',250,'100','10','27500.00','2022-11-06 05:42:54','2022-11-06 05:42:54'),(142,27,25,9,'Red Iron Oxide Pigments','Bayferrox 4125','123456',1,25,'1',25,'100','18','2950.00','2023-10-04 06:57:44','2023-10-04 06:57:44'),(144,28,24,9,'Red Iron Oxide Pigments','Bayferrox 4100/402','123456',1,25,'1',25,'100','18','2950.00','2023-10-04 06:59:10','2023-10-04 06:59:10');
/*!40000 ALTER TABLE `quotation_particulars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotations`
--

DROP TABLE IF EXISTS `quotations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `quotation_no` varchar(255) DEFAULT NULL,
  `quotation_made_by` varchar(255) DEFAULT NULL,
  `quotation_type` varchar(255) NOT NULL,
  `quotation_date` varchar(255) NOT NULL,
  `dispatch_date` varchar(255) NOT NULL,
  `dispatch_status` varchar(255) NOT NULL,
  `transport` varchar(255) DEFAULT NULL,
  `term_of_supply` varchar(255) NOT NULL,
  `quotation_sub_total` varchar(255) DEFAULT '0',
  `quotation_total` varchar(255) NOT NULL,
  `quotation_tax` varchar(255) DEFAULT '0',
  `quotation_tax_percent` varchar(255) NOT NULL DEFAULT '0',
  `payment_condition` varchar(255) NOT NULL,
  `payment_time` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `remarks` longtext DEFAULT NULL,
  `firm_id` int(11) DEFAULT NULL,
  `firm_name` varchar(255) DEFAULT NULL,
  `firm_address` text DEFAULT NULL,
  `firm_gst_no` varchar(255) DEFAULT NULL,
  `firm_bank_name` varchar(255) DEFAULT NULL,
  `firm_branch_name` varchar(255) DEFAULT NULL,
  `firm_bank_account_no` varchar(255) DEFAULT NULL,
  `firm_bank_ifsc` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_address` varchar(255) DEFAULT NULL,
  `booking_destination` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `firm_id` (`firm_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `quotations_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `quotations_ibfk_2` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`),
  CONSTRAINT `quotations_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `customer_lead_profile` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotations`
--

LOCK TABLES `quotations` WRITE;
/*!40000 ALTER TABLE `quotations` DISABLE KEYS */;
INSERT INTO `quotations` VALUES (25,1,'Q/NOV/0001/22-23','Darshan Mahajan','quotation','2022-11-05','2022-11-19','pending','ABC transport','paid','0','29500.00','0','0','0','none','advance','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.',1,'Anjali Chemicals','401,4th Floor,\r\nHardik Residency\r\nNear Vithal Rukhmani Mandir\r\nSector -1, Airoli\r\nNavi Mumbai\r\nMaharashtra, Code : 27\r\nGSTIN: 27AJEPA4925F1ZK\r\nContact: 022-27792232,9326337723 /8425849809',NULL,'IDBI BANK LIMITED','AIROLI','0367102000003322','IBKL0000367',15,'ABC Emporia','901/Woodville\r\nRodas Enclave\r\nHiranandani Estate\r\nPatliapada\r\nGB road\r\n400607','Goa','2022-11-05 06:39:48','2022-11-05 03:39:57'),(26,1,'Q/NOV/0002/22-23','Darshan Mahajan','quotation','2022-11-06','2022-11-08','dispatch','ABC transport','paid','0','98300.00','0','0','0','none','advance','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is tha',1,'Anjali Chemicals','401,4th Floor,\r\nHardik Residency\r\nNear Vithal Rukhmani Mandir\r\nSector -1, Airoli\r\nNavi Mumbai\r\nMaharashtra, Code : 27\r\nGSTIN: 27AJEPA4925F1ZK\r\nContact: 022-27792232,9326337723 /8425849809',NULL,'IDBI BANK LIMITED','AIROLI','0367102000003322','IBKL0000367',15,'ABC Emporia','901/Woodville\r\nRodas Enclave\r\nHiranandani Estate\r\nPatliapada\r\nGB road\r\n400607','Goa','2022-11-05 22:13:46','2022-11-06 05:42:54'),(27,1,'PI/OCT/0001/23-24','Darshan Mahajan','proforma_invoice','2023-10-04','2023-10-04','pending','Truck','to_pay','0','2950.00','0','0','10','days','credit',NULL,1,'Anjali Chemicals','401,4th Floor,\r\nHardik Residency\r\nNear Vithal Rukhmani Mandir\r\nSector -1, Airoli\r\nNavi Mumbai\r\nMaharashtra, Code : 27\r\nGSTIN: 27AJEPA4925F1ZK\r\nContact: 022-27792232,9326337723 /8425849809',NULL,'IDBI BANK LIMITED','AIROLI','0367102000003322','IBKL0000367',15,'ABC Emporia','901/Woodville\r\nRodas Enclave\r\nHiranandani Estate\r\nPatliapada\r\nGB road\r\n400607',NULL,'2023-10-04 06:57:44','2023-10-04 06:57:44'),(28,1,'PI/OCT/0002/23-24','Darshan Mahajan','proforma_invoice','2023-10-04','2023-10-04','pending','Truck','to_pay','0','2950.00','0','0','10','days','credit',NULL,1,'Anjali Chemicals','401,4th Floor,\r\nHardik Residency\r\nNear Vithal Rukhmani Mandir\r\nSector -1, Airoli\r\nNavi Mumbai\r\nMaharashtra, Code : 27\r\nGSTIN: 27AJEPA4925F1ZK\r\nContact: 022-27792232,9326337723 /8425849809',NULL,'IDBI BANK LIMITED','AIROLI','0367102000003322','IBKL0000367',15,'ABC Emporia','901/Woodville\r\nRodas Enclave\r\nHiranandani Estate\r\nPatliapada\r\nGB road\r\n400607',NULL,'2023-10-04 06:58:37','2023-10-04 06:59:10');
/*!40000 ALTER TABLE `quotations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revisions`
--

DROP TABLE IF EXISTS `revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `revisions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `revisionable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revisionable_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revisions_revisionable_id_revisionable_type_index` (`revisionable_id`,`revisionable_type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revisions`
--

LOCK TABLES `revisions` WRITE;
/*!40000 ALTER TABLE `revisions` DISABLE KEYS */;
INSERT INTO `revisions` VALUES (1,'App\\Models\\UserDetails',9,1,'personal_phone_no_1','7738730914','7738730889','2022-08-08 15:35:44','2022-08-08 15:35:44');
/*!40000 ALTER TABLE `revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_title` varchar(100) NOT NULL,
  `state_code` int(11) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6601 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state`
--

LOCK TABLES `state` WRITE;
/*!40000 ALTER TABLE `state` DISABLE KEYS */;
INSERT INTO `state` VALUES (1,'Andaman & Nicobar Islands',35,'Active'),(2,'Andhra Pradesh',28,'Active'),(3,'Arunachal Pradesh',12,'Active'),(4,'Assam',18,'Active'),(5,'Bihar',10,'Active'),(6,'Chandigarh',4,'Active'),(7,'Chhattisgarh',22,'Active'),(8,'Dadra & Nagar Haveli',26,'Active'),(9,'Daman & Diu',25,'Active'),(10,'Delhi',7,'Active'),(11,'Goa',30,'Active'),(12,'Gujarat',24,'Active'),(13,'Haryana',6,'Active'),(14,'Himachal Pradesh',2,'Active'),(15,'Jammu & Kashmir',1,'Active'),(16,'Jharkhand',20,'Active'),(17,'Karnataka',29,'Active'),(18,'Kerala',32,'Active'),(19,'Lakshadweep',31,'Active'),(20,'Madhya Pradesh',23,'Active'),(21,'Maharashtra',27,'Active'),(22,'Manipur',14,'Active'),(23,'Meghalaya',17,'Active'),(24,'Mizoram',15,'Active'),(25,'Nagaland',13,'Active'),(26,'Odisha',21,'Active'),(27,'Pondicherry',34,'Active'),(28,'Punjab',3,'Active'),(29,'Rajasthan',8,'Active'),(30,'Sikkim',11,'Active'),(31,'Tamil Nadu',33,'Active'),(32,'Tripura',16,'Active'),(33,'Uttar Pradesh',9,'Active'),(34,'Uttarakhand',5,'Active'),(35,'West Bengal',19,'Active'),(36,'Andhra Pradesh (New)',37,'Active'),(37,'Telangana',36,'Active');
/*!40000 ALTER TABLE `state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_modules`
--

DROP TABLE IF EXISTS `sub_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_module_id` int(11) NOT NULL,
  `sub_module_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `parent_module_id` (`parent_module_id`),
  CONSTRAINT `sub_modules_ibfk_1` FOREIGN KEY (`parent_module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_modules`
--

LOCK TABLES `sub_modules` WRITE;
/*!40000 ALTER TABLE `sub_modules` DISABLE KEYS */;
INSERT INTO `sub_modules` VALUES (1,3,'Product Categories','manage_productCategory','2021-12-29 20:59:29','2021-12-29 20:59:29'),(2,3,'Product Details','manage_productDetails','2021-12-29 21:12:43','2021-12-29 21:12:43');
/*!40000 ALTER TABLE `sub_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_assigned_by` int(11) DEFAULT NULL,
  `task_assigned_to` int(11) DEFAULT NULL,
  `task_date` datetime DEFAULT NULL,
  `task_title` varchar(255) DEFAULT NULL,
  `task_description` longtext DEFAULT NULL,
  `task_status` tinyint(4) DEFAULT NULL,
  `task_notes` longtext DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` VALUES (2,1,22,NULL,'Close todays leads','Please comply with leads provided',2,NULL,'2022-02-25 07:12:11','2022-02-25 07:12:11'),(3,1,22,NULL,'task123','task description',3,NULL,'2022-03-09 06:26:01','2022-03-09 06:26:01'),(4,1,22,NULL,'Aliquip consequatur Assumenda enim sit quia vel iure autem doloremque quis voluptate ut incididunt molestiae quod','Omnis veniam duis in non consectetur sed',1,NULL,'2022-10-15 22:43:28','2022-10-15 22:43:28'),(5,22,23,NULL,'Aliquip consequatur Assumenda enim sit quia vel iure autem doloremque quis voluptate ut incididunt molestiae quod','Omnis veniam duis in non consectetur sed',1,NULL,'2022-10-15 22:54:09','2022-10-15 22:54:09');
/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `employee_image` varchar(255) DEFAULT NULL,
  `personal_phone_no_1` varchar(255) DEFAULT NULL,
  `personal_phone_no_2` varchar(255) DEFAULT NULL,
  `father_phone_no` varchar(255) DEFAULT NULL,
  `mother_phone_no` varchar(255) DEFAULT NULL,
  `wife_phone_no` varchar(255) DEFAULT NULL,
  `others_phone_no` varchar(255) DEFAULT NULL,
  `current_address` varchar(255) DEFAULT NULL,
  `permanent_address` varchar(255) DEFAULT NULL,
  `joining_letter` varchar(255) DEFAULT NULL,
  `accessories` varchar(255) DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` VALUES (4,1,'','7738730913',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2022-01-20 17:33:11','2022-01-20 17:33:11'),(9,22,'2022_08_05_08_08_29_photo.jpg','7738730889','7738730917',NULL,NULL,NULL,NULL,'Hiranandani','Hiranandani','2022_08_05_08_16_34_ABC EMPORIA_PI_JUL_0001_22-23.pdf','Laptop','2022-01-20',1,'2022-01-20 06:02:04','2022-08-08 03:35:44'),(10,23,NULL,'7738730099','7738730091','7738730094','7738730093',NULL,'7738730095','Thane','Thane','RC909548_Invoice (6).pdf','Laptop','2022-01-21',1,'2022-01-21 06:54:40','2022-01-21 06:54:40'),(11,24,NULL,'9999999999',NULL,NULL,NULL,NULL,NULL,'Thane','Thane','RC909548_Invoice (1).pdf','Laptop','2022-01-21',1,'2022-01-20 22:16:52','2022-01-20 22:16:52'),(12,25,NULL,'3897298323',NULL,NULL,NULL,NULL,NULL,'Raunak heights','Raunak heights','Chapter 4.pdf','Laptop','2022-04-11',1,'2022-04-11 00:10:50','2022-04-11 00:10:50'),(13,26,'female-gccf65cb61_1280.png','9087654321',NULL,NULL,NULL,NULL,NULL,'Borivali EAST','Borivali EAST',NULL,NULL,'2022-04-27',1,'2022-04-26 21:04:16','2022-04-26 21:04:16'),(14,27,NULL,'7738732901',NULL,NULL,NULL,NULL,NULL,'Thane','Thane',NULL,NULL,'2022-05-03',1,'2022-05-03 05:22:46','2022-05-03 05:22:46'),(15,28,'images (1).jpg','9988765544',NULL,NULL,NULL,NULL,NULL,'Airoli','Airoli',NULL,NULL,'2022-05-07',1,'2022-05-07 00:49:15','2022-05-07 00:49:15'),(16,29,NULL,'8812304332',NULL,NULL,NULL,NULL,NULL,'Airoli','Airoli',NULL,NULL,'2022-06-09',1,'2022-06-09 04:13:04','2022-06-09 04:13:04');
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,1,'director',1,'2021-10-04 15:58:48','2022-03-30 04:56:33'),(2,1,'manager',1,'2021-10-04 15:58:56','2022-08-08 00:46:10'),(3,1,'executive',1,'2021-10-04 15:59:02','2022-10-15 22:55:04'),(4,1,'role 1',0,'2022-01-15 04:32:02','2022-01-15 04:32:21'),(5,1,'role 2',0,'2022-01-15 05:39:54','2022-01-15 05:39:54');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `firm_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `firm_id_ibfk_1` (`firm_id`),
  CONSTRAINT `firm_id_ibfk_1` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,1,'Darshan Mahajan','director@gmail.com','$2y$10$Sh2o6zesmjA9lSJJ9JaC3e0D8v27wqInf5hoLcZsIw0.45rUSsg2u',0,1,'2021-10-04 15:59:49','2021-10-04 15:59:49'),(22,2,1,'Test Manager 2','testmanager2@gmail.com','$2y$10$Sh2o6zesmjA9lSJJ9JaC3e0D8v27wqInf5hoLcZsIw0.45rUSsg2u',1,1,'2022-01-20 06:02:04','2022-08-08 03:35:44'),(23,3,1,'Test Executive','testexec@gmail.com','$2y$10$126Gp5NF63he6Xbz48otyuKX.7Iw7FSIFKBhW2XAmjEIFGO8ARLt2',22,1,'2022-01-21 06:54:40','2022-01-21 06:54:40'),(24,3,1,'Test Executive 3','testexec3@gmail.com','$2y$10$prR9lFk0Xyao/bFaFLCr8.ZfygjHhn/EVkeslLypgLFqQLiudOnUC',22,1,'2022-01-20 22:16:52','2022-10-02 03:47:08'),(25,2,2,'Aman Kumtakar','aman@gmail.com','$2y$10$AnDmBa5ncpyHx96h7zeek.v35HCTUnOXMQ3IEVz9MVRMYqr3VyMF.',1,1,'2022-04-11 00:10:50','2022-04-11 00:10:50'),(26,2,1,'Jinal Patel','jinal@gmail.com','$2y$10$Sh2o6zesmjA9lSJJ9JaC3e0D8v27wqInf5hoLcZsIw0.45rUSsg2u',1,1,'2022-04-26 21:04:16','2022-04-26 21:04:16'),(27,3,1,'Darshan','darshan.executive@gmail.com','$2y$10$HT9yEolvyd6iT2zL9sHShedOPBgPmJcm7BqrH2PdkV6MxPR9VmDya',26,1,'2022-05-03 05:22:46','2022-05-03 05:22:46'),(28,2,1,'Hemangi Patel','hemangi@gmail.com','$2y$10$eyKcpA658rJU6BQLj568zegywZ/t8y95SpBD/ioyquOu6z8ilUSDy',1,0,'2022-05-07 00:49:15','2022-05-07 00:49:15'),(29,3,2,'Hemangi Patel','hemangi@cog.com','$2y$10$arjgtf1FdhpYG2kVim7iluG18P.k9z2/h9dq1svyNTnQz/iiO053q',25,0,'2022-06-09 04:13:04','2022-08-05 05:36:42');
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

-- Dump completed on 2023-10-06  0:36:51
