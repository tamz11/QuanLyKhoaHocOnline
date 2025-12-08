<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php include __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<h2 class="mb-4">✏ Sửa danh mục khóa học</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Tên danh mục</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="<?= htmlspecialchars($category['name'] ?? '') ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
                </div>

                <button class="btn btn-primary">✔ Cập nhật</button>
                <a href="/index.php?controller=admin&action=listCategories"
                   class="btn btn-secondary ms-2">← Quay lại</a>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
