-- 1️⃣ Création de la base
CREATE DATABASE IF NOT EXISTS oop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE oop;

-- 2️⃣ Création de la table `user`
CREATE TABLE IF NOT EXISTS user (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- 3️⃣ Insertion de 20 utilisateurs fictifs
INSERT INTO user (name, email, password) VALUES
('Alice Dupont', 'alice.dupont@example.com', MD5('password1')),
('Bob Martin', 'bob.martin@example.com', MD5('password2')),
('Charlie Leroy', 'charlie.leroy@example.com', MD5('password3')),
('David Petit', 'david.petit@example.com', MD5('password4')),
('Emma Moreau', 'emma.moreau@example.com', MD5('password5')),
('François Bernard', 'francois.bernard@example.com', MD5('password6')),
('Gabriel Richard', 'gabriel.richard@example.com', MD5('password7')),
('Hélène Dubois', 'helene.dubois@example.com', MD5('password8')),
('Isabelle Simon', 'isabelle.simon@example.com', MD5('password9')),
('Jacques Michel', 'jacques.michel@example.com', MD5('password10')),
('Karine Fournier', 'karine.fournier@example.com', MD5('password11')),
('Louis Girard', 'louis.girard@example.com', MD5('password12')),
('Marie Lambert', 'marie.lambert@example.com', MD5('password13')),
('Nicolas Roy', 'nicolas.roy@example.com', MD5('password14')),
('Océane Faure', 'oceane.faure@example.com', MD5('password15')),
('Pauline Blanc', 'pauline.blanc@example.com', MD5('password16')),
('Quentin Pelletier', 'quentin.pelletier@example.com', MD5('password17')),
('Raphaël Dupuis', 'raphael.dupuis@example.com', MD5('password18')),
('Sophie Marchand', 'sophie.marchand@example.com', MD5('password19')),
('Thomas Henry', 'thomas.henry@example.com', MD5('password20'));
