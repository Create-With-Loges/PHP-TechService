-- Database: tech_service_db
DROP DATABASE IF EXISTS tech_service_db;
CREATE DATABASE tech_service_db;
USE tech_service_db;

-- Admins Table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    contact VARCHAR(20),
    model VARCHAR(100),
    company VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- providers Table
CREATE TABLE providers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    contact VARCHAR(20),
    shop_reg_num VARCHAR(100),
    prof_link VARCHAR(255),
    service_type VARCHAR(50),
    short_info TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Requests Table
CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    provider_id INT NOT NULL,
    details TEXT,
    status ENUM('Pending', 'Accepted', 'In Progress', 'Completed', 'Rejected') DEFAULT 'Pending',
    amount DECIMAL(10,2) DEFAULT 0.00,
    payment_status ENUM('Pending', 'Paid') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (provider_id) REFERENCES providers(id) ON DELETE CASCADE
);

-- Contacts Table
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(150),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- SAMPLE DATA

-- Admin
INSERT INTO admins (username, password, email) VALUES 
('admin', 'admin123', 'admin@techsupport.com');

-- Providers
INSERT INTO providers (username, password, email, contact, shop_reg_num, prof_link, service_type, short_info) VALUES 
('JohnRepair', 'pass123', 'john@repair.com', '9876543210', 'REG-1001', 'http://freelancer.com/john', 'Hardware', 'Expert in laptop screen and keyboard replacements.'),
('SoftSol', 'pass123', 'soft@sol.com', '9876543211', 'REG-1002', '', 'Software', 'OS Installation, Virus Removal, and Data Recovery.');

-- Users
INSERT INTO users (username, password, email, contact, model, company) VALUES 
('alice', 'pass123', 'alice@gmail.com', '1234567890', 'Inspiron 15', 'Dell'),
('bob', 'pass123', 'bob@gmail.com', '1234567891', 'MacBook Pro', 'Apple');
