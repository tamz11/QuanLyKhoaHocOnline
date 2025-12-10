<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-4">
            <img src="assets/uploads/courses/<?= htmlspecialchars($course['image']) ?>"
                 class="img-fluid rounded shadow-sm"
                 alt="<?= htmlspecialchars($course['title']) ?>">
        </div>
        <div class="col-md-8">
            <h2><?= htmlspecialchars($course['title']) ?></h2>
            <p class="text-muted"><?= htmlspecialchars($course['description']) ?></p>
            <p class="mb-1"><strong>Thời lượng:</strong> <?= $course['duration_weeks'] ?> tuần</p>
            <p class="mb-1"><strong>Cấp độ:</strong> <?= htmlspecialchars($course['level']) ?></p>
            <p class="mb-3">
                <span class="text-muted text-decoration-line-through me-2">$<?= $course['old_price'] ?? '' ?></span>
                <span class="fw-bold text-danger h5 mb-0">$<?= $course['price'] ?></span>
            </p>

            <a href="index.php?controller=enrollment&action=checkout&course_id=<?= $course['id'] ?>"
               class="btn btn-primary btn-lg">Mua ngay</a>
        </div>
    </div>

    <hr class="my-4">

    <h4>Danh sách bài học</h4>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Tên bài học</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($lessons as $lesson): ?>
                <tr>
                    <td><?= $lesson['order'] ?></td>
                    <td><?= htmlspecialchars($lesson['title']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
