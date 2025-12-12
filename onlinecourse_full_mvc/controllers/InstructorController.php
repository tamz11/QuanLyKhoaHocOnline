<?php

require_once 'BaseController.php';

class InstructorController extends BaseController
{
    protected $currentUser;

    public function __construct($currentUser = null)
    {
        $this->currentUser = $currentUser;
    }
    // ===========================
    // DASHBOARD GIẢNG VIÊN
    // ===========================
    public function dashboard()
    {
        $this->requireRole([1, 2]); // giảng viên + admin
        $this->render('instructor/dashboard');
    }

    // ===========================
    // 1. QUẢN LÝ KHÓA HỌC
    // ===========================
    public function myCourses()
    {
        $this->requireRole([1, 2]);
        $courseModel = new Course();
        $courses = $courseModel->getByInstructor($this->currentUser['id']);
        $this->render('instructor/my_courses', ['courses' => $courses]);
    }

    public function createCourse()
    {
        $this->requireRole([1, 2]);
        // Lấy danh mục để hiển thị trong form
        require_once 'models/Category.php';
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();
        $this->render('instructor/course/create', ['categories' => $categories]);
    }

    public function storeCourse()
    {
        $this->requireRole([1, 2]);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'category_id' => $_POST['category_id'] ?? '',
            'duration_weeks' => $_POST['duration_weeks'] ?? 1,
            'level' => $_POST['level'] ?? 'Beginner',
            'price' => $_POST['price'] ?? 0,
        ];

