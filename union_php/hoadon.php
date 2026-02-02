<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

require_once 'db.php';

    echo "<h1>Quản lý hóa đơn</h1>";
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


?>

</div>
<script>
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