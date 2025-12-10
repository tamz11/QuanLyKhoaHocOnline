<?php

abstract class BaseController {

    // Điều hướng (redirect)
    protected function redirect($url) {
        header("Location: $url");
        exit();
    }

    // Load view
    protected function render($view, $data = []) {
        extract($data);

        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/' . $view . '.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // Yêu cầu đăng nhập
    protected function requireLogin() {
        if (!isset($_SESSION['user'])) {
            $this->redirect("index.php?controller=auth&action=login");
        }
    }

    // Kiểm tra role
    protected function requireRole($roles = []) {
        $this->requireLogin();

        if (!in_array($_SESSION['user']['role'], $roles)) {
            die("Bạn không có quyền truy cập trang này!");
        }
    }
}
