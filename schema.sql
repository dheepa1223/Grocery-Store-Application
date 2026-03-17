
-- Database schema for Grocery Web Application

CREATE DATABASE IF NOT EXISTS grocery_db;
USE grocery_db;

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL
);

-- Cart table
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Orders table (Recording finalized purchases)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(100),
    product_name VARCHAR(100),
    price DECIMAL(10, 2),
    quantity INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert high-quality initial products
INSERT INTO products (product_name, price, image) VALUES
('Carrot', 40.00, 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?auto=format&fit=crop&w=800&q=80'),
('Brinjal', 35.00, 'https://images.unsplash.com/photo-1590393961173-10d297ffda72?auto=format&fit=crop&w=800&q=80'),
('Tomato', 30.00, 'https://images.unsplash.com/photo-1518977676601-b53f02bad67b?auto=format&fit=crop&w=800&q=80'),
('Potato', 40.00, 'https://images.unsplash.com/photo-1518977676601-b53f02bad67b?auto=format&fit=crop&w=800&q=80'),
('Onion', 50.00, 'https://images.unsplash.com/photo-1508747703725-719777637510?auto=format&fit=crop&w=800&q=80'),
('Rice', 60.00, 'https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=800&q=80'),
('Sugar', 45.00, 'https://images.unsplash.com/photo-1581441363689-1f3c3c414635?auto=format&fit=crop&w=800&q=80'),
('Milk', 30.00, 'https://images.unsplash.com/photo-1564415051542-cb8423b06c2c?auto=format&fit=crop&w=800&q=80');

-- Insert dummy admin user
INSERT INTO users (email, password) VALUES ('admin@gmail.com', '1234');

