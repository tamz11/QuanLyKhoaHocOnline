<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // ============================
    //  ĐĂNG NHẬP
    // ============================
    public function login() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $emailOrUsername = trim($_POST['email_or_username']);
            $password        = trim($_POST['password']);

            // Kiểm tra user nhập email hay username
            if (filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) {
                $user = $this->userModel->findByEmail($emailOrUsername);
            } else {
                $user = $this->userModel->findByUsername($emailOrUsername);
            }

            if (!$user) {
                $error = "Tài khoản không tồn tại.";
            } elseif (!password_verify($password, $user['password'])) {
                $error = "Sai mật khẩu.";
            } else {
                // Lưu phiên đăng nhập
                $_SESSION['user'] = $user;

                // Điều hướng theo role
                switch ($user['role']) {
                    case 2:
                        $this->redirect("index.php?controller=admin&action=dashboard");
                        break;
                    case 1:
                        $this->redirect("index.php?controller=instructor&action=dashboard");
                        break;
                    default:
                        $this->redirect("index.php?controller=student&action=dashboard");
                }
            }
        }

        $this->render("auth/login", ['error' => $error]);
    }

    // ============================
//  XỬ LÝ ĐĂNG NHẬP (POST)
// ============================
    public function doLogin()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect("index.php?controller=auth&action=login");
        }

        $login    = trim($_POST['login']);    // form name="login"
        $password = trim($_POST['password']);

        // tìm user theo email hoặc username
        $user = $this->userModel->findByLogin($login);

        if (!$user) {
            $error = "Tài khoản không tồn tại!";
            return $this->render("auth/login", ['error' => $error]);
        }

        if (!password_verify($password, $user['password'])) {
            $error = "Mật khẩu không đúng!";
            return $this->render("auth/login", ['error' => $error]);
        }

        // đăng nhập thành công → lưu session
        $_SESSION['user'] = $user;

        // điều hướng theo ROLE
        switch ($user['role']) {
            case 2:
                return $this->redirect("index.php?controller=admin&action=dashboard");
            case 1:
                return $this->redirect("index.php?controller=instructor&action=dashboard");
            default:
                return $this->redirect("index.php?controller=student&action=dashboard");
        }
    }

    // ============================
    //  HIỂN THỊ FORM ĐĂNG KÝ
    // ============================
    public function register() {
        $error = $success = "";

        $this->render("auth/register", [
            'error' => $error,
            'success' => $success
        ]);
    }

    // ============================
    //  XỬ LÝ ĐĂNG KÝ (POST)
    // ============================
    public function doRegister() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect("index.php?controller=auth&action=register");
        }

        $fullname = trim($_POST['fullname']);
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm  = trim($_POST['confirm']);

        // Kiểm tra mật khẩu khớp
        if ($password !== $confirm) {
            $error = "Mật khẩu không khớp!";
            return $this->render("auth/register", ['error' => $error]);
        }

        // Kiểm tra email tồn tại
        if ($this->userModel->findByEmail($email)) {
            $error = "Email đã tồn tại!";
            return $this->render("auth/register", ['error' => $error]);
        }

        // Kiểm tra username tồn tại
        if ($this->userModel->findByUsername($username)) {
            $error = "Username đã tồn tại!";
            return $this->render("auth/register", ['error' => $error]);
        }

        // Hash mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Chuẩn bị data
        $data = [
            ':fullname' => $fullname,
            ':username' => $username,
            ':email'    => $email,
            ':password' => $hashedPassword,
            ':role'     => 0 // mặc định học viên
        ];

        // Lưu vào DB
        if ($this->userModel->createUser($data)) {
            $success = "Đăng ký thành công! Bạn có thể đăng nhập.";
            return $this->render("auth/register", ['success' => $success]);
        } else {
            $error = "Có lỗi xảy ra, vui lòng thử lại!";
            return $this->render("auth/register", ['error' => $error]);
        }
    }

    // ============================
    //  ĐĂNG XUẤT
    // ============================
    public function logout() {
        session_destroy();
        $this->redirect("index.php?controller=auth&action=login");
    }
}
