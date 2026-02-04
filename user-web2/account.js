
    const accountBox = document.getElementById('accountBox');
    
    // Hàm chuyển đổi giữa chế độ xem và sửa
    function toggleEdit(isEditing) {
        if (isEditing) {
            accountBox.classList.add('edit-mode');
            document.getElementById('btnEdit').style.display = 'none';
            document.getElementById('btnSave').style.display = 'block';
            document.getElementById('btnCancel').style.display = 'block';
        } else {
            accountBox.classList.remove('edit-mode');
            document.getElementById('btnEdit').style.display = 'block';
            document.getElementById('btnSave').style.display = 'none';
            document.getElementById('btnCancel').style.display = 'none';
        }
    }

    // Hàm lưu thông tin
    function saveProfile() {
        // Lấy giá trị từ input
        const newName = document.getElementById('edit-name').value;
        const newEmail = document.getElementById('edit-email').value;
        const newPhone = document.getElementById('edit-phone').value;

        // Cập nhật lại phần hiển thị văn bản
        document.getElementById('text-name').innerText = newName;
        document.getElementById('text-email').innerText = newEmail;
        document.getElementById('text-phone').innerText = newPhone;

        // Giả lập lưu vào LocalStorage (để khi load lại trang vẫn còn)
        const userData = { name: newName, email: newEmail, phone: newPhone };
        localStorage.setItem('userProfile', JSON.stringify(userData));

        alert('Cập nhật thông tin thành công!');
        toggleEdit(false);
    }

    // Hàm lưu thông tin
function saveProfile() {
    // Lấy giá trị từ các ô input
    const newName = document.getElementById('edit-name').value;
    const newEmail = document.getElementById('edit-email').value;
    const newPhone = document.getElementById('edit-phone').value;
    const newAddress = document.getElementById('edit-address').value; // Lấy địa chỉ mới

    // Cập nhật lại phần hiển thị văn bản (thẻ p)
    document.getElementById('text-name').innerText = newName;
    document.getElementById('text-email').innerText = newEmail;
    document.getElementById('text-phone').innerText = newPhone;
    document.getElementById('text-address').innerText = newAddress || "Chưa cập nhật địa chỉ";

    // Lưu dữ liệu vào LocalStorage để không bị mất khi load lại trang
    const userData = { 
        name: newName, 
        email: newEmail, 
        phone: newPhone,
        address: newAddress 
    };
    localStorage.setItem('userProfile', JSON.stringify(userData));

    alert('Cập nhật thông tin thành công!');
    toggleEdit(false); // Quay lại chế độ xem
}

// Hàm bổ sung: Tự động điền dữ liệu khi load trang
document.addEventListener('DOMContentLoaded', () => {
    const savedData = localStorage.getItem('userProfile');
    if (savedData) {
        const user = JSON.parse(savedData);
        // Điền vào thẻ P
        document.getElementById('text-name').innerText = user.name;
        document.getElementById('text-email').innerText = user.email;
        document.getElementById('text-phone').innerText = user.phone;
        document.getElementById('text-address').innerText = user.address || "Chưa cập nhật địa chỉ";
        
        // Điền sẵn vào ô Input
        document.getElementById('edit-name').value = user.name;
        document.getElementById('edit-email').value = user.email;
        document.getElementById('edit-phone').value = user.phone;
        document.getElementById('edit-address').value = user.address || "";
    }
});

    function logout() {
    if (confirm("Bạn có chắc chắn muốn đăng xuất không?")) {
        localStorage.removeItem('currentUser');
        window.location.href = "test11.html";
    }
}


// Gọi hàm này trong DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    // ... code cũ ...
    displayOrderHistory();
});

// Hàm chuyển đổi Tab
function showTab(tabName) {
    // Ẩn tất cả nội dung tab
    document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
    // Bỏ class active ở menu
    document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));

    // Hiển thị tab được chọn
    document.getElementById(tabName + '-tab').style.display = 'block';
    // Thêm class active cho menu tương ứng
    event.currentTarget.classList.add('active');

    if (tabName === 'history') {
        displayOrderHistory();
    }
}

// Hàm hiển thị lịch sử mua hàng chi tiết
function displayOrderHistory() {
    const orderList = document.getElementById('orderList');
    const orders = JSON.parse(localStorage.getItem('orderHistory')) || [];

    if (orders.length === 0) {
        orderList.innerHTML = "<p>Bạn chưa có đơn hàng nào.</p>";
        return;
    }

    orderList.innerHTML = orders.map(order => `
        <div class="order-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 8px; background: #fff;">
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px;">
                <span><strong>Mã đơn: ${order.id}</strong></span>
                <span style="color: #666;">${order.date}</span>
            </div>
            
            <div class="order-items">
                ${order.items.map(item => `
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <img src="${item.img}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 15px; border-radius: 4px;">
                        <div style="flex: 1;">
                            <div style="font-weight: 500;">${item.name}</div>
                            <div style="font-size: 0.9rem; color: #666;">SL: ${item.quantity}</div>
                        </div>
                        <div style="color: #28a745;">${(item.price * item.quantity).toLocaleString()}đ</div>
                    </div>
                `).join('')}
            </div>

            <div style="text-align: right; border-top: 1px solid #eee; pt-10px; margin-top: 10px; padding-top: 10px;">
                <span style="font-size: 1.1rem;">Tổng tiền: <strong style="color: #e44d26;">${order.total.toLocaleString()}đ</strong></span>
            </div>
        </div>
    `).join('');
}