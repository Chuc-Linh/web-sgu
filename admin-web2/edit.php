<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require_once 'db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: product.php");
    exit;
}

$sp = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM sanpham WHERE masp = $id")
);

if (!$sp) {
    header("Location: product.php");
    exit;
}

$loai = mysqli_query($conn, "SELECT * FROM loai");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE sanpham SET
        tensp='{$_POST['tensp']}',
        hientrang='{$_POST['hientrang']}',
        donvitinh='{$_POST['donvitinh']}',
        giabandexuat={$_POST['giabandexuat']},
        phantramloinhuanmongmuon={$_POST['phantramloinhuanmongmuon']},
        maloai='{$_POST['maloai']}'
        WHERE masp=$id";

    mysqli_query($conn, $sql);
    header("Location: admin.php?page=product");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa sản phẩm</title>

<style>
* {
    box-sizing: border-box;
    font-family: system-ui, -apple-system, BlinkMacSystemFont;
}

body {
    background: #f2f4f7;
    margin: 0;
    padding: 0;
}

/* ===== LAYOUT ===== */
.container {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 16px;
}

/* ===== CARD ===== */
.card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.card-header {
    padding: 16px 20px;
    background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    color: #fff;
}

.card-header h2 {
    margin: 0;
    font-size: 20px;
}

.card-body {
    padding: 24px;
}

/* ===== FORM ===== */
.form-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full {
    grid-column: span 3;
}

label {
    font-weight: 600;
    margin-bottom: 6px;
}

input, select {
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}

input:focus, select:focus {
    outline: none;
    border-color: #0d6efd;
    box-shadow: 0 0 0 2px rgba(13,110,253,0.15);
}

/* ===== ACTIONS ===== */
.actions {
    margin-top: 24px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn {
    padding: 10px 22px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
}

.btn-primary {
    background: #0d6efd;
    color: #fff;
}

.btn-primary:hover {
    background: #0b5ed7;
}

.btn-secondary {
    background: #6c757d;
    color: #fff;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-secondary:hover {
    background: #5a6268;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    .form-group.full {
        grid-column: span 1;
    }
}
</style>
</head>

<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2> Sửa sản phẩm</h2>
        </div>

        <div class="card-body">
            <form method="post" onsubmit="return validateSanPham()">

                <div class="form-grid">
                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="tensp"
                               value="<?= htmlspecialchars($sp['tensp']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Hiện trạng</label>
                        <input type="text" name="hientrang"
                               value="<?= htmlspecialchars($sp['hientrang']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Đơn vị tính</label>
                        <input type="text" name="donvitinh"
                               value="<?= htmlspecialchars($sp['donvitinh']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Giá bán</label>
                        <input type="number" name="giabandexuat" min="1"
                               value="<?= $sp['giabandexuat'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label>% Lợi nhuận</label>
                        <input type="number" step="0.1"
                               name="phantramloinhuanmongmuon" min="0.1"
                               value="<?= $sp['phantramloinhuanmongmuon'] ?>" required>
                    </div>

                    <div class="form-group full">
                        <label>Loại sản phẩm</label>
                        <select name="maloai" required>
                            <?php while ($l = mysqli_fetch_assoc($loai)): ?>
                                <option value="<?= $l['maloai'] ?>"
                                    <?= $l['maloai'] == $sp['maloai'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($l['tenloai']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="actions">
                    <a href="admin.php?page=product" class="btn btn-secondary">Quay lại</a>
                    <button class="btn btn-primary">Cập nhật</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function validateSanPham() {
    let tensp = document.querySelector('[name="tensp"]').value.trim();
    let hientrang = document.querySelector('[name="hientrang"]').value.trim();
    let donvitinh = document.querySelector('[name="donvitinh"]').value.trim();
    let giabandexuat = document.querySelector('[name="giabandexuat"]').value;
    let phantram = document.querySelector('[name="phantramloinhuanmongmuon"]').value;

    if (tensp.length < 3) {
        alert("Tên sản phẩm phải có ít nhất 3 ký tự");
        return false;
    }
    if (hientrang === "" || donvitinh === "") {
        alert("Vui lòng nhập đầy đủ thông tin");
        return false;
    }
    if (giabandexuat <= 0 || phantram <= 0) {
        alert("Giá và % lợi nhuận phải lớn hơn 0");
        return false;
    }
    return true;
}
</script>

</body>
</html>
