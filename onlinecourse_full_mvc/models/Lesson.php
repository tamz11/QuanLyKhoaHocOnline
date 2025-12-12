<?php
require_once __DIR__ . '/../config/Database.php';

class Lesson {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getByCourse($courseId) {
        $sql = "SELECT * FROM lessons WHERE course_id = ? ORDER BY `order` ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO lessons (course_id, title, content, video_url, `order`)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['course_id'],
            $data['title'],
            $data['content'],
            $data['video_url'] ?? null,
            $data['order'] ?? 1
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE lessons SET title = ?, content = ?, video_url = ?, `order` = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['content'],
            $data['video_url'] ?? null,
            $data['order'] ?? 1,
            $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM lessons WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function findById($id) {
        $sql = "SELECT * FROM lessons WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMaxOrder($courseId) {
        $sql = "SELECT MAX(`order`) as max_order FROM lessons WHERE course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$courseId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['max_order'] ?? 0;
    }
}
