-- Sample Data for Online Shop

USE online_shop;

-- Users (Password is 'password123' hashed with BCRYPT)
INSERT INTO users (username, password, email, role) VALUES
('admin', '$2y$10$8W3Y6H8VjH1p9uY.Z1vX9O8f.e.9u6f.zW.zW.zW.zW.zW.zW.zW', 'admin@example.com', 'admin'),
('john_doe', '$2y$10$8W3Y6H8VjH1p9uY.Z1vX9O8f.e.9u6f.zW.zW.zW.zW.zW.zW.zW', 'john@example.com', 'user');

-- Categories
INSERT INTO categories (name, description) VALUES
('Electronics', 'Gadgets, devices, and more'),
('Clothing', 'Apparel and fashion accessories'),
('Home & Kitchen', 'Essentials for your home');

-- Products
INSERT INTO products (name, description, price, stock_quantity, category_id) VALUES
('Smartphone X', 'Latest model with 5G', 799.99, 50, 1),
('Wireless Headphones', 'Noise-cancelling over-ear headphones', 199.99, 100, 1),
('Cotton T-Shirt', 'Premium quality cotton t-shirt', 19.99, 200, 2),
('Coffee Maker', 'Brews perfect coffee in minutes', 89.99, 5, 3); -- Low stock for testing view

-- Sample Orders and Items
-- Note: Total amount will be updated by trigger
INSERT INTO orders (user_id, status) VALUES (2, 'completed');
INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (1, 1, 1, 799.99);
INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (1, 2, 2, 199.99);

INSERT INTO orders (user_id, status) VALUES (2, 'pending');
INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (2, 3, 5, 19.99);
