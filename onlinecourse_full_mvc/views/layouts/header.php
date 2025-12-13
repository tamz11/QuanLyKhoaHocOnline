<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// NGĂN TRÌNH DUYỆT LẤY TRANG CŨ RA (Fix back after logout)
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache");
header("Expires: 0");

$currentPage = $_GET['controller'] ?? 'home';
$currentUser = $_SESSION['user'] ?? null;
?>


<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>OnlineCourse - MVC</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
.active-menu {
    color: #ff0 !important;       /* đổi màu */
    font-weight: 600 !important;  /* in đậm */
    /* text-decoration: underline;   gạch chân nếu muốn */
}
</style>

<body>

<header class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="fa-solid fa-graduation-cap me-1"></i> OnlineCourse
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <nav class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a href="index.php" class="nav-link <?= $currentPage == 'home' ? 'active-menu' : '' ?>">Trang chủ</a>
</li>
                <li class="nav-item"><a href="index.php?controller=course&action=index"
                                        class="nav-link <?= $currentPage == 'course' ? 'active-menu' : '' ?>">
                                            Khóa học
                                        </a></li>
            </ul>

            <!-- ========================= -->
            <!--   KIỂM TRA ĐĂNG NHẬP     -->
            <!-- ========================= -->
            <ul class="navbar-nav ms-auto">

                <?php if ($currentUser): ?>

                    <!-- Link theo role -->
                    <?php if ($currentUser['role'] == 2): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($currentPage == 'admin' ? 'active-menu' : '') ?>" href="index.php?controller=admin&action=dashboard">
                                <i class="fa-solid fa-user-shield me-1"></i> Quản trị
                            </a>
                        </li>

                    <?php elseif ($currentUser['role'] == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($currentPage == 'instructor' ? 'active-menu' : '') ?>" href="index.php?controller=instructor&action=dashboard">
                                <i class="fa-solid fa-chalkboard-user me-1"></i> Giảng viên
                            </a>
                        </li>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($currentPage == 'student' ? 'active-menu' : '') ?>" href="index.php?controller=student&action=dashboard">
                                <i class="fa-solid fa-user-graduate me-1"></i> Trang cá nhân
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-2"
                           href="index.php?controller=auth&action=logout">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Đăng xuất
                        </a>
                    </li>

                <?php else: ?>

                    <!-- Chưa đăng nhập -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=auth&action=login">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning ms-2"
                           href="index.php?controller=auth&action=register">Đăng ký</a>
                    </li>

                <?php endif; ?>

            </ul>
        </nav>
    </div>
</header>

<main class="flex-shrink-0">


<?php
$controller = $_GET['controller'] ?? '';
$action     = $_GET['action'] ?? '';

$currentRoute = $controller . ':' . $action;

// =======================
// RULE: Nếu là trang giảng viên và KHÔNG phải dashboard → hiện nút Back
// =======================

$showBack = false;

if ($controller == 'instructor' && $action != 'dashboard' || $controller == 'student' && $action != 'dashboard'  
|| $controller == 'admin' && $action != 'dashboard') {
    $showBack = true;
}

// Các trang khác muốn thêm thủ công
$allowBackExtra = [
    'course:detail',
    'course:search',
    'student:courseProgress'
];

if (in_array($currentRoute, $allowBackExtra)) {
    $showBack = true;
}

?>

<div class="container mt-3" style="min-height: 16px;">
    <?php if ($showBack): ?>
        <a href="javascript:history.back()"
           class="d-inline-flex align-items-center text-decoration-none"
           style="font-weight:600; color:#444;">
            <i class="fa-solid fa-chevron-left me-2"></i> Quay lại
        </a>
    <?php endif; ?>
</div>




