<?php
require_once 'BaseController.php';

class UserController extends BaseController {

    public function updateProfile() {
        $this->requireRole([0,1,2]); // học viên + giảng viên + admin

        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        $id = $_SESSION['user']['id'];
        $fullname = $_POST['fullname'] ?? '';

        if (trim($fullname) == "") {
            $_SESSION['msg'] = "Họ tên không được để trống!";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Xử lý avatar
        $avatarPath = null;

        if (!empty($_FILES['avatar']['name'])) {

            $fileName = time() . '_' . basename($_FILES['avatar']['name']);
            $targetDir = "assets/uploads/avatars/";
            $targetFile = $targetDir . $fileName;

            $allowed = ['image/jpeg', 'image/png', 'image/jpg'];

            if (!in_array($_FILES['avatar']['type'], $allowed)) {
                $_SESSION['msg'] = "Chỉ được upload JPG/PNG!";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }

            move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile);
            $avatarPath = $fileName;
        }

        // Cập nhật DB
        $userModel->updateProfile($id, $fullname, $avatarPath);

        // Cập nhật session
        $_SESSION['user']['fullname'] = $fullname;
        if ($avatarPath) {
            $_SESSION['user']['avatar'] = $avatarPath;
        }

        $_SESSION['msg'] = "Cập nhật hồ sơ thành công!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
