<?php
$pageTitle = "Kết quả tìm kiếm";
include_once __DIR__ . '/../layouts/header.php';
?>

<h1 class="h4 mb-3">Kết quả tìm kiếm: “<?= htmlspecialchars($keyword) ?>”</h1>

<div class="row g-3">

<?php foreach ($results as $course): ?>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm course-card">
            <img src="<?= $course['image'] ?: '/assets/img/course-placeholder.jpg' ?>"
                 class="card-img-top">

            <div class="card-body d-flex flex-column">
                <h5 class="card-title text-truncate"><?= htmlspecialchars($course['title']) ?></h5>

                <small class="text-muted mb-2 text-truncate"><?= $course['instructor_name'] ?></small>

                <p class="small text-muted flex-grow-1">
                    <?= htmlspecialchars(mb_strimwidth($course['description'], 0, 60, '...')) ?>
                </p>

                <div class="d-flex justify-content-between align-items-center mt-2">
                    <strong class="text-primary">
                        <?= $course['price'] > 0 ? number_format($course['price']) . "đ" : "Miễn phí" ?>
                    </strong>

                    <a href="/courses/detail/<?= $course['id'] ?>" class="btn btn-sm btn-outline-primary">
                        Xem
                    </a>
                </div>
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

<?php include __DIR__ . '/../layouts/footer.php'; ?>
