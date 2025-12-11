<?php
require_once __DIR__ . '/../config/Database.php';

class Lesson {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Lấy tất cả lesson theo course (thường dùng để hiển thị danh sách)
    public function getByCourse($courseId) {
        $sql = "SELECT * FROM lessons WHERE course_id = ? ORDER BY `order` ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy lessons + trạng thái (is_done) cho 1 học viên
    public function getLessonsWithProgress($courseId, $studentId) {
        $sql = "SELECT 
                    l.*,
                    CASE WHEN lp.completed = 1 THEN 1 ELSE 0 END AS is_done
                FROM lessons l
                LEFT JOIN lesson_progress lp
                    ON lp.lesson_id = l.id AND lp.student_id = ?
                WHERE l.course_id = ?
                ORDER BY l.`order` ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 lesson theo id
    public function findById($lessonId) {
        $sql = "SELECT * FROM lessons WHERE id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$lessonId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy tài liệu cho 1 lesson
    public function getMaterials($lessonId) {
        $sql = "SELECT * FROM materials WHERE lesson_id = ? ORDER BY uploaded_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$lessonId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đánh dấu 1 lesson là đã làm (tạo record trong lesson_progress nếu chưa có)
    public function markLessonAsDone($studentId, $courseId, $lessonId) {
        // kiểm tra đã có chưa
        $sqlCheck = "SELECT id FROM lesson_progress WHERE student_id = ? AND lesson_id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sqlCheck);
        $stmt->execute([$studentId, $lessonId]);
        if ($stmt->fetch()) {
            return true; // đã có rồi
        }

        $sql = "INSERT INTO lesson_progress (student_id, course_id, lesson_id) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$studentId, $courseId, $lessonId]);
    }

    // Nếu cần bỏ dấu hoàn thành (không bắt buộc)
    public function unmarkLesson($studentId, $lessonId) {
        $sql = "DELETE FROM lesson_progress WHERE student_id = ? AND lesson_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$studentId, $lessonId]);
    }
}
