<?php include __DIR__ . '/../layouts/student_sidebar.php'; ?>

<h3 class="mb-3"><?= htmlspecialchars($course['title'] ?? 'Tiến độ khóa học') ?></h3>

<!-- PROGRESS -->
<div class="mb-4">
    <label class="form-label fw-bold">Tiến độ khóa học:</label>
    <div class="progress" style="height: 20px;">
        <div class="progress-bar bg-success" style="width: <?= $progress ?>%;">
            <?= $progress ?>%
        </div>
    </div>
</div>

<div class="row g-4">

<!-- ================= SIDEBAR BÀI HỌC ================= -->
<div class="col-md-4">
    <div class="card shadow-sm h-100">
        <div class="card-header"><strong>Bài giảng</strong></div>
        <ul class="list-group list-group-flush">

            <?php if (empty($lessons)): ?>
                <li class="list-group-item text-muted small">
                    Chưa có bài học nào.
                </li>
            <?php else: ?>
                <?php foreach ($lessons as $lesson): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center
                        <?= ($currentLesson && $currentLesson['id'] == $lesson['id']) ? 'active text-light' : '' ?>">
                        <!-- Link xem bài giảng -->
                        <a href="index.php?controller=student&action=courseProgress&course_id=<?= $course['id'] ?>&lesson_id=<?= $lesson['id'] ?>"
                           class="<?= ($currentLesson && $currentLesson['id'] == $lesson['id']) ? 'text-light' : '' ?>">
                            <?= $lesson['order'] ?>. <?= htmlspecialchars($lesson['title']) ?>
                        </a>
                        <!-- Icon đã hoàn thành -->
                        <?php if (in_array($lesson['id'], $completedLessons)): ?>
                            <i class="fa-solid fa-circle-check text-success"></i>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>

        </ul>
    </div>
</div>

<!-- ================= NỘI DUNG ================= -->
<div class="col-md-8">

    <div class="card shadow-sm mb-3">
        <div class="card-body">

            <h5 class="card-title mb-3">
                <?= htmlspecialchars($currentLesson['title'] ?? 'Nội dung bài học') ?>
            </h5>
            <!-- Video bài học -->
            <?php if (!empty($currentLesson['video_url'])): ?>
                <div class="ratio ratio-16x9 mb-3">
                    <iframe src="<?= htmlspecialchars($currentLesson['video_url']) ?>" allowfullscreen></iframe>
                </div>
            <?php endif; ?>
            <!-- Nội dung bài học -->
            <div class="lesson-content">
                <?= $currentLesson['content'] ?? '<p>Nội dung bài học đang được cập nhật.</p>' ?>
            </div>

        </div>
    </div>

    <!-- NÚT HOÀN THÀNH -->
    <?php if ($currentLesson): ?>
        <?php if (!in_array($currentLesson['id'], $completedLessons)): ?>
            <a href="index.php?controller=student&action=markDone&lesson_id=<?= $currentLesson['id'] ?>&course_id=<?= $course['id'] ?>"
               class="btn btn-success mb-3">
                <i class="fa-solid fa-check me-1"></i> Đánh dấu hoàn thành
            </a>
        <?php else: ?>
            <div class="alert alert-success mb-3">
                <i class="fa-solid fa-circle-check me-2"></i>
                Bạn đã hoàn thành bài học này!
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- TÀI LIỆU -->
    <div class="card shadow-sm">
        <div class="card-header"><strong>Tài liệu</strong></div>
        <ul class="list-group list-group-flush">

            <?php if (empty($materials)): ?>
                <li class="list-group-item small text-muted">
                    Chưa có tài liệu.
                </li>
            <?php else: ?>
                <?php foreach ($materials as $m): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fa-solid fa-file me-2"></i>
                            <?= htmlspecialchars($m['filename']) ?>
                        </span>
                        <a href="<?= htmlspecialchars($m['file_path']) ?>" target="_blank"
                           class="btn btn-sm btn-outline-primary">
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
