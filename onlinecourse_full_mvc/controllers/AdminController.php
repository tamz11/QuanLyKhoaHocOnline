<?php
require_once __DIR__ . '/../models/Category.php';

class AdminController extends BaseController {

    // ================================================================
    // ⭐ DASHBOARD - THỐNG KÊ HỆ THỐNG
    // ================================================================
    public function dashboard() {
        $this->requireRole([2]);

        require_once __DIR__ . '/../models/User.php';
        require_once __DIR__ . '/../models/Course.php';
        require_once __DIR__ . '/../models/Category.php';

        $userModel     = new User();
        $courseModel   = new Course();
        $categoryModel = new Category();

        $stats = [
            'total_users'      => $userModel->countAll(),
            'students'         => $userModel->countStudents(),
            'instructors'      => $userModel->countInstructors(),
            'total_courses'    => $courseModel->countAll(),
            'pending_courses'  => $courseModel->countPending(),
            'total_categories' => $categoryModel->countAll(),
        ];

        $this->render("admin/dashboard", [
            'stats' => $stats
        ]);
    }

    // ================================================================
    // ⭐ QUẢN LÝ USER
    // ================================================================
    public function users() {
        $this->requireRole([2]);

        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        $users = $userModel->getAllUsers();

        $this->render('admin/users/manage', [
            'users' => $users
        ]);
    }

    // ================================================================
    // ⭐ QUẢN LÝ DANH MỤC KHÓA HỌC
    // ================================================================
    public function categories() {
        $this->requireRole([2]);

        $catModel = new Category();
        $categories = $catModel->getAll();

        $this->render("admin/categories/list", [
            'categories' => $categories
        ]);
    }

    public function categoriesCreate() {
        $this->requireRole([2]);
        $this->render("admin/categories/create", [
            'error' => '',
            'old' => []
        ]);
    }

    public function categoriesStore() {
        $this->requireRole([2]);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect("index.php?controller=admin&action=categories");
        }

        $name = trim($_POST['name']);
        $desc = trim($_POST['description']);

        if ($name === "") {
            return $this->render("admin/categories/create", [
                'error' => "Tên danh mục không được để trống!",
                'old' => ['name' => $name, 'description' => $desc]
            ]);
        }

        $catModel = new Category();
        $catModel->create($name, $desc);

