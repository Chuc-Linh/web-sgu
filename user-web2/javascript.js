
// chỉnh ngày sinh
// Đưa các biến này ra ngoài để mọi hàm đều dùng được
const daySelect = document.getElementById('dob-day');
const monthSelect = document.getElementById('dob-month');
const yearSelect = document.getElementById('dob-year');

function khoiTaoNgaySinh() {
    if (!daySelect || !monthSelect || !yearSelect) return;

    // Đổ dữ liệu Tháng
    let months = '<option value="">Tháng</option>';
    for (let i = 1; i <= 12; i++) {
        months += `<option value="${i}">Tháng ${i}</option>`;
    }
    monthSelect.innerHTML = months;

    // Đổ dữ liệu Năm
    const currentYear = new Date().getFullYear();
    let years = '<option value="">Năm</option>';
    for (let i = currentYear; i >= 1960; i--) {
        years += `<option value="${i}">${i}</option>`;
    }
    yearSelect.innerHTML = years;

    // Gọi hàm updateDays lần đầu để hiện đủ 31 ngày
    updateDays();
}

function updateDays() {
    const month = parseInt(monthSelect.value);
    const year = parseInt(yearSelect.value);
    
    // Tính số ngày trong tháng (Mặc định 31 nếu chưa chọn tháng)
    let daysInMonth = 31;
    if (month) {
        daysInMonth = new Date(year || 2024, month, 0).getDate();
    }

    const currentSelectedDay = daySelect.value; // Giữ lại ngày khách đã chọn
    let days = '<option value="">Ngày</option>';
    for (let i = 1; i <= daysInMonth; i++) {
        days += `<option value="${i}">${i}</option>`;
    }
    daySelect.innerHTML = days;
    daySelect.value = currentSelectedDay; // Trả lại ngày đã chọn nếu nó vẫn hợp lệ
}

// Lắng nghe sự kiện
monthSelect.addEventListener('change', updateDays);
yearSelect.addEventListener('change', updateDays);

// Xử lý khi nhấn nút Đăng ký
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Ngăn trang web tải lại

    const mk1 = document.getElementById('matkhau').value;
    const mk2 = document.getElementById('matkhau2').value;

    if (mk1 !== mk2) {
        alert("Mật khẩu nhập lại không khớp!");
        return;
    }

    alert("Đăng ký thành công! Chào mừng " + document.getElementById('name').value);
    console.log("Dữ liệu ngày sinh:", `${daySelect.value}/${monthSelect.value}/${yearSelect.value}`);
});

// Chạy khởi tạo
khoiTaoNgaySinh();