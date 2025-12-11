<?php
// views/home/index.php
?>

<!-- Hero -->
<section class="bg-dark text-light position-relative">
    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"
         style="background: url('assets/uploads/images/background.png') center/cover no-repeat;
                opacity: .35;"></div>

    <div class="container position-relative py-5 text-center">
        <h1 class="display-4 fw-bold mb-3">Chào mừng đến với OnlineCourse</h1>
        <p class="lead mb-4">Học & thực hành các kỹ năng mới với hệ thống khóa học online.</p>
        <a href="index.php?controller=course&action=index" class="btn btn-danger btn-lg">
            Bắt đầu học ngay
        </a>
    </div>
</section>

<!-- Khoá học phổ biến -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Các khóa học phổ biến</h2>

        <div class="row g-4">
            <?php if (!empty($popularCourses)): ?>
                <?php foreach ($popularCourses as $course): ?>
                    <div class="col-md-3">
                        <div class="card h-100 shadow-sm">
                            <img src="assets/uploads/courses/<?= htmlspecialchars($course['image']) ?>"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars($course['title']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>

                                <p class="small text-muted mb-2">
                                    Giảng viên: <?= htmlspecialchars($course['instructor_name'] ?? '') ?>
                                </p>

                                <p class="small text-muted mb-2">
                                    Cấp độ: <?= htmlspecialchars($course['level'] ?? '') ?>
                                </p>

                                <p class="mb-2">
                                    <span class="fw-bold text-danger">
                                        <?= isset($course['price']) ? number_format($course['price']) . "đ" : "" ?>
                                    </span>
                                </p>

                                <a href="index.php?controller=course&action=detail&id=<?= $course['id'] ?>"
                                   class="btn btn-primary btn-sm mt-auto">
                                    Xem khóa học
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có khóa học nào.</p>
            <?php endif; ?>
        </div>

        <div class="text-center mt-4">
            <a href="index.php?controller=course&action=index" class="btn btn-outline-primary">
                Xem toàn bộ khóa học
            </a>
        </div>
    </div>
</section>

<!-- Liên hệ -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Liên hệ</h2>
        <div class="row g-4">
            <div class="col-md-7">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Họ & tên</label>
                        <input type="text" class="form-control" placeholder="Nhập tên của bạn">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="you@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea class="form-control" rows="4" placeholder="Chúng tôi có thể hỗ trợ gì cho bạn?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi</button>
                </form>
            </div>
            <div class="col-md-5 d-flex align-items-center justify-content-center">
                <div class="bg-danger text-light p-4 rounded-3 shadow">
                    <h4 class="mb-1">OnlineCourse</h4>
                    <p class="mb-0 small">Tầng 3, Tòa nhà CNTT<br>Đại học Thủy lợi</p>
                </div>
            </div>
        </div>
    </div>
</section>
