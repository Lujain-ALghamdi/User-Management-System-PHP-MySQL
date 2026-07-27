# 🌸 Dreamy User Management System ✨

A simple and elegant user management system built using HTML, CSS, JavaScript, PHP, and MySQL.
The project allows users to add personal information, store it in a MySQL database, display registered users in a table, and update user status using a toggle button without refreshing the page.

---
<img width="2880" height="1920" alt="لقطة شاشة 2026-07-27 070147" src="https://github.com/user-attachments/assets/36ff3128-3521-45f8-ab94-4e03955f0c3f" />
<img width="2880" height="1920" alt="لقطة شاشة 2026-07-27 071244" src="https://github.com/user-attachments/assets/fa3b7b29-cb55-4bf3-82d3-d980965e0d89" />

## ✨ Project Features

- Add users through a simple form.
- Store user information in a MySQL database.
- Display all registered users in a table (ID, Name, Age, Gender, Status, Action).
- Toggle user status between Active and Inactive (0 ⇄ 1) — no page reload.
- Update status instantly using AJAX.
- Responsive UI design with soft colors and decorative elements.

---

## 🛠️ Technologies Used

- HTML
- CSS
- JavaScript
- PHP
- MySQL
- InfinityFree Hosting

---

## 📁 Project Structure
dreamy-users/
├── index.php          # Main page (form + table)
├── db.php              # Database connection settings
├── add_user.php        # Handles form submission (INSERT)
├── fetch_users.php     # Returns all users as JSON (for AJAX refresh)
├── toggle_status.php   # Flips a user's status (0/1) via AJAX
├── style.css           # All styling (pastel/feminine theme)
├── script.js            # Client-side AJAX logic
├── database.sql         # SQL to create the `users` table
└── README.md             # This file

---

## 🗄️ Database Structure
Table name: users

| Column | Type          | Notes                            |
|--------|---------------|----------------------------------|
| id     | INT           | AUTO_INCREMENT, PRIMARY KEY      |
| name   | VARCHAR(50)   |                                  |
| age    | INT           |                                  |
| gender | VARCHAR(10)   | "Male" or "Female"               |
| status | INT           | Default `0`; toggled to `1`      |

The full SQL is in database.sql.

---

Made with 💗 and a little bit of sparkle ✨
