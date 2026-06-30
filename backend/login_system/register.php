<?php
// register.php
require 'config.php';
require 'send_otp_email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

$first_name  = trim($input['first_name'] ?? '');
$middle_name = trim($input['middle_name'] ?? '');
$last_name   = trim($input['last_name'] ?? '');
$email       = trim($input['email'] ?? '');
$password    = $input['password'] ?? '';
$terms       = $input['terms'] ?? false;

// Validate
$errors = [];
if (empty($first_name)) $errors[] = 'First name required';
if (empty($last_name)) $errors[] = 'Last name required';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email';
if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters';
if (!$terms) $errors[] = 'You must accept the terms';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['errors' => $errors]);
    exit;
}

// Check if email already registered and verified
$stmt = $pdo->prepare("SELECT id, verified FROM users WHERE email = ?");
$stmt->execute([$email]);
$existing = $stmt->fetch();

if ($existing && $existing['verified'] == 1) {
    http_response_code(409);
    echo json_encode(['error' => 'Email already registered']);
    exit;
}

// Generate OTP
$otp = sprintf("%06d", random_int(0, 999999));
$otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

// Hash password
$password_hash = password_hash($password, PASSWORD_BCRYPT);

if ($existing) {
    // Update existing unverified record
    $stmt = $pdo->prepare("UPDATE users SET first_name=?, middle_name=?, last_name=?, password_hash=?, otp=?, otp_expiry=? WHERE id=?");
    $stmt->execute([$first_name, $middle_name, $last_name, $password_hash, $otp, $otp_expiry, $existing['id']]);
} else {
    // Insert new record
    $stmt = $pdo->prepare("INSERT INTO users (first_name, middle_name, last_name, email, password_hash, otp, otp_expiry) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$first_name, $middle_name, $last_name, $email, $password_hash, $otp, $otp_expiry]);
}

// Send OTP email
$emailSent = sendOtpEmail($email, $otp);
if (!$emailSent) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to send OTP email']);
    exit;
}

echo json_encode(['message' => 'OTP sent to your email']);
?>