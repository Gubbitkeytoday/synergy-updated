<?php
header('Content-Type: application/json; charset=utf-8');

// Enable error reporting suppression for clean JSON response
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Extract and sanitize input fields
$name = trim($_POST['name'] ?? '');
$company = trim($_POST['company'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');
$consent_contact = isset($_POST['consent_contact']);
$consent_marketing = isset($_POST['consent_marketing']);

// Validation
if (empty($name) || empty($email) || empty($phone) || empty($message)) {
    echo json_encode(['success' => false, 'error' => 'กรุณากรอกข้อมูลที่จำเป็น (*) ให้ครบถ้วน']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'รูปแบบอีเมลไม่ถูกต้อง']);
    exit;
}

if (!$consent_contact) {
    echo json_encode(['success' => false, 'error' => 'กรุณายอมรับนโยบายความเป็นส่วนตัวก่อนส่งข้อมูล']);
    exit;
}

// 1. SAVE TO DATABASE FILE (data/contact_messages.json)
$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

$dataFile = $dataDir . '/contact_messages.json';
$messages = [];
if (file_exists($dataFile)) {
    $messages = json_decode(file_get_contents($dataFile), true) ?: [];
}

$entry = [
    'id' => uniqid('msg_'),
    'date' => date('Y-m-d H:i:s'),
    'name' => htmlspecialchars($name),
    'company' => htmlspecialchars($company),
    'email' => htmlspecialchars($email),
    'phone' => htmlspecialchars($phone),
    'message' => htmlspecialchars($message),
    'consent_contact' => $consent_contact,
    'consent_marketing' => $consent_marketing,
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
];

array_unshift($messages, $entry); // Put newest first
file_put_contents($dataFile, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// 2. SEND EMAIL NOTIFICATION TO SALES
$to = 'sales@syntechnology.com';
$subject = "=?UTF-8?B?" . base64_encode("ข้อความใหม่จากเว็บไซต์ (Synergy Contact Form): " . $name) . "?=";

$emailBody = "มีข้อความใหม่ส่งมาจากแบบฟอร์มติดต่อบนเว็บไซต์ Synergy Technology\n\n";
$emailBody .= "--------------------------------------------------\n";
$emailBody .= "วันที่-เวลา: " . $entry['date'] . "\n";
$emailBody .= "ชื่อ-นามสกุล: " . $name . "\n";
$emailBody .= "บริษัท / องค์กร: " . ($company ?: '-') . "\n";
$emailBody .= "อีเมล: " . $email . "\n";
$emailBody .= "เบอร์โทรศัพท์: " . $phone . "\n";
$emailBody .= "--------------------------------------------------\n";
$emailBody .= "ข้อความ:\n" . $message . "\n";
$emailBody .= "--------------------------------------------------\n";
$emailBody .= "ยินยอมรับข่าวสารการตลาด: " . ($consent_marketing ? "ยินยอม" : "ไม่ยินยอม") . "\n";

$headers = [
    'From: Synergy Website <noreply@syntechnology.com>',
    'Reply-To: ' . $name . ' <' . $email . '>',
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/plain; charset=UTF-8'
];

// Try sending email via PHP mail() or WordPress wp_mail if available
if (function_exists('wp_mail')) {
    @wp_mail($to, "ข้อความใหม่จากเว็บไซต์: " . $name, $emailBody, implode("\r\n", $headers));
} else {
    @mail($to, $subject, $emailBody, implode("\r\n", $headers));
}

// Return clean success response
echo json_encode([
    'success' => true,
    'message' => 'ขอบคุณครับ เราได้รับข้อมูลของคุณเรียบร้อยแล้ว ทีมผู้เชี่ยวชาญจะติดต่อกลับโดยเร็วที่สุด'
]);
exit;
