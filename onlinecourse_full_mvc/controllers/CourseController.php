<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Lesson.php';

class CourseController extends BaseController {

    private $courseModel;
    private $categoryModel;
    private $lessonModel;

    public function __construct() {
        $this->courseModel = new Course();
        $this->categoryModel = new Category();
        $this->lessonModel  = new Lesson();
    }

    /* ================================
       TRANG DANH SÁCH KHÓA HỌC
       (Có lọc theo danh mục)
    ================================= */
    public function index() {
        $category = $_GET['category'] ?? null;

        if ($category) {
            $courses = $this->courseModel->getByCategory($category);
        } else {
            // Lấy tất cả khóa học đã duyệt
            $courses = $this->courseModel->getAllApproved();
        }

        $categories = $this->categoryModel->getAll();

        $this->render('courses/index', [
            'courses' => $courses,
            'categories' => $categories
        ]);
    }


    /* ================================
       TÌM KIẾM KHÓA HỌC
    ================================= */
    public function search() {
        $keyword = $_GET['q'] ?? '';

        $results = $this->courseModel->search($keyword);

        $this->render('courses/search', [
            'results' => $results,
            'keyword' => $keyword
        ]);
    }

    /* ================================
       TRANG CHI TIẾT KHÓA HỌC
    ================================= */
    public function detail() {
        $id = $_GET['id'] ?? 0;

        $course = $this->courseModel->findById($id);
        $lessons = $this->lessonModel->getByCourse($id);

        // kiểm tra đăng ký
        require_once __DIR__ . '/../models/Enrollment.php';
        $enrollModel = new Enrollment();
        
        $isEnrolled = false;

        if (isset($_SESSION['user'])) {
            $studentId = $_SESSION['user']['id'];
            $isEnrolled = $enrollModel->isEnrolled($studentId, $id);
        }

        $this->render('courses/detail', [
            'course' => $course,
            'lessons' => $lessons,
            'isEnrolled' => $isEnrolled
        ]);
    }

}
