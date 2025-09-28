-- SQL script to add description columns to room and cottage tables
-- Execute these commands in your database to add the new columns

-- Add room_description column to room table
ALTER TABLE `room` 
ADD COLUMN `room_description` TEXT NULL AFTER `photo`;

-- Add cottage_description column to cottage table  
ALTER TABLE `cottage` 
ADD COLUMN `cottage_description` TEXT NULL AFTER `photo`;

-- Optional: Add some sample descriptions for existing records
-- UPDATE `room` SET `room_description` = 'Comfortable room with modern amenities' WHERE `room_description` IS NULL;
-- UPDATE `cottage` SET `cottage_description` = 'Cozy cottage perfect for relaxation' WHERE `cottage_description` IS NULL;
