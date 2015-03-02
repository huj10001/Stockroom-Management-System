# Create (and reset) the actual database
DROP SCHEMA IF EXISTS inventory;
CREATE SCHEMA inventory;

# Create the tables for the database
CREATE TABLE inventory.user
    (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        email VARCHAR(254) NOT NULL,
        pass VARCHAR(255) NOT NULL, # Subject to change when I actually implement the password system
        type TINYINT UNSIGNED NOT NULL,
        enabled BOOLEAN NOT NULL,
        PRIMARY KEY (id),
        UNIQUE (email)
    ) ENGINE = INNODB;

CREATE TABLE inventory.item
    (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        description TEXT, # Optional item description (65,535 char max)
        type TINYINT UNSIGNED NOT NULL,
        qty INT UNSIGNED, # Null for infinity
        price DECIMAL(9, 2), # This configuration will store any value less then 10 million (which should be plenty for our scale) (also, null for unknown)
        enabled BOOLEAN NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE = INNODB;

CREATE TABLE inventory.project
    (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        balance DECIMAL(9, 2) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE = INNODB;

CREATE TABLE inventory.project_member
    (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        project_id INT UNSIGNED NOT NULL,
        user_id INT UNSIGNED NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (project_id) REFERENCES inventory.project(id),
        FOREIGN KEY (user_id) REFERENCES inventory.user(id)
    ) ENGINE = INNODB;

CREATE TABLE inventory.order
    (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id INT UNSIGNED NOT NULL,
        project_id INT UNSIGNED NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user_id) REFERENCES inventory.user(id),
        FOREIGN KEY (project_id) REFERENCES inventory.project(id)
    ) ENGINE = INNODB;

CREATE TABLE inventory.order_item
    (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        item_id INT UNSIGNED NOT NULL,
        order_id INT UNSIGNED NOT NULL,
        qty INT UNSIGNED, # Null for unknown
        price DECIMAL(9, 2), # Null for unknown
        PRIMARY KEY (id),
        FOREIGN KEY (item_id) REFERENCES inventory.item(id),
        FOREIGN KEY (order_id) REFERENCES inventory.order(id)
    ) ENGINE = INNODB;
