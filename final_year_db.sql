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

--- users tables

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Member', 'Admin') NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `customer` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(256) NOT NULL,
  `surname` varchar(256) NOT NULL,
  `address` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` int(16) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`customer_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `products` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `sku` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` TEXT,
  `stock` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  PRIMARY KEY (`product_id`)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `order_detail` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
  `quantity` int(10) NOT NULL,
  `total` DECIMAL(7,2) NOT NULL,
  `address` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  PRIMARY KEY (`order_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`),
  FOREIGN KEY (`customer_id`) REFERENCES `customer`(`customer_id`)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


FLUSH PRIVILEGES;
