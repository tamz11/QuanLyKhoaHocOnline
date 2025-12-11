<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-light">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Đăng nhập
                    </h5>
                </div>

                <div class="card-body">

                    <!-- HIỂN THỊ LỖI NẾU CÓ -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?controller=auth&action=doLogin">
                        <div class="mb-3">
                            <label class="form-label">Email hoặc Username</label>
                            <!-- SỬA name="username" → name="login" để đúng với findByLogin() -->
                            <input type="text" class="form-control" name="login" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">
                            Đăng nhập
                        </button>
                    </form>

                    <p class="small mt-3 mb-0 text-center">
                        Chưa có tài khoản?
                        <a href="index.php?controller=auth&action=register">Đăng ký ngay</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>