<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "test";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

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

    if ($sql_action != "" && mysqli_query($conn, $sql_action)) {
        echo "<script>alert('$msg'); window.location.href='admin.php?page=khachhang';</script>";
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
}
?>


<!-- =============================
 admin.php - GIAO DIỆN ADMIN
============================= -->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="css.php">
</head>
<body>

<div class="sidebar">
    <h2>ADMIN</h2>
    <a href="admin.php?page=khachhang">Khách hàng</a>
    <a href="admin.php?page=hoadon">Hóa đơn</a>
    <a class="nav-link text-danger" href="logout.php"> Đăng xuất</a>
</div>

<div class="content">

<?php
$page = $_GET['page'] ?? 'dashboard';
// trang khách hàng
if ($page == 'khachhang') {
    echo "<h1>Quản lý khách hàng</h1>";
echo "
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
    </form>";
    $sql = "SELECT * FROM khachhang";
    $rs = mysqli_query($conn, $sql);

    echo "<table><tr><th>User name</th><th>Họ tên</th><th>Trạng Thái</th><th>SĐT</th><th>Địa chỉ nhà</th><th>Quận/Huyện/Phường/Xã</th><th>Thành phố</th><th>Hành động</th></tr>";
 while ($row = mysqli_fetch_assoc($rs)) {
        // Kiểm tra chữ trong cột trangthaitk để hiện nút tương ứng
        $isLocked = ($row['trangthaitk'] == 'Bị khóa');
        
        $btn_lock_logic = $isLocked 
            ? "<a href='?page=khachhang&action=mo&id={$row['username']}' 
                onclick=\"return confirm('Bạn có chắc chắn muốn MỞ KHÓA tài khoản này?')\" 
                class='btn btn-unlock'>Mở khóa</a>"
            : "<a href='?page=khachhang&action=khoa&id={$row['username']}' 
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
                    <a href='?page=khachhang&action=reset&id={$row['username']}' class='btn btn-reset'>Reset MK</a>
                </td>
              </tr>";
    }
    echo "</table>";
}

else if ($page == 'hoadon') {
    echo "<h1>Danh sách hóa đơn</h1>";
    $tu_ngay  = $_GET['tu_ngay'] ?? '';
    $den_ngay = $_GET['den_ngay'] ?? '';


    // 2. Hiển thị Giao diện Bộ lọc
echo "
    <div class='filter-container'>
        <div class='filter-title'>Lọc đơn hàng theo thời gian</div>
        <form method='GET' class='filter-form'>
            <input type='hidden' name='page' value='hoadon'>
            
            <div class='filter-group'>
                <label>Từ ngày (YYYY-MM-DD)</label>
                <input type='text' id='tu_ngay' name='tu_ngay' value='$tu_ngay' 
                       class='filter-input' placeholder='YYYY-MM-DD' 
                       pattern='\d{4}-\d{2}-\d{2}' title='Định dạng: Năm-Tháng-Ngày (VD: 2024-01-01)'>
            </div>

            <div class='filter-group'>
                <label>Đến ngày (YYYY-MM-DD)</label>
                <input type='text' id='den_ngay' name='den_ngay' value='$den_ngay' 
                       class='filter-input' placeholder='YYYY-MM-DD'
                       pattern='\d{4}-\d{2}-\d{2}' title='Định dạng: Năm-Tháng-Ngày (VD: 2024-12-31)'>
            </div>

            <button type='button' onclick='locVoiAPI()' class='btn-filter'>Lọc kết quả</button>
            <a href='admin.php?page=hoadon' class='btn-clear'>Xóa lọc</a>
        </form>
        <div id='ketqua_loc'></div>
    </div>";
    // giao diện lọc tình trạng hóa đơn
    echo " <div class='filter-container'>
<div class='filter-title'>Lọc đơn hàng theo tình trạng đơn hàng</div>
    <div class='filter-form'>
        <div class='filter-group'>
            <label>Tình trạng</label>
            <select id='loc_tinhtrang' class='filter-input'>
                <option value=''>-- Trạng thái --</option>
                <option value='Cho xu ly'>Chờ xử lý</option>
                <option value='Dang giao'>Đang giao</option>
                <option value='Da giao'>Hoàn thành</option>
                <option value='Da huy'>Đã hủy</option>
            </select> </div>
        <div class='filter-group'>
            <label>Sắp xếp theo phường </label>
            <select id='sapxepphuong' class='filter-input'>
                <option value=''>-- Sắp xếp phường --</option>
                <option value='asc'>A → Z</option>
                <option value='desc'>Z → A</option>
            </select></div>

        <button type='button' class='btn-filter' onclick='locDonHang()'>Lọc kết quả</button>
        <a href='admin.php?page=hoadon' class='btn-clear'>Xóa lọc</a>
    </div>

</div>";

    $sql = "SELECT * FROM hoadon";
    $rs = mysqli_query($conn, $sql);

    echo "<table id='main-table'><tr><th>Tên tài khoản</th><th>Mã hóa đơn</th><th>Ngày đặt</th><th>Phương thức thanh toán</th><th>Trạng thái</th><th>Số nhà giao hàng</th><th>Phường giao hàng</th><th>Thành phố giao hàng</th><th>Hành động</th></tr>";
   

    while ($row = mysqli_fetch_assoc($rs)) {
        echo "<tr>
                <td>{$row['username']}</td>
                <td>{$row['mahd']}</td>
                <td>{$row['ngaydat']}</td>
                <td>{$row['phuongthucthanhtoan']}</td>
                <td>{$row['trangthai']}</td>
                <td>{$row['diachihd']}</td>
                <td>{$row['phuonghd']}</td>
                <td>{$row['thanhphohd']}</td>
                <td><button type='button' class='btn btn-reset' onclick=\"showDetails('{$row['mahd']}')\">Xem chi tiết</button></td>
              </tr>";
    }
    echo "</table>";
}

