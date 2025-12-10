<?php include __DIR__ . '/../layouts/student_sidebar.php'; ?>

<h3 class="mb-4">Trang cá nhân học viên</h3>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Tiến độ học tập</h6>
                <p class="display-6 mb-0"><?= $overallProgress ?? 0 ?>%</p>
                <div class="progress mt-2">
                    <div class="progress-bar" role="progressbar"
                         style="width: <?= $overallProgress ?? 0 ?>%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Số khóa học đã đăng ký</h6>
                <p class="display-6 mb-0"><?= $totalCourses ?? 0 ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Khóa học đã hoàn thành</h6>
                <p class="display-6 mb-0"><?= $completedCourses ?? 0 ?></p>
            </div>
        </div>
    </div>
</div>

<hr class="my-4">

<h5>Thông tin tài khoản</h5>
<form method="post" action="index.php?controller=student&action=updateProfile" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Họ & tên</label>
        <input type="text" name="fullname" class="form-control"
               value="<?= htmlspecialchars($currentUser['fullname'] ?? '') ?>">
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" value="<?= htmlspecialchars($currentUser['email'] ?? '') ?>" disabled>
    </div>
    <div class="col-md-6">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($currentUser['username'] ?? '') ?>" disabled>
    </div>
    <div class="col-md-6">
        <label class="form-label">Ảnh đại diện</label>
        <input type="file" name="avatar" class="form-control">
    </div>
    <div class="col-12">
        <button class="btn btn-primary">Cập nhật</button>
    </div>
</form>

<?php include __DIR__ . '/../layouts/student_sidebar_end.php'; // hoặc đóng section/row/container như đã nói ?>
