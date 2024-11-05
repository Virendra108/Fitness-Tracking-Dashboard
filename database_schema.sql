create database myfitnessdashboard;
use myfitnessdashboard;
CREATE TABLE Users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    age INT,
    gender ENUM('Male', 'Female', 'Other', 'Prefer Not to Say'),
    height_cm DECIMAL(5, 2),
    weight_kg DECIMAL(5, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Credentials (
    credential_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    password_hash VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE FitnessData (
    data_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    date DATE NOT NULL,
    steps INT,
    distance_km DECIMAL(5, 2),
    calories_burned DECIMAL(6, 2),
    active_minutes INT,
    sleep_hours DECIMAL(3, 1),
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE APISource (
    source_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
    description TEXT,
    api_url VARCHAR(255)
);

CREATE TABLE UserPreferences (
    preference_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    display_unit ENUM('metric', 'imperial') DEFAULT 'metric',
    daily_goal_steps INT DEFAULT 10000,
    daily_goal_calories DECIMAL(6, 2),
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

ALTER TABLE Users
MODIFY first_name VARCHAR(50),
MODIFY last_name VARCHAR(50),
MODIFY age INT,
MODIFY gender ENUM('Male', 'Female', 'Other', 'Prefer Not to Say'),
MODIFY height_cm DECIMAL(5, 2),
MODIFY weight_kg DECIMAL(5, 2);

