CREATE DATABASE image_upload;
CREATE TABLE users (
    id INT NOT NULL  AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL ,
    password VARCHAR(255) NOT NULL,
    image varchar(100)
);