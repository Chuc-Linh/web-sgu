document.getElementById('btnLogin').addEventListener('click', () => {
    const userVal = document.getElementById('username').value;
    const passVal = document.getElementById('password').value;

    // Lấy danh sách người dùng từ localStorage
    const users = JSON.parse(localStorage.getItem('users')) || [];

    // Tìm user khớp cả tên và pass
    const foundUser = users.find(u => u.username === userVal && u.password === passVal);

    if (foundUser) {
        // Lưu thông tin phiên đăng nhập hiện tại
        const sessionData = {
            username: foundUser.username,
            isLoggedIn: true
        };
        localStorage.setItem('currentUser', JSON.stringify(sessionData));

        // Cập nhật thông tin Profile để trang account.html hiển thị đúng
        const profileData = {
            name: foundUser.username,
            email: foundUser.email || "Chưa cập nhật",
            phone: foundUser.phone,
            address: foundUser.address
        };
        localStorage.setItem('userProfile', JSON.stringify(profileData));

        alert("Đăng nhập thành công!");
        window.location.href = "test11.html";
    } else {
        alert("Thông tin đăng nhập không đúng!");
    }
});