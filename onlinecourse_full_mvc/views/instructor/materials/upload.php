<?php include __DIR__ . '/../../layouts/instructor_sidebar.php'; ?>

<h3 class="mb-4">Upload tài liệu học tập</h3>

<form method="post" action="index.php?controller=instructor&action=storeMaterial" enctype="multipart/form-data" class="row g-3 col-lg-8">
    <div class="col-12">
        <label class="form-label">Chọn bài học</label>
        <select name="lesson_id" class="form-select" required>
            <option value="">-- Chọn bài học --</option>
            <?php foreach ($lessons as $lesson): ?>
                <option value="<?= $lesson['id'] ?>"><?= htmlspecialchars($lesson['course_title']) ?> - <?= htmlspecialchars($lesson['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">File tài liệu</label>
        <input type="file" name="material" class="form-control" required>
    </div>
    <div class="col-12">
        <button class="btn btn-primary">Upload</button>
    </div>
</form>

</section></div></div>
