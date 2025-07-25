-- Add OAuth support columns to tbl_login table
-- Run this SQL to add support for social login

ALTER TABLE `tbl_login` 
ADD COLUMN `google_id` VARCHAR(255) NULL DEFAULT NULL,
ADD COLUMN `github_id` INT NULL DEFAULT NULL,
ADD COLUMN `oauth_provider` ENUM('local', 'google', 'github') DEFAULT 'local',
ADD COLUMN `email_verified` TINYINT(1) DEFAULT 0,
ADD COLUMN `profile_picture` VARCHAR(500) NULL DEFAULT NULL,
ADD COLUMN `last_login` TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN `login_attempts` INT DEFAULT 0,
ADD COLUMN `locked_until` TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Add indexes for better performance
ALTER TABLE `tbl_login` 
ADD INDEX `idx_google_id` (`google_id`),
ADD INDEX `idx_github_id` (`github_id`),
ADD INDEX `idx_oauth_provider` (`oauth_provider`),
ADD INDEX `idx_email` (`useremail`);

-- Create a table for passkey credentials
CREATE TABLE IF NOT EXISTS `user_passkeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `credential_id` varchar(255) NOT NULL,
  `public_key` text NOT NULL,
  `counter` int(11) DEFAULT 0,
  `device_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_used` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `credential_id` (`credential_id`),
  KEY `user_id` (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `tbl_login` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create a table for login sessions
CREATE TABLE IF NOT EXISTS `user_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`),
  KEY `user_id` (`user_id`),
  KEY `expires_at` (`expires_at`),
  FOREIGN KEY (`user_id`) REFERENCES `tbl_login` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create a table for security logs
CREATE TABLE IF NOT EXISTS `security_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text,
  `details` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `action` (`action`),
  KEY `created_at` (`created_at`),
  FOREIGN KEY (`user_id`) REFERENCES `tbl_login` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Update existing users to have email_verified = 1 if they registered normally
UPDATE `tbl_login` SET `email_verified` = 1 WHERE `oauth_provider` = 'local';

COMMIT;
