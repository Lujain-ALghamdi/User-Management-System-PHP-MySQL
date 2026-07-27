<?php
/**
 * toggle_status.php
 * ---------------------------------------------------------
 * Flips the "status" field of a single user between 0 and 1.
 * Expects a POST request with an "id" field.
 * Returns the new status as JSON so the front end can update
 * the table instantly without a page refresh.
 * ---------------------------------------------------------
 */

header('Content-Type: application/json');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid user id.']);
    exit;
}

// ---------- Get current status ----------
$stmt = mysqli_prepare($conn, "SELECT status FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
    exit;
}

// ---------- Flip 0 <-> 1 ----------
$newStatus = $user['status'] == 1 ? 0 : 1;

$updateStmt = mysqli_prepare($conn, "UPDATE users SET status = ? WHERE id = ?");
mysqli_stmt_bind_param($updateStmt, 'ii', $newStatus, $id);

if (mysqli_stmt_execute($updateStmt)) {
    echo json_encode(['success' => true, 'id' => $id, 'status' => $newStatus]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
}

mysqli_stmt_close($updateStmt);
mysqli_close($conn);
?>
