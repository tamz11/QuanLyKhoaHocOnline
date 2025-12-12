<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }


    /* ============================================================
       💠 1. CHỨC NĂNG CHO HỌC VIÊN (Student)
       ============================================================ */

    /**
     * Kiểm tra học viên đã đăng ký khóa học hay chưa
     */
    public function isEnrolled($studentId, $courseId) {
        $sql = "SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetch() ? true : false;
    }

    /**
     * Học viên đăng ký khóa học
     * => phiên bản chuẩn theo master: có ngày đăng ký, trạng thái, progress
     */
    public function enroll($studentId, $courseId) {
        $sql = "INSERT INTO enrollments (student_id, course_id, enrolled_date, status, progress)
                VALUES (?, ?, NOW(), 'active', 0)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$studentId, $courseId]);
    }

    /**
     * Lấy danh sách khóa học mà học viên đã đăng ký
     */
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

    /**
     * Lấy tiến độ tổng của học viên trong 1 khóa học
     */
    public function getCourseProgress($studentId, $courseId) {
        $sql = "SELECT progress FROM enrollments WHERE student_id = ? AND course_id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['progress'] : 0;
    }

    /**
     * Cập nhật phần trăm tiến độ trong bảng enrollments
     */
    public function updateProgress($studentId, $courseId, $progress) {
        $sql = "UPDATE enrollments SET progress = ? WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([(int)$progress, $studentId, $courseId]);
    }

    /**
     * Tính lại tiến độ dựa trên số bài đã hoàn thành & lưu vào database
     */
    public function recalcAndUpdateProgress($studentId, $courseId) {
        // Đếm tổng số bài học
        $sqlTotal = "SELECT COUNT(*) AS total FROM lessons WHERE course_id = ?";
        $stmt = $this->pdo->prepare($sqlTotal);
        $stmt->execute([$courseId]);
        $total = (int)($stmt->fetchColumn() ?: 0);

        if ($total === 0) {
            $progress = 0;
        } else {
            // Đếm số bài đã hoàn thành
            $sqlDone = "SELECT COUNT(*) FROM lesson_progress 
                        WHERE student_id = ? AND course_id = ?";
            $stmt2 = $this->pdo->prepare($sqlDone);
            $stmt2->execute([$studentId, $courseId]);
            $done = (int)($stmt2->fetchColumn() ?: 0);

            // Tính %
            $progress = (int)round(($done / $total) * 100);
        }

        // Lưu tiến độ
        $this->updateProgress($studentId, $courseId, $progress);
        return $progress;
    }


    /**
     * Đánh dấu hoàn thành 1 bài học
     */
    public function markLessonDone($studentId, $courseId, $lessonId) {
        $sql = "INSERT INTO lesson_progress (student_id, course_id, lesson_id, completed)
                VALUES (?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE completed = 1";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$studentId, $courseId, $lessonId]);
    }

    /**
     * Lấy danh sách các bài học đã hoàn thành
     */
    public function getCompletedLessons($studentId, $courseId) {
        $sql = "SELECT lesson_id FROM lesson_progress 
                WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Tiến độ trung bình của học viên (dashboard)
     */
    public function getOverallProgress($studentId) {
        $sql = "SELECT AVG(e.progress) AS avgProgress 
                FROM enrollments e 
                WHERE e.student_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? (int)round($row['avgProgress']) : 0;
    }

    /**
     * Tổng số khóa học học viên đã đăng ký
     */
    public function countMyCourses($studentId) {
        $sql = "SELECT COUNT(*) FROM enrollments WHERE student_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId]);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Số khóa học đã hoàn thành (progress >= 100)
     */
    public function countCompletedCourses($studentId) {
        $sql = "SELECT COUNT(*) 
                FROM enrollments 
                WHERE student_id = ? AND progress >= 100";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId]);
        return (int)$stmt->fetchColumn();
    }



    /* ============================================================
       💠 2. CHỨC NĂNG DÀNH CHO GIẢNG VIÊN / ADMIN
       ============================================================ */

    /**
     * Lấy danh sách học viên đã đăng ký 1 khóa học (cho giảng viên)
     */
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

    /**
     * Lấy thông tin 1 lượt đăng ký của học viên trong 1 khóa học
     */
    public function getByStudentAndCourse($studentId, $courseId) {
        $sql = "SELECT * FROM enrollments WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm số lượng học viên đã đăng ký 1 khóa học
     */
    public function countByCourse($courseId) {
        $sql = "SELECT COUNT(*) AS total FROM enrollments WHERE course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetch()['total'] ?? 0;
    }
}
