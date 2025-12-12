

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Danh mục khóa học</h3>
    <a href="index.php?controller=admin&action=createCategory" class="btn btn-success">
        <i class="fa-solid fa-plus me-1"></i>Thêm danh mục
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Mô tả</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <!-- <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['id'] ?></td>
                <td><?= htmlspecialchars($cat['name']) ?></td>
                <td class="small"><?= htmlspecialchars($cat['description']) ?></td>
                <td class="text-end">
                    <a href="index.php?controller=admin&action=editCategory&id=<?= $cat['id'] ?>"
                       class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                    <a href="index.php?controller=admin&action=deleteCategory&id=<?= $cat['id'] ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Xóa danh mục này?')"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?> -->
        </tbody>
    </table>
</div>

</section></div></div>
