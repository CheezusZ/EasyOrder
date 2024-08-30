# EasyOrder
A SaaS web service for processing restaurant menu and orders

CodeIgniter and Endroid install are needed with composer.

MySQL schema:
CREATE TABLE Users (
    user_id INT(11) UNSIGNED AUTO_INCREMENT,
    password_hash VARCHAR(255),
    restaurant_name VARCHAR(255),
    email VARCHAR(255),
    location VARCHAR(255),
    city VARCHAR(50),
    role ENUM('owner', 'admin') DEFAULT 'owner',
    PRIMARY KEY (user_id)
);

CREATE TABLE Category (
    category_id INT(11) UNSIGNED AUTO_INCREMENT,
    user_id INT(11) UNSIGNED,
    category_name VARCHAR(255),
    category_sort INT(4) UNSIGNED,
    PRIMARY KEY (category_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Tables (
    table_id INT(11) UNSIGNED AUTO_INCREMENT,
    user_id INT(11) UNSIGNED,
    table_number VARCHAR(50),
    qrcode_image TEXT,
    PRIMARY KEY (table_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Menuitem (
    menu_item_id INT(11) UNSIGNED AUTO_INCREMENT,
    user_id INT(11) UNSIGNED,
    category_id INT(11) UNSIGNED,
    item_name VARCHAR(255),
    description TEXT,
    price DECIMAL(10,2),
    is_active TINYINT(1) UNSIGNED DEFAULT 1,
    PRIMARY KEY (menu_item_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES Category(category_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Orders (
    order_id INT(11) UNSIGNED AUTO_INCREMENT,
    user_id INT(11) UNSIGNED,
    table_id INT(11) UNSIGNED,
    order_status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    customer_email VARCHAR(55),
    created_at DATETIME,
    total_price DECIMAL(10,2),
    updated_at DATETIME,
    PRIMARY KEY (order_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (table_id) REFERENCES Tables(table_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Orderitem (
    order_item_id INT(11) UNSIGNED AUTO_INCREMENT,
    order_id INT(11) UNSIGNED,
    menu_item_id INT(11) UNSIGNED,
    quantity INT(4),
    PRIMARY KEY (order_item_id),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES Menuitem(menu_item_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
