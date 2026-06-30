<?php
// verify_otp.php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$email = trim($input['email'] ?? '');
$otp   = trim($input['otp'] ?? '');

if (empty($email) || empty($otp)) {
    http_response_code(422);
    echo json_encode(['error' => 'Email and OTP required']);
    exit;
}

$stmt = $pdo->prepare("SELECT id, otp, otp_expiry, verified FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
    exit;
}

if ($user['verified'] == 1) {
    echo json_encode(['message' => 'Account already verified']);
    exit;
}

if ($user['otp'] !== $otp) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid OTP']);
    exit;
}

if (strtotime($user['otp_expiry']) < time()) {
    http_response_code(400);
    echo json_encode(['error' => 'OTP expired']);
    exit;
}

// Mark as verified and clear OTP
$stmt = $pdo->prepare("UPDATE users SET verified = 1, otp = NULL, otp_expiry = NULL WHERE id = ?");
$stmt->execute([$user['id']]);

echo json_encode(['message' => 'Registration successful']);
?>  