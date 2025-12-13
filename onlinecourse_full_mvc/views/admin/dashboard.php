<h3 class="mb-4">Trang quản trị</h3>

<div class="row g-3 mb-4">

    <!-- Tổng người dùng -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-primary text-light">
            <div class="card-body">
                <h6 class="mb-1">Tổng người dùng</h6>
                <p class="display-6 mb-0">
                    <?= $stats['total_users'] ?? 0 ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Học viên -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-success text-light">
            <div class="card-body">
                <h6 class="mb-1">Học viên</h6>
                <p class="display-6 mb-0">
                    <?= $stats['students'] ?? 0 ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Giảng viên -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-warning text-dark">
            <div class="card-body">
                <h6 class="mb-1">Giảng viên</h6>
                <p class="display-6 mb-0">
                    <?= $stats['instructors'] ?? 0 ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Tổng khóa học -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-danger text-light">
            <div class="card-body">
                <h6 class="mb-1">Tổng khóa học</h6>
                <p class="display-6 mb-0">
                    <?= $stats['total_courses'] ?? 0 ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Khóa học chờ duyệt -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-info text-light">
            <div class="card-body">
                <h6 class="mb-1">Khóa học chờ duyệt</h6>
                <p class="display-6 mb-0">
                    <?= $stats['pending_courses'] ?? 0 ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Danh mục -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-secondary text-light">
            <div class="card-body">
                <h6 class="mb-1">Danh mục khóa học</h6>
                <p class="display-6 mb-0">
                    <?= $stats['total_categories'] ?? 0 ?>
                </p>
            </div>
        </div>
    </div>

</div>

<!-- <h5 class="mb-3">Giao dịch gần đây</h5>
<div class="alert alert-secondary">
    Chưa có dữ liệu.
</div> -->

</section></div></div>
