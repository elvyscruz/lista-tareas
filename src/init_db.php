<?php
// Initialize SQLite database for todo app

try {
    // Create (or open) the database
    $pdo = new PDO('sqlite:todos.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create todos table
    $sql = "
    CREATE TABLE IF NOT EXISTS todos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        task TEXT NOT NULL,
        completed BOOLEAN DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);
    echo "Database initialized successfully!\n";

} catch(PDOException $e) {
    echo "Error creating database: " . $e->getMessage() . "\n";
}
?>