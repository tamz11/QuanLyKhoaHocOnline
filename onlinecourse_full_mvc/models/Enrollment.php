<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Kiểm tra đã đăng ký hay chưa
    public function isEnrolled($studentId, $courseId) {
        $sql = "SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetch() ? true : false;
    }

    // Đăng ký khóa học
    public function enroll($studentId, $courseId) {
        $sql = "INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$studentId, $courseId]);
    }

    // Lấy danh sách khóa học của học viên
    public function getMyCourses($studentId) {
        $sql = "SELECT 
                    c.id,
                    c.title,
                    c.image,
                    c.description AS short_description,
                    u.fullname AS instructor_name,
                    e.progress
                FROM enrollments e
                INNER JOIN courses c ON e.course_id = c.id
                LEFT JOIN users u ON c.instructor_id = u.id
                WHERE e.student_id = ?
                ORDER BY e.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy progress tổng từ enrollments
    public function getCourseProgress($studentId, $courseId) {
        $sql = "SELECT progress FROM enrollments WHERE student_id = ? AND course_id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['progress'] : 0;
    }

    // Cập nhật progress (phần trăm) trong enrollments
    public function updateProgress($studentId, $courseId, $progress) {
        $sql = "UPDATE enrollments SET progress = ? WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([(int)$progress, $studentId, $courseId]);
    }

    // Tính progress dựa trên số bài đã hoàn thành và cập nhật (helper)
    public function recalcAndUpdateProgress($studentId, $courseId) {
        // tổng số bài
        $sqlTotal = "SELECT COUNT(*) AS total FROM lessons WHERE course_id = ?";
        $stmt = $this->pdo->prepare($sqlTotal);
        $stmt->execute([$courseId]);
        $total = (int)($stmt->fetchColumn() ?: 0);

        if ($total === 0) {
            $progress = 0;
        } else {
            $sqlDone = "SELECT COUNT(*) FROM lesson_progress WHERE student_id = ? AND course_id = ?";
            $stmt2 = $this->pdo->prepare($sqlDone);
            $stmt2->execute([$studentId, $courseId]);
            $done = (int)($stmt2->fetchColumn() ?: 0);
            $progress = (int)round(($done / $total) * 100);
        }

        // cập nhật vào enrollments
        $this->updateProgress($studentId, $courseId, $progress);
        return $progress;
    }

    // Thống kê cho dashboard
    public function getOverallProgress($studentId) {
        $sql = "SELECT AVG(e.progress) as avgProgress FROM enrollments e WHERE e.student_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)round($row['avgProgress']) : 0;
    }

    public function countMyCourses($studentId) {
        $sql = "SELECT COUNT(*) FROM enrollments WHERE student_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId]);
        return (int)$stmt->fetchColumn();
    }

    public function countCompletedCourses($studentId) {
        $sql = "SELECT COUNT(*) FROM enrollments WHERE student_id = ? AND progress >= 100";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId]);
        return (int)$stmt->fetchColumn();
    }
    // đánh dấu hoàn thành 1 bài học
    public function markLessonDone($studentId, $courseId, $lessonId) {
        $sql = "INSERT INTO lesson_progress (student_id, course_id, lesson_id, completed)
                VALUES (?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE completed = 1";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$studentId, $courseId, $lessonId]);
    }


    // lấy danh sách bài học đã hoàn thành
    public function getCompletedLessons($studentId, $courseId) {
        $sql = "SELECT lesson_id FROM lesson_progress 
                WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

}
