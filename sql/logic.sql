-- Database Logic: Procedures, Triggers, and Views

USE online_shop;

-- 1. Stored Procedures (Requirement: At least 3)

DELIMITER //

-- Procedure to safely place an order (Requirement: Transactions used in at least 1 place)
CREATE PROCEDURE sp_place_order(
    IN p_user_id INT,
    IN p_total_amount DECIMAL(10, 2)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;
        INSERT INTO orders (user_id, total_amount, status)
        VALUES (p_user_id, p_total_amount, 'pending');
        
        -- Return the last inserted ID to PHP
        SELECT LAST_INSERT_ID() AS order_id;
    COMMIT;
END //

-- Procedure to add or update stock
CREATE PROCEDURE sp_update_stock(
    IN p_product_id INT,
    IN p_quantity_change INT
)
BEGIN
    UPDATE products 
    SET stock_quantity = stock_quantity + p_quantity_change
    WHERE id = p_product_id;
END //

-- Procedure to get dashboard statistics
CREATE PROCEDURE sp_get_dashboard_stats()
BEGIN
    SELECT 
        (SELECT COUNT(*) FROM products) AS total_products,
        (SELECT COUNT(*) FROM orders) AS total_orders,
        (SELECT SUM(total_amount) FROM orders WHERE status = 'completed') AS total_revenue,
        (SELECT COUNT(*) FROM users WHERE role = 'user') AS total_customers;
END //

DELIMITER ;


-- 2. Triggers (Requirement: At least 2)

DELIMITER //

-- Trigger to automatically update order total when item is added
CREATE TRIGGER tr_after_order_item_insert
AFTER INSERT ON order_items
FOR EACH ROW
BEGIN
    UPDATE orders 
    SET total_amount = (SELECT SUM(quantity * unit_price) FROM order_items WHERE order_id = NEW.order_id)
    WHERE id = NEW.order_id;
END //

-- Trigger to prevent negative stock
CREATE TRIGGER tr_prevent_negative_stock
BEFORE UPDATE ON products
FOR EACH ROW
BEGIN
    IF NEW.stock_quantity < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Insufficient stock.';
    END IF;
END //

DELIMITER ;


-- 3. Views (Requirement: At least 2)

-- View for sales summary by category
CREATE VIEW v_sales_by_category AS
SELECT 
    c.name AS category_name,
    COUNT(oi.id) AS items_sold,
    SUM(oi.quantity * oi.unit_price) AS total_sales
FROM categories c
JOIN products p ON c.id = p.category_id
JOIN order_items oi ON p.id = oi.product_id
JOIN orders o ON oi.order_id = o.id
WHERE o.status = 'completed'
GROUP BY c.id;

-- View for low stock products
CREATE VIEW v_low_stock_report AS
SELECT id, name, stock_quantity, price
FROM products
WHERE stock_quantity < 10 AND is_deleted = 0;
