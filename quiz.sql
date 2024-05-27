USE quiz_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    class VARCHAR(50),
    phone VARCHAR(15),
    score INT DEFAULT 0
);
