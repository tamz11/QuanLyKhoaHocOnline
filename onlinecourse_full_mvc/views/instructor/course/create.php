<?php include __DIR__ . '/../../layouts/instructor_sidebar.php'; ?>

<h3 class="mb-4">Tạo khóa học mới</h3>

<form method="post" action="index.php?controller=instructor&action=storeCourse" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Tiêu đề khóa học</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Danh mục</label>
        <select name="category_id" class="form-select" required>
            <option value="">-- Chọn danh mục --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Giá ($)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="0">
    </div>
    <div class="col-md-4">
        <label class="form-label">Thời lượng (tuần)</label>
        <input type="number" name="duration_weeks" class="form-control" value="1">
    </div>
    <div class="col-md-4">
        <label class="form-label">Cấp độ</label>
        <select name="level" class="form-select">
            <option>Beginner</option>
            <option>Intermediate</option>
            <option>Advanced</option>
        </select>
    </div>

    <div class="col-md-12">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Ảnh khóa học</label>
        <input type="file" name="image" class="form-control">
    </div>

    <div class="col-12">
        <button class="btn btn-success">Lưu khóa học</button>
        <a href="index.php?controller=instructor&action=myCourses" class="btn btn-outline-secondary">Hủy</a>
    </div>
</form>

</section></div></div>
