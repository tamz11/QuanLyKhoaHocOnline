<?php include __DIR__ . '/../../layouts/instructor_sidebar.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Quản lý bài học - <?= htmlspecialchars($course['title']) ?></h3>
    <a href="index.php?controller=instructor&action=createLesson&course_id=<?= $course['id'] ?>" class="btn btn-success">
        <i class="fa-solid fa-plus me-1"></i>Thêm bài học
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Tiêu đề</th>
            <th>Video</th>
            <th>Ngày tạo</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lessons as $lesson): ?>
            <tr>
                <td><?= $lesson['order'] ?></td>
                <td><?= htmlspecialchars($lesson['title']) ?></td>
                <td><?= htmlspecialchars($lesson['video_url']) ?></td>
                <td><?= $lesson['created_at'] ?></td>
                <td class="text-end">
                    <a href="index.php?controller=instructor&action=editLesson&id=<?= $lesson['id'] ?>"
                       class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                    <a href="index.php?controller=instructor&action=deleteLesson&id=<?= $lesson['id'] ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Xóa bài học này?')"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</section></div></div>
