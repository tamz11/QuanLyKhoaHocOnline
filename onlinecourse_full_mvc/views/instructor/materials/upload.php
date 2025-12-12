<?php include __DIR__ . '/../../layouts/instructor_sidebar.php'; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php if ($_GET['success'] == 1): ?>
            Tài liệu đã được upload thành công!
        <?php elseif ($_GET['success'] == 2): ?>
            Tài liệu đã được xóa thành công!
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php
        $error = urldecode($_GET['error']);
        if ($error == '1') echo 'Lỗi khi lưu thông tin file vào database!';
        elseif ($error == '2') echo 'Lỗi upload file!';
        elseif ($error == '3') echo 'Lỗi khi lưu file!';
        else echo htmlspecialchars($error);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Quản lý tài liệu - <?= htmlspecialchars($course['title']) ?></h3>
</div>

<!-- Form upload -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Upload tài liệu mới</h5>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?controller=instructor&action=uploadMaterial" enctype="multipart/form-data">
            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Chọn bài học</label>
                    <select name="lesson_id" class="form-select" required>
                        <option value="">-- Chọn bài học --</option>
                        <?php foreach ($lessons as $lesson): ?>
                            <option value="<?= $lesson['id'] ?>"><?= htmlspecialchars($lesson['title']) ?> (Thứ tự: <?= $lesson['order'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">File tài liệu</label>
                    <input type="file" name="material_file" class="form-control" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">Upload tài liệu</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Danh sách tài liệu -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Danh sách tài liệu</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                <tr>
                    <th>Bài học</th>
                    <th>Tên file</th>
                    <th>Loại file</th>
                    <th>Ngày upload</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($materials as $material): ?>
                    <tr>
                        <td><?= htmlspecialchars($material['lesson_title']) ?></td>
                        <td>
                            <a href="assets/uploads/materials/<?= $material['file_path'] ?>" target="_blank">
                                <?= htmlspecialchars($material['filename']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($material['file_type']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($material['uploaded_at'])) ?></td>
                        <td class="text-end">
                            <a href="index.php?controller=instructor&action=deleteMaterial&id=<?= $material['id'] ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Xóa tài liệu này?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
