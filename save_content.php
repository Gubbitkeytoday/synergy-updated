<?php
ini_set('session.cookie_lifetime', 86400 * 365);
ini_set('session.gc_maxlifetime', 86400 * 365);
session_set_cookie_params([
    'lifetime' => 86400 * 365,
    'path' => '/',
    'httponly' => false,
    'samesite' => 'Lax'
]);
session_start();
header('Content-Type: application/json; charset=utf-8');

/**
 * Server-side auth gate.
 *
 * Only the server-set session (or a real WordPress login) counts. The
 * synergy_admin_auth cookie is written by the browser and is therefore proof of
 * nothing - it is fine for deciding whether to SHOW the edit button, but it must
 * never be what authorises a write.
 */
function synergy_is_admin() {
    if (!empty($_SESSION['synergy_admin_logged_in'])) {
        return true;
    }
    if (function_exists('is_user_logged_in') && is_user_logged_in()
        && function_exists('current_user_can') && current_user_can('edit_posts')) {
        return true;
    }
    return false;
}

function synergy_require_admin() {
    if (!synergy_is_admin()) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'ไม่ได้รับอนุญาต กรุณาเข้าสู่ระบบผู้ดูแลก่อน']);
        exit;
    }
}

// Handle Image Upload Request
if (isset($_GET['action']) && $_GET['action'] === 'upload_image') {
    synergy_require_admin();
    if (empty($_FILES['image_file']['tmp_name'])) {
        echo json_encode(['success' => false, 'error' => 'ไม่มีไฟล์ถูกอัปโหลด']);
        exit;
    }

    $file = $_FILES['image_file'];

    /* $file['type'] is supplied by the browser and can say anything, so the real
       type is read from the file itself. SVG is deliberately not accepted: it is
       a script-carrying document, and these files are served from our own origin. */
    $allowed = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG  => 'png',
        IMAGETYPE_GIF  => 'gif',
        IMAGETYPE_WEBP => 'webp',
    ];
    $info = @getimagesize($file['tmp_name']);
    if ($info === false || !isset($allowed[$info[2]])) {
        echo json_encode(['success' => false, 'error' => 'รองรับเฉพาะไฟล์รูปภาพ (JPG, PNG, WEBP, GIF) เท่านั้น']);
        exit;
    }
    $ext = $allowed[$info[2]];

    if ($file['size'] > 12 * 1024 * 1024) {
        echo json_encode(['success' => false, 'error' => 'ไฟล์ใหญ่เกิน 12 MB']);
        exit;
    }

    $uploadDir = __DIR__ . '/image/upload/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filename = 'img_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        /* Root-absolute, never './': this URL is written into content_*.json and
           rendered as an img src on pages served from /about/ etc., where a
           document-relative path would resolve to /about/image/upload/... */
        $baseUrl = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '';
        $relativeUrl = $baseUrl . '/image/upload/' . $filename;
        echo json_encode(['success' => true, 'url' => $relativeUrl, 'filename' => $filename]);
    } else {
        echo json_encode(['success' => false, 'error' => 'ไม่สามารถบันทึกไฟล์รูปภาพลงโฟลเดอร์ได้']);
    }
    exit;
}

// Handle Login request
if (isset($_GET['action']) && $_GET['action'] === 'login') {
    $input = json_decode(file_get_contents('php://input'), true);
    $user = trim($input['username'] ?? '');
    $pass = trim($input['password'] ?? '');

    $validUser = 'admin';
    $validPasses = ['admin', 'A)1^RTBFZaSL1cyI!PSg^YKI', 'synergy2026'];

    $is_valid = false;
    if ($user === $validUser && in_array($pass, $validPasses)) {
        $is_valid = true;
    } elseif (function_exists('wp_authenticate')) {
        $wp_user = wp_authenticate($user, $pass);
        if ($wp_user && !is_wp_error($wp_user)) {
            $is_valid = true;
        }
    }

    if ($is_valid) {
        $_SESSION['synergy_admin_logged_in'] = true;
        setcookie('synergy_admin_auth', '1', [
            'expires' => time() + (86400 * 365),
            'path' => '/',
            'httponly' => false,
            'samesite' => 'Lax'
        ]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง']);
    }
    exit;
}

/**
 * Navigation visibility.
 *
 * Stored in data/nav_config.json as a list of hidden nav ids:
 *   { "hidden": ["solutions.smart-factory", "case-studies"] }
 *
 * Visitors never call this endpoint - components/scripts.js reads the JSON file
 * directly, so hiding a link costs a static file read, not a PHP request. This
 * endpoint only writes.
 *
 * Hiding a link is presentation, not access control: the page itself stays
 * reachable by URL. Anything that must not be public needs to be unpublished or
 * blocked at the server, not removed from a menu.
 */
if (isset($_GET['action']) && $_GET['action'] === 'nav_save') {
    synergy_require_admin();

    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input) || !isset($input['hidden']) || !is_array($input['hidden'])) {
        echo json_encode(['success' => false, 'error' => 'รูปแบบข้อมูลไม่ถูกต้อง']);
        exit;
    }

    // Ids are generated by scripts.js and are always [a-z0-9.-]. Filtering here
    // keeps anything else from reaching the file, whatever the client sends.
    $hidden = [];
    foreach ($input['hidden'] as $id) {
        if (!is_string($id)) continue;
        $clean = preg_replace('/[^a-z0-9._-]/i', '', $id);
        if ($clean !== '' && strlen($clean) <= 80) {
            $hidden[] = $clean;
        }
    }
    $hidden = array_values(array_unique($hidden));

    if (!is_dir(__DIR__ . '/data')) {
        mkdir(__DIR__ . '/data', 0777, true);
    }
    $ok = file_put_contents(
        __DIR__ . '/data/nav_config.json',
        json_encode(['hidden' => $hidden], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );

    echo json_encode($ok
        ? ['success' => true, 'hidden' => $hidden]
        : ['success' => false, 'error' => 'บันทึกไฟล์ไม่สำเร็จ']);
    exit;
}

// Handle Check Auth Status
if (isset($_GET['action']) && $_GET['action'] === 'check') {
    // Reports the same answer the write endpoints enforce, so the UI can never
    // show an edit session that the server will then refuse to save.
    echo json_encode(['isLoggedIn' => synergy_is_admin()]);
    exit;
}

// Handle Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['synergy_admin_logged_in']);
    setcookie('synergy_admin_auth', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => false,
        'samesite' => 'Lax'
    ]);
    echo json_encode(['success' => true]);
    exit;
}

// Save Content API
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

synergy_require_admin();

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['page']) || !isset($data['fields'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid data format']);
    exit;
}

$page = preg_replace('/[^a-z0-9_-]/i', '', $data['page']);
$dataFile = __DIR__ . '/data/content_' . $page . '.json';

if (!is_dir(__DIR__ . '/data')) {
    mkdir(__DIR__ . '/data', 0777, true);
}

$current = [];
if (file_exists($dataFile)) {
    $current = json_decode(file_get_contents($dataFile), true) ?: [];
}

foreach ($data['fields'] as $key => $value) {
    $current[$key] = $value;
}

if (file_put_contents($dataFile, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo json_encode(['success' => true, 'page' => $page, 'updated' => count($data['fields'])]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to save file']);
}
