SET NAMES utf8mb4;
SET TIME_ZONE='+00:00';
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

--
-- Remove existing database, if any, and then create an empty database
--

DROP DATABASE IF EXISTS `final_year_db`;

CREATE DATABASE IF NOT EXISTS final_year_db COLLATE utf8_unicode_ci;

--
-- Create the user account
--
GRANT ALL PRIVILEGES ON final_year_db.* TO 'final_year_user'@localhost IDENTIFIED BY 'final_year_pass';

USE final_year_db;

DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `order_detail`;

-- users tables

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Member', 'Admin') NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `customers` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`customer_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` TEXT,
  `stock` int(10) NOT NULL,
  `price` varchar(5) NOT NULL,
  `product_image` varchar(255),
  PRIMARY KEY (`product_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `order_detail` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
  `desc` TEXT,
  `total` DECIMAL(7,2) NOT NULL,
  `address` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_assigned` int(10) unsigned NOT NULL,
  `status` ENUM('Processing', 'Building', 'Dispatched', 'Cancelled') NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`order_id`),
  FOREIGN KEY (`admin_assigned`) REFERENCES `users`(`user_id`),
  FOREIGN KEY (`customer_id`) REFERENCES `customers`(`customer_id`)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


FLUSH PRIVILEGES;

-- Intel Motherboards
INSERT INTO `products` VALUES ('1', 'MSI Z390-A PRO LGA 1151 SATA 6GBs ATX', 'Intel-Motherboard', 'Empty', '10', '110', '');
INSERT INTO `products` VALUES ('2', 'Asus ROG STRIX Z390-F LGA 1151 SATA 6GBs', 'Intel-Motherboard', 'Empty', '10', '240', '');
INSERT INTO `products` VALUES ('3', 'Asus TUF H370-PRO LGA 1151 SATA 6GBs', 'Intel-Motherboard', 'Empty', '10', '130', '');
INSERT INTO `products` VALUES ('4', 'Gigabyte H370 AORU LGA 1151 SATA 6GBs', 'Intel-Motherboard', 'Empty', '10', '145', '');

-- AMD Motherboards
INSERT INTO `products` VALUES ('5', 'Asus ROG STRIX B450-F SATA 6GBs', 'AMD-Motherboard', 'Empty', '5', '110', '');
INSERT INTO `products` VALUES ('6', 'MSI AMD Ryzen B450-A PRO MAX SATA 6GBs', 'AMD-Motherboard', 'Empty', '3', '82', '');
INSERT INTO `products` VALUES ('7', 'Asus ROG STRIX B450-E SATA 6GBs', 'AMD-Motherboard', 'Empty', '3', '135', '');

-- Mid Towers
INSERT INTO `products` VALUES ('8', 'Corsair Carbide Series 275R Mid-Tower White Acrylic Window Gaming Case',
                               'Case', 'Empty', '5', '60', '');
INSERT INTO `products` VALUES ('9', 'AvP Kolus RGB Mid Tower Black Case', 'Case',
                               'Empty', '5', '24', '');
INSERT INTO `products` VALUES ('10', 'EG Promethium Case', 'Case', 'Empty', '5', '30', '');
INSERT INTO `products` VALUES ('11', 'Bitfenix Nova Midi Tower Case - Black Window', 'Case',
                               'Empty', '5', '40', '');
INSERT INTO `products` VALUES ('12', 'Riotoro CR400 ATX Mid-Tower Case', 'Case', 'Empty',
                               '7', '43', '');
INSERT INTO `products` VALUES ('13', 'EG Wider X1 ATX Case', 'Case', 'Empty', '3', '25', '');
INSERT INTO `products` VALUES ('14', 'Aerocool Bolt Windowed RGB Midi PC Gaming Case', 'Case',
                               'Empty', '9', '34', '');

-- RAM
INSERT INTO `products` VALUES ('15', 'Corsair Vengeance LPX DDR4 2400MHz 1x4GB', 'RAM',
                               'DDR4 1x4GB Memory Module', '11', '21', '');
INSERT INTO `products` VALUES ('16', 'Corsair Vengeance LPX DDR4 2400MHz 1x8GB', 'RAM',
                               'DDR4 1x8GB Memory Module', '11', '41', '');
INSERT INTO `products` VALUES ('17', 'Corsair Vengeance LPX DDR4 2400MHz 2x4GB', 'RAM',
                               'DDR4 2x4GB Memory Module', '11', '39.98', '');
INSERT INTO `products` VALUES ('18', 'Corsair Vengeance LPX DDR4 2400MHz 1x16GB', 'RAM',
                               'DDR4 1x16GB Memory Module', '11', '69.84', '');
