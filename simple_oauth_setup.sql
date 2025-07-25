-- Simple OAuth columns addition for existing tbl_login table
-- Copy and paste these commands into phpMyAdmin SQL tab

-- Add OAuth columns to existing tbl_login table
ALTER TABLE `tbl_login` 
ADD COLUMN `google_id` VARCHAR(100) NULL,
ADD COLUMN `github_id` VARCHAR(100) NULL,
ADD COLUMN `auth_provider` VARCHAR(20) DEFAULT 'local';

-- Show the updated table structure
DESCRIBE `tbl_login`;
