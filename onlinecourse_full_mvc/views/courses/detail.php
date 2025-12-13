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
            <p class="mb-1"><strong>Giảng viên:</strong> <?= htmlspecialchars($course['instructor']) ?></p>

            <p class="mb-1"><strong>Thời lượng:</strong> <?= $course['duration_weeks'] ?> tuần</p>
            <p class="mb-1"><strong>Cấp độ:</strong> <?= htmlspecialchars($course['level']) ?></p>
            <p class="mb-3">
                <span class="fw-bold text-danger h5 mb-0"><?= number_format($course['price']) . "đ" ?></span>
            </p>
            
            <?php if (!$currentUser): ?>
                <!-- Chưa đăng nhập → đưa thẳng về trang login -->
                <a href="index.php?controller=auth&action=login"
                class="btn btn-primary btn-lg">
                Đăng ký học
                </a>
            <?php elseif ($isEnrolled): ?>
                <button class="btn btn-secondary btn-lg" disabled>Đã đăng ký</button>
            <?php else: ?>
                <a href="#"
                class="btn btn-primary btn-lg"
                id="btnRegister">
                Đăng ký học
                </a>
            <?php endif; ?>



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
<!-- Modal Thanh toán -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 14px;">

            <div class="modal-header ">
                <h5 class="modal-title fw-bold">Xác nhận đăng ký khóa học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-3">
                <p class="text-muted mb-1">Bạn đang đăng ký khóa học:</p>
                <h5 id="courseTitle" class="fw-semibold"></h5>

                <p class="text-muted mt-3 mb-1">Tổng số tiền phải thanh toán:</p>
                <h3 class="text-danger fw-bold" id="coursePrice"></h3>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                
                <!-- Xác nhận nằm TRÁI -->
                <a id="confirmPaymentBtn" 
                   href="#" 
                   class="btn btn-primary px-4 py-2 fw-semibold">
                   Xác nhận thanh toán
                </a>

                <!-- Hủy nằm PHẢI -->
                <button class="btn btn-outline-secondary px-4 py-2 fw-semibold" 
                        data-bs-dismiss="modal">
                    Hủy
                </button>
            </div>

        </div>
    </div>
</div>

<script>
// Lấy dữ liệu từ PHP
const courseName = "<?= $course['title'] ?>";
const coursePrice = "<?= number_format($course['price'], 0, ',', '.') ?>đ";
const courseId = <?= $course['id'] ?>;

// Bắt sự kiện click
document.getElementById("btnRegister").addEventListener("click", function () {

    // Gán dữ liệu vào modal
    document.getElementById("courseTitle").innerText = courseName;
    document.getElementById("coursePrice").innerText = coursePrice;

    // Link xác nhận thanh toán (gọi controller)
    document.getElementById("confirmPaymentBtn").href =
    "index.php?controller=enrollment&action=enroll&course_id=" + courseId;


    // Hiện modal Bootstrap
    var modal = new bootstrap.Modal(document.getElementById("paymentModal"));
    modal.show();
});
</script>
