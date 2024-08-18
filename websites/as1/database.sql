-- MySQL dump 10.16  Distrib 10.1.20-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: 127.0.0.1
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
-- Tables structure for tables `products , category, questions, reviews, admins and customers`
--

CREATE database IF NOT EXISTS techstoredb;
USE techstoredb;


DROP TABLE IF EXISTS `questions`;
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `category`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `admins`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;


CREATE TABLE `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `date_created` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11),
  `name` VARCHAR(200) NOT NULL,
  `description` VARCHAR(1000) DEFAULT NULL, 
  `manufacturer` VARCHAR(100) DEFAULT NULL,
  `price` DECIMAL(6,2) NOT NULL,
  `date_posted` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_picture_img` VARCHAR(150) DEFAULT '../images/banners/1.jpg', 
  PRIMARY KEY (`product_id`),
  FOREIGN KEY (`category_id`) REFERENCES category (`category_id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(50) NOT NULL,
  `surname` VARCHAR(50) NOT NULL,
  `password` VARCHAR(150) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `date_created` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(50) NOT NULL,
  `surname` VARCHAR(50) NOT NULL,
  `password` VARCHAR(150) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `date_created` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `question` VARCHAR(225) DEFAULT NULL, 
  `answer` VARCHAR(225) DEFAULT NULL, 
  `status` CHAR(40) NOT NULL DEFAULT 'pending',
  `visibility` CHAR(40) NOT NULL DEFAULT 'yes',
  `date_posted` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`question_id`),
  FOREIGN KEY (`product_id`) REFERENCES products (`product_id`),
  FOREIGN KEY (`customer_id`) REFERENCES customers (`customer_id`),
  FOREIGN KEY (`admin_id`) REFERENCES admins (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` VARCHAR(225) DEFAULT NULL, 
  `review` VARCHAR(225) DEFAULT NULL, 
  `rating` int(11) DEFAULT NULL,
  `status` CHAR(40) NOT NULL DEFAULT 'pending',
  `visibility` CHAR(40) NOT NULL DEFAULT 'yes',
  `date_posted` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  FOREIGN KEY (`product_id`) REFERENCES products (`product_id`),
  FOREIGN KEY (`customer_id`) REFERENCES customers (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for tables `products , category, questions, reviews,admins and customers`
--

INSERT INTO `category` VALUES 
(1, 'TVs', '2024-01-22'),
(2, 'Phones', '2024-01-22'),
(3, 'PCs', '2024-01-22')
;

INSERT INTO `products` VALUES 
(1, 1,'Samsung CF390 27" 16:9 Curved LCD FHD 1920x1080 Curved Desktop Black Monitor', 'Setting up this Samsung monitor is simple as it comes equipped with both HDMI and VGA inputs. Once configured 
viewers can take advantage of the Full HD 1920 x 1080 resolution display complete with a 3,000:1 contrast ratio, a 250 cd/m² brightness rating, and a 4 ms response time for a clear picture wi
th reduced ghosting and blur. This 27" Curved Samsung monitor can also be mounted to the wall using a 75 x 75mm mount, 
and with 178° horizontal and vertical viewing angles the screen can be viewed from virtually any angle.', 'Samsung', 99.99, '2023-01-05', '../uploaded-images/samsung_tv.png'),

(2, 1,'LG FHD 32-Inch Computer Monitor 32ML600M-B, IPS with HDR 10 Compatibility, Black', 'Enjoy incredible detail and image clarity with Full HD 1080p resolution. This versatile IPS computer monitor
 helps keep colors consistent at a wide viewing angle while reproducing 95 percent coverage of the DCI-P3 color gamut. Color Calibration helps maintain accurate color on the screen and prevents 
 gradual changes. Stay in the game as you take fast, easy control of essential monitor settings including picture, audio and Screen Split with just a few clicks of your mouse with On-Screen Control', 'LG', 129.99, '2023-06-05', '../uploaded-images/LG_tv.png'),

(3, 2,'Iphone 14 Pro Max', 'iPhone 14 Pro Max. Capture incredible detail with a 48MP Main camera. Experience iPhone in a whole new way with Dynami
c Island and Always-On display. Crash Detection, a new safety feature, calls for help when you can’t.', 'Apple', 729.99, '2023-08-05', '../uploaded-images/iphone_14_pro_max.png'),

(4, 3,'Gaming PC', 'NVIDIA® GeForce RTX® 40 Series GPUs are beyond fast for gamers and creators. Theyre powered by the ultra-efficient NVIDIA Ada Lovelace architecture which delivers 
a quantum leap in both performance and AI-powered graphics. Experience lifelike virtual worlds with ray tracing and ultra-high FPS gaming with the lowest latency. Discover revolutionary 
new ways to create and unprecedented workflow acceleration.', 'PC Specialist', 929.99, '2023-09-05', '../uploaded-images/gaming_pc.png')
;

INSERT INTO `customers` VALUES 
(1,'Josh', 'Allen', 'testing1', 'JoshAllen@gmail.com', '2024-01-22'),
(2,'James', 'Stock', 'testing2', 'JamesStock@gmail.com', '2024-01-22'),
(3,'Elliot', 'Smith', 'testing3' , 'ElliotSmith@yahoo.com', '2024-01-22'),
(4,'Lily', 'Rose', 'testing4' , 'LilyRose@outlook.com', '2024-01-22')
;

INSERT INTO `admins` VALUES 
(1,'admin', '1', '$2y$10$nak43Xll.3TPEB9SA.acve2xfW8Tky0rlNcmG1HZqIu48LxTnXL6O' , 'testing00@gmail.com', '2024-01-22'),
(2,'admin', '2', '$2y$10$nak43Xll.3TPEB9SA.acve2xfW8Tky0rlNcmG1HZqIu48LxTnXL6O' , 'testing01@gmail.com', '2024-01-22')
;

INSERT INTO `questions` VALUES 
(1, 1, 1, 1, 'Whats the size of this Monitor?', 'The Size of this monitor is 27 inches.', 'verified', 'yes', '2024-01-22'),
(2, 3, 1, 2, 'Does this monitor support HDR 10?', 'No, this monitor does not support HDR 10.', 'verified', 'yes', '2024-01-22'),
(3, 3, 1, 2, 'What is the Resolution of this Monitor?', '', 'pending', 'no', '2024-01-22'),
(4, 3, 1, 2, 'Is this Monitor Curved?', 'Yes this Monitor is Curved.', 'verified', 'no', '2024-01-22'),
(5, 2, 2, 1, 'Does this monitor support HDR 10?', 'Yes, this monitor does support HDR 10.', 'verified', 'yes', '2024-01-22')
;

INSERT INTO `reviews` VALUES 
(1, 1, 1, 'Good monitor. Works on PC and Mac', 'I needed an extra monitor to manage the windows on my work computer. It works well. I say good because I am not a 
pro on the ends and outs of a good monitor. Works on PC and Mac. .', 4, 'verified', 'yes', '2024-01-22')

;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-14 16:36:07
