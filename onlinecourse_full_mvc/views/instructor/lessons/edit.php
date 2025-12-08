<?php include __DIR__ . '/../../layouts/header.php'; ?>
<div class="container py-4">
    <h2 class="mb-4">✏ Chỉnh sửa bài giảng</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Thuộc khóa học</label>
                    <select name="course_id" class="form-select" disabled>
                        <option>
                            <?= htmlspecialchars($lesson['course_title'] ?? 'Khóa học') ?>
                        </option>
                    </select>
                    <div class="form-text">Không cho đổi khóa học trong màn sửa (nếu muốn bạn có thể cho phép).</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tiêu đề bài giảng</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="<?= htmlspecialchars($lesson['title'] ?? '') ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Thứ tự (order)</label>
                    <input type="number"
                           name="order"
                           class="form-control"
                           min="1"
                           value="<?= htmlspecialchars($lesson['order'] ?? 1) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung mô tả</label>
                    <textarea name="content"
                              class="form-control"
                              rows="5"><?= htmlspecialchars($lesson['content'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Link video (YouTube / URL)</label>
                    <input type="url"
                           name="video_url"
                           class="form-control"
                           value="<?= htmlspecialchars($lesson['video_url'] ?? '') ?>">
                </div>

                <button class="btn btn-primary">✔ Cập nhật bài giảng</button>
                <a href="/index.php?controller=instructor&action=manageLessons&course_id=<?= $lesson['course_id'] ?? '' ?>"
                   class="btn btn-secondary ms-2">← Quay lại</a>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
