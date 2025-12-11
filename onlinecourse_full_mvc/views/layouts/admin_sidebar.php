<div class="container-fluid py-4">
    <div class="row">

        <!-- SIDEBAR -->
        <aside class="col-md-3 col-lg-2 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <?php 
                        // Lấy thông tin admin đang đăng nhập
                        $currentAdmin = $_SESSION['user'] ?? null;
                    ?>

                    <!-- Avatar -->
                    <img src="assets/uploads/avatars/<?= htmlspecialchars($currentAdmin['avatar'] ?? 'default-admin.png') ?>"
                         class="rounded-circle mb-3"
                         width="80"
                         height="80"
                         alt="Admin">

                    <!-- Fullname -->
                    <h6 class="mb-0">
                        <?= htmlspecialchars($currentAdmin['fullname'] ?? 'Quản trị viên') ?>
                    </h6>

                    <!-- Email -->
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

                <!-- Link duyệt yêu cầu giảng viên -->
                <a href="index.php?controller=admin&action=instructorRequests"
                   class="list-group-item list-group-item-action 
                   <?= ($_GET['action'] ?? '') === 'instructorRequests' ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-check me-2"></i> Duyệt yêu cầu giảng viên
                </a>

                <a href="index.php?controller=admin&action=changePassword"
                    class="list-group-item list-group-item-action <?= ($_GET['action'] ?? '') === 'changePassword' ? 'active' : '' ?>">
                    <i class="fa-solid fa-key me-2"></i>Thay đổi mật khẩu
                </a>

                <a href="index.php?controller=auth&action=logout"
                   class="list-group-item list-group-item-action text-danger">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Đăng xuất
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <section class="col-md-9 col-lg-10">
