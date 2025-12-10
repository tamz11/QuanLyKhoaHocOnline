<?php include __DIR__ . '/../layouts/student_sidebar.php'; ?>

<h3 class="mb-4">Thay đổi mật khẩu</h3>

<form method="post" action="index.php?controller=student&action=updatePassword" class="col-md-6">
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
