<?php
// models/Plan.php
require_once __DIR__ . '/../config/database.php';

class Plan {
    private $db;

    public function __construct() {
        // Llamada estática para asegurar que $this->db no sea null
        $this->db = Database::connect(); 
    }

    public function create($data) {
        // Esta es la línea 18 que te daba error
        $stmt = $this->db->prepare("INSERT INTO planes (nombre_plan, costo, megas) VALUES (?, ?, ?)");
        return $stmt->execute([
            $data['nombre_plan'], 
            $data['costo'], 
            $data['megas']
        ]);
    }

    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM planes ORDER BY id_plan ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}