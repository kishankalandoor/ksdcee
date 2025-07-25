-- Database setup for KSDC22 project
-- Run this in phpMyAdmin or MySQL command line

CREATE DATABASE IF NOT EXISTS ksdc;
USE ksdc;

-- Create the login table
CREATE TABLE IF NOT EXISTS tbl_login (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    useremail VARCHAR(100) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a test user (password: "test123")
INSERT INTO tbl_login (username, useremail, pass) VALUES 
('testuser', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Note: The password above is hashed version of "test123"
-- You can use this to test the login functionality
