function initCart() {
    const addButtons = document.querySelectorAll('.add-to-cart');

    addButtons.forEach(button => {
        // Gỡ bỏ sự kiện cũ để tránh bị lặp
        button.replaceWith(button.cloneNode(true));
    });

    const newButtons = document.querySelectorAll('.add-to-cart');
    newButtons.forEach(button => {
        button.addEventListener('click', () => {
            // --- BẮT ĐẦU KIỂM TRA ĐĂNG NHẬP ---
            const currentUser = JSON.parse(localStorage.getItem('currentUser'));

            if (!currentUser || !currentUser.isLoggedIn) {
                alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!");
                window.location.href = "login.html"; // Chuyển hướng đến trang đăng nhập
                return; // Dừng hàm, không thực hiện thêm hàng
            }
            // --- KẾT THÚC KIỂM TRA ĐĂNG NHẬP ---

            const name = button.getAttribute('data-name');
            const price = parseInt(button.getAttribute('data-price'));
            const img = button.getAttribute('data-img');

            let cart = JSON.parse(localStorage.getItem('ecoCart')) || [];
            const existingItem = cart.find(item => item.name === name);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    name: name,
                    price: price,
                    img: img,
                    quantity: 1
                });
            }

            localStorage.setItem('ecoCart', JSON.stringify(cart));
            alert(`Đã thêm "${name}" vào giỏ hàng!`);
        });
    });
}

document.addEventListener('DOMContentLoaded', initCart);