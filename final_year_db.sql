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

DROP TABLE IF EXISTS `messages`;
DROP TABLE IF EXISTS `order_detail`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `users`;


-- users tables

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Member', 'Admin', 'Root') NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `customers` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`customer_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
  ON DELETE CASCADE
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` TEXT,
  `stock` int(10) NOT NULL,
  `price` varchar(7) NOT NULL,
  `product_image` varchar(255),
  PRIMARY KEY (`product_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `order_detail` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_date` varchar(64) NOT NULL,
  `description` TEXT,
  `total` DECIMAL(7,2) NOT NULL,
  `quantity` int(10) NOT NULL,
  `admin_assigned` int(10) unsigned NOT NULL,
  `status` ENUM('Processing', 'Building', 'Dispatched', 'Cancelled') NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`order_id`),
  FOREIGN KEY (`admin_assigned`) REFERENCES `users`(`user_id`),
  FOREIGN KEY (`customer_id`) REFERENCES `customers`(`customer_id`) ON DELETE CASCADE
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



FLUSH PRIVILEGES;

-- Intel Motherboards
INSERT INTO `products` VALUES ('1', 'MSI Z390-A PRO LGA 1151 SATA 6GBs ATX', 'Intel-Motherboard', '    Socket LGA 1151
    9th Generation Intel
    DDR4 4400 (OC)
    ATX Form Factor', '10', '110', '/finalyearproject/media/motherboards/721077-711063-800.jpg');
INSERT INTO `products` VALUES ('2', 'Asus ROG STRIX Z390-F LGA 1151 SATA 6GBs', 'Intel-Motherboard', '    Socket LGA 1151
    9th Generation Intel
    DDR4
    ATX Form Factor', '10', '240', '/finalyearproject/media/motherboards/890616-862120-800.jpg');
INSERT INTO `products` VALUES ('3', 'Asus TUF H370-PRO LGA 1151 SATA 6GBs', 'Intel-Motherboard', '    Socket LGA 1151
    Intel 8th Generation
    DDR4 Support
    ATX Form Factor', '10', '130', '/finalyearproject/media/motherboards/866382-833317-800.jpg');
INSERT INTO `products` VALUES ('4', 'Gigabyte H370 AORU LGA 1151 SATA 6GBs', 'Intel-Motherboard', '    Socket LGA 1151
    Intel 8th Generation
    DDR4 Support
    ATX Form Factor', '10', '145', '/finalyearproject/media/motherboards/922089-837915-800.jpg');

-- AMD Motherboards
INSERT INTO `products` VALUES ('5', 'Asus ROG STRIX B450-F SATA 6GBs', 'AMD-Motherboard', 'AM4 socket: Ready for AMD Ryzen™ processors

Fast memory and storage: Dual-channel DDR4 3200MHz (OC) and NVM Express® RAID supported.

Aura Sync RGB: Synchronize LED lighting with a vast portfolio of compatible PC gear.

Gaming connectivity: Dual M.2 and USB 3.1 Gen 2 Type-A connectors.', '5', '110', '/finalyearproject/media/motherboards/61Wrp3hrfKL._AC_SL1000_.jpg');
INSERT INTO `products` VALUES ('6', 'MSI AMD Ryzen B450-A PRO MAX SATA 6GBs', 'AMD-Motherboard', '    Socket AM4
    Supports RYZEN 3rd Gen
    DDR4 Support
    ATX Form Factor', '3', '82', '/finalyearproject/media/motherboards/61+7jAOYBpL._AC_SL1024_.jpg');
INSERT INTO `products` VALUES ('7', 'Asus ROG STRIX B450-E SATA 6GBs', 'AMD-Motherboard', '    Socket AMD
    Ryzen 2nd Gen
    DDR4 3533 MHz OC
    ATX Form Factor', '3', '135', '/finalyearproject/media/motherboards/918382-881461-800.jpg');

-- Mid Towers
INSERT INTO `products` VALUES ('8', 'Corsair Carbide Series 275R Mid-Tower Black Acrylic Window Gaming Case',
                               'Case', '    Clean and Minimalist Design
    Black Acrylic Window
    Builder-Friendly Internal Layout
    Expansive Storage Space
    Direct Airflow Cooling', '5', '60', '/finalyearproject/media/mid-tower/886449-834998-800.jpg');
INSERT INTO `products` VALUES ('9', 'AvP Opius Mid Tower Black Case', 'Case',
                               '    2 x 3.5" Internal Drive Bays
    2 x 2.5" Internal Drive Bays
    Max MB Size: ATX
    Tempered Glass', '5', '24', '/finalyearproject/media/mid-tower/939361-912979-800.jpg');
INSERT INTO `products` VALUES ('10', 'EG Promethium Case', 'Case', '    USB 3.0 Support
    Motherboard: ATX, Micro-ATX
    Tempered Glass Side Panel
    RGB Fan Included', '5', '30', '/finalyearproject/media/mid-tower/942802-919712-800.jpg');
INSERT INTO `products` VALUES ('11', 'Bitfenix Nova Midi Tower Case - Black Window', 'Case',
                               '    ATX, Micro ATX, Mini-ITX (7 expansion slots)
    Acrylic Side Window
    (WxHxD): 183 x 437 x 465 mm
    1 Pre-installed 120mm Rear Fan', '5', '40', '');
INSERT INTO `products` VALUES ('12', 'Xigmatek Eros RGB Mid Tower Case', 'Case', '    Tempered Glass Side Panel.
    Effective Heat Dissipation.
    Liquid Cooling Compatibility.
    Bottom PSU Mount.',
                               '7', '30', '/finalyearproject/media/mid-tower/952910-959087-800.jpg');
INSERT INTO `products` VALUES ('13', 'EG Argon ATX RGB Tower Gaming Case', 'Case', '    3 x RGB Fans Included
    USB 3.0 Support
    ATX,MATX,ITX
    Plastic mesh bezel
    Dark Mirror Tempered Glass', '3', '52', '/finalyearproject/media/mid-tower/941833-919141-800.jpg');
INSERT INTO `products` VALUES ('14', 'Aerocool Shard RGB Windowed Mid Tower Case', 'Case',
                               '    Windowed Side Panel
    ATX | Micro-ATX | Mini-ITX
    Radiator Support: 120/240mm
    GPU Max Length: 355mm
    CPU Cooler Height Limit: 155mm', '9', '48', '/finalyearproject/media/mid-tower/962793-964803-800.jpg');

-- RAM
INSERT INTO `products` VALUES ('15', 'Corsair Vengeance LPX DDR4 2400MHz 1x4GB', 'RAM',
                               'DDR4 1x4GB Memory Module', '11', '21', '/finalyearproject/media/Ram/672239-711714-800.jpg');
INSERT INTO `products` VALUES ('16', 'Corsair Vengeance LPX DDR4 2400MHz 1x8GB', 'RAM',
                               'DDR4 1x8GB Memory Module', '11', '41', '/finalyearproject/media/Ram/928761-743023-800.jpg');
INSERT INTO `products` VALUES ('17', 'Corsair Vengeance LPX DDR4 2400MHz 2x4GB', 'RAM',
                               'DDR4 2x4GB Memory Module', '11', '39.98', '/finalyearproject/media/Ram/689071-719494-800.jpg');
INSERT INTO `products` VALUES ('18', 'Corsair Vengeance LPX DDR4 2400MHz 1x16GB', 'RAM',
                               'DDR4 1x16GB Memory Module', '11', '69.84', '/finalyearproject/media/Ram/865778-833649-800.jpg');
INSERT INTO `products` VALUES ('19', 'Corsair Vengeance LPX DDR4 2400MHz 2x8GB', 'RAM',
                               'DDR4 2x8GB Memory Module', '11', '86.30', '/finalyearproject/media/Ram/926385-737132-800.jpg');
INSERT INTO `products` VALUES ('20', 'Corsair Vengeance LPX DDR4 2400MHz 2x16GB', 'RAM',
                               'DDR4 2x16GB Memory Module', '11', '120', '/finalyearproject/media/Ram/926385-737132-800.jpg');

-- RAM 2666MHz

INSERT INTO `products` VALUES ('22', 'Corsair Vengeance LPX DDR4 2666MHz 1x8GB', 'RAM',
                               'DDR4 1x8GB Memory Module', '11', '44', '/finalyearproject/media/Ram/688896-719387-800.jpg');
INSERT INTO `products` VALUES ('23', 'Corsair Vengeance LPX DDR4 2666MHz 2x4GB', 'RAM',
                               'DDR4 2x4GB Memory Module', '11', '39.98', '/finalyearproject/media/Ram/926385-737132-800.jpg');
INSERT INTO `products` VALUES ('24', 'Corsair Vengeance LPX DDR4 2666MHz 1x16GB', 'RAM',
                               'DDR4 1x16GB Memory Module', '11', '66.17', '/finalyearproject/media/Ram/688896-719387-800.jpg');
INSERT INTO `products` VALUES ('25', 'Corsair Vengeance LPX DDR4 2666MHz 2x8GB', 'RAM',
                               'DDR4 2x8GB Memory Module', '11', '95.16', '/finalyearproject/media/Ram/926385-737132-800.jpg');
INSERT INTO `products` VALUES ('26', 'Corsair Vengeance LPX DDR4 2666MHz 2x16GB', 'RAM',
                               'DDR4 2x16GB Memory Module', '11', '160.49', '/finalyearproject/media/Ram/926385-737132-800.jpg');

-- RAM 3000MHz
INSERT INTO `products` VALUES ('27', 'Corsair Vengeance LPX DDR4 3000MHz 1x8GB', 'RAM',
                               'DDR4 1x8GB Memory Module', '7', '36', '/finalyearproject/media/Ram/688896-719387-800.jpg');
INSERT INTO `products` VALUES ('28', 'Corsair Vengeance LPX DDR4 3000MHz 2x8GB', 'RAM',
                               'DDR4 2x8GB Memory Module', '9', '73', '/finalyearproject/media/Ram/926385-737132-800.jpg');
INSERT INTO `products` VALUES ('29', 'Corsair Vengeance LPX DDR4 3000MHz 2x16GB', 'RAM',
                               'DDR4 2x16GB Memory Module', '2', '133.49', '/finalyearproject/media/Ram/926385-737132-800.jpg');
INSERT INTO `products` VALUES ('30', 'Corsair Vengeance LPX DDR4 3000MHz 2x16GB', 'RAM',
                               'DDR4 2x16GB Memory Module', '5', '133.49', '/finalyearproject/media/Ram/926385-737132-800.jpg');
INSERT INTO `products` VALUES ('31', 'Corsair Vengeance LPX DDR4 3000MHz 2x16GB', 'RAM',
                               'DDR4 2x32GB Memory Module', '3', '260', '/finalyearproject/media/Ram/926385-737132-800.jpg');

-- Power supply
INSERT INTO `products` VALUES ('32', 'Aerocool Cylon 500W Power Supply 80 Plus ', 'Power-Supply',
                               '    80Plus 230V EU Standard Certified for up to 85%+ efficiency
    Silent 12cm black fan with optimized thermal fan speed control', '4', '34.49', '/finalyearproject/media/power-supply/965782-964797-800.jpg');
INSERT INTO `products` VALUES ('33', 'Be Quiet SFX Power 2 300W Fully Wired 80+ Bronze Power Supply',
                               'Power-Supply', '    Black Coloured PSU with a 80mm Silent Cooling Fan
    Equipped with a Dual 12v Rail Delivering upto Amps
    Equipped with 1 PCI-E Connectors for Graphics Cards', '7', '55', '/finalyearproject/media/power-supply/604778-620499-800.jpg');
INSERT INTO `products` VALUES ('34', 'Corsair VS Series VS550 ATX Power Supply', 'Power-Supply',
                               ' 80 PLUS efficiency: Runs cooler and uses less power than non-certified power supplies
3-year warranty: Backed by CORSAIR’s legendary technical support and customer service
Black housing, cable sleeves and connectors: Give your build the high-end look without breaking the bank
Thermally controlled 120mm fan: Quiet operation across a wide range of loads
Continuous output rated temperature C: 30°C ', '3', '35',
                               '/finalyearproject/media/power-supply/-CP-9020171-UK-Gallery-VS550-PSU-01.png');
INSERT INTO `products` VALUES ('35', 'Corsair VS Series VS650 650W Power Supply 80 Plus', 'Power-Supply',
                               ' 80 PLUS efficiency: Runs cooler and uses less power than non-certified power supplies
3-year warranty: Backed by CORSAIR’s legendary technical support and customer service
Black housing, cable sleeves and connectors: Give your build the high-end look without breaking the bank
Thermally controlled 120mm fan: Quiet operation across a wide range of loads
Continuous output rated temperature: 30°C ', '13', '59', '/finalyearproject/media/motherboards/81LJpoP-uqL._AC_SL1500_.jpg');
INSERT INTO `products` VALUES ('36', 'EVGA 750w G3 80+ Modular Gold', 'Power-Supply', '    Unbeatable 10 Year Warranty
    80 PLUS Gold certified
    Fully Modular
    Hydraulic Dynamic Bearing Fan',
                               '5', '114', '/finalyearproject/media/power-supply/782560-767601-800.jpg');
INSERT INTO `products` VALUES ('37', 'Corsair TX850M 80 PLUS Bronze Certified 850 Watts', 'Power-Supply',
                               '80 PLUS Gold efficiency reduces operating cost and excess heat', '8', '110',
                               '/finalyearproject/media/power-supply/-CP-9020130-NA-Gallery-TX850M-01.png');
INSERT INTO `products` VALUES ('38', 'EVGA 850 B3 850W Modular 80+ Bronze PSU', 'Power-Supply',
                               'Quiet and Intelligent Auto Fan for near-silent operation
Fan Size / Bearing 140mm Teflon Nano-Steel Bearing', '12', '111', '/finalyearproject/media/power-supply/71aEOq0HIXL._AC_SL1200_.jpg');
INSERT INTO `products` VALUES ('39', 'Evga 1000w G3 80+ Modular Gold', 'Power-Supply', '    Unbeatable 10 Year Warranty
    80 PLUS Gold certified
    Hydraulic Dynamic Bearing Fan
    Fully Modular',
                               '18', '180', '/finalyearproject/media/power-supply/782564-767602-800.jpg');

-- cooling fan
INSERT INTO `products` VALUES ('40','Default CPU Cooler', 'Cooler', 'This product is only available for custom builds', '30', '10', '');
INSERT INTO `products` VALUES ('41', 'Corsair Hydro Series H60 120mm Liquid CPU Cooler', 'Cooler',
                               '    Cooler, Quieter & More Controlled#
    Precise PVM Control
    120mm High Density Radiator
    LED Illuminated Pump Head
    Efficient Cold Plate and Pump', '14', '28', '/finalyearproject/media/cooler/873393-835158-800.jpg');
INSERT INTO `products` VALUES ('42', 'EG GI-X6R 160W CPU Cooler X6 with Red Colour Ring Fan ', 'Cooler',
                               '    120mm Corona LED fan
    CPU - AMD/Intel MB
    6mm heat-pipes
    35 - 65 CFM
    SilentPro PWM fan', '9', '16.99', '/finalyearproject/media/cooler/913925-879083-800.jpg');
INSERT INTO `products` VALUES ('43', 'Cooler Master Hyper 212 Evo Processor Cooler',
                               'Cooler', '    4 Direct Contact heat pipes
    Versatile all-in-one mounting solution
    Wide-range PWM fan
    AMD & Intel Compatible', '19', '28', '/finalyearproject/media/cooler/794112-288855-800.jpg');
INSERT INTO `products` VALUES ('44', 'Coolermaster Hyper H412R Tower CPU Cooler', 'Cooler', '    4 Direct Contact heat pipes
    Versatile all-in-one mounting solution
    Wide-range PWM fan
    AMD & Intel Compatible',
                               '7', '25.58', '/finalyearproject/media/cooler/794112-288855-800.jpg');

-- AMD Processor

INSERT INTO `products` VALUES ('45', 'AMD Ryzen 3 3200G Processor 3.6-4.0GHZ Quad-Core', 'AMD-Processor',
                               '    Ryzen 3 3200G
    4 Cores, 4 Threads
    Boost Clock 4GHz
    Vega 8 Graphics', '12', '82', '/finalyearproject/media/amd-processor/929907-883797-800.jpg');
INSERT INTO `products` VALUES ('46', 'AMD Ryzen 5 3400G Processor 3.8-4.2GHz Quad-Core', 'AMD-Processor',
                               ' Includes Radeon RX Vega 11, the world''s most powerful graphics on a desktop Processor, no expensive Graphics card required
Can deliver smooth high definition Performance in the world''s most popular games
4 Cores and 8 processing threads, bundled with the powerful AMD Wraith Spire cooler
4. 2 GHz Max Boost, unlocked for overclocking, 6 MB Cache, DDR 2933 support
For the advanced socket AM4 platfo', '10', '130', '/finalyearproject/media/amd-processor/929328-883792-800.jpg');
INSERT INTO `products` VALUES ('47', 'AMD Ryzen 5 3600 Processor 3.6-4.2GHz Hexa-Core', 'AMD-Processor',
                               '    Ryzen 5 3600
    6 Cores, 12 Threads
    Boost Clock 4.2GHz', '9', '150', '/finalyearproject/media/amd-processor/929272-883794-800.jpg');
INSERT INTO `products` VALUES ('48', 'AMD Ryzen 7 2700 Processor 3.2-4.1GHz Octa-Core', 'AMD-Processor',
                               '    Ryzen 7 2700
    8 Core, 16 Thread
    3.2GHz, 4.1GHz Turbo
    LED Wraith Spire Cooler', '13', '120', '/finalyearproject/media/amd-processor/929661-883788-800.jpg');
INSERT INTO `products` VALUES ('49', 'AMD Ryzen 5 3600X Processor 3.8-4.4GHZ Hexa-Core', 'AMD-Processor',
                               '    Ryzen 5 3600X
    6 Cores, 12 Threads
    Boost Clock 4.4GHz', '8', '180', '/finalyearproject/media/amd-processor/929272-883794-800.jpg');
INSERT INTO `products` VALUES ('50', 'AMD Ryzen 7 3700X Processor 3.6-4.4GHZ Octa-Core', 'AMD-Processor',
                               '    Ryzen 7 3700X
    8 Cores, 16 Threads
    Boost Clock 4.4GHz', '4', '299', '/finalyearproject/media/amd-processor/929277-883790-800.jpg');
INSERT INTO `products` VALUES ('51', 'AMD Ryzen 7 3800X Processor 3.9-4.5GHz Octa-Core', 'AMD-Processor',
                               '    Ryzen 7 3800X
    8 Cores, 16 Threads
    Boost Clock 4.5GHz', '4', '350', '/finalyearproject/media/amd-processor/869569-830814-800.jpg');
INSERT INTO `products` VALUES ('52', 'AMD Ryzen 9 3900X Processor 3.8-4.6GHz 12-Core', 'AMD-Processor',
                               '    Ryzen 9 3900X
    12 Cores, 24 Threads
    Boost Clock 4.6GHz', '5', '440', '/finalyearproject/media/amd-processor/929281-883787-800.jpg');

-- Intel Processor
INSERT INTO `products` VALUES('53', 'Intel Core i3 8100 Quad Core Socket 1151 3.60GHz Processor', 'Intel-Processor',
                              '    Intel Coffee Lake
    i3 8100
    Quad Core
    3.60GHz', '4', '106', '/finalyearproject/media/intel-processor/61ZMffpkQKL._AC_SL1200_.jpg');
INSERT INTO `products` VALUES('54', 'Intel Core i3 8300 Quad Core 3.7GHz Processor', 'Intel-Processor', '    Intel Core i3-8300
    4 Cores
    Socket 1151
    Integrated Graphics',
                              '4', '130', '/finalyearproject/media/intel-processor/867337-826165-800.jpg');
INSERT INTO `products` VALUES('55', 'Intel Core i3 9100F  Quad Core 3.6GHz Processor', 'Intel-Processor', '    i3 9100F
    Socket 1151
    Coffee Lake Refresh
    Max turbo 4.20 GHz',
                              '4', '73', '/finalyearproject/media/intel-processor/867337-826165-800.jpg');
INSERT INTO `products` VALUES('56', 'Intel Core i5 9600K Hexa-Core 3.7 GHz Processor', 'Intel-Processor', '    Intel Coffee Lake Refresh
    i5 9600K
    Socket 1151
    3.7GHz',
                              '4', '220', '/finalyearproject/media/intel-processor/890510-859396-800.jpg');
INSERT INTO `products` VALUES('57', 'Intel Core i5 10400F 4.8GHz Hexa-Core Processor', 'Intel-Processor', '    Intel Comet Lake
    i5-10400F
    Socket 1200
    4.8GHz',
                              '4', '180', '/finalyearproject/media/intel-processor/967031-974720-800.jpg');
INSERT INTO `products` VALUES('58', 'Intel Core i7 9700 3.00GHz Octa Core Processor', 'Intel-Processor', '    Intel Coffee Lake Refresh
    i7-9700
    LGA 1151
    Core 3.00 GHz',
                              '4', '300', '/finalyearproject/media/intel-processor/924132-883148-800.jpg');
INSERT INTO `products` VALUES('59', 'Intel Core i7 9700KF 3.6GHz Octa Core Processor', 'Intel-Processor', '    i7 9700KF
    Socket 1151
    Coffee Lake Refresh
    Max turbo 4.90 GHz',
                              '4', '340', '/finalyearproject/media/intel-processor/922732-874793-800.jpg');
INSERT INTO `products` VALUES('60', 'Intel Core i9 9900 3.10 GHz Octa Core Processor', 'Intel-Processor', '    Intel Coffee Lake Refresh
    I9-9900
    LGA 1151
    Core 3.10 GHz',
                              '4', '420', '/finalyearproject/media/intel-processor/924138-883147-800.jpg');

-- Harddrive
INSERT INTO `products` VALUES('61', 'SanDisk 120GB Solid State Drive', 'Storage', '    Capacity: 120 GB
    Read Speed: up to 530 MB/s
    Write Speed: up to 400 MB/s
    Interface: SATA Revision 3.0 (6 Gb/s)
    Durable Solid State Design', '5', '25', '/finalyearproject/media/storage/844909-809362-800.jpg');
INSERT INTO `products` VALUES('62', 'Crucial MX500 250GB Solid State Drive', 'Storage', '    Capacity 250GB
    2.5inch SSD
    Sequential Read/Write 560MB/s - 510MB/s
    Random Read/Write IOPS  95k/90k
    Limited Five Year Warranty', '5', '39', '/finalyearproject/media/storage/850780-822477-800.jpg');
INSERT INTO `products` VALUES('63', 'Samsung 850 Evo 500GB Solid State Drive', 'Storage', '    SATA 6Gb/s Interface
    2.5 inch form factor
    Sequential Read: Max. 550 MB/s
    Sequential Write: Max. 520 MB/s
    5 Year Warranty', '5', '75', '/finalyearproject/media/storage/854514-824749-800.jpg');
INSERT INTO `products` VALUES('64', 'Samsung 860 QVO 1TB Solid State Drive', 'Storage', '    Samsung V-NAND technology
    2.5 inch form factor
    Sequential Read: Max. 550 MB/s
    Sequential Write: Max. 520 MB/s
    3-year limited warranty', '5', '110', '/finalyearproject/media/storage/946385-871714-800.jpg');

-- Graphics Card
INSERT INTO `products` VALUES('65', 'Asus 1GB NVIDIA GEFORCE 710', 'Graphics-Card', '    GeForce GT 710
    1GB GDDR5
    Silent 0dB', '5', '30', '/finalyearproject/media/graphics/836923-806221-800.jpg');
INSERT INTO `products` VALUES('66', 'Asus 2GB NVIDIA GEFORCE 1030', 'Graphics-Card', '    2GB GDDR5
    Passive Cooler for Silent Running
    NVIDIA G-SYNC Ready
    HDMI 2.0b and DVI-D', '5', '79', '/finalyearproject/media/graphics/849058-821275-800.jpg');
INSERT INTO `products` VALUES('67', 'MSI 4GB NVIDIA GEFORCE GTX 1650', 'Graphics-Card', '    GTX 1650 SUPER
    4GB GDDR6
    1755MHz Boost Clock
    Dual Fan Cooling', '5', '190', '/finalyearproject/media/graphics/945327-921161-800.jpg');
INSERT INTO `products` VALUES('68', '6GB NVIDIA GEFORCE GTX 1660', 'Graphics-Card', '    GTX 1660
    6GB GDDR5
    Gaming X', '5', '250', '/finalyearproject/media/graphics/915489-879570-800.jpg');

-- Laptops
INSERT INTO `products` VALUES ('69', 'HP 255 G7 A6-9225 8GB 256GB FHD 15.6in', 'Laptops', '
    AMD A6-9225 2.6GHz
    8GB DDR4 RAM
    256GB SSD Storage
    15.6" Full HD (1920x1080) Display
    FreeDOS (Windows 10 NOT Included)', '5', '350', '/finalyearproject/media/940891-914414-800.jpg');

INSERT INTO `products` VALUES('70', 'Lenovo IdeaPad C340 Core i3 8GB 128GB SSD 15.6"', 'Laptops',
    'Intel Core i3-8145U 2.1GHz
    8GB RAM + 128GB SSD
    13.3" FHD Display
    Touchscreen
    Windows 10 Home', '5', '480', '/finalyearproject/media/961693-972659-800.jpg');
INSERT INTO `products` VALUES('71', 'Asus A509JA Core i5 8GB 512GB SSD 15.6in', 'Laptops',
    'Intel Core i5-1035G1 1.0GHz
    8GB RAM + 512GB SSD
    15.6" FHD Display
    Intel UHD Graphics
    Windows 10 Home', '7', '590', '/finalyearproject/media/958492-947183-800.jpg');
INSERT INTO `products` VALUES('72', 'ASUS X409FA-EK149T Core i7 8GB 256GB SSD 14"', 'Laptops',
    'Intel Core i7-8565U 1.8GHz
    8GB RAM + 256Gb SSD
    14" FHD Display
    Intel UHD Graphics 620
    Windows 10 Home', '3', '699.98', '/finalyearproject/media/938195-900684-800.jpg');
INSERT INTO `products` VALUES('73', 'HP ProBook 440 G6 14" Core i5 8GB 256GB SSD', 'Laptops',
    'Intel Core i5-8265U 1.6 GHz
    8GB DDR4 + 256GB SSD
    14" HD LED Display
    WIFI + Bluetooth
    Windows 10 Home', '2', '799.99', '/finalyearproject/media/926173-882119-800.jpg');

-- Desktops
INSERT INTO `products` VALUES('74', 'ASUS VA24EHE 23.8" Eye Care Full HD Monitor', 'Monitor',
    '1920 x 1080 Full HD
    HDMI, VGA & DVI
    75Hz / 5ms Response Time
    Panel Type: IPS
    VESA 100x100', '10', '99.99', '/finalyearproject/media/961616-966013-800.jpg');
INSERT INTO `products` VALUES('75', 'Acer KA220HQbid 21.5" HD DVI HDMI Monitor', 'Monitor',
    '1920 x 1080 Full HD
    HDMI, DVI & VGA
    60Hz / 5ms Response Time
    Panel Type: TN
    Wall Mountable', '10', '72.99', '/finalyearproject/media/721077-711063-800.jpg');
INSERT INTO `products` VALUES('76', 'BenQ EL2870UE 28" 4K HDR Monitor', 'Monitor',
    '3840 x 2160 4K UHD
    HDMI & DisplayPort
    60Hz / 1ms Response Time
    Panel type: TN
    AMD FreeSync', '10', '239.98', '/finalyearproject/media/961689-910955-800.jpg');
INSERT INTO `products` VALUES('77', 'LG UltraGear 24GL600F 24" Full HD 144Hz 1ms Gaming Monitor', 'Monitor',
    '1920 x 1080 Full HD
    HDMI & DisplayPort
    144Hz / 1ms Response Time
    Panel Type: TN
    Radeon FreeSync', '10', '179.99', '/finalyearproject/media/923381-883252-800.jpg');
INSERT INTO `products` VALUES('78', 'LG 34WL750 34" WQHD IPS Ultrawide Monitor', 'Monitor',
    '440 x 1440 WQHD
    DisplayPort & HDMI
    60Hz / 5ms Response Time
    Panel Type: IPS
    VESA Mount 100 x 100', '10', '379.98', '/finalyearproject/media/953046-914112-800.jpg');

-- Desktop-pcs
INSERT INTO `products` VALUES('79', 'Cyberpower Gaming Ryzen 3 8GB RAM 1TB HDD GTX 1650 WIFI Desktop PC', 'Desktops',
                              'AMD Ryzen 3 3200G 3.6 GHz
8GB RAM DDR4 + 1TB HDD
Nvidia GeForce GTX 1650
WIFI + Windows 10 Home', '7', '529.96', '/finalyearproject/media/Desktops/954313-958687-800.jpg');
INSERT INTO `products` VALUES('80', 'AlphaSync Core i5 GTX 1060 16GB 1TB HDD 240GB SSD', 'Desktops',
                              'Intel Core i5-9400F 6 Cores 2.9GHz
16GB, 1TB HDD, 240GB SATA SSD
MSI GTX 1060 6GB OCv1 GPU
WIFI, Windows 10 Home', '7', '699.99', '/finalyearproject/media/Desktops/944950-913993-800.jpg');
INSERT INTO `products` VALUES('81', 'AlphaSync Gaming Ryzen 7 16GB RAM 1TB HDD 240GB SSD RTX 2060', 'Desktops',
                              'AMD Ryzen 7 2700X 3.7GHz
16GB DDR4, 1TB HDD, 240GB SSD
ASUS NVIDIA GeForce 2060 6GB
WIFI + Windows 10 Home', '7', '939.99', '/finalyearproject/media/Desktops/958340-963563-800.jpg');
INSERT INTO `products` VALUES('82', 'Cyberpower Gaming Core i5 9th Gen 16GB RAM 1TB HDD 240GB SSD RTX 2070', 'Desktops',
                              'Intel Core i5-9600K 3.7GHz
16GB DDR4, 1TB HDD, 240GB SSD
NVidia GeForce RTX 2070
WIFI + Windows 10 Home', '7', '1099.49', '/finalyearproject/media/Desktops/954655-958694-800.jpg');
INSERT INTO `products` VALUES('83', 'HP Pavilion 690-0051na Core i5 9th Gen 8GB RAM 2TB HDD 256GB SSD GTX 1650', 'Desktops',
                              'Intel Core i5-9400F 2.9GHz
8GB DDR4, 2TB HDD, 256GB SSD
DVD Writer
NVIDIA GTX 1650 4GB', '7', '699.99', '/finalyearproject/media/Desktops/954385-958603-800.jpg');