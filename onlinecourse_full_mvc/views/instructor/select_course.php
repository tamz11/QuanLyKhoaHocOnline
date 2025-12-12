<?php include __DIR__ . '/../layouts/instructor_sidebar.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><?= htmlspecialchars($title) ?></h3>
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
                <td><?= htmlspecialchars($course['status'] ?? 'Đã duyệt') ?></td>
                <td class="text-end">
                    <a href="index.php?controller=instructor&action=<?= $action ?>&course_id=<?= $course['id'] ?>"
                       class="btn btn-sm btn-primary">
                        Chọn
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</section></div></div>