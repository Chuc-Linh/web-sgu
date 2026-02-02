<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location:login.php");
    exit;
}
require_once 'db.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM sanpham WHERE masp = $id");

header("Location: admin.php?page=product");


