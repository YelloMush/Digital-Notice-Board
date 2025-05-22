CREATE DATABASE IF NOT EXISTS notice_board;
USE notice_board;

-- Drop and recreate admins table
DROP TABLE IF EXISTS admins;
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

-- Insert admin and multiple users
INSERT INTO admins (username, password) VALUES 
('admin', 'admin123'),
('user1', 'user1'),
('user2', 'user2'),
('user3', 'user3'),
('user4', 'user4');

-- Drop and recreate notices table
DROP TABLE IF EXISTS notices;
CREATE TABLE notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100),
    posted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expire_at DATETIME NOT NULL,
    image VARCHAR(255) DEFAULT NULL
);

-- Sample notice
INSERT INTO notices (title, description, category, expire_at)
VALUES ('Welcome Notice', 'Welcome to the Digital Notice Board.', 'General', '2025-12-31');