        $_SESSION['flash'] = "Thêm danh mục thành công!";
        return $this->redirect("index.php?controller=admin&action=categories");
    }

    public function categoriesEdit() {
        $this->requireRole([2]);

        $id = $_GET['id'] ?? null;

        $catModel = new Category();
        $cat = $catModel->findById($id);

        $this->render("admin/categories/edit", [
            'category' => $cat,
            'error' => ''
        ]);
    }

    public function categoriesUpdate() {
        $this->requireRole([2]);

        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $desc = trim($_POST['description']);

        if ($name === "") {
            $catModel = new Category();
            $cat = $catModel->findById($id);

            return $this->render("admin/categories/edit", [
                'category' => $cat,
                'error' => "Tên danh mục không được để trống!"
            ]);
        }

        $catModel = new Category();
        $catModel->update($id, $name, $desc);

        $_SESSION['flash'] = "Cập nhật danh mục thành công!";
        return $this->redirect("index.php?controller=admin&action=categories");
    }

    public function categoriesDelete() {
        $this->requireRole([2]);

        $id = $_GET['id'];

        $catModel = new Category();
        $catModel->delete($id);

        $_SESSION['flash'] = "Đã xoá danh mục!";
        return $this->redirect("index.php?controller=admin&action=categories");
    }

    // ================================================================
    // ⭐ DUYỆT KHÓA HỌC
    // ================================================================
    public function approveCourses() {
        $this->requireRole([2]);
        $this->render('admin/courses/approve');
    }

    // ================================================================
    // ⭐ ĐỔI MẬT KHẨU
    // ================================================================
    public function changePassword() {
        $this->requireRole([2]);
        $this->render('admin/change_password');
    }

    public function updatePassword() {
        $this->requireRole([2]);
        echo "Đã nhận dữ liệu đổi mật khẩu của admin!";
    }

    // ================================================================
    // ⭐ DANH SÁCH YÊU CẦU GIẢNG VIÊN
    // ================================================================
    public function instructorRequests() {
        $this->requireRole([2]);
        require_once __DIR__ . '/../models/InstructorRequest.php';
        $requestModel = new InstructorRequest();

        $requests = $requestModel->getAll();

        $this->render("admin/instructor_requests", [
            'requests' => $requests
        ]);
    }

    // Xử lý duyệt / từ chối yêu cầu giảng viên
    public function handleInstructorRequest() {
        $this->requireRole([2]);

        if (!isset($_GET['id'], $_GET['status'])) {
            die("Thiếu tham số!");
        }

        $id = (int)$_GET['id'];
        $status = $_GET['status'];

        require_once __DIR__ . '/../models/InstructorRequest.php';
        require_once __DIR__ . '/../models/User.php';

        $requestModel = new InstructorRequest();
        $userModel = new User();

        $request = $requestModel->findById($id);
        if (!$request) die("Không tìm thấy yêu cầu!");

        if ($status === 'approved') {
            $userModel->updateRole($request['user_id'], 1);
        }

        $requestModel->updateStatus($id, $status);

        header("Location: index.php?controller=admin&action=instructorRequests");
        exit;
    }

    // ================================================================
    // ⭐ HANDLE USER (KÍCH HOẠT / VÔ HIỆU / XOÁ)
    // ================================================================
    public function handleUser() {
        $this->requireRole([2]);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid request!");
        }

        if (!isset($_POST['id'], $_POST['actionType'])) {
            die("Thiếu tham số!");
        }

        $id = (int)$_POST['id'];
        $action = $_POST['actionType'];

        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        // Lấy thông tin user
        $user = $userModel->getUserById($id);
        if (!$user) die("User không tồn tại!");

        if ($action === "enable") {

            $userModel->setActive($id, 1);
            $_SESSION['flash_success'] = "Đã kích hoạt tài khoản!";

        } elseif ($action === "disable") {

            $userModel->setActive($id, 0);
            $_SESSION['flash_success'] = "Đã vô hiệu hoá tài khoản!";

        } elseif ($action === "delete") {

            if ((int)$user['is_active'] === 1) {
                $_SESSION['flash_error'] = "Bạn phải vô hiệu hóa tài khoản trước khi xoá!";
                header("Location: index.php?controller=admin&action=users");
                exit;
            }

            try {
                $userModel->deleteUser($id);
                $_SESSION['flash_success'] = "Đã xoá tài khoản!";
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Không thể xoá tài khoản do ràng buộc dữ liệu!";
            }

        } else {
            die("Hành động không hợp lệ!");
        }

        header("Location: index.php?controller=admin&action=users");
        exit;
    }

    // ================================================================
    // ⭐ XEM CHI TIẾT USER
    // ================================================================
    public function userDetail() {
        $this->requireRole([2]);

        if (!isset($_GET['id'])) {
            die("Thiếu ID người dùng!");
        }

        $id = (int)$_GET['id'];

        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        // Lấy thông tin user
        $user = $userModel->getUserById($id);
        if (!$user) {
            die("Người dùng không tồn tại!");
        }

        $instructorCourses = [];
        if ((int)$user['role'] === 1) {
            $instructorCourses = $userModel->getInstructorCourses($id);
        }

        $studentEnrollments = [];
        if ((int)$user['role'] === 0) {
            $studentEnrollments = $userModel->getStudentEnrollments($id);
        }

        $this->render("admin/users/detail", [
            'user' => $user,
            'instructorCourses' => $instructorCourses,
            'studentEnrollments' => $studentEnrollments
        ]);
    }

}
