<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Buscar usuario para el Login
    public function getByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :un LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':un', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear nuevo usuario (Registro)
    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                (cedula, telefono, domicilio, nombres, apellidos, email, username, password, role, copia_cedula, record_policial) 
                VALUES (:cedula, :telefono, :domicilio, :nombres, :apellidos, :email, :username, :password, :role, :cc, :rp)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }
}
?>