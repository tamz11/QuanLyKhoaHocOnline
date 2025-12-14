
<h3 class="mb-4">Duyệt khóa học mới</h3>

<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['flash'] ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khóa học</th>
            <th>Giảng viên</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($pendingCourses)): ?>
            <tr><td colspan="4" class="text-center">Chưa có khóa học chờ duyệt.</td></tr>
        <?php else: ?>
            <?php foreach ($pendingCourses as $course): ?>
                <tr>
                    <td><?= $course['id'] ?></td>
                    <td>
                        <strong><?= htmlspecialchars($course['title']) ?></strong><br>
                        <small class="text-muted"><?= htmlspecialchars(substr($course['description'], 0, 100)) ?>...</small>
                    </td>
                    <td>
                        <?php
                        // Lấy tên giảng viên
                        require_once __DIR__ . '/../../../models/User.php';
                        $userModel = new User();
                        $instructor = $userModel->getUserById($course['instructor_id']);
                        echo htmlspecialchars($instructor['fullname'] ?? 'N/A');
                        ?>
                    </td>
                    <td>
                        <a href="index.php?controller=admin&action=approveCourse&id=<?= $course['id'] ?>" 
                           class="btn btn-success btn-sm"
                           onclick="return confirm('Bạn có chắc muốn duyệt khóa học này?')">Duyệt</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</section></div></div>
