-- =========================================================
-- database.sql
-- Run this in phpMyAdmin (InfinityFree Control Panel > MySQL
-- Databases > phpMyAdmin) after creating your database.
-- =========================================================

CREATE TABLE IF NOT EXISTS `users` (
  `id`     INT AUTO_INCREMENT PRIMARY KEY,
  `name`   VARCHAR(50)  NOT NULL,
  `age`    INT          NOT NULL,
  `gender` VARCHAR(10)  NOT NULL,
  `status` INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional: a couple of sample rows to see the table styled immediately
INSERT INTO `users` (`name`, `age`, `gender`, `status`) VALUES
('Sara', 22, 'Female', 0),
('Layla', 27, 'Female', 1),
('Omar', 30, 'Male', 0);
