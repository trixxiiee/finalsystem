CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    usertype VARCHAR(59) NOT NULL DEFAULT 'user',
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    profilepicture VARCHAR(255) NOT NULL DEFAULT 'upload/default.png',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    otp VARCHAR(6)
);

CREATE TABLE IF NOT EXISTS recipeee (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    dish_name VARCHAR(255) NOT NULL,
    recipe TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending'
);

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    recipe_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES recipeee(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    FOREIGN KEY (recipe_id) REFERENCES recipeee(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS recipe_archive (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    dish_name VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    recipe TEXT COLLATE utf8mb4_general_ci DEFAULT NULL,
    category VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    image_path VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    status ENUM('approved', 'rejected') COLLATE utf8mb4_general_ci DEFAULT NULL,
    archived_at DATETIME DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS meal_plans (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    day DATE NOT NULL,
    breakfast text COLLATE utf8mb4_general_ci DEFAULT NULL,
    lunch text COLLATE utf8mb4_general_ci DEFAULT NULL,
    snack text COLLATE utf8mb4_general_ci DEFAULT NULL,
    dinner text COLLATE utf8mb4_general_ci DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS user_activity_logs (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    activity VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
