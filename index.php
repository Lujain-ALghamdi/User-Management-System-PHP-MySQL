<?php
/**
 * index.php
 * ---------------------------------------------------------
 * Main page: shows the user form and the users table.
 * The initial table is rendered server-side with PHP (so it
 * works even if JavaScript is disabled), then script.js takes
 * over to refresh it dynamically via AJAX after that.
 * ---------------------------------------------------------
 */
require_once 'db.php';

// Fetch users for the initial page load
$sql = "SELECT id, name, age, gender, status FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$initialUsers = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $initialUsers[] = $row;
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>✨ Dreamy Users ✨</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Decorative floating clouds & stars -->
  <div class="sky-decor" aria-hidden="true">
    <span class="cloud c1">☁️</span>
    <span class="cloud c2">☁️</span>
    <span class="cloud c3">☁️</span>
    <span class="star s1">✨</span>
    <span class="star s2">⭐</span>
    <span class="star s3">✨</span>
    <span class="star s4">💫</span>
  </div>

  <div class="page-wrap">

    <header class="hero">
      <h1>🌸 Dreamy Users ✨</h1>
    </header>

    <!-- ================= FORM CARD ================= -->
    <section class="card form-card">
      <form id="userForm" class="user-form" autocomplete="off">
  <div class="field">
    <label for="name">Name 🌷</label>
    <input type="text" id="name" name="name" placeholder="e.g. Sara" required>
  </div>

  <div class="field">
    <label for="age">Age 🎂</label>
    <input type="number" id="age" name="age" placeholder="e.g. 22" min="1" max="120" required>
  </div>

  <div class="field">
    <label>Gender 💕</label>
    <div class="gender-options">
      <label class="radio-pill">
        <input type="radio" name="gender" value="Female" checked>
        <span>Female ♀️</span>
      </label>
      <label class="radio-pill">
        <input type="radio" name="gender" value="Male">
        <span>Male ♂️</span>
      </label>
    </div>
  </div>

  <div class="field submit-field">
    <button type="submit" id="submitBtn" class="btn-primary">  Submit 🌸  </button>
  </div>
</form>
      <p id="formMessage" class="form-message" role="alert"></p>
    </section>

    <!-- ================= TABLE CARD ================= -->
    <section class="card table-card">
      <h2 class="table-title">💌 Registered Users</h2>

      <div class="table-scroll">
        <table id="usersTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Age</th>
              <th>Gender</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="usersTableBody">
            <?php if (empty($initialUsers)): ?>
              <tr class="empty-row">
                <td colspan="6">No users yet — be the first to add one! 🌷</td>
              </tr>
            <?php else: foreach ($initialUsers as $u): ?>
              <tr data-id="<?php echo (int)$u['id']; ?>">
                <td><?php echo (int)$u['id']; ?></td>
                <td><?php echo htmlspecialchars($u['name']); ?></td>
                <td><?php echo (int)$u['age']; ?></td>
                <td><?php echo htmlspecialchars($u['gender']); ?></td>
                <td class="status-cell">
                  <span class="status-badge <?php echo $u['status'] == 1 ? 'active' : 'inactive'; ?>">
                    <?php echo $u['status'] == 1 ? 'Active 💗' : 'Inactive 🤍'; ?>
                  </span>
                </td>
                <td>
                  <button class="btn-toggle" data-id="<?php echo (int)$u['id']; ?>">Toggle 🔄</button>
                </td>
              </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </section>

  </div>

<script src="script.js"></script>
</body>
</html>
