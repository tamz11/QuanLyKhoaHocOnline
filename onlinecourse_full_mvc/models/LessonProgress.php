<?php
require_once __DIR__ . '/../config/Database.php';

class LessonProgress {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getByStudentAndCourse($studentId, $courseId) {
        $sql = "SELECT lp.*, l.title AS lesson_title, l.order AS lesson_order
                FROM lesson_progress lp
                LEFT JOIN lessons l ON lp.lesson_id = l.id
                WHERE lp.student_id = ? AND lp.course_id = ?
                ORDER BY l.order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markCompleted($studentId, $courseId, $lessonId) {
        $sql = "INSERT INTO lesson_progress (student_id, course_id, lesson_id, completed)
                VALUES (?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE completed = 1";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$studentId, $courseId, $lessonId]);
    }

    public function isCompleted($studentId, $lessonId) {
        $sql = "SELECT completed FROM lesson_progress WHERE student_id = ? AND lesson_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $lessonId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['completed'] : 0;
    }

    public function getCompletedCount($studentId, $courseId) {
        $sql = "SELECT COUNT(*) as completed FROM lesson_progress
                WHERE student_id = ? AND course_id = ? AND completed = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['completed'] ?? 0;
    }
}