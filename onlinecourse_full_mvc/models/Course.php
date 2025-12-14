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
                WHERE c.approved = 1
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
                WHERE c.category_id = ? AND c.approved = 1
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
                WHERE (c.title LIKE ? OR c.description LIKE ?) AND c.approved = 1
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
                    c.category_id,
                    c.instructor_id,
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
        $sql = "SELECT COUNT(*) FROM courses";
        return (int) $this->pdo->query($sql)->fetchColumn();
    }

    public function countPending() {
        $sql = "SELECT COUNT(*) FROM courses WHERE approved = 0";
        return (int) $this->pdo->query($sql)->fetchColumn();
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
                WHERE c.approved = 1
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

    /* ============================
       CRUD CHO GIẢNG VIÊN
    ============================= */
    public function getByInstructor($instructorId) {
        $sql = "SELECT c.*, cat.name AS category_name
                FROM courses c
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.instructor_id = ?
                ORDER BY c.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$instructorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data, $instructorId) {
        $sql = "INSERT INTO courses (title, description, category_id, instructor_id, duration_weeks, level, price, image, approved)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['category_id'],
            $instructorId,
            $data['duration_weeks'],
            $data['level'],
            $data['price'],
            $data['image'] ?? null
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE courses SET title = ?, description = ?, category_id = ?, duration_weeks = ?, level = ?, price = ?, image = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['category_id'],
            $data['duration_weeks'],
            $data['level'],
            $data['price'],
            $data['image'] ?? null,
            $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM courses WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /* ============================
       THỐNG KÊ DASHBOARD GIẢNG VIÊN
    ============================= */
    public function getInstructorStats($instructorId) {
        // Tổng khóa học
        $sqlCourses = "SELECT COUNT(*) as total_courses FROM courses WHERE instructor_id = ?";
        $stmtCourses = $this->pdo->prepare($sqlCourses);
        $stmtCourses->execute([$instructorId]);
        $totalCourses = $stmtCourses->fetch()['total_courses'] ?? 0;

        // Tổng học viên (từ tất cả khóa học của giảng viên)
        $sqlStudents = "SELECT COUNT(DISTINCT e.student_id) as total_students 
                        FROM enrollments e 
                        JOIN courses c ON e.course_id = c.id 
                        WHERE c.instructor_id = ?";
        $stmtStudents = $this->pdo->prepare($sqlStudents);
        $stmtStudents->execute([$instructorId]);
        $totalStudents = $stmtStudents->fetch()['total_students'] ?? 0;

        // Tổng bài giảng
        $sqlLessons = "SELECT COUNT(*) as total_lessons 
                       FROM lessons l 
                       JOIN courses c ON l.course_id = c.id 
                       WHERE c.instructor_id = ?";
        $stmtLessons = $this->pdo->prepare($sqlLessons);
        $stmtLessons->execute([$instructorId]);
        $totalLessons = $stmtLessons->fetch()['total_lessons'] ?? 0;

        return [
            'totalCourses' => $totalCourses,
            'totalStudents' => $totalStudents,
            'totalLessons' => $totalLessons
        ];
    }

    public function getRecentCoursesWithCounts($instructorId, $limit = 5) {
        $sql = "SELECT 
                    c.id, 
                    c.title, 
                    cat.name AS category_name,
                    (SELECT COUNT(*) FROM lessons WHERE course_id = c.id) AS lessons_count,
                    (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) AS students_count
                FROM courses c
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.instructor_id = ?
                ORDER BY c.created_at DESC
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(1, $instructorId, PDO::PARAM_INT);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} 
