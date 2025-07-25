-- Enhanced OAuth and Passkey Login Setup for KSDC22
-- Run this script to add social authentication and passkey support

-- Add OAuth columns to existing tbl_login table
ALTER TABLE tbl_login 
ADD COLUMN google_id VARCHAR(100) NULL,
ADD COLUMN github_id VARCHAR(100) NULL, 
ADD COLUMN auth_provider VARCHAR(20) DEFAULT 'local',
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Create table for storing passkey credentials
CREATE TABLE IF NOT EXISTS user_passkeys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    credential_id VARCHAR(255) NOT NULL UNIQUE,
    public_key TEXT NOT NULL,
    counter BIGINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_used TIMESTAMP NULL,
    device_name VARCHAR(100) DEFAULT 'Unknown Device',
    FOREIGN KEY (user_id) REFERENCES tbl_login(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_credential_id (credential_id)
);

-- Create table for OAuth tokens (optional - for token refresh)
CREATE TABLE IF NOT EXISTS oauth_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    provider VARCHAR(20) NOT NULL,
    access_token TEXT,
    refresh_token TEXT,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES tbl_login(id) ON DELETE CASCADE,
    INDEX idx_user_provider (user_id, provider)
);

-- Create table for login attempts and security auditing
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255),
    ip_address VARCHAR(45),
    user_agent TEXT,
    login_method VARCHAR(20), -- 'password', 'google', 'github', 'passkey'
    success BOOLEAN DEFAULT FALSE,
    failure_reason VARCHAR(100),
    attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_ip_time (ip_address, attempted_at)
);

-- Add indexes for better performance
ALTER TABLE tbl_login 
ADD INDEX idx_google_id (google_id),
ADD INDEX idx_github_id (github_id),
ADD INDEX idx_auth_provider (auth_provider);

-- Insert sample data to demonstrate multi-auth support
-- Note: Replace with actual test emails if needed
INSERT IGNORE INTO tbl_login (username, useremail, pass, auth_provider) VALUES 
('test@example.com', 'test@example.com', '$2y$10$example_hashed_password', 'local');

-- Create view for user authentication summary
CREATE OR REPLACE VIEW user_auth_summary AS
SELECT 
    tl.id,
    tl.username,
    tl.useremail,
    tl.auth_provider,
    COUNT(DISTINCT up.id) as passkey_count,
    COUNT(DISTINCT ot.id) as oauth_tokens_count,
    tl.created_at as account_created,
    MAX(la.attempted_at) as last_login_attempt
FROM tbl_login tl
LEFT JOIN user_passkeys up ON tl.id = up.user_id
LEFT JOIN oauth_tokens ot ON tl.id = ot.user_id  
LEFT JOIN login_attempts la ON tl.useremail = la.email AND la.success = TRUE
GROUP BY tl.id, tl.username, tl.useremail, tl.auth_provider, tl.created_at;

-- Grant necessary permissions (adjust as needed for your setup)
-- GRANT SELECT, INSERT, UPDATE ON ksdc_db.* TO 'your_web_user'@'localhost';

COMMIT;
