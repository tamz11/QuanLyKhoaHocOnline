<?php include __DIR__ . '/../layouts/instructor_sidebar.php'; ?>

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
                <td>$<?= $course['price'] ?></td>
                <td><?= htmlspecialchars($course['level']) ?></td>
                <td><?= htmlspecialchars($course['status'] ?? 'Đã duyệt') ?></td>
                <td class="text-end">
                    <a href="index.php?controller=instructor&action=editCourse&id=<?= $course['id'] ?>"
                       class="btn btn-sm btn-outline-primary">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="index.php?controller=instructor&action=manageLessons&course_id=<?= $course['id'] ?>"
                       class="btn btn-sm btn-outline-secondary">
                        Bài giảng
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
