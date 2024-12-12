-- Criando a tabela de produtos
CREATE TABLE products (
    product_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(100),
    product_category VARCHAR(100),
    product_description VARCHAR(250),
    product_image VARCHAR(250),
    product_image2 VARCHAR(250),
    product_image3 VARCHAR(250),
    product_image4 VARCHAR(250),
    product_price DECIMAL(6,2),
    product_special_offer INT(2),
    product_color VARCHAR(100)
);

-- Criando a tabela de usuários
CREATE TABLE users (
    user_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(100),
    user_email VARCHAR(100),
    user_password VARCHAR(100)
);

-- Criando a tabela de pedidos
CREATE TABLE orders (
    order_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    order_cost DECIMAL(6,2),
    order_status VARCHAR(100),
    user_id INT(11),
    shipping_city VARCHAR(255),
    shipping_uf VARCHAR(2),
    shipping_address VARCHAR(255),
    order_date DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Criando a tabela de itens de pedido
CREATE TABLE order_items (
    item_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    order_id INT(11),
    product_id INT(11),
    user_id INT(11),
    qnt INT(11),
    order_date DATETIME,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Criando a tabela de pagamentos
CREATE TABLE payments (
    payment_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    order_id INT(11),
    user_id INT(11),
    transaction_id VARCHAR(255),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Criando a tabela de administradores
CREATE TABLE admins (
    admin_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    admin_email VARCHAR(255),
    admin_name VARCHAR(255),
    admin_password VARCHAR(100)
);

-- inserindo um registro na tabela de administradores
INSERT into admins VALUES(null,"admin", "admin@shop.com.br",
"e10adc3949ba59abbe56e057f20f883e");