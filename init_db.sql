CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    price DECIMAL(10, 2),
    production_duration INT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    storage_amount INT,
);

CREATE TABLE storage_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    storage_id INT,
    order_id INT,
    amount INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
