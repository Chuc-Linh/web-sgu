<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../../login.php");
    exit;
}

require_once __DIR__ . "/../inc/header.php";
require_once __DIR__ . "/../../config/db.php";

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
        die(" LỖI INSERT: " . mysqli_error($conn));
    }

    // quay về trang danh sách
    header("Location: index.php");
    exit;
}


?>

<h3 class="mb-4">Thêm sản phẩm</h3>

<form method="post" onsubmit="return validateSanPham()" class="card p-4 shadow-sm">
    <div class="mb-3">
        <label class="form-label">Tên sản phẩm</label>
        <input type="text" name="tensp" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Hiện trạng</label>
        <input type="text" name="hientrang" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Đơn vị tính</label>
        <input type="text" name="donvitinh" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Giá bán</label>
        <input type="number" name="giabandexuat" class="form-control" min="1" required>
    </div>

    <div class="mb-3">
        <label class="form-label">% Lợi nhuận</label>
        <input type="number" step="0.1" name="phantramloinhuanmongmuon" class="form-control" min="0.1" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Loại sản phẩm</label>
        <select name="maloai" class="form-select" required>
            <?php while ($l = mysqli_fetch_assoc($loai)): ?>
                <option value="<?= $l['maloai'] ?>"><?= $l['tenloai'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <button class="btn btn-success">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Quay lại</a>
</form>

<!-- ===== JS RÀNG BUỘC ===== -->
<script>
function validateSanPham() {
    let tensp = document.querySelector('[name="tensp"]').value.trim();
    let hientrang = document.querySelector('[name="hientrang"]').value.trim();
    let donvitinh = document.querySelector('[name="donvitinh"]').value.trim();
    let giabandexuat = document.querySelector('[name="giabandexuat"]').value;
    let phantram = document.querySelector('[name="phantramloinhuanmongmuon"]').value;

    if (tensp.length < 3) {
        alert(" Tên sản phẩm phải có ít nhất 3 ký tự");
        return false;
    }

    if (hientrang === "") {
        alert(" Vui lòng nhập hiện trạng sản phẩm");
        return false;
    }

    if (donvitinh === "") {
        alert(" Vui lòng nhập đơn vị tính");
        return false;
    }

    if (giabandexuat <= 0) {
        alert(" Giá bán phải lớn hơn 0");
        return false;
    }

    if (phantram <= 0) {
        alert(" % lợi nhuận phải lớn hơn 0");
        return false;
    }

    return true;
}
</script>

<?php require_once __DIR__ . "/../inc/footer.php"; ?>






