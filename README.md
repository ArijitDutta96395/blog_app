# My Blog Application

A secure, feature-rich blog application built with PHP, MySQL, and Bootstrap 5.

## 🚀 Features

### User Features
- **User Registration & Login** - Secure authentication system
- **Create Blog Posts** - Rich text posting functionality
- **Edit/Delete Posts** - Full CRUD operations for posts
- **Responsive Design** - Mobile-friendly interface

### Admin Features
- **Secure Admin Dashboard** - Password-protected admin access
- **User Management** - Manage all registered users
- **Post Management** - Manage all blog posts
- **Admin-only Access** - Only designated admin users can access

## 🛠️ Technology Stack

- **Backend:** PHP 8.x
- **Database:** MySQL
- **Frontend:** Bootstrap 5, Font Awesome
- **Server:** Apache (XAMPP)

## 📁 Project Structure

```
blog_app-1.1/
├── index.php                 # Home page - displays all posts
├── setup_database.php        # Database setup script
├── README.md                 # This file
├── create_admin_user.sql     # SQL script to create admin user
├── admin/
│   ├── login.php            # Admin login page
│   ├── index.php            # Admin dashboard
│   ├── manage_posts.php     # Post management
│   └── manage_users.php     # User management
├── includes/
│   ├── config.php           # Database configuration
│   └── auth.php             # Authentication functions
├── users/
│   ├── login.php            # User login
│   ├── register.php         # User registration
│   └── logout.php           # User logout
├── posts/
│   ├── create.php           # Create new post
│   ├── edit.php             # Edit existing post
│   ├── delete.php           # Delete post
│   └── view.php             # View single post
└── assets/
    └── css/
        └── style.css        # Custom styles
```

## 🚀 Quick Start

### 1. Setup Database
1. Start XAMPP and ensure Apache & MySQL are running
2. Open phpMyAdmin at `http://localhost/phpmyadmin`
3. Run the database setup:
   ```bash
   php setup_database.php
   ```
   Or manually create a database named `blog`

### 2. Create Admin User via phpMyAdmin
1. Open phpMyAdmin at `http://localhost/phpmyadmin`
2. Select the blog database
3. Run the SQL commands: 
  -- Add admin column if not exists
     ```sql
 ALTER TABLE users ADD COLUMN IF NOT EXISTS is_admin BOOLEAN DEFAULT FALSE;
```
-- Create admin user (replace with your preferred credentials)
3. Run the SQL commands:
   
Add admin column if not exists
```sql
 ALTER TABLE users ADD COLUMN IF NOT EXISTS is_admin BOOLEAN DEFAULT FALSE;
```
    
Create admin user (replace with your preferred credentials)
```sql
INSERT INTO users (username, email, password, is_admin) 
VALUES ('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);
   ```
3. Access Admin Dashboard
1. Admin Login: `http://localhost/blog_app-1.1/admin/login.php`
2. Admin Credentials: Use the credentials you set in phpMyAdmin

### 3. Access Admin Dashboard
   
1. Admin Login: `http://localhost/blog_app-1.1/admin/login.php`
2. Admin Credentials: Use the credentials you set in phpMyAdmin

### 4. Access the Application
- **Main Blog:** `http://localhost/blog_app-1.1/`
- **User Login:** `http://localhost/blog_app-1.1/users/login.php`
- **User Register:** `http://localhost/blog_app-1.1/users/register.php`
- **Admin Login:** `http://localhost/blog_app-1.1/admin/login.php`

## 🔐 Security Features

- **Password Hashing** - All passwords are securely hashed
- **Session Management** - Secure session handling
- **Admin Authentication** - Dedicated admin login system
- **Role-based Access** - Admin-only dashboard access
- **Input Validation** - All user inputs are sanitized

## 📊 Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Posts Table
```sql
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## 🎯 Usage Guide

### For Regular Users
1. Register a new account
2. Login with credentials
3. Create, edit, and delete your own posts
4. View all posts on the homepage

### For Admin Users
1. Go to admin login page
2. Login with admin credentials
3. Access admin dashboard
4. Manage all users and posts

## 🔧 Configuration

### Database Settings
Edit `includes/config.php` if needed:
```php
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'blog');
```

## 🐛 Troubleshooting

### Common Issues
1. **"Call to undefined function isAdmin()"** - Ensure includes/auth.php has the isAdmin() function
2. **Database connection errors** - Check MySQL service and credentials in config.php
3. **Admin access denied** - Ensure admin user has is_admin = 1 in database

### Reset Admin Password
```sql
UPDATE users SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE username = 'admin';
```

## 📞 Support

For issues or questions:
1. Check the troubleshooting section above
2. Ensure XAMPP is running properly
3. Verify database connection settings
4. Check PHP error logs for detailed error messages

## 📝 License

This project is open source and available under the MIT License.
