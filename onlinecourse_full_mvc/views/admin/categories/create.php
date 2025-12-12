

<div class="container py-4">
    <h2 class="mb-4">➕ Thêm danh mục khóa học</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="index.php?controller=admin&action=categoriesStore">

                <div class="mb-3">
                    <label class="form-label">Tên danh mục</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value=""
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3"></textarea>
                </div>

                <button class="btn btn-primary">✔ Lưu</button>
                <a href="/index.php?controller=admin&action=categories"
                   class="btn btn-secondary ms-2">← Quay lại</a>
            </form>
        </div>
    </div>
</div>

