
<?php include __DIR__ . '/../../layouts/instructor_sidebar.php';// Nếu bạn có sidebar riêng cho giảng viên thì include thêm ở đây ?>
<div class="container py-4">
    <h2 class="mb-4">✏ Chỉnh sửa khóa học</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="index.php?controller=instructor&action=updateCourse&id=<?= $course['id'] ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Tên khóa học</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="<?= htmlspecialchars($course['title'] ?? '') ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= (!empty($course['category_id']) && $course['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description"
                              class="form-control"
                              rows="4"><?= htmlspecialchars($course['description'] ?? '') ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá (VNĐ)</label>
                        <input type="number"
                               name="price"
                               class="form-control"
                               value="<?= htmlspecialchars($course['price'] ?? 0) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Thời lượng (tuần)</label>
                        <input type="number"
                               name="duration_weeks"
                               class="form-control"
                               value="<?= htmlspecialchars($course['duration_weeks'] ?? 1) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trình độ</label>
                    <select name="level" class="form-select">
                        <?php
                        $levels = ['Cơ bản', 'Trung cấp', 'Nâng cao'];
                        $currentLevel = $course['level'] ?? '';
                        foreach ($levels as $lv): ?>
                            <option value="<?= $lv ?>" <?= $lv == $currentLevel ? 'selected' : '' ?>>
                                <?= $lv ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if (!empty($course['image'])): ?>
                    <div class="mb-3">
                        <label class="form-label">Hình hiện tại</label><br>
                        <img src="/assets/uploads/courses/<?= htmlspecialchars($course['image']) ?>"
                             alt="Course image"
                             style="max-width: 200px; border-radius: 8px;">
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Đổi hình ảnh (nếu muốn)</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button class="btn btn-primary">✔ Cập nhật khóa học</button>
                <a href="/index.php?controller=instructor&action=myCourses"
                   class="btn btn-secondary ms-2">← Quay lại</a>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
