<?php

class AdminController extends BaseController {

    // Trang dashboard của admin
    public function dashboard() {
        $this->requireRole([2]); // chỉ admin
        $this->render("admin/dashboard");
    }

    // Quản lý user
    public function users() {
        $this->requireRole([2]); // chỉ admin
        $this->render('admin/users/manage');
    }

    // Quản lý danh mục
    public function categories() {
        $this->requireRole([2]); // chỉ admin
        $this->render('admin/categories/list');
    }

    // Duyệt khóa học mới
    public function approveCourses() {
        $this->requireRole([2]);
        $this->render('admin/courses/approve');
    }

    // Form đổi mật khẩu
    public function changePassword() {
        $this->requireRole([2]);
        $this->render('admin/change_password');
    }

    // Xử lý đổi mật khẩu
    public function updatePassword() {
        $this->requireRole([2]);
        echo "Đã nhận dữ liệu đổi mật khẩu của admin!";
    }


    // ================================================================
    // 1) DANH SÁCH YÊU CẦU TRỞ THÀNH GIẢNG VIÊN
    // ================================================================
    public function instructorRequests()
    {
        $this->requireRole([2]);

        require_once __DIR__ . '/../models/InstructorRequest.php';

        $requestModel = new InstructorRequest();
        $requests = $requestModel->getAll();

        $this->render("admin/instructor_requests", [
            'requests' => $requests
        ]);
    }


    // ================================================================
    // 2) HÀM XỬ LÝ DUYỆT / TỪ CHỐI (BẠN ĐANG GỌI action=handleInstructorRequest)
    // ================================================================
    public function handleInstructorRequest()
    {
        $this->requireRole([2]);

        if (!isset($_GET['id'], $_GET['status'])) {
            die("Thiếu tham số!");
        }

        $id = (int)$_GET['id'];
        $status = $_GET['status']; // approved / rejected

        require_once __DIR__ . '/../models/InstructorRequest.php';
        require_once __DIR__ . '/../models/User.php';

        $requestModel = new InstructorRequest();
        $userModel = new User();

        // Lấy yêu cầu
        $request = $requestModel->findById($id);
        if (!$request) {
            die("Không tìm thấy yêu cầu!");
        }

        // Nếu admin duyệt → đổi role user thành giảng viên
        if ($status === 'approved') {
            $userModel->updateRole($request['user_id'], 1);
        }

        // Cập nhật trạng thái yêu cầu
        $requestModel->updateStatus($id, $status);

        // Quay lại danh sách
        header("Location: index.php?controller=admin&action=instructorRequests");
        exit;
    }


    // ================================================================
    // 3) CHẤP NHẬN YÊU CẦU (BẢN GỐC CỦA BẠN – GIỮ LẠI CHO ĐỦ)
    // ================================================================
    public function approveInstructor()
    {
        $this->requireRole([2]);

        if (!isset($_GET['id'])) {
            die("Thiếu ID yêu cầu!");
        }

        $requestId = $_GET['id'];

        require_once __DIR__ . '/../models/InstructorRequest.php';
        require_once __DIR__ . '/../models/User.php';

        $requestModel = new InstructorRequest();
        $userModel    = new User();

        $request = $requestModel->findById($requestId); // sửa lại cho đúng
        if (!$request) {
            die("Yêu cầu không tồn tại!");
        }

        $userModel->updateRole($request['user_id'], 1);
        $requestModel->updateStatus($requestId, 'approved');

        echo "<script>
                alert('Đã chấp nhận yêu cầu và cấp quyền Giảng viên!');
                window.location='index.php?controller=admin&action=instructorRequests';
            </script>";
    }


    // ================================================================
    // 4) TỪ CHỐI YÊU CẦU (BẢN GỐC CỦA BẠN – GIỮ LẠI CHO ĐỦ)
    // ================================================================
    public function rejectInstructor()
    {
        $this->requireRole([2]);

        if (!isset($_GET['id'])) {
            die("Thiếu ID yêu cầu!");
        }

        $requestId = $_GET['id'];

        require_once __DIR__ . '/../models/InstructorRequest.php';

        $requestModel = new InstructorRequest();
        $requestModel->updateStatus($requestId, 'rejected');

        echo "<script>
                alert('Đã từ chối yêu cầu!');
                window.location='index.php?controller=admin&action=instructorRequests';
            </script>";
    }
}
