document.addEventListener('DOMContentLoaded', () => {
    const cartBody = document.getElementById('cartBody');
    const totalPriceElement = document.getElementById('totalPrice');
    
    function renderCart() {
        let cart = JSON.parse(localStorage.getItem('ecoCart')) || [];
        cartBody.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            cartBody.innerHTML = '<tr><td colspan="6">Giỏ hàng của bạn đang trống.</td></tr>';
            totalPriceElement.innerText = 'Tổng cộng: 0đ';
            return;
        }

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td><img src="${item.img}" alt="${item.name}" style="width: 50px; border-radius: 5px;"></td>
                <td>${item.name}</td>
                <td>
                    <button class="btn-qty" onclick="updateQuantity(${index}, -1)">-</button>
                    ${item.quantity}
                    <button class="btn-qty" onclick="updateQuantity(${index}, 1)">+</button>
                </td>
                <td>${item.price.toLocaleString()}đ</td>
                <td>${itemTotal.toLocaleString()}đ</td>
                <td><button class="btn-delete" onclick="removeItem(${index})">Xóa</button></td>
            `;
            cartBody.appendChild(row);
        });

        totalPriceElement.innerHTML = `<h3>Tổng cộng: ${total.toLocaleString()}đ</h3>`;
    }

    // Hàm thay đổi số lượng
    window.updateQuantity = (index, change) => {
        let cart = JSON.parse(localStorage.getItem('ecoCart'));
        cart[index].quantity += change;

        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }

        localStorage.setItem('ecoCart', JSON.stringify(cart));
        renderCart();
    };

    // Hàm xóa sản phẩm
    window.removeItem = (index) => {
        let cart = JSON.parse(localStorage.getItem('ecoCart'));
        cart.splice(index, 1);
        localStorage.setItem('ecoCart', JSON.stringify(cart));
        renderCart();
    };

    renderCart();
    // Xử lý ẩn hiện địa chỉ mới
    const addressRadios = document.querySelectorAll('input[name="addressOption"]');
    const newAddressInput = document.getElementById('newAddressInput');
    const profileAddressDisplay = document.getElementById('profileAddressDisplay');

    // Lấy địa chỉ từ profile
    const userProfile = JSON.parse(localStorage.getItem('userProfile')) || {};
    profileAddressDisplay.innerText = userProfile.address || "Chưa có địa chỉ trong hồ sơ";

    addressRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            newAddressInput.style.display = e.target.value === 'new' ? 'block' : 'none';
        });
    });

    // Xử lý hiển thị thông tin chuyển khoản
    document.getElementById('paymentMethod').addEventListener('change', function() {
        document.getElementById('transferInfo').style.display = this.value === 'transfer' ? 'block' : 'none';
    });
});

window.processOrder = () => {
    let cart = JSON.parse(localStorage.getItem('ecoCart')) || [];
    if (cart.length === 0) return alert("Giỏ hàng trống!");

    const method = document.getElementById('paymentMethod').value;
    const addressOption = document.querySelector('input[name="addressOption"]:checked').value;
    const finalAddress = addressOption === 'profile' 
        ? (JSON.parse(localStorage.getItem('userProfile'))?.address || "Địa chỉ mặc định")
        : document.getElementById('newAddressInput').value;

    if (addressOption === 'new' && !finalAddress) return alert("Vui lòng nhập địa chỉ!");

    // Tính tổng tiền
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    // Tạo đơn hàng
    const order = {
        id: Date.now(),
        date: new Date().toLocaleString(),
        items: cart,
        total: total,
        address: finalAddress,
        payment: method
    };

    // Lưu vào lịch sử đơn hàng
    let orderHistory = JSON.parse(localStorage.getItem('orderHistory')) || [];
    orderHistory.unshift(order); // Đưa đơn hàng mới nhất lên đầu
    localStorage.setItem('orderHistory', JSON.stringify(orderHistory));

    // Hiển thị tóm tắt
    showSummary(order);

    // Xóa giỏ hàng sau khi đặt thành công
    localStorage.removeItem('ecoCart');
    // renderCart(); // Cập nhật lại giao diện (cần gọi từ closure hoặc định nghĩa lại)
};

function showSummary(order) {
    const modal = document.getElementById('orderSummaryModal');
    const content = document.getElementById('summaryContent');
    content.innerHTML = `
        <p><strong>Mã đơn hàng:</strong> ${order.id}</p>
        <p><strong>Ngày đặt:</strong> ${order.date}</p>
        <p><strong>Địa chỉ:</strong> ${order.address}</p>
        <p><strong>Thanh toán:</strong> ${order.payment}</p>
        <hr>
        <p><strong>Tổng cộng:</strong> ${order.total.toLocaleString()}đ</p>
    `;
    modal.style.display = 'block';
}

window.closeSummary = () => {
    document.getElementById('orderSummaryModal').style.display = 'none';
    window.location.reload();
};

window.goToCheckout = () => {
    let cart = JSON.parse(localStorage.getItem('ecoCart')) || [];
    if (cart.length === 0) {
        alert("Giỏ hàng của bạn đang trống!");
        return;
    }
    window.location.href = "checkout.html";
};