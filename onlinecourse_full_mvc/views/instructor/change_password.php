<?php include __DIR__ . '/../layouts/instructor_sidebar.php'; ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<h3 class="mb-4">Thay đổi mật khẩu</h3>

<form method="post" 
      action="index.php?controller=instructor&action=updatePassword" 
      class="col-md-6">

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
        <input type="password" name="new_password_confirmation" class="form-control" required>
    </div>

    <button class="btn btn-primary">Cập nhật</button>
</form>

</section></div></div>
