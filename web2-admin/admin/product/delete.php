<?php
require_once __DIR__ . "/../../config/db.php";

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM sanpham WHERE masp = $id");

header("Location: index.php");


