<?php
$conn = mysqli_connect(
    "localhost",
    "root",
    "123456",
    "web2",
    3307
);

mysqli_set_charset($conn, "utf8mb4");

if (!$conn) {
    die("Lỗi kết nối DB: " . mysqli_connect_error());
}
