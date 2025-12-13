<div class="container-fluid py-4">
    <div class="row">

        <!-- SIDEBAR -->
        <aside class="col-md-3 col-lg-2 mb-4">

            <!-- FIX KHÔNG XUỐNG DÒNG -->
            <style>
                .list-group-item {
                    white-space: nowrap !important;
                }
            </style>

            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <?php 
                        $currentAdmin = $currentUser ?? ($_SESSION['user'] ?? null);
                        $avatarFile = $currentAdmin['avatar'] ?? 'default.png';
                    ?>

                    <img src="assets/uploads/avatars/<?= htmlspecialchars($avatarFile) ?>"
                         class="rounded-circle mb-3" width="96" height="96" alt="Admin Avatar">

                    <h6 class="mb-0">
                        <?= htmlspecialchars($currentAdmin['fullname'] ?? 'Quản trị viên') ?>
                    </h6>

                    <p class="text-muted small mb-0">
                        <?= htmlspecialchars($currentAdmin['email'] ?? '') ?>
                    </p>

                </div>
            </div>

            <div class="list-group list-group-flush mt-3">

                <a href="index.php?controller=admin&action=dashboard"
                   class="list-group-item list-group-item-action 
                   <?= ($_GET['action'] ?? '') === 'dashboard' ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-simple me-2"></i> Thống kê
                </a>

                <a href="index.php?controller=admin&action=users"
                   class="list-group-item list-group-item-action 
                   <?= ($_GET['action'] ?? '') === 'users' ? 'active' : '' ?>">
                    <i class="fa-solid fa-users me-2"></i> Quản lý người dùng
                </a>

                <a href="index.php?controller=admin&action=categories"
                   class="list-group-item list-group-item-action 
                   <?= ($_GET['action'] ?? '') === 'categories' ? 'active' : '' ?>">
                    <i class="fa-solid fa-layer-group me-2"></i> Danh mục khóa học
                </a>

                <a href="index.php?controller=admin&action=approveCourses"
                   class="list-group-item list-group-item-action 
                   <?= ($_GET['action'] ?? '') === 'approveCourses' ? 'active' : '' ?>">
                    <i class="fa-solid fa-check me-2"></i> Duyệt khóa học mới
                </a>

                <a href="index.php?controller=admin&action=instructorRequests"
                   class="list-group-item list-group-item-action 
                   <?= ($_GET['action'] ?? '') === 'instructorRequests' ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-check me-2"></i> Duyệt yêu cầu giảng viên
                </a>

                <a href="index.php?controller=admin&action=changePassword"
                   class="list-group-item list-group-item-action 
                   <?= ($_GET['action'] ?? '') === 'changePassword' ? 'active' : '' ?>">
                    <i class="fa-solid fa-key me-2"></i> Thay đổi mật khẩu
                </a>

            </div>
        </aside>

        <section class="col-md-9 col-lg-10">