INSERT INTO `products` VALUES ('19', 'Corsair Vengeance LPX DDR4 2400MHz 2x8GB', 'RAM',
                               'DDR4 2x8GB Memory Module', '11', '86.30', '');
INSERT INTO `products` VALUES ('20', 'Corsair Vengeance LPX DDR4 2400MHz 2x16GB', 'RAM',
                               'DDR4 2x16GB Memory Module', '11', '120', '');

-- RAM 2666MHz

INSERT INTO `products` VALUES ('22', 'Corsair Vengeance LPX DDR4 2666MHz 1x8GB', 'RAM',
                               'DDR4 1x8GB Memory Module', '11', '44', '');
INSERT INTO `products` VALUES ('23', 'Corsair Vengeance LPX DDR4 2666MHz 2x4GB', 'RAM',
                               'DDR4 2x4GB Memory Module', '11', '39.98', '');
INSERT INTO `products` VALUES ('24', 'Corsair Vengeance LPX DDR4 2666MHz 1x16GB', 'RAM',
                               'DDR4 1x16GB Memory Module', '11', '66.17', '');
INSERT INTO `products` VALUES ('25', 'Corsair Vengeance LPX DDR4 2666MHz 2x8GB', 'RAM',
                               'DDR4 2x8GB Memory Module', '11', '95.16', '');
INSERT INTO `products` VALUES ('26', 'Corsair Vengeance LPX DDR4 2666MHz 2x16GB', 'RAM',
                               'DDR4 2x16GB Memory Module', '11', '160.49', '');

-- RAM 3000MHz
INSERT INTO `products` VALUES ('27', 'Corsair Vengeance LPX DDR4 3000MHz 1x8GB', 'RAM',
                               'DDR4 1x8GB Memory Module', '7', '36', '');
INSERT INTO `products` VALUES ('28', 'Corsair Vengeance LPX DDR4 3000MHz 2x8GB', 'RAM',
                               'DDR4 2x8GB Memory Module', '9', '73', '');
INSERT INTO `products` VALUES ('29', 'Corsair Vengeance LPX DDR4 3000MHz 2x16GB', 'RAM',
                               'DDR4 2x16GB Memory Module', '2', '133.49', '');
INSERT INTO `products` VALUES ('30', 'Corsair Vengeance LPX DDR4 3000MHz 2x16GB', 'RAM',
                               'DDR4 2x16GB Memory Module', '5', '133.49', '');
INSERT INTO `products` VALUES ('31', 'Corsair Vengeance LPX DDR4 3000MHz 2x16GB', 'RAM',
                               'DDR4 2x32GB Memory Module', '3', '260', '');

-- Power supply
INSERT INTO `products` VALUES ('32', 'Corsair VS Series 350 Watt Power Supply ', 'Power-Supply',
                               'Empty', '4', '34.49', '');
INSERT INTO `products` VALUES ('33', 'Corsair CX Series CX450M 450W 80 Plus Bronze Certified Modular ATX PSU',
                               'Power-Supply', 'Empty', '7', '55', '');
INSERT INTO `products` VALUES ('34', 'Corsair VS Series VS550 ATX Power Supply', 'Power-Supply',
                               'Empty', '3', '35', '');
INSERT INTO `products` VALUES ('35', 'Corsair VS Series VS650 650W Power Supply 80 Plus', 'Power-Supply',
                               'Empty', '13', '59', '');
INSERT INTO `products` VALUES ('36', 'EVGA 750w G3 80+ Modular Gold', 'Power-Supply', 'Empty',
                               '5', '114', '');
INSERT INTO `products` VALUES ('37', 'Corsair TX850M 80 PLUS Bronze Certified 850 Watts', 'Power-Supply',
                               'Empty', '8', '110', '');
INSERT INTO `products` VALUES ('38', 'EVGA 850 B3 850W Modular 80+ Bronze PSU', 'Power-Supply',
                               'Empty', '12', '111', '');
INSERT INTO `products` VALUES ('39', 'Evga 1000w G3 80+ Modular Gold', 'Power-Supply', 'Empty',
                               '18', '180', '');

-- cooling fan
INSERT INTO `products` VALUES ('40','Default CPU Cooler', 'Cooler', 'Empty', '30', '10', '');
INSERT INTO `products` VALUES ('41', 'Cooler Master Hyper 212 Evo Processor Cooler', 'Cooler',
                               'Empty', '14', '28', '');
INSERT INTO `products` VALUES ('42', 'EG GI-X6R 160W CPU Cooler X6 with Red Colour Ring Fan ', 'Cooler',
                               'Empty', '9', '16.99', '');
