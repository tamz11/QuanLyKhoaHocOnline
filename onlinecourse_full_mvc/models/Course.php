<?php

require_once __DIR__ . '/../config/Database.php';

class Course {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();  // ⭐ FIX LỖI Ở ĐÂY
    }
    /* ============================
       LẤY TẤT CẢ KHÓA HỌC
    ============================= */
    public function getAllApproved() {
        $sql = "SELECT 
                    c.*, 
                    u.fullname AS instructor_name
                FROM courses c
                LEFT JOIN users u ON c.instructor_id = u.id
                ORDER BY c.id DESC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

   public function getAll() {
        return $this->pdo->query("
            SELECT c.*, u.fullname AS instructor_name
            FROM courses c
            LEFT JOIN users u ON c.instructor_id = u.id
            ORDER BY c.id DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
    /* ============================
       LỌC THEO DANH MỤC
    ============================= */
    public function getByCategory($categoryId) {
        $sql = "SELECT c.*, u.fullname AS instructor_name
                FROM courses c
                LEFT JOIN users u ON c.instructor_id = u.id
                WHERE c.category_id = ?
                ORDER BY c.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    


    /* ============================
       TÌM KIẾM KHÓA HỌC
    ============================= */
    public function search($keyword) {
        $keyword = "%$keyword%";
        $sql = "SELECT c.*, u.fullname AS instructor_name
                FROM courses c
                LEFT JOIN users u ON c.instructor_id = u.id
                WHERE c.title LIKE ? OR c.description LIKE ?
                ORDER BY c.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================
       LẤY CHI TIẾT KHÓA HỌC
    ============================= */
    public function findById($id) {
        $sql = "SELECT 
                    c.id,
                    c.title,
                    c.description,
                    c.duration_weeks,
                    c.level,
                    c.price,
                    c.image,
                    u.fullname AS instructor
                FROM courses c
                LEFT JOIN users u ON c.instructor_id = u.id
                WHERE c.id = ?
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
                    c.id,
                    c.title,
                    c.description,
                    c.level,
                    c.price,
                    c.image,
                    u.fullname AS instructor_name,
                    COUNT(e.id) AS total_students
                FROM courses c
                LEFT JOIN enrollments e ON c.id = e.course_id
                LEFT JOIN users u ON c.instructor_id = u.id
                GROUP BY c.id
                ORDER BY total_students DESC
                LIMIT 4";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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

    




    public function countByInstructor() {
        $sql = "SELECT u.fullname, COUNT(c.id) AS total_courses
                FROM users u
                LEFT JOIN courses c ON u.id = c.instructor_id
                WHERE u.role = 1
                GROUP BY u.id";
        return $this->pdo->query($sql)->fetchAll();
    }




}
