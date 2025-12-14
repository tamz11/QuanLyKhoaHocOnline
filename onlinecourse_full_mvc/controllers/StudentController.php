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

    /* ================= DASHBOARD ================= */
    public function dashboard() {
        $this->requireRole([0, 1, 2]);

        $studentId = $_SESSION['user']['id'];

        $overallProgress  = $this->enrollModel->getOverallProgress($studentId);
        $totalCourses     = $this->enrollModel->countMyCourses($studentId);
        $completedCourses = $this->enrollModel->countCompletedCourses($studentId);

        $this->render('student/dashboard', [
            'overallProgress'  => $overallProgress,
            'totalCourses'     => $totalCourses,
            'completedCourses' => $completedCourses,
            'currentUser'      => $_SESSION['user']
        ]);
    }

    /* ================= KHÓA HỌC ĐÃ ĐĂNG KÝ ================= */
    public function myCourses() {
        $this->requireRole([0, 1, 2]);

        $studentId = $_SESSION['user']['id'];
        $myCourses = $this->enrollModel->getMyCourses($studentId);

        $this->render('student/my_courses', [
            'myCourses'   => $myCourses,
            'currentUser' => $_SESSION['user']
        ]);
    }

    /* ================= TIẾN ĐỘ HỌC TẬP ================= */
    public function courseProgress() {
        $this->requireRole([0, 1, 2]);

        $studentId = $_SESSION['user']['id'];
        $courseId  = $_GET['course_id'] ?? null;

        if (!$courseId) {
            header("Location: index.php?controller=student&action=myCourses");
            exit;
        }

        $course = $this->courseModel->findById($courseId);
        $lessons = $this->lessonModel->getLessonsWithProgress($courseId, $studentId);
        $completedLessons = $this->enrollModel->getCompletedLessons($studentId, $courseId) ?? [];

        if (!empty($lessons)) {
            $lessonId = $_GET['lesson_id'] ?? $lessons[0]['id'];
            $currentLesson = $this->lessonModel->findById($lessonId);
        } else {
            $currentLesson = null;
        }

        $materials = $currentLesson
            ? $this->lessonModel->getMaterials($currentLesson['id'])
            : [];

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

    /* ================= ĐỔI MẬT KHẨU ================= */
    public function changePassword() {
        $this->requireRole([0, 1, 2]);
        $this->render('student/change_password');
    }

    /* ================= FORM YÊU CẦU GIẢNG VIÊN ================= */
    public function requestInstructor() {
        $this->requireRole([0]);

        $requestModel = new InstructorRequest();
        $existing = $requestModel->findByUserId($_SESSION['user']['id']);

        $this->render('student/request_instructor', [
            'existing' => $existing
        ]);
    }

    /* ================= XỬ LÝ GỬI YÊU CẦU ================= */
    public function doRequestInstructor() {
        $this->requireRole([0]);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect("index.php?controller=student&action=requestInstructor");
        }

        $description = trim($_POST['description'] ?? '');

        if (empty($description)) {
            $_SESSION['request_error'] = 'Vui lòng nhập lý do!';
            return $this->redirect("index.php?controller=student&action=requestInstructor");
        }

        $userId = $_SESSION['user']['id'];
        $requestModel = new InstructorRequest();

        if ($requestModel->findByUserId($userId)) {
            $_SESSION['request_error'] = 'Bạn đã gửi yêu cầu trước đó rồi!';
            return $this->redirect("index.php?controller=student&action=requestInstructor");
        }

        $requestModel->create([
            'user_id'    => $userId,
            'message'    => $description,
            'status'     => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $_SESSION['request_success'] = true;
        return $this->redirect("index.php?controller=student&action=requestInstructor");
    }

    /* ================= ĐÁNH DẤU BÀI HỌC ================= */
    public function markDone() {
        $this->requireRole([0]);

        $studentId = $_SESSION['user']['id'];
        $courseId  = $_GET['course_id'] ?? 0;
        $lessonId  = $_GET['lesson_id'] ?? 0;

        $this->lessonModel->markLessonAsDone($studentId, $courseId, $lessonId);
        $this->enrollModel->recalcAndUpdateProgress($studentId, $courseId);

        header("Location: index.php?controller=student&action=courseProgress&course_id=$courseId&lesson_id=$lessonId");
        exit;
    }

    /* ================= CẬP NHẬT MẬT KHẨU ================= */
    public function updatePassword() {
        $this->requireRole([0, 1, 2]);

        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        $userId  = $_SESSION['user']['id'];
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($new !== $confirm) {
            $_SESSION['error'] = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
            header("Location: index.php?controller=student&action=changePassword");
            exit;
        }

        $user = $userModel->getUserById($userId);

        if (!$user || !password_verify($current, $user['password'])) {
            $_SESSION['error'] = "Mật khẩu hiện tại không chính xác!";
            header("Location: index.php?controller=student&action=changePassword");
            exit;
        }

        $userModel->updatePassword($userId, $new);

        $_SESSION['success'] = "Thay đổi mật khẩu thành công!";
        header("Location: index.php?controller=student&action=changePassword");
        exit;
    }
}
