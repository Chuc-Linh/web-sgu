// Dữ liệu sản phẩm tổng hợp từ source của bạn
const allProducts = [
    { name: "Ô Ăn Quan", price: "100.000đ", rawPrice: 100000, img: "oan.webp" },
    { name: "Mất Màu", price: "450.000đ", rawPrice: 450000, img: "balo.jpg" },
    { name: "Đồ Ngọt", price: "1.550.000đ", rawPrice: 1550000, img: "balobat (1).jpg" },
    { name: "Hồng Hạc", price: "650.000đ", rawPrice: 650000, img: "deo (2).jpg" },
    { name: "Em Xinh", price: "250.000đ", rawPrice: 250000, img: "balo1.jpg" },
    { name: "Thế Giới", price: "550.000đ", rawPrice: 550000, img: "balo3.jpg" },
    { name: "Chia Đất", price: "550.000đ", rawPrice: 550000, img: "balo5.jpg" },
    { name: "Báo Hồng", price: "1.850.000đ", rawPrice: 1850000, img: "balobat (4).jpg" },
    { name: "Tia Cực Tím", price: "1.550.000đ", rawPrice: 1550000, img: "balobat (7).jpg" },
    { name: "Trơn Tru Trắng", price: "2.550.000đ", rawPrice: 2550000, img: "balobat (10).jpg" },
    { name: "Bày Mẹo Tốt", price: "450.000đ", rawPrice: 450000, img: "balotote (6).jpg" },
    { name: "Thìn King", price: "450.000đ", rawPrice: 450000, img: "balotote (4).jpg" },
    { name: "Chợ Phiên", price: "650.000đ", rawPrice: 650000, img: "balotote (9).jpg" },
    { name: "Tốt Dần", price: "450.000đ", rawPrice: 450000, img: "balotote (11).jpg" },
    { name: "Đông Xuân", price: "750.000đ", rawPrice: 750000, img: "deo (6).jpg" },
    { name: "Cà Phê", price: "750.000đ", rawPrice: 750000, img: "deo (9).jpg" },
    { name: "Âm Nhạc", price: "750.000đ", rawPrice: 750000, img: "deo (11).jpg" },
    { name: "Kéo Búa Bao", price: "100.000đ", rawPrice: 100000, img: "keobua.png" },
    { name: "Lúa Nước Việt Nam", price: "100.000đ", rawPrice: 100000, img: "luanuoc.webp" },
    { name: "Đen thui", price: "100.000đ", rawPrice: 100000, img: "den.jpg" }
];

const itemsPerPage = 8; // Số sản phẩm mỗi trang
let currentPage = 1;

function renderProducts(page) {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedItems = allProducts.slice(start, end);

    const container = document.getElementById('product-container');
    container.innerHTML = paginatedItems.map(p => `
        <div class="product-card">
            <a href="product-detail.html">
                <div class="product-img" style="background-image: url('${p.img}');"></div>
            </a>
            <div class="product-info">
                <h3>${p.name}</h3>
                <p class="price">${p.price}</p>
                <button class="add-to-cart" 
                    data-name="${p.name}" 
                    data-price="${p.rawPrice}" 
                    data-img="${p.img}">Thêm vào giỏ</button>
            </div>
        </div>
    `).join('');
    
    renderPagination();
}

function renderPagination() {
    const totalPages = Math.ceil(allProducts.length / itemsPerPage);
    const controls = document.getElementById('pagination-controls');
    controls.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.innerText = i;
        btn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
        btn.onclick = () => {
            currentPage = i;
            renderProducts(i);
            window.scrollTo(0, 0); // Cuộn lên đầu trang khi chuyển trang
        };
        controls.appendChild(btn);
    }
}

// Chạy lần đầu
document.addEventListener('DOMContentLoaded', () => renderProducts(1));


