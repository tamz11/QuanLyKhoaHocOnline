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



    // =================================================================
    // 1) HIỂN THỊ FORM GỬI YÊU CẦU TRỞ THÀNH GIẢNG VIÊN
    // =================================================================
    public function requestInstructor()
    {
        $this->requireRole([0]); // chỉ học viên mới được gửi yêu cầu

        $requestModel = new InstructorRequest();

        // Kiểm tra user đã gửi yêu cầu trước chưa
        $existing = $requestModel->findByUserId($_SESSION['user']['id']);

        $this->render("student/request_instructor", [
            'existing' => $existing
        ]);
    }



    // =================================================================
    // 2) XỬ LÝ POST GỬI YÊU CẦU
    // =================================================================
    public function doRequestInstructor()
    {
        $this->requireRole([0]);

        // chỉ cho phép POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect("index.php?controller=student&action=requestInstructor");
        }

        $description = trim($_POST['description'] ?? '');

        if (empty($description)) {
            echo "<script>alert('Vui lòng nhập lý do!'); window.history.back();</script>";
            return;
        }

        $userId = $_SESSION['user']['id'];
        $requestModel = new InstructorRequest();

        // kiểm tra đã gửi yêu cầu trước đó
        if ($requestModel->findByUserId($userId)) {
            echo "<script>alert('Bạn đã gửi yêu cầu trước đó rồi!'); window.history.back();</script>";
            return;
        }

        // Tạo yêu cầu
        $requestModel->create([
            'user_id'    => $userId,
            'message'    => $description,
            'status'     => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        echo "<script>
                alert('Gửi yêu cầu thành công! Vui lòng chờ Admin duyệt.');
                window.location = 'index.php?controller=student&action=dashboard';
              </script>";
    }
}
