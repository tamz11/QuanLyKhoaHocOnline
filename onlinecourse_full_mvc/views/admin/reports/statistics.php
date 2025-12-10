<?php include __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<h3 class="mb-4">Thống kê hệ thống</h3>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Tổng khóa học</h6>
                <p class="h3 mb-0"><?= $stats['courses'] ?? 0 ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Tổng học viên</h6>
                <p class="h3 mb-0"><?= $stats['students'] ?? 0 ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Tổng giảng viên</h6>
                <p class="h3 mb-0"><?= $stats['instructors'] ?? 0 ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Số lượt đăng ký</h6>
                <p class="h3 mb-0"><?= $stats['enrollments'] ?? 0 ?></p>
            </div>
        </div>
    </div>
</div>

<h5 class="mb-3">Top khóa học được đăng ký nhiều</h5>
<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-light">
        <tr>
            <th>Khóa học</th>
            <th>Giảng viên</th>
            <th>Lượt đăng ký</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($topCourses as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['title']) ?></td>
                <td><?= htmlspecialchars($c['instructor_name']) ?></td>
                <td><?= $c['enrollments'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</section></div></div>
