<?php
<<<<<<< HEAD
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
=======
class Plan {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $sql = "SELECT * FROM planes ORDER BY id_plan DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM planes WHERE id_plan = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO planes (nombre_plan, megas, costo) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['nombre_plan'], $data['megas'], $data['costo']]);
    }

    // --- NUEVOS MÉTODOS ---

    public function update($data) {
        $sql = "UPDATE planes SET nombre_plan = ?, megas = ?, costo = ? WHERE id_plan = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['nombre_plan'], 
            $data['megas'], 
            $data['costo'], 
            $data['id_plan']
        ]);
    }

    public function delete($id) {
        // Usamos try-catch porque si el plan está siendo usado por un cliente,
        // la base de datos lanzará un error de integridad referencial.
        try {
            $stmt = $this->db->prepare("DELETE FROM planes WHERE id_plan = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
>>>>>>> master
    }
}