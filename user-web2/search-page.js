// // search-page.js

// // Lấy tham số ban đầu từ URL
// const params = new URLSearchParams(window.location.search);
// const initialKeyword = params.get("keyword") || "";

// // Gán giá trị ban đầu vào ô nhập liệu trong trang search
// document.getElementById("advKeyword").value = initialKeyword;
// document.getElementById("keyword-text").textContent = initialKeyword || "Tất cả";

// // Hàm thực hiện lọc
// function performSearch() {
//     const keyword = document.getElementById("advKeyword").value.toLowerCase();
//     const category = document.getElementById("advCategory").value;
    
//     // Lấy giá trị từ input
//     const minInput = document.getElementById("advMinPrice").value;
//     const maxInput = document.getElementById("advMaxPrice").value;

//     // Chuyển đổi sang số
//     let minPrice = parseInt(minInput) || 0;
//     // Nếu ô nhập trống thì là Infinity, nếu có nhập (kể cả số 0) thì lấy đúng giá trị đó
//     let maxPrice = (maxInput === "" || maxInput === null) ? Infinity : parseInt(maxInput);

//     // 1. Kiểm tra nếu giá trị nhập vào là số âm
//     if (minPrice < 0) {
//         alert("Giá tối thiểu không được nhỏ hơn 0");
//         document.getElementById("advMinPrice").value = 0;
//         return;
//     }

//     // 2. CẢNH BÁO: Nếu giá tối thiểu lớn hơn giá tối đa (bao gồm trường hợp giá tối đa = 0)
//     if (minPrice > maxPrice) {
//         alert("Giá tối thiểu không thể lớn hơn giá tối đa! ");
//         return; 
//     }

//     // --- Tiếp tục logic fetch và lọc dữ liệu bên dưới ---
//     document.getElementById("keyword-text").textContent = keyword || "Tất cả";
   
//     fetch("all-products.html")
//         .then(res => res.text())
//         .then(html => {
//             const parser = new DOMParser();
//             const doc = parser.parseFromString(html, "text/html");
//             const productCards = doc.querySelectorAll(".product-card");
//             const resultList = document.getElementById("result-list");
            
//             resultList.innerHTML = "";
//             let count = 0;

//             productCards.forEach(card => {
//                 const name = card.querySelector("h3")?.textContent.toLowerCase() || "";
//                 const priceText = card.querySelector(".price")?.textContent.replace(/\D/g, "") || "0";
//                 const price = parseInt(priceText);

//                 const matchKeyword = name.includes(keyword);
//                 const matchPrice = price >= minPrice && price <= maxPrice;
                
//                 // Kiểm tra phân loại sản phẩm
//                 let matchCategory = true;
//                 if (category !== "") {
//                     const grid = card.closest('.product-grid');
//                     let categoryTitle = grid.previousElementSibling;
//                     while (categoryTitle && categoryTitle.tagName !== "H2") {
//                         categoryTitle = categoryTitle.previousElementSibling;
//                     }
//                     matchCategory = categoryTitle && (categoryTitle.classList.contains(category) || categoryTitle.id === category);
//                 }

//                 if (matchKeyword && matchPrice && matchCategory) {
//                     const clone = card.cloneNode(true);
//                     resultList.appendChild(clone);
//                     count++;
//                 }
//             });

//             if (count === 0) {
//                 resultList.innerHTML = "<p>Không tìm thấy sản phẩm phù hợp.</p>";
//             } else if (typeof initCart === "function") {
//                 initCart(); // Gắn lại sự kiện giỏ hàng sau khi lọc
//             }
//         });
// }

// // Chạy tìm kiếm lần đầu khi trang vừa load
// document.addEventListener('DOMContentLoaded', performSearch);

// // Gán sự kiện cho nút Lọc
// document.getElementById("btnFilter").addEventListener("click", performSearch);


// search-page.js

