<?php include __DIR__ . '/../layouts/student_sidebar.php'; ?>

<h3 class="mb-4">Thay đổi mật khẩu</h3>

<!-- Thông báo lỗi -->
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<!-- Thông báo thành công -->
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="col-md-6">
    <form method="post" action="index.php?controller=student&action=updatePassword">

        <div class="mb-3">
            <label class="form-label">Mật khẩu hiện tại</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mật khẩu mới</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nhập lại mật khẩu mới</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <button class="btn btn-primary mt-2">Cập nhật</button>
    </form>
</div>

</section>
</div>
</div>
