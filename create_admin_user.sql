-- SQL commands to create an admin user
-- Run these commands in phpmyadmin localhost

-- First, ensure the is_admin column exists (if not already added)
ALTER TABLE users ADD COLUMN IF NOT EXISTS is_admin BOOLEAN DEFAULT FALSE;

-- Create an admin user (replace 'admin' and 'admin@example.com' with your preferred credentials)
-- Password is 'admin123' (hashed below)
INSERT INTO users (username, email, password, is_admin) 
VALUES ('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- Verify the admin user was created
SELECT * FROM users WHERE is_admin = 1;
