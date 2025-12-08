<?php

require_once __DIR__ . '/../config/Database.php';

class Course {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();  // ⭐ FIX LỖI Ở ĐÂY
    }

    public function countAll() {
        $sql = "SELECT COUNT(*) AS total FROM courses";
        return $this->pdo->query($sql)->fetch()['total'] ?? 0;
    }

    public function countPending() {
        $sql = "SELECT COUNT(*) AS total FROM courses WHERE approved = 0";
        return $this->pdo->query($sql)->fetch()['total'] ?? 0;
    }

    public function topCourses() {
        $sql = "SELECT 
                    c.title, 
                    u.fullname AS instructor,
                    COUNT(e.id) AS total_students
                FROM courses c
                LEFT JOIN enrollments e ON c.id = e.course_id
                LEFT JOIN users u ON c.instructor_id = u.id
                GROUP BY c.id
                ORDER BY total_students DESC
                LIMIT 5";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getPending() {
        $sql = "SELECT * FROM courses WHERE approved = 0";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function approve($id) {
        $sql = "UPDATE courses SET approved = 1 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function getAll() {
    return $this->pdo->query("SELECT c.*, u.fullname AS instructor 
                              FROM courses c 
                              LEFT JOIN users u ON c.instructor_id = u.id
                              ORDER BY c.id DESC")->fetchAll();
}



public function countByInstructor() {
    $sql = "SELECT u.fullname, COUNT(c.id) AS total_courses
            FROM users u
            LEFT JOIN courses c ON u.id = c.instructor_id
            WHERE u.role = 1
            GROUP BY u.id";
    return $this->pdo->query($sql)->fetchAll();
}



}
