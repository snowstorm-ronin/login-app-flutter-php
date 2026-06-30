# 🔐 Login App - Flutter + PHP + MySQL

A complete registration/login system built with **Flutter** (frontend) and **PHP** (backend) using **MySQL** database with **OTP email verification**.

---

## 📸 Screens

| Step 1: Basic Info | Step 2: Password | Step 3: OTP | Step 4: Success |
|-------------------|------------------|-------------|-----------------|
| Name, Email, Terms | Create Password | Enter OTP from Email | ✅ Green Tick |

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Frontend** | Flutter (Dart) |
| **Backend** | PHP |
| **Database** | MySQL |
| **Email** | PHPMailer (Gmail SMTP) |
| **Dev Tools** | VS Code, XAMPP, Android Studio |

---

## ✨ Features

- ✅ Multi-step registration form
- ✅ Email OTP verification
- ✅ Password hashing (bcrypt)
- ✅ Duplicate email prevention
- ✅ Terms & conditions acceptance
- ✅ Clean, responsive UI

---

## 📋 Prerequisites

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL)
- [Flutter SDK](https://flutter.dev/docs/get-started/install)
- [Android Studio](https://developer.android.com/studio) (for emulator)
- [Composer](https://getcomposer.org/)
- Gmail account with [App Password](https://myaccount.google.com/apppasswords)

---

## 🚀 Quick Setup

### 1. Clone the Repository
```bash
git clone https://github.com/snowstorm-ronin/login-app-flutter-php.git

2. Database Setup
Run this SQL in MySQL:
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

3. Backend Setup
# Copy backend to XAMPP htdocs
cp -r backend/login_system C:/xampp/htdocs/login_system

# Install PHPMailer
cd C:/xampp/htdocs/login_system
composer require phpmailer/phpmailer

4. Configure Credentials
# Rename example files
cd C:/xampp/htdocs/login_system
copy config.example.php config.php
copy send_otp_email.example.php send_otp_email.php

Edit config.php:
$pass = 'YOUR_MYSQL_ROOT_PASSWORD';  // Add your MySQL password

Edit send_otp_email.php:
$mail->Username = 'YOUR_GMAIL@gmail.com';      // Your Gmail
$mail->Password = 'YOUR_APP_PASSWORD';          // Your App Password
$mail->setFrom('YOUR_GMAIL@gmail.com', 'App');  // Your Gmail

📧 Get Gmail App Password: https://myaccount.google.com/apppasswords

5. Run the App
# Start Apache in XAMPP
# Start Android emulator in Android Studio
# Open frontend folder in VS Code

cd frontend/login_app
flutter pub get
flutter run

📁 Project Structure
login-app-flutter-php/
├── frontend/
│   └── login_app/           # Flutter application
│       ├── lib/
│       │   ├── config.dart
│       │   ├── main.dart
│       │   ├── models/
│       │   ├── screens/
│       │   └── services/
│       └── pubspec.yaml
├── backend/
│   └── login_system/        # PHP backend
│       ├── config.example.php
│       ├── send_otp_email.example.php
│       ├── register.php
│       ├── verify_otp.php
│       └── composer.json
├── .gitignore
├── SETUP.md
└── README.md

🔄 How It Works
User → Fill Form → Create Password → Receive OTP Email → Enter OTP → ✅ Success
         ↓              ↓                ↓               ↓
      Step 1         Step 2           Step 3          Step 4

🔒 Security
Passwords hashed with bcrypt
OTP expires after 10 minutes
Email verification prevents spam
Sensitive files excluded via .gitignore
Use .example.php templates for sharing

📝 License
This project is for educational purposes as part of an internship project.

👤 Author
Saumil Kalavikatte
GitHub: @snowstorm-ronin

🙏 Acknowledgments
Flutter Documentation
PHPMailer Library
XAMPP Team
