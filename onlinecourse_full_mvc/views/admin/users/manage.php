<div class="container py-4">

    <h4>Quản lý người dùng</h4>

    <div class="card mt-3">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Họ tên</th>
                        <th>Role</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="8" class="text-center p-3">Không có người dùng</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['id']) ?></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['fullname']) ?></td>
                            <td>
                                <?php
                                    $r = (int)$u['role'];
                                    echo $r === 2 ? 'Admin' : ($r === 1 ? 'Giảng viên' : 'Học viên');
                                ?>
                            </td>
                            <td>
                                <?php if ((int)$u['is_active'] === 1): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Disabled</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($u['created_at'] ?? '') ?></td>

                            <td>

                                <!-- ⭐ NÚT XEM CHI TIẾT (THÊM MỚI) -->
                                <a href="index.php?controller=admin&action=userDetail&id=<?= $u['id'] ?>" 
                                   class="btn btn-sm btn-info text-white mb-1">
                                    Chi tiết
                                </a>

                                <!-- ENABLE / DISABLE giữ nguyên -->
                                <?php if ((int)$u['is_active'] === 1): ?>
                                    <form method="POST" action="index.php?controller=admin&action=handleUser" style="display:inline">
                                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                        <input type="hidden" name="actionType" value="disable">
                                        <button class="btn btn-sm btn-warning">
                                            Vô hiệu
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="index.php?controller=admin&action=handleUser" style="display:inline">
                                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                        <input type="hidden" name="actionType" value="enable">
                                        <button class="btn btn-sm btn-success">Kích hoạt</button>
                                    </form>
                                <?php endif; ?>


                                <!-- DELETE - THAY NÚT BẰNG JS SWEETALERT -->
                                <button 
                                    class="btn btn-sm btn-danger delete-btn"
                                    data-id="<?= $u['id'] ?>"
                                    data-active="<?= $u['is_active'] ?>"
                                >
                                    Xoá
                                </button>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- FORM ẨN ĐỂ GỬI REQUEST XOÁ -->
<form id="deleteForm" method="POST" 
      action="index.php?controller=admin&action=handleUser" style="display:none;">
    <input type="hidden" name="id" id="deleteUserId">
    <input type="hidden" name="actionType" value="delete">
</form>

<!-- ============================= -->
<!-- SWEETALERT -->
<!-- ============================= -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function () {

        let userId = this.dataset.id;
        let isActive = this.dataset.active;

        // Nếu user đang active → không cho xoá
        if (parseInt(isActive) === 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Không thể xoá!',
                text: 'Bạn phải vô hiệu hoá tài khoản trước khi xoá.',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // Nếu user đã disabled → hỏi confirm xoá
        Swal.fire({
            title: 'Bạn có chắc muốn xoá tài khoản này?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Xoá ngay',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteUserId').value = userId;
                document.getElementById('deleteForm').submit();
            }
        });
    });
});
</script>

<?php if (!empty($_SESSION['flash_error'])): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Không thể xoá!',
    text: '<?= $_SESSION['flash_error'] ?>',
});
</script>
<?php unset($_SESSION['flash_error']); endif; ?>

<?php if (!empty($_SESSION['flash_success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Thành công!',
    text: '<?= $_SESSION['flash_success'] ?>',
});
</script>
<?php unset($_SESSION['flash_success']); endif; ?>
