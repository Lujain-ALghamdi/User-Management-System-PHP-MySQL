<?php
/**
 * fetch_users.php
 * ---------------------------------------------------------
 * Retrieves all rows from the "users" table and returns
 * them as JSON so JavaScript can render/refresh the table
 * without reloading the page.
 * ---------------------------------------------------------
 */

header('Content-Type: application/json');
require_once 'db.php';

$sql = "SELECT id, name, age, gender, status FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$users = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Cast types so JS receives clean numbers, not strings
        $row['id']     = (int)$row['id'];
        $row['age']    = (int)$row['age'];
        $row['status'] = (int)$row['status'];
        $users[] = $row;
    }
    echo json_encode(['success' => true, 'users' => $users]);
} else {
    echo json_encode(['success' => false, 'message' => 'Could not fetch users.']);
}

mysqli_close($conn);
?>
