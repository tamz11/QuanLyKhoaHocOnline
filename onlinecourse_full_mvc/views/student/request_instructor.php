<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Yêu cầu trở thành Giảng viên</h5>
        </div>
        <div class="card-body">
          <?php if (!empty($existing)): ?>
            <div class="alert alert-secondary">
              Bạn đã gửi yêu cầu vào <strong><?= htmlspecialchars($existing['created_at']) ?></strong>.
              Trạng thái: <strong><?= htmlspecialchars($existing['status']) ?></strong>
              <?php if (!empty($existing['updated_at'])): ?>
                (Cập nhật: <?= htmlspecialchars($existing['updated_at']) ?>)
              <?php endif; ?>
            </div>
          <?php else: ?>
            <form method="POST" action="index.php?controller=student&action=doRequestInstructor">
              <div class="mb-3">
                <label class="form-label">Lý do/kinh nghiệm ngắn (bắt buộc)</label>
                <textarea name="description" class="form-control" rows="6" required></textarea>
              </div>
              <button class="btn btn-primary">Gửi yêu cầu</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
