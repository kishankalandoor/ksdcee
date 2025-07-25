-- SQL setup for Project Management System
-- Run this script to create the necessary tables

-- Projects table
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `technologies` varchar(500) DEFAULT NULL,
  `github_url` varchar(500) DEFAULT NULL,
  `demo_url` varchar(500) DEFAULT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `views` int(11) DEFAULT 0,
  `rating` decimal(3,2) DEFAULT 0.00,
  `comments_count` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category` (`category`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Project Comments table
CREATE TABLE IF NOT EXISTS `project_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`),
  FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Project Ratings table
CREATE TABLE IF NOT EXISTS `project_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `rating` int(1) NOT NULL CHECK (`rating` >= 1 AND `rating` <= 5),
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_project_rating` (`project_id`, `user_id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`),
  KEY `rating` (`rating`),
  FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Project Views table (to track unique views)
CREATE TABLE IF NOT EXISTS `project_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`),
  KEY `viewed_at` (`viewed_at`),
  FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Project Likes table (optional - for future enhancement)
CREATE TABLE IF NOT EXISTS `project_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_project_like` (`project_id`, `user_id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`),
  FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Triggers to update project statistics

-- Trigger to update comments count when a comment is added
DELIMITER $$
CREATE TRIGGER `update_comments_count_after_insert` 
AFTER INSERT ON `project_comments` 
FOR EACH ROW 
BEGIN
    UPDATE `projects` 
    SET `comments_count` = (
        SELECT COUNT(*) 
        FROM `project_comments` 
        WHERE `project_id` = NEW.`project_id` AND `status` = 'active'
    )
    WHERE `id` = NEW.`project_id`;
END$$
DELIMITER ;

-- Trigger to update comments count when a comment is deleted
DELIMITER $$
CREATE TRIGGER `update_comments_count_after_delete` 
AFTER DELETE ON `project_comments` 
FOR EACH ROW 
BEGIN
    UPDATE `projects` 
    SET `comments_count` = (
        SELECT COUNT(*) 
        FROM `project_comments` 
        WHERE `project_id` = OLD.`project_id` AND `status` = 'active'
    )
    WHERE `id` = OLD.`project_id`;
END$$
DELIMITER ;

-- Trigger to update average rating when a rating is added or updated
DELIMITER $$
CREATE TRIGGER `update_rating_after_insert` 
AFTER INSERT ON `project_ratings` 
FOR EACH ROW 
BEGIN
    UPDATE `projects` 
    SET `rating` = (
        SELECT AVG(`rating`) 
        FROM `project_ratings` 
        WHERE `project_id` = NEW.`project_id`
    )
    WHERE `id` = NEW.`project_id`;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `update_rating_after_update` 
AFTER UPDATE ON `project_ratings` 
FOR EACH ROW 
BEGIN
    UPDATE `projects` 
    SET `rating` = (
        SELECT AVG(`rating`) 
        FROM `project_ratings` 
        WHERE `project_id` = NEW.`project_id`
    )
    WHERE `id` = NEW.`project_id`;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `update_rating_after_delete` 
AFTER DELETE ON `project_ratings` 
FOR EACH ROW 
BEGIN
    UPDATE `projects` 
    SET `rating` = COALESCE((
        SELECT AVG(`rating`) 
        FROM `project_ratings` 
        WHERE `project_id` = OLD.`project_id`
    ), 0)
    WHERE `id` = OLD.`project_id`;
END$$
DELIMITER ;

-- Insert some sample data (optional)
-- Uncomment the following lines if you want to insert sample projects

/*
INSERT INTO `projects` (`title`, `description`, `category`, `technologies`, `github_url`, `demo_url`, `user_id`, `username`) VALUES
('Weather App', 'A beautiful weather application that shows current weather and 5-day forecast using OpenWeatherMap API.', 'Web Development', 'HTML, CSS, JavaScript, API Integration', 'https://github.com/user/weather-app', 'https://weather-app-demo.com', 1, 'john_doe'),
('Task Manager', 'A full-stack task management application with user authentication and real-time updates.', 'Web Development', 'React, Node.js, Express, MongoDB', 'https://github.com/user/task-manager', 'https://task-manager-demo.com', 1, 'john_doe'),
('Machine Learning Stock Predictor', 'A Python application that uses machine learning to predict stock prices using historical data.', 'Machine Learning', 'Python, TensorFlow, Pandas, NumPy', 'https://github.com/user/stock-predictor', NULL, 2, 'jane_smith');
*/

-- Create uploads directory structure (Note: This needs to be done manually or via PHP)
-- Directory structure needed:
-- uploads/
-- └── projects/
--     └── (uploaded project screenshots will go here)

-- Grant necessary permissions (adjust as needed for your setup)
-- GRANT SELECT, INSERT, UPDATE, DELETE ON your_database.* TO 'your_user'@'localhost';

COMMIT;
