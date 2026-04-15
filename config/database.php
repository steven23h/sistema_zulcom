<?php
// config/database.php
class Database {
    public static function connect() {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=zulcom;charset=utf8mb4", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo; 
        } catch (PDOException $e) {
            // Si falla aquí, verás el mensaje de error real de MySQL
            die("Fallo de conexión: " . $e->getMessage());
        }
    }
}