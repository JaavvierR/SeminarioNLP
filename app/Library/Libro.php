<?php

namespace App\Library;

use PDO;
use PDOException;

class Libro
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getLibros()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM libro");
            $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($libros);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al obtener los libros: ' . $e->getMessage()]);
        }
    }

    public function getLibro($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM libro WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $libro = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($libro) {
                echo json_encode($libro);
            } else {
                echo json_encode(['error' => 'Libro no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al obtener el libro: ' . $e->getMessage()]);
        }
    }

    public function createLibro()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['titulo']) || empty($data['autor']) || empty($data['fecha'])) {
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO libro (titulo, autor, fecha) VALUES (:titulo, :autor, :fecha)");
            $stmt->execute([
                'titulo' => $data['titulo'],
                'autor' => $data['autor'],
                'fecha' => $data['fecha']
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al crear el libro: ' . $e->getMessage()]);
        }
    }

    public function updateLibro($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['titulo']) || empty($data['autor']) || empty($data['fecha'])) {
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE libro SET titulo = :titulo, autor = :autor, fecha = :fecha WHERE id = :id");
            $stmt->execute([
                'titulo' => $data['titulo'],
                'autor' => $data['autor'],
                'fecha' => $data['fecha'],
                'id' => $id
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al actualizar el libro: ' . $e->getMessage()]);
        }
    }

    public function deleteLibro($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM libro WHERE id = :id");
            $stmt->execute(['id' => $id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Libro no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al eliminar el libro: ' . $e->getMessage()]);
        }
    }
}
