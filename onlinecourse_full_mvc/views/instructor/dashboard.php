<?php include __DIR__ . '/../layouts/instructor_sidebar.php'; ?>

<h3 class="mb-4">Dashboard giảng viên</h3>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Số khóa học đang dạy</h6>
                <p class="display-6 mb-0"><?= $totalCourses ?? 0 ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Tổng số học viên</h6>
                <p class="display-6 mb-0"><?= $totalStudents ?? 0 ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Bài giảng đã xuất bản</h6>
                <p class="display-6 mb-0"><?= $totalLessons ?? 0 ?></p>
            </div>
        </div>
    </div>
</div>

<h5 class="mb-3">Khóa học mới nhất</h5>
<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Danh mục</th>
            <th>Số bài học</th>
            <th>Số học viên</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($recentCourses as $course): ?>
            <tr>
                <td><?= $course['id'] ?></td>
                <td><?= htmlspecialchars($course['title']) ?></td>
                <td><?= htmlspecialchars($course['category_name']) ?></td>
                <td><?= $course['lessons_count'] ?></td>
                <td><?= $course['students_count'] ?></td>
                <td>
                    <a href="index.php?controller=instructor&action=editCourse&id=<?= $course['id'] ?>"
                       class="btn btn-sm btn-outline-primary">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="index.php?controller=instructor&action=manageLessons&course_id=<?= $course['id'] ?>"
                       class="btn btn-sm btn-outline-secondary">
                        Bài giảng
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</section></div></div>
