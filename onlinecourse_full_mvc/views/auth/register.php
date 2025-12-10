<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-light">
                    <h5 class="mb-0"><i class="fa-solid fa-user-plus me-1"></i> Đăng ký tài khoản</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="index.php?controller=auth&action=doRegister">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ & tên</label>
                                <input type="text" class="form-control" name="fullname" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <button class="btn btn-success w-100" type="submit">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
