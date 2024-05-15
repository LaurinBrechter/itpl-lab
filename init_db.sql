CREATE TABLE IF NOT EXISTS addresses (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  street varchar(50) NOT NULL,
  house_number varchar(10),
  city varchar(50) NOT NULL,
  state varchar(50),
  zip varchar(10) NOT NULL,
  country varchar(50) NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50),
    role ENUM('SERVICE_PARTNER', 'STORAGE', 'PRODUCTION'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    price DECIMAL(10, 2),
    production_duration INT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    storage_amount INT
);

CREATE TABLE customers (
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  name varchar(25) DEFAULT NULL,
  address_id int(11) DEFAULT NULL,
  telephone_number varchar(20) DEFAULT NULL,
  isVip boolean DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS service_partners (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(50),
  tax_number varchar(20),
  address_id int(11),
  isInternal tinyint(1),
  KEY address_id (address_id),
  user_id int(11),
  CONSTRAINT address_id FOREIGN KEY (address_id) REFERENCES addresses (id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE table orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sp_id INT, -- service partner id
    customer_id INT,
    status ENUM('PENDING', 'COMPLETED', 'CANCELLED'),
    priority ENUM('LOW', 'MEDIUM', 'HIGH'),
    CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `sp_id` FOREIGN KEY (`sp_id`) REFERENCES `service_partners` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE storage_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    storage_id INT,
    order_id INT,
    amount INT,
    detail ENUM('RESERVED', 'PRODUCTION_IN', 'SHIPPED', 'MANUAL'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `order_id3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `sku3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    amount INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE production_plan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status enum('PENDING','COMPLETED','CANCELLED'),
    product_id INT,
    amount INT,
    order_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    priority ENUM('LOW', 'MEDIUM', 'HIGH'),
    target ENUM('STORAGE', 'CUSTOMER'),
    facility_id INT,
);

CREATE TABLE IF NOT EXISTS storage_facilities (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  address_id int(11) NOT NULL,
  KEY address_id3 (address_id),
  user_id int(11),
  CONSTRAINT address_id3 FOREIGN KEY (address_id) REFERENCES addresses (id) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS production_facilities (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  address_id int(11) NOT NULL,
  KEY `address_id 4` (`address_id`),
  user_id int(11),
  CONSTRAINT `address_id 4` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);