<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/InstructorRequest.php';

class StudentController extends BaseController {

    // Dashboard học viên
    public function dashboard() {
        $this->requireRole([0, 1, 2]); // học viên + giảng viên + admin
        $this->render('student/dashboard');
    }

    // Khóa học đã đăng ký
    public function myCourses() {
        $this->requireRole([0, 1, 2]);
        $this->render('student/my_courses');
    }

    // Tiến độ học tập
    public function courseProgress() {
        $this->requireRole([0, 1, 2]);
        $this->render('student/course_progress');
    }

    // Gửi phản hồi / đánh giá khóa học
    public function feedback() {
        $this->requireRole([0, 1, 2]);
        $this->render('student/feedback');
    }

    // Đổi mật khẩu
    public function changePassword() {
        $this->requireRole([0, 1, 2]);
        $this->render('student/change_password');
    }

}