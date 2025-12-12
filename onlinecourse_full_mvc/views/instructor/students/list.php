<?php include __DIR__ . '/../../layouts/instructor_sidebar.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Danh sách học viên - <?= htmlspecialchars($course['title']) ?></h3>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Họ & tên</th>
            <th>Email</th>
            <th>Ngày đăng ký</th>
            <th>Tiến độ</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($enrollments as $enrollment): ?>
            <tr>
                <td><?= $enrollment['student_id'] ?></td>
                <td><?= htmlspecialchars($enrollment['fullname']) ?></td>
                <td><?= htmlspecialchars($enrollment['email']) ?></td>
                <td><?= date('d/m/Y', strtotime($enrollment['enrolled_date'])) ?></td>
                <td>
                    <div class="progress" style="width: 100px;">
                        <div class="progress-bar" role="progressbar"
                             style="width: <?= $enrollment['progress'] ?>%"
                             aria-valuenow="<?= $enrollment['progress'] ?>"
                             aria-valuemin="0" aria-valuemax="100">
                            <?= $enrollment['progress'] ?>%
                        </div>
                    </div>
                </td>
                <td class="text-end">
                    <a href="index.php?controller=instructor&action=studentProgress&course_id=<?= $course['id'] ?>&student_id=<?= $enrollment['student_id'] ?>"
                       class="btn btn-sm btn-outline-info">
                        <i class="fa-solid fa-chart-line"></i> Chi tiết
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (empty($enrollments)): ?>
    <div class="alert alert-info">
        Chưa có học viên nào đăng ký khóa học này.
    </div>
<?php endif; ?>

</section></div></div>
