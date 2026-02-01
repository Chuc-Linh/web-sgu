<?php
$current = basename($_SERVER['PHP_SELF']);
$path = $_SERVER['REQUEST_URI'];
?>

<div class="sidebar bg-dark text-white vh-100 p-3" style="width:240px;">
    <h4 class="text-center mb-4">WEB 2 ADMIN</h4>
    <hr class="text-secondary">

    <ul class="nav flex-column">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link text-white <?= strpos($path, '/admin/index.php') !== false ? 'active bg-primary' : '' ?>"
               href="/web2-admin/admin/index.php">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <!-- Category -->
        <li class="nav-item">
            <a class="nav-link text-white <?= strpos($path, '/category/') !== false ? 'active bg-primary' : '' ?>"
               href="/web2-admin/admin/category/index.php">
                <i class="bi bi-tags me-2"></i> Quản lý loại
            </a>
        </li>

        <!-- Product -->
        <li class="nav-item">
            <a class="nav-link text-white <?= strpos($path, '/product/') !== false ? 'active bg-primary' : '' ?>"
               href="/web2-admin/admin/product/index.php">
                <i class="bi bi-box-seam me-2"></i> Quản lý sản phẩm
            </a>
        </li>

        <hr class="text-secondary mt-3">

        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link text-danger" href="/web2-admin/admin/logout.php">
                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
            </a>
        </li>
    </ul>
</div>

