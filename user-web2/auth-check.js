document.addEventListener('DOMContentLoaded', () => {
    const authLinks = document.getElementById('authLinks');
    const userRaw = localStorage.getItem('currentUser');

    if (userRaw) {
        const user = JSON.parse(userRaw);
        if (user.isLoggedIn) {
            // Nếu đã đăng nhập: Hiện "Quản lý tài khoản" và "Đăng xuất"
            authLinks.innerHTML = `
                <li><a href="account.html">Tài khoản</a></li>
            `;

            // Xử lý sự kiện đăng xuất
            document.getElementById('btnLogout').addEventListener('click', (e) => {
                e.preventDefault();
                localStorage.removeItem('currentUser'); // Xóa trạng thái
                alert("Đã đăng xuất!");
                window.location.reload(); // Load lại trang để cập nhật giao diện
            });
        }
    } else {
        // Nếu chưa đăng nhập: Hiện Đăng nhập/Đăng ký (Mặc định)
        authLinks.innerHTML = `
            <li><a href="login.html">Đăng Nhập</a></li>
            <li><a href="signup.html">Đăng Ký</a></li>
        `;
    }
});