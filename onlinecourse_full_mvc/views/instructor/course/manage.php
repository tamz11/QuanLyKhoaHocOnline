<?php
$pageTitle = "Quản lý khóa học";
include_once __DIR__ . '/../../layouts/header.php';

$menu_role = 'instructor';
include __DIR__ . '/../../layouts/sidebar.php';
?>

<h1 class="h4 mb-3">Quản lý khóa học</h1>

<div class="d-flex justify-content-end mb-3">
    <a href="/instructor/course/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tạo khóa học mới
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>Khóa học</th>
                <th>Ngày tạo</th>
                <th>Bài học</th>
                <th>Giá</th>
                <th></th>
            </tr>
            </thead>

            <tbody>

            <?php foreach ($courses as $c): ?>
                <tr>
                    <td>
                        <strong><?= $c['title'] ?></strong><br>
                        <small class="text-muted"><?= $c['category_name'] ?></small>
                    </td>
                    <td><?= $c['created_at'] ?></td>
                    <td><?= $c['lesson_count'] ?></td>
                    <td><?= number_format($c['price']) ?> đ</td>

                    <td class="text-end">
                        <a href="/instructor/course/edit/<?= $c['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="/instructor/course/delete/<?= $c['id'] ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Xóa khóa học?')">
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($courses)): ?>
                <tr><td colspan="5" class="text-center py-4 text-muted">Chưa có khóa học.</td></tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
