<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Enrollment.php';

class EnrollmentController extends BaseController {

    private $enrollModel;

    public function __construct() {
        $this->enrollModel = new Enrollment();
    }

    // Đăng ký khóa học
    public function enroll() {
        $this->requireRole([0]); // chỉ học viên được đăng ký

        $studentId = $_SESSION['user']['id'];
        $courseId  = $_GET['course_id'] ?? 0;

        // kiểm tra đã đăng ký chưa
        if ($this->enrollModel->isEnrolled($studentId, $courseId)) {
            $_SESSION['msg'] = "Bạn đã đăng ký khóa học này rồi!";
            header("Location: index.php?controller=course&action=detail&id=$courseId");
            exit;
        }

        // thực hiện đăng ký
        if ($this->enrollModel->enroll($studentId, $courseId)) {
            $_SESSION['msg'] = "Đăng ký khóa học thành công!";
        } else {
            $_SESSION['msg'] = "Đăng ký thất bại.";
        }

        header("Location: index.php?controller=student&action=myCourses");
        exit;
    }
}