INSERT INTO `products` VALUES ('43', 'Cooler Master Hyper TX3 EVO 3 Heatpipes Fan CPU Air Cooler',
                               'Cooler', 'Empty', '19', '41', '');
INSERT INTO `products` VALUES ('44', 'Coolermaster Hyper H412R Tower CPU Cooler', 'Cooler', 'Empty',
                               '7', '25.58', '');

-- AMD Processor

INSERT INTO `products` VALUES ('45', 'AMD Ryzen 3 3200G Processor 3.6-4.0GHZ Quad-Core', 'AMD-Processor',
                               'Empty', '12', '82', '');
INSERT INTO `products` VALUES ('46', 'AMD Ryzen 5 3400G Processor 3.8-4.2GHz Quad-Core', 'AMD-Processor',
                               'Empty', '10', '130', '');
INSERT INTO `products` VALUES ('47', 'AMD Ryzen 5 3600 Processor 3.6-4.2GHz Hexa-Core', 'AMD-Processor',
                               'Empty', '9', '150', '');
INSERT INTO `products` VALUES ('48', 'AMD Ryzen 7 2700X Processor 3.7-4.3GHz Octa-Core', 'AMD-Processor',
                               'Empty', '13', '159', '');
INSERT INTO `products` VALUES ('49', 'AMD Ryzen 5 3600X Processor 3.8-4.4GHZ Hexa-Core', 'AMD-Processor',
                               'Empty', '8', '180', '');
INSERT INTO `products` VALUES ('50', 'AMD Ryzen 7 3700X Processor 3.6-4.4GHZ Octa-Core', 'AMD-Processor',
                               'Empty', '4', '260', '');
INSERT INTO `products` VALUES ('51', 'AMD Ryzen 7 3800X Processor 3.9-4.5GHz Octa-Core', 'AMD-Processor',
                               'Empty', '4', '309', '');
INSERT INTO `products` VALUES ('52', 'AMD Ryzen 9 3900X Processor 3.8-4.6GHz 12-Core', 'AMD-Processor',
                               'Empty', '5', '420', '');

-- Intel Processor
INSERT INTO `products` VALUES('53', 'Intel Core i3 8100 Quad Core Socket 1151 3.60GHz Processor', 'Intel-Processor',
                              'Empty', '4', '106', '');
INSERT INTO `products` VALUES('54', 'Intel Core i3 8300 Quad Core 3.7GHz Processor', 'Intel-Processor', 'Empty',
                              '4', '130', '');
INSERT INTO `products` VALUES('55', 'Intel Core i3 9350KF Quad Core 4.0GHz Processor', 'Intel-Processor', 'Empty',
                              '4', '140', '');
INSERT INTO `products` VALUES('56', 'Intel Core i5 9600K Hexa-Core 3.7 GHz Processor', 'Intel-Processor', 'Empty',
                              '4', '200', '');
INSERT INTO `products` VALUES('57', 'Intel Core i5 8600K 3.6GHz Hexa-Core Processor', 'Intel-Processor', 'Empty',
                              '4', '210', '');
INSERT INTO `products` VALUES('58', 'Intel Core i7 9700 3.00GHz Octa Core Processor', 'Intel-Processor', 'Empty',
                              '4', '300', '');
INSERT INTO `products` VALUES('59', 'Intel Core i7 9700KF 3.6GHz Octa Core Processor', 'Intel-Processor', 'Empty',
                              '4', '340', '');
INSERT INTO `products` VALUES('60', 'Intel Core i9 9900 3.10 GHz Octa Core Processor', 'Intel-Processor', 'Empty',
                              '4', '420', '');

-- Harddrive
INSERT INTO `products` VALUES('61', '128GB Solid State Drive', 'Storage', 'Empty', '5', '25', '');
INSERT INTO `products` VALUES('62', '250GB Solid State Drive', 'Storage', 'Empty', '5', '39', '');
INSERT INTO `products` VALUES('63', '500GB Solid State Drive', 'Storage', 'Empty', '5', '75', '');
INSERT INTO `products` VALUES('64', '1TB Solid State Drive', 'Storage', 'Empty', '5', '150', '');

-- Graphics Card
INSERT INTO `products` VALUES('65', '1GB NVIDIA GEFORCE 710', 'Graphics-Card', 'Empty', '5', '30', '');
INSERT INTO `products` VALUES('66', '2GB NVIDIA GEFORCE 1030', 'Graphics-Card', 'Empty', '5', '65', '');
INSERT INTO `products` VALUES('67', '4GB NVIDIA GEFORCE GTX 1650', 'Graphics-Card', 'Empty', '5', '130', '');
INSERT INTO `products` VALUES('68', '6GB NVIDIA GEFORCE GTX 1660', 'Graphics-Card', 'Empty', '5', '180', '');