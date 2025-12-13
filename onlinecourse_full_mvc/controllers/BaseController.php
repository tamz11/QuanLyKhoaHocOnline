<?php

abstract class BaseController {

    protected function redirect($url) {
        header("Location: $url");
        exit();
    }

    protected function render($view, $data = []) {
        extract($data);

        $currentUser = $_SESSION['user'] ?? null;

        include __DIR__ . '/../views/layouts/header.php';

        // Nếu view thuộc admin -> tự động chèn sidebar
        if (strpos($view, 'admin/') === 0) {
            include __DIR__ . '/../views/layouts/admin_sidebar.php';
        }

        include __DIR__ . '/../views/' . $view . '.php';

        include __DIR__ . '/../views/layouts/footer.php';
    }

    protected function requireLogin() {
        if (!isset($_SESSION['user'])) {
            $this->redirect("index.php?controller=auth&action=login");
        }
    }

    protected function requireRole($roles = []) {
        $this->requireLogin();

        if (!in_array($_SESSION['user']['role'], $roles)) {
            die("Bạn không có quyền truy cập trang này!");
        }
    }
}