// 1. Dữ liệu gốc (Đảm bảo trùng khớp với pagination.js)
const allProducts = [
    { name: "Ô Ăn Quan", price: "100.000đ", rawPrice: 100000, img: "oan.webp", category: "tat" },
    { name: "Mất Màu", price: "450.000đ", rawPrice: 450000, img: "balo.jpg", category: "balojean" },
    { name: "Đồ Ngọt", price: "1.550.000đ", rawPrice: 1550000, img: "balobat (1).jpg", category: "balobat" },
    { name: "Hồng Hạc", price: "650.000đ", rawPrice: 650000, img: "deo (2).jpg", category: "deo" },
    { name: "Em Xinh", price: "250.000đ", rawPrice: 250000, img: "balo1.jpg", category: "balojean" },
    { name: "Thế Giới", price: "550.000đ", rawPrice: 550000, img: "balo3.jpg", category: "balojean" },
    { name: "Chia Đất", price: "550.000đ", rawPrice: 550000, img: "balo5.jpg", category: "balojean" },
    { name: "Báo Hồng", price: "1.850.000đ", rawPrice: 1850000, img: "balobat (4).jpg", category: "balobat" },
    { name: "Tia Cực Tím", price: "1.550.000đ", rawPrice: 1550000, img: "balobat (7).jpg", category: "balobat" },
    { name: "Trơn Tru Trắng", price: "2.550.000đ", rawPrice: 2550000, img: "balobat (10).jpg", category: "balobat" },
    { name: "Bày Mẹo Tốt", price: "450.000đ", rawPrice: 450000, img: "balotote (6).jpg", category: "balotote" },
    { name: "Thìn King", price: "450.000đ", rawPrice: 450000, img: "balotote (4).jpg", category: "balotote" },
    { name: "Chợ Phiên", price: "650.000đ", rawPrice: 650000, img: "balotote (9).jpg", category: "balotote" },
    { name: "Tốt Dần", price: "450.000đ", rawPrice: 450000, img: "balotote (11).jpg", category: "balotote" },
    { name: "Đông Xuân", price: "750.000đ", rawPrice: 750000, img: "deo (6).jpg", category: "deo" },
    { name: "Cà Phê", price: "750.000đ", rawPrice: 750000, img: "deo (9).jpg", category: "deo" },
    { name: "Âm Nhạc", price: "750.000đ", rawPrice: 750000, img: "deo (11).jpg", category: "deo" },
    { name: "Kéo Búa Bao", price: "100.000đ", rawPrice: 100000, img: "keobua.png", category: "tat" },
    { name: "Lúa Nước Việt Nam", price: "100.000đ", rawPrice: 100000, img: "luanuoc.webp", category: "tat" },
    { name: "Đen thui", price: "100.000đ", rawPrice: 100000, img: "den.jpg", category: "tat" }
];

// 2. Xử lý tham số URL
const params = new URLSearchParams(window.location.search);
const initialKeyword = params.get("keyword") || "";
document.getElementById("advKeyword").value = initialKeyword;

// 3. Hàm thực hiện lọc chính
function performSearch() {
    const keyword = document.getElementById("advKeyword").value.toLowerCase().trim();
    const category = document.getElementById("advCategory").value;

    // 1. Lấy giá trị thô từ ô input (chuỗi)
    const minInput = document.getElementById("advMinPrice").value;
    const maxInput = document.getElementById("advMaxPrice").value;

    // 2. Chuyển đổi: Nếu trống thì min = 0, max = vô cực. Nếu có nhập thì lấy số đó.
    const minPrice = minInput === "" ? 0 : parseInt(minInput);
    const maxPrice = maxInput === "" ? Infinity : parseInt(maxInput);

    // 3. Kiểm tra logic: Nếu cả hai ô đều có giá trị và Min > Max
    // Hoặc trường hợp Min > 0 mà Max lại nhập là 0
    if (minInput !== "" && maxInput !== "" && minPrice > maxPrice) {
        alert("Giá tối thiểu không thể lớn hơn giá tối đa!");
        return;
    }

    // Cập nhật text hiển thị từ khóa
    const keywordText = document.getElementById("keyword-text");
    if (keywordText) keywordText.textContent = keyword || "Tất cả";

    // 4. Thực hiện lọc trên mảng allProducts
    const filtered = allProducts.filter(product => {
        const matchKeyword = product.name.toLowerCase().includes(keyword);
        const matchPrice = product.rawPrice >= minPrice && product.rawPrice <= maxPrice;
        const matchCategory = category === "" || product.category === category;
        return matchKeyword && matchPrice && matchCategory;
    });

    renderResults(filtered);
}
// 4. Hàm hiển thị kết quả ra giao diện
function renderResults(products) {
    const resultList = document.getElementById("result-list");
    resultList.innerHTML = "";

    if (products.length === 0) {
        resultList.innerHTML = "<p>Không tìm thấy sản phẩm phù hợp.</p>";
        return;
    }

    products.forEach(p => {
        const card = document.createElement("div");
        card.className = "product-card";
        card.innerHTML = `
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
        `;
        resultList.appendChild(card);
    });

    // Kích hoạt lại sự kiện giỏ hàng (nếu có cart.js)
    if (typeof initCart === "function") initCart();
}

// Khởi chạy khi trang load
document.addEventListener('DOMContentLoaded', performSearch);
document.getElementById("btnFilter").addEventListener("click", performSearch);