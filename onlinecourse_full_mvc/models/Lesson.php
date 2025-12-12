<?php
require_once __DIR__ . '/../config/Database.php';

class Lesson {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    /* ============================================================
       💠 1. CHỨC NĂNG CHUNG
       ============================================================ */

    /**
     * Lấy danh sách bài học của một khóa học
     * Thường dùng để hiển thị danh sách lesson theo đúng thứ tự
     */
    public function getByCourse($courseId) {
        $sql = "SELECT * FROM lessons 
                WHERE course_id = ? 
                ORDER BY `order` ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ============================================================
       💠 2. CHỨC NĂNG DÀNH CHO HỌC VIÊN (Student)
       ============================================================ */

    /**
     * Lấy danh sách bài học kèm trạng thái hoàn thành (is_done)
     */
    public function getLessonsWithProgress($courseId, $studentId) {
        $sql = "SELECT 
                    l.*,
                    CASE WHEN lp.completed = 1 THEN 1 ELSE 0 END AS is_done
                FROM lessons l
                LEFT JOIN lesson_progress lp
                    ON lp.lesson_id = l.id 
                   AND lp.student_id = ?
                WHERE l.course_id = ?
                ORDER BY l.`order` ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy thông tin chi tiết của một bài học
     */
    public function findById($lessonId) {
        $sql = "SELECT * FROM lessons WHERE id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$lessonId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách tài liệu thuộc một bài học
     */
    public function getMaterials($lessonId) {
        $sql = "SELECT * FROM materials 
                WHERE lesson_id = ? 
                ORDER BY uploaded_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$lessonId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đánh dấu bài học là đã hoàn thành
     */
    public function markLessonAsDone($studentId, $courseId, $lessonId) {

        // Kiểm tra đã tồn tại record chưa
        $sqlCheck = "SELECT id 
                     FROM lesson_progress 
                     WHERE student_id = ? AND lesson_id = ? 
                     LIMIT 1";

        $stmt = $this->pdo->prepare($sqlCheck);
        $stmt->execute([$studentId, $lessonId]);

        if ($stmt->fetch()) {
            // Đã có => coi như done
            return true;
        }

        // Tạo mới record
        $sql = "INSERT INTO lesson_progress (student_id, course_id, lesson_id) 
                VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$studentId, $courseId, $lessonId]);
    }

    /**
     * Bỏ trạng thái hoàn thành bài học (không bắt buộc phải dùng)
     */
    public function unmarkLesson($studentId, $lessonId) {
        $sql = "DELETE FROM lesson_progress 
                WHERE student_id = ? AND lesson_id = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$studentId, $lessonId]);
    }


    /* ============================================================
       💠 3. CHỨC NĂNG DÀNH CHO GIẢNG VIÊN / ADMIN (CRUD LESSON)
       ============================================================ */

    /**
     * Tạo bài học mới
     */
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

    /**
     * Cập nhật bài học
     */
    public function update($id, $data) {
        $sql = "UPDATE lessons 
                SET title = ?, content = ?, video_url = ?, `order` = ? 
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['content'],
            $data['video_url'] ?? null,
            $data['order'] ?? 1,
            $id
        ]);
    }

    /**
     * Xóa bài học
     */
    public function delete($id) {
        $sql = "DELETE FROM lessons WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Lấy thứ tự lớn nhất (order) để thêm bài mới đúng vị trí
     */
    public function getMaxOrder($courseId) {
        $sql = "SELECT MAX(`order`) AS max_order 
                FROM lessons 
                WHERE course_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$courseId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['max_order'] ?? 0;
    }
}
