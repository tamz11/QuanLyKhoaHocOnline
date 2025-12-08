<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentUser = $_SESSION['user'] ?? null;
?>

<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>OnlineCourse - VSchool MVC</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<header class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="fa-solid fa-graduation-cap me-1"></i> VSchool
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <nav class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?controller=course&action=index">Khóa học</a></li>
            </ul>

            <!-- ========================= -->
            <!--   KIỂM TRA ĐĂNG NHẬP     -->
            <!-- ========================= -->
            <ul class="navbar-nav ms-auto">

                <?php if ($currentUser): ?>

                    <!-- Link theo role -->
                    <?php if ($currentUser['role'] == 2): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=admin&action=dashboard">
                                <i class="fa-solid fa-user-shield me-1"></i> Quản trị
                            </a>
                        </li>

                    <?php elseif ($currentUser['role'] == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=instructor&action=dashboard">
                                <i class="fa-solid fa-chalkboard-user me-1"></i> Giảng viên
                            </a>
                        </li>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=student&action=dashboard">
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
