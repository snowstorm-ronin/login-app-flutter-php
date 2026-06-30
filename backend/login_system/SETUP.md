# Setup Guide

## Prerequisites
- XAMPP (Apache + MySQL)
- Flutter SDK
- Android Studio (for emulator)
- Composer
- Gmail account with 2-Step Verification

## Step 1: Database Setup
1. Start MySQL (XAMPP or MySQL Workbench)
2. Run this SQL:
```sql
CREATE DATABASE user_auth;
USE user_auth;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    verified TINYINT(1) DEFAULT 0,
    otp VARCHAR(6) DEFAULT NULL,
    otp_expiry DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

## Step 2: Backend Setup
Copy backend/login_system/ to C:\xampp\htdocs\login_system\
Open terminal in that folder and run:
composer require phpmailer/phpmailer

## Step 3: Configure Credentials
Edit these files:

config.php
Change: $pass = 'YOUR_MYSQL_ROOT_PASSWORD';
To your MySQL root password

send_otp_email.php
Change:
$mail->Username → Your Gmail address
$mail->Password → Your Gmail App Password
$mail->setFrom → Your Gmail address

To get App Password: https://myaccount.google.com/apppasswords

## Step 4: Run the App
Start Apache in XAMPP
Start Android emulator
Open frontend folder in VS Code
Run flutter pub get
Press F5

## Important

Android emulator uses 10.0.2.2 to connect to localhost
For real device, change baseUrl in lib/config.dart to your PC's IP