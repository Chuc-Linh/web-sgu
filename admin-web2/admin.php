<?php
session_start();
require_once 'db.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="css.php">
</head>
<body>

<div class="sidebar">
    <h2>ADMIN</h2>
    <a href="admin.php?page=category">Quản lý loại hàng</a>
    <a href="admin.php?page=product">Quản lý sản phẩm</a>
    <a href="admin.php?page=khachhang">Quản lý khách hàng</a>
    <a href="admin.php?page=hoadon">Quản lý hóa đơn</a>
    <a class="nav-link text-danger" href="logout.php"> Đăng xuất</a>
</div>

<div class="content">
<?php
$page = isset($_GET['page']) ? $_GET['page'] : '';

switch ($page) {
    case 'khachhang':
        include 'khachhang.php';
        break;

    case 'hoadon':
        include 'hoadon.php';
        break;

    case 'category':
        include 'category.php';
        break;

    case 'product':
        include 'product.php';
        break;

    default:
        if (isset($_SESSION['admin'])) {
            echo "<h1>Xin chào " . htmlspecialchars($_SESSION['admin']) . "</h1>";
        } else {
            echo "<h1>Xin chào Admin</h1>";
        }
        break;
}
?>
</div>

</body>
</html>

