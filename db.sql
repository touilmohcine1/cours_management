CREATE DATABASE cours_management

CREATE TABLE users (
    UserId INT AUTO_INCREMENT PRIMARY KEY,
    UserName VARCHAR(100) NOT NULL,
    UserEmail VARCHAR(100) NOT NULL UNIQUE,
    UserPass VARCHAR(255) NOT NULL,
    UserType ENUM('admin', 'professor', 'student') NOT NULL
);

CREATE TABLE courses (
    CourseId INT AUTO_INCREMENT PRIMARY KEY,
    CourseTitle VARCHAR(100) NOT NULL
);

CREATE TABLE files (
    FileId INT AUTO_INCREMENT PRIMARY KEY,
    FileTitle VARCHAR(100) NOT NULL,
    Path VARCHAR(255) NOT NULL,
    UploadDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    TelechargeCount INT DEFAULT 0,
    UserId INT,
    CourseId INT,
    FOREIGN KEY (UserId) REFERENCES users(UserId),
    FOREIGN KEY (CourseId) REFERENCES courses(CourseId)
);

/*
    pour créer des compte sur le platform
    username:admin
    mot de passe:admin
*/
INSERT INTO users (UserName,UserEmail,UserPass,UserType) VALUES ('admin','admin@gmail.com','$2y$10$bcXdwGpZtjAeN9C.SOEh8OMfAldh9oe8RYw.h0HUe0W8m/F8LhORa','admin');


SELECT * FROM users