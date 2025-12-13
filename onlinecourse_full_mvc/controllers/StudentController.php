<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/InstructorRequest.php';

class StudentController extends BaseController {

    private $enrollModel;
    private $lessonModel;
    private $courseModel;

    public function __construct() {
        require_once __DIR__ . '/../models/Enrollment.php';
        require_once __DIR__ . '/../models/Lesson.php';
        require_once __DIR__ . '/../models/Course.php';

        $this->enrollModel = new Enrollment();
        $this->lessonModel = new Lesson();
        $this->courseModel = new Course();
    }

    // Dashboard học viên
    public function dashboard() {
        $this->requireRole([0, 1, 2]); // học viên + giảng viên + admin

        $studentId = $_SESSION['user']['id'];

        $overallProgress = $this->enrollModel->getOverallProgress($studentId);
        $totalCourses = $this->enrollModel->countMyCourses($studentId);
        $completedCourses = $this->enrollModel->countCompletedCourses($studentId);

        $this->render('student/dashboard', [
            'overallProgress' => $overallProgress,
            'totalCourses' => $totalCourses,
            'completedCourses' => $completedCourses,
            'currentUser' => $_SESSION['user']
        ]);
    }

    // Khóa học đã đăng ký
    public function myCourses() {
        $this->requireRole([0, 1, 2]);

        $studentId = $_SESSION['user']['id'];
        $myCourses = $this->enrollModel->getMyCourses($studentId);

        $this->render('student/my_courses', [
            'myCourses' => $myCourses,
            'currentUser' => $_SESSION['user']
        ]);
    }

    // Tiến độ học tập
    public function courseProgress() {
        $this->requireRole([0, 1, 2]);

        $studentId = $_SESSION['user']['id'];
        $courseId  = $_GET['course_id'] ?? null;

        if (!$courseId) {
            header("Location: index.php?controller=student&action=myCourses");
            exit;
        }

        // Course
        $course = $this->courseModel->findById($courseId);

        // Lessons + trạng thái
        $lessons = $this->lessonModel->getLessonsWithProgress($courseId, $studentId);

        // Danh sách lesson đã hoàn thành (ID)
        $completedLessons = $this->enrollModel->getCompletedLessons($studentId, $courseId);

        // Xác định current lesson
        if (!empty($lessons)) {
            $lessonId = $_GET['lesson_id'] ?? $lessons[0]['id'];
            $currentLesson = $this->lessonModel->findById($lessonId);
        } else {
            $currentLesson = null;
        }

        // Materials
        $materials = $currentLesson
            ? $this->lessonModel->getMaterials($currentLesson['id'])
            : [];

        // Progress
        $progress = $this->enrollModel->recalcAndUpdateProgress($studentId, $courseId);

        $this->render('student/course_progress', [
            'course'           => $course,
            'lessons'          => $lessons,
            'currentLesson'    => $currentLesson,
            'materials'        => $materials,
            'completedLessons' => $completedLessons,
            'progress'         => $progress,
            'currentUser'      => $_SESSION['user']
        ]);
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

        // kiểm tra đã gửi yêu cầu chưa
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

    // =================================================================
    // 3) ĐÁNH DẤU BÀI HỌC HOÀN THÀNH (TỪ MASTER)
    // =================================================================
    public function markDone() {
        $this->requireRole([0]);

        $studentId = $_SESSION['user']['id'];
        $courseId = $_GET['course_id'] ?? 0;
        $lessonId = $_GET['lesson_id'] ?? 0;

        // Đánh dấu hoàn thành bài học
        $this->lessonModel->markLessonAsDone($studentId, $courseId, $lessonId);

        // Cập nhật tiến độ
        $this->enrollModel->recalcAndUpdateProgress($studentId, $courseId);

        header("Location: index.php?controller=student&action=courseProgress&course_id=$courseId&lesson_id=$lessonId");
        exit;
    }
        // Xử lý cập nhật mật khẩu
    public function updatePassword() {
        $this->requireRole([0, 1, 2]); // học viên, giảng viên, admin

        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        $userId = $_SESSION['user']['id'];

        // Lấy dữ liệu từ form
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // 1) Kiểm tra mật khẩu mới và xác nhận
        if ($new !== $confirm) {
            $_SESSION['error'] = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
            header("Location: index.php?controller=student&action=changePassword");
            exit;
        }

        // 2) Lấy thông tin user hiện tại
        $user = $userModel->getUserById($userId);

        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy tài khoản!";
            header("Location: index.php?controller=student&action=changePassword");
            exit;
        }

        // 3) Kiểm tra mật khẩu hiện tại
        if (!password_verify($current, $user['password'])) {
            $_SESSION['error'] = "Mật khẩu hiện tại không chính xác!";
            header("Location: index.php?controller=student&action=changePassword");
            exit;
        }

        // 4) Cập nhật mật khẩu mới
        $userModel->updatePassword($userId, $new);

        $_SESSION['success'] = "Thay đổi mật khẩu thành công!";
        header("Location: index.php?controller=student&action=changePassword");
        exit;
    }

}

