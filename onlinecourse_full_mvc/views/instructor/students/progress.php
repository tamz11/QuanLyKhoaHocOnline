<?php include __DIR__ . '/../../layouts/instructor_sidebar.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Tiến độ học viên: <?= htmlspecialchars($student['fullname']) ?></h3>
    <a href="index.php?controller=instructor&action=students&course_id=<?= $course['id'] ?>" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin học viên</h5>
            </div>
            <div class="card-body">
                <p><strong>Họ tên:</strong> <?= htmlspecialchars($student['fullname']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                <p><strong>Ngày đăng ký:</strong> <?= date('d/m/Y', strtotime($enrollment['enrolled_date'])) ?></p>
                <p><strong>Tiến độ tổng thể:</strong></p>
                <div class="progress mb-2">
                    <div class="progress-bar" role="progressbar"
                         style="width: <?= $enrollment['progress'] ?>%"
                         aria-valuenow="<?= $enrollment['progress'] ?>"
                         aria-valuemin="0" aria-valuemax="100">
                        <?= $enrollment['progress'] ?>%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Chi tiết bài học</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tiêu đề bài học</th>
                            <th>Trạng thái</th>
                            <th>Ngày hoàn thành</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($lessons as $lesson): ?>
                            <tr>
                                <td><?= $lesson['order'] ?></td>
                                <td><?= htmlspecialchars($lesson['title']) ?></td>
                                <td>
                                    <?php
                                    $completed = isset($progressMap[$lesson['id']]) && $progressMap[$lesson['id']] == 1;
                                    ?>
                                    <?php if ($completed): ?>
                                        <span class="badge bg-success">Hoàn thành</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Chưa hoàn thành</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($completed): ?>
                                        15/12/2025
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</section></div></div>