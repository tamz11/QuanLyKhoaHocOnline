<div class="container py-4">
    <h3 class="mb-4">Thay đổi mật khẩu</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="index.php?controller=admin&action=updatePassword">

                <div class="mb-3">
                    <label class="form-label">Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu mới</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>

                <button class="btn btn-primary">
                    <i class="fa-solid fa-key me-1"></i>
                    Đổi mật khẩu
                </button>

            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
<?php if (!empty($_SESSION['password_success'])): ?>
Swal.fire({
    icon: 'success',
    title: 'Thành công!',
    text: '<?= $_SESSION['password_success'] ?>'
});
<?php unset($_SESSION['password_success']); endif; ?>

<?php if (!empty($_SESSION['password_error'])): ?>
Swal.fire({
    icon: 'error',
    title: 'Lỗi!',
    text: '<?= $_SESSION['password_error'] ?>'
});
<?php unset($_SESSION['password_error']); endif; ?>
</script>
