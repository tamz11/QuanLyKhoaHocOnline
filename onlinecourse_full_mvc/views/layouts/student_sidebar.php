<?php
// views/layouts/student_sidebar.php
?>
<div class="container-fluid py-4">
    <div class="row">
        <!-- SIDEBAR -->
        <aside class="col-md-3 col-lg-2 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <img src="assets/uploads/avatars/<?= htmlspecialchars($currentUser['avatar'] ?? 'default-student.png') ?>"
                         class="rounded-circle mb-3" width="96" height="96" alt="Avatar">
                    <h6 class="mb-0"><?= htmlspecialchars($currentUser['fullname'] ?? 'Học viên') ?></h6>
                    <p class="text-muted small mb-2"><?= htmlspecialchars($currentUser['email'] ?? '') ?></p>
                </div>
                <div class="list-group list-group-flush">
                    <a href="index.php?controller=student&action=dashboard"
                       class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'dashboard' ? 'active' : '' ?>">
                        <i class="fa-solid fa-gauge me-2"></i>Hồ sơ
                    </a>
                    <a href="index.php?controller=student&action=myCourses"
                       class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'myCourses' ? 'active' : '' ?>">
                        <i class="fa-solid fa-book-open-reader me-2"></i>Khóa học của tôi
                    </a>
                    <a href="index.php?controller=student&action=changePassword"
                       class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'changePassword' ? 'active' : '' ?>">
                        <i class="fa-solid fa-key me-2"></i>Thay đổi mật khẩu
                    </a>

                    <!-- ==== Thêm: Link 'Yêu cầu trở thành giảng viên' cho role = 0 (Học viên) ==== -->
                    <?php if (isset($currentUser) && isset($currentUser['role']) && (int)$currentUser['role'] === 0): ?>
                        <a href="index.php?controller=student&action=requestInstructor"
                           class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'requestInstructor' ? 'active' : '' ?>">
                            <i class="fa-solid fa-chalkboard-user me-2"></i>Yêu cầu trở thành giảng viên
                        </a>
                    <?php endif; ?>
                    <!-- ============================================================== -->
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <section class="col-md-9 col-lg-10">
