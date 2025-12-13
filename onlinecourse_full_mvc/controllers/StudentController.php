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

    // ================= DASHBOARD =================
    public function dashboard() {
        $this->requireRole([0, 1, 2]);

        $studentId = $_SESSION['user']['id'];

        $overallProgress   = $this->enrollModel->getOverallProgress($studentId);
        $totalCourses      = $this->enrollModel->countMyCourses($studentId);
        $completedCourses  = $this->enrollModel->countCompletedCourses($studentId);

        $this->render('student/dashboard', [
            'overallProgress'   => $overallProgress,
            'totalCourses'      => $totalCourses,
            'completedCourses'  => $completedCourses,
            'currentUser'       => $_SESSION['user']
        ]);
    }

    // ================= REQUEST INSTRUCTOR FORM =================
    public function requestInstructor() {
        $this->requireRole([0]);

        $requestModel = new InstructorRequest();
        $existing = $requestModel->findByUserId($_SESSION['user']['id']);

        $this->render("student/request_instructor", [
            'existing' => $existing
        ]);
    }

    // ================= HANDLE REQUEST (FIXED) =================
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

        // Đã gửi yêu cầu trước đó
        if ($requestModel->findByUserId($userId)) {
            $_SESSION['request_error'] = 'Bạn đã gửi yêu cầu trước đó rồi!';
            return $this->redirect("index.php?controller=student&action=requestInstructor");
        }

        // Tạo yêu cầu
        $requestModel->create([
            'user_id'    => $userId,
            'message'    => $description,
            'status'     => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // ✅ SUCCESS FLAG
        $_SESSION['request_success'] = true;

        return $this->redirect("index.php?controller=student&action=requestInstructor");
    }

    // ================= MARK LESSON DONE =================
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
}