        // Xử lý upload ảnh
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/uploads/courses/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $data['image'] = $fileName;
            }
        }

        $courseModel = new Course();
        if ($courseModel->create($data, $this->currentUser['id'])) {
            header('Location: index.php?controller=instructor&action=myCourses&success=1');
        } else {
            header('Location: index.php?controller=instructor&action=createCourse&error=1');
        }
        exit;
    }

    public function editCourse()
    {
        $this->requireRole([1, 2]);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $courseModel = new Course();
        $course = $courseModel->findById($id);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        require_once 'models/Category.php';
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

        $this->render('instructor/course/edit', ['course' => $course, 'categories' => $categories]);
    }

    public function updateCourse()
    {
        $this->requireRole([1, 2]);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $courseModel = new Course();
        $course = $courseModel->findById($id);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'category_id' => $_POST['category_id'] ?? '',
            'duration_weeks' => $_POST['duration_weeks'] ?? 1,
            'level' => $_POST['level'] ?? 'Beginner',
            'price' => $_POST['price'] ?? 0,
        ];

        // Xử lý upload ảnh mới
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/uploads/courses/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $data['image'] = $fileName;
            }
        } else {
            // Giữ ảnh cũ
            $data['image'] = $course['image'];
        }

        if ($courseModel->update($id, $data)) {
            header('Location: index.php?controller=instructor&action=myCourses&success=2');
        } else {
            header('Location: index.php?controller=instructor&action=editCourse&id=' . $id . '&error=1');
        }
        exit;
    }

    public function deleteCourse()
    {
        $this->requireRole([1, 2]);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $courseModel = new Course();
        $course = $courseModel->findById($id);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        if ($courseModel->delete($id)) {
            header('Location: index.php?controller=instructor&action=myCourses&success=3');
        } else {
            header('Location: index.php?controller=instructor&action=myCourses&error=1');
        }
        exit;
    }

    public function manageLessons()
    {
        $this->requireRole([1, 2]);
        $courseId = $_GET['course_id'] ?? null;
        if (!$courseId) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        // Lấy lessons của khóa học
        require_once 'models/Lesson.php';
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($courseId);

        $this->render('instructor/lessons/manage', ['course' => $course, 'lessons' => $lessons]);
    }

    // ===========================
    // 2. QUẢN LÝ BÀI HỌC
    // ===========================
    public function lessons()
    {
        $this->requireRole([1, 2]);
        $courseId = $_GET['course_id'] ?? null;
        if (!$courseId) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        // Lấy lessons của khóa học
        require_once 'models/Lesson.php';
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($courseId);

        $this->render('instructor/lessons/manage', ['course' => $course, 'lessons' => $lessons]);
    }

    public function createLesson()
    {
        $this->requireRole([1, 2]);
        $courseId = $_GET['course_id'] ?? null;
        if (!$courseId) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        $this->render('instructor/lessons/create', ['course' => $course]);
    }

    public function storeLesson()
    {
        $this->requireRole([1, 2]);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $courseId = $_POST['course_id'] ?? null;
        if (!$courseId) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        $lessonModel = new Lesson();
        $maxOrder = $lessonModel->getMaxOrder($courseId);

        $data = [
            'course_id' => $courseId,
            'title' => $_POST['title'] ?? '',
            'content' => $_POST['content'] ?? '',
            'video_url' => $_POST['video_url'] ?? '',
            'order' => ($maxOrder + 1)
        ];

        if ($lessonModel->create($data)) {
            header('Location: index.php?controller=instructor&action=lessons&course_id=' . $courseId . '&success=1');
        } else {
            header('Location: index.php?controller=instructor&action=createLesson&course_id=' . $courseId . '&error=1');
        }
        exit;
    }

    public function editLesson()
    {
        $this->requireRole([1, 2]);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $lessonModel = new Lesson();
        $lesson = $lessonModel->findById($id);
        if (!$lesson) {
            die('Bài học không tồn tại!');
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($lesson['course_id']);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        $this->render('instructor/lessons/edit', ['lesson' => $lesson, 'course' => $course]);
    }

    public function updateLesson()
    {
        $this->requireRole([1, 2]);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $lessonModel = new Lesson();
        $lesson = $lessonModel->findById($id);
        if (!$lesson) {
            die('Bài học không tồn tại!');
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($lesson['course_id']);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'content' => $_POST['content'] ?? '',
            'video_url' => $_POST['video_url'] ?? '',
            'order' => $_POST['order'] ?? 1
        ];

        if ($lessonModel->update($id, $data)) {
            header('Location: index.php?controller=instructor&action=lessons&course_id=' . $lesson['course_id'] . '&success=2');
        } else {
            header('Location: index.php?controller=instructor&action=editLesson&id=' . $id . '&error=1');
        }
        exit;
    }

    public function deleteLesson()
    {
        $this->requireRole([1, 2]);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $lessonModel = new Lesson();
        $lesson = $lessonModel->findById($id);
        if (!$lesson) {
            die('Bài học không tồn tại!');
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($lesson['course_id']);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        if ($lessonModel->delete($id)) {
            header('Location: index.php?controller=instructor&action=lessons&course_id=' . $lesson['course_id'] . '&success=3');
        } else {
            header('Location: index.php?controller=instructor&action=lessons&course_id=' . $lesson['course_id'] . '&error=1');
        }
        exit;
    }

    // ===========================
    // 3. QUẢN LÝ TÀI LIỆU
    // ===========================
    public function materials()
    {
        $this->requireRole([1, 2]);
        $courseId = $_GET['course_id'] ?? null;
        if (!$courseId) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        // Lấy materials của khóa học
        require_once 'models/Material.php';
        $materialModel = new Material();
        $materials = $materialModel->getByCourse($courseId);

        // Lấy lessons để chọn khi upload
        require_once 'models/Lesson.php';
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($courseId);

        $this->render('instructor/materials/upload', [
            'course' => $course,
            'materials' => $materials,
            'lessons' => $lessons
        ]);
    }

    public function uploadMaterial()
    {
        $this->requireRole([1, 2]);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $courseId = $_POST['course_id'] ?? null;
        $lessonId = $_POST['lesson_id'] ?? null;
        if (!$courseId || !$lessonId) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        // Xử lý upload file
        if (!isset($_FILES['material_file']) || $_FILES['material_file']['error'] !== UPLOAD_ERR_OK) {
            $errorMsg = 'Lỗi upload file: ';
            switch ($_FILES['material_file']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    $errorMsg .= 'File quá lớn (php.ini)';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $errorMsg .= 'File quá lớn (form)';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errorMsg .= 'Upload không hoàn thành';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errorMsg .= 'Không có file được chọn';
                    break;
                default:
                    $errorMsg .= 'Lỗi không xác định';
            }
            header('Location: index.php?controller=instructor&action=materials&course_id=' . $courseId . '&error=' . urlencode($errorMsg));
            exit;
        }

        $uploadDir = 'assets/uploads/materials/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                header('Location: index.php?controller=instructor&action=materials&course_id=' . $courseId . '&error=' . urlencode('Không thể tạo thư mục upload'));
                exit;
            }
        }

        $fileName = time() . '_' . basename($_FILES['material_file']['name']);
        $targetFile = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['material_file']['tmp_name'], $targetFile)) {
            header('Location: index.php?controller=instructor&action=materials&course_id=' . $courseId . '&error=' . urlencode('Lỗi khi lưu file'));
            exit;
        }

        $materialModel = new Material();
        $data = [
            'lesson_id' => $lessonId,
            'filename' => basename($_FILES['material_file']['name']),
            'file_path' => $fileName,
            'file_type' => $_FILES['material_file']['type']
        ];

        if ($materialModel->create($data)) {
            header('Location: index.php?controller=instructor&action=materials&course_id=' . $courseId . '&success=1');
        } else {
            // Xóa file đã upload nếu lưu DB thất bại
            if (file_exists($targetFile)) {
                unlink($targetFile);
            }
            header('Location: index.php?controller=instructor&action=materials&course_id=' . $courseId . '&error=' . urlencode('Lỗi khi lưu thông tin file vào database'));
        }
        exit;
    }

    public function deleteMaterial()
    {
        $this->requireRole([1, 2]);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        $materialModel = new Material();
        $material = $materialModel->findById($id);
        if (!$material) {
            die('Tài liệu không tồn tại!');
        }

        // Kiểm tra quyền sở hữu khóa học thông qua lesson
        require_once 'models/Lesson.php';
        $lessonModel = new Lesson();
        $lesson = $lessonModel->findById($material['lesson_id']);
        if (!$lesson) {
            die('Bài học không tồn tại!');
        }

        $courseModel = new Course();
        $course = $courseModel->findById($lesson['course_id']);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        // Xóa file vật lý
        $filePath = 'assets/uploads/materials/' . $material['file_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if ($materialModel->delete($id)) {
            header('Location: index.php?controller=instructor&action=materials&course_id=' . $course['id'] . '&success=2');
        } else {
            header('Location: index.php?controller=instructor&action=materials&course_id=' . $course['id'] . '&error=1');
        }
        exit;
    }

    // ===========================
    // 4. DANH SÁCH HỌC VIÊN
    // ===========================
    public function students()
    {
        $this->requireRole([1, 2]);
        $courseId = $_GET['course_id'] ?? null;
        if (!$courseId) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        // Lấy danh sách học viên đã đăng ký
        require_once 'models/Enrollment.php';
        $enrollmentModel = new Enrollment();
        $enrollments = $enrollmentModel->getByCourse($courseId);

        $this->render('instructor/students/list', ['course' => $course, 'enrollments' => $enrollments]);
    }

    public function studentProgress()
    {
        $this->requireRole([1, 2]);
        $courseId = $_GET['course_id'] ?? null;
        $studentId = $_GET['student_id'] ?? null;
        if (!$courseId || !$studentId) {
            header('Location: index.php?controller=instructor&action=myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        if (!$course || $course['instructor_id'] != $this->currentUser['id']) {
            die('Không có quyền truy cập!');
        }

        // Lấy thông tin enrollment
        $enrollmentModel = new Enrollment();
        $enrollment = $enrollmentModel->getByStudentAndCourse($studentId, $courseId);
        if (!$enrollment) {
            die('Học viên chưa đăng ký khóa học này!');
        }

        // Lấy thông tin học viên
        require_once 'models/User.php';
        $userModel = new User();
        $student = $userModel->findById($studentId);

        // Lấy lessons của khóa học để hiển thị tiến độ
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($courseId);

        // Lấy tiến độ từng bài học
        require_once 'models/LessonProgress.php';
        $progressModel = new LessonProgress();
        $lessonProgresses = $progressModel->getByStudentAndCourse($studentId, $courseId);

        // Tạo map để dễ kiểm tra
        $progressMap = [];
        foreach ($lessonProgresses as $lp) {
            $progressMap[$lp['lesson_id']] = $lp['completed'];
        }

        $this->render('instructor/students/progress', [
            'course' => $course,
            'student' => $student,
            'enrollment' => $enrollment,
            'lessons' => $lessons,
            'progressMap' => $progressMap
        ]);
    }

    // ===========================
    // 5. ĐỔI MẬT KHẨU
    // ===========================
    public function changePassword()
    {
        $this->requireRole([1, 2]);
        $this->render('instructor/change_password');
    }

    public function updatePassword()
    {
        $this->requireRole([1, 2]);
        echo "Đã nhận dữ liệu đổi mật khẩu của giảng viên!";
    }
}
