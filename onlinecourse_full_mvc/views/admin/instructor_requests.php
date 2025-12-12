<div class="container py-4">
  <h4>Danh sách yêu cầu trở thành Giảng viên</h4>
  <div class="card mt-3">
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Email</th>
            <th>Mô tả</th>
            <th>Trạng thái</th>
            <th>Ngày gửi</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>

          <?php if (empty($requests)): ?>
            <tr><td colspan="7" class="text-center p-3">Chưa có yêu cầu</td></tr>
          <?php else: ?>

            <?php foreach ($requests as $r): ?>
              <tr>
                <td><?= htmlspecialchars($r['id']) ?></td>

                <td>
                  <?= htmlspecialchars($r['username']) ?><br>
                  <small><?= htmlspecialchars($r['fullname']) ?></small>
                </td>

                <td><?= htmlspecialchars($r['email']) ?></td>

                <td style="max-width:300px;">
                  <?= nl2br(htmlspecialchars($r['message'])) ?>
                </td>

                <td><?= htmlspecialchars($r['status']) ?></td>

                <td><?= htmlspecialchars($r['created_at']) ?></td>

                <td>
                  <?php if ($r['status'] === 'pending'): ?>

                    <a class="btn btn-sm btn-success"
                       href="index.php?controller=admin&action=handleInstructorRequest&id=<?= $r['id'] ?>&status=approved">
                       Duyệt
                    </a>

                    <a class="btn btn-sm btn-danger"
                       href="index.php?controller=admin&action=handleInstructorRequest&id=<?= $r['id'] ?>&status=rejected">
                       Từ chối
                    </a>

                  <?php else: ?>
                    <span class="text-muted">
                      Đã <?= htmlspecialchars($r['status']) ?>
                    </span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>

          <?php endif; ?>

        </tbody>
      </table>
    </div>
  </div>
</div>
