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
}
