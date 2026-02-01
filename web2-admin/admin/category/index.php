<?php
session_start();

// kiểm tra đăng nhập admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../../login.php");
    exit;
}

// include header + db
require_once __DIR__ . "/../inc/header.php";
require_once __DIR__ . "/../../config/db.php";

// lấy dữ liệu bảng loai
$sql = "SELECT * FROM loai";
$result = mysqli_query($conn, $sql);
?>

<h3 class="mb-4">Quản lý loại sản phẩm</h3>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Mã loại</th>
            <th>Tên loại</th>
            <th>Mô tả</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['maloai']) ?></td>
                    <td><?= htmlspecialchars($row['tenloai']) ?></td>
                    <td><?= htmlspecialchars($row['mota']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">Chưa có dữ liệu</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . "/../inc/footer.php"; ?>






