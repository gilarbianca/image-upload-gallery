-- SQLite Database Structure

-- Create the images table
CREATE TABLE IF NOT EXISTS images (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    file_name TEXT NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- PostgreSQL version (for production deployment)
/*
CREATE TABLE images (
    id SERIAL PRIMARY KEY,
    file_name TEXT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
*/

-- Note: For PostgreSQL deployment:
-- 1. Create database: CREATE DATABASE image_upload;
-- 2. Create user: CREATE USER your_db_username WITH ENCRYPTED PASSWORD 'your_db_password';
-- 3. Grant privileges: GRANT ALL PRIVILEGES ON DATABASE image_upload TO your_db_username;
-- 4. Use the PostgreSQL version of the table creation script above
