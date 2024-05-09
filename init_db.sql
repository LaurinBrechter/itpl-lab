CREATE TABLE IF NOT EXISTS `addresses` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(50) NOT NULL,
  `house_number` varchar(10),
  `city` varchar(50) NOT NULL,
  `state` varchar(50),
  `zip` varchar(10) NOT NULL,
  `country` varchar(50) NOT NULL,
  PRIMARY KEY (`address_id`)
) 

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `address_id` int(11) NOT NULL,
  `telephone_number` varchar(20),
  `isVip` tinyint(1),
  PRIMARY KEY (`customer_id`),
  KEY `address_id2` (`address_id`),
  CONSTRAINT `address_id2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) 

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` enum('High','Medium','low') NOT NULL,
  `sp_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` enum('PENDING','COMPLETED','CANCELLED') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`order_id`) USING BTREE,
  KEY `customer_id` (`customer_id`),
  KEY `sp_id` (`sp_id`),
  CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sp_id` FOREIGN KEY (`sp_id`) REFERENCES `servicepartners` (`sp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) 

CREATE TABLE IF NOT EXISTS `order_items` (
  `item_count_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `sku` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`item_count_id`),
  KEY `order_id` (`order_id`),
  KEY `sku2` (`sku`),
  CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sku2` FOREIGN KEY (`sku`) REFERENCES `products` (`sku`) ON DELETE NO ACTION ON UPDATE NO ACTION
) 

CREATE TABLE IF NOT EXISTS `productionplan` (
  `sku` int(11),
  `production_amt` int(11),
  `order_id` int(11),
  `status` enum('PENDING','COMPLETED','CANCELLED'),
  `next_production_item_id` int(11),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  KEY `sku` (`sku`),
  KEY `order_id2` (`order_id`),
  CONSTRAINT `order_id2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sku` FOREIGN KEY (`sku`) REFERENCES `products` (`sku`) ON DELETE NO ACTION ON UPDATE NO ACTION
) 

CREATE TABLE IF NOT EXISTS `production_facilities` (
  `production_facility_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`production_facility_id`),
  KEY `address_id 4` (`address_id`),
  CONSTRAINT `address_id 4` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) 

CREATE TABLE IF NOT EXISTS `products` (
  `sku` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `production_duration` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `storage_amount` int(11),
  PRIMARY KEY (`sku`) USING BTREE
) 

CREATE TABLE IF NOT EXISTS `servicepartners` (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50),
  `tax_number` varchar(20),
  `address_id` int(11),
  `isInternal` tinyint(1),
  PRIMARY KEY (`sp_id`),
  KEY `address_id` (`address_id`),
  CONSTRAINT `address_id` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
)
CREATE TABLE IF NOT EXISTS `storage_facilities` (
  `storage_facility_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`storage_facility_id`),
  KEY `address_id3` (`address_id`),
  CONSTRAINT `address_id3` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) 

CREATE TABLE IF NOT EXISTS `storage_log` (
  `storage_event_id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` int(11),
  `order_id` int(11),
  `amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`storage_event_id`) USING BTREE,
  KEY `sku3` (`sku`),
  KEY `order_id3` (`order_id`),
  CONSTRAINT `order_id3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sku3` FOREIGN KEY (`sku`) REFERENCES `products` (`sku`) ON DELETE NO ACTION ON UPDATE NO ACTION
) 