else {
    echo "<h1>Dashboard</h1>";
    echo "<p>Chào mừng Admin 👑</p>";
}

?>

</div>
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
// xem chi tiết hóa đơn
function showDetails(mahd) {
    var modal = document.getElementById("myModal");
    var modalBody = document.getElementById("modal-body");
    
    modal.style.display = "block";
    modalBody.innerHTML = "Đang tải...";

    // Dùng Fetch API (giống Ajax) để lấy dữ liệu từ file get_chitiet.php
    fetch('chitiethd.php?mahd=' + mahd)
        .then(response => response.text())
        .then(data => {
            modalBody.innerHTML = data;
        })
        .catch(error => {
            modalBody.innerHTML = "Lỗi khi tải dữ liệu!";
            console.error(error);
        });
}

function closeModal() {
    document.getElementById("myModal").style.display = "none";
}

// Đóng popup khi click ra ngoài vùng trắng
window.onclick = function(event) {
    var modal = document.getElementById("myModal");
    if (event.target == modal) {
        closeModal();
    }
}
// lọc hóa đơn theo ngày đặt
function locVoiAPI() {
    const tu = document.getElementById('tu_ngay').value;
    const den = document.getElementById('den_ngay').value;

    let url = 'locngay.php?';
    if (tu)  url += 'tu_ngay=' + encodeURIComponent(tu) + '&';
    if (den) url += 'den_ngay=' + encodeURIComponent(den);

    fetch(url)
        .then(res => res.json())
        .then(data => renderTable(data)) // Gọi hàm vẽ lại bảng
        .catch(err => alert("Lỗi tải dữ liệu!"));
    
}
// render lại thông tin sau khi lọc và chỉ xuất hiện 1 bảng mà thôi
function renderTable(data) {
    const table = document.getElementById('main-table');
    
    // Tạo lại tiêu đề bảng (Header)
    let html = `
        <tr>
            <th>Tên tài khoản</th><th>Mã hóa đơn</th><th>Ngày đặt</th>
            <th>Phương thức thanh toán</th><th>Trạng thái</th>
            <th>Số nhà giao hàng</th><th>Phường giao hàng</th>
            <th>Thành phố giao hàng</th><th>Hành động</th>
        </tr>`;

    if (data.length === 0) {
        html += `<tr><td colspan="9" align="center">Không tìm thấy dữ liệu phù hợp</td></tr>`;
    } else {
        // Đổ dữ liệu mới vào
        data.forEach(row => {
            html += `
                <tr>
                    <td>${row.username}</td>
                    <td>${row.mahd}</td>
                    <td>${row.ngaydat}</td>
                    <td>${row.phuongthucthanhtoan}</td>
                    <td>${row.trangthai}</td>
                    <td>${row.diachihd}</td>
                    <td>${row.phuonghd}</td>
                    <td>${row.thanhphohd}</td>
                    <td><button type='button' class='btn btn-reset' onclick="showDetails('${row.mahd}')">Xem chi tiết</button></td>
                </tr>`;
        });
    }
    
    // Ghi đè toàn bộ nội dung bảng cũ bằng nội dung mới đã lọc
    table.innerHTML = html;
}
// lọc hóa đơn theo tình trạng hóa đơn
function locDonHang() {
    const trangthai = document.getElementById('loc_tinhtrang').value;
    const order = document.getElementById('sapxepphuong').value;

    let url = 'loctinhtrang.php?';
    if (trangthai) url += 'trangthai=' + encodeURIComponent(trangthai) + '&';
    if (order) url += 'order=' + order;

    fetch(url)
        .then(res => res.json())
        .then(data => renderTable(data)) // Gọi hàm vẽ lại bảng
        .catch(err => alert("Lỗi tải dữ liệu!"));
}

</script>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div id="modal-body">
            <p>Đang tải dữ liệu...</p>
        </div>
    </div>
</div>
</body>
</html>
