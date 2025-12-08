<?php include __DIR__ . '/../layouts/student_sidebar.php'; ?>

<h3 class="mb-4">Khóa học của tôi</h3>

<?php if (empty($myCourses)): ?>
    <div class="alert alert-info">Bạn chưa đăng ký khóa học nào.</div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($myCourses as $course): ?>
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="row g-0 h-100">
                        <div class="col-md-4">
                            <img src="assets/uploads/courses/<?= htmlspecialchars($course['image']) ?>"
                                 class="img-fluid rounded-start h-100 w-100 object-fit-cover"
                                 alt="<?= htmlspecialchars($course['title']) ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1"><?= htmlspecialchars($course['title']) ?></h5>
                                <p class="small text-muted mb-1">
                                    Giảng viên: <?= htmlspecialchars($course['instructor_name'] ?? '') ?>
                                </p>
                                <p class="small mb-2"><?= htmlspecialchars($course['short_description'] ?? '') ?></p>
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between small">
                                        <span>Tiến độ</span>
                                        <span><?= $course['progress'] ?? 0 ?>%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: <?= $course['progress'] ?? 0 ?>%"></div>
                                    </div>
                                </div>
                                <div class="mt-auto">
                                    <a href="index.php?controller=student&action=courseProgress&course_id=<?= $course['id'] ?>"
                                       class="btn btn-primary btn-sm">Vào học</a>
                                    <a href="index.php?controller=course&action=detail&id=<?= $course['id'] ?>"
                                       class="btn btn-outline-secondary btn-sm">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

</section></div></div>
