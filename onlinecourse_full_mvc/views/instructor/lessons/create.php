<?php include __DIR__ . '/../../layouts/header.php'; ?>
<div class="container py-4">
    <h2 class="mb-4">➕ Tạo bài giảng mới</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="index.php?controller=instructor&action=storeLesson">
                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Tiêu đề bài giảng</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Thứ tự (order)</label>
                    <input type="number"
                           name="order"
                           class="form-control"
                           min="1"
                           value="<?= htmlspecialchars($nextOrder ?? 1) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung mô tả</label>
                    <textarea name="content"
                              class="form-control"
                              rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Link video (YouTube / URL)</label>
                    <input type="url"
                           name="video_url"
                           class="form-control"
                           placeholder="https://...">
                </div>

                <button class="btn btn-primary">✔ Lưu bài giảng</button>
                <a href="/index.php?controller=instructor&action=manageLessons"
                   class="btn btn-secondary ms-2">← Quay lại</a>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
