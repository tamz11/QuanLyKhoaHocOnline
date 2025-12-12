<?php
require_once __DIR__ . '/../config/Database.php';

class Material {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getByCourse($courseId) {
        $sql = "SELECT m.*, l.title AS lesson_title
                FROM materials m
                LEFT JOIN lessons l ON m.lesson_id = l.id
                WHERE l.course_id = ?
                ORDER BY m.uploaded_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO materials (lesson_id, filename, file_path, file_type)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['lesson_id'],
            $data['filename'],
            $data['file_path'],
            $data['file_type']
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM materials WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function findById($id) {
        $sql = "SELECT * FROM materials WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
