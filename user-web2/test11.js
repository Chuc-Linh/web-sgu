
/*==========TÌM KIẾM==========*/
document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.querySelector(".search-form");
    const searchInput = document.querySelector(".search-input");
    const productCards = document.querySelectorAll(".product-card");

    searchForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const keyword = searchInput.value.toLowerCase().trim();

        productCards.forEach(card => {
            const productName = card.querySelector("h3")
                ?.textContent.toLowerCase();

            if (productName && productName.includes(keyword)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
});