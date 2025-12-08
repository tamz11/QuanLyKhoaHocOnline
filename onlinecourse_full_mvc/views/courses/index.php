<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Tất cả các khóa học</h2>
        <form class="d-flex" method="get" action="">
            <input type="hidden" name="controller" value="course">
            <input type="hidden" name="action" value="search">
            <input class="form-control me-2" type="search" name="q" placeholder="Tìm khóa học...">
            <button class="btn btn-outline-primary" type="submit">Tìm</button>
        </form>
    </div>

    <!-- sau này controller truyền $categories -->
    <!-- Lọc theo danh mục -->
    <div class="mb-4">
        <a href="index.php?controller=course&action=index" class="badge bg-secondary text-decoration-none me-1">Tất cả</a>
        <!-- foreach categories -->
        <!-- <a href="...&category=1" class="badge bg-outline-primary me-1">Web Development</a> -->
    </div>

    <!-- Grid khoá học -->
    <div class="row g-4">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img src="assets/uploads/courses/<?= htmlspecialchars($course['image']) ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($course['title']) ?>">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"><?= htmlspecialchars($course['title']) ?></h6>
                            <p class="small text-muted mb-2">
                                Cấp độ: <?= htmlspecialchars($course['level']) ?>
                            </p>
                            <p class="mb-2">
                                <span class="text-muted text-decoration-line-through me-1">$<?= $course['old_price'] ?? '' ?></span>
                                <span class="fw-bold text-danger">$<?= $course['price'] ?></span>
                            </p>
                            <a href="index.php?controller=course&action=detail&id=<?= $course['id'] ?>"
                               class="btn btn-primary btn-sm mt-auto">Xem khóa học</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có khóa học nào.</p>
        <?php endif; ?>
    </div>
</div>
