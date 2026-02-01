<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: /web2-admin/admin/login.php");
    exit;
}
?>

<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background-color: #f4f6f9; }
        .sidebar {
            min-height: 100vh;
            background: #212529;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }
        .sidebar a:hover {
            background: #343a40;
            color: #fff;
        }
        .sidebar .active {
            background: #0d6efd;
            color: #fff;
        }
        .content {
            padding: 25px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-2 sidebar p-0">
            <h5 class="text-white text-center py-3 border-bottom">WEB 2 ADMIN</h5>


            <a href="/web2-admin/admin/category/index.php">
                <i class="bi bi-tags"></i> Quản lý loại sản phẩm 
            </a>

            <a href="/web2-admin/admin/product/index.php">
                <i class="bi bi-box-seam"></i> Quản lý sản phẩm
            </a>

            <a href="/web2-admin/admin/logout.php" class="text-danger mt-3">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </a>
        </div>

        <!-- CONTENT -->
        <div class="col-10 content">



