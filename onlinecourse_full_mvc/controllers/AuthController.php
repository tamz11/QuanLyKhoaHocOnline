<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends BaseController {

    // =============================
    // HIỂN THỊ TRANG ĐĂNG NHẬP
    // =============================
    public function login() {
        $this->render('auth/login');
    }

    // =============================
    // XỬ LÝ ĐĂNG NHẬP
    // =============================
    public function doLogin() {

        $login = $_POST['username'] ?? '';      // có thể là email hoặc username
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByLogin($login);

        if (!$user) {
            echo "<script>alert('Email hoặc username không tồn tại!'); window.history.back();</script>";
            return;
        }

        // Kiểm tra mật khẩu (hỗ trợ cả hash hoặc plain text)
        if ($user['password'] == $password || password_verify($password, $user['password'])) {

            $_SESSION['user'] = $user;

            // Điều hướng theo quyền
            if ($user['role'] == 2) {
                header("Location: index.php?controller=admin&action=dashboard");
            } elseif ($user['role'] == 1) {
                header("Location: index.php?controller=instructor&action=dashboard");
            } else {
                header("Location: index.php?controller=student&action=dashboard");
            }
        }
        else {
            echo "<script>alert('Sai mật khẩu!'); window.history.back();</script>";
        }
    }


    // =============================
    // HIỂN THỊ TRANG ĐĂNG KÝ
    // =============================
    public function register() {
        $this->render('auth/register');
    }

    // =============================
    // XỬ LÝ ĐĂNG KÝ NGƯỜI DÙNG
    // =============================
    public function doRegister() {
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);
        $fullname = trim($_POST['fullname']);

        $userModel = new User();

        // ----- KIỂM TRA TRÙNG EMAIL -----
        if ($userModel->findByEmail($email)) {
            echo "<script>alert('Email đã tồn tại!'); window.history.back();</script>";
            return;
        }

        // ----- KIỂM TRA TRÙNG USERNAME -----
        if ($userModel->findByUsername($username)) {
            echo "<script>alert('Username đã tồn tại!'); window.history.back();</script>";
            return;
        }

        // ----- HASH PASSWORD (khuyên dùng) -----
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        // ----- TẠO NGƯỜI DÙNG MỚI -----
        $userModel->create([
            'username' => $username,
            'email'    => $email,
            'password' => $hashed,
            'fullname' => $fullname,
            'role'     => 0  // Default: student
        ]);

        echo "<script>alert('Đăng ký thành công! Hãy đăng nhập.'); 
                window.location='index.php?controller=auth&action=login';
              </script>";
    }

    // =============================
    // ĐĂNG XUẤT
    // =============================
    public function logout() {
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
    }
    
}
