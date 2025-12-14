<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Yêu cầu trở thành Giảng viên</h5>
        </div>
        <div class="card-body">

          <?php if (!empty($existing)): ?>

            <?php
              $status = $existing['status'];

              // Màu theo trạng thái
              $alertClass = match ($status) {
                  'approved' => 'alert-success',
                  'rejected' => 'alert-danger',
                  default    => 'alert-warning', // pending
              };

              // Text hiển thị
              $statusText = match ($status) {
                  'approved' => 'Đã được chấp nhận',
                  'rejected' => 'Bị từ chối',
                  default    => 'Đang chờ duyệt',
              };
            ?>

            <div class="alert <?= $alertClass ?>">
              <p class="mb-1">
                Bạn đã gửi yêu cầu vào
                <strong><?= htmlspecialchars($existing['created_at']) ?></strong>
              </p>

              <p class="mb-1">
                Trạng thái:
                <strong><?= $statusText ?></strong>
              </p>

              <?php if (!empty($existing['updated_at'])): ?>
                <small class="text-muted">
                  Cập nhật: <?= htmlspecialchars($existing['updated_at']) ?>
                </small>
              <?php endif; ?>
            </div>

          <?php else: ?>

            <form method="POST" action="index.php?controller=student&action=doRequestInstructor">
              <div class="mb-3">
                <label class="form-label">
                  Lý do / kinh nghiệm ngắn <span class="text-danger">*</span>
                </label>
                <textarea name="description"
                          class="form-control"
                          rows="6"
                          required></textarea>
              </div>
              <button class="btn btn-primary">
                <i class="fa-solid fa-paper-plane me-1"></i>
                Gửi yêu cầu
              </button>
            </form>

          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- ================= SWEETALERT2 ================= -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
<?php if (!empty($_SESSION['request_success'])): ?>
    Swal.fire({
        icon: 'success',
        title: 'Gửi yêu cầu thành công!',
        text: 'Vui lòng chờ Admin duyệt.',
        confirmButtonText: 'OK'
    });
<?php unset($_SESSION['request_success']); endif; ?>

<?php if (!empty($_SESSION['request_error'])): ?>
    Swal.fire({
        icon: 'error',
        title: 'Không thể gửi yêu cầu',
        text: '<?= addslashes($_SESSION['request_error']) ?>',
        confirmButtonText: 'OK'
    });
<?php unset($_SESSION['request_error']); endif; ?>
</script>
