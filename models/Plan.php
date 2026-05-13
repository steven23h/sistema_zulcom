<?php

require_once __DIR__ . '/../config/database.php';

class Plan {

    private $db;

    public function __construct($db = null) {

        // Si no recibe conexión, crea una automáticamente
        $this->db = $db ?: Database::connect();
    }

    // =========================
    // LISTAR TODOS LOS PLANES
    // =========================
    public function getAll() {

        $sql = "SELECT * FROM planes ORDER BY id_plan DESC";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    // =========================
    // OBTENER PLAN POR ID
    // =========================
    public function getById($id) {

        $stmt = $this->db->prepare(
            "SELECT * FROM planes WHERE id_plan = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =========================
    // CREAR PLAN
    // =========================
    public function create($data) {

        $sql = "
            INSERT INTO planes (
                nombre_plan,
                megas,
                costo
            )
            VALUES (?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['nombre_plan'],
            $data['megas'],
            $data['costo']
        ]);
    }

    // =========================
    // ACTUALIZAR PLAN
    // =========================
    public function update($data) {

        $sql = "
            UPDATE planes
            SET
                nombre_plan = ?,
                megas = ?,
                costo = ?
            WHERE id_plan = ?
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['nombre_plan'],
            $data['megas'],
            $data['costo'],
            $data['id_plan']
        ]);
    }

    // =========================
    // ELIMINAR PLAN
    // =========================
    public function delete($id) {

        try {

            $stmt = $this->db->prepare(
                "DELETE FROM planes WHERE id_plan = ?"
            );

            return $stmt->execute([$id]);

        } catch (PDOException $e) {

            return false;
        }
    }
}