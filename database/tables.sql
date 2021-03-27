CREATE DATABASE IF NOT EXISTS app_db;

USE app_db;

-- The general users of the website
CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(40),
    last_name VARCHAR(40),
    biography TEXT(1000),
    profile_image_url VARCHAR(255),
    favourite_pets VARCHAR(255),
    activated INT(1) DEFAULT 1 -- By default, mark as activated.
) CHARACTER SET=utf8;

-- Store the user session tokens that will be refreshed with every request
CREATE TABLE IF NOT EXISTS user_sessions (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) CHARACTER SET=utf8;