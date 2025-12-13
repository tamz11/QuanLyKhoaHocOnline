
<div class="container py-4">

<h2 class="mb-4">✏ Sửa danh mục khóa học</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <!-- ⭐ Sửa action để gửi về đúng controller -->
            <form method="post" action="index.php?controller=admin&action=categoriesUpdate">


                <!-- Truyền ID danh mục cần sửa -->
                <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">

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

                <!-- ⭐ Sửa link quay lại -->
                <a href="index.php?controller=admin&action=categories"
                   class="btn btn-secondary ms-2">← Quay lại</a>

            </form>

        </div>
    </div>

</div>

