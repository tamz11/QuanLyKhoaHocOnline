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

    // Tiến độ học tập - hiển thị bài và tiến độ
    public function courseProgress() {
        $this->requireRole([0, 1, 2]);

        $studentId = $_SESSION['user']['id'];
        $courseId = $_GET['course_id'] ?? null;

        if (!$courseId) {
            header("Location: index.php?controller=student&action=myCourses");
            exit;
        }

        // Lấy thông tin khóa học
        $course = $this->courseModel->findById($courseId);

        // Lấy danh sách bài học kèm trạng thái hoàn thành
        $lessons = $this->lessonModel->getLessonsWithProgress($courseId, $studentId);

        // Lấy danh sách bài học đã hoàn thành (array lesson_id)
        $completedLessons = $this->enrollModel->getCompletedLessons($studentId, $courseId);

        // Xác định bài học đang xem
        $lessonId = $_GET['lesson_id'] ?? ($lessons[0]['id'] ?? null);
        $currentLesson = $lessonId ? $this->lessonModel->findById($lessonId) : null;

        // Tài liệu
        $materials = $currentLesson ? $this->lessonModel->getMaterials($currentLesson['id']) : [];

        // Tính lại progress
        $progress = $this->enrollModel->recalcAndUpdateProgress($studentId, $courseId);

        $this->render('student/course_progress', [
            'course' => $course,
            'lessons' => $lessons,
            'currentLesson' => $currentLesson,
            'materials' => $materials,
            'completedLessons' => $completedLessons,
            'progress' => $progress,
            'currentUser' => $_SESSION['user']
        ]);
    }


    // Hành động: đánh dấu bài học hoàn thành

    // Đổi mật khẩu
    public function changePassword() {
        $this->requireRole([0, 1, 2]);
        $this->render('student/change_password');
    }

    //xử lý nút “Đánh dấu hoàn thành”
    // Đánh dấu hoàn thành
        public function markDone() {
            $this->requireRole([0]);

            $studentId = $_SESSION['user']['id'];
            $courseId = $_GET['course_id'] ?? 0;
            $lessonId = $_GET['lesson_id'] ?? 0;

            // Đánh dấu hoàn thành
            $this->lessonModel->markLessonAsDone($studentId, $courseId, $lessonId);

            // Cập nhật lại progress
            $this->enrollModel->recalcAndUpdateProgress($studentId, $courseId);

            header("Location: index.php?controller=student&action=courseProgress&course_id=$courseId&lesson_id=$lessonId");
            exit;
        }
}

