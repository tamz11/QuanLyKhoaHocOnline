<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Danh mục khóa học</h3>
    <a href="index.php?controller=admin&action=categoriesCreate" class="btn btn-success">
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

        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td class="small"><?= htmlspecialchars($cat['description']) ?></td>

                    <td class="text-end">
                        <a href="index.php?controller=admin&action=categoriesEdit&id=<?= $cat['id'] ?>"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <button class="btn btn-sm btn-outline-danger"
                                onclick="deleteCategory(<?= $cat['id'] ?>)">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>

            <tr>
                <td colspan="4" class="text-center text-muted py-3">
                    Chưa có danh mục nào.
                </td>
            </tr>

        <?php endif; ?>

        </tbody>
    </table>
</div>


<!-- =============================== -->
<!-- ⭐ SWEETALERT2 DELETE POPUP JS ⭐ -->
<!-- =============================== -->
<script>
function deleteCategory(id) {
    Swal.fire({
        title: "Bạn có chắc chắn?",
        text: "Danh mục sẽ bị xoá vĩnh viễn!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xoá",
        cancelButtonText: "Hủy"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href =
                "index.php?controller=admin&action=categoriesDelete&id=" + id;
        }
    });
}
</script>

</section></div></div>
