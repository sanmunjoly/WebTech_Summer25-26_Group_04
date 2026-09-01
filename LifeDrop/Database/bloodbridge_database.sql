-- ==========================================
-- BloodBridge Blood Donation Management System
-- Database File for XAMPP MySQL
-- ==========================================


CREATE DATABASE IF NOT EXISTS bloodbridge_db;

USE bloodbridge_db;


-- ==========================================
-- 1. USERS TABLE
-- Admin, Donor and Recipient accounts
-- ==========================================

CREATE TABLE users (

    user_id INT AUTO_INCREMENT PRIMARY KEY,

    full_name VARCHAR(100) NOT NULL,

    email VARCHAR(100) UNIQUE NOT NULL,

    password VARCHAR(255) NOT NULL,

    phone VARCHAR(20),

    address TEXT,

    blood_group VARCHAR(5),

    gender VARCHAR(20),

    role ENUM('admin','donor','recipient') NOT NULL,

    account_status ENUM('active','inactive') DEFAULT 'active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);



-- ==========================================
-- 2. DONOR PROFILE TABLE
-- ==========================================

CREATE TABLE donor_profile (

    donor_id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    age INT,

    last_donation_date DATE,

    availability ENUM('available','unavailable') DEFAULT 'available',

    total_donation INT DEFAULT 0,

    FOREIGN KEY(user_id)
    REFERENCES users(user_id)
    ON DELETE CASCADE

);



-- ==========================================
-- 3. RECIPIENT PROFILE TABLE
-- ==========================================

CREATE TABLE recipient_profile (

    recipient_id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    patient_age INT,

    disease_info TEXT,

    emergency_contact VARCHAR(20),

    FOREIGN KEY(user_id)
    REFERENCES users(user_id)
    ON DELETE CASCADE

);



-- ==========================================
-- 4. BLOOD REQUEST TABLE
-- ==========================================

CREATE TABLE blood_requests (

    request_id INT AUTO_INCREMENT PRIMARY KEY,

    recipient_id INT NOT NULL,

    blood_group VARCHAR(5) NOT NULL,

    required_units INT DEFAULT 1,

    hospital_name VARCHAR(150),

    location VARCHAR(150),

    request_date DATE,

    priority ENUM(
        'normal',
        'urgent',
        'emergency'
    )
    DEFAULT 'normal',

    message TEXT,


    status ENUM(
        'pending',
        'approved',
        'rejected',
        'completed'
    )
    DEFAULT 'pending',


    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,


    FOREIGN KEY(recipient_id)
    REFERENCES recipient_profile(recipient_id)
    ON DELETE CASCADE

);



-- ==========================================
-- 5. DONATION HISTORY TABLE
-- ==========================================

CREATE TABLE donation_history (

    donation_id INT AUTO_INCREMENT PRIMARY KEY,

    donor_id INT NOT NULL,

    recipient_id INT NOT NULL,

    blood_group VARCHAR(5),

    donation_date DATE,

    hospital_name VARCHAR(150),

    location VARCHAR(150),

    status ENUM(
        'pending',
        'completed'
    )
    DEFAULT 'pending',


    FOREIGN KEY(donor_id)
    REFERENCES donor_profile(donor_id)
    ON DELETE CASCADE,


    FOREIGN KEY(recipient_id)
    REFERENCES recipient_profile(recipient_id)
    ON DELETE CASCADE

);



-- ==========================================
-- 6. DONOR REQUEST ACCEPTANCE TABLE
-- ==========================================

CREATE TABLE donor_requests (

    id INT AUTO_INCREMENT PRIMARY KEY,

    request_id INT NOT NULL,

    donor_id INT NOT NULL,


    response ENUM(
        'accepted',
        'rejected',
        'pending'
    )
    DEFAULT 'pending',


    response_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,


    FOREIGN KEY(request_id)
    REFERENCES blood_requests(request_id)
    ON DELETE CASCADE,


    FOREIGN KEY(donor_id)
    REFERENCES donor_profile(donor_id)
    ON DELETE CASCADE

);



-- ==========================================
-- 7. BLOOD STOCK TABLE
-- Admin manages blood availability
-- ==========================================

CREATE TABLE blood_stock (

    stock_id INT AUTO_INCREMENT PRIMARY KEY,

    blood_group VARCHAR(5) UNIQUE,

    available_units INT DEFAULT 0,

    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

);



-- ==========================================
-- 8. NOTIFICATION TABLE
-- ==========================================

CREATE TABLE notifications (

    notification_id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    message TEXT,

    notification_status ENUM(
        'read',
        'unread'
    )
    DEFAULT 'unread',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,


    FOREIGN KEY(user_id)
    REFERENCES users(user_id)
    ON DELETE CASCADE

);



-- ==========================================
-- DEFAULT ADMIN ACCOUNT
-- Email: admin@gmail.com
-- Password: admin123
-- ==========================================

INSERT INTO users
(
full_name,
email,
password,
role
)

VALUES
(
'System Administrator',
'admin@gmail.com',
'admin123',
'admin'
);



-- ==========================================
-- INITIAL BLOOD STOCK
-- ==========================================

INSERT INTO blood_stock
(
blood_group,
available_units
)

VALUES

('A+',0),
('A-',0),
('B+',0),
('B-',0),
('AB+',0),
('AB-',0),
('O+',0),
('O-',0);



-- ==========================================
-- CHECK DATABASE TABLES
-- ==========================================

SHOW TABLES;