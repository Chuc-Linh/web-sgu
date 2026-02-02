<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require_once 'db.php';
$loai = mysqli_query($conn, "SELECT * FROM loai");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tensp  = $_POST['tensp'];
    $hientrang = $_POST['hientrang'];
    $donvitinh = $_POST['donvitinh'];
    $gia = $_POST['giabandexuat'];
    $phantram = $_POST['phantramloinhuanmongmuon'];
    $maloai = $_POST['maloai'];

    $sql = "INSERT INTO sanpham 
        (tensp, hientrang, donvitinh, giabandexuat, phantramloinhuanmongmuon, maloai)
        VALUES (
            '$tensp',
            '$hientrang',
            '$donvitinh',
            $gia,
            $phantram,
            '$maloai'
        )";

    if (!mysqli_query($conn, $sql)) {
        die("LỖI INSERT: " . mysqli_error($conn));
    }

    header("Location: admin.php?page=product");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm sản phẩm</title>

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

/* ===== WRAPPER ===== */
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
    background: linear-gradient(135deg, #1e7e34, #28a745);
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
    border-color: #28a745;
    box-shadow: 0 0 0 2px rgba(40,167,69,0.15);
}

/* ===== BUTTON ===== */
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

.btn-success {
    background: #28a745;
    color: #fff;
}

.btn-success:hover {
    background: #218838;
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
            <h2> Thêm sản phẩm mới</h2>
        </div>

        <div class="card-body">
            <form method="post" onsubmit="return validateSanPham()">

                <div class="form-grid">
                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="tensp" required>
                    </div>

                    <div class="form-group">
                        <label>Hiện trạng</label>
                        <select name="hientrang" required>
                            <option value=""> Chọn hiện trạng</option>
                            <option value="Hiển Thị">Hiển Thị</option>
                            <option value="Ẩn">Ẩn</option>
                        </select>
                    </div>

                   <div class="form-group">
                       <label>Đơn vị tính</label>
                       <select name="donvitinh" required>
                            <option value=""> Chọn đơn vị </option>
                            <option value="Chiếc">Chiếc</option>
                            <option value="Đôi">Đôi</option>
                         </select>
                    </div>

                    <div class="form-group">
                        <label>Giá bán</label>
                        <input type="number" name="giabandexuat" min="1" required>
                    </div>

                    <div class="form-group">
                        <label>% Lợi nhuận</label>
                        <input type="number" step="0.1" name="phantramloinhuanmongmuon" min="0.1" required>
                    </div>

                    <div class="form-group full">
                        <label>Loại sản phẩm</label>
                        <select name="maloai" required>
                            <?php while ($l = mysqli_fetch_assoc($loai)): ?>
                                <option value="<?= $l['maloai'] ?>">
                                    <?= $l['tenloai'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="actions">
                    <a href="admin.php?page=product" class="btn btn-secondary">Quay lại</a>
                    <button class="btn btn-success">Lưu sản phẩm</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function validateSanPham() {
    let tensp = document.querySelector('[name="tensp"]').value.trim();
    let giabandexuat = document.querySelector('[name="giabandexuat"]').value;
    let phantram = document.querySelector('[name="phantramloinhuanmongmuon"]').value;

    if (tensp.length < 3) {
        alert("Tên sản phẩm phải có ít nhất 3 ký tự");
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







