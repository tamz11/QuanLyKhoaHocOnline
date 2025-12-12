<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <strong>Thông tin chi tiết người dùng</strong>
        </div>

        <div class="card-body p-0">
            <table class="table mb-0">
                <tr><th>ID</th><td><?= $user['id'] ?></td></tr>
                <tr><th>Username</th><td><?= $user['username'] ?></td></tr>
                <tr><th>Email</th><td><?= $user['email'] ?></td></tr>
                <tr><th>Họ tên</th><td><?= $user['fullname'] ?></td></tr>
                <tr><th>Role</th>
                    <td>
                        <?= $user['role'] == 2 ? "Admin" : ($user['role'] == 1 ? "Giảng viên" : "Học viên") ?>
                    </td>
                </tr>
                <tr><th>Trạng thái</th>
                    <td>
                        <?= $user['is_active'] ? "<span class='badge bg-success'>Active</span>" 
                                             : "<span class='badge bg-secondary'>Disabled</span>" ?>
                    </td>
                </tr>
                <tr><th>Ngày tạo</th><td><?= $user['created_at'] ?></td></tr>
            </table>
        </div>
    </div>

    <!-- ============================== -->
    <!--   KHÓA HỌC GIẢNG VIÊN TẠO       -->
    <!-- ============================== -->
    <?php if ($user['role'] == 1): ?>
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <strong>Khóa học đã tạo</strong>
            </div>

            <div class="card-body">
                <?php if (empty($instructorCourses)): ?>
                    <p class="text-muted">Giảng viên này chưa tạo khóa học nào.</p>
                <?php else: ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên khóa học</th>
                                <th>Giá</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($instructorCourses as $c): ?>
                                <tr>
                                    <td><?= $c['id'] ?></td>
                                    <td><?= htmlspecialchars($c['title']) ?></td>
                                    <td><?= number_format($c['price']) ?> đ</td>
                                    <td><?= $c['created_at'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>


    <!-- ============================== -->
    <!--   KHÓA HỌC HỌC VIÊN ĐĂNG KÝ    -->
    <!-- ============================== -->
    <?php if ($user['role'] == 0): ?>
        <div class="card mt-4">
            <div class="card-header bg-warning text-dark">
                <strong>Khóa học đã đăng ký</strong>
            </div>

            <div class="card-body">
                <?php if (empty($studentEnrollments)): ?>
                    <p class="text-muted">Học viên này chưa đăng ký khóa học nào.</p>
                <?php else: ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID khóa học</th>
                                <th>Tên khóa học</th>
                                <th>Giá</th>
                                <th>Ngày đăng ký</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($studentEnrollments as $e): ?>
                                <tr>
                                    <td><?= $e['course_id'] ?></td>
                                    <td><?= htmlspecialchars($e['title']) ?></td>
                                    <td><?= number_format($e['price']) ?> đ</td>
                                    <td><?= $e['enrolled_date'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

</div>
