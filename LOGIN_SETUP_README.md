# KSDC Login System Setup Instructions

## Prerequisites
- XAMPP installed and running
- MySQL/MariaDB running
- PHP 7.4 or higher

## Database Setup

1. **Create the database:**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Run the SQL commands in `setup_database.sql` file

2. **Or create manually:**
   ```sql
   CREATE DATABASE IF NOT EXISTS ksdc;
   USE ksdc;
   
   CREATE TABLE IF NOT EXISTS tbl_login (
       id INT(11) AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL UNIQUE,
       useremail VARCHAR(100) NOT NULL UNIQUE,
       pass VARCHAR(255) NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```

## Test User
A test user is automatically created with:
- **Username:** testuser
- **Password:** test123
- **Email:** test@example.com

## Files Overview

- `joinus.php` - Login page
- `register.php` - Registration page  
- `welcome.php` - Dashboard after login
- `logout.php` - Logout functionality
- `dbconnection.php` - Database connection
- `setup_database.sql` - Database setup script

## Features

✅ **Secure Login System**
- Password hashing support
- Session management
- SQL injection protection
- Input validation

✅ **User Registration**
- Email validation
- Username uniqueness check
- Password hashing

✅ **Responsive Design**
- Bootstrap framework
- Mobile-friendly interface
- Professional styling

## Usage

1. Start XAMPP
2. Navigate to `http://localhost/ksdc22/joinus.php`
3. Use the test credentials or register a new account
4. After login, you'll be redirected to the welcome dashboard

## Security Features

- Prepared statements prevent SQL injection
- Password hashing for secure storage
- Session-based authentication
- Input sanitization and validation
- Error handling

## Troubleshooting

**Database Connection Issues:**
- Check if MySQL is running in XAMPP
- Verify database credentials in `dbconnection.php`
- Ensure database `ksdc` exists

**Login Issues:**
- Verify user exists in `tbl_login` table
- Check password hashing in registration vs login
- Enable error reporting for debugging

**Permission Issues:**
- Ensure proper file permissions
- Check XAMPP htdocs folder permissions
