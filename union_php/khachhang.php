<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

require_once 'db.php';
// --- XỬ LÝ LOGIC (QUAN TRỌNG: Đặt trước khi hiển thị HTML) ---
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $action = $_GET['action'];
    $sql_action = "";
    $msg = "";

    if ($action == 'khoa') {
        $sql_action = "UPDATE khachhang SET trangthaitk = 'Bị khóa' WHERE username = '$id'";
        $msg = "Đã khóa tài khoản thành công!";
    } elseif ($action == 'mo') {
        $sql_action = "UPDATE khachhang SET trangthaitk = 'Hoạt động' WHERE username = '$id'";
        $msg = "Đã mở khóa tài khoản thành công!";
    } elseif ($action == 'reset') {

    $matkhau_macdinh = "123456";

    // mã hóa mật khẩu
    $matkhau_mahoa = password_hash($matkhau_macdinh, PASSWORD_DEFAULT);

    $sql_action = "UPDATE khachhang 
                   SET matkhau = '$matkhau_mahoa' 
                   WHERE username = '$id'";

    $msg = "Mật khẩu đã được reset về mặc định (123456)";
}

}

// Xử lý thêm mới
if (isset($_POST['btn_them'])) {
    $matkhau_macdinh = "123456";
    $matkhau_mahoa = password_hash($matkhau_macdinh, PASSWORD_DEFAULT);
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $ht = mysqli_real_escape_string($conn, $_POST['hoten']);
    $s = mysqli_real_escape_string($conn, $_POST['sdt']);
    $dc = mysqli_real_escape_string($conn, $_POST['diachinha']);
    $p = mysqli_real_escape_string($conn, $_POST['phuong']);
    $tp = mysqli_real_escape_string($conn, $_POST['thanhpho']);
    
    $sql_add = "INSERT INTO khachhang VALUES ('$u', '$ht', 'Hoạt động', '$s', '$dc', '$p', '$tp', '$matkhau_mahoa')";
    if (mysqli_query($conn, $sql_add)) {
        echo "<script>alert('Thêm thành công! MK mặc định là 123456'); window.location.href='admin.php?page=khachhang';</script>";
    } else {
        echo "<script>alert('Lỗi: Username hoặc SĐT đã tồn tại!');</script>";
    }
}?>



<h1>Quản lý khách hàng</h1>
    <form class='form-row' method='POST' onsubmit=\"return confirm('Bạn có chắc chắn muốn thêm khách hàng mới này không?')\">
        <div class='input-group'>
            <label>Username</label>
            <input type='text' name='username' placeholder='Username' required style='padding:5px'>
        </div>

        <div class='input-group'>
            <label>Họ tên</label>
            <input type='text' name='hoten' placeholder='Họ tên' required style='padding:5px'>
        </div>

        <div class='input-group'>
            <label>Số điện thoại</label>
            <input type='text' name='sdt' placeholder='Số điện thoại' required style='padding:5px'>
        </div>
        <div class='input-group'>
            <label>Địa chỉ</label>
            <input type='text' name='diachinha' placeholder='Địa chỉ' required style='padding:5px'>
        </div>
        <div class='input-group'>
            <label>Tỉnh thành</label>
            <select id='thanhpho' name='thanhpho' required style='padding:5px'>
                <option value=''>Chọn tỉnh thành</option>
            </select>
        </div>

        <div class='input-group'>
            <label>Quận/Huyện/Phường/Xã</label>
            <select id='phuong' name='phuong' required style='padding:5px'>
                <option value=''>Chọn quận/huyện/phường/xã</option>
            </select>
        </div>

        <button type='submit' name='btn_them' class='btn btn-them'>Thêm</button>
    </form>
    <?php
    $sql = "SELECT * FROM khachhang";
    $rs = mysqli_query($conn, $sql);
    ?>
    <?php
    echo "<table><tr><th>User name</th><th>Họ tên</th><th>Trạng Thái</th><th>SĐT</th><th>Địa chỉ nhà</th><th>Quận/Huyện/Phường/Xã</th><th>Thành phố</th><th>Hành động</th></tr>";
 while ($row = mysqli_fetch_assoc($rs)) {
        // Kiểm tra chữ trong cột trangthaitk để hiện nút tương ứng
        $isLocked = ($row['trangthaitk'] == 'Bị khóa');
        
        $btn_lock_logic = $isLocked
        ? "<a href='admin.php?page=khachhang&action=mo&id={$row['username']}'
            onclick=\"return confirm('Bạn có chắc chắn muốn MỞ KHÓA tài khoản này?')\"
            class='btn btn-unlock'>Mở khóa</a>"
        : "<a href='admin.php?page=khachhang&action=khoa&id={$row['username']}'
            onclick=\"return confirm('Bạn có chắc chắn muốn KHÓA tài khoản này?')\"
            class='btn btn-lock'>Khóa</a>";

        echo "<tr>
                <td>{$row['username']}</td>
                <td>{$row['hoten']}</td>
                <td>{$row['trangthaitk']}</td>
                <td>{$row['SDT']}</td>
                <td>{$row['diachinha']}</td>
                <td> {$row['phuong']}</td>
                <td> {$row['thanhpho']}</td>
                <td>
                    $btn_lock_logic
                    <a href='admin.php?page=khachhang&action=reset&id={$row['username']}' onclick=\"return confirm('Bạn có chắc chắn muốn RESET mật khẩu?')\" class='btn btn-reset'>Reset MK</a>
                </td>
              </tr>";
    }
    echo "</table>";

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>

    // dropdown thành phố. tỉnh thành
    var citis = document.getElementById("thanhpho");
    var districts = document.getElementById("phuong");

    axios.get("https://provinces.open-api.vn/api/?depth=2")
        .then(function (result) {
            renderCity(result.data);
        });

    function renderCity(data) {
        for (const x of data) {
            citis.options[citis.options.length] =
                new Option(x.name, x.name);
        }

        citis.onchange = function () {
            districts.length = 1;

            if (this.value !== "") {
                const result = data.filter(n => n.name === this.value);

                for (const k of result[0].districts) {
                    districts.options[districts.options.length] =
                        new Option(k.name, k.name);
                }
            }
        };
    }
</script>

