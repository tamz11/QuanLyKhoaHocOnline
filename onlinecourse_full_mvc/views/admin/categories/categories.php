<div class="container py-4">

    <h4>Danh mục khóa học</h4>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
        </div>
    <?php endif; ?>

    <a href="index.php?controller=admin&action=categoriesCreate"
       class="btn btn-success mb-3">+ Thêm danh mục</a>

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($categories as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['name']) ?></td>
                        <td><?= htmlspecialchars($c['description']) ?></td>
                        <td><?= $c['created_at'] ?></td>

                        <td>
                            <a class="btn btn-info btn-sm" 
                               href="index.php?controller=admin&action=categoriesEdit&id=<?= $c['id'] ?>">
                               Sửa
                            </a>

                            <a class="btn btn-danger btn-sm"
                               onclick="return confirm('Bạn chắc chắn muốn xoá?')"
                               href="index.php?controller=admin&action=categoriesDelete&id=<?= $c['id'] ?>">
                               Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($categories)): ?>
                        <tr><td colspan="5" class="text-center p-3">Chưa có danh mục</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
