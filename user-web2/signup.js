const Cityselect= document.getElementById("City");
const Districtselect= document.getElementById("District");

fetch("https://provinces.open-api.vn/api/?depth=2")
    .then(response => response.json())
    .then(data => {
        data.forEach(city => {
            let option= new Option(city.name, city.code);
            Cityselect.add(option);
        });


        Cityselect.addEventListener('change', function() {
            Districtselect.innerHTML= '  <option value="" selected> Chọn quận huyện</option>';

            if(this.value !==""){
                const selectedCity= data.find(c=> c.code== this.value);
                selectedCity.districts.forEach(district => {
                    let option= new Option(district.name, district.code);
                    Districtselect.add(option);
                });
            }
        });
    })
    .catch(error => console.error('Lỗi tải dữ liệu:', error));

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".My_form");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Chặn chuyển trang để xử lý lưu dữ liệu

        let username = form.username.value.trim();
        let phone = form.phone.value.trim();
        let address = form.address.value.trim();
        let cityText = form.city.options[form.city.selectedIndex].text; // Lấy tên tỉnh
        let districtText = form.district.options[form.district.selectedIndex].text; // Lấy tên huyện
        let password = form.password.value;
        let repassword = form["re-password"].value;

        // --- Bắt đầu Validation (Giữ nguyên các logic check của bạn) ---
        if (username.length < 5) { alert("❌ Tên đăng nhập quá ngắn"); return; }
        if (!/^[0-9]{10}$/.test(phone)) { alert("❌ SĐT không hợp lệ"); return; }
        if (password.length < 6) { alert("❌ Mật khẩu quá ngắn"); return; }
        if (password !== repassword) { alert("❌ Mật khẩu không khớp"); return; }
        // --- Kết thúc Validation ---

        // Lấy danh sách user cũ hoặc tạo mảng mới nếu chưa có
        let users = JSON.parse(localStorage.getItem('users')) || [];

        // Kiểm tra xem tên đăng nhập đã tồn tại chưa
        if (users.some(u => u.username === username)) {
            alert("❌ Tên đăng nhập đã tồn tại!");
            return;
        }

        // Tạo đối tượng user mới
        const newUser = {
            username: username,
            password: password,
            phone: phone,
            address: `${address}, ${districtText}, ${cityText}`,
            email: "" // Mặc định trống vì form đăng ký không có email
        };

        // Lưu vào mảng và đẩy lên localStorage
        users.push(newUser);
        localStorage.setItem('users', JSON.stringify(users));

        alert("✅ Đăng ký thành công! Bạn sẽ được chuyển đến trang đăng nhập.");
        window.location.href = "login.html";
    });
});
    


    
