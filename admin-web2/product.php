<?php


// kiểm tra đăng nhập admin
if (!isset($_SESSION['admin'])) {
    header("Location:login.php");
    exit;
}

// lấy dữ liệu sản phẩm + tên loại
$sql = "SELECT sp.*, l.tenloai 
        FROM sanpham sp
        LEFT JOIN loai l ON sp.maloai = l.maloai";

$result = mysqli_query($conn, $sql);
?>

<h1 class="mb-4">Quản lý sản phẩm</h1>

<a href="add.php" class="btn btn-success mb-3">
    [+] Thêm sản phẩm
</a>

<table class="table table-bordered table-hover align-middle">
    <thead class="table-dark text-center">
        <tr>
            <th>Mã SP</th>
            <th>Tên sản phẩm</th>
            <th>Hiện trạng</th>
            <th>Đơn vị</th>
            <th>Giá bán</th>
            <th>% Lợi nhuận</th>
            <th>Loại</th>
            <th width="130">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td class="text-center"><?= $row['masp'] ?></td>
                    <td><?= htmlspecialchars($row['tensp']) ?></td>
                    <td class="text-center">
                        <?php if ($row['hientrang'] == 'Hiển Thị'): ?>
                            <span class="badge bg-success">Hiển thị</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Ẩn</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><?= htmlspecialchars($row['donvitinh']) ?></td>
                    <td class="text-end"><?= number_format($row['giabandexuat']) ?> đ</td>
                    <td class="text-center"><?= $row['phantramloinhuanmongmuon'] ?>%</td>
                    <td><?= htmlspecialchars($row['tenloai']) ?></td>
                    <td class="text-center">
                        <a href="edit.php?id=<?= $row['masp'] ?>" 
                           class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil"></i>
                        Sửa</a>
                        <a href="delete.php?id=<?= $row['masp'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                            <i class="bi bi-trash"></i>Xóa
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">Chưa có dữ liệu</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>






