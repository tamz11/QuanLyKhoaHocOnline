<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // ============================
    //  ĐĂNG NHẬP (SHOW + POST)
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
            } 
            elseif ($user['is_active'] == 0) {
                $error = "Tài khoản của bạn đã bị vô hiệu hóa!";
            }
            elseif (!password_verify($password, $user['password'])) {
                $error = "Sai mật khẩu.";
            } else {
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

        $login    = trim($_POST['login']);
        $password = trim($_POST['password']);

        $user = $this->userModel->findByLogin($login);

        if (!$user) {
            return $this->render("auth/login", ['error' => "Tài khoản không tồn tại!"]);
        }

        if ($user['is_active'] == 0) {
            return $this->render("auth/login", ['error' => "Tài khoản của bạn đã bị vô hiệu hóa!"]);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->render("auth/login", ['error' => "Mật khẩu không đúng!"]);
        }

        $_SESSION['user'] = $user;

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
    //  XỬ LÝ ĐĂNG KÝ
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

        if ($password !== $confirm) {
            return $this->render("auth/register", ['error' => "Mật khẩu không khớp!"]);
        }

        if ($this->userModel->findByEmail($email)) {
            return $this->render("auth/register", ['error' => "Email đã tồn tại!"]);
        }

        if ($this->userModel->findByUsername($username)) {
            return $this->render("auth/register", ['error' => "Username đã tồn tại!"]);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            ':fullname' => $fullname,
            ':username' => $username,
            ':email'    => $email,
            ':password' => $hashedPassword,
            ':role'     => 0
        ];

        if ($this->userModel->createUser($data)) {

            // ⭐⭐⭐ TỰ ĐỘNG ĐĂNG NHẬP NGAY SAU KHI ĐĂNG KÝ ⭐⭐⭐
            $newUser = $this->userModel->findByLogin($email);
            $_SESSION['user'] = $newUser;

            // Chuyển sang dashboard học viên
            return $this->redirect("index.php?controller=student&action=dashboard");
        }

        return $this->render("auth/register", ['error' => "Có lỗi xảy ra, vui lòng thử lại!"]);
    }

    // ============================
    //  ĐĂNG XUẤT
    // ============================
    public function logout() {
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        header("Location: index.php?controller=auth&action=login");
        exit;
    }
}
