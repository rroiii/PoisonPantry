-- SQL statements to create the tables and insert data

-- Drop the tables if they already exist
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `poisons`;
DROP TABLE IF EXISTS `admins`;

-- Create the users table
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) NOT NULL UNIQUE,
  `password` VARCHAR(65) NOT NULL,
  `balances` INT(15) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Insert two users into the users table with MD5 hashed passwords
INSERT INTO `users` (`username`, `password`,`balances`)
VALUES
  ('janedoe', MD5('123456'), 500),
  ('johndoe', MD5('p@ssword'), 200);

-- Create the poisons table
CREATE TABLE `poisons` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(40) NOT NULL,
  `pricess` INT(8) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Insert four items into the poisons table
INSERT INTO `poisons` (`name`, `pricess`)
VALUES
  ('Potion of Regeneration', 30),
  ('Potion of Fire Resistance', 55),
  ('Potion of Strength', 40),
  ('Potion of Invisibility', 100);

-- Create the admins table
CREATE TABLE `admins` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) NOT NULL UNIQUE,
  `password` VARCHAR(65) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Insert one admin user into the admins table with MD5 hashed password
INSERT INTO `admins` (`username`, `password`)
VALUES ('admin', MD5('admin'));