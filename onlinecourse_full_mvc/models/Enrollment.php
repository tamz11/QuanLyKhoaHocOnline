<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getByCourse($courseId) {
        $sql = "SELECT e.*, u.fullname, u.email, e.enrolled_date, e.progress
                FROM enrollments e
                LEFT JOIN users u ON e.student_id = u.id
                WHERE e.course_id = ?
                ORDER BY e.enrolled_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByStudentAndCourse($studentId, $courseId) {
        $sql = "SELECT * FROM enrollments WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProgress($studentId, $courseId, $progress) {
        $sql = "UPDATE enrollments SET progress = ? WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$progress, $studentId, $courseId]);
    }

    public function enroll($studentId, $courseId) {
        $sql = "INSERT INTO enrollments (student_id, course_id, enrolled_date, status, progress)
                VALUES (?, ?, NOW(), 'active', 0)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$studentId, $courseId]);
    }

    public function countByCourse($courseId) {
        $sql = "SELECT COUNT(*) as total FROM enrollments WHERE course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetch()['total'] ?? 0;
    }
}
