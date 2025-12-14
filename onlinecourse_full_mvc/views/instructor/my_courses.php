<?php include __DIR__ . '/../layouts/instructor_sidebar.php'; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php if ($_GET['success'] == 1): ?>
            <?= htmlspecialchars($_GET['message'] ?? 'Khóa học đã được tạo thành công!') ?>
        <?php elseif ($_GET['success'] == 2): ?>
            Khóa học đã được cập nhật thành công!
        <?php elseif ($_GET['success'] == 3): ?>
            Khóa học đã được xóa thành công!
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Có lỗi xảy ra. Vui lòng thử lại!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Khoá học của tôi</h3>
    <a href="index.php?controller=instructor&action=createCourse"
       class="btn btn-success"><i class="fa-solid fa-plus me-1"></i>Tạo khóa học mới</a>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Cấp độ</th>
            <th>Trạng thái</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?= $course['id'] ?></td>
                <td><?= htmlspecialchars($course['title']) ?></td>
                <td><?= htmlspecialchars($course['category_name']) ?></td>
                <td><?= number_format($course['price']) ?>đ</td>
                <td><?= htmlspecialchars($course['level']) ?></td>
                <td>
                    <?php if ($course['approved'] == 1): ?>
                        <span class="badge bg-success">Đã duyệt</span>
                    <?php else: ?>
                        <span class="badge bg-warning">Chờ duyệt</span>
                    <?php endif; ?>
                </td>
                <td class="text-end">
                    <a href="index.php?controller=instructor&action=editCourse&id=<?= $course['id'] ?>"
                       class="btn btn-sm btn-outline-primary">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="index.php?controller=instructor&action=deleteCourse&id=<?= $course['id'] ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Xóa khóa học này?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</section></div></div>
