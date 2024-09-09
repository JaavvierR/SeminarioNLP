<?php

namespace App\Library;

use PDO;
use PDOException;

class Pais
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPaises()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM Pais");
            $paises = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($paises);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al obtener los países: ' . $e->getMessage()]);
        }
    }

    public function getPais($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Pais WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $pais = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($pais) {
                echo json_encode($pais);
            } else {
                echo json_encode(['error' => 'País no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al obtener el país: ' . $e->getMessage()]);
        }
    }

    public function createPais()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nom_pais'])) {
            echo json_encode(['error' => 'Nombre del país es requerido']);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO Pais (nom_pais) VALUES (:nom_pais)");
            $stmt->execute(['nom_pais' => $data['nom_pais']]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al crear el país: ' . $e->getMessage()]);
        }
    }

    public function updatePais($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nom_pais'])) {
            echo json_encode(['error' => 'Nombre del país es requerido']);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE Pais SET nom_pais = :nom_pais WHERE id = :id");
            $stmt->execute([
                'nom_pais' => $data['nom_pais'],
                'id' => $id
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al actualizar el país: ' . $e->getMessage()]);
        }
    }

    public function deletePais($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Pais WHERE id = :id");
            $stmt->execute(['id' => $id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'País no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al eliminar el país: ' . $e->getMessage()]);
        }
    }
}
