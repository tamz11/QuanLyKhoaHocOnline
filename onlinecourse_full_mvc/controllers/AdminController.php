<?php

class AdminController extends BaseController {

    // Trang dashboard của admin
    public function dashboard() {
        $this->requireRole([2]); 
        $this->render("admin/dashboard");
    }

    // Quản lý user
    public function users() {
        $this->requireRole([2]);

        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        $users = $userModel->getAllUsers();

        $this->render('admin/users/manage', [
            'users' => $users
        ]);
    }

    // Quản lý danh mục
    public function categories() {
        $this->requireRole([2]);
        $this->render('admin/categories/list');
    }

    // Duyệt khóa học
    public function approveCourses() {
        $this->requireRole([2]);
        $this->render('admin/courses/approve');
    }

    // Đổi mật khẩu
    public function changePassword() {
        $this->requireRole([2]);
        $this->render('admin/change_password');
    }

    public function updatePassword() {
        $this->requireRole([2]);
        echo "Đã nhận dữ liệu đổi mật khẩu của admin!";
    }

    // Danh sách yêu cầu giảng viên
    public function instructorRequests() {
        $this->requireRole([2]);

        require_once __DIR__ . '/../models/InstructorRequest.php';
        $requestModel = new InstructorRequest();

        $requests = $requestModel->getAll();

        $this->render("admin/instructor_requests", [
            'requests' => $requests
        ]);
    }

    // Xử lý duyệt / từ chối
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

            // Không cho xoá user nếu còn active
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
    // ⭐ XEM CHI TIẾT USER (ĐÃ MỞ RỘNG CHUẨN MVC)
    // ================================================================
    public function userDetail()
    {
        $this->requireRole([2]); // Chỉ admin được xem

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

        // ----------------------------------------------
        // Nếu là GIẢNG VIÊN -> lấy danh sách khóa học tạo
        // ----------------------------------------------
        $instructorCourses = [];
        if ((int)$user['role'] === 1) {
            $instructorCourses = $userModel->getInstructorCourses($id);
        }

        // ----------------------------------------------
        // Nếu là HỌC VIÊN -> lấy danh sách khóa học đã đăng ký
        // ----------------------------------------------
        $studentEnrollments = [];
        if ((int)$user['role'] === 0) {
            $studentEnrollments = $userModel->getStudentEnrollments($id);
        }

        // Render view và truyền thêm dữ liệu
        $this->render("admin/users/detail", [
            'user' => $user,
            'instructorCourses' => $instructorCourses,
            'studentEnrollments' => $studentEnrollments
        ]);
    }

}
