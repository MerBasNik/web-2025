CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    avatar VARCHAR(255),
    name VARCHAR(100) NOT NULL,
    about TEXT,
    count_posts INT DEFAULT 0
);