<?php
// views/layouts/instructor_sidebar.php
?>
<div class="container-fluid py-4">
    <div class="row">
        <aside class="col-md-3 col-lg-2 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <img src="assets/uploads/avatars/<?= htmlspecialchars($currentUser['avatar'] ?? 'default.png') ?>"
                         class="rounded-circle mb-3" width="96" height="96" alt="Instructor">
                    <h6 class="mb-0"><?= htmlspecialchars($currentUser['fullname'] ?? 'Giảng viên') ?></h6>
                    <p class="text-muted small mb-0"><?= htmlspecialchars($currentUser['email'] ?? '') ?></p>
                </div>
            </div>

            <div class="list-group list-group-flush mt-3">
                <a href="index.php?controller=instructor&action=dashboard"
                   class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'dashboard' ? 'active' : '' ?>">
                    <i class="fa-solid fa-gauge me-2"></i>Dashboard
                </a>
                <a href="index.php?controller=instructor&action=myCourses"
                   class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'myCourses' ? 'active' : '' ?>">
                    <i class="fa-solid fa-book me-2"></i>Khoá học của tôi
                </a>
                <a href="index.php?controller=instructor&action=lessons"
                   class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'lessons' ? 'active' : '' ?>">
                    <i class="fa-solid fa-graduation-cap me-2"></i>Quản lý bài học
                </a>
                <a href="index.php?controller=instructor&action=materials"
                   class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'materials' ? 'active' : '' ?>">
                    <i class="fa-solid fa-file-arrow-up me-2"></i>Tài liệu
                </a>
                <a href="index.php?controller=instructor&action=students"
                   class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'students' ? 'active' : '' ?>">
                    <i class="fa-solid fa-users me-2"></i>Học viên
                </a>
                <a href="index.php?controller=instructor&action=changePassword"
                   class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'changePassword' ? 'active' : '' ?>">
                    <i class="fa-solid fa-key me-2"></i>Đổi mật khẩu
                </a>
            </div>
        </aside>

        <section class="col-md-9 col-lg-10">
