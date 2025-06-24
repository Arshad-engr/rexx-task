<?php
require_once 'dbconnection.php';

function createSchemaIfNotExists(PDO $pdo) {
    // Create users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) UNIQUE NOT NULL
        );
    ");

    // Create events table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS events (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(200) NOT NULL,
            event_date DATE NOT NULL
        );
    ");

    // Create bookings (pivot) table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS bookings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            participation_id INT NOT NULL,
            event_id INT NOT NULL,
            participation_fee DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (participation_id) REFERENCES users(id),
            FOREIGN KEY (event_id) REFERENCES events(id)
        );
    ");
}
