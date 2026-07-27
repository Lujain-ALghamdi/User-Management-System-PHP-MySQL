<?php
/**
 * db.php
 * ---------------------------------------------------------
 * Database connection file for the "Dreamy Users" app.
 * Uses MySQLi (procedural) for compatibility with InfinityFree.
 *
 * IMPORTANT: Update the 4 constants below with the database
 * credentials from your InfinityFree control panel
 * (Control Panel > MySQL Databases).
 * ---------------------------------------------------------
 */

// ======= CONFIGURE YOUR DATABASE CREDENTIALS HERE =======
define('DB_HOST', 'sql300.infinityfree.com'); // InfinityFree MySQL hostname (NOT localhost)
define('DB_USER', 'if0_42505682');             // Your InfinityFree MySQL username
define('DB_PASS', 'EXCHnWdygCNd93');         // Your InfinityFree MySQL password
define('DB_NAME', 'if0_42505682_dreamy_users'); // Your InfinityFree database name
// ==========================================================

// Create the connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection and stop execution with a friendly message if it fails
if (!$conn) {
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . mysqli_connect_error()
    ]));
}

// Force UTF-8 so names with accents/emojis display correctly
mysqli_set_charset($conn, 'utf8mb4');
?>
