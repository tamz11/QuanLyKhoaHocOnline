<?php include __DIR__ . '/../layouts/student_sidebar.php'; ?>

<h3 class="mb-3"><?= htmlspecialchars($course['title'] ?? 'Tiến độ khóa học') ?></h3>

<div class="row g-4">
    <!-- Danh sách bài học -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <strong>Bài giảng</strong>
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach ($lessons as $lesson): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center
                        <?= ($currentLesson['id'] ?? null) == $lesson['id'] ? 'active text-light' : '' ?>">
                        <a href="index.php?controller=student&action=courseProgress&course_id=<?= $course['id'] ?>&lesson_id=<?= $lesson['id'] ?>"
                           class="<?= ($currentLesson['id'] ?? null) == $lesson['id'] ? 'text-light' : '' ?>">
                            <?= $lesson['order'] ?>. <?= htmlspecialchars($lesson['title']) ?>
                        </a>
                        <?php if (($lesson['completed'] ?? false)): ?>
                            <i class="fa-solid fa-circle-check text-success"></i>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Video + nội dung -->
    <div class="col-md-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3"><?= htmlspecialchars($currentLesson['title'] ?? '') ?></h5>
                <?php if (!empty($currentLesson['video_url'])): ?>
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe src="<?= htmlspecialchars($currentLesson['video_url']) ?>"
                                title="Video bài giảng" allowfullscreen></iframe>
                    </div>
                <?php endif; ?>
                <div class="lesson-content">
                    <?= $currentLesson['content'] ?? '<p>Nội dung bài học đang được cập nhật.</p>' ?>
                </div>
            </div>
        </div>

        <!-- Tài liệu đính kèm -->
        <div class="card shadow-sm">
            <div class="card-header"><strong>Tài liệu</strong></div>
            <ul class="list-group list-group-flush">
                <?php if (empty($materials)): ?>
                    <li class="list-group-item small text-muted">Chưa có tài liệu.</li>
                <?php else: ?>
                    <?php foreach ($materials as $m): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa-solid fa-file me-2"></i><?= htmlspecialchars($m['filename']) ?>
                                <span class="badge bg-secondary ms-1"><?= htmlspecialchars($m['file_type']) ?></span>
                            </span>
                            <a href="<?= htmlspecialchars($m['file_path']) ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                Tải
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

</section></div></div>
