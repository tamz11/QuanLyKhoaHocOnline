<?php
$pageTitle = "Kết quả tìm kiếm";
include_once __DIR__ . '/../layouts/header.php';
?>
<div class="container py-5">
<h1 class="h4 mb-3">Kết quả tìm kiếm: “<?= htmlspecialchars($keyword) ?>”</h1>

<div class="row g-3">

<?php foreach ($results as $course): ?>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm course-card">
            <img src="assets/uploads/courses/<?= htmlspecialchars($course['image']) ?>"
                    class="card-img-top"
                    alt="<?= htmlspecialchars($course['title']) ?>">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                <p class="small text-muted mb-2">
                    Cấp độ: <?= htmlspecialchars($course['level']) ?>
                </p>
                <p class="mb-2">
                    <span class="fw-bold text-danger"><?= number_format($course['price']) . "đ" ?></span>
                </p>
                <a href="index.php?controller=course&action=detail&id=<?= $course['id'] ?>"
                    class="btn btn-primary btn-sm mt-auto">Xem khóa học</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php if (empty($results)): ?>
    <div class="col-12 text-center text-muted py-4">
        Không tìm thấy khóa học phù hợp.
    </div>
<?php endif; ?>

</div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
