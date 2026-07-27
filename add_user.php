<?php
/**
 * add_user.php
 * ---------------------------------------------------------
 * Receives form data (via AJAX/POST), validates it, and
 * inserts a new row into the "users" table using a
 * prepared statement. Returns JSON.
 * ---------------------------------------------------------
 */

header('Content-Type: application/json');
require_once 'db.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// ---------- Collect & sanitize input ----------
$name   = isset($_POST['name'])   ? trim($_POST['name'])   : '';
$age    = isset($_POST['age'])    ? trim($_POST['age'])    : '';
$gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';

// ---------- Validation ----------
$errors = [];

if ($name === '') {
    $errors[] = 'Name is required.';
} elseif (!preg_match("/^[a-zA-Z\s'\-]{2,50}$/", $name)) {
    $errors[] = 'Name must be 2-50 letters only.';
}

if ($age === '' || !is_numeric($age) || (int)$age < 1 || (int)$age > 120) {
    $errors[] = 'Please enter a valid age between 1 and 120.';
}

if (!in_array($gender, ['Male', 'Female'], true)) {
    $errors[] = 'Please select a valid gender.';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

$age = (int)$age;

// ---------- Insert using a prepared statement ----------
$sql = "INSERT INTO users (name, age, gender, status) VALUES (?, ?, ?, 0)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: could not prepare statement.']);
    exit;
}

mysqli_stmt_bind_param($stmt, 'sis', $name, $age, $gender);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        'success' => true,
        'message' => 'User added successfully! ✨',
        'id'      => mysqli_insert_id($conn)
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add user. Please try again.']);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
