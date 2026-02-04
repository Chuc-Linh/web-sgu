document.addEventListener('DOMContentLoaded', () => {
    const userProfile = JSON.parse(localStorage.getItem('userProfile')) || {};
    const cart = JSON.parse(localStorage.getItem('ecoCart')) || [];
    
    // Hiển thị địa chỉ profile
    document.getElementById('profileAddressDisplay').innerText = userProfile.address || "Bạn chưa cập nhật địa chỉ trong hồ sơ.";

    // Tính tổng tiền tóm tắt
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('orderSummary').innerHTML = `<h3>Tổng cộng: ${total.toLocaleString()}đ</h3>`;

    // Ẩn hiện input địa chỉ mới
    document.querySelectorAll('input[name="addressOption"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            document.getElementById('newAddressInput').style.display = e.target.value === 'new' ? 'block' : 'none';
        });
    });

    // Hiện thông tin chuyển khoản
    document.getElementById('paymentMethod').addEventListener('change', function() {
        document.getElementById('transferInfo').style.display = this.value === 'transfer' ? 'block' : 'none';
    });
});

function confirmOrder() {
    const cart = JSON.parse(localStorage.getItem('ecoCart')) || [];
    const addressOption = document.querySelector('input[name="addressOption"]:checked').value;
    const payment = document.getElementById('paymentMethod').value;
    
    let finalAddress = "";
    if (addressOption === 'profile') {
        const userProfile = JSON.parse(localStorage.getItem('userProfile')) || {};
        finalAddress = userProfile.address;
        if (!finalAddress) return alert("Hồ sơ của bạn chưa có địa chỉ. Vui lòng chọn nhập địa chỉ mới.");
    } else {
        finalAddress = document.getElementById('newAddressInput').value;
        if (!finalAddress) return alert("Vui lòng nhập địa chỉ giao hàng.");
    }

    const order = {
        id: "ORD" + Date.now(),
        date: new Date().toLocaleString(),
        total: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0),
        address: finalAddress,
        payment: payment,
        items: cart
    };

    // Lưu vào lịch sử
    let history = JSON.parse(localStorage.getItem('orderHistory')) || [];
    history.unshift(order);
    localStorage.setItem('orderHistory', JSON.stringify(history));

    // Xóa giỏ hàng
    localStorage.removeItem('ecoCart');

    alert("Đặt hàng thành công! Mã đơn hàng: " + order.id);
    window.location.href = "account.html"; // Chuyển về trang tài khoản để xem lịch sử
}