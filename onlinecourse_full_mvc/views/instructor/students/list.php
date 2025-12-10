<?php include __DIR__ . '/../../layouts/instructor_sidebar.php'; ?>

<h3 class="mb-4">Danh sách học viên đăng ký khóa học của tôi</h3>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-light">
        <tr>
            <th>Khóa học</th>
            <th>Mã học viên</th>
            <th>Họ & tên</th>
            <th>Email</th>
            <th>Tiến độ</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($enrollments as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['course_title']) ?></td>
                <td><?= $e['student_id'] ?></td>
                <td><?= htmlspecialchars($e['student_name']) ?></td>
                <td><?= htmlspecialchars($e['student_email']) ?></td>
                <td><?= $e['progress'] ?>%</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</section></div></div>
