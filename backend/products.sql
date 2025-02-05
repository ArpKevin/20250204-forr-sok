-- Adatbázis létrehozása
CREATE DATABASE IF NOT EXISTS product_catalog;
USE product_catalog;

-- Tábla létrehozása
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image_name VARCHAR(255) NOT NULL
);

-- Adatok beszúrása
INSERT INTO products (name, description, price, image_name) VALUES
('Mountain Bike', 'A durable bike perfect for off-road trails and rough terrain.', 499.99, 'mountain_bike.jpg'),
('Smartphone', 'A high-end smartphone with a sleek design and powerful features.', 899.99, 'smartphone.jpg'),
('Coffee Maker', 'Brew your perfect cup of coffee with this advanced coffee maker.', 79.99, 'coffee_maker.jpg'),
('Gaming Laptop', 'A powerful laptop designed for gamers and heavy-duty tasks.', 1499.99, 'gaming_laptop.jpg'),
('Wireless Headphones', 'Noise-cancelling headphones with crystal-clear sound.', 199.99, 'wireless_headphones.jpg');
